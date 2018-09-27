<?php
$lang = [
    'ERROR_NET'         =>  '网络繁忙',
    'ERROR_PARAM'       =>  '参数错误',
    'ERROR_NO_TAIL'     =>  '未查询到指定信息',
    'ERROR_MASTER'      =>  '您没有权限执行此操作',
    'ERROR_NO_LOGIN'    =>  '请登录',
    'ERROR_VALID_CODE'  =>  '验证码错误',
    'ERROR_ACCOUNT_PWD' =>  '账号或密码错误',
    'ERROR_NO_ACCOUNT'  =>  '该账号未注册',
    'ERROR_ACCOUNT_EXISTS'  =>  '该账号已存在',
    'ERROR_DISTANCE_GOODS_NUM'  =>  '商品货号已存在',
    'ERROR_DISTINCT_ORDER'      =>  '请勿重复下单',
    'ERROR_ORDER_STATUS'    =>  '不允许跨状态操作'
];
$lang['ERROR_CODE'] = [
    '1.0'       =>  [
        'success'               =>  0,
        'default'               =>  4000,
        $lang['ERROR_NET']      =>  4001,
        $lang['ERROR_PARAM']    =>  4002,
        $lang['ERROR_NO_TAIL']  =>  4003,
        $lang['ERROR_MASTER']   =>  4004,
        $lang['ERROR_NO_LOGIN'] =>  4005,
        $lang['ERROR_DISTINCT_ORDER']   =>  4006,
        $lang['ERROR_ORDER_STATUS']     =>  4007
    ]
];
return $lang;