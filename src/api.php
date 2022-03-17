<?php 

include "../api/autoload.php";

use libs\app\Config as Config;
use libs\app\User as user;

if(!$request->vars['file'] || !$request->vars['func']){
    echo "erro 0"; // criar response error - BAD REQUEST
    exit;
}

$file =  "../api/services/".$request->vars['file'].".php";

if(!file_exists($file)){ 
    echo "erro 1"; // criar response error - 404 - A
    exit;
}

include $file;

if(!_is_public()){
    
    if(!$request->vars['key']){
        echo "erro 2"; // criar response error - UNAUTORIZED A
        exit;
    }
    
    $user = new user($request->vars['key']);
    
    if(!_is_authentic($user)){
        echo "erro 3"; // criar response error - UNAUTORIZED B
        exit;
    }

}

$func = $request->vars['func'];

if(!function_exists($func) || $func == '_is_autentic' || $func == '_is_public'){
    echo "erro 4"; // criar response error 404 - B
    exit;
}

$func();

