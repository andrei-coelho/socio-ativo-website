<?php 

use libs\app\User as user;

function _is_public(){
    return true;    
}

function _is_authentic(user $user){
    return in_array($user->level, ['admin', 'client', 'app']);
}

function test(){
    echo date('Y-m-d H:i.s').".000000";
}