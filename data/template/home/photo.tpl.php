<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header_home'); ?><div id="mainFrame">
	<form method="post" autocomplete="off">
    <input type="hidden" name="formsubmit" value="yes">
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
	<?php if($piclist) { ?>
    	<div class="photoList">
        <?php if(is_array($piclist)) { foreach($piclist as $pic) { ?>            <?php $pic['uptime']=formatTime($pic['uptime']) ?>            <dl id="photo_item_<?php echo $pic['photoid'];?>">
            	  <dd><img src="<?php echo $attachurl;?>/<?php echo $pic['thumb'];?>"></dd>
                 <dt><?php echo $pic['uptime'];?></dt>
            </dl>
            <?php } } ?>        </div>
        <div class="pages"><?php echo $pages;?></div>
        <?php } else { ?>
        <div class="noaccess">您还没有上传过任何照片哦</div>
        <?php } ?>
    </form>
</div><?php include template('footer_home'); ?>