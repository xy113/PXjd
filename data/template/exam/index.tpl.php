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

<div class="exam-home">
	<h1><?php echo $examset['sysname'];?></h1>
    <?php if($examinee) { ?>
    <div class="nowtime" id="nowtime"></div>
    <div class="buttondiv">
    	<a class="bigbutton" href="/?m=exam&c=paper">开始答题</a>
    </div>
    <?php } else { ?>
    <div class="tips" style="color:#C00;">你尚未进行考生登记，请先登记个人信息</div>
    <div class="buttondiv">
    	<a class="bigbutton" href="/?m=home&c=examsign">登记个人信息</a>
    </div>
    <?php } ?>
</div>
<script>setInterval("document.getElementById('nowtime').innerHTML='现在是：'+new Date().toLocaleString()+' 星期'+'日一二三四五六'.charAt(new Date().getDay());",1000);</script>
</body>
</html>