<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>罗马仕</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <!-- uc强制竖屏 -->
    <meta name="screen-orientation" content="portrait">
    <!-- QQ强制竖屏 -->
    <meta name="x5-orientation" content="portrait">
    <!-- UC强制全屏 -->
    <meta name="full-screen" content="yes">
    <!-- QQ强制全屏 -->
    <meta name="x5-fullscreen" content="true">
    <!-- UC应用模式 -->
    <meta name="browsermode" content="application">
    <!-- QQ应用模式 -->
    <meta name="x5-page-mode" content="app">
    <!-- windows phone 点击无高光 -->
    <meta name="msapplication-tap-highlight" content="no">


    
    <link href="/static/wx/css/global.css?v=0.01" rel="stylesheet" />
    <link href="/static/wx/css/g.css?v=0.01" rel="stylesheet" />
    
</head>
<body>

    <div class="header-panel">
        <a href="javascript:goback()" class="go-back"></a>
        确认下单
    </div>
    <div class="fix-bottom">
        <div class="c-t">
            合计：<span class="c-total-fee font-red"></span>
        </div>
        <!--<a class="c-order-btn" href="<?php echo U('Order/paytype');?>">确认订单</a>-->
        <a class="c-order-btn" href="#">提交订单</a>
    </div>
    <div class="page-panel padding-header padding-footer">
        <div class="shipping-box">
            <div class="select-panel">
                <span class="font-gray">配送方式：</span>
                <div class="label-type">
                    <label class="lxb-checkbox">
                        <input type="radio" name="shipping-type" value="1" id="shipping-type-1" checked><i></i>
                    </label>
                    <label for="shipping-type-1">送货</label>
                </div>
                <div class="label-type">
                    <label class="lxb-checkbox">
                        <input type="radio" name="shipping-type" value="2" id="shipping-type-2"><i></i>
                    </label>
                    <label for="shipping-type-2">自提</label>
                </div>
            </div>
            <div class="c-a">
                <?php if(!$address): ?>添加地址
                    <?php else: ?>
                    <p><span class="font-gray">收货人：</span><?php echo ($address["consignee"]); ?></p>
                    <p><span class="font-gray">收货地址：<br></span><?php echo ($address["address"]["area"]); ?></p><?php endif; ?>
            </div>
        </div>
        <div class="c-goods-panel">
            <h2>罗马仕</h2>
            <div class="c-goods">
                <div class="img" style="background-image: url(<?php echo ($sku["img"]); ?>)"></div>
                <div class="c-tail">
                    <div class="title"><?php echo ($goods["goods_name"]); ?></div>
                    <div class="items font-gray"><?php echo ($sku["sku_name"]); ?></div>
                    <div class="font-red">￥<?php echo ($goods["price"]); ?></div>
                    <div class="num-controller">
                        <a class="dec" href="javascript:">-</a><input type="tel" value="<?php echo ($num); ?>" class="num"><a class="inc" href="javascript:">+</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="c-total">
            <p class="border-bottom">共1件商品<span class="floatr color-gray total-price"></span></p>
            <p class="border-bottom">快递费<span class="floatr color-gray shipping-fee"></span></p>
            <div class="c-remark">
                <p>买家留言</p>
                <textarea class="r-input" id='mmark'></textarea>
            </div>
        </div>
    </div>

<script src="/static/common/js/jquery.min.js"></script>
<script src="/static/common/js/handlebars.js"></script>
<script src="/static/common/js/base.js?v=0.01"></script>
<script src="/static/wx/js/common.js?v=0.01"></script>
<script src="/static/layer/layer.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>

    <script>
        var _address_id = <?php echo ($address_id); ?>;
                var _maxInput = <?php echo ($sku["sku_num"]); ?>;
                var _shipping_fee = <?php echo ($goods["shipping_fee"]); ?>;
                var _append_fee = <?php echo ($goods["append_fee"]); ?>;
                var _goods_price = <?php echo ($goods["price"]); ?>;
                var _num = <?php echo ($num); ?>;
                var _sku = <?php echo ($sku["sku"]); ?>;
        var $inc = $('.num-controller .inc');
        var $dec = $('.num-controller .dec');
        var $num = $('.num-controller .num');
        var $totalFee = $('.c-total-fee');
        var $shippingFee = $('.shipping-fee');
        var $goodsFee = $('.total-price');
        var $btn = $('.c-order-btn');
        var $address = $('.shipping-box .c-a');
        $inc.click(function () {
            if ($(this).hasClass('lock')) {
                return false;
            }
            $num.val(parseInt($num.val()) + 1);
            checkNum();
        });
        $dec.click(function () {
            if ($(this).hasClass('lock')) {
                return false;
            }
            $num.val(parseInt($num.val()) - 1);
            checkNum();
        });
        $num.change(checkNum);
        function checkNum() {
            var num = parseInt($num.val());
            num = num || 1;
            num = Math.min(_maxInput, num);
            num = Math.max(1, num);
            $num.val(num);
            _num = num;
            if (_maxInput == 1) {
                $dec.addClass('lock');
                $inc.addClass('lock');
            } else {
                if (num <= 1) {
                    $dec.addClass('lock');
                } else {
                    $dec.removeClass('lock');
                }
                if (num >= _maxInput) {
                    $inc.addClass('lock');
                } else {
                    $inc.removeClass('lock');
                }
            }
            checkFee();
        }
        function checkFee() {
            var goods_fee = _goods_price * _num;
            var shipping_fee = _shipping_fee + (_append_fee * (_num - 1));
            var total_fee = goods_fee + shipping_fee;
            $goodsFee.text('￥' + goods_fee);
            $shippingFee.text('￥' + shipping_fee);
            $totalFee.text('￥' + total_fee);
        }
        checkFee();
        $btn.click(function () {
            $.post("<?php echo U('Order/createBuySoon');?>", {sku: _sku, num: _num, address_id: _address_id,mark:$('#mmark').val(),diyid:diyid}, function (res) {
                doAjax(res, function () {
					console.log(res);
					alert('创建订单成功,等待微信商户授权后正式支付！');
					location.href = "<?php echo U('Order/paytype');?>?oid="+res.data;
                    //layer.msg('启动支付接口失败...');
                });
            });
        });
        $address.click(function () {
            var redirect = "<?php echo U('buySoon', '', true, true);?>?sku=" + _sku + '&num=' + _num;
            location.href = "<?php echo U('Address/index','',true,true);?>?redirect=" + encodeURIComponent(redirect) + '&address_id=' + _address_id;
        });
    </script>

</body>
</html>