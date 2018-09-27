<?php
namespace Common\Model;
use Think\Model;
class AddressModel extends Model{
    public function insert($user_id, $consignee, $phone, $address, $is_default = 0){
        $data = [];
        $data['user_id'] = $user_id;
        $data['consignee'] = $consignee;
        $data['phone'] = $phone;
        $data['address'] = json_encode($address);
        $data['is_default'] = $is_default;
        $data['create_time'] = time();
        return (int)$this->add($data);
    }
    public function edit($address_id, $consignee, $phone, $address, $is_default = null){
        $condition = [];
        $condition['address_id'] = $address_id;
        $data = [];
        $data['consignee'] = $consignee;
        $data['phone'] = $phone;
        $data['address'] = json_encode($address);
        if(isset($is_default)){
            $data['is_default'] = $is_default;
        }
        return $this->where($condition)->save($data) !== false;
    }
    public function del($address_id){
        return $this->where(['address_id' => $address_id])->delete() !== false;
    }

    public function cancelDefault($user_id){
        $condition = [];
        $condition['user_id'] = $user_id;
        $data = [];
        $data['is_default'] = 0;
        return  $this->where($condition)->save($data);
    }
    public function getInfo($address_id){
        $condition = [];
        $condition['address_id'] = $address_id;
        $info = $this->where($condition)->find();
        return $this->formatInfo($info);
    }
    public function getDefault($user_id){
        $condition = [];
        $condition['user_id'] = $user_id;
        $info = $this->where($condition)->order(['is_default' => 'desc', 'create_time' => 'desc'])->find();
        return $this->formatInfo($info);
    }
    public function getList($user_id){
        $condition = [];
        $condition['user_id'] = $user_id;
        $res = $this->where($condition)->order(['is_default' => 'desc', 'create_time' => 'desc'])->select();
        $list = [];
        foreach ($res as $v){
            $list[] = $this->formatInfo($v);
        }
        return $list;
    }
    public function getpickList(){
        $condition = [];
        $condition['type'] = 2;
        $res = $this->where($condition)->order(['create_time' => 'desc'])->select();
        $list = [];
        foreach ($res as $v){
            $list[] = $this->formatInfo($v);
        }
        return $list;
    }
    private function formatInfo($info){
        $keys = array_keys($info);
        if(in_array('address_id', $keys))           $info['address_id'] = (int)$info['address_id'];
        if(in_array('create_time', $keys))          $info['create_time'] = (int)$info['create_time'];
        if(in_array('user_id', $keys))              $info['user_id'] = (int)$info['user_id'];
        if(in_array('is_default', $keys))           $info['is_default'] = (int)$info['is_default'];
        if(in_array('address', $keys))              $info['address'] = json_decode($info['address'], true);
        return $info;
    }
}