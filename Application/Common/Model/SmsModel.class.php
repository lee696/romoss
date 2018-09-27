<?php

/*
 * 发送短信的类
 */

namespace Common\Model;

//import("@.ORG.taobao-sdk-PHP.TopSdk");
include THINK_PATH . 'Library/Org/taobao-sdk-PHP/TopSdk.php';

/**
 * 发送短信的类
 *
 * @author liang
 */
class SmsModel {

    private $topclient;
    private $req;

    //put your code here
    public function __construct() {

        
        
        $this->topclient = new \TopClient;
        $this->topclient->appkey = C('SMS.appkey');
        $this->topclient->secretKey = C('SMS.secretKey');
        $this->topclient->format = 'json';
        $this->req = new \AlibabaAliqinFcSmsNumSendRequest;
        $this->req->setSmsType(C('SMS.sms_type'));
        $this->req->setSmsFreeSignName(C('SMS.sms_free_sign_name'));
    }

    /**
     * 发送短信验证码
     * @param type $vcode
     * @param type $mobile
     * @return boolean
     */
    public function send_vcode($vcode, $mobile) {
        $params = [
            'number' => strval($vcode),
        ];
        $params = json_encode($params);
        $this->req->setSmsParam($params);
        $this->req->setRecNum($mobile);
        $this->req->setSmsTemplateCode(C('SMS.sms_template_code_vcode'));
        $resp = $this->topclient->execute($this->req);
        $resp_arr = objectToArray($resp);
        if (isset($resp_arr['result']['success']) and $resp_arr['result']['success']) {
            return TRUE;
        }

        return FALSE;
    }

}
