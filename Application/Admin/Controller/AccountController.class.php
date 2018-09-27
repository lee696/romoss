<?php
namespace Admin\Controller;
use Think\Controller;
class AccountController extends Controller {
    public function login(){
        if(IS_GET){
            $this->display();
        }else{
            $model = D('Common/AdminUser');
            //检查验证码
            // $verify = new \Think\Verify();
            // $code =I('post.code');
            // if(!$verify->check($code)){
            //  $this->error('验证码错误');
            // }

            $data = $model->create();
            if(!$data){
                $this->error($model->getError());
            }
            //进行登录的数据验证
            //$info = $model ->checkLogin($data['username'],$data['password']);
            $userInfo = $model->where(['status' => 1, 'username' => $data['username'], 'password' => createPassword($data['password'])])->find();
            if(!$userInfo){
                sendError('账号或密码错误');
            }else{
                setLoginData($userInfo);
                //(sendResult();
            }
            cookie('_user',$userInfo,$time);
            //dump($_COOKIE);exit();
            $this->ajaxReturn(array('status'=>0,'msg'=>'登录成功'));

/*            //URL重定向
            $this->redirect('Index/index');*/
        }
		
    }
/*    public function doLogin(){
        $username = I('username', null, 'trim');
        $password = I('password', null, 'trim');
        if(!$username || !$password){
            sendError('ERROR_PARAM');
        }else{
            $userInfo = D('Common/AdminUser')->where(['status' => 1, 'username' => $username, 'password' => createPassword($password)])->find();
            if(!$userInfo){
                sendError('账号或密码错误');
            }else{
                setLoginData($userInfo);
                sendResult();
            }
        }
    }*/
    public function logout(){
    	if(is_login()){
        Loginout();
    		$this->success('您已成功退出！', U('Account/login'));
    	} else {
    		$this->redirect('Account/login');
    	}
    }
}