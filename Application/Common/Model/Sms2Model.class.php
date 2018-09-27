<?php

/*
 * 发送短信的类(阿里云短信服务)
 */

namespace Common\Model;

include_once THINK_PATH . 'Library/Vendor/dysmsapi_demo_sdk__php/php/api_sdk/aliyun-php-sdk-core/Config.php';
include_once THINK_PATH . 'Library/Vendor/dysmsapi_demo_sdk__php/php/api_sdk/Dysmsapi/Request/V20170525/SendSmsRequest.php';
include_once THINK_PATH . 'Library/Vendor/dysmsapi_demo_sdk__php/php/api_sdk/Dysmsapi/Request/V20170525/QuerySendDetailsRequest.php';

/**
 * 发送短信的类
 *
 * @author liang
 */
class Sms2Model {

    private $request;
    private $acsClient;

    //put your code here
    public function __construct() {
        $accessKeyId = C('SMS.accessKeyId'); //参考本文档步骤2
        $accessKeySecret = C('SMS.accessKeySecret'); //参考本文档步骤2
        //短信API产品名
        $product = C('SMS.product');
        //短信API产品域名
        $domain = C('SMS.domain');
        //暂时不支持多Region
        $region = C('SMS.region');
        //初始化访问的acsCleint
        $profile = \DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
        \DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $product, $domain);
        $this->acsClient = new \DefaultAcsClient($profile);
        $this->request = new \Dysmsapi\Request\V20170525\SendSmsRequest;
    }

    /**
     * 发送短信验证码
     * @param type $vcode
     * @param type $mobile
     * @return boolean
     */
    public function send_vcode($vcode, $mobile) {
        $params = [
            'code' => strval($vcode),
        ];
        $params = json_encode($params);
        //必填-短信接收号码。支持以逗号分隔的形式进行批量调用，批量上限为20个手机号码,批量调用相对于单条调用及时性稍有延迟,验证码类型的短信推荐使用单条调用的方式
        $this->request->setPhoneNumbers($mobile);
        //必填-短信签名
        $this->request->setSignName(C('SMS.SignName'));
        //必填-短信模板Code
        $this->request->setTemplateCode(C('SMS.TemplateCode'));
        //选填-假如模板中存在变量需要替换则为必填(JSON格式)

        $this->request->setTemplateParam($params);
        //选填-发送短信流水号
//        $this->request->setOutId("1234");
        //发起访问请求
        $acsResponse = $this->acsClient->getAcsResponse($this->request);
        $resp_arr = objectToArray($acsResponse);
//        print_r($resp_arr);
        if (isset($resp_arr['Code']) and 'OK' == $resp_arr['Code']) {
            return TRUE;
        }

        return FALSE;
    }

}
