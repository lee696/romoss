<?php

namespace Wx\Controller;

use Think\Controller;

class SetingController extends BaseContoller {

    public function index()
    {
        $this->display('setting');
    }
    public function feedback(){
      checkLogin();
      $user_id = getUserId();
      if(IS_POST){
        
       $data = array(
        	'uid' => $user_id,
        	'content' => I('content','','trim'),
        	'add_time' => time(),
        );
   
     if (M('feedback')->add($data)) {
       $url=U('Seting/setting');
       echo"<script> alert(' 提交成功,我们会尽快处理您的反馈');window.location.href='$url'</script>";
//       echo"<script> alert(' 提交成功,我们会尽快处理您的反馈');window.self.location=document.referrer;</script>";
        }else{
        	$this->error('提交失败');
        } 
      }else{
       $this->display(); 
      }
        }
        
        public function revise(){
          checkLogin();
      $user_id = getUserId();
      if(IS_POST){
        $info=M('User')->find($user_id);
        $repassword=$_POST['repassword'];
        $pwd=$_POST['password'];
        
        $oldpwd=$_POST['oldpws'];
//        var_dump($info['pwd'].'/'.createPassword($oldpwd));die;
        if($info['pwd']!=  createPassword($oldpwd)){
          echo"<script> alert('原密码错误');window.self.location=document.referrer;</script>";
        }  else {
          if($pwd!=$repassword){
          echo"<script> alert('两次输入的密码不一致')</script>";die;
        }
          $ret=D('Common/User')->changepwd($user_id,$pwd);
        }
        

        if ($ret) {
       $url=U('Seting/setting');
       echo"<script> alert(' 修改成功');window.location.href='$url'</script>";
//       echo"<script> alert(' 提交成功,我们会尽快处理您的反馈');window.self.location=document.referrer;</script>";
        }else{
        	$this->error('提交失败');
        } 
      }else{
        $info=M('User')->find($user_id);
        if($info['pwd']==  createPassword('YXS0')){
          $url=U('Seting/settingnewpwd');
       echo"<script>window.location.href='$url'</script>";
        } 
       $this->display(); 
      }
        }
        public function settingnewpwd(){
//          var_dump(createPassword('YXS0'));die;
          checkLogin();
      $user_id = getUserId();
          if(IS_POST){
//            $repassword=$_POST['repassword'];
        $pwd=$_POST['password'];
            $ret=D('Common/User')->changepwd($user_id,$pwd);
            if ($ret) {
       $url=U('Seting/setting');
       echo"<script> alert(' 设置成功');window.location.href='$url'</script>";
//       echo"<script> alert(' 提交成功,我们会尽快处理您的反馈');window.self.location=document.referrer;</script>";
        }else{
        	$this->error('设置失败');
        } 
          }else{
           $this->display();  
          }
          
        }

}
