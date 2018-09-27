<?php
namespace Common\Model;
use Think\Model;
class SlideModel extends Model{
    public function getInfo($slide_id){
        $condition = [];
        $condition['is_del'] = 0;
        $condition['slide_id'] = $slide_id;
        return $this->formatInfo($this->where($condition)->find());
    }
    public function insert($title, $img, $link, $is_on){
        $data = [];
        $data['title'] = $title;
        $data['img'] = $img;
        $data['link'] = $link;
        $data['is_on'] = $is_on;
        $data['create_time'] = time();
        $data['order'] = time();
        return (int)$this->add($data);
    }
    public function edit($slide_id, $title, $img, $link, $is_on){
        $data = [];
        $data['slide_id'] = $slide_id;
        $data['title'] = $title;
        $data['img'] = $img;
        $data['link'] = $link;
        $data['is_on'] = $is_on;
        return $this->save($data) !== false;
    }
    public function del($slide_id){
        $condition = [];
        if(is_array($slide_id)){
            $condition['slide_id'] = ['in', $slide_id];
        }else{
            $condition['slide_id'] = $slide_id;
        }
        $data = [];
        $data['is_del'] = 1;
        return $this->where($condition)->save($data) !== false;
    }
    public function setOrder($slide_id, $order){
        $condition = [];
        $condition['slide_id'] = $slide_id;
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
        if(in_array('slide_id', $keys))         $info['slide_id'] = (int)$info['slide_id'];
        if(in_array('create_time', $keys))      $info['create_time'] = (int)$info['create_time'];
        if(in_array('is_on', $keys))            $info['is_on'] = (int)$info['is_on'];
        if(in_array('is_del', $keys))           $info['is_del'] = (int)$info['is_del'];
        if(in_array('order', $keys))            $info['order'] = (int)$info['order'];
        return $info;
    }
}