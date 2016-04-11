<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $G['title'];?> - <?php echo $G['setting']['sitename'];?></title>
<meta name="keywords" content="<?php echo $G['keywords'];?>">
<meta name="description" content="<?php echo $G['description'];?>">
<link rel="icon" href="/static/images/common/favicon.ico">
<link rel="stylesheet" type="text/css" href="/static/css/common.css">
<link rel="stylesheet" type="text/css" href="/static/css/exam.css">
<script src="/static/js/jquery.js" type="text/javascript"></script>
<script src="/static/js/common.js" type="text/javascript"></script>
<script src="/static/js/jquery.form.js" type="text/javascript"></script>
<script src="/static/js/jquery.dsxui.js" type="text/javascript"></script>
<script src="/static/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
</head>
<body>
<div id="paper">
<h1><?php echo $paper_config['name'];?></h1>
<p class="tips">提示:<?php echo $paper_config['tips'];?></p>
<form method="post" id="paperForm">
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<input type="hidden" name="formsubmit" value="yes">
<input type="hidden" name="uid" value="<?php echo $G['uid'];?>">
<input type="hidden" name="recordid" value="<?php echo $record['recordid'];?>"><?php if(is_array($paper_types)) { foreach($paper_types as $type) { ?><div id="type_<?php echo $type['typeid'];?>">
<h1><?php echo $type['typename'];?></h1>
	<div class="content" id="content_<?php echo $type['typeid'];?>">
    <?php $orderno=1; if(is_array($subjectlist[$type['typeid']])) { foreach($subjectlist[$type['typeid']] as $subject) { ?>    <h3 id="subject_<?php echo $subject['id'];?>"><?php echo $orderno;?>、<?php echo $subject['subject'];?></h3>
    <div class="div">
    	<?php if($subject['valuetype']=='radio') { ?>
       <?php if(is_array($optionlist[$subject['id']])) { foreach($optionlist[$subject['id']] as $option) { ?>           <div class="option"><input type="radio" name="answers[<?php echo $subject['id'];?>]" value="<?php echo $option['optionkey'];?>" onclick="selectRadio(<?php echo $subject['id'];?>);"> <?php echo $option['optionname'];?></div>
           <?php } } ?>       <?php } ?>
       <?php if($subject['valuetype']=='checkbox') { ?>
       <?php if(is_array($optionlist[$subject['id']])) { foreach($optionlist[$subject['id']] as $option) { ?>           <div class="option"><input type="checkbox" name="answers[<?php echo $subject['id'];?>][]" value="<?php echo $option['optionkey'];?>" onclick="selectCheckbox(<?php echo $subject['id'];?>);"> <?php echo $option['optionname'];?></div>
           <?php } } ?>       <?php } ?>
       
       <?php if($subject['valuetype']=='yesorno') { ?>
           <div class="option">
           	<input type="radio" name="answers[<?php echo $subject['id'];?>]" value="Y" onclick="selectRadio(<?php echo $subject['id'];?>);"> 是&nbsp;&nbsp;&nbsp;&nbsp;
            	<input type="radio" name="answers[<?php echo $subject['id'];?>]" value="N" onclick="selectRadio(<?php echo $subject['id'];?>);"> 否
           </div>
       <?php } ?>
       
       <?php if($subject['valuetype']=='text') { ?>
       		<div class="input"><input type="text" class="input-text" name="answers[<?php echo $subject['id'];?>]" onKeyUp="checkInput(this,<?php echo $subject['id'];?>);"></div>
       <?php } ?>
       
       <?php if($subject['valuetype']=='textarea') { ?>
       		<div class="input"><textarea class="textarea" name="answers[<?php echo $subject['id'];?>]" onKeyUp="checkInput(this,<?php echo $subject['id'];?>);"></textarea></div>
       <?php } ?>
    </div>
    <?php $orderno++; ?>    <?php } } ?>    </div>
</div><?php } } ?><div class="bottom"><a href="javascript:;" class="submitbutton" onclick="submitPaper();">交卷</a></div>
</form>
</div>


<div id="leftmenu"><?php if(is_array($paper_types)) { foreach($paper_types as $type) { ?><h3><a href="javascript:;" onclick="windowScrollTo('#type_<?php echo $type['typeid'];?>');"><?php echo $type['typename'];?></a></h3><?php } } ?></div>

<div id="rightmenu">
<h3 class="timelength">答题时间:<?php echo $paper_config['timelength'];?>分钟</h3>
<div class="timelast">剩余时间:<span id="timelast"></span></div>
<div class="subjectbox"><?php if(is_array($paper_types)) { foreach($paper_types as $type) { ?><h4><?php echo $type['typename'];?></h4>
<div class="boxdiv">
    <?php $no=1; ?>    <?php if(is_array($subjectlist[$type['typeid']])) { foreach($subjectlist[$type['typeid']] as $subject) { ?>       <a class="box" id="box_<?php echo $subject['id'];?>" href="javascript:;" onclick="windowScrollTo('#subject_<?php echo $subject['id'];?>');"><?php echo $no;?></a>
       <?php $no++; ?>       <?php } } ?></div><?php } } ?></div>
</div>
<script type="text/javascript">
function submitPaper(){
	if( confirm('交卷后答题将不可再修改，你确定现在交卷吗?')){
		$("#paperForm").submit();
	}
}
function windowScrollTo(el){
	$(document).scrollTop($(el).offset().top);
}

var nowtime   = Math.ceil(parseInt(new Date().getTime())/1000);
var systime   = <?php echo TIMESTAMP;?>;
var totaltime = <?php echo $paper_config['timelength'];?>*60;
//var timelast = Math.ceil(parseInt(new Date().getTime())/1000) - <?php echo $record['starttime'];?>;
var timelast = totaltime - (nowtime - <?php echo $record['starttime'];?>) + (nowtime - systime);
setInterval(function(){
	timelast--;
	if(timelast < 1){
		$("#paperForm").submit();
		return;
	}
	$("#timelast").text(formatTime(timelast));
},1000);
function formatTime(time){
	//return Math.ceil(time/60-1)+'分'+(time%60)+'秒';
	return Math.floor(time/60)+'分'+(time%60)+'秒';
}

function  selectRadio(id){
	if($("[name='answers["+id+"]']:checked").length > 0){
		$("#box_"+id).addClass('checked');
	}else {
		$("#box_"+id).removeClass('checked');
	}
}

function selectCheckbox(id){
	if($("[name='answers["+id+"][]']:checked").length > 0){
		$("#box_"+id).addClass('checked');
	}else {
		$("#box_"+id).removeClass('checked');
	}
}

function checkInput(o,id){
	var value = $(o).val();
	if($.trim(value).length > 0){
		$("#box_"+id).addClass('checked');
	}else {
		$("#box_"+id).removeClass('checked');
	}
}
</script>
</body>
</html>