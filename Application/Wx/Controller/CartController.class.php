<?php
namespace Wx\Controller;
use Think\Controller;
class CartController extends BaseContoller {
    public function index(){
        $goods_id = I('goods_id', 0, 'intval');
        $info = D('Common/Goods')->getInfo($goods_id);
        $this->assign('info', $info);
        $this->display();
    }
    
}