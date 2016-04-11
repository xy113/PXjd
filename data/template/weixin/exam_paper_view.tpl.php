<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('weixin_header'); ?><div id="exampaper"><?php $orderno=1; if(is_array($paper_types)) { foreach($paper_types as $type) { if(is_array($subjectlist[$type['typeid']])) { foreach($subjectlist[$type['typeid']] as $subject) { ?>    <div class="content" id="content_<?php echo $subject['id'];?>">
    <h3 id="subject_<?php echo $subject['id'];?>"><?php echo $orderno;?>、<?php echo $subject['subject'];?></h3>
    <div class="div">
    	<?php if($subject['valuetype']=='radio') { ?>
        	<div class="answer">正确答案:<?php echo $subject['answer'];?>,<span<?php if(!$subject['yes']) { ?> style="color:#C30;"<?php } ?>>你的答案:<?php echo $answers[$subject['id']];?></span></div>
       <?php if(is_array($optionlist[$subject['id']])) { foreach($optionlist[$subject['id']] as $option) { ?>           <div class="option">
           	<label for="option_<?php echo $option['optionid'];?>">
            	<?php echo $option['optionkey'];?>、<?php echo $option['optionname'];?>
           	</label>
           </div>
           <?php } } ?>       <?php } ?>
       <?php if($subject['valuetype']=='checkbox') { ?>
       		<div class="answer">正确答案:<?php echo $subject['answer'];?>, <span<?php if(!$subject['yes']) { ?> style="color:#C30;"<?php } ?>>你的答案:<?php echo $answers[$subject['id']];?></span></div>
       <?php if(is_array($optionlist[$subject['id']])) { foreach($optionlist[$subject['id']] as $option) { ?>           <div class="option">
           	<label for="option_<?php echo $option['optionid'];?>">
           	<?php echo $option['optionkey'];?>、<?php echo $option['optionname'];?>
           	</label>
            </div>
           <?php } } ?>       <?php } ?>
       
       <?php if($subject['valuetype']=='yesorno') { ?>
           <div class="answer">正确答案:<?php echo $subject['answer'];?>, <span<?php if(!$subject['yes']) { ?> style="color:#C30;"<?php } ?>>你的答案:<?php echo $answers[$subject['id']];?></span></div>
       <?php } ?>
       
       <?php if($subject['valuetype']=='text') { ?>
       		<div class="answer">正确答案:<?php echo $subject['answer'];?>, <span<?php if(!$subject['yes']) { ?> style="color:#C30;"<?php } ?>>你的答案:<?php echo $answers[$subject['id']];?></span></div>
       <?php } ?>
       
       <?php if($subject['valuetype']=='textarea') { ?>
       		<div class="answer">参考答案:</div>
           <p><?php echo $subject['answer'];?></p>
           <div class="answer">你的答案:</div>
           <p><?php echo $answers[$subject['id']];?></p>
       <?php } ?>
    </div>
    </div>
    <?php $orderno++; ?>    <?php } } } } ?><div class="content" id="content_last" style="z-index:300;">
	<div class="subjectlist">
    <?php $boxno=1; ?>    <?php if(is_array($paper_types)) { foreach($paper_types as $type) { ?>        <?php if(is_array($subjectlist[$type['typeid']])) { foreach($subjectlist[$type['typeid']] as $subject) { ?>        <div class="subjectbox checked" id="box_<?php echo $subject['id'];?>" onclick="selectSubject(<?php echo $subject['id'];?>);"<?php if(!$subject['yes']) { ?> style="background:#C30;"<?php } ?>><?php echo $boxno;?></div>
        <?php $boxno++; ?>        <?php } } ?>       <?php } } ?>    </div>
    <p class="tips">绿色表示答对题目，红色表示答错题目</p>
    <p class="tips">答题用时:<?php echo $spenttime;?>,最后得分:<?php echo $record['score'];?></p>
    <!--<p><a class="bigbutton" href="/?m=weixin&c=home">返回</a></p>-->
</div>
</div>
<script type="text/javascript">
var currentSubject = 0;
$(function(){
	$("body",'html').css('overflow','hidden');
	$("#exampaper").height($('html').height());
	$($("#exampaper .content")[0]).show();
	var startX,startY,swipe;
	var paper = document.getElementById('exampaper');
	var slideW = $("#exampaper").width()/10;
	
	var tStart = function(e){
		swipe = 0;
		var touch = e.touches[0];
		startX = touch.pageX;
		startY = touch.pageY;
	
		//添加“触摸移动”事件监听
		paper.addEventListener('touchmove', tMove,false);
		//添加“触摸结束”事件监听
		paper.addEventListener('touchend', tEnd ,false);
	}
	var tMove = function(e) {
		 var touch = e.touches[0];
		 swipe = touch.pageX - startX;
		 //var offset = $($(".content")[currentSubject]).offset();
		 //$($(".content")[currentSubject]).css('left',(offset.left+swipe));
	}
	var tEnd = function(e){
		if(swipe == 0) return;
		e.preventDefault();
		if(swipe > slideW){
			showPrev();	
		}else if(swipe < -slideW){
			showNext();
		}
		paper.removeEventListener('touchmove', tMove, false);
		paper.removeEventListener('touchend', tEnd, false);
	}
	paper.addEventListener('touchstart', tStart ,false);
});

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

function selectSubject(id){
	//var index = $("#exampaper .content").index('#content_'+id);
	$(".content").hide();
	currentSubject = $("#exampaper .content").index($('#content_'+id));
	//alert(currentSubject);
	$($(".content")[currentSubject]).show();
}

function showPrev(){
	var current = $($(".content")[currentSubject]);
	currentSubject--;
	if(currentSubject < 0) {
		currentSubject = 0;
		return ;
	}else {
		$(".content").hide();
		//current.fadeOut('fast',function(){
			$($(".content")[currentSubject]).fadeIn('fast');
		//});
	}	
}

function showNext(){
	var current = $($(".content")[currentSubject]);
	currentSubject++;
	if(currentSubject >= $(".content").length) {
		currentSubject = $(".content").length -1;
		return ;
	}else {
		$(".content").hide();
		//current.fadeOut('fast',function(){
			$($(".content")[currentSubject]).fadeIn('fast');
		//});
	}
}
</script>
<div class="tabbar">
  <div class="bar">
      <div class="tab"><a href="javascript:;" class="menu" onclick="showPrev();">上一题</a></div> 
      <div class="tab"><a href="javascript:;" class="menu" onclick="$('#content_last').toggle();"><i class="icon" style="font-size:28px;">&#xf0159;</i></a></div> 
     <div class="tab" style="border:none;"><a href="javascript:;" class="menu" onclick="showNext();">下一题</a></div> 
 </div>
</div><?php include template('weixin_footer'); ?>