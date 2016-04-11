<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('weixin_header'); ?><div id="research">
<form method="post">
<input type="hidden" name="formsubmit" value="yes">
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<input type="hidden" name="paperid" value="<?php echo $paperid;?>"><?php $orderno=1; if(is_array($subjectlist)) { foreach($subjectlist as $subject) { ?>	<h3 class="title"><?php echo $orderno;?>、<?php echo $subject['subject'];?></h3>
    
    <?php if($subject['valuetype']=='radio') { ?>
    <?php if(is_array($subject['options'])) { foreach($subject['options'] as $option) { ?>    <div class="option">
       <label><input type="radio" class="radio" name="answers[<?php echo $subject['id'];?>]" value="<?php echo $option['optionkey'];?>"> <?php echo $option['optionname'];?></label>
    </div>
    <?php } } ?>    <?php } ?>
    <?php if($subject['valuetype']=='checkbox') { ?>
    <?php if(is_array($subject['options'])) { foreach($subject['options'] as $option) { ?>    <div class="option">
       <label><input type="checkbox" class="checkbox" name="answers[<?php echo $subject['id'];?>][]" value="<?php echo $option['optionkey'];?>"> <?php echo $option['optionname'];?></label>
    </div>
    <?php } } ?>    <?php } ?>
    <?php if($subject['valuetype']=='text') { ?>
          <div class="input"><input type="text" class="input-text" name="answers[<?php echo $subject['id'];?>]"></div>
     <?php } ?>
     
     <?php if($subject['valuetype']=='textarea') { ?>
          <div class="input"><textarea class="textarea" name="answers[<?php echo $subject['id'];?>]"></textarea></div>
     <?php } ?>
    <?php $orderno++; } } ?><div style="padding:20px 0;"><button class="bigbutton" type="submit">交卷</button></div>
    </form>
</div><?php include template('weixin_tabbar'); include template('weixin_footer'); ?>