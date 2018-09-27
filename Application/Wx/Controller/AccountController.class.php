<?php

namespace Wx\Controller;

use Think\Controller;

class AccountController extends BaseContoller {

    public function login() {
        $redirect = I('redirect', '', 'urldecode');
        $this->assign('redirect', $redirect);
        $this->display();
    }

    public function plogin() {
        $redirect = I('redirect', '', 'urldecode');
        $this->assign('redirect', $redirect);
        $this->display();
    }

    public function reg() {
        $redirect = I('redirect', '', 'urldecode');
        $this->assign('redirect', $redirect);
        $this->display();
    }

    public function sendLoginCode() {
        $phone = I('phone', '', 'trim');
        if (!isPhone($phone)) {
            sendError('ERROR_PARAM');
        }
//        if (!D('Common/User')->accountExists($phone)) {
//            sendError('ERROR_NO_ACCOUNT');
//        }
        $prefix = 'login';
        if ($this->setCode($prefix, $phone)) {
            sendResult();
        } else {
            sendError('ERROR_NET');
        }
    }

    public function sendRegisterCode() {
        $phone = I('phone', '', 'trim');
        if (!isPhone($phone)) {
            sendError('ERROR_PARAM');
        }
        if (D('Common/User')->accountExists($phone)) {
            sendError('ERROR_ACCOUNT_EXISTS');
        }
        $prefix = 'register';
        if ($this->setCode($prefix, $phone)) {
            sendResult();
        } else {
            sendError('ERROR_NET');
        }
    }

    public function pwdLogin() {
        $phone = I('phone', '', 'trim');
        $pwd = I('pwd', '', 'trim');
        if (!isPhone($phone) || !$pwd) {
            sendError('ERROR_PARAM');
        }
        $userInfo = D('Common/User')->checkLogin($phone, $pwd);
        if (!$userInfo) {
            sendError('ERROR_ACCOUNT_PWD');
        } else {
            setLoginData($userInfo);
            sendResult();
        }
    }

    public function phoneLogin() {
        $phone = I('phone', '', 'trim');
        $code = I('code', '', 'trim');
        if (!isPhone($phone) || !$code) {
            sendError('ERROR_PARAM');
        }

        if (!$this->checkCode('login', $phone, $code)) {
            sendError('ERROR_VALID_CODE');
        }

        $userInfo = D('Common/User')->accountExists($phone);

        if (!$userInfo) {
          $user_id = D('Common/User')->insert($phone, 'YXS0');
            if ($user_id) {
                $info = D('Common/User')->getInfo($user_id);
                setLoginData($info);
                sendResult();
            } else {
                sendError('ERROR_NET');
            }
//            sendError('ERROR_NO_ACCOUNT');
        } else {
            setLoginData($userInfo);
            sendResult();
        }
    }
    public function loginout(){
      session('user_login_data', '');
      $url=U('Account/login');
      echo "<script> ;window.location.href='$url'</script>";
//      $this->success('退出成功', U('Account/login'));
    }

    public function register() {
        $phone = I('phone', '', 'trim');
        $code = I('code', '', 'trim');
        $pwd = I('pwd', '', 'trim');
        if (!isPhone($phone) || !$code || !$pwd) {
            sendError('ERROR_PARAM');
        }
        if (!$this->checkCode('register', $phone, $code)) {
            sendError('ERROR_VALID_CODE');
        } elseif (D('Common/User')->accountExists($phone)) {
            sendError('ERROR_ACCOUNT_EXISTS');
        } else {
            $user_id = D('Common/User')->insert($phone, $pwd);
            if ($user_id) {
                $info = D('Common/User')->getInfo($user_id);
                setLoginData($info);
                sendResult();
            } else {
                sendError('ERROR_NET');
            }
        }
    }

    public function callback() {

        // 获取 OAuth 授权结果用户信息
        $user = $this->oauth->user();
        $_SESSION['wechat_user'] = $user->toArray();
        $targetUrl = empty($_SESSION['target_url']) ? '/' : $_SESSION['target_url'];
        header('location:' . $targetUrl); // 跳转到 user/profile
    }

    private function setCode($prefix, $phone, $expire = 599) {
        $num = rand(1000, 9999);
//        $num = 1234;
        S($prefix . $phone, $num, $expire);
        // 发送验证码
        $sms = D('Common/Sms2');
        $sms->send_vcode($num, $phone);
        return true;
    }

    private function checkCode($prefix, $phone, $code) {
//        return $code == 1234;
        return S($prefix . $phone) == $code;
    }

}
