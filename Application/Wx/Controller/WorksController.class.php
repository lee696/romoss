<?php

namespace Wx\Controller;

use Think\Controller;

class WorksController extends BaseContoller {

    public function index()
    {
      checkLogin();
      $user_id=  getUserId();
      $list=M('works')->where(['user_id'=>$user_id])->select();
      $this->assign('list', $list);
        $this->display();
    }
    public function del(){
        $user_id = getUserId();
        $id = I('id', 0, 'intval');
        if (!$id) {
            sendError('ERROR_PARAM');
        }
        $info = M('works')->where(['user_id'=>$user_id,'id'=>$id])->find();
        if (!$info || $info['user_id'] != $user_id) {
            sendError('ERROR_MASTER');
        }
        M('works')->delete($id);
        sendResult();
    }

}
