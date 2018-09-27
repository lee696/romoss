<?php
namespace Admin\Controller;
class IndexController extends BaseController {
    public function index(){
/*    	dump($this->_user['menus']);exit();
    	//实现导航菜单生成
    	$this->assign('menus',$this->_user['menus']);*/
        $this->display();
    }
}