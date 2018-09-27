<?php

namespace Admin\Controller;
class OrderController extends BaseController {
  public function index(){
        $start_time = I('start_time', null, 'strtotime');
        $end_time = I('end_time', null , 'strtotime');
        $goods_no = I('get.order_num');
        $status = I('status', null, 'intval');
        $condition = [];
        if($goods_no){
            $condition['order_num'] = "$goods_no";
        }
        if($status){
            $condition['status'] = ['eq', $status];
        }
        
        if(isset($start_time) && isset($end_time)){
            $condition['create_time'] = ['between', [$start_time, $end_time]];
        }elseif(isset($start_time)){
            $condition['create_time'] = ['gt', $start_time];
        }elseif(isset($end_time)){
            $condition['create_time'] = ['lt', $end_time];
        }
       
        $count = D('Order')->where($condition)->count();
        $Page = new \Think\Page($count,10);
        $Page->setConfig('theme', C('PAGE_THEME'));
        $pageHtml = $Page->show();
        $field = ['goods_id', 'order_num', 'user_id', 'create_time', 'price', 'shipping_fee', 'goods_num','goods_type','status','order_id'];
        $consi = D('address') -> select();
        $list = D('Order')->where($condition)->field($field)->limit($Page->firstRow,$Page->listRows)->select();
        //dump($condition);exit();
        //echo D('Order')->getlastsql();exit();
        //dump($list);exit();
        foreach ($list as $k=>$v){
          if($list[$k]['goods_type']==1){
            $ginfo=M('goods')->find($list[$k]['goods_id']);
            $list[$k]['goods_name']=$ginfo['goods_name'];
            $list[$k]['img']=$ginfo['goods_img'];
          }
        }
        $this -> assign('con',$consi);
        $this->assign('pageHtml',$pageHtml);
        $this->assign('total',$count);
        $this->assign('list', $list);
    $this->display();
  }
  public function send(){
    if(IS_POST){
      $expressno=$_POST['exp'];
      $order_id=$_POST['order_id'];
      $expresscode=$_POST['expresscode'];
      $ret=M('order')->where(['order_id'=>$order_id])->save(['expressno'=>$expressno,'expresscode'=>$expresscode,'shipping_time'=>  time(),'status'=>3]);
      if($ret){
        sendResult($order_id);
      }else{
        sendError('ERROR_NET');
      }
      
    }
    $oid=I('order_id');
    $info=M('order')->find($oid);
    $express=M('express')->select();
    $this->assign('express', $express);
    $this->assign('info', $info);
    $this->display();
  }
  public function info(){
    $oid=I('order_id');
    $list=M('order')->find($oid);
    $ginfo=M('goods')->find($list['goods_id']);
            $list['goods_name']=$ginfo['goods_name'];
            $list['img']=$ginfo['goods_img'];
    $this->assign('info', $list);
    $this->display();
  }
}

