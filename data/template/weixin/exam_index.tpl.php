<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('weixin_header'); ?><div id="examhome">
	<h3><?php echo $paper_config['name'];?></h3>
	<p><?php echo $paper_config['tips'];?></p>
    <p style="color:#ff0000; font-weight:bold;">提示: 向左滑动屏幕进入下一题，向右滑动返回上一题</p>
    <div style="margin-top:50px;"><a href="/?m=weixin&c=exampaper" class="bigbutton">开始答题</a></div>
</div><?php include template('weixin_tabbar'); include template('weixin_footer'); ?>