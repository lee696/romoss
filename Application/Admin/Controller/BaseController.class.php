<?php
namespace Admin\Controller;
use Think\Controller;

class BaseController extends Controller {
    public $_user;//保存登录的用户信息
    public $is_check_login=true;//是否需要验证登录

    public $_module = '';       //记录当前的模块名称
    public $_controller ='';    //记录当前的控制器名称
    public $_action ='';        //记录当前的操作方法名称
    public $is_check_rule=true;  //表示是否需要验证权限

    public function __construct()
    {
        parent::__construct();
        $this->_user=cookie('_user');
        
        //使用属性将当前的URL对应的模型控制器方法的名称记录记录下来
        $this->_module=strtolower(MODULE_NAME);
        $this->_controller=strtolower(CONTROLLER_NAME);
        $this->_action=strtolower(ACTION_NAME);

        if($this->is_check_login){
            if(!$this->_user){
                $this->error('没有登录',U('Account/login'));
            }
            //通过角色获取对应的权限id
            if($this->_user['role_id']==1){
                //超级管理员 不进行权限认证
                $this->is_check_rule=false;//表示不验证权限
                //超级管理员不做权限认证，但是需要给他生成处导航菜单
                $rule_list= D('Rule')->select();
            }else{
                //普通角色 通过角色id获取对应的权限id
                $role = D('Role')->where(array('role_id'=>$this->_user['role_id']))->find();
                //$rule_ids表示当前角色具备的权限
                $rule_ids= $role['rule_ids'];
                //根据具备的权限信息获取 详细的权限

                $rule_list = D('Rule')->where(array('rule_id'=>array('in',$rule_ids)))->select();
            }
            foreach ($rule_list as $key => $value) {
                //将所有的权限/当前用户所具备的权限，根据is_show 加入到$this变量中
                if($value['is_show']){
                    $this->_user['menus'][]=$value;
                }
                //将已拥有的权限存储到一个数组中
                $this->_user['rules'][]=$value['rule_module'].'/'.$value['rule_controller'].'/'.$value['rule_action'];
            }
            
            //开始验证权限
            $this->authRule();
        }
    }

    public function authRule()
    {
        //超级管理员不进行权限认证
        if(!$this->is_check_rule){
            return true;
        }
        if(!$this->checkAuth()){
            if(IS_AJAX){
                $this->ajaxReturn(array('status'=>0,'msg'=>'没权限'));
            }else{
                // $this->error();
                echo '没有权限';exit();
            }
        }
    }

    //进行权限认证
    public function checkAuth()
    {
        //增加默认都具备访问权限的地址
        $this->_user['rules'][]='admin/index/index';
        $this->_user['rules'][]='admin/index/home';
        $action = $this->_module.'/'.$this->_controller.'/'.$this->_action;
        if(in_array($action, $this->_user['rules'])){
            return true;
        }else{
            return false;
        }
    }
    private $noLogin = [['Account', 'login']];
    protected function _initialize(){
        $this->checkLogin();
        if(method_exists($this,'init'))
            $this->init();
    }
    protected function checkLogin(){
        if(!in_array([CONTROLLER_NAME,ACTION_NAME], $this->noLogin) && !isLogin()){
            $this->redirect('Account/login');
        }
    }
}