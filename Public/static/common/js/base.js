//  是否微信浏览器
function isWeiXinWindow(){
    var ua = window.navigator.userAgent.toLowerCase()+"";
    if(ua.indexOf("micromessenger") != -1){
        return true;
    } else {
        return false;
    }
}
function isContact(str){
   return isPhone(str)||isTel(str);
}
function isIMEI(str){
	var partten = /^(\d{15}|\d{17})$/;
	return partten.test(str);
}
function isPhone(str){
	var partten = /^1[3,4,5,7,8]\d{9}$/;
	return partten.test(str);
}
function isTel(inpurStr){
	partten = /^(\d{3,4}\-)?\d{7,8}$/i;    //带横线 电话号码
    if(partten.test(inpurStr)){
         return true;
    }
    partten = /^0(([1-9]\d)|([3-9]\d{2}))\d{8}$/;    //不带横向电话号码
    if(partten.test(inpurStr)){
         return true;
    }
    return false;    //如果都不是 返回  false
}
//身份证
function isIDCard(str) {
	var pattern = /\d{17}[\d|x]|\d{15}/;
	return pattern.test(str);
}
//支付宝
function isALiPay(str){
    var reg=/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
    var newReg=/^(13[0-9]|14[0-9]|15[0-9]|18[0-9])\d{8}$/;
    if(newReg.test(str) || reg.test(str)){
        return true;
    }
}
//微信号
function isWeixin(wx){
    var reg=/^[a-zA-Z\d_]{5,}$/;
    if(reg.test(wx)){
        return true;
    }
}
//银行卡
function BankCard(bCard){
    var reg=/^\d{19}|\d{16}$/;
    if(reg.test(bCard)){
        return true;
    }
}
//邮箱
function isEmail(str){
    var partten =/^[a-zA-Z0-9_\-.]{1,}@[a-zA-Z0-9_\-]{1,}\.[a-zA-Z0-9_\-.]{1,}$/;
    if(partten.test(str)){
        return true;
    }
    return false;
}
function isFunction(func){
    return typeof(func) == 'function';
}
function isArray(obj) {
    return Object.prototype.toString.call(obj) === '[object Array]';
}
function getName(){
	var str = 'base';
	var timestamp = new Date().getTime();
	str += String(timestamp);
	str += String(parseInt(10000*Math.random()));
	if($('.'+str).length > 0){
		str = getName();
	}
	return str;
}
function goTop(){
    $('html,body').animate({'scrollTop':0});
}
function trim(str){ //删除左右两端的空格
	try{
		return str.replace(/(^\s*)|(\s*$)/g, "");
	}catch(e){
		return '';
	}
}
var tips = new Object();
tips.alert = function(str){
    var className = getName();
    var zIndex = new Date().getTime();
    var html = '<div class="tips-alert '+className+'" style="z-index:'+zIndex+';">'+str+'</div>';
    $('body').append(html);
    var dom = $('.'+className);
    dom.css({'left': ($(window).width() - dom.outerWidth())/2 + 'px','margin-top':- dom.outerHeight()/2 + 'px'}).removeClass(className);
    setTimeout(function(){
        dom.fadeOut(3000,function(){
            dom.remove();
        });
    },200);
};
function showSearchPanel(is_es){
    var dom = $('.search-panel');
    if(dom.length > 0){
        dom.fadeIn();
        $('.getKeyword').focus();
    }else{
        var o = new Object();
        if(is_es === true){
            o.is_es = 1;
        }
        $.ajax({
            url : _searchPanel,
            data : o,
            success : function(res){
                $('body').append(res);
                dom = $('.search-panel');
                dom.fadeIn();
                $('.getKeyword').focus();
            }
        });
    }
}
// 比较两个对象是否相等
function object_equal( x, y ) {
// If both x and y are null or undefined and exactly the same
    if ( x === y ) {
        return true;
    }

// If they are not strictly equal, they both need to be Objects
    if ( ! ( x instanceof Object ) || ! ( y instanceof Object ) ) {
        return false;
    }

//They must have the exact same prototype chain,the closest we can do is
//test the constructor.
    if ( x.constructor !== y.constructor ) {
        return false;
    }

    for ( var p in x ) {
        //Inherited properties were tested using x.constructor === y.constructor
        if ( x.hasOwnProperty( p ) ) {
            // Allows comparing x[ p ] and y[ p ] when set to undefined
            if ( ! y.hasOwnProperty( p ) ) {
                return false;
            }

            // If they have the same strict value or identity then they are equal
            if ( x[ p ] === y[ p ] ) {
                continue;
            }

            // Numbers, Strings, Functions, Booleans must be strictly equal
            if ( typeof( x[ p ] ) !== "object" ) {
                return false;
            }

            // Objects and Arrays must be tested recursively
            if ( ! Object.equals( x[ p ], y[ p ] ) ) {
                return false;
            }
        }
    }

    for ( p in y ) {
        // allows x[ p ] to be set to undefined
        if ( y.hasOwnProperty( p ) && ! x.hasOwnProperty( p ) ) {
            return false;
        }
    }
    return true;
};
function in_array(search,array){
    for(var i in array){
        if(array[i]==search){
            return true;
        }
    }
    return false;
}
function array_unique(a) { // 去重
    var r = [];
    for(var i = 0; i < a.length; i ++) {
        var flag = true;
        var temp = a[i];
        for(var j = 0; j < r.length; j ++) {
            if(temp === r[j]) {
                flag = false;
                break;
            }
        }
        if(flag) {
            r.push(temp);
        }
    }
    return r;
}
function array_intersect(a, b) { // 交集
    var result = [];
    for(var i = 0; i < b.length; i ++) {
        var temp = b[i];
        for(var j = 0; j < a.length; j ++) {
            if(temp === a[j]) {
                result.push(temp);
                break;
            }
        }
    }
    return array_unique(result);
}
function array_rmvChild(child_a, parent_a) {
	for(var i = 0; i < child_a.length; i++){
		parent_a.splice(parent_a.indexOf(child_a[i]), 1)
	}
	return parent_a
}

