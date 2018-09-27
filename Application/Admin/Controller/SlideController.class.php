<?php
namespace Admin\Controller;
class SlideController extends BaseController {
    public function index(){
        $keywords = I('title', '', 'trim');
        $start_time = I('start_time', null, 'strtotime');
        $end_time = I('end_time', null , 'strtotime');
        $is_on = I('is_on', null, 'intval');
        $condition = [];
        if($keywords){
            $condition['title'] = ['like', "%$keywords%"];
        }
        if(isset($is_on)){
            $condition['is_on'] = $is_on;
        }
        if(isset($start_time) && isset($end_time)){
            $condition['create_time'] = ['between', [$start_time, $end_time]];
        }elseif(isset($start_time)){
            $condition['create_time'] = ['gt', $start_time];
        }elseif(isset($end_time)){
            $condition['create_time'] = ['lt', $end_time];
        }
        $count = D('Common/Slide')->getTotal($condition);
        $Page = new \Think\Page($count,C('LIST_ROWS'));
        $Page->setConfig('theme', C('PAGE_THEME'));
        $pageHtml = $Page->show();
        $list = D('Common/Slide')->getList($condition,$Page->firstRow,$Page->listRows);
        $this->assign('pageHtml',$pageHtml);
        $this->assign('total',$count);
        $this->assign('list', $list);
		$this->display();
    }
    public function info(){
        $slide_id = I('slide_id', 0, 'intval');
        if($slide_id){
            $info = D('Common/Slide')->getInfo($slide_id);
            $this->assign('info', $info);
        }
        $this->display();
    }
    public function operation(){
        $slide_id = I('slide_id', 0, 'intval');
        $title = I('title', null, 'trim');
        $img = I('img', null, 'trim');
        $link = I('link', null, 'trim');
        $is_on = I('is_on', 1, 'intval');
        if(!$title || !$img){
            sendError('ERROR_PARAM');
        }
        if($slide_id){
            $res = D('Common/Slide')->edit($slide_id, $title, $img, $link, $is_on);
            if($res){
                sendResult();
            }else{
                sendError('ERROR_NET');
            }
        }else{
            $slide_id = D('Common/Slide')->insert($title, $img, $link, $is_on);
            if($slide_id){
                sendResult($slide_id);
            }else{
                sendError('ERROR_NET');
            }
        }
    }
    public function del(){
        $slide_id = I('slide_id');
        if(!$slide_id){
            sendError('ERROR_PARAM');
        }
        if(D('Common/Slide')->del($slide_id)){
            sendResult();
        }else{
            sendError('ERROR_NET');
        }
    }
    public function setMulOrder(){
        $slideOrder = I('slide_order');
        if(!$this->checkMulOrder($slideOrder)){
            sendError('ERROR_PARAM');
        }
        $model = D('Common/Slide');
        $model->startTrans();
        foreach ($slideOrder as $slide_id => $order){
            if(!$model->setOrder($slide_id, $order)){
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