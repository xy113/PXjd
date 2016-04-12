<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header_common'); ?><div class="area">
	<div class="yourpos">
    	<a href="/">首页</a> <?php if($category['cname']) { ?>> <?php echo $category['cname'];?><?php } ?> > <?php echo $pagecontent['title'];?>
    </div>
    <div class="main">
        <div class="page-body" style="padding:20px 0; font-size:14px; line-height:1.5;"><?php echo $pagecontent['body'];?></div>
    </div>
</div><?php include template('footer_common'); ?>