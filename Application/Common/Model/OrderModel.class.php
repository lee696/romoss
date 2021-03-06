<?php

namespace Common\Model;

use Think\Model;

class OrderModel extends Model {

    public function getInfo($sku)
    {
        $info = $this->find($sku);
        return $this->formatInfo($info);
    }

    public function skuExists($goods_id, $sku_name)
    {
        $condition = [];
        $condition['goods_id'] = $goods_id;
        $condition['sku_name'] = $sku_name;
        return (int) $this->where($condition)->getField('sku');
    }

    public function insert($goods_id, $sku_name, $sku_num, $pic, $img)
    {
        $data = [];
        $data['goods_id'] = $goods_id;
        $data['sku_name'] = $sku_name;
        $data['sku_num'] = $sku_num;
        $data['pic'] = json_encode($pic);
        $data['img'] = $img;
        $data['create_time'] = time();
        return (int) $this->add($data);
    }

    public function insert_test($postData)
    {
        return (int) $this->add($postData);
    }

    public function getList($filter, $order = '', $limit = null)
    {
        $res = $this->field('cm_order.*,cm_address.address,cm_address.consignee,cm_address.phone')
                        ->join('cm_address ON cm_order.address = cm_address.address_id')
                        ->where($filter)
                        ->order($order)
                        ->page($limit,5)->order('create_time desc')->select();
        //echo $this->getLastSql();
        return $res;
    }

    private function formatInfo($info)
    {
        $keys = array_keys($info);
        if (in_array('goods_id', $keys))
            $info['goods_id'] = (int) $info['goods_id'];
        if (in_array('create_time', $keys))
            $info['create_time'] = (int) $info['create_time'];
        if (in_array('is_on', $keys))
            $info['is_on'] = (int) $info['is_on'];
        if (in_array('is_del', $keys))
            $info['is_del'] = (int) $info['is_del'];
        if (in_array('order', $keys))
            $info['order'] = (int) $info['order'];
        if (in_array('price', $keys))
            $info['price'] = (float) $info['price'];
        if (in_array('market_price', $keys))
            $info['market_price'] = (float) $info['market_price'];
        if (in_array('warn_num', $keys))
            $info['warn_num'] = (int) $info['warn_num'];
        if (in_array('shipping_fee', $keys))
            $info['shipping_fee'] = (float) $info['shipping_fee'];
        if (in_array('append_fee', $keys))
            $info['append_fee'] = (float) $info['append_fee'];
        if (in_array('on_time', $keys))
            $info['on_time'] = (int) $info['on_time'];
        if (in_array('goods_label', $keys))
            $info['goods_label'] = json_decode($info['goods_label'], true);
        if (in_array('goods_service', $keys))
            $info['goods_service'] = json_decode($info['goods_service'], true);
        if (in_array('pic', $keys))
            $info['pic'] = json_decode($info['pic'], true);
        return $info;
    }

}
