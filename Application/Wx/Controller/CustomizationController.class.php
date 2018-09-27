<?php

namespace Wx\Controller;

use Think\Controller;

class CustomizationController extends BaseContoller {

    public function index()
    {
      $materialtype=M('materialtype')->select();
      $this->assign('materialtype', $materialtype);
      $cmpicture=M("cmpicture")->limit(2)->select();
      $this->assign('cmpicture', $cmpicture);
      $stickers=M("sticker")->limit(2)->select();
      $JsTicket=$this->wxtest();
      $this->assign('JsTicket', $JsTicket);
      $this->assign('sticker', $stickers);
      $this->display();
    }
    
    public function material(){
      $pid=I('pid');
      $list=M('material')->where(['pid'=>$pid])->select();
      sendResult($list);
    }
    /*
     * 更多图片
     */
    public function materials(){
      $type=M("cmpicturetype")->select();
      $list=M("cmpicture")->where(['pid'=>1])->select();
      $this->assign('list', $list);
      $this->assign('type', $type);
      $this->display();
    }
     public function cmpicture(){
      $pid=I('pid');
      $list=M('cmpicture')->where(['pid'=>$pid])->select();
      sendResult($list);
    }
    /*
     * 贴纸
     */
    public function stickers(){
      $type=M("stickertype")->select();
      $list=M("sticker")->where(['pid'=>1])->select();
      $this->assign('list', $list);
      $this->assign('type', $type);
      $this->display();
    }
     public function sticker(){
      $pid=I('pid');
      $list=M('sticker')->where(['pid'=>$pid])->select();
      sendResult($list);
    }

}
