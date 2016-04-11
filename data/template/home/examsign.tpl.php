<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header_home'); ?><div id="mainFrame" class="tableView">
	<div class="top">
    	<div class="right"><a class="button-green" href="/?m=exam" target="_blank">参与答题</a></div>
        <span>考生信息登记</span>
    </div>
	<form method="post" id="examineeForm" enctype="multipart/form-data">
    <input type="hidden" name="formsubmit" value="yes">
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
	<div class="itemRow">
        <div class="item-name">姓名</div>
        <div class="item-input"><input type="text" class="input-text" maxlength="20"  name="newexaminee[username]" value="<?php echo $examinee['username'];?>" id="username"></div>
        <div class="item-tips error" id="tips_name">请填写你的真实姓名</div>
    </div>
    <div class="itemRow">
        <div class="item-name">身份证号</div>
        <div class="item-input"><input type="text" class="input-text" maxlength="20"  name="newexaminee[idnumber]" value="<?php echo $examinee['idnumber'];?>" id="idnumber"></div>
        <div class="item-tips" id="tips_idnumber">请填写你的身份证号</div>
    </div>
    <div class="itemRow">
        <div class="item-name">联系电话</div>
        <div class="item-input"><input type="text" class="input-text" name="newexaminee[tel]" value="<?php echo $examinee['tel'];?>" id="tel"></div>
        <div class="item-tips error" id="tips_tel">请填写你的联系电话</div>
    </div>
    <div class="itemRow">
        <div class="item-name">微信号码</div>
        <div class="item-input"><input type="text" class="input-text" name="newexaminee[weixin]" value="<?php echo $examinee['weixin'];?>" id="weixin"></div>
        <div class="item-tips error" id="tips_weixin">请填写你的微信号码</div>
    </div>
    <div class="itemRow">
        <div class="item-name">所在省</div>
        <div class="item-input"><input type="text" class="input-text" name="newexaminee[province]" value="贵州" id="province" readonly></div>
        <div class="item-tips error" id="tips_province">请选择所在省</div>
    </div>
    <div class="itemRow">
        <div class="item-name">所在市</div>
        <div class="item-input"><input type="text" class="input-text" name="newexaminee[city]" value="六盘水" id="city" readonly></div>
        <div class="item-tips error" id="tips_city">请选择所在市</div>
    </div>
    <div class="itemRow">
        <div class="item-name">所在县</div>
        <div class="item-input"><input type="text" class="input-text" name="newexaminee[county]" value="盘县" id="county"></div>
        <div class="item-tips error" id="tips_county">请选择所在县</div>
    </div>
    <div class="itemRow">
        <div class="item-name">所在乡镇</div>
        <div class="item-input">
        	<select class="input-select" name="newexaminee[town]">
            <?php if(is_array($townlist)) { foreach($townlist as $list) { ?>            <option value="<?php echo $list['name'];?>"<?php if($examinee['town']==$list['name']) { ?> selected<?php } ?>><?php echo $list['name'];?></option>
            <?php } } ?>            </select>
        </div>
    	<div class="item-tips error" id="tips_town">请选择所在乡镇</div>
    </div>
    <div class="itemRow">
        <div class="item-name">所在单位</div>
        <div class="item-input"><input type="text" class="input-text" name="newexaminee[company]" value="<?php echo $examinee['company'];?>" id="company"></div>
        <div class="item-tips error" id="tips_company">请填写你的单位名称</div>
    </div>
    <div class="itemRow">
        <div class="item-name">&nbsp;</div>
        <div class="item-input"><input type="submit" class="button submit" value="提交"></div>
        <div class="item-tips"></div>
    </div>
    </form>
