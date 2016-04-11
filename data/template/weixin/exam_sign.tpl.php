<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('weixin_header'); ?><div id="weixin" style="padding:20px 10px;">
	<form method="post" id="examineeForm">
    <input type="hidden" name="formsubmit" value="yes">
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
    <input type="hidden" name="examineeid" value="<?php echo $examinee['uid'];?>">
    <input type="hidden" name="newexaminee[province]" value="贵州">
    <input type="hidden" name="newexaminee[city]" value="六盘水">
    <input type="hidden" name="newexaminee[county]" value="盘县">
    <?php if($examinee['uid']) { ?>
    <div class="rowItem">
    	<h3>姓名:</h3>
       <div class="inputdiv"><input type="text" class="input-text" value="<?php echo $examinee['username'];?>" disabled></div>
       <input type="hidden" name="newexaminee[username]" value="<?php echo $examinee['username'];?>" id="username">
   </div>
   <div class="rowItem">
       <h3>身份证号:</h3>
       <div class="inputdiv"><input type="text" class="input-text" value="<?php echo $examinee['idnumber'];?>" disabled></div>
       <input type="hidden" name="newexaminee[idnumber]" value="<?php echo $examinee['idnumber'];?>" id="idnumber">
   </div>
    <?php } else { ?>
	<div class="rowItem">
    	<h3>姓名:</h3>
       <div class="inputdiv"><input type="text" class="input-text" name="newexaminee[username]" value="<?php echo $examinee['username'];?>" id="username"></div>
   </div>
   <div class="rowItem">
       <h3>身份证号:</h3>
       <div class="inputdiv"><input type="text" class="input-text" name="newexaminee[idnumber]" value="<?php echo $examinee['idnumber'];?>" id="idnumber"></div>
   </div>
   <?php } ?>
   <div class="rowItem">
       <h3>联系电话:</h3>
       <div class="inputdiv"><input type="text" class="input-text" name="newexaminee[tel]" value="<?php echo $examinee['tel'];?>" id="tel"></div>
   </div>
   <div class="rowItem">
       <h3>微信号码:</h3>
       <div class="inputdiv"><input type="text" class="input-text" name="newexaminee[weixin]" value="<?php echo $examinee['weixin'];?>"></div>
   </div>
   <div class="rowItem">
       <h3>所在乡镇:</h3>
       <div class="inputdiv">
       		<select class="select" name="newexaminee[town]">
       <?php if(is_array($townlist)) { foreach($townlist as $list) { ?>            <option value="<?php echo $list['name'];?>"<?php if($list['name']==$examinee['town']) { ?> selected<?php } ?>><?php echo $list['name'];?></option>
           <?php } } ?>           </select>
       </div>
   </div>
   <div class="rowItem">
       <h3>所在单位:</h3>
       <div class="inputdiv"><input type="text" class="input-text" name="newexaminee[company]" value="<?php echo $examinee['company'];?>"></div>
    </div>
    <div class="button-hd"><button type="submit" class="bigbutton">提交</button></div>
    </form>
</div>
<script type="text/javascript">
$("#examineeForm").submit(function(){
	<?php if(!$examinee['uid']) { ?>
	if(!isUsername($("#username").val())){
		alert('请填写姓名');
		return false;
	}
	if(!isIdCardNo($("#idnumber").val())){
		alert('请填写身份证号');
		return false;
	}
	<?php } ?>
	if(!($("#tel").val())){
		alert('请填写联系电话');
		return false;
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
</script><?php include template('weixin_tabbar'); include template('weixin_footer'); ?>