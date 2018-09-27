<?php

// error: 1 ：成功，  error : 2失败
function sendResult($errorMsg = null, $errorType = 1){
	header('Content-Type:application/json; charset=utf-8');
    $result = formatResult($errorMsg, $errorType);
    exit(json_encode($result,JSON_UNESCAPED_UNICODE));
}
function formatResult($errorMsg, $errorType){
    $errorLangBox = L('ERROR_CODE');
    $version = getApiVersion();
    if(!isset($errorLangBox[$version])){
        exit(404);
    }else{
        $errorLang = $errorLangBox[$version];
    }
    switch ($errorType){
        case 1:
            $error_code = $errorLang['success'];
            $error_data = $errorMsg;
            break;
        case 2:
            if(isset($errorLang[$errorMsg])){
                $error_code = $errorLang[$errorMsg];
            }else{
                $error_code = $errorLang['default'];
            }
            $error_msg = $errorMsg;
            break;
        default:
            exit(404);
    }
    $result = [];
    switch ($version){
        case '1.0':
            $result['status'] = $error_code;
            if(isset($error_msg)){
                $result['msg'] = $error_msg;
            }
            if(isset($error_data)){
                $result['data'] = $error_data;
            }
            break;
        default:
            exit(404);
    }
    return $result;
}
function getApiVersion(){
    $version = I('version', '1.0', 'trim');
    return $version;
}
function sendError($error){
    sendResult(L($error), 2);
}
function createPassword($password){
    return md5(C('DATA_AUTH_KEY').$password);
}
function setCodeCache($phone, $code, $expire = 900){
    S('valid_code_'.$phone, $code, $expire);
}
function delCodeCache($phone){
    S('valid_code_'.$phone, null);
}
// 格式校验
function is_email($email){
    return strlen($email) > 6 && preg_match("/^[w-.]+@[w-]+(.w+)+$/", $email);
}
function is_mobile($str){
    return preg_match("/^(((d{3}))|(d{3}-))?13d{9}$/", $str);
}
function is_url($str){
    return preg_match("/^http://[A-Za-z0-9]+.[A-Za-z0-9]+[/=?%-&_~`@[]':+!]*([^<>\"])*$/
", $str);
}
function isImei($imei) {
    if(preg_match('/^(\d{15}|\d{17})$/', $imei)){
        return true;
    }else{
        return false;
    }
}
function isPhone($str){
    $pattern = "/^1[34578]\d{9}$/";     //手机号码
    if(preg_match_all($pattern,$str)){
        return true;
    }else{
        return false;
    }
}
function isTel($str){
    $v = false;
    $pattern = "/^(\d{3,4}\-)?\d{7,8}$/i";     //带横线 电话号码
    if(preg_match_all($pattern,$str)){
        $v = true;
    }
    $pattern = "/^0(([1-9]\d)|([3-9]\d{2}))\d{8}$/";
    if(preg_match_all($pattern,$str)){
        $v = true;
    }
    return $v;
}
function isTelORphone($str){
    if(isTel($str) || isPhone($str)){
        return true;
    }else{
        return false;
    }
}
function isBank($bank_num) {
    if(preg_match('/^(\d{16}|\d{19})$/', $bank_num)){
        return true;
    }else{
        return false;
    }
}
function isWechat(){
    if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
        return true;
    }
    return false;
}

function base64ToImg($base64){
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64, $result)) {
        $type = $result[2];
        $ext = ['jpg', 'gif', 'png', 'jpeg'];
        if(!in_array($type, $ext)){
            return false;
        }
        $new_file = '/static/upload/image/return/'.time().rand(100000, 999999).'.'.$type;
        if (file_put_contents('.'.$new_file, base64_decode(str_replace($result[1], '', $base64)))) {
            return $new_file;
        } else {
            return false;
        }
    }else{
        return false;
    }
}
function formatTime($time){
    return date('Y-m-d H:i:s', $time);
}

function objectToArray($obj)
{
    $arr = is_object($obj) ? get_object_vars($obj) : $obj;
    if (is_array($arr)) {
        return array_map(__FUNCTION__, $arr);
    } else {
        return $arr;
    }
}

/**
 * 判断是否是微信客户端
 * @return boolean
 */
function is_weixin()
{
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
        return TRUE;
    }
    return FALSE;
}
function domain(){
    $domain = $_SERVER['HTTP_HOST'];
    $domain   =  (is_ssl()?'https://':'http://').$domain;
    return $domain;
}
function getUrl(){
    return domain().$_SERVER["REQUEST_URI"];
}