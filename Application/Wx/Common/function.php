<?php
function isLogin(){
    return (bool)getLoginData();
}
function setLoginData($data){
    session('user_login_data', $data);
    return true;
}
function getLoginData(){
    return session('user_login_data');
}
function getUserId(){
    $loginData = getLoginData();
    return $loginData['user_id'];
}
function checkLogin(){
    if(!isLogin()){
        $thisUrl = getUrl();
        $link = U('Account/login', ['redirect' => urlencode($thisUrl)], true, true);
        redirect($link);
    }
}