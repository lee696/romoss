<?php
namespace Common\Model;
use Think\Model;
class GoodsModel extends Model{
    public function getInfo($goods_id){
        $condition = [];
        $condition['is_del'] = 0;
        $condition['goods_id'] = $goods_id;
        return $this->formatInfo($this->where($condition)->find());
    }
    public function insert($goods_name, $goods_img, $goods_no, $price, $market_price, $warn_num, $desc, $shipping_fee, $append_fee, $is_on, $goods_label, $goods_service, $remark, $sku_name){
        $data = [];
        $data['goods_name'] = $goods_name;
        $data['goods_img'] = $goods_img;
        $data['goods_no'] = $this->createSku($goods_no);
        $data['price'] = $price;
        $data['market_price'] = $market_price;
        $data['warn_num'] = $warn_num;
        $data['desc'] = $desc;
        $data['shipping_fee'] = $shipping_fee;
        $data['append_fee'] = $append_fee;
        $data['goods_label'] = json_encode($goods_label);
        $data['goods_service'] = json_encode($goods_service);
        $data['remark'] = $remark;
        $data['sku_name'] = $sku_name;
        $data['is_on'] = $is_on;
        $data['create_time'] = time();
        $data['on_time'] = time();
        $data['order'] = 0;
        if($is_on){
            $data['on_time'] = time();
        }
        return (int)$this->add($data);
    }
    public function edit($goods_id, $goods_name, $goods_img, $goods_no, $price, $market_price, $warn_num, $desc, $shipping_fee, $append_fee, $is_on, $goods_label, $goods_service, $remark, $sku_name, $on_time){
        $data = [];
        $data['goods_id'] = $goods_id;
        $data['goods_name'] = $goods_name;
        $data['goods_img'] = $goods_img;
        $data['goods_no'] = $this->createSku($goods_no);
        $data['price'] = $price;
        $data['market_price'] = $market_price;
        $data['warn_num'] = $warn_num;
        $data['desc'] = $desc;
        $data['shipping_fee'] = $shipping_fee;
        $data['append_fee'] = $append_fee;
        $data['goods_label'] = json_encode($goods_label);
        $data['goods_service'] = json_encode($goods_service);
        $data['remark'] = $remark;
        $data['sku_name'] = $sku_name;
        $data['on_time'] = $on_time;
        $data['is_on'] = $is_on;
        return $this->save($data) !== false;
    }
    private function createSku($goods_no){
        if($goods_no){
            return $goods_no;
        }else{
            return 'RMSK'.time().rand(100000, 999999);
        }
    }
    public function del($goods_id){
        $condition = [];
        if(is_array($goods_id)){
            $condition['goods_id'] = ['in', $goods_id];
        }else{
            $condition['goods_id'] = $goods_id;
        }
        $data = [];
        $data['is_del'] = 1;
        return $this->where($condition)->save($data) !== false;
    }
    public function setOrder($goods_id, $order){
        $condition = [];
        $condition['goods_id'] = $goods_id;
        $data = [];
        $data['order'] = $order;
        return $this->where($condition)->save($data) !== false;
    }
    public function getList($condition = [], $start = null, $length = null){
        $condition['is_del'] = 0;
        $res = $this->where($condition)->order(['order' => 'desc'])->limit($start, $length)->select();
        $list = [];
        foreach ($res as $v){
            $list[] = $this->formatInfo($v);
        }
        return $list;
    }
    public function getTotal($condition = []){
        $condition['is_del'] = 0;
        $count = $this->where($condition)->count();
        return (int)$count;
    }
    private function formatInfo($info){
        $keys = array_keys($info);
        if(in_array('goods_id', $keys))         $info['goods_id'] = (int)$info['goods_id'];
        if(in_array('create_time', $keys))      $info['create_time'] = (int)$info['create_time'];
        if(in_array('is_on', $keys))            $info['is_on'] = (int)$info['is_on'];
        if(in_array('is_del', $keys))           $info['is_del'] = (int)$info['is_del'];
        if(in_array('order', $keys))            $info['order'] = (int)$info['order'];
        if(in_array('price', $keys))            $info['price'] = (float)$info['price'];
        if(in_array('market_price', $keys))     $info['market_price'] = (float)$info['market_price'];
        if(in_array('warn_num', $keys))         $info['warn_num'] = (int)$info['warn_num'];
        if(in_array('shipping_fee', $keys))     $info['shipping_fee'] = (float)$info['shipping_fee'];
        if(in_array('append_fee', $keys))       $info['append_fee'] = (float)$info['append_fee'];
        if(in_array('on_time', $keys))          $info['on_time'] = (int)$info['on_time'];
        if(in_array('goods_label', $keys))      $info['goods_label'] = json_decode($info['goods_label'], true);
        if(in_array('goods_service', $keys))    $info['goods_service'] = json_decode($info['goods_service'], true);
        return $info;
    }
}