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

    <style>
        body{background:#f3f5f9!important;}
        a{
            color: #3e4e59 !important;
        }
        .header-panel .right{
            color: #fff !important;
        }
        .member-box .user-avatar{
            height: 10rem;
            line-height: 10rem;
            margin-bottom: 1rem;
        }
        .member-box .user-avatar img{
            width: 7rem;
            height: 7rem;
            margin-top: .5rem;
            border-radius: 50%;
        }
        .member-box .user-avatar i {
            height: 10rem;
        }
        .member-box .col i{
            font-size: 1.6rem;
        }
        .header-panel .right{
            position: absolute;
            right: 1.5rem;
            font-size: 1.5rem;
        }
        .member-box .col .nickname,.member-box .col .phone{
            width:15rem;
            height: 5rem;
            text-align: right;
            color:#cccbcb;
        }
        .member-box .col input[type='date']{
            height:4rem;
            text-align: right;
            color:#cccbcb;
            font-size: 1.5rem;
            padding-right: 0
        }
        .member-box .col input[type='date']::-webkit-calendar-picker-indicator{
            display: none;
        }
        .member-box .col input[type='date']::-webkit-clear-button{
            display: none;
        }
        .member-box .col input[type='date']::-moz-calendar-picker-indicator{
            display: none;
        }
        .member-box .col input[type='date']::-moz-clear-button{
            display: none;
        }
        .member-box .col input[type='date']::calendar-picker-indicator{
            display: none;
        }
        .member-box .col input[type='date']::clear-button{
            display: none;
        }
        .member-box .col select{
            height: 5rem;
            text-align: right;
            color:#cccbcb;
            font-size: 1.5rem;
        }
    </style>

    <div class="header-panel">
        <a href="javascript:goback()" class="go-back"></a>基本资料
        <a href="#" id='sbt' class="right" >
            提交
        </a>
    </div>
    <div class="member-box" style='margin-top:3.5rem'>
      <form action="<?php echo U('Member/setinfo');?>" method = 'post' id='formid' enctype="multipart/form-data">
        <div class='col user-avatar'>
            <a>
                头像
                <i><input type='file' name='images' style='display:none'/><img src='<?php echo ($user_info["avatar"]); ?>' onerror="javascript:this.src='/static/wx/images/default_avatar.png'">&nbsp;&nbsp;<i class='ico-right'></i></i>
            </a>
        </div>
        <label>
        <div class='col'>
            <a>
                昵称
                <i><input type='text' class='nickname' name='nickname' placeholder='请输入昵称' value="<?php echo ($user_info["nickname"]); ?>" />&nbsp;&nbsp;<i class='ico-right'></i></i>
            </a>
        </div>
        </label>
        <label>
        <div class='col'>
            <a>
                手机号
                <i><?php echo ($user_info["phone"]); ?>&nbsp;&nbsp;<i class='ico-right'></i></i>
            </a>
        </div>
        </label>
        <div class='col' data-am-modal="{target: '#sex-actions'}" id="sex">
            <a>
                性别
                <i>
                    <span><?php echo ((isset($user_info["sex"]) && ($user_info["sex"] !== ""))?($user_info["sex"]):'请选择'); ?></span><input type='text' type="hidden" name="sex" />&nbsp;&nbsp;<i class='ico-right'></i></i>
            </a>
        </div>
        <div class='col' id="selectDate">
            <a>
                生日
                <i>
                    <span data-year="" data-month="" data-date="" id="showDate"><?php echo ((isset($user_info["birthday"]) && ($user_info["birthday"] !== ""))?($user_info["birthday"]):'请选择'); ?></span><input type="text" type="hidden" name="birthday"/>&nbsp;&nbsp;<i class='ico-right'></i></i>
            </a>
        </div>
      </form>
    </div>
    <div class="am-modal-actions" id="sex-actions">
          <div class="am-modal-actions-group">
            <ul class="am-list">
              <li class="am-modal-actions-header" data-am-modal-close>男</li>
              <li class="am-modal-actions-header" data-am-modal-close>女</li>
            </ul>
          </div>
          <div class="bg">
              
          </div>
          <div class="am-modal-actions-group">
            <button class="am-btn am-btn-secondary am-btn-block" data-am-modal-close>取消</button>
          </div>
    </div>

<script src="/static/common/js/jquery.min.js"></script>
<script src="/static/common/js/handlebars.js"></script>
<script src="/static/common/js/base.js?v=0.01"></script>
<script src="/static/wx/js/common.js?v=0.01"></script>
<script src="/static/layer/layer.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>

    <link rel="stylesheet" href="/static/amazeui/css/amazeui.min.css" />
    <link rel="stylesheet" href="/static/iosselect/iosSelect.css" />
    <script src="/static/amazeui/js/amazeui.min.js"></script>
    <script src="/static/iosselect/iosSelect.min.js"></script>
    <script>
        window.onload = function () {
            var input = $(".user-avatar input[type='file']")[0];
            var txshow = $('.user-avatar img')[0];
            if (typeof (FileReader) === 'undefined') {
                result.innerHTML = "抱歉，你的浏览器不支持 FileReader，请使用现代浏览器操作！";
                input.setAttribute('disabled', 'disabled');
            } else {
                input.addEventListener('change', readFile, false);
                txshow.onclick = function () {
                    input.click();
                }
            }
        }
        function readFile() {
            var file = this.files[0];
            var txshow = $('.user-avatar img')[0];
            //判断是否是图片类型
            if (!/image\/\w+/.test(file.type)) {
                alert("只能选择图片");
                return false;
            }
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function (e) {
                txshow.src = this.result;
                console.log(this.result);
            }
        }
         $(function () {
            $("#sbt").click(function () {
//              $('form[id=formid]').attr('action',"<?php echo U('Member/setinfo');?>"); 
              document.getElementById("formid").submit();
            });
            // 性别滑动框自定义 关闭事件
            $('#sex-actions').on('close.modal.amui', function(){

            });
            // 性别滑动框 点击选择
            $('.am-modal-actions-header').click(function(){
                $('#sex span').text($(this).text())
                $('#sex input').val($(this).text())
            })

            // 选择时间
            var selectDateDom = $('#selectDate');
            var showDateDom = $('#showDate');
            // 初始化时间
            var now = new Date();
            var nowYear = now.getFullYear();
            var nowMonth = now.getMonth() + 1;
            var nowDate = now.getDate();
            showDateDom.attr('data-year', nowYear);
            showDateDom.attr('data-month', nowMonth);
            showDateDom.attr('data-date', nowDate);
            // 数据初始化
            function formatYear (nowYear) {
                var arr = [];
                for (var i = nowYear - 80; i <= nowYear; i++) {
                    arr.push({
                        id: i + '',
                        value: i
                    });
                }
                return arr;
            }
            function formatMonth () {
                var arr = [];
                for (var i = 1; i <= 12; i++) {
                    arr.push({
                        id: i + '',
                        value: i
                    });
                }
                return arr;
            }
            function formatDate (count) {
                var arr = [];
                for (var i = 1; i <= count; i++) {
                    arr.push({
                        id: i + '',
                        value: i
                    });
                }
                return arr;
            }
            var yearData = function(callback) {
                callback(formatYear(nowYear))
            }
            var monthData = function (year, callback) {
                callback(formatMonth());
            };
            var dateData = function (year, month, callback) {
                if (/^(1|3|5|7|8|10|12)$/.test(month)) {
                    callback(formatDate(31));
                }
                else if (/^(4|6|9|11)$/.test(month)) {
                    callback(formatDate(30));
                }
                else if (/^2$/.test(month)) {
                    if (year % 4 === 0 && year % 100 !==0 || year % 400 === 0) {
                        callback(formatDate(29));
                    }
                    else {
                        callback(formatDate(28));
                    }
                }
                else {
                    throw new Error('month is illegal');
                }
            };
            var hourData = function(one, two, three, callback) {
                var hours = [];
                for (var i = 0,len = 24; i < len; i++) {
                    hours.push({
                        id: i,
                        value: i
                    });
                }
                callback(hours);
            };
            var minuteData = function(one, two, three, four, callback) {
                var minutes = [];
                for (var i = 0, len = 60; i < len; i++) {
                    minutes.push({
                        id: i,
                        value: i
                    });
                }
                callback(minutes);
            };
            selectDateDom.bind('click', function () {
                var oneLevelId = showDateDom.attr('data-year');
                var twoLevelId = showDateDom.attr('data-month');
                var threeLevelId = showDateDom.attr('data-date');
                var iosSelect1 = new IosSelect(3, 
                    [yearData, monthData, dateData],
                    {
                        title: '',
                        itemHeight: 35,
                        relation: [1, 1, 0, 0],
                        itemShowCount: 5,
                        oneLevelId: oneLevelId,
                        twoLevelId: twoLevelId,
                        threeLevelId: threeLevelId,
                        callback: function (selectOneObj, selectTwoObj, selectThreeObj, selectFourObj, selectFiveObj) {
                            showDateDom.attr('data-year', selectOneObj.id);
                            showDateDom.attr('data-month', selectTwoObj.id);
                            showDateDom.attr('data-date', selectThreeObj.id);
                            $('#selectDate span').text(selectOneObj.id+'.'+selectTwoObj.id+'.'+selectThreeObj.id);
                            $('input[name=birthday]').val(selectOneObj.id+'.'+selectTwoObj.id+'.'+selectThreeObj.id);
                        }
                });
            });
        });
    </script>

</body>
</html>