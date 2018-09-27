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
    
    <link rel="stylesheet" href="/static/wx/LArea/LArea.css">

</head>
<body>

    <div class="header-panel">
        <a href="javascript:goback()" class="go-back"></a>
        <?php if($address_id): ?>编辑地址<?php else: ?>新增地址<?php endif; ?>
    </div>
    <div class="page-panel padding-header address-oper-box">
        <div class="address-oper">
            <div class="tail">
                <span class="title">收货人</span>
                <input type="text" class="consignee" value="<?php echo ($address["consignee"]); ?>">
            </div>
            <div class="tail">
                <span class="title">联系电话</span>
                <input type="tel" class="phone" value="<?php echo ($address["phone"]); ?>" placeholder="保密">
            </div>
            <div class="tail">
                <span class="title">所在地区</span>
                <input type="text" class="address" id="address" value="<?php echo ($address["address"]["prov"]); echo ($address["address"]["city"]); echo ($address["address"]["region"]); ?>" placeholder="请选择" readonly>
                <input type="hidden" id="prov">
                <input type="hidden" id="city">
                <input type="hidden" id="region">
            </div>
            <div class="tail">
                <span class="title addr-details"><span>详细地址</span></span>
                <textarea class="area"><?php echo ($address["address"]["area"]); ?></textarea>
            </div>
            <div class="tail">
                <label class="lxb-checkbox">
                    <input type="checkbox" id="is_default" <?php if($address['is_default']): ?>checked<?php endif; ?>><i></i>
                </label>
                <label for="is_default">设为默认</label>
            </div>
        </div>
        <a class="lxb-btn lxb-full-btn back-blue login-btn">确定</a>
    </div>

<script src="/static/common/js/jquery.min.js"></script>
<script src="/static/common/js/handlebars.js"></script>
<script src="/static/common/js/base.js?v=0.01"></script>
<script src="/static/wx/js/common.js?v=0.01"></script>
<script src="/static/layer/layer.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>

    <script src="/static/wx/LArea/LAreaData1.js"></script>
    <script src="/static/wx/LArea/LAreaData2.js"></script>
    <script src="/static/wx/LArea/LArea.js"></script>
    <script>
        var area1 = new LArea();
        area1.init({
            'trigger': '#address',
            'valueTo': '#prov',
            'keys': {
                id: 'id',
                name: 'name'
            },
            'type': 1,
            'data': LAreaData
        });
        var _address_id = <?php echo ($address_id); ?>;
        var redirect = '<?php echo ($redirect); ?>';
        var $btn = $('.login-btn');
        var $consignee = $('.consignee');
        var $phone = $('.phone');
        var $address = $('#address');
        var $area = $('.area');
        $btn.click(function(){
            var data = {};
            if($consignee.val().length == 0){
                layer.msg('收货人不能为空');
                return false;
            }
            if($phone.val() && (!isPhone($phone.val()) && !isTel($phone.val()))){
                layer.msg('联系电话格式错误');
                return false;
            }
            if($address.val().length == 0){
                layer.msg('请填写您的所在地区');
                return false;
            }
            if($area.val().length == 0){
                layer.msg('请填写您的详细地址');
                return false;
            }
            data.consignee = $consignee.val();
            data.phone = $phone.val();
            data.address = {};
            data.address.area = $area.val();
            var address = $address.val().split(',');
            if(address[0]){
                data.address.prov = address[0];
            }
            if(address[1]){
                data.address.city = address[1];
            }
            if(address[2]){
                data.address.region = address[2];
            }
            if(_address_id){
                data.address_id = _address_id;
            }
            data.is_default = $('#is_default').prop('checked')?1:0;
            $.post("<?php echo U('operation');?>", data, function(res){
               doAjax(res, function(address_id){
                    location.href = "<?php echo U('index','',true,true);?>?address_id=" + address_id + '&redirect=' + redirect;
               });
            });
        });

    </script>

</body>
</html>