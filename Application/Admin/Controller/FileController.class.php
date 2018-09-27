<?php
namespace Admin\Controller;
use Think\Controller;
class FileController extends Controller {
    public function upload_json(){
        vendor('Keditor.upload_json');
    }
    public function file_manager_json(){
        vendor('Keditor.file_manager_json');
    }
    public function file_upload(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './static/upload/image/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件
        $file = $_FILES['photo'];
        if(!$file){
            $file = $_FILES['file'];
        }
        if(!$file){
            $file = $_FILES['images'];
        }
        $info   =   $upload->uploadOne($file);
        if(!$info) {// 上传错误提示错误信息
            sendError($upload->getError());
        }else{// 上传成功
            sendResult('/static/upload/image/'.$info['savepath'].$info['savename']);
        }
    }
}