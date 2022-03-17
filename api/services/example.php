<?php 

use libs\app\User as user;
use src\Request as request;

function _is_public(){
    return true;    
}

function _is_authentic(user $user){
    return in_array($user->level, ['admin']);
}

function test(){
    print_r(request::raw());
}