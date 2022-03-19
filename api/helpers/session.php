<?php 

function _gen_private_key(){
    return hash('sha512', _salt()._user()->id().mt_rand(0,1000).date('d-m-Y_h:i:s')."_private_");
}

function _gen_session(int $id_user){
    
    $new_session = hash('sha256', _salt().$id_user.mt_rand(0,1000).date('d-m-Y_h:i:s')."_session_");
    
    $hoje = new DateTime();
    $hoje->modify('+1 day');
    $expire = $hoje->format('Y-m-d H:i:s');
    
    $status = _exec("INSERT INTO user_sessions (session, user_id, expire) VALUES ('$new_session', $id_user, '$expire')");
    
    return $status ? [$new_session, $expire] : false;
}