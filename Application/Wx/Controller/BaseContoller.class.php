<?php

/*
 */

namespace Wx\Controller;

use Think\Controller;
use EasyWeChat\Foundation\Application;

/**
 * Description of BaseContoller
 *
 * @author liang
 */
class BaseContoller extends Controller {
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->app = new Application(C('wx_options'));
        $this->oauth = $this->app->oauth;

        $this_uri = getUrl();
        /**
         * 在微信里面 wechat_user数据不存在  
         */
        if (is_weixin() and empty($_SESSION['wechat_user'])) {
            if (empty($_GET['code']) and empty($_GET['state'])) {
                // 未登录
                $_SESSION['target_url'] = getUrl();
                $this->oauth->redirect()->send();
            }
        }


    }
    public function wxtest(){
    $conf=C('wxopt');
    Vendor('wx.wechat');
    $wx=new \Wechat($conf);
    $ti=$wx->getJsTicket();
		$js_sign = $wx->getJsSign ( $_SERVER['SERVER_NAME'] );
    return $js_sign;
  }


}
