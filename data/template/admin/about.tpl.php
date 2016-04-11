<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>欢迎使用大师兄CMS</h2>
<div class="about-content">
    <div class="frame0">
    	<h3 class="title">开始使用</h3>
    	<div class="item"><a class="button submit" href="/?m=admin&c=setting&a=basic">自定义你的站点</a></div>
    </div>
    <div class="frame0">
    	<h3 class="title">接下来</h3>
        <div class="item"><i class="icon">&#xf0199;</i><a href="/?m=admin&c=post&a=publish">撰写第一篇文章</a></div>
        <div class="item"><i class="icon">&#xf00a7;</i><a href="/" target="_blank">查看站点</a></div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="about-left">
	<div class="about-content">
    	<div class="content-title">大师兄新闻</div>
        <div class="textfield"></div>
    </div>
    <div class="blank"></div>
    <div class="about-content">
    	<div class="content-title">关注大师兄</div>
        <p></p>
        <p>QQ:307718818</p>
        <p>邮箱:songdewei@163.com</p>
        <p>微信:大师兄网络服务平台</p>
        <p><img src="/static/images/weixin.jpg" width="150" height="150"></p>
        <p></p>
    </div>
</div>
<div class="about-right">
	<div class="about-content">
    	<div class="content-title">最新发布</div>
        <ul>
        <?php if(is_array($posts['1'])) { foreach($posts['1'] as $pp) { ?>            <?php $pp['pubtime']=date('Y-m-d H:i',$pp['pubtime']) ?>            <li><span><?php echo $pp['pubtime'];?></span><a href="/?m=post&c=detail&id=<?php echo $pp['id'];?>" target="_blank"><?php echo $pp['title'];?></a></li>
            <?php } } ?>        </ul>
    </div>
    <div class="blank"></div>
    <div class="about-content">
    	<div class="content-title">待审文章</div>
        <ul>
        <?php if(is_array($posts['2'])) { foreach($posts['2'] as $pp) { ?>            <?php $pp['pubtime']=date('Y-m-d H:i',$pp['pubtime']) ?>            <li><span><?php echo $pp['pubtime'];?></span><a href="/?m=post&act=detail&id=<?php echo $pp['id'];?>" target="_blank"><?php echo $pp['title'];?></a></li>
            <?php } } ?>        </ul>
    </div>
</div>
<div class="clearfix"></div><?php include template('footer'); ?>