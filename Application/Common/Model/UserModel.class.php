<?php
namespace Common\Model;
use Think\Model;
class UserModel extends Model{
    public function getInfo($user_id){
        $condition = [];
        $condition['user_id'] = $user_id;
        $info = $this->where($condition)->find();
        return $this->fInfo($info);
    }
    public function accountExists($phone){
        $condition = [];
        $condition['phone'] = $phone;
        $info = $this->where($condition)->find();
        return $this->formatInfo($info);
    }
    public function checkLogin($phone, $pwd){
        $condition = [];
        $condition['phone'] = $phone;
        $condition['pwd'] = createPassword($pwd);
        $info = $this->where($condition)->find();
        return $this->formatInfo($info);
    }
    public function insert($phone, $pwd){
        $data = [];
        $data['phone'] = $phone;
        $data['nickname'] = 'YXS'.$phone;
        $data['pwd'] = createPassword($pwd);
        $data['create_time'] = time();
        return (int)$this->add($data);
    }
    public function changepwd($uid,$pwd){
       $data = array(
        	'user_id' => $uid,
        	'pwd' => createPassword($pwd),
        );
       return (int)$this->save($data);
    }
     public function getTotal($condition = []){
        $count = $this->where($condition)->count();
        return (int)$count;
    }
    public function getList($condition = [], $start = null, $length = null){
        $res = $this->where($condition)->limit($start, $length)->select();
       
        $list = [];
        foreach ($res as $v){
            $list[] = $this->fInfo($v);
        }
        return $list;
    }

    private function fInfo($info){
        $keys = array_keys($info);
        if(in_array('user_id', $keys))          $info['user_id'] = $info['user_id'];
        if(in_array('phone', $keys))          $info['phone'] = (int)$info['phone'];
        if(in_array('avatar', $keys))          $info['avatar'] = $info['avatar'];
        if(in_array('birthday', $keys))          $info['birthday'] = $info['birthday'];
        if(in_array('nickname', $keys))          $info['nickname'] = $info['nickname'];
        if(in_array('create_time', $keys))      $info['create_time'] = (int)$info['create_time'];
        if(in_array('pwd', $keys))              unset($info['pwd']);
        return $info;
    }
    private function formatInfo($info){
        $keys = array_keys($info);
        if(in_array('user_id', $keys))          $info['user_id'] = (int)$info['user_id'];
        if(in_array('create_time', $keys))      $info['create_time'] = (int)$info['create_time'];
        if(in_array('pwd', $keys))              unset($info['pwd']);
        return $info;
    }
}