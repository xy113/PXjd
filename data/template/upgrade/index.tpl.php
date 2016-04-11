<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>系统升级</title>
<style type="text/css">
.contain{width:300px; margin:100px auto; clear:both;}
.contain .button{width:100px; text-align:center; margin:10px auto; clear:both; background:#f0f0f0; border:1px #e0e0e0 solid;
border-radius:5px; padding:5px 10px; clear:both;}
</style>
</head>

<body>
<div class="contain">
	<a class="button" href="/?m=upgrade&c=index&a=articlecat">转换文章分类</a>
    <a class="button" href="/?m=upgrade&c=index&a=article">转换文章</a>
    <a class="button" href="/?m=upgrade&c=index&a=video">转换视频</a>
    <a class="button" href="/?m=upgrade&c=index&a=image">转换图片</a>
</div>

</body>
</html>
