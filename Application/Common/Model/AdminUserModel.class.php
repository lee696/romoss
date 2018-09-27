<?php
namespace Common\Model;
use Think\Model;
class AdminUserModel extends Model{

    private function formatInfo($info){
        $keys = array_keys($info);
        if(in_array('user_id', $keys))          $info['user_id'] = (int)$info['user_id'];
        if(in_array('ays_user_id', $keys))      $info['ays_user_id'] = (int)$info['ays_user_id'];
        if(in_array('create_time', $keys))      $info['create_time'] = (int)$info['create_time'];
        if(in_array('status', $keys))           $info['status'] = (int)$info['status'];
        return $info;
    }
}