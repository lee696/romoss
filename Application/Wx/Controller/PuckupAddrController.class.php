<?php

namespace Wx\Controller;

use Think\Controller;

class PuckupAddrController extends BaseContoller {

    public function index()
    {
        $address_id = I('address_id', 0, 'intval');
        $redirect = I('redirect', '', 'urldecode');
        $user_id = getUserId();
        $address = D('Common/Address')->getpickList();
        $this->assign('address_list', $address);
        $this->assign('redirect', $redirect);
        $this->assign('address_id', $address_id);
        $this->display();
    }
}