/* 并集 */
function array_merge() {
    if(arguments.length <= 0){
        return false;
    }
    if(arguments.length == 1){
        return array_unique(array_unique[0]);
    }
    var arr = new Array();
    for(var i = 0; i < arguments.length; i++){
        for(j = 0; j < arguments[i].length; j++){
            if(!in_array(arguments[i][j],arr)){
                arr.push(arguments[i][j]);
            }
        }
    }
    return arr;
}
// 判断child [a,b,c]  是否包含于 parent [b,a,c,d]
function array_own(child_array,parent_array){
	var o = new Object()
	if(array_intersect(child_array,parent_array).length === child_array.length){
		o.included = true
		o.arr = parent_array
	}else{
		o.included = false;
	}
	return o
}
//合并数组中的子数组 [[1,2],[2,3]] => [1,2,3]
function concatArr(array) {
	var concatArr = new Array();
	var newArr = new Array();
	var map = {};
	if(array !== null){
		for(var i = 0 ; i < array.length ; i++){
			concatArr = concatArr.concat(array[i]);
		}
		for(var j = 0 ; j < concatArr.length ; j++){
			var k = concatArr[j];
			if(!map[k]){
				newArr.push(k);
				map[k] = 'o';
			}
		}
		return newArr;
	}
}
// 复制数组，或者对象，因为js数组对象会共用内存
function object_array_copy($a){
    if(typeof($a) != "object"){
        return $a;
    }
    if(isArray($a)){
        $b = array_copy($a);
    }else{
        $b = object_copy($a);
    }
    return $b;
}

function object_copy($a){
    $b = {};
    for(var k in $a){
        $b[k] = $a[k];
    }
    return $b;
}
function array_copy($a){
    $b = [];
    for (var i = 0; i < $a.length; i++){
        $b[i] = $a[i];
    }
    return $b;
}

//非空数组，字符串
function nonEmptyArray(a) {
	return (a !== null && a !== undefined && a !== '' && a.length > 0)
}
function nonEmptyString(str) {
	return (str !== null && str !== undefined && str !== '')
}

//清空对象
//是否为整型
function isInteger(num) {
	return num % 1 === 0;
}
//清空
$(document).delegate('input.has-clear','input',function () {
	if($(this).val() === '' && $(this).siblings('.clear').length > 0){
		$(this).siblings('.clear').remove();
	}else if($(this).val() !== '' && $(this).siblings('.clear').length === 0){
		$(this).after('<a href="javascript:void(0)" class="clear"></a>')
	}
});
$(document).delegate('.clear','click',function () {
	$(this).parent().find('input').val('');
	$(this).remove();
});
//移除不要的东西
function removeDom(className) {
	var dom = $('.'+ className);
	if(dom.length > 0){
		dom.remove();
	}
}
//后退
$(document).delegate('.back-step','click',function (e) {
	e.stopPropagation();
	window.history.back();
});
//modal关闭
$(document).delegate('.close-modal','click',function () {
	var $this = $(this);
	var modal = $this.closest('.modal');
	switch($this.attr('data-style')){
		case 'fade-out':
			modal.fadeOut();
			if($this.hasClass('as-remove')){
				setTimeout(function () {
					modal.remove();
				},700);
			}
			break;
		case 'transform':
			modal.addClass('has-transform');
			setTimeout(function () {
				if($this.hasClass('as-remove')){
					modal.remove();
				}else{
					modal.hide();
				}
			},700);
			break;
		default:
			modal.hide();
			break;
	}
});
//modal打开
$(document).delegate('.fade-in-modal','click',function () {
	var target = $(this).attr('data-target');
	$('.' + target).fadeIn();
});
//cookie
function setCookie(c_name,value,expiredays){
	var exdate = new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	document.cookie = c_name+ "=" +encodeURI(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString())+";path=/TraderShow";
}
function getCookie(c_name){
	if (document.cookie.length>0){
		c_start=document.cookie.indexOf(c_name + "=");
		if (c_start!=-1){
			c_start=c_start + c_name.length+1;
			c_end=document.cookie.indexOf(";",c_start);
			if (c_end==-1){
				c_end=document.cookie.length;
			}
			return decodeURI(document.cookie.substring(c_start,c_end));
		}
	}
	return "";
}
function delCookie(c_name){
	var exp = new Date();
	exp.setTime(exp.getTime() - 1);
	var cval = getCookie(c_name);
	if(cval!=null){
		document.cookie= c_name + "="+cval+";expires="+exp.toGMTString() + ";path=/TraderShow" ;
	}
}
//获取用户信息
function getUserInfo(callback) {
	var token = getCookie('token');
	$.ajax({
		type : 'GET',
		url : _user,
		data : {token : token},
		success : function (res) {
			if(res.status == 1){
				callback(res.info);
			}else{
				errorDirect()
			}
		}
	})
}

