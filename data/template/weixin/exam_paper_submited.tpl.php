<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('weixin_header'); ?><div id="examhome" style="margin-top:20%;">
	<h1 style="text-align:center;">交卷成功</h1>
    <p class="tips" style="color:#C00; text-align:center;">你本次答题用时<strong><?php echo $spenttime;?></strong>,除去主观题最后得分为:<strong><?php echo $totalscore;?></strong>分</p>
    <div class="buttondiv" style="margin-top:20px;">
    	<a class="bigbutton" href="/?m=weixin&c=exampaper&a=viewpaper&recordid=<?php echo $recordid;?>">查看试卷</a>
    </div>
</div><?php include template('weixin_footer'); ?>