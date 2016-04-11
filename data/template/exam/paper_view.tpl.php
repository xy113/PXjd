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
<div id="paper" style="margin-bottom:50px;">
<h1><?php echo $paper_config['name'];?></h1>
<p class="tips">提示:<?php echo $paper_config['tips'];?></p><?php if(is_array($paper_types)) { foreach($paper_types as $type) { ?><div id="type_<?php echo $type['typeid'];?>">
<h1><?php echo $type['typename'];?></h1>
	<div class="content" id="content_<?php echo $type['typeid'];?>">
    <?php $orderno=1; if(is_array($subjectlist[$type['typeid']])) { foreach($subjectlist[$type['typeid']] as $subject) { ?>    <h3 id="subject_<?php echo $subject['id'];?>"><?php echo $orderno;?>、<?php echo $subject['subject'];?></h3>
    <div class="div">
    	<?php if($subject['valuetype']=='radio') { ?>
        	<div class="answer">正确答案:<?php echo $subject['answer'];?>，<span<?php if(!$subject['yes']) { ?> style="color:#F00;"<?php } ?>>你的答案:<?php echo $answers[$subject['id']];?></span></div>
       <?php if(is_array($optionlist[$subject['id']])) { foreach($optionlist[$subject['id']] as $option) { ?>           <div class="option"><?php echo $option['optionkey'];?>、 <?php echo $option['optionname'];?></div>
           <?php } } ?>       <?php } ?>
       <?php if($subject['valuetype']=='checkbox') { ?>
       		<div class="answer">正确答案:<?php echo $subject['answer'];?>，<span<?php if(!$subject['yes']) { ?> style="color:#F00;"<?php } ?>>你的答案:<?php echo $answers[$subject['id']];?></span></div>
       <?php if(is_array($optionlist[$subject['id']])) { foreach($optionlist[$subject['id']] as $option) { ?>           <div class="option"><?php echo $option['optionkey'];?>、 <?php echo $option['optionname'];?></div>
           <?php } } ?>       <?php } ?>
       
       <?php if($subject['valuetype']=='yesorno') { ?>
       		<div class="answer">正确答案:<?php echo $subject['answer'];?>，<span<?php if(!$subject['yes']) { ?> style="color:#F00;"<?php } ?>>你的答案:<?php echo $answers[$subject['id']];?></span></div>
       <?php } ?>
       
       <?php if($subject['valuetype']=='text') { ?>
       		<div class="answer">参考答案:</div>
           <p><?php echo $subject['answer'];?></p>
           <div class="answer">你的答案:</div>
           <p><?php echo $answers[$subject['id']];?></p>
       <?php } ?>
       
       <?php if($subject['valuetype']=='textarea') { ?>
       		<div class="answer">参考答案:</div>
           <p><?php echo $subject['answer'];?></p>
           <div class="answer">你的答案:</div>
           <p><?php echo $answers[$subject['id']];?></p>
       <?php } ?>
    </div>
    <?php $orderno++; ?>    <?php } } ?>    </div>
</div><?php } } ?></div>


<div id="leftmenu"><?php if(is_array($paper_types)) { foreach($paper_types as $type) { ?><h3><a href="javascript:;" onclick="windowScrollTo('#type_<?php echo $type['typeid'];?>');"><?php echo $type['typename'];?></a></h3><?php } } ?></div>

<div id="rightmenu">
<h3 class="timelength">答题用时:<?php echo $spenttime;?></h3>
<div class="timelast">最后得分:<?php echo $record['score'];?></div>
<div class="subjectbox"><?php if(is_array($paper_types)) { foreach($paper_types as $type) { ?><h4><?php echo $type['typename'];?></h4>
<div class="boxdiv">
    <?php $no=1; ?>    <?php if(is_array($subjectlist[$type['typeid']])) { foreach($subjectlist[$type['typeid']] as $subject) { ?>       <a class="box"<?php if($subject['yes']) { ?> style="background:#060; color:#fff;"<?php } else { ?> style="background:#f00; color:#fff;"<?php } ?> href="javascript:;" onclick="windowScrollTo('#subject_<?php echo $subject['id'];?>');"><?php echo $no;?></a>
       <?php $no++; ?>       <?php } } ?></div><?php } } ?></div>
</div>
<script type="text/javascript">
function windowScrollTo(el){
	$(document).scrollTop($(el).offset().top);
}
</script>
</body>
</html>