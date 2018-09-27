<?php

namespace Wx\Controller;

use Think\Controller;
use EasyWeChat\Payment\Order;
use EasyWeChat\Foundation\Application;

class OrderController extends BaseContoller {

  public function index() {
    checkLogin();
    $user_id = getUserId();
    $type = I('type', 1, 'intval'); //0 全部 1 待付款 2待收货 4 待评价 6 已完成
    switch ($type) {
      case 1:
        $status = 'and cm_order.status = 1';
        break;
      case 2:
        $status = 'and cm_order.status in (2,3)';
        break;
      case 4:
        $status = 'and cm_order.status = 4';
        break;
      case 6:
        $status = 'and cm_order.status = 6';
        break;
      default:
        $status = '';
        $type = 0;
        break;
    }
//        var_dump(I('page'));die;
    $filter = "cm_order.user_id ={$user_id} {$status} ";
    $list = D('Common/Order')->getList($filter, '', I('page', 1));
    foreach ($list as $i => $value) {
      $list[$i]['address'] = json_decode($value['address'], true);
      $skus = D('Common/Cart')->where($value['order_id'])->select();
      $goods = D('Common/Goods')->where(['goods_id' => $value['goods_id']])->find();
//      switch ($list[$i]['status']) {
//        case 1:
//          $list[$i]['status']='等待买家付款';
//          break;
//        case 2:
//          $list[$i]['status']='已付款，等待发货';
//          break;
//        case 3:
//          $list[$i]['status']='已发货';
//          break;
//        case 4:
//          $list[$i]['status']='已收货';
//          break;
//        case 5:
//          $list[$i]['status']='已取消';
//          break;
//        case 6:
//          $list[$i]['status']='已完成';
//          break;
//        
//        default:
//           $list[$i]['status']='未知';
//      }
//            foreach ($skus as $j => $_value) {
//                $info = D('Common/Sku')->getGoodsInfo($_value['sku']);
//                $info['buy_num'] = $_value['num'];
//                $goods[] = $info;
//            }
      $list[$i]['goods'] = $goods;
    }
    if (IS_AJAX) {
      sendResult($list);
    }

    $data = [];
    $data['list'] = $list;
    $data['type'] = $type;
    $this->assign('data', $data);
    $this->display();
  }

  public function details() {
    checkLogin();
    $user_id = getUserId();
    $oid = I('oid');
    $info = M("order")->where(['order_id' => $oid, 'user_id' => $user_id])->find();
    $express=M('express')->Field('name,code')->find($info['expresscode']);
    $address = M('address')->find($info['address']);
    $addlsit = json_decode($address['address'], true);
    $info['address'] = $addlsit['prov'] . $addlsit['city'] . $addlsit['region'].$addlsit['area'];
    $info['consignee'] = $address['consignee'];
    $info['phone'] = $address['phone'];
    if($info['goods_type']==2){
      $info['goods'] = M('works')->join('cm_cmpicture on cm_works.cmpicture=cm_cmpicture.id')->where(['cm_works.id'=>$info['goods_id']])->field('cm_cmpicture.pic,cm_works.name,cm_works.price')->find();
      $info['goods']['goods_img']=$info['goods']['pic'];
      $info['goods']['goods_name']=$info['goods']['name'];
    }else{
      $info['goods'] = M('sku')->join('cm_goods on cm_sku.goods_id=cm_goods.goods_id')->find($info['sku']);
    }
    $this->assign('express', $express);
    $this->assign('info', $info);
    $this->display();
  }

  public function paytype() {
    checkLogin();
    $user_id = getUserId();
    $oid = I('oid');
    $info = M("order")->where(['order_id' => $oid, 'user_id' => $user_id])->find();
    //dump($info);exit();
    $this->assign('info', $info);
    $this->display();
  }

  public function paysucceed() {
    checkLogin();
    $user_id = getUserId();
    $oid = I('oid');
//    M("order")->where(['order_id' => $oid, 'user_id' => $user_id])->save(['pay_time'=>  time(),'status'=>2]);
    $info = M("order")->where(['order_id' => $oid, 'user_id' => $user_id])->find();
    $address = M('address')->find($info['address']);
    $addlsit = json_decode($address['address'], true);
    $info['address'] = $addlsit['prov'] . $addlsit['city'] . $addlsit['region'].$addlsit['area'];
    $info['consignee'] = $address['consignee'];
    $info['phone'] = $address['phone'];
    $this->assign('info', $info);
    $this->display();
  }

