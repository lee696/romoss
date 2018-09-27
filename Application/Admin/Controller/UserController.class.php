<?php

namespace Admin\Controller;
class UserController extends BaseController {
  public function index(){
    $keywords = I('title', '', 'trim');
        $start_time = I('start_time', null, 'strtotime');
        $end_time = I('end_time', null , 'strtotime');
//        $is_on = I('is_on', null, 'intval');
        $condition = [];
        if($keywords){
            $condition['phone'] = ['like', "%$keywords%"];
        }
//        if(isset($is_on)){
//            $condition['is_on'] = $is_on;
//        }
        if(isset($start_time) && isset($end_time)){
            $condition['create_time'] = ['between', [$start_time, $end_time]];
        }elseif(isset($start_time)){
            $condition['create_time'] = ['gt', $start_time];
        }elseif(isset($end_time)){
            $condition['create_time'] = ['lt', $end_time];
        }
        $count = D('Common/User')->getTotal($condition);
        $Page = new \Think\Page($count,C('LIST_ROWS'));
        $Page->setConfig('theme', C('PAGE_THEME'));
        $pageHtml = $Page->show();
        $list = D('Common/User')->getList($condition,$Page->firstRow,$Page->listRows);
        $this->assign('pageHtml',$pageHtml);
        $this->assign('total',$count);
        $this->assign('list', $list);
    $this->display();
  }
  public function info(){
        $user_id = I('user_id', 0, 'intval');
        if($user_id){
            $info = D('Common/User')->getInfo($user_id);
            $this->assign('info', $info);
        }
        $this->display();
    }
    public function add(){
      if(IS_POST){
        $phone = I('phone', null, 'trim');
        $pwd = I('pwd', null, 'trim');
        if (D('Common/User')->accountExists($phone)) {
            sendError('ERROR_ACCOUNT_EXISTS');
        }
        $user_id = D('Common/User')->insert($phone, $pwd);
            if($user_id){
                sendResult($user_id);
            }else{
                sendError('ERROR_NET');
            }
      }
      $this->display();
    }
    public function del(){
        //删除用户
        $model = D('user');
        $id = I('post.user_id',0,'intval');
        $res = $model -> where("user_id=%d",$id) -> delete();
        if($res){
            $this -> ajaxReturn(array('status'=>1,'msg'=>'删除成功'));
        }else{
            $this -> ajaxReturn(array('status'=>0,'msg'=>'删除失败'));
        }
    }
}
