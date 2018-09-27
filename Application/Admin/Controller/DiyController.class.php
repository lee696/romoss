<?php
namespace Admin\Controller;

class DiyController extends BaseController{
  public function cmpicture(){
        $keywords = I('title', '', 'trim');
        $start_time = I('start_time', null, 'strtotime');
        $end_time = I('end_time', null , 'strtotime');
        $condition = [];
        if($keywords){
            $condition['title'] = ['like', "%$keywords%"];
        }
        if(isset($is_on)){
            $condition['is_on'] = $is_on;
        }
        if(isset($start_time) && isset($end_time)){
            $condition['add_time'] = ['between', [$start_time, $end_time]];
        }elseif(isset($start_time)){
            $condition['add_time'] = ['gt', $start_time];
        }elseif(isset($end_time)){
            $condition['add_time'] = ['lt', $end_time];
        }
        $count = D('cmpicture')->where($condition)->count();
        $Page = new \Think\Page($count,C('LIST_ROWS'));
        $Page->setConfig('theme', C('PAGE_THEME'));
        $pageHtml = $Page->show();
        $list = M('cmpicture')->where($condition)->limit($Page->firstRow,$Page->listRows)->select();
        foreach ($list as $k=>$v){
          $list[$k]['pname']=M('cmpicturetype')->where(['id'=>$list[$k]['pid']])->getField('name');
        }
        $this->assign('pageHtml',$pageHtml);
        $this->assign('total',$count);
        $this->assign('list', $list);
        $this->display();
  }
  public function cmpicturetype(){
    $keywords = I('title', '', 'trim');
        $start_time = I('start_time', null, 'strtotime');
        $end_time = I('end_time', null , 'strtotime');
        $condition = [];
        if($keywords){
            $condition['name'] = ['like', "%$keywords%"];
        }
        if(isset($start_time) && isset($end_time)){
            $condition['add_time'] = ['between', [$start_time, $end_time]];
        }elseif(isset($start_time)){
            $condition['add_time'] = ['gt', $start_time];
        }elseif(isset($end_time)){
            $condition['add_time'] = ['lt', $end_time];
        }
        $count = D('cmpicturetype')->where($condition)->count();
        $Page = new \Think\Page($count,C('LIST_ROWS'));
        $Page->setConfig('theme', C('PAGE_THEME'));
        $pageHtml = $Page->show();
        $list = M('cmpicturetype')->where($condition)->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign('pageHtml',$pageHtml);
        $this->assign('total',$count);
        $this->assign('list', $list);
    $this->display();
  }
  
