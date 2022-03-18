<?php 

header('Content-Type: application/json; charset=utf-8');

include "../api/autoload.php";
include "../api/source/response.php";
include "../api/source/sqli.php";
include "../api/source/user.php";
include "../api/source/session.php";

use libs\app\Config as Config;
use libs\app\Route as Route;
use libs\app\User as user;
use src\Request as request;

if(!$request->vars['route'] || !$request->vars['func']){
    _error(400, 'Bad Request A');
    exit;
}

include "../api/routes.php";
$file = Route::get_file($request->vars['route']);

if(!$file || !file_exists($file)){ 
    _error(404, 'Not Found - A');
    exit;
}

include $file;

if(!_is_public()){
    
    if((!$request->vars['session'] || $request->vars['session'] == 'null') && !$request->vars['secret']){
        _error(401, 'Unauthorized - A'); 
        exit;
    }
    
    $user = $request->vars['secret'] ? 
    user::generate_by_secret($request->vars['secret']) :
    user::generate_by_session($request->vars['session']) ;
    
    if(!$user || !_is_authentic()){
        _error(401, 'Unauthorized - B');
        exit;
    }

}

$func = $request->vars['func'];

if(!function_exists($func) || $func == '_is_autentic' || $func == '_is_public'){
    _error(404, 'Not Found - B'); 
    exit;
}

$refFunction = new ReflectionFunction($func);
$parameters = $refFunction->getParameters();
$vars = request::raw();

$validParameters = [];

foreach ($parameters as $parameter) {
    
    $exists = array_key_exists($parameter->getName(), $vars);
    
    if (!$exists && !$parameter->isOptional()) {
        _error(400, 'Bad Request B');
        exit;
    }

    if(!$exists) continue;
    $validParameters[$parameter->getName()] = $vars[$parameter->getName()];
}

$resp = $refFunction->invoke(...$validParameters);
if(!$resp) $resp = _response([]);

echo $resp->response();