  public function buySoon() {
    checkLogin();
    $sku = I('sku', 0, 'intval');
    $num = I('num', 1, 'intval');
    $diyid = I('diyid', 0, 'intval');
    $address_id = I('address_id', 0, 'intval');
    $shipping_type = I('shipping_type', 0, 'intval');

    if ($diyid) {
      $goodsInfo = M('works')->field('name as goods_name,price,cmpicture')->find($diyid);
      $goodsInfo['shipping_fee'] = 10;
      $goodsInfo['append_fee'] = 2;
      $skuInfo['img'] = M('cmpicture')->where(['id' => $goodsInfo['cmpicture']])->getField('pic');
      $skuInfo['sku'] = 0;
      $skuInfo['sku_num'] = 10;

      $this->assign('diyid', $diyid);
    } else {
      $this->assign('diyid', 0);
      if ($sku < 1 || $num < 1) {
        $this->error('参数错误');
      }
      $skuInfo = D('Common/Sku')->getInfo($sku);
      if ($skuInfo['status'] != 1) {
        $this->error('商品已下架');
      }
      if ($skuInfo['sku_num'] < $num) {
        $this->error('商品库存不足');
      }
      $goodsInfo = D('Common/Goods')->getInfo($skuInfo['goods_id']);
      if (!$goodsInfo || $goodsInfo['is_on'] != 1 || $goodsInfo['is_del']) {
        $this->error('商品已下架');
      }
    }
    $user_id = getUserId();
    if ($address_id) {
      $address = D('Common/Address')->getInfo($address_id);
      if($shipping_type!=2){
       if (!$address || $address['user_id'] != $user_id) {
        $address = D('Common/Address')->getDefault($user_id);
      } 
      }
//      var_dump($address);die;
    } else {
      $address = D('Common/Address')->getDefault($user_id);
    }
    
    $this->assign('address', $address);
    $this->assign('sku', $skuInfo);
    $this->assign('goods', $goodsInfo);
    $this->assign('num', $num);
    $this->assign('address_id', (int) $address['address_id']);
    $this->display();
  }

  public function createBuySoon() {
    //以下代码仅为测试演试专用，非正式代码
    $param = array(
        'sku' => I('sku', ''),
        'num' => I('num', 0, 'intval'),
        'address_id' => I('address_id', 0, 'intval'),
        'shipping_fee'=>I('shipping_fee',0,'intval'),
    );
    $shipping_type=I('shipping_type', 1, 'intval');
    $diyid = I('diyid', 0, 'intval');
    $address = D('Common/Address')->getInfo($param['address_id']);
    if(!$address){
      $data['status']=1;
      $data['content']='请填写收货地址';
      $this->ajaxReturn($data);
    }
    if ($diyid) {
      $goodinfo = M('works')->field('name as goods_name,price,cmpicture')->find($diyid);
      $insert_data = array(
          'order_num' => time() . $_SESSION['user_login_data']['user_id'],
          'user_id' => $_SESSION['user_login_data']['user_id'],
          'goods_fee' => $goodinfo['price'] * $param['num'],
          'price' => $goodinfo['price'] * $param['num'] + $param['shipping_fee'] + $param['num'] * 2 - 2,
          'shipping_fee' => $param['shipping_fee'],
          'shipping_type' =>$shipping_type ,
          'goods_num' => $param['num'],
          'address' => $param['address_id'],
          'create_time' => time(), //date('Y-m-d h:i:s', time()),
          'sku' => $param['sku'],
          'mark' => I('mark', '', 'trim'),
          'goods_id' => $diyid,
          'goods_type' => 2,
          'status' => 1, //1：未付款,2：已付款,3：已发货,4：已收货,5：已取消,6：已评价 (建议定为常量)
      );
    } else {
      $sukinfo = M('sku')->find($param['sku']);
      $goodinfo = M('goods')->find($sukinfo['goods_id']);
      //print_r($para);
      $insert_data = array(
          'order_num' => time() . $_SESSION['user_login_data']['user_id'],
          'user_id' => $_SESSION['user_login_data']['user_id'],
          'goods_fee' => $goodinfo['price'] * $param['num'],
          'price' => $goodinfo['price'] * $param['num'] + $param['shipping_fee'] + $param['num'] * 2 - 2,
          'shipping_fee' => $param['shipping_fee'],
          'shipping_type' =>$shipping_type ,
          'goods_num' => $param['num'],
          'address' => $param['address_id'],
          'create_time' => time(),
          'sku' => $param['sku'],
          'mark' => I('mark', '', 'trim'),
          'goods_id' => $sukinfo['goods_id'],
          'status' => 1, //1：未付款,2：已付款,3：已发货,4：已收货,5：已取消,6：已评价 (建议定为常量)
      );
    }
    try {
      $model = M();
      $order_id = D('Common/Order')->insert_test($insert_data);
      if ($order_id) {
        M('sku')->where(['sku' => $param['sku']])->setDec('sku_num', $param['num']);
      }
      $model->commit();
      sendResult($order_id);
    } catch (Exception $e) {
      //这里要做事物回滚。。。
      echo $e->getMessage();
    }
  }