  public function addcmptype(){
    if(IS_POST){
       $id = I('id', 0, 'intval');
        $name = I('name', null, 'trim');
        $img = I('pic', null, 'trim');
        if(!$name || !$img){
            sendError('ERROR_PARAM');
        }
        if($id){
            $res =M('cmpicturetype')->where(['id'=>$id])->save([ 'name'=>$name, 'pic'=>$img]);
            if($res){
                sendResult();
            }else{
                sendError('ERROR_NET');
            }
        }else{
            $slide_id = M('cmpicturetype')->add([ 'name'=>$name, 'pic'=>$img,'add_time'=>  time()]);
            if($slide_id){
                sendResult($slide_id);
            }else{
                sendError('ERROR_NET');
            }
        }
  }else{
    $condition['id']=I('id');
    $list = M('cmpicturetype')->where($condition)->find();
    $this->assign('info', $list);
    $this->display();
  }
  
    }
     public function delcmptype(){
        $slide_id = I('id');
        if(!$slide_id){
            sendError('ERROR_PARAM');
        }
        $ret=M('cmpicturetype')->where(['id'=>array('in',$slide_id)])->delete();
        if($ret){
            sendResult();
        }else{
            sendError('ERROR_NET');
        }
    }
  public function addcmp(){
    if(IS_POST){
       $id = I('id', 0, 'intval');
        $name = I('name', null, 'trim');
        $img = I('pic', null, 'trim');
        $price = I('price', null, 'trim');
        $pid = I('pid', 1, 'intval');
        if(!$name || !$img){
            sendError('ERROR_PARAM');
        }
        if($id){
            $res =M('cmpicture')->where(['id'=>$id])->save([ 'name'=>$name, 'pic'=>$img, 'pid'=>$pid, 'price'=>$price]);
            if($res){
                sendResult();
            }else{
                sendError('ERROR_NET');
            }
        }else{
            $slide_id = M('cmpicture')->add([ 'name'=>$name, 'pic'=>$img, 'pid'=>$pid, 'price'=>$price,'add_time'=>  time()]);
            if($slide_id){
                sendResult($slide_id);
            }else{
                sendError('ERROR_NET');
            }
        }
  }else{
    $condition['id']=I('id');
    $list = M('cmpicture')->where($condition)->find();
    $type=M("cmpicturetype")->select();
    $this->assign('info', $list);
    $this->assign('a', $type);
    $this->display();
  }
  
    }
     public function delcmp(){
        $slide_id = I('id');
        if(!$slide_id){
            sendError('ERROR_PARAM');
        }
        $ret=M('cmpicture')->where(['id'=>array('in',$slide_id)])->delete();
        if($ret){
            sendResult();
        }else{
            sendError('ERROR_NET');
        }
    }
    /*
     * 质材类型管理
     */
   public function materialtype(){
    $keywords = I('title', '', 'trim');
        $start_time = I('start_time', null, 'strtotime');
        $end_time = I('end_time', null , 'strtotime');
        $condition = [];
        if($keywords){
            $condition['name'] = ['like', "%$keywords%"];
        }
        if(isset($start_time) && isset($end_time)){
            $condition['add_time'] = ['between', [$start_time, $end_time]];
        }elseif(isset($start_time)){
            $condition['add_time'] = ['gt', $start_time];
        }elseif(isset($end_time)){
            $condition['add_time'] = ['lt', $end_time];
        }
        $count = D('materialtype')->where($condition)->count();
        $Page = new \Think\Page($count,C('LIST_ROWS'));
        $Page->setConfig('theme', C('PAGE_THEME'));
        $pageHtml = $Page->show();
        $list = M('materialtype')->where($condition)->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign('pageHtml',$pageHtml);
        $this->assign('total',$count);
        $this->assign('list', $list);
    $this->display();
  }
  
  public function addmaterialtype(){
    if(IS_POST){
       $id = I('id', 0, 'intval');
        $name = I('name', null, 'trim');
        $img = I('pic', null, 'trim');
        if(!$name || !$img){
            sendError('ERROR_PARAM');
        }
        if($id){
            $res =M('materialtype')->where(['id'=>$id])->save([ 'name'=>$name, 'pic'=>$img]);
            if($res){
                sendResult();
            }else{
                sendError('ERROR_NET');
            }
        }else{
            $slide_id = M('materialtype')->add([ 'name'=>$name, 'pic'=>$img,'add_time'=>  time()]);
            if($slide_id){
                sendResult($slide_id);
            }else{
                sendError('ERROR_NET');
            }
        }
  }else{
    $condition['id']=I('id');
    $list = M('materialtype')->where($condition)->find();
    $this->assign('info', $list);
    $this->display();
  }
  
    }
     public function delmaterialtype(){
        $slide_id = I('id');
        if(!$slide_id){
            sendError('ERROR_PARAM');
        }
        $ret=M('materialtype')->where(['id'=>array('in',$slide_id)])->delete();
        if($ret){
            sendResult();
        }else{
            sendError('ERROR_NET');
        }
    }
    /*
     * 质材管理
     */
    public function material(){
    $keywords = I('title', '', 'trim');
        $start_time = I('start_time', null, 'strtotime');
        $end_time = I('end_time', null , 'strtotime');
        $condition = [];
        if($keywords){
            $condition['title'] = ['like', "%$keywords%"];
        }
        if(isset($is_on)){
            $condition['is_on'] = $is_on;
        }
        if(isset($start_time) && isset($end_time)){
            $condition['add_time'] = ['between', [$start_time, $end_time]];
        }elseif(isset($start_time)){
            $condition['add_time'] = ['gt', $start_time];
        }elseif(isset($end_time)){
            $condition['add_time'] = ['lt', $end_time];
        }
        $count = D('material')->where($condition)->count();
        $Page = new \Think\Page($count,C('LIST_ROWS'));
        $Page->setConfig('theme', C('PAGE_THEME'));
        $pageHtml = $Page->show();
        $list = M('material')->where($condition)->limit($Page->firstRow,$Page->listRows)->select();
        foreach ($list as $k=>$v){
          $list[$k]['pname']=M('materialtype')->where(['id'=>$list[$k]['pid']])->getField('name');
        }
        $this->assign('pageHtml',$pageHtml);
        $this->assign('total',$count);
        $this->assign('list', $list);
    $this->display();
  }
  
