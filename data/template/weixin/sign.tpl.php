<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('weixin_header'); ?><div id="weixin" class="sign">
	<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="formsubmit" value="yes">
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
    <input type="hidden" name="longitude" value="" id="longitude">
    <input type="hidden" name="latitude" value="" id="latitude">
    <input type="hidden" name="location" value="" id="location">
	<div class="row">签到时间: <span id="signtime"><?php echo $signtime;?></span></div>
    <div class="row">签到位置: <span id="signlocation">正在获取位置信息..</span></div>
    <div class="row"><textarea class="textarea" placeholder="备注信息" name="remark"></textarea></div>
    <div class="row addphoto">
    	<div id="preview"></div>
    	<i class="icon">&#xf019e;</i>拍照<input type="file" class="file" name="filedata" id="filedata">
    </div>
    <div class="button-hd"><button type="submit" class="bigbutton">签到</button></div>
    </form>
</div>
<script type="text/javascript">
function getLocation(){ 
    if (navigator.geolocation){ 
        navigator.geolocation.getCurrentPosition(showPosition,showError); 
    }else{ 
        showIP(); 
    } 
}

function showIP(){
	$("#longitude").val('<?php echo $longitude;?>');
	$("#latitude").val('<?php echo $latitude;?>');
	$("#location").val('<?php echo $signlocation;?>');
	$("#signlocation").text('<?php echo $signlocation;?>');
}

function showPosition(position){ 
    var lat = position.coords.latitude; //纬度 
    var lng = position.coords.longitude; //经度 
    //alert('纬度:'+lat+',经度:'+lag);
	$("#longitude").val(lng);
	$("#latitude").val(lat);
	$.ajax({
		url:'/?m=weixin&c=sign&a=getlocation&longitude='+lng+'&latitude='+lat,
		dataType:"json",
		success: function(json){
			if(json.errno == 0){
				$("#location").val(json.data.location);
				$("#signlocation").text(json.data.location);
			}
		}
	});
} 

function showError(error){ 
    switch(error.code) { 
        case error.PERMISSION_DENIED: 
            alert("定位失败,用户拒绝请求地理定位"); 
            break; 
        case error.POSITION_UNAVAILABLE: 
            alert("定位失败,位置信息是不可用"); 
            break; 
        case error.TIMEOUT: 
            alert("定位失败,请求获取用户位置超时"); 
            break; 
        case error.UNKNOWN_ERROR: 
            alert("定位失败,定位系统失效"); 
            break; 
    } 
}
getLocation();
$("#filedata").change(function(){
	var objUrl = getObjectURL(this.files[0]) ;
	console.log("objUrl = "+objUrl) ;
	if (objUrl) {
		//$("#img0").attr("src", objUrl) ;
		$("#preview").html('<img src="'+objUrl+'" width="50" height="50" />');
	}
}) ;
//建立一個可存取到該file的url
function getObjectURL(file) {
	var url = null ; 
	if (window.createObjectURL!=undefined) { // basic
		url = window.createObjectURL(file) ;
	} else if (window.URL!=undefined) { // mozilla(firefox)
		url = window.URL.createObjectURL(file) ;
	} else if (window.webkitURL!=undefined) { // webkit or chrome
		url = window.webkitURL.createObjectURL(file) ;
	}
	return url ;
}
</script><?php include template('weixin_footer'); ?>