<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('post_title'); ?><div class="newpost-content" id="p-content-postdata">
  <h3 class="content-sub-title">上传照片</h3>
  <div id="image-upload-queue" class="content-body">
  	  <?php if(is_array($piclist)) { foreach($piclist as $pic) { ?>      <?php $key=$pic['photoid']; ?>      <div id="file_SWFUpload_0_0" class="image-item">
        <input type="hidden" value="<?php echo $pic['photoid'];?>" class="photoid" name="piclist[<?php echo $key;?>][photoid]">
    	<input type="hidden" value="<?php echo $pic['thumb'];?>" class="thumb" name="piclist[<?php echo $key;?>][thumb]">
    	<input type="hidden" value="<?php echo $pic['attachment'];?>" class="attachment" name="piclist[<?php echo $key;?>][attachment]">
        <div class="image"><span title="删除" class="icon close" onclick="deleteItem(this)">&#xf029a;</span><img src="<?php echo $pic['attachment'];?>"></div>
        <div class="description"><textarea placeholder="在这里输入图片说明" name="piclist[<?php echo $key;?>][description]" class="textarea-summary textarea"><?php echo $pic['description'];?></textarea></div>
     </div>
     <?php } } ?>  </div>
  <div class="content-body">
  <div id="btn-upload-image"></div>
      <p>
        ·可以同时选择多张图片进行批量上传 (注:一次最多同时上传50张图片)<br>
          ·单张图最大为5M，支持jpeg,gif,jpg,png格式，如果上传失败，请尝试小一点的图片。
      </p>
 </div>
</div><?php $token=sha1($G['uid'].$G['username'].formhash()); ?><script src="/static/uploadify/jquery.uploadify-3.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
function deleteItem(obj){
	if(confirm('你确定要删除吗?')){
		$(obj).parent().parent().remove();
	}
}
(function(){
  var files = [];
  var imageCount = 0;
  var upload_options = {
      swf:'/static/uploadify/uploadify.swf',
      uploader:'/?m=common&c=upload&a=uploadimage&uploadtype=swfupload',
      queueID:'upload-queue-div',
      buttonClass:'input-uploadify input-publish',
      auto:true,
      width:120,
      height:38,
      multi:true,
      queueSizeLimit:50,
      fileSizeLimit:'5MB',
      fileObjName:'filedata',
      buttonText:'<i class="icon">&#xf0175;</i>添加照片',
      fileTypeDesc:'图片',
      fileTypeExts:'*.jpg;*.jpeg;*.png;*.gif',
      removeCompleted:false,
      checkExisting:false,
      formData:{'uid':'<?php echo $G['uid'];?>','username':'<?php echo $G['username'];?>','token':'<?php echo $token;?>'},
      onSelect:function(file){
		   imageCount++;
		   var html = $("#tplItem").html();
		   html = html.replace(/\{fileid\}/g,'file_'+file.id);
		   html = html.replace(/\{filename\}/g,file.name);
		   html = html.replace(/\{key\}/g,imageCount);
          $("#image-upload-queue").append(html);
      },
      onQueueComplete:function(file,data,response){
      },
      onUploadSuccess:function(file, data, response){
          var json = $.parseJSON(data);
          if(json.errno == 0){					
              $("#file_"+file.id).find(".photoid").val(json.data.photoid);
			   $("#file_"+file.id).find(".thumb").val(json.data.thumb);
			   $("#file_"+file.id).find(".attachment").val(json.data.attachment);
              $("#file_"+file.id).find(".image").html('<span class="icon close" title="删除">&#xf029a;</span><img src="'+json.data.url+'">');
              $("#file_"+file.id).find(".close").click(function(){
                  if(confirm('你确定要删除吗?')){
                      $("#file_"+file.id).remove();
                  }
              });
          }else{
              alert(json.error);
          }
      }
  }
  $("#btn-upload-image").uploadify(upload_options);
})();
</script>
<script type="text/template" id="tplItem">
<div class="image-item" id="{<?php echo fileid;?>}">
    <input type="hidden" name="piclist[{<?php echo key;?>}][photoid]" class="photoid" value="">
	<input type="hidden" name="piclist[{<?php echo key;?>}][thumb]" class="thumb" value="">
	<input type="hidden" name="piclist[{<?php echo key;?>}][attachment]" class="attachment" value="">
    <div class="image">{<?php echo filename;?>}<span class="loading"></span></div>
    <div class="description"><textarea class="textarea-summary textarea" name="piclist[{<?php echo key;?>}][description]" placeholder="在这里输入图片说明"></textarea></div>
</div>
</script><?php include template('post_attribute'); ?>