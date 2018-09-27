$(function(){
    TouchSlide({
            slideCell: "#slide-box",
            mainCell: ".slide-panel",
            titCell: ".slide-point li",
            effect: 'leftLoop',
            autoPlay: true,
            interTime: 3500
        });
    var $sku = $('.sku-item a');
    var _maxInput = 1;
    var $buySoon = $('.buy-soon');
    var $skuBox = $('.sku-confirm-box');
    var $close = $skuBox.find('.close');
    var $toBuy = $('.to-buy');
    var $inc = $('.num-controller .inc');
    var $dec = $('.num-controller .dec');
    var $num = $('.num-controller .num');
    $sku.each(function(){
        if(!$(this).attr('data-num')){
            $(this).addClass('lock');
        }
    });
    $sku.click(function(){
        if($(this).hasClass('lock')){
            return false;
        }
        $(this).addClass('active').siblings().removeClass('active');
        $buySoon.removeClass('lock');
        _maxInput = parseInt($(this).attr('data-num'));
        $num.val(1);
        checkNum();
    });
    $close.click(function(){
        $skuBox.fadeOut();
    });
    $toBuy.click(function(){
        $skuBox.fadeIn();
    });
    $inc.click(function(){
        if($(this).hasClass('lock')){
            return false;
        }
        $num.val(parseInt($num.val()) + 1);
        checkNum();
    });
    $dec.click(function(){
        if($(this).hasClass('lock')){
            return false;
        }
        $num.val(parseInt($num.val()) - 1);
        checkNum();
    });
    $num.change(checkNum);
    function checkNum(){
        var num = parseInt($num.val());
        num = num || 1;
        num = Math.min(_maxInput, num);
        num = Math.max(1, num);
        $num.val(num);
        if(_maxInput == 1){
            $dec.addClass('lock');
            $inc.addClass('lock');
        }else{
            if(num <= 1){
                $dec.addClass('lock');
            }else{
                $dec.removeClass('lock');
            }
            if(num >= _maxInput){
                $inc.addClass('lock');
            }else{
                $inc.removeClass('lock');
            }
        }
    }
    $buySoon.click(function(){
        if($(this).hasClass('lock')){
            return false;
        }
        var sku = $sku.filter('.active').attr('data-sku');
        var num = $num.val();
        location.href = _buy_soon + '?sku=' + sku + '&num=' + num;
    });


});