<?php
/*
 *权限控制器
 */
namespace Admin\Controller;
class RuleController extends BaseController {
	public function index(){
		//将数据显示在列表中
		$model = D('Rule');
		//分页
		$p = I('get.p');
		$pageszie= 10;
		$count = $model->count();

		$page = new \Think\Page($count,$pageszie);
		$show = $page->show();
		$this->assign('show',$show);

		$list = $model->page($p,$pageszie)->select();
		$this -> assign('list',$list);
		$this -> display();
	}
	public function add(){
		//添加权限
		$model = D('Rule');
		if(IS_GET){
			$tree = $model -> getTree();
			$this -> assign('tree',$tree);
			$this -> display();
		}else{
			$data['rule_name'] = $_POST['name'];
			$data['rule_module'] = $_POST['module'];
			$data['rule_controller'] = $_POST['controller'];
			$data['rule_action'] = $_POST['action'];
			$data['pid'] = $_POST['pid'];
			$data['is_show'] = $_POST['is_show'];
			//dump($data);exit();
			$res = $model -> add($data);
			if($res){
				$this -> ajaxReturn(array('status'=>1,'content'=>'添加成功'));
			}else{
				$this -> ajaxReturn(array('status'=>0,'content'=>'添加失败'));
			}
		}
	}
	public function edit(){
		//修改权限
		$model = D('Rule');
		if(IS_GET){
			$id = intval(I('get.rule_id'));
			$list = $model -> where("rule_id='$id'") -> find();
			// dump($list);exit();
			$this -> assign('list',$list);
			$this -> display();
		}else{
			$data['rule_name'] = $_POST['name'];
			$data['rule_module'] = $_POST['module'];
			$data['rule_controller'] = $_POST['controller'];
			$data['rule_action'] = $_POST['action'];
			$id = $_POST['id'];
			$res = $model -> where("rule_id='$id'") -> save($data);
			if($res){
				$this -> ajaxReturn(array('status'=>1,'content'=>'修改成功'));
			}else{
				$this -> ajaxReturn(array('status'=>0,'content'=>'编辑失败'));
			}	
		}
	}
	public function del(){
		//删除权限
		$model = D('Rule');
		$id = $_POST['rule_id'][0];
		//dump($id);exit();
		$res = $model -> where("rule_id='$id'") -> delete();
		if($res){
			$this -> ajaxReturn(array('status'=>1,'content'=>'删除成功'));
		}else{
			$this -> ajaxReturn(array('status'=>0,'content'=>'删除失败'));
		}
	}
}