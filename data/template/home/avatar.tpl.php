<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header_home'); ?><script src="/static/js/webcam.js" type="text/javascript"></script>
<script src="/static/js/jquery.Jcrop.js" type="text/javascript"></script>
<div id="mainFrame">
  <div id="setting-face-upload">
  <div class="setting-tab-bar" id="setting-tab-bar">
  	<span class="tab-item tab-cur">上传照片</span>
    <span class="tab-item">在线拍照</span>
  </div>
  <div class="setting-face-wrap">
  		<div class="setting-face-view">
            <div><img id="facebig" src="<?php echo $avatarbig;?>" class="big" /><p>大头像预览</p></div>
            <dl>
            	<dd><img id="facemiddle" src="<?php echo $avatarmiddle;?>" class="middle" /><p>中头像</p></dd>
                <dt><img id="facesmall" src="<?php echo $avatarsmall;?>" class="small" /><p>小头像</p></dt>
            </dl>
        </div>
        <div class="setting-face-actions" id="setting-face-actions">
        	<div class="action-item">
            	<form method="post" name="face" id="formupload" enctype="multipart/form-data">
                	<span class="upload-button" id="upload-button"><i class="icon">&#xf0024;</i>上传照片<input type="file" name="filedata" class="input-file" onchange="uploadPhoto()" /></span>
                </form>
                <div class="upload-tips">仅支持JPG、JPEG、PNG格式（2M以下）</div>
            </div>
            <div class="action-item" style="display:none;">
            	<div id="cam"></div>
                <div class="upload-tips"><span class="cam-button" id="cam-button">点击这里拍照</span></div>
            </div>
        </div>
  </div>
  </div>
<link rel="stylesheet" type="text/css" href="/static/css/jquery.jcrop.css"/>
<div class="setting-face-crop" id="setting-face-crop" style="display:none;">
	<div class="crop-view">
    	<div id="tempimg"><img id="sourceimg" src=""></div>
        <p class="buttonview">
        	<span class="button submit" tabindex="1" id="button-save">保存</span>
            <span class="button" tabindex="1" id="button-cancel">取消</span>
        </p>
        <form method="post" id="formimg">
        	 <input type="hidden" id="src" name="src" value="">
        	 <input type="hidden" id="img_x" name="img[x]" value="">
            <input type="hidden" id="img_y" name="img[y]" value="">
            <input type="hidden" id="img_w" name="img[w]" value="">
            <input type="hidden" id="img_h" name="img[h]" value="">
        </form>
    </div>
    <div class="preview">
    	<h3>图像预览</h3>
        <div class="imageview" id="imageview"><img id="preview" src="" /></div>
    </div>
    <div class="clearfix"></div>
</div>
<script type="text/javascript">
$("#setting-tab-bar .tab-item").click(function(){
	$(this).addClass('tab-cur').siblings().removeClass('tab-cur');
	$("#setting-face-actions .action-item").eq($(this).index()).show().siblings().hide();
});
function initCrop(){
	$("#sourceimg").Jcrop({
		onChange:showPreview,
		onSelect:showPreview,
		aspectRatio:1,
		setSelect: [40,40,190,190],
		minSize:[150,150]
	});	
}
function saveCrop(){
	var loading = null;
	$("#formimg").ajaxSubmit({
		dataType:'json',
		url:'/?m=home&c=avatar&a=crop',
		beforeSubmit:function(){loading = DSXUI.showloading('正在保存照片...');},
		success:function(json){
			if(json.errno == 0){
				loading.close();
				DSXUI.success('头像保存成功',function(){document.location.reload();});
			}
		}
	});
}
//简单的事件处理程序，响应自onChange,onSelect事件，按照上面的Jcrop调用
function showPreview(coords){
	$("#img_x").val(coords.x);
	$("#img_y").val(coords.y);
	$("#img_w").val(coords.w);
	$("#img_h").val(coords.h);
	if(parseInt(coords.w) > 0){
		//计算预览区域图片缩放的比例，通过计算显示区域的宽度(与高度)与剪裁的宽度(与高度)之比得到
		var rx = $("#imageview").width() / coords.w; 
		var ry = $("#imageview").height() / coords.h;
		//通过比例值控制图片的样式与显示
		$("#preview").css({
			width:Math.round(rx * $("#sourceimg").width()) + "px",	//预览图片宽度为计算比例值与原图片宽度的乘积
			height:Math.round(rx * $("#sourceimg").height()) + "px",	//预览图片高度为计算比例值与原图片高度的乘积
			marginLeft:"-" + Math.round(rx * coords.x) + "px",
			marginTop:"-" + Math.round(ry * coords.y) + "px"
		});
	}
}
function uploadPhoto(){
	var loading = null;
	$("#formupload").ajaxSubmit({
		dataType:'json',
		url:'/?m=home&c=avatar&a=upload',
		beforeSubmit:function(){loading = DSXUI.showloading('正在上传图片...');},
		success:function(json){
		if(json.state){
			loading.close();
			$("#sourceimg").attr("src",json.data.url);
			$("#preview").attr("src",json.data.url);
			$("#src").val(json.data.attachment);
			$("#setting-face-upload").hide();
			$("#setting-face-crop").show();
			initCrop();
		}
	}});
}
;(function(){
	var loading = null;
	var camera = $("#cam");
	webcam.set_swf_url('/static/swf/webcam.swf');
	webcam.set_api_url('/?m=home&c=avatar&a=snap');
	webcam.set_quality(100); // JPEG quality (1 - 100)
	webcam.set_shutter_sound(true,'/static/media/shutter.mp3'); // play shutter click soun
	camera.html(webcam.get_html(300, 250, 300,250));
	webcam.set_hook('onComplete',function(c){
		var json = $.parseJSON(c);
		if(json.errno == 0){
			//loading.close();
			$("#sourceimg").attr("src",json.data.url);
			$("#preview").attr("src",json.data.url);
			$("#src").val(json.data.attachment);
			$("#setting-face-upload").hide();
			$("#setting-face-crop").show();
			initCrop();
		}
		webcam.reset();
	});
	$("#cam-button").bind('click',function(){
		webcam.snap();
		//DSXUI.showloading('正在上传图片...');
	});
	$("#upload-button").click(function(){
		$(this).addClass('current');
		$("#tab-takephoto").removeClass('current');
		$("#content-upload").show();
		$("#content-takephoto").hide();
	});
	$("#tab-takephoto").click(function(){
		$(this).addClass('current');
		$("#tab-upload").removeClass('current');
		$("#content-upload").hide();
		$("#content-takephoto").show();
	});
	$("#button-save").click(function(){
		saveCrop();
	});
	$("#button-cancel").click(function(){
		$("#setting-face-crop").hide();
		$("#setting-face-upload").show();
	});
	$(".jcrop-tracker").live('dblclick',function(){saveCrop();});
})();
</script>
</div><?php include template('footer_home'); ?>