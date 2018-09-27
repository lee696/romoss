<?php
/*
 *角色控制器
 */
namespace Admin\Controller;
class RoleController extends BaseController {
	public function index(){
		//显示角色列表
		$model = D('Role');
        $list = $model -> select();
        // dump($list);exit();
        $user = D('Admin_user');
        $username = $user->select();
        $this -> assign('name',$username);
        $this -> assign('list',$list);
		$this -> display();
	}

	public function add(){
		//角色添加
		self::edit();
	}
    public function edit(){
    	//角色编辑
    	$model = D('Role');
    	if(IS_GET){
      		$id = intval(I('get.role_id'));
	      	if ($id==1) {
	      		//超级管理员不能进行修改
	        	$this -> error('超级管理员不能修改');
	      	}
	      	if($id>1){
	      		$info = $model -> where("role_id='$id'") -> find();
	      		$this -> assign('info',$info);
	      	}
	      	$this -> display('edit');
    	}else{
    		$id = intval(I('post.id'));
    		$data = $model -> create();
    		$data['create_time']=time();
    		if($id>1){
    			//有id代表修改角色信息
    			$model -> save($data);
    		}else{
    			//没有id代表添加角色
    			$model -> add($data);
    		}
    	}
    }
    public function del(){
        //dump($_POST['role_id']);exit();
    	//删除角色
    	$id = $_POST['role_id'][0];
    	if($id==1){
    		$this -> error('超级管理员不能删除');
    	}
    	$res = D('Role') -> where("role_id='$id'") -> delete();
        if($res){
            $this -> ajaxReturn(array('status'=>1,'content'=>'删除成功'));
        }else{
            $this -> ajaxReturn(array('status'=>0,'content'=>'删除失败'));
        }
    }

    public function disfetch()
    {
        if(IS_GET){
            //接受传递的角色ID
            $role_id = intval(I('get.role_id'));
            $this->assign('rid',$role_id);
            //获取所有的权限信息
            $rule = D('Rule')->select();
            //dump($rule);exit();
            $this->assign('rule',$rule);

            //获取当前修改角色的已有权限
            $rules=D('Role')->where("role_id=%d",$role_id)->find();
            $hasRule=$rules['rule_ids'];
            $this->assign('hasRule',$hasRule);
            $this->display();
        }else{
            //接受表单传递的要修改的角色id
            $rid = intval(I('post.rid'));
            $rules=I('post.rule');
            //$rule是数组格式 因此需要转换成逗号分隔的字符串
            $rule_ids=implode(',', $rules);
            //修改角色表中对应的权限
            $res = D('Role')->where("role_id=%d",$rid)->setField('rule_ids',$rule_ids);
            //echo D('role')->getlastsql();dump($rule_ids);exit();
            if($res){
                $this -> success('权限分配成功');
            }else{
                $this -> error('请重新分配');
            }
        }
    }
}