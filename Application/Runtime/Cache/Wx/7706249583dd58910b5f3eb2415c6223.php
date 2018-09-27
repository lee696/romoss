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

    <div class="login-panel">
        <div class="logo-panel">
            <img src="/static/wx/images/logo.png" alt="罗马仕" title="罗马仕">
        </div>
        <div class="login-container">
            <label class="login-tel input-con">
                <input type="tel" placeholder="请输入手机号" autocomplete="off" maxlength="11">
            </label>
            <label class="login-pwd input-con">
                <input type="password" placeholder="请输入密码" maxlength="20">
            </label>
        </div>
        <a class="lxb-btn lxb-full-btn back-blue login-btn lock">登录</a>
        <div class="bottom-nav">
            <a href="<?php echo U('login', ['redirect' => I('redirect')]);?>">验证码登录</a>
            <a href="<?php echo U('reg', ['redirect' => I('redirect')]);?>">注册</a>
        </div>
    </div>

<script src="/static/common/js/jquery.min.js"></script>
<script src="/static/common/js/handlebars.js"></script>
<script src="/static/common/js/base.js?v=0.01"></script>
<script src="/static/wx/js/common.js?v=0.01"></script>
<script src="/static/layer/layer.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>

    <script>
        $(function(){
            var _redirect = "<?php echo ($redirect); ?>";
            var _login = "<?php echo U('pwdLogin');?>";
            var $phone = $('.login-tel input');
            var $pwd = $('.login-pwd input');
            var $login = $('.login-btn');
            $phone.add($pwd).keyup(checkCodeBtn);
            function checkCodeBtn(){
                if(isPhone($phone.val()) && $pwd.val().length > 0 ){
                    $login.removeClass('lock');
                }else{
                    $login.addClass('lock');
                }
            }
            $login.click(function(){
                if($(this).hasClass('lock')){
                    return false;
                }
                $.post(_login, {phone : $phone.val(), pwd : $pwd.val()}, function(res){
                    doAjax(res, function(){
                        var link = "<?php echo U('Index/index');?>";
                        if(_redirect){
                            link = _redirect;
                        }
                        location.href = link;
                    });
                });
            });
        });
    </script>

</body>
</html>