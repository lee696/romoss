function doAjax(res, callback){
    if(res.status == 0){
        if($.isFunction(callback)){
            callback(res.data);
        }
    }else{
        layer.msg(res.msg);
    }
}
function goback(){
    history.go(-1);
}