<?php
namespace Wx\Controller;
use Think\Controller;
class AddressController extends BaseContoller {
    public function _initialize(){
        checkLogin();
    }
    public function index(){
        $address_id = I('address_id', 0, 'intval');
        $redirect = I('redirect', '', 'urldecode');
        $user_id = getUserId();
        $address = D('Common/Address')->getList($user_id);
        $this->assign('address_list', $address);
        $this->assign('redirect', $redirect);
        $this->assign('address_id', $address_id);
        $this->display();
    }
    public function info(){
        $user_id = getUserId();
        $redirect = I('redirect', '', 'urldecode');
        $this->assign('redirect', $redirect);
        $address_id = I('address_id', 0, 'intval');
        if($address_id){
            $address = D('Common/Address')->getInfo($address_id);
            if($address && $address['user_id'] == $user_id){
                $this->assign('address', $address);     //  权限判断
            }
        }
        $this->assign('address_id', (int)$address['address_id']);
        $this->display();
    }
    public function operation(){
        $user_id = getUserId();
        $address_id = I('address_id', 0, 'intval');
        $consignee = I('consignee', '', 'trim');
        $phone = I('phone', '', 'trim');
        $address = I('address', []);
        $is_default = I('is_default', 0, 'intval');
        if($address_id){
            $addressInfo = D('Common/Address')->getInfo($address_id);
            if($addressInfo && $addressInfo['user_id'] == $user_id){
                if(!$is_default || $address['is_default']){
                    D('Common/Address')->edit($address_id, $consignee, $phone, $address);
                }else{
                    $model = M();
                    $model->startTrans();
                    D('Common/Address')->cancelDefault($user_id);
                    D('Common/Address')->edit($address_id, $consignee, $phone, $address, 1);
                    $model->commit();
                }
                sendResult($address_id);
            }
        }
        if($is_default){
            $model = M();
            $model->startTrans();
            D('Common/Address')->cancelDefault($user_id);
            $address_id = D('Common/Address')->insert($user_id, $consignee, $phone, $address, 1);
            $model->commit();
        }else{
            $address_id = D('Common/Address')->insert($user_id, $consignee, $phone, $address);
        }
        sendResult($address_id);
    }
    public function del(){
        $user_id = getUserId();
        $address_id = I('address_id', 0, 'intval');
        if(!$address_id){
            sendError('ERROR_PARAM');
        }
        $info = D('Common/Address')->getInfo($address_id);
        if(!$info || $info['user_id'] != $user_id){
            sendError('ERROR_MASTER');
        }
        D('Common/Address')->del($address_id);
        sendResult();
    }
}