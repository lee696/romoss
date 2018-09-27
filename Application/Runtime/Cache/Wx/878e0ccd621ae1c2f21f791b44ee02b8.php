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

    <div class="login-panel">
        <div class="logo-panel">
            <img src="/static/wx/images/logo.png" alt="罗马仕" title="罗马仕">
        </div>
        <div class="login-container">
            <label class="login-tel input-con">
                <input type="tel" placeholder="请输入手机号码" autocomplete="off" maxlength="11">
            </label>
            <label class="login-code input-con">
                <input type="tel" placeholder="请输入验证码" maxlength="4">
                <a class="send-code lock" href="javascript:" tabindex="-1">获取验证码</a>
            </label>
        </div>
        <a class="lxb-btn lxb-full-btn back-blue login-btn lock">完成</a>
        <div class="tips-agreement">
            <label class="lxb-checkbox">
                <input type="checkbox" id="agreement" checked><i></i>
            </label>
            <label for="agreement">
                同意<a href="<?php echo U('agreement');?>">《优选师服务协议》</a>
            </label>
        </div>
        <div class="bottom-nav">
            <a href="<?php echo U('plogin', ['redirect' => I('redirect')]);?>">密码登录</a>
            <a href="<?php echo U('reg', ['redirect' => I('redirect')]);?>">注册</a>
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
        $(function(){
            var _redirect = "<?php echo ($redirect); ?>";
            var _login = "<?php echo U('phoneLogin');?>";
            var _send_code = "<?php echo U('sendLoginCode');?>";
            var $phone = $('.login-tel input');
            var $code = $('.login-code input');
            var $sendCode = $('.send-code');
            var $login = $('.login-btn');
            var $agreement = $('#agreement');
            var _code_time = 60;
            $phone.keyup(checkSendBtn);
            $phone.add($code).add($agreement).keyup(checkCodeBtn);
            
            $agreement.change(checkCodeBtn);
            $sendCode.click(function(){
                if($(this).hasClass('lock')){
                    return false;
                }
                $.post(_send_code, {phone : $phone.val()},function(res){
                    doAjax(res, function(){
                        setCodeTime();
                        $code.focus();
                    });
                });
            });
            $login.click(function(){
                if($(this).hasClass('lock')){
                    return false;
                }
                $.post(_login, {phone : $phone.val(), code : $code.val()}, function(res){
                    doAjax(res, function(){
                        var link = "<?php echo U('Index/index');?>";
                        if(_redirect){
                            $phone.val('');
                            link = _redirect;
                        }
                        location.href = link;
                        $code.val('');
                    });
                });
            });
            function checkSendBtn(){
                if(isPhone($phone.val())){
                    $sendCode.removeClass('lock');
                }else{
                    $sendCode.addClass('lock');
                }
            }
            function checkCodeBtn(){
                if(isPhone($phone.val()) && $code.val().length == 4 && $agreement.is(':checked')){
                    $login.removeClass('lock');
                }else{
                    $login.addClass('lock');
                }
            }
            function setCodeTime(time){
                if(typeof time == 'undefined'){
                    time = _code_time;
                }
                if(time == 0){
                    $sendCode.removeClass('active');
                    $sendCode.text('获取验证码');
                    checkSendBtn();
                }else{
                    $sendCode.addClass('lock').addClass('active').removeClass('loading');
                    $sendCode.text('(' + time + ')重新获取');
                    setTimeout(function(){
                        setCodeTime(time - 1);
                    }, 1000);
                }
            }
        });
    </script>

</body>
</html>