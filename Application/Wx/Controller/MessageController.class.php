<?php

namespace Wx\Controller;

use Think\Controller;

class MessageController extends BaseContoller {

    public function index()
    {
      checkLogin();
      $userid=  getUserId();
      $list=M('msgcenter')->where('uid='.$userid)->order('create_at desc')->select();
      $this->assign('list', $list);
        $this->display();
    }

    public function details()
    {
      checkLogin();
      $id=I('id');
      $list=M('msgcenter')->where('id='.$id)->find();
      $this->assign('list', $list);
        $this->display();
    }

}
