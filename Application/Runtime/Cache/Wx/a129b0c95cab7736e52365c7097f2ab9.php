<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>罗马仕</title>
    <meta name="viewport" content="
    width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
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
     <link href="/static/wx/webuploade/webuploader.css?v=0.01" rel="stylesheet" />
    <link href="/static/wx/css/g.css?v=0.01" rel="stylesheet" />
    
</head>
<body>

    <div class="footer">
    <a class="nav-home <?php if(home == home): ?>current<?php endif; ?>" href="<?php echo U('Index/index');?>">首页</a>
    <a class="nav-diy <?php if(home == diy): ?>current<?php endif; ?>" href="<?php echo U('Customization/index');?>">
        <div class="i-1">
            <div class="i-2">
                <div class="i-3">
                    <div class="i-4">
                        <div class="i-5">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        定制
    </a>
    <a class="nav-member <?php if(home == member): ?>current<?php endif; ?>" href="<?php echo U('Member/index');?>">我的</a>
</div>
    <div class="header-panel">
        <a href="<?php echo U('Message/index');?>" class="message"></a>
        <a href="<?php echo U('Index/scan-qr');?>" class="scan"></a>
        优选师
    </div>
    <div class="page-panel padding-header padding-footer">
        <div id="slide-box">
            <ul class="slide-panel">
                <?php if(is_array($slide_list)): $i = 0; $__LIST__ = $slide_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$slide): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ((isset($slide["link"]) && ($slide["link"] !== ""))?($slide["link"]):'javascript:'); ?>" style="background-image:url(<?php echo ($slide["img"]); ?>)" title="<?php echo ($slide["title"]); ?>"></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <div class="hd">
                <ul>
                    <?php if(is_array($slide_list)): $i = 0; $__LIST__ = $slide_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$slide): $mod = ($i % 2 );++$i;?><li></li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>
        <h2 class="module-title">精品推荐</h2>
        <div class="goods-list">
            <?php if(is_array($goods_list)): $i = 0; $__LIST__ = $goods_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Goods/index', ['goods_id' => $goods['goods_id']]);?>">
                    <div class="goods-tail">
                        <img class="img" src="<?php echo ($goods["goods_img"]); ?>" alt="<?php echo ($goods["goods_name"]); ?>" title="<?php echo ($goods["goods_name"]); ?>">
                        <div class="title"><?php echo ($goods["goods_name"]); ?></div>
                        <div class="tips"><?php echo ($goods["desc"]); ?></div>
                        <div class="price-con">
                            ￥<?php echo ($goods["price"]); ?><s>￥<?php echo ($goods["market_price"]); ?></s>
                        </div>
                    </div>
                </a><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>

<script src="/static/common/js/jquery.min.js"></script>
<script src="/static/common/js/handlebars.js"></script>
<script src="/static/common/js/base.js?v=0.01"></script>
<script src="/static/wx/js/common.js?v=0.01"></script>
<script src="/static/layer/layer.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
            <script src="/static/wx/webuploade/webuploader.js?v=0.01"></script>

    <script src="/static/wx/js/TouchSlide.js"></script>
    <script>
        TouchSlide({
            slideCell: "#slide-box",
            // titCell: ".hd ul",
            mainCell: ".slide-panel",
            effect: 'leftLoop',
            autoPlay: true,
            interTime: 3500
        });
    </script>

</body>
</html>