</div>
<script type="text/javascript">
var optionhtml = '<option value="">请选择省份</option>';
$.ajax({
	url:'/?m=common&c=district&a=fetchdistrict&fid=0',
	dataType:'json',
	success: function(json){
		if(json.errno == 0){
			for(var k in json.data){
				var optionitem = json.data[k];
				optionhtml+= '<option idvalue="'+optionitem.id+'" value="'+
				optionitem.name+'"'+((optionitem.name == "<?php echo $shop['province'];?>") ? '  selected="selected"' : '')+'>'+optionitem.name+'</option>';
				
			}
			$("#province").html(optionhtml);
			var province = $("#province").find("option:selected").attr("idvalue");
			showCity(province);
		}
	}
});
$("#province").change(function(){
	var province = $(this).find("option:selected").attr("idvalue");
	showCity(province);
});
function showCity(province){
	if(!province) return;
	var Options = '<option value="">请选择城市</option>';
	$.ajax({
		url:'/?m=common&c=district&a=fetchdistrict&fid='+province,
		dataType:'json',
		success: function(json){
			for(var k in json.data){
				var optionitem = json.data[k];
				Options+= '<option idvalue="'+optionitem.id+'" value="'+
				optionitem.name+'"'+((optionitem.name == "<?php echo $shop['city'];?>") ? '  selected="selected"' : '')+'>'+optionitem.name+'</option>';
				
			}
			$("#city").html(Options);
		}
	});
}
$("#examineeForm").submit(function(){
	if(!isUsername($("#username").val())){
		$("#tips_name").show();
		return false;
	}else {
		$("#tips_name").hide();
	}
	if(!isIdCardNo($("#idnumber").val())){
		$("#tips_idnumber").show();
		return false;
	}else {
		$("#tips_idnumber").hide();
	}
	
	if(!($("#tel").val())){
		$("#tips_tel").show();
		return false;
	}else {
		$("#tips_tel").hide();
	}
	return true;
});

function isUsername(name){
	var Re = /[^0-9a-zA-Z,./ <> ?`!@#$%^&*()_+|\=-]/;
	return Re.test(name);
}
//--身份证号码验证-支持新的带x身份证
function isIdCardNo(num){
var factorArr = new Array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2,1);
var error;
var varArray = new Array();
var intValue;
var lngProduct = 0;
var intCheckDigit;
var intStrLen = num.length;
var idNumber = num;
// initialize
if ((intStrLen != 15) && (intStrLen != 18)) {
//error = "输入身份证号码长度不对！";
//alert(error);
//frmAddUser.txtIDCard.focus();
return false;
}
// check and set value
for(i=0;i<intStrLen;i++) {
varArray[i] = idNumber.charAt(i);
if ((varArray[i] < '0' || varArray[i] > '9') && (i != 17)) {
//error = "错误的身份证号码！.";
//alert(error);
//frmAddUser.txtIDCard.focus();
return false;
} else if (i < 17) {
varArray[i] = varArray[i]*factorArr[i];
}
}
if (intStrLen == 18) {
//check date
var date8 = idNumber.substring(6,14);
if (checkDate(date8) == false) {
//error = "身份证中日期信息不正确！.";
//alert(error);
return false;
}
// calculate the sum of the products
for(i=0;i<17;i++) {
lngProduct = lngProduct + varArray[i];
}
// calculate the check digit
intCheckDigit = 12 - lngProduct % 11;
switch (intCheckDigit) {
case 10:
intCheckDigit = 'X';
break;
case 11:
intCheckDigit = 0;
break;
case 12:
intCheckDigit = 1;
break;
}
// check last digit
if (varArray[17].toUpperCase() != intCheckDigit) {
//error = "身份证效验位错误!...正确为： " + intCheckDigit + ".";
//alert(error);
return false;
}
}
else{ //length is 15
//check date
var date6 = idNumber.substring(6,12);
if (checkDate(date6) == false) {
//alert("身份证日期信息有误！.");
return false;
}
}
//alert ("Correct.");
return true;
}

function checkDate(date)
{
return true;
} 
</script><?php include template('footer_home'); ?>