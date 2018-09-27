<?php
namespace Wx\Controller;
use Think\Controller;
class IndexController extends BaseContoller {
    public function index(){
        $slideList = D('Common/Slide')->getList(['is_on' => 1]);
        $this->assign('slide_list', $slideList);
        $goodsList = D('Common/Goods')->getList(['is_on' => 1]);
        $this->assign('goods_list', $goodsList);
        $this->display();
    }
    public function valid()
    {
  $conf=C('wxopt');
    Vendor('wx.wechat');
    $wx=new \Wechat($conf);
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($wx->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

}