  public function addmaterial(){
    if(IS_POST){
       $id = I('id', 0, 'intval');
        $name = I('name', null, 'trim');
        $img = I('pic', null, 'trim');
        $price = I('price', null, 'trim');
        $pid = I('pid', 1, 'intval');
        if(!$name || !$img){
            sendError('ERROR_PARAM');
        }
        if($id){
            $res =M('cmpicture')->where(['id'=>$id])->save([ 'name'=>$name, 'pic'=>$img, 'pid'=>$pid, 'price'=>$price]);
            if($res){
                sendResult();
            }else{
                sendError('ERROR_NET');
            }
        }else{
            $slide_id = M('cmpicture')->add([ 'name'=>$name, 'pic'=>$img, 'pid'=>$pid, 'price'=>$price,'add_time'=>  time()]);
            if($slide_id){
                sendResult($slide_id);
            }else{
                sendError('ERROR_NET');
            }
        }
  }else{
    $condition['id']=I('id');
    $list = M('material')->where($condition)->find();
    $type=M("materialtype")->select();
    $this->assign('info', $list);
    $this->assign('a', $type);
    $this->display();
  }
  
    }
     public function delmaterial(){
        $slide_id = I('id');
        if(!$slide_id){
            sendError('ERROR_PARAM');
        }
        $ret=M('material')->where(['id'=>array('in',$slide_id)])->delete();
        if($ret){
            sendResult();
        }else{
            sendError('ERROR_NET');
        }
    }
    /*
     * 装备管理
     */
    public function equipment(){
        $keywords = I('title', '', 'trim');
        $start_time = I('start_time', null, 'strtotime');
        $end_time = I('end_time', null , 'strtotime');
        $condition = [];
        if($keywords){
            $condition['title'] = ['like', "%$keywords%"];
        }
        if(isset($is_on)){
            $condition['is_on'] = $is_on;
        }
        if(isset($start_time) && isset($end_time)){
            $condition['add_time'] = ['between', [$start_time, $end_time]];
        }elseif(isset($start_time)){
            $condition['add_time'] = ['gt', $start_time];
        }elseif(isset($end_time)){
            $condition['add_time'] = ['lt', $end_time];
        }
        $count = D('equipment')->where($condition)->count();
        $Page = new \Think\Page($count,C('LIST_ROWS'));
        $Page->setConfig('theme', C('PAGE_THEME'));
        $pageHtml = $Page->show();
        $list = M('equipment')->where($condition)->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign('pageHtml',$pageHtml);
        $this->assign('total',$count);
        $this->assign('list', $list);
        $this->display();
  }
  public function addequipment(){
    if(IS_POST){
       $id = I('id', 0, 'intval');
        $name = I('name', null, 'trim');
        $img = I('pic', null, 'trim');
        $price = I('price', null, 'trim');
        $pid = I('pid', 1, 'intval');
        if(!$name || !$img){
            sendError('ERROR_PARAM');
        }
        if($id){
            $res =M('equipment')->where(['id'=>$id])->save([ 'name'=>$name, 'pic'=>$img, 'pid'=>$pid, 'price'=>$price]);
            if($res){
                sendResult();
            }else{
                sendError('ERROR_NET');
            }
        }else{
            $slide_id = M('equipment')->add([ 'name'=>$name, 'pic'=>$img, 'pid'=>$pid, 'price'=>$price,'add_time'=>  time()]);
            if($slide_id){
                sendResult($slide_id);
            }else{
                sendError('ERROR_NET');
            }
        }
  }else{
    $condition['id']=I('id');
    $list = M('equipment')->where($condition)->find();
    $this->assign('info', $list);
    $this->display();
  }
  }
}

