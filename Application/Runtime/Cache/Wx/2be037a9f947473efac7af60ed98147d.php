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

    <style>
        .order-box{}
        .order-box .top{
            height: 4rem;
            line-height: 4rem;
            background-color: #fff;
            border-bottom: 1px solid #f8f8f8;
            font-size: 1.5rem;
        }
        .order-box .top ul li{
            width:19%;
            display: inline-block;
            text-align: center;
        }
        .order-box .top ul li span{
            display: inline-block;
            height: 4rem;
        }
        .order-box .top ul li span.or-active{
            color:#31a9ff;
            border-bottom: 2px solid #31a9ff;
        }
        .order-box .or-col{
            height: 4.15rem;
            line-height: 4.15rem;
            background-color: #fff;
            border-bottom: 1px solid #f8f8f8;
            padding: 0 1.5rem;
            color:#c2c4c6;
            font-size: 1.4rem;
        }
        .order-box .or-title{
            margin-top: 1rem;
        }
        .order-box .or-title img{
            width: 1.8rem;
            height: 1.8rem;
            position: relative;
            top: .4rem;
            margin-right: 1rem;
        }
        .order-box .or-title span{
            float: right;
            color:#db8686;
        }
        .order-box .or-goods-info{
            padding: 1rem 1.5rem;
            height: 12rem;
            position: relative;
            color:#827070;
            background-color: #fff;
            border-bottom: 1px solid #f8f8f8;
        }
        .order-box .or-goods-info img{
            width: 8rem;
            height: 10rem;
            background-color: #fff;
        }
        .order-box .or-goods-info p{
            position: absolute;
            font-size: 1.4rem;
            padding-right: 1.5rem;
            overflow:hidden;
        }
        .order-box .or-goods-info .or-goods-name{
            top: 1rem;
            height: 4.4rem;
            left: 10.5rem;
            line-height: 1.6;
        }
        .order-box .or-goods-info .or-goods-money{
            top: 7rem;
            left: 10.5rem;
            line-height: 1.6;
            color: #ef5a5a;
        }
        .order-box .or-goods-info .or-goods-num{
            top: 7rem;
            line-height: 1.6;
            left: none;
            right: 0;
        }
        .order-box .or-pay-money p{
            color:#000;
            text-align:right;
            height: 4.15rem;

        }
        .order-box .or-pay-btn p{
            float: right;
        }
        .order-box .or-pay-btn a{
            display: inline-block;
            border: 1px solid #31a9ff;
            color:#31a9ff;
            width:8rem;
            height: 2.6rem;
            font-size: 1.3rem;
            line-height: 2.6rem;
            text-align: center;
            border-radius: 3rem;
            margin-left: .5rem;
        }
  #wrapper {
   position:absolute; z-index:1;
   top:7.5rem; bottom:0; left:0;
   width:100%;
   overflow:auto;
  }
 
  #scroller {
   position:relative;
  /* -webkit-touch-callout:none;*/
   -webkit-tap-highlight-color:rgba(0,0,0,0);
    top: 3.5rem;
   float:left;
   width:100%;
   padding:0;
  }
 
  #scroller ul {
   position:relative;
   list-style:none;
   padding:0;
   margin:0;
   width:100%;
   text-align:left;
  }
 
  #scroller li {
   padding:0 10px;
   height:40px;
   line-height:40px;
   border-bottom:1px solid #ccc;
   border-top:1px solid #fff;
   background-color:#fafafa;
   font-size:14px;
  }
 
  #scroller li > a {
   display:block;
  }
 
  /**
   *
   * 下拉样式 Pull down styles
   *
   */
  #pullDown, #pullUp {
   /*background:#fff;*/
   height:40px;
   line-height:40px;
   padding:5px 10px;
   /*border-bottom:1px solid #ccc;*/
   font-weight:bold;
   font-size:14px;
   color:#888;
   text-align: center;
  }
  #pullDown .pullDownIcon, #pullUp .pullUpIcon {
   display:block; float:left;
   width:40px; height:40px;
   background:url(pull-icon@2x.png) 0 0 no-repeat;
   -webkit-background-size:40px 80px; background-size:40px 80px;
   -webkit-transition-property:-webkit-transform;
   -webkit-transition-duration:250ms; 
  }
  #pullDown .pullDownIcon {
   -webkit-transform:rotate(0deg) translateZ(0);
  }
  #pullUp .pullUpIcon {
   -webkit-transform:rotate(-180deg) translateZ(0);
  }
 
 
  /**
   * 动画效果css3代码
   */
  #pullDown.flip .pullDownIcon {
   -webkit-transform:rotate(-180deg) translateZ(0);
  }
 
  #pullUp.flip .pullUpIcon {
   -webkit-transform:rotate(0deg) translateZ(0);
  }
 
  #pullDown.loading .pullDownIcon, #pullUp.loading .pullUpIcon {
   background-position:0 100%;
   -webkit-transform:rotate(0deg) translateZ(0);
   -webkit-transition-duration:0ms;
 
   -webkit-animation-name:loading;
   -webkit-animation-duration:2s;
   -webkit-animation-iteration-count:infinite;
   -webkit-animation-timing-function:linear;
  }
 
  @-webkit-keyframes loading {
   from { -webkit-transform:rotate(0deg) translateZ(0); }
   to { -webkit-transform:rotate(360deg) translateZ(0); }
  }
 
    </style>
    <div class="header-panel">
        <a href="<?php echo U('Member/index');?>" class="go-back"></a>我的订单
    </div>
    <div class="order-box" style='margin-top: 3.5rem'>
        <div class="top">
            <ul>
                <li><a href="<?php echo U('Order/index?type=0');?>"><span <?php if($data["type"] == 0): ?>class="or-active"<?php endif; ?>>全部</span></a></li>
                <li><a href="<?php echo U('Order/index?type=1');?>"><span <?php if($data["type"] == 1): ?>class="or-active"<?php endif; ?>>待付款</span></a></li>
                <li><a href="<?php echo U('Order/index?type=2');?>"><span <?php if($data["type"] == 2): ?>class="or-active"<?php endif; ?>>待收货</span></a></li>
                <li><a href="<?php echo U('Order/index?type=4');?>"><span <?php if($data["type"] == 4): ?>class="or-active"<?php endif; ?>>待评价</span></a></li>
                <li><a href="<?php echo U('Order/index?type=6');?>"><span <?php if($data["type"] == 6): ?>class="or-active"<?php endif; ?>>已完成</span></a></li>
            </ul>
        </div>
        <div id="wrapper">
            <div id="scroller">
              <div id="olist">
            <?php if(is_array($data["list"])): foreach($data["list"] as $key=>$item): ?><div>
                      
                        <div class="or-col or-title">
                            <img src="/static/wx/images/logo.png"/>罗马仕
                            <span>
                                <?php switch($item["status"]): case "1": ?>等待买家付款<?php break;?>
                                <?php case "2": ?>已付款，等待发货<?php break;?>
                                <?php case "3": ?>已发货<?php break;?>
                                <?php case "4": ?>已收货<?php break;?>
                                <?php case "5": ?>已取消<?php break;?>
                                <?php case "6": ?>已完成<?php break;?>
                                <?php default: ?>未知<?php endswitch;?>
                            </span>
                        </div>
                        <!--<a href="<?php echo U('Order/details', ['oid' => $item['order_id']]);?>">-->
                        <div id='od' onclick="detial(<?php echo ($item["order_id"]); ?>);">
                          
                       
                            <div class="or-goods-info">
                                <a href="<?php echo U('Goods/index', ['goods_id' => $item['goods']['goods_id']]);?>">
                                    <img src="<?php echo ($item[goods][goods_img]); ?>"/>
                                </a>
                                <p class="or-goods-name"><?php echo ($item["goods"]["goods_name"]); ?></p>
                                <p class="or-goods-money">￥<?php echo ($item["goods"]["price"]); ?></p>
                                <p class="or-goods-num"> <?php if($item["status"] != 4): ?>×<?php echo ($item["goods_num"]); endif; ?></p>
                            </div>
                         </a>
                         </div>
                         <?php if($item["status"] != 4): ?><div class="or-col or-pay-money">
                            <p>
                                <span>共<?php echo ($item["goods_num"]); ?>件商品 需付款:</span>
                                <span style="color:#ed5f86"><b style="font-size:1.6rem;font-weight: normal"><?php echo ($item["price"]); ?></b></span>
                                <span style="color:#c2c4c6">(含运费<?php echo ($item["shipping_fee"]); ?>)</span>
                            </p>
                        </div><?php endif; ?>
                        <div class="or-col or-pay-btn" style="clear:both">
                            <p>
                              <?php switch($item["status"]): case "1": ?><a href="<?php echo U('Order/cancel',array('oid'=>$item['order_id']));?>">取消订单</a>
                                <a href="<?php echo U('Order/paytype',array('oid'=>$item['order_id']));?>">付款</a><?php break;?>
                                <?php case "2": break;?>
                                    <?php case "3": ?><a href="<?php echo U('Order/confirm',array('oid'=>$item['order_id']));?>"><?php switch($item["shipping_type"]): case "1": ?>确认收货<?php break;?>
                                        <?php case "2": ?>确认提货<?php break; endswitch;?></a><?php break;?>
                                <?php case "4": ?><a href="<?php echo U('Order/evaluate',array('oid'=>$item['order_id']));?>">评价</a><?php break;?>
                                <?php case "5": ?><a href="<?php echo U('Order/del',['oid'=>$item['order_id']]);?>">删除订单</a><?php break;?>
                                <?php case "6": ?><a href="<?php echo U('Goods/index', ['goods_id' => $item['goods_id']]);?>">再次购买</a><a href="<?php echo U('Order/del',array('oid'=>$item['order_id']));?>">删除订单</a><?php break;?>
                                <?php default: ?>未知<?php endswitch;?>
                              
                            </p>
                        </div>
                    </div><?php endforeach; endif; ?>
            </div>
            <div id="pullUp">
                <span class="pullUpIcon"></span><span class="pullUpLabel"></span>
            </div>
        </div>
    </div>

