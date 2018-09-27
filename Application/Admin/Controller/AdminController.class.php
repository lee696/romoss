<?php
namespace Admin\Controller;
class AdminController extends BaseController {
  public function index(){
   $keywords = I('title', '', 'trim');
        $start_time = I('start_time', null, 'strtotime');
        $end_time = I('end_time', null , 'strtotime');
//        $is_on = I('is_on', null, 'intval');
        $condition = [];
        if($keywords){
            $condition['username'] = ['like', "%$keywords%"];
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
        $count = M('AdminUser')->where($condition)->count();
        $Page = new \Think\Page($count,C('LIST_ROWS'));
        $Page->setConfig('theme', C('PAGE_THEME'));
        $pageHtml = $Page->show();
        $list = M('AdminUser')->where($condition)->limit($Page->firstRow,$Page->listRows)->select();
        //查询角色
        $model = D('role');
        $tree = $model->select();
        //dump($tree);exit();
        $this -> assign('tree',$tree);
        $this->assign('pageHtml',$pageHtml);
        $this->assign('total',$count);
        $this->assign('list', $list);
    $this->display();
  }
  public function add(){
    //用户添加
    $model = M('Admin_user');
    if(IS_GET){
        $role=D('Role');
        $tree = $role -> select();
        //dump($tree);exit();
        $this -> assign('tree',$tree);
        $this -> display();
    }else{
        //dump($_POST);exit();
        $data['username']=$_POST['name'];
        $data['password']=createPassword($_POST['pwd']);
        $data['role_id']=$_POST['role_id'];
        $data['create_time']=time();
        $res = $model -> add($data);
        if($res){
            $this -> ajaxReturn(array('status'=>1,'content'=>'添加成功'));
        }
    }
  }
  public function edit(){
    //用户编辑
    $model = D('Admin_user');
    if(IS_GET){
        $id = intval(I('get.admin_id'));
        if($id==1){
            //admin账户不用修改，
            $this -> error('管理员账户不能修改');
        }
        $list = $model -> where("admin_id=%d",$id) -> find();
        $tree = D('Role') -> select();
        $this -> assign('tree',$tree);
        $this -> assign('list',$list);
        $this -> display();
    }else{
        //修改用户信息
        $id = intval(I('post.admin_id'));
        $data['username']=$_POST['name'];
        $data['password']=createPassword($_POST['pwd']);
        $data['role_id']=$_POST['role_id'];
        $data['create_time']=time();
        $res = $model -> where("admin_id=%d",$id) -> save($data);
        if($res){
            $this -> ajaxReturn(array('status'=>1,'msg'=>'修改成功'));
        }else{
            $this -> ajaxReturn(array('status'=>0,'msg'=>'修改失败'));
        }
    }
  }
  public function del(){
    //用户删除
    $model = D('Admin_user');
    $id = I('post.admin_id',0,'intval');
    $res = $model -> where("admin_id=%d",$id) -> delete();
    if($res){
        $this -> ajaxReturn(array('status'=>1,'msg'=>'删除成功'));
    }else{
        $this -> ajaxReturn(array('status'=>0,'msg'=>'删除失败'));
    }
  }
}
