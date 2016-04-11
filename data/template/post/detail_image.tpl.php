<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header_common'); include template('detail_common'); ?><script src="/static/js/postdetail.js" type="text/javascript"></script>
<div class="area" id="detail">
	<h1 class="title"><?php echo $article['title'];?></h1>
   <div class="info">
   	   <span><?php echo $article['pubtime'];?></span>
      <span>播放:<?php echo $article['viewnum'];?></span>
      <span>评论:(<?php echo $article['commentnum'];?>)</span>
      <span><?php if($article['from']) { ?><?php echo $article['from'];?><?php } else { ?><?php echo $G['setting']['sitename'];?><?php } ?></span>
    </div>
    <div class="piclist">
    <?php if(is_array($piclist)) { foreach($piclist as $pic) { ?>        <div class="pic"><img src="<?php echo $pic['attachment'];?>" class="pic"></div>
        <p><?php echo $pic['description'];?></p>
      <?php } } ?>    </div>
    <div class="blank"></div>
    <div class="morepics">
    	<h3>相关图片</h3>
       <div class="pics">
       <?php $articlelist=articlelist(array('type'=>'image','num'=>6)); ?>           <?php if(is_array($articlelist)) { foreach($articlelist as $list) { ?>           <div class="item">
           	<div class="pic"><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>"><img src="<?php echo $list['pic'];?>"></a></div>
            	<div class="title"><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>"><?php echo $list['title'];?></a></div>
           </div>
           <?php } } ?>       </div>
    </div>
</div><?php include template('footer_common'); ?>