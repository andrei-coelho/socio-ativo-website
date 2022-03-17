<?php 

include "../api/autoload.php";
include "../api/source/response.php";

use libs\app\Config as Config;
use libs\app\User as user;
use libs\app\Route as Route;

if(!$request->vars['route'] || !$request->vars['func']){
    _error(400, 'Bad Request');
    exit;
}

include "../api/source/routes.php";
$file = Route::get_file($request->vars['route']);

if(!$file || !file_exists($file)){ 
    _error(404, 'Not Found - A');
    exit;
}

include $file;

if(!_is_public()){
    
    if(!$request->vars['key']){
        _error(401, 'Unauthorized - A'); 
        exit;
    }
    
    $user = new user($request->vars['key']);
    
    if(!_is_authentic($user)){
        _error(401, 'Unauthorized - B');
        exit;
    }

}

$func = $request->vars['func'];

if(!function_exists($func) || $func == '_is_autentic' || $func == '_is_public'){
    _error(404, 'Not Found - B'); 
    exit;
}

$func();

