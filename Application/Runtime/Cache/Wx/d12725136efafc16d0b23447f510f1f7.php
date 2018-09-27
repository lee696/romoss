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
        选择地址
    </div>
    <a class="fixed-bottom-btn to-buy" href="<?php echo U('info');?>?redirect=<?php echo ($redirect); ?>">添加新地址</a>
    <div class="page-panel padding-header padding-footer">
        <div class="addr-box">
            <ul>
                <?php if(is_array($address_list)): $i = 0; $__LIST__ = $address_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$address): $mod = ($i % 2 );++$i;?><li data-id="<?php echo ($address["address_id"]); ?>">
                        <div>
                            <p class="addr-cont">
                                <label class="lxb-checkbox">
                                    <input type="radio" id="is_default" name='is_default' onclick="defaultadd(<?php echo ($address["address_id"]); ?>);" <?php if($address["is_default"] == 1): ?>checked = "checked"<?php endif; ?>><i></i>
                                </label>
                                <span class="addr-name"><?php echo ($address["consignee"]); ?></span>
                                <span class="addr-phone"><?php echo ($address["phone"]); ?></span>
                                <span class="def_set">默认</span>
                            </p>
                            <p class="addr-info"><?php echo ($address["address"]["area"]); ?></p>
                            <p class="addr-grp">
                                <span class="addr-btn">
                                    <i class="edit"></i><a class="addr-edit" href="<?php echo U('info');?>?address_id=<?php echo ($address["address_id"]); ?>&redirect=<?php echo ($redirect); ?>">编辑</a>
                                    <i class="del"></i><span class="addr-del">删除</span>
                                </span>
                            </p>
                        </div>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <div class="tishi_bg none">
                <div><img src="../static/wx/images/tishi_bg.png" /></div>
                <p>您还没有收货地址哦！</p>
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
       function defaultadd(address_id){
         $.post("<?php echo U('Addr/defaultadd');?>", {address_id: address_id}, function () {
                doAjax(res, function () {
                });
            });
      }
        $('.addr-del').click(function () {
            var $dom = $(this).closest('li');
            $.post("<?php echo U('del');?>", {address_id: $dom.attr('data-id')}, function () {
                doAjax(res, function () {
                    $dom.slideUp(function () {
                        $dom.remove();
                    });
                });
            });
        });
        $('.addr-cont, .addr-info').click(function () {
            var _address_id = $(this).closest('li').attr('data-id');
            location.href = "<?php echo ($redirect); ?>&address_id=" + _address_id;
        });

        if ("<?php echo ($address); ?>" == "") {
            $(".tishi_bg").show();

        } else {
            $(".tishi_bg").hide();
        }
    </script>

</body>
</html>