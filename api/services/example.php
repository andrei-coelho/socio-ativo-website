<?php 

use libs\app\User as user;

function _is_public(){
    return false;    
}

function _is_authentic(){
    return in_array(_user()->level(), ['admin']);
}

function test(){
    return _response(["teste"=>"1"]);
}