function errorDirect(info) {
	if(info === undefined || info === '登录超时'){
		delCookie('token')
		tips.alert('登录已过期，3秒后自动跳转登录页面')
		setTimeout(function () {
			location.href = _LOGIN_PAGE
		}, 3000)
	}else{
		tips.alert(info)
	}
}

//获取品牌
function getBrandList(page,size,callback) {
	var o = new Object;
    o.brand_page = page;
    o.pageSize = size;
	$.ajax({
		type : 'GET',
		url : _getBrands,
		data : o,
		success : function (res) {
			callback(res)
		}
	})
}
//获取机型
function getMachineList(brand_id, page, size, callback) {
	var o = new Object;
	o.brand_id = brand_id;
	o.machine_page = page;
	o.pageSize = size;
	$.ajax({
		type : 'GET',
		url : _getMachines,
		data : o,
		success : function (res) {
			callback(res)
		}
	})
}

//警告tips
function showWarningTips(content, top, left, dom) {
	var className = getName();
	var zIndex = new Date().getTime();
	var html = '<div class="warning-tips '+className+'" style="z-index:'+zIndex+';">'+content+'</div>';
	dom.append(html);
	var tips = $('.'+className);
	tips.css({'left': left + 'px','top': top + 'px'}).removeClass(className);
	setTimeout(function(){
		tips.fadeOut(3000,function(){
			tips.remove();
		});
	},200);
}

//时间转换
function timeTransition(timestamp) {
	var unixTimestamp = new Date(timestamp * 1000);
	var year = unixTimestamp.getFullYear()
	var month = unixTimestamp.getMonth() + 1
	var day = unixTimestamp.getDate()
	var hour = unixTimestamp.getHours()
	var min = unixTimestamp.getMinutes()
	var second = unixTimestamp.getSeconds()
	if(hour < 10) {hour = '0' + hour}
	if(min < 10) {min = '0' + min}
	if(second < 10) {second = '0' + second}
	// return unixTimestamp.toLocaleString();
	return  (year + '-' + month + '-' + day + ' ' + hour + ':' + min + ':' + second)
}
function timeTransitionYMD(ts, is_all) { //中文表示
	var uts = new Date(ts * 1000);
	var y = uts.getFullYear();
	var m = uts.getMonth() + 1;
	var d = uts.getDate();
	var h = uts.getHours();
	var i = uts.getMinutes();
	var s = uts.getSeconds();
	if(is_all){
        return (y + '年' + m + '月' + d + '日' + ' ' + h + ':' + i + ':' + s);
	}else{
        return (y + '年' + m + '月' + d + '日')
	}

}
//去掉字符串中出现的空格
function stringTrim(str) {
	return str.replace(/\s/g,"");
}

//不为微信浏览器时的设置
function checkBrowser() {
	if(isWeiXinWindow() == false && !(typeof(is_webview) == "boolean" && is_webview)){
		var str = '<div class="browser-warning-box">';
		str += '<div class="warning-icon"></div>';
		str += '<p>请在微信客户端打开链接</p></div>';
		$('body').html(str);
	}
}

function doError(res,wait_time){
    if(typeof wait_time !== 'undefined'){
        wait_time = parseInt(wait_time);
    }
    if((typeof wait_time == 'undefined') || isNaN(wait_time)){
        wait_time = 3000;
    }
    if(res.status == 3) {
	    delCookie('token')
        setTimeout(toLogin, wait_time);
    }
    tips.alert(res.info);
}

function toLogin(){
    location.href = _LOGIN_PAGE + '?redirect=' + encodeURIComponent(location.href);
}

function getQueryStringArgs(){
    var qs = (location.search.length>0?location.search.substring(1):"");var args = {};
    var items = qs.split("&");
    var item = null,    name=null,    value=null;
    for(var i=0;i<items.length;i++){
        item=items[i].split("=");
        name=decodeURIComponent(item[0]);
        value=decodeURIComponent(item[1]);
        args[name]=value;
    }
    return args;
}