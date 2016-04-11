<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header_common'); ?><div id="area">
<div class="ui-message-warp" style="width:70%">
	<div class="message-content">
    	<?php if($type=='success') { ?>
    	<h3 class="message-detail message-success"><i class="icon">&#xf0156;</i><?php echo $msg;?></h3>
        <?php } elseif($type=='error') { ?>
        <h3 class="message-detail message-error"><i class="icon">&#xf0155;</i><?php echo $msg;?></h3>
        <?php } elseif($type=='warning') { ?>
        <h3 class="message-detail message-warning"><i class="icon">&#xf00b7;</i><?php echo $msg;?></h3>
        <?php } else { ?>
        <h3 class="message-detail message-information"><i class="icon">&#xf0142;</i><?php echo $msg;?></h3>
        <?php } ?>
        <?php if($tips) { ?><div class="message-tips" style="font-size:14px;"><?php echo $tips;?></div><?php } ?>
        <?php if($autoredirect) { ?>
        <div class="message-tips"><?php echo $lang['auto_redirect'];?></div>
        <?php } else { ?>
        <div class="message-tips"><?php echo $lang['message_tips'];?></div>
        <?php } ?>
        
        <div class="message-links">
        	<?php if($links) { ?>
        <?php if(is_array($links)) { foreach($links as $link) { ?>        	<a href="<?php echo $link['url'];?>"<?php if($link['target']) { ?> target="<?php echo $link['target'];?>"<?php } ?>><?php echo $link['text'];?></a>
           <?php } } ?>           <?php } else { ?>
           <a href="<?php echo $forward;?>"><?php echo $lang['go_back'];?></a>
           <?php } ?>
        </div>
    </div>
</div> 
</div>
<?php if($autoredirect) { ?>
<script type="text/javascript">
var second = 5;
var timeid = setInterval(function(){
	second--;
	if(second<1){
		clearTimeout(timeid);
		window.location = '<?php echo $forward;?>';
	}else {
		$("#timer").text(second);
	}
},1000);
</script>
<?php } include template('footer_common'); ?>