<script src="/static/common/js/jquery.min.js"></script>
<script src="/static/common/js/handlebars.js"></script>
<script src="/static/common/js/base.js?v=0.01"></script>
<script src="/static/wx/js/common.js?v=0.01"></script>
<script src="/static/layer/layer.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
            <script src="/static/wx/webuploade/webuploader.js?v=0.01"></script>

    <script src="/static/amazeui/js/iscroll4.js"></script>
    <script>
       function detial(oid){
            location.href ="<?php echo U('Order/details','',true,true);?>?oid="+oid;
          }

        var myScroll,
         pullUpEl, pullUpOffset,
         generatedCount =1;

        /**
         * 滚动翻页 （自定义实现此方法）
         * myScroll.refresh();  // 数据加载完成后，调用界面更新方法
         */
        function pullUpAction () {
            generatedCount++;
            console.log(generatedCount);
            var gtype=<?php echo ($data["type"]); ?>;
         setTimeout(function () {
           // <-- Simulate network congestion, remove setTimeout from production!
            $.ajax({
        url:"<?php echo U('index');?>",
        type:"POST",
        data:{page:generatedCount,type:gtype},
        success:function(res){
          //要执行的内容
          var dom = '';
          var dom2 = '';
          var dom3 = '';
          var dom4 = '';
          var dom5 = '';
          for(var i=0;i<res.data.length;i++){
          dom ='<div>\n\
                        <div class="or-col or-title">\n\
                            <img src="/static/wx/images/logo.png"/>罗马仕\n\
                            <span>'
                            if(res.data[i].status==1){
                              dom3='等待买家付款'
                            }else if(res.data[i].status==2){
                              dom3='已付款，等待发货'
                            }else if(res.data[i].status==3){
                              dom3='已发货'
                            }else if(res.data[i].status==4){
                              dom3='已收货'
                            }else if(res.data[i].status==5){
                              dom3='已取消'
                            }else if(res.data[i].status==6){
                             dom3= '已完成'
                            }
                           dom2= '</span>\n\
                        </div>\n\
                        <div id="od" onclick="detial('+res.data[i].order_id+');">\n\
                            <div class="or-goods-info">\n\
                                <a href="/Goods/index.html?goods_id='+res.data[i].goods.goods_id+'">\n\
                                    <img src="'+res.data[i].goods.goods_img+'"/>\n\
                                </a>\n\
                                <p class="or-goods-name">'+res.data[i].goods.goods_name+'</p>\n\
                                <p class="or-goods-money">￥'+res.data[i].goods.price+'</p>\n\
                                <p class="or-goods-num">×'+res.data[i].goods_num+'</p>\n\
                            </div>\n\
                         </a>\n\
                         </div>\n\
                        <div class="or-col or-pay-money">\n\
                            <p>\n\
                                <span>共'+res.data[i].goods_num+'件商品 需付款:</span>\n\
                                <span style="color:#ed5f86"><b style="font-size:1.6rem;font-weight: normal">'+res.data[i].price+'</b></span>\n\
                                <span style="color:#c2c4c6">(含运费'+res.data[i].shipping_fee+')</span>\n\
                            </p>\n\
                        </div>\n\
                        <div class="or-col or-pay-btn" style="clear:both">\n\
                            <p>'
                            if(res.data[i].status==1){
                              dom4='<a href="/Order/cancel.html?oid='+res.data[i].order_id+'">取消订单</a>\n\
                                <a href="/Order/paytype.html?oid='+res.data[i].order_id+'">付款</a>'
                            }else if(res.data[i].status==2){
                              dom4=''
                            }else if(res.data[i].status==3){
                              dom4='<a href="/Order/confirm.html?oid='+res.data[i].order_id+'">确认收货</a>'
                            }else if(res.data[i].status==4){
                              dom4='<a href="/Order/evaluate.html?oid='+res.data[i].order_id+'">评价</a>'
                            }else if(res.data[i].status==5){
                              dom4='<a href="/Order/evaluate.html?oid='+res.data[i].order_id+'">删除订单</a>'
                            }else if(res.data[i].status==6){
                             dom4= '<a href="/Goods/index.html?goods_id='+res.data[i].goods_id+'">再次购买</a>\n\
                                <a href="/Order/del.html?oid='+res.data[i].order_id+'">删除订单</a>'
                            }
                           dom5= '</p>\n\
                        </div>\n\
                    </div>'
                     $('#olist').append(dom+dom3+dom2+dom4+dom5);
          }
          myScroll.refresh();
        }
      });
          myScroll.refresh();  // 数据加载完成后，调用界面更新方法 Remember to refresh when contents are loaded (ie: on ajax completion)
         }, 1000); // <-- Simulate network congestion, remove setTimeout from production!
        }
         
        /**
         * 初始化iScroll控件
         */
        function loaded() {
         pullUpEl = document.getElementById('pullUp'); 
         pullUpOffset = pullUpEl.offsetHeight;
         
         myScroll = new iScroll('wrapper', {
          // scrollbarClass: 'myScrollbar', /* 重要样式 */
          useTransition: false, /* 此属性不知用意，本人从true改为false */
          topOffset: pullUpOffset,
          onRefresh: function () {
           if (pullUpEl.className.match('loading')) {
            pullUpEl.className = '';
            pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉加载更多...';
           }
          },
          onScrollMove: function () {
           if (this.y < (this.maxScrollY - 5) && !pullUpEl.className.match('flip')) {
            pullUpEl.className = 'flip';
            pullUpEl.querySelector('.pullUpLabel').innerHTML = '松手开始更新...';
            this.maxScrollY = this.maxScrollY;
           } else if (this.y > (this.maxScrollY + 5) && pullUpEl.className.match('flip')) {
            pullUpEl.className = '';
            pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉加载更多...';
            this.maxScrollY = pullUpOffset;
           }
          },
          onScrollEnd: function () {
           if (pullUpEl.className.match('flip')) {
            pullUpEl.className = 'loading';
            pullUpEl.querySelector('.pullUpLabel').innerHTML = '加载中...';    
            pullUpAction(); // Execute custom function (ajax call?)
           }
          }
         });
         
         // setTimeout(function () { document.getElementById('wrapper').style.left = '0'; }, 800);
        }
         
        //初始化绑定iScroll控件 
        document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
        document.addEventListener('DOMContentLoaded', loaded, false);

    </script>

</body>
</html>