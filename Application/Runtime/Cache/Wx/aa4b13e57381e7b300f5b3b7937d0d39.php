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
    <a class="nav-home <?php if(member == home): ?>current<?php endif; ?>" href="<?php echo U('Index/index');?>">首页</a>
    <a class="nav-diy <?php if(member == diy): ?>current<?php endif; ?>" href="<?php echo U('Customization/index');?>">
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
    <a class="nav-member <?php if(member == member): ?>current<?php endif; ?>" href="<?php echo U('Member/index');?>">我的</a>
</div>
    <div class="member-box">
        <div class="userinfo">
            <div class="avatar userbg">
                <a href="<?php echo U('info');?>">
                    <!--<img src="/static/wx/images/logo.png" alt="罗马仕" title="罗马仕"/>-->
                    <img src="<?php echo ($user_info["avatar"]); ?>" alt="<?php echo ($user_info["nickname"]); ?>" title="<?php echo ($user_info["nickname"]); ?>"
                         onerror="javascript:this.src='/static/wx/images/default_avatar.png'"/>
                </a>
                <a href="<?php echo U('info');?>">
                    <p><?php echo ($user_info["nickname"]); ?></p>
                </a>
                <a href="<?php echo U('info');?>">
                    <span>帐号：<?php echo ($user_info["user_id"]); ?></span>
                </a>
            </div>
            <a class="user-message" href="<?php echo U('Message/index');?>"><i src="/static/wx/images/icon-message.png" ></i></a>
        </div>
        <div class='col order'>
            <a href="<?php echo U('Order/index?type=0');?>">
                我的订单
                <i>查看全部订单&nbsp;&nbsp;&nbsp;<i class='ico-right' style='background-size: 6px;'></i></i>
            </a>
        </div>
        <div class='order-rows'>
            <ul>
                <li>
                    <a href="<?php echo U('Order/index?type=1');?>"><i class='icon-bar'></i><span>待付款</span></a>
                </li>
                <li>
                    <a href="<?php echo U('Order/index?type=2');?>"><i class='icon-cat'></i><span>待收货</span></a>
                </li>
                <li>
                    <a href="<?php echo U('Order/index?type=4');?>"><i class='icon-pj'></i><span>待评价</span></a>
                </li>
                <li>
                    <a href="<?php echo U('Order/index?type=6');?>"><i class='icon-ok2' ></i><span>已完成</span></a>
                </li>
            </ul>
        </div>
        <div class='col' rel="<?php echo U('Addr/index');?>">
            <a>
                我的地址<i class='ico-right'></i>
            </a>
        </div>
        <div class='col' rel="<?php echo U('Works/index');?>">
            <a>
                我的作品<i class='ico-right'></i>
            </a>
        </div>
        <div class='col' style='margin-bottom: 5rem;'>
            <a href="<?php echo U('Seting/setting');?>">
                设置<i class='ico-right'></i>
            </a>
        </div>
    </div>

<script src="/static/common/js/jquery.min.js"></script>
<script src="/static/common/js/handlebars.js"></script>
<script src="/static/common/js/base.js?v=0.01"></script>
<script src="/static/wx/js/common.js?v=0.01"></script>
<script src="/static/layer/layer.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
            <script src="/static/wx/webuploade/webuploader.js?v=0.01"></script>

    <script>
        $(function () {
            goToNav();

            function goToNav() {
                $('.member-box .col').click(function () {
                    location.href = $(this).attr('rel');
                });
            }
        });
    </script>

</body>
</html>