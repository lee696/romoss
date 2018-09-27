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

    <div class="header-panel">
        <a href="javascript:goback()" class="go-back"></a>
        <div>商品</div>
<!--         <div>详情</div>
        <div>评价</div> -->

    </div>
    <a class="fixed-bottom-btn to-buy" href="javascript:">立即购买</a>
    <div class="page-panel padding-header padding-footer">
        <div id="slide-box" class="container-banner">
            <ul class="slide-panel">
                <?php if(is_array($sku)): $i = 0; $__LIST__ = $sku;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="javascript:" style="background-image:url(<?php echo ($vo["img"]); ?>)" title="<?php echo ($vo["sku_name"]); ?>"></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <div class="bd">
                <ul class="slide-point">
                    <?php if(is_array($sku)): $i = 0; $__LIST__ = $sku;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li></li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>
        <div class="goods-desc">
            <p class="title"><b>[罗马仕名称]</b> <?php echo ($info["goods_name"]); ?></p>
            <div class="price-con">
                ￥<span class="font-big"><?php echo ($info["price"]); ?></span>
                <s>￥<?php echo ($info["market_price"]); ?></s>
                <span class="floatr">月销量：<?php echo ($info["sale_num"]); ?></span>
            </div>
            <div class="shipping-con text-right">
                <?php if($info['shipping_fee']): ?>邮费：￥<?php echo ($info["shipping_fee"]); ?>
                    <?php else: ?>
                    包邮<?php endif; ?>
            </div>
        </div>
        <div class="comment-panel">
            <div class="title-con">
                <h2 class="module-title">用户评价 (<?php echo ($sum); ?>)</h2>
            </div>
            <div class="module-cont">
              <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="module-main">
                  
                    <div class="u-img"><?php if(empty($vo["avatar"])): ?><img src="../../../static/wx/images/default_avatar.png"/><?php else: ?><img src="<?php echo ($vo["avatar"]); ?>"/><?php endif; ?> </div>
                    
                    <div class="module-utit">
                        <div><?php echo ($vo["nickname"]); ?></div>
                        <div class="module-star">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <p class="module-ptime"></p>
                    </div>
                    <p><?php echo ($vo["content"]); ?></p>
                    <div class="pj-imgs clr">
                       <?php if(is_array($vo["pic"])): $i = 0; $__LIST__ = $vo["pic"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vp): $mod = ($i % 2 );++$i;?><div><img src="<?php echo ($vp["path"]); ?>"/></div><?php endforeach; endif; else: echo "" ;endif; ?>
<!--                        <div><img src="../../../static/wx/images/test003.png"/></div>
                        <div><img src="../../../static/wx/images/test004.png"/></div>
                        <div><img src="../../../static/wx/images/test005.png"/></div>-->

                    </div>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>

              <div class="pj-more"><a href="<?php echo U('Goods/details',array('goods_id'=>$info['goods_id']));?>">查看更多评论</a></div>
            </div>
            <!---     <?php if($comment_list): if(is_array($comment_list)): $i = 0; $__LIST__ = $comment_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$comment): $mod = ($i % 2 );++$i;?><!---<?php endforeach; endif; else: echo "" ;endif; ?>
                 <?php else: ?>
                 该商品暂无评价<?php endif; ?>           ---->
        </div>
        <div class="relation-panel">
            <h2 class="module-title">相关推荐</h2>
            <div class="relation-goods">
                <?php if(is_array($relation_goods)): $i = 0; $__LIST__ = $relation_goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Goods/index', ['goods_id' => $goods['goods_id']]);?>">
                        <div class="goods-tail">
                            <img class="img" src="<?php echo ($goods["goods_img"]); ?>" alt="<?php echo ($goods["goods_name"]); ?>" title="<?php echo ($goods["goods_name"]); ?>">
                            <div class="title"><?php echo ($goods["goods_name"]); ?></div>
                            <div class="price-con">
                                ￥<?php echo ($goods["price"]); ?>
                            </div>
                        </div>
                    </a><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
    </div>
    <div class="sku-confirm-box">
        <div class="shadow-model"></div>
        <div class="sku-confirm">
            <div class="goods-detail">
                <div class="img" style="background-image: url(<?php echo ($sku[0]['img']); ?>)"></div>
                <div class="title text-overflow"><?php echo ($info["goods_name"]); ?><i class="close"></i></div>
                <div class="price">￥<?php echo ($info["price"]); ?></div>
                <div class="sku-num">库存：<?php echo ($info["total_num"]); ?></div>
            </div>
            <div class="goods-sku">
                <div class="title">规格：</div>
                <div class="sku-item">
                    <?php if(is_array($sku)): $i = 0; $__LIST__ = $sku;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a data-sku="<?php echo ($vo["sku"]); ?>" data-img="<?php echo ($vo["img"]); ?>" data-num="<?php echo ($vo["sku_num"]); ?>"><?php echo ($vo["sku_name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div class="num-controller">
                数量：<a class="dec lock" href="javascript:">-</a><input type="tel" value="1" class="num"><a class="inc lock" href="javascript:">+</a>
            </div>
            <a class="bottom-btn lock buy-soon" href="javascript:">提交</a>
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
        var _buy_soon = "<?php echo U('Order/buySoon');?>";
    </script>
    <script src="/static/wx/js/goods.js?v=0.01"></script>

</body>
</html>