<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('weixin_header'); ?><div class="wxmessage">
	<h3 class="<?php echo $type;?>"><?php echo $msg;?></h3>
    <div class="buttondiv">
    	<?php if($links) { ?>
    	<a class="back-button" href="<?php echo $links['0']['url'];?>"><?php echo $links['0']['text'];?></a>
       <?php } else { ?>
       <a class="back-button" href="<?php echo $forward;?>">返回</a>
       <?php } ?>
    </div>
</div> <?php include template('weixin_footer'); ?>