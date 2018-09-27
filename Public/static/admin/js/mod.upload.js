function UploadAttachment(ARG){
      var btnTxt=ARG.btnTxt || '上传图片';
      var fileFormat=ARG.fileFormat || '*.gif; *.jpg; *.png; *.jpeg;';
      var sizeLimit=ARG.sizeLimit || '5MB';
      var fileEl=ARG.fileEl;
      var hiddenEl=ARG.hiddenEl;
      var resultEl=ARG.resultEl;
      var fileLimit=ARG.fileLimit || 999;
      var width=ARG.width || 120;
      var height=ARG.width || 32;
      if(fileEl.length==1){
          fileEl.uploadify({
              'buttonClass':'',
              'width':width,
              'height':height,
              'buttonText':'<i class="am-icon-upload"></i> '+btnTxt,
              'uploadLimit':fileLimit,
              'fileTypeExts':fileFormat,
              'fileSizeLimit':sizeLimit,
              'swf':window._STATIC_+'/img/upload-swf.swf',
              'queueID':'ZSUploadBox',
              'uploader':window._UPLOAD_,
              'onUploadProgress':function (file, bytesUploaded, bytesTotal, totalBytesUploaded, totalBytesTotal) {
                var percent=((bytesUploaded / bytesTotal).toFixed(2)*100);
                resultEl.html('<i class="am-icon-spinner icon-spin"></i> 正在上传...'+percent+'%').show();
          },
          'onUploadStart':function () {
              resultEl.html('<i class="am-icon-spinner icon-spin"></i> 正在上传...').show();
          },
          'formData':{'sessionid':fileEl.attr('data-sid'),'type':'submit','is_preview':1},
          'removeTimeout':0,
          'multi':false,
          'onFallback':function () {
              resultEl.html('上传失败，请重试 :(').show();
          },
          'onUploadSuccess':function (file, str, response) {
              var data = eval('(' + str + ')');
              if (ARG.callback) {
            	  ARG.callback(data);
              } else {
            	  if (response && data.code == 200) {
                        resultEl.html('<img src="'+data.url+'" alt=""/><a href="javascript:;" class="red J_removeAtt"> <i class="icon-trash"></i> 删除</a>').show();
                        hiddenEl.val(data.url);
                   } else {
                	   resultEl.html(data.message);
                   }
              } 
          }
        });
        //删除
        resultEl.delegate('.J_removeAtt','click',function(){
          resultEl.html('').hide();
              hiddenEl.val('');
        });
      }
    } 