<?php

namespace Wx\Controller;

use Think\Controller;
use Wx\Common;
use EasyWeChat\Foundation\Application;

class MemberController extends BaseContoller {

    public function __construct()
    {
        parent::__construct();
        //未登录跳转到登录页面
        if (!isLogin()) {
            redirect("/Account/login");
        }
        $this->app = new Application(C('wx_options'));
        $this->oauth = $this->app->oauth;
    }

    public function index()
    {

        $user_info = getLoginData();
        $User = M("User");
        $user_info = $User->where("user_id={$user_info['user_id']}")->find();
        if (is_weixin() and empty($user_info['nickname'])) {
            /**
             * 登录成功跳转到个人中心页面
             * 1.判断是否在微信客户端
             * 2.判断头像昵称是否存在
             * 3.如果条件都满足（在微信端并且没有头像）就跳转到微信的授权页面
             * 4.获取微信头像昵称信息
             * 5.更新到数据库
             * 6.展示页面
             */
            // 未登录
            if (empty($_SESSION['wechat_user'])) {
                $_SESSION['target_url'] = '/Member/index';
//            return $oauth->redirect();
                // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
                $this->oauth->redirect()->send();
            }
            // 已经登录过
            $user = $_SESSION['wechat_user'];
//            print_r($user);
            // ...

            if (isset($user['nickname']) and isset($user['avatar'])) {
//                $User = M("User"); // 实例化User对象
                // 要修改的数据对象属性赋值
                $data['nickname'] = $user['nickname'];
                $data['avatar'] = $user['avatar'];
                $User->where("user_id={$user_info['user_id']}")->save($data); // 根据条件更新记录
                $user_info = $User->where("user_id={$user_info['user_id']}")->find();
            }
        }

//        print_r($user_info);die;
        $this->assign('user_info', $user_info);

        $this->display();
    }

    public function callback()
    {

//        var_dump($_GET);die;
        // 获取 OAuth 授权结果用户信息
        $user = $this->oauth->user();
        $_SESSION['wechat_user'] = $user->toArray();
        $targetUrl = empty($_SESSION['target_url']) ? '/' : $_SESSION['target_url'];
        var_dump($user);
//        header('location:' . $targetUrl); // 跳转到 user/profile
    }

    public function info()
    {
        $user_info = getLoginData();

        $User = M("User");
        $user_info = $User->where("user_id={$user_info['user_id']}")->find();
        if (is_weixin() and ! isset($user_info['nickname'])) {
            /**
             * 登录成功跳转到个人中心页面
             * 1.判断是否在微信客户端
             * 2.判断头像昵称是否存在
             * 3.如果条件都满足（在微信端并且没有头像）就跳转到微信的授权页面
             * 4.获取微信头像昵称信息
             * 5.更新到数据库
             * 6.展示页面
             */
            // 未登录
            if (empty($_SESSION['wechat_user'])) {
                $_SESSION['target_url'] = 'Member/index';
//            return $oauth->redirect();
                // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
                $this->oauth->redirect()->send();
            }
            // 已经登录过
            $user = $_SESSION['wechat_user'];
//            print_r($user);
            // ...

            if (isset($user['nickname']) and isset($user['avatar'])) {
                $User = M("User"); // 实例化User对象
                // 要修改的数据对象属性赋值
                $data['nickname'] = $user['nickname'];
                $data['avatar'] = $user['avatar'];
                $User->where("user_id={$user_info['user_id']}")->save($data); // 根据条件更新记录
                $user_info = $User->where("user_id={$user_info['user_id']}")->find();
            }
        }

//        print_r($user_info);
//        die;
        $this->assign('user_info', $user_info);
        $this->display();
    }
    public function setinfo(){
      checkLogin();
      $userid=  getUserId();
      $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './static/upload/image/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        
        // 上传文件
        if(!empty($_FILES['images']['name'])){
          
          $info   =   $upload->uploadOne($_FILES['images']);
        if(!$info) {// 上传错误提示错误信息
            sendError($upload->getError());
        }else{// 上传成功
            $avatar='/static/upload/image/'.$info['savepath'].$info['savename'];
        }
        }
        
        $fldArr = ['nickname', 'sex', 'birthday'];
    $data = [];
    foreach ($fldArr as $fld) {
      $$fld = I($fld, null, 'trim');
      if (!empty($$fld)) {
        $data[$fld] = $$fld;
      }
    }
    $data['avatar']=$avatar;
//        $data['nickname'] =$_POST['nickname'];
//        $data['sex'] =$_POST['sex'];
//        $data['birthday'] =$_POST['birthday'];
        $User = M("User");
        $ret=$User->where("user_id=$userid")->save($data);
        if($ret){
           $url=U('Member/index');
           echo"<script> alert(' 修改成功');window.location.href='$url'</script>";
        }else{
          echo"<script> alert(' 修改失败');window.location.href=document.referrer</script>";
        }
    }

}