  public function cancel() {
    checkLogin();
    $oid = I('oid');
    $info = M('order')->find($oid);
    if ($info['status'] != 1) {
      echo"<script> alert('只有未支付订单才能取消');window.history.go(-1);</script>";
      die;
    }
    $ret = M('order')->where(['order_id' => $oid])->save(['status' => 5]);
    if ($ret) {
      $url = U('Order/index', array('type' => 0));
      echo"<script> alert(' 取消成功');window.location.href='$url'</script>";
    } else {
      echo"<script> alert(' 取消失败');window.location.href=document.referrer</script>";
    }
  }

  /*
   * 
   */

  public function confirm() {
    checkLogin();
    $oid = I('oid');
    $info = M('order')->find($oid);
    if ($info['status'] != 3) {
      echo"<script> alert('只有发货订单才能收货');window.history.go(-1);</script>";
      die;
    }
    $ret = M('order')->where(['order_id' => $oid])->save(['status' => 4]);
    if ($ret) {
      $url = U('Order/index', array('type' => 0));
      echo"<script> alert(' 收货成功');window.location.href='$url'</script>";
    } else {
      echo"<script> alert(' 收货失败');window.location.href=document.referrer</script>";
    }
  }

  public function del() {
    checkLogin();
    $oid = I('oid');
    $info = M('order')->find($oid);
    if ($info['status'] == 5 || $info['status'] == 6) {
      $ret = M('order')->delete($oid);
      if ($ret) {
        $url = U('Order/index', array('type' => 0));
        echo"<script> alert(' 删除成功');window.location.href='$url'</script>";
      } else {
        echo"<script> alert(' 删除失败');window.location.href=document.referrer</script>";
      }
    } else {
      echo"<script> alert('该状态下订单无法删除');;window.location.href=document.referrer</script>";
      die;
    }
  }
  public function logistics(){
        //参数设置
//    key:MDnLAWFc8731
//
//  （2）customer :8D8B4275ABF1D0DFC73B3E9B81673828
    $oid = I('oid');
    $info=M('order')->Field('expresscode,expressno')->find($oid);
    $express=M('express')->Field('name,code')->find($info['expresscode']);
    $post_data = array();
    $post_data["customer"] = '8D8B4275ABF1D0DFC73B3E9B81673828';
    $key= 'MDnLAWFc8731' ;
    $post_data["param"] = '{"com":"'.$express['code'].'","num":"'.$info['expressno'].'","from":"","to":""}';
    $url='https://poll.kuaidi100.com/poll/query.do';
    $post_data["sign"] = md5($post_data["param"].$key.$post_data["customer"]);
    $post_data["sign"] = strtoupper($post_data["sign"]);
    $o="";
    
    $post_data=  http_build_query($post_data);
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST ,false);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $result = curl_exec($ch);
        $data = str_replace("\"",'"',$result );
        $data = json_decode($data,true);
        $this->assign('data', $data);
        $this->assign('express', $express);
        $this->display();
  }

  public function evaluate() {
    checkLogin();
    $user_id = getUserId();
    $oid = I('oid');
    M("order")->where(['order_id' => $oid, 'user_id' => $user_id])->save(['pay_time'=>  time(),'status'=>4]);
    $info = M("order")->where(['order_id' => $oid, 'user_id' => $user_id])->find();
    $info['goods'] = M('sku')->join('cm_goods on cm_sku.goods_id=cm_goods.goods_id')->find($info['sku']);
    if (IS_POST) {
      $data = $_POST;
      $data['user_id'] = $user_id;
      $data['goods_id'] = $info['goods']['goods_id'];
      $data['sku'] = $info['sku'];
      $data['pic'] = join(',', $_POST['img']);
      $data['create_time'] = time();
      $ret = M('comment')->add($data);
      if ($ret) {
        M('order')->where(['order_id' => $oid])->save(['status' => 6]);
        $url = U('Order/index', array('type' => 0));
        echo"<script> alert(' 评论成功');window.location.href='$url'</script>";
      } else {
        echo"<script> alert(' 评论失败');window.location.href=document.referrer</script>";
      }
    } else {

      $this->assign('info', $info);
      $this->display();
    }
  }

  public function uploadPicture() {
    //TODO: 用户登录检测

    /* 返回标准数据 */
    $return = array('status' => 1, 'info' => '上传成功', 'data' => '');

    /* 调用文件上传组件上传文件 */
    $Picture = D('Common/Picture');
    $pic_driver = C('PICTURE_UPLOAD_DRIVER');
    $info = $Picture->upload(
            $_FILES, C('PICTURE_UPLOAD'), C('PICTURE_UPLOAD_DRIVER'), C("UPLOAD_{$pic_driver}_CONFIG")
    ); //TODO:上传到远程服务器

    /* 记录图片信息 */
    if ($info) {
      $return['status'] = 1;
      $return = array_merge($info['file'], $return);
    } else {
      $return['status'] = 0;
      $return['info'] = $Picture->getError();
    }
    /* 返回JSON数据 */
    $this->ajaxReturn($return);
  }

  public function buydiy() {
    checkLogin();
    $user_id = getUserId();
    $data = $_POST;
    $data['user_id'] = $user_id;
    $cmp = M('cmpicture')->where(['id' => $data['cmpicture']])->getField('price');
    $materialp = M('material')->where(['id' => $data['material']])->getField('price');
    $stickerp = M('sticker')->where(['id' => $data['sticker']])->getField('price');
    $equipmentp = M('equipment')->where(['id' => $data['equipment']])->getField('price');
    $data['price'] = 199 + $cmp + $stickerp + $materialp + $equipmentp;
    $info = M('works')->where($data)->find();
    if ($info) {
      $ret = $info['id'];
    } else {
      $data['name'] = 'dyi' . time();
      $data['add_time'] = time();
      $ret = M('works')->add($data);
    }
    $this->redirect(U('Order/buySoon', array('diyid' => $ret)));
  }

  public function pay() {

    /**
     * 发起微信支付
     * 1.获取order_id
     * 2.根据order_id获取订单信息
     * 3.根据订单信息构建支付订单
     * 4.生成支付参数
     */
    $order_id = I('get.oid', 0, 'intval');

    $Order = M("Order");
    $order_info = $Order->where("order_id={$order_id}")->find();
    if (!isset($order_info['order_id'])) {
      $this->error("参数错误");
    }

    $app = new Application(C('wx_options'));
    $payment = $app->payment;



    $user = $_SESSION['wechat_user'];

    $attributes = [
        'trade_type' => 'JSAPI', // JSAPI，NATIVE，APP...
        'body' => '优选师',
        'detail' => '优选师',
        'out_trade_no' => $order_info['order_num'],
//        'total_fee' => $order_info['price'] * 100, // 单位：分  
         'total_fee' =>1,
        'openid' => $user['id'], // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
    ];
    $order = new Order($attributes);

    $result = $payment->prepare($order);
//    dump($result);exit();
    if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
      $prepayId = $result->prepay_id;
      //WeixinJSBridge:
      $json = $payment->configForPayment($prepayId);
      //支付成功跳转地址
      $return_url = "/Order/paysucceed/oid/$order_id.html";
      $pay_str = <<<STR
    <script type="text/javascript" id='global_wxmp_script'>
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
                        {$json},
			function(res){
				//WeixinJSBridge.log(res.err_msg);
				//alert(res.err_code+" "+res.err_desc+" "+res.err_msg);
                                if(res.err_msg=='get_brand_wcpay_request:cancel'){
                                    //取消支付
                                    //alert('用户取消支付');
                                }else if(res.err_msg=='get_brand_wcpay_request:ok'){
                                    //支付成功
                                    //alert('支付成功');                                    
                                    window.location.href="{$return_url}";
                                }
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}                        
        callpay();//马上调用微信支付
	</script>
STR;
      $return_data = ['pay_str' => $pay_str, 'len' => strlen($pay_str)];
//      sendResult($return_data);
      $this->assign('return_url', $return_url);
      $this->assign('total_fee', $order_info['price']);
      $this->assign('json', $json);
      $this->display('weixinPay');
    }
  }
  
  public function wxreturn(){
    $msg = array();
    $postStr = file_get_contents('php://input');
    
    $msg = (array) simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
    M('notitylog')->add(['data'=>  json_encode($msg,TRUE)]);
    if($msg['return_code']=='SUCCESS'){
      $info=M('Order')->where(['order_num' => $msg['out_trade_no']])->find();
      if($info['shipping_type']==2){
      $ordercode=$info['user_id'].time().rand(1000, 9999);
    }
      M('Order')->where(['order_num' => $msg['out_trade_no']])->save(['trade_no' => $msg['transaction_id'], 'status' => 2, 'paytype' => 'wxpay','order_code'=>$ordercode,]);
      $re['return_code'] = 'SUCCESS';
      $re['return_msg'] = 'OK';
      echo $this->ToXml($re);
    }else{
      $re['return_code'] = 'FAIL';
      $re['return_msg'] = '订单信息错误';
      echo $this->ToXml($re);
    }
    
  }
  /**
   * 输出xml字符
   * @throws WxPayException
   * */
  public function ToXml($data) {
    if (!is_array($data) || count($data) <= 0) {
      throw new WxPayException("数组数据异常！");
    }

    $xml = "<xml>";
    foreach ($data as $key => $val) {
      if (is_numeric($val)) {
        $xml.="<" . $key . ">" . $val . "</" . $key . ">";
      } else {
        $xml.="<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
      }
    }
    $xml.="</xml>";
    return $xml;
  }

}
