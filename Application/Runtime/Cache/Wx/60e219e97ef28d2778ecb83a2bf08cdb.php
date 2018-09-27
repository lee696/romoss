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
     <link href="/static/wx/webuploade/webuploader.css?v=0.01" rel="stylesheet" />
    <link href="/static/wx/css/g.css?v=0.01" rel="stylesheet" />
    
</head>
<body>

    <style>

        .scan_box{ background: rgba(0,0,0,0.6);position: fixed;top:3.5rem;left:0;width:100%; height:100%;z-index:999;}
        .scan_box .scan_box_cont{overflow:hidden;position: relative;margin-top:25%;margin-left:16.5%;background:#fff;width:25.1rem; height:25.1rem;}
        .scan_box .scan_box_cont .qr-s-line{position:absolute;width:100%;height:4px;background: url(../../../static/wx/images/qr-sm.png)no-repeat;background-size: 100% 100%;}
        .scan_box p{font-size:1.3rem;margin-top:3.2rem;text-align: center;color:rgba(255, 255, 255, 0.8); }
        .scan_box span{position: absolute;display:block;box-sizing:border-box;width:1.75rem ;height:1.75rem;}
        .scan_box .corner1{top:13.5%;left:15.5%;border-top:0.2rem #31a9ff solid;border-left:0.2rem #31a9ff solid;}
        .scan_box .corner2{top:13.5%;right:15.5%;border-top:0.2rem #31a9ff solid;border-right:0.2rem #31a9ff solid;}
        .scan_box .corner3{top:49.7%;left:15.5%;border-bottom:0.2rem #31a9ff solid;border-left:0.2rem #31a9ff solid;}
        .scan_box .corner4{top:49.7%;right:15.5%;border-bottom:0.2rem #31a9ff solid;border-right:0.2rem #31a9ff solid;}

        .dongh{animation: k-loadingC 2s linear infinite ; }
        @keyframes k-loadingC {
            0% {
                margin-top: 0px;
            }

            100% {margin-top: 250px;
            }
        }


    </style>
    <div class="header-panel">
        <a href="javascript:goback()" class="go-back"></a>扫一扫
    </div>
    <div class='scan_box' >
        <span class="corner1"></span>
        <span class="corner2"></span>
        <span class="corner3"></span>
        <span class="corner4"></span>
        <div class="scan_box_cont">
            <div class="qr-s-line dongh"></div>
        </div>
        <p>将二维码/条码放入框内，即可自动扫描</p>
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


        });
    </script>

</body>
</html>