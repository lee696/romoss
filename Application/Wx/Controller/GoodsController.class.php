<?php
namespace Wx\Controller;
use Think\Controller;
class GoodsController extends BaseContoller {
    public function index(){
        $goods_id = I('goods_id', 0, 'intval');
        if(!$goods_id){
            $this->error('参数缺失');
        }
        $info = D('Common/Goods')->getInfo($goods_id);
        $info['sale_num'] = $this->getMonthSale($goods_id);
        if(!$info || !$info['is_on']){
            $this->error('商品已下架');
        }
        $sku = D('Common/Sku')->getList($goods_id);
//        if(!$sku){
//            $this->error('商品已下架');
//        }
        $info['total_num'] = 0;
        foreach ($sku as $v){
            $info['total_num'] += $v['sku_num'];
        }
        $relationGoods = D('Common/Goods')->getList(['is_on' => 1, 'goods_id' => ['neq', $goods_id]], 0, 9);

        $list=M('comment')->join('cm_user on cm_user.user_id=cm_comment.user_id')->where(['goods_id'=>$goods_id])->field('cm_comment.*,cm_user.nickname,cm_user.avatar')->order('create_time desc')->limit(3)->select();

        foreach ($list as $k=>$v){
          $list[$k]['pic']=M('picture')->select($list[$k]['pic']);
        }
        //dump($list);exit();
        $this->assign('list', $list);
        $this->assign('info', $info);
        $this->assign('sku', $sku);
        $this->assign('sum', M('comment')->where(['goods_id'=>$goods_id])->count());
        $this->assign('relation_goods', $relationGoods);
        $this->display();
    }
    private function getMonthSale($goods_id){
      $num=M('order')->where(['goods_id'=>$goods_id])->sum('goods_num');
        return (int)$num;
    }
    public function details(){
      $goods_id = I('goods_id', 0, 'intval');
        if(!$goods_id){
            $this->error('参数缺失');
        }
        $where['goods_id']=$goods_id;
        $type=I('type', 0, 'intval');
        if($type==1){
          $where['score']=5;
        }
        if($type==2){
          $where['score']=array('between','3,4');
        }
        if($type==3){
           $where['score']=array('between','1,2');
        }

        $list=M('comment')->join('cm_user on cm_user.user_id=cm_comment.user_id')->where($where)->order('create_time desc')->field('cm_comment.*,cm_user.nickname,cm_user.avatar')->select();

        foreach ($list as $k=>$v){
          $list[$k]['pic']=M('picture')->select($list[$k]['pic']);
        }
        $good=M('comment')->join('cm_user on cm_user.user_id=cm_comment.user_id')->where(['goods_id'=>$goods_id,'score'=>5])->count();
        $secondary=M('comment')->join('cm_user on cm_user.user_id=cm_comment.user_id')->where(['goods_id'=>$goods_id,'score'=>array('between','3,4')])->count();
        $bad=M('comment')->join('cm_user on cm_user.user_id=cm_comment.user_id')->where(['goods_id'=>$goods_id,'score'=>array('between','1,2')])->count();
        $info = D('Common/Goods')->getInfo($goods_id);
        $sku = D('Common/Sku')->getList($goods_id);
        $info['total_num'] = 0;
        foreach ($sku as $v){
            $info['total_num'] += $v['sku_num'];
        }
        $this->assign('sku', $sku);
        $this->assign('type', $type);
        $this->assign('info', $info);
        $this->assign('list', $list);
        $this->assign('good', $good);
        $this->assign('sum', M('comment')->join('cm_user on cm_user.user_id=cm_comment.user_id')->where(['goods_id'=>$goods_id])->count());
        $this->assign('secondary', $secondary);
        $this->assign('bad', $bad);
        $this->display();
    }

    
}