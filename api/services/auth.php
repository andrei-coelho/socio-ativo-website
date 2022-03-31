<?php 

// $passEnc = password_hash($pass, PASSWORD_DEFAULT);

function _is_public(){
    return true;    
}

function _is_authentic(){
    return in_array(_user()->level(), ['admin', 'app', 'client']);
}

function login($pass, $email){
    
    $selUser = _query(
        "SELECT 
		    users.nome, users.id, users.email, users.senha, user_types.slug as level
        FROM users JOIN user_types ON user_types.id = users.user_type
        WHERE users.email = '$email';
    ");
    
    if(!$selUser) _error(404, 'Usuário não existe');
    $user = $selUser->fetchAssoc();
    
    $status = password_verify($pass, $user['senha']);
    
    if($status){
        $sess = _gen_session($user['id']);
        if(!$sess) _error(500, 'Falha no servidor ao tentar gerar uma sessão');
    }
    unset($user['senha']);
    return $status ? _response($user, $sess[0]) : _error(404, 'Senha errada');

}

function test(){
    return _response(_user()->to_array());
}

function forgot(){
    
}