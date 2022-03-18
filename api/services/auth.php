<?php 

// $passEnc = password_hash($pass, PASSWORD_DEFAULT);

function _is_public(){
    return false;    
}

function _is_authentic(){
    return in_array(_user()->level(), ['admin','app', 'client']);
}

function login($pass, $email){
    
    $checPas = password_verify($pass, $passEnc);
    return _response([$pass]);

}

function test(){
    return _response(_user()->to_array());
}

function forgot(){
    
}