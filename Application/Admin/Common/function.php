<?php
function is_login(){
    return isLogin();
}
function isLogin(){
    return (bool)getLoginData();
}
function setLoginData($data){
    session('admin_login_data', $data);
    return true;
}
function getLoginData(){
    return session('admin_login_data');
}
function Loginout(){
  session_unset();
  return true;
}