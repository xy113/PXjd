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
	<h1>交卷成功</h1>
    <div class="tips" style="color:#C00;">你本次答题用时<strong><?php echo $spenttime;?></strong>,除去主观题最后得分为:<strong><?php echo $totalscore;?></strong>分</div>
    <div class="buttondiv">
    	<a class="bigbutton" href="/?m=exam&c=paper&a=viewpaper&recordid=<?php echo $recordid;?>">查看试卷</a>
    </div>
</div>
<script>setInterval("document.getElementById('nowtime').innerHTML='现在是：'+new Date().toLocaleString()+' 星期'+'日一二三四五六'.charAt(new Date().getDay());",1000);</script>
</body>
</html>