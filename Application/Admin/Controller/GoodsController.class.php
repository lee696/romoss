<?php
namespace Admin\Controller;
class GoodsController extends BaseController {
    public function index(){
        $keywords = I('title', '', 'trim');
        $start_time = I('start_time', null, 'strtotime');
        $end_time = I('end_time', null , 'strtotime');
        $is_on = I('is_on', null, 'intval');
        $sku_num = I('sku_num', null, 'intval');
        //dump($sku_num);exit();
        $goods_no = I('goods_no');
        $condition = [];
        if($keywords){
            $condition['goods_name'] = ['like', "%$keywords%"];
        }
        if($goods_no){
            $condition['goods_no'] = ['like', "%$goods_no%"];
        }
        if(isset($is_on)){
            $condition['is_on'] = $is_on;
        }
        if(isset($start_time) && isset($end_time)){
            $condition['on_time'] = ['between', [$start_time, $end_time]];
        }elseif(isset($start_time)){
            $condition['on_time'] = ['gt', $start_time];
        }elseif(isset($end_time)){
            $condition['on_time'] = ['lt', $end_time];
        }
        if($sku_num == 1){
            $condition['sku_num'] = ['between', [10, 100]];
        }elseif ($sku_num == 2){
            $condition['sku_num'] = ['exp', ' <= warn_num'];
        }
        $count = D('Common/Goods')->where($condition)->count();
        
        $Page = new \Think\Page($count,C('LIST_ROWS'));
        $Page->setConfig('theme', C('PAGE_THEME'));
        $pageHtml = $Page->show();
        $field = ['goods_id', 'goods_name', 'goods_no','on_time', 'price', 'shipping_fee', 'goods_label','is_on'];
        $list = D('Common/Goods')->where($condition)->field($field)->limit($Page->firstRow,$Page->listRows)->select();
        //echo D('Common/Goods') -> getlastsql();exit();
        foreach ($list as $k => $v){
            $list[$k]['sale_num'] = 0;
            $list[$k]['comment_num'] = M('comment')->where(['goods_id'=>$v['goods_id']])->count();
            $list[$k]['img'] = M('sku')->where(['goods_id'=>$v['goods_id']])->getField('img');
            $list[$k]['sku_num'] = M('sku')->where(['goods_id'=>$v['goods_id']])->sum('sku_num');
            $list[$k]['goods_label'] = json_decode($v['goods_label'], true);
        }
        $this->assign('pageHtml',$pageHtml);
        $this->assign('total',$count);
        $this->assign('list', $list);
		$this->display();
    }
    public function info(){
        $goods_id = I('goods_id', 0, 'intval');
        if($goods_id){
            $info = D('Common/Goods')->getInfo($goods_id);
            $info['sku'] = D('Common/Sku')->getList($goods_id);
            $info['sku_json'] = json_encode($info['sku']);
            $this->assign('info', $info);
        }
        $this->display();
    }
    public function operation(){
        $goods_id = I('goods_id', 0, 'intval');
        $goods_name = I('goods_name', '', 'trim');
        $goods_no = I('goods_no', '', 'trim');
        $price = I('price', 0, 'floatval');
        $market_price= I('market_price', 0, 'floatval');
        $warn_num = I('warn_num', 0, 'intval');
        $desc = I('desc', '', 'trim');
        $shipping_fee = I('shipping_fee', 0, 'floatval');
        $append_fee = I('append_fee', 0, 'floatval');
        $is_on = I('is_on', 0, 'intval');
        $goods_label = I('goods_label');
        $goods_service = I('goods_service');
        $remark = I('remark', '', 'trim');
        $sku_name = I('sku_name', '', 'trim');
        $sku = I('sku');
        if(!$goods_name || !$price || $this->checkSku($sku)){
            sendError('ERROR_PARAM');
        }
        $model = D('Common/Goods');
        if($goods_id){
            $goodsInfo = $model->getInfo($goods_id);
            if(!$goodsInfo){
                sendError('ERROR_NO_TAIL');
            }
            $on_time = null;
            if(!$goodsInfo['is_on']){
                $on_time = time();
            }
            $model->startTrans();
            if(!D('Common/Sku')->setOff($goods_id) || !D('Common/Goods')->edit($goods_id, $goods_name, $sku[0]['img'], $goods_no, $price, $market_price, $warn_num, $desc, $shipping_fee, $append_fee, $is_on, $goods_label, $goods_service, $remark, $sku_name, $on_time)){
                $model->rollback();
                sendError('ERROR_NET');
            }
            foreach ($sku as $v){
                $sku_no = D('Common/Sku')->skuExists($goods_id, $v['sku_name']);
                if($sku_no){
                    if(!D('Common/Sku')->edit($sku_no, $v['sku_name'], $v['sku_num'], $v['pic'], $v['img'])){
                        $model->rollback();
                        sendError('ERROR_NET');
                    }
                }elseif(!D('Common/Sku')->insert($goods_id, $v['sku_name'], $v['sku_num'], $v['pic'], $v['img'])){
                    $model->rollback();
                    sendError('ERROR_NET');
                }
            }
            $model->commit();
            sendResult();
        }else{
            $model->startTrans();
            $goods_id = D('Common/Goods')->insert($goods_name, $sku[0]['img'], $goods_no, $price, $market_price, $warn_num, $desc, $shipping_fee, $append_fee, $is_on, $goods_label, $goods_service, $remark, $sku_name);
            if(!$goods_id){
                $model->rollback();
                sendError('ERROR_NET');
            }
            foreach ($sku as $v){
                if(!D('Common/Sku')->insert($goods_id, $v['sku_name'], $v['sku_num'], $v['pic'], $v['img'])){
                    $model->rollback();
                    sendError('ERROR_NET');
                }
            }
            $model->commit();
            sendResult($goods_id);
        }
    }
    private function checkSku(){

    }
    public function del(){
        $slide_id = I('slide_id');
        if(!$slide_id){
            sendError('ERROR_PARAM');
        }
        $res = D('Common/Goods')->where("goods_id=%d",$slide_id)->delete();
        if($res){
            sendResult();
        }else{
            sendError('ERROR_NET');
        }
    }
    public function setMulOrder(){
        $goodsOrder = I('goods_order');
        if(!$this->checkMulOrder($goodsOrder)){
            sendError('ERROR_PARAM');
        }
        $model = D('Common/Order');
        $model->startTrans();
        foreach ($goodsOrder as $goods_id => $order){
            if(!$model->setOrder($goods_id, $order)){
                $model->rollback();
                sendError('ERROR_NET');
            }
        }
        $model->commit();
        sendResult();
    }
    private function checkMulOrder($slideOrder){
        if(!$slideOrder || !is_array($slideOrder)){
            return false;
        }
        foreach ($slideOrder as $slide_id => $order){
            if(!is_numeric($slide_id) || !is_numeric($order)){
                return false;
            }
        }
        return true;
    }
}