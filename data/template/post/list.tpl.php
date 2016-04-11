<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header_common'); ?><div class="area yourpos"><a href="/">首页</a> > <a href="/?m=post&c=list&catid=<?php echo $category['catid'];?>"><?php echo $category['cname'];?></a></div>
<div class="area post-list-wrap">
    <div class="post-list-main"> 
      <?php if($articlelist) { ?>
      <?php if(is_array($articlelist)) { foreach($articlelist as $k => $list) { ?>      <dl class="post-list-item">
      		<?php if($list['pic']) { ?><dd><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>" target="_blank"><img src="<?php echo $list['pic'];?>"></a></dd><?php } ?>
            <dt>
            	<h3><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>" target="_blank"><?php echo $list['title'];?></a></h3>
              <p><?php echo $list['summary'];?></p>
            </dt>
            <div>
                <span><?php echo $list['pubtime'];?></span>
                <span>阅读:<?php echo $list['viewnum'];?></span>
                <span>评论:<?php echo $list['commentnum'];?></span>
                <span><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>" target="_blank">查看详细</a></span>
            </div>
      </dl>
      <?php } } ?>      <?php } else { ?>
      <div class="noaccess">该栏目下还没有文章</div>
      <?php } ?>
      <?php if($pages) { ?><div class="pages"><?php echo $pages;?></div><?php } ?>
  </div>
  <div class="column-right">
  		<div class="categorylist">
        <?php $k=1; ?>        <?php if(is_array($categorylist)) { foreach($categorylist as $list) { ?>           <?php if($list['fid']==$category['fid']&&$k<11) { ?>
           <a href="/?m=post&c=list&catid=<?php echo $list['catid'];?>" class="item<?php if($k%2==0) { ?> item2<?php } ?>"><?php echo $list['cname'];?></a>
           <?php $k++; ?>           <?php } ?>
           <?php } } ?>        </div>
		<div class="contentdiv">
        	<h3 class="title">最新动态</h3>
            <?php $articlelist['new']=articlelist(array('num'=>10)); ?>           <ul>
           <?php if(is_array($articlelist['new'])) { foreach($articlelist['new'] as $list) { ?>           <li><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>"><?php echo $list['title'];?></a></li>
           <?php } } ?>           </ul>
        </div>
        <div class="contentdiv">
        	<h3 class="title">热点导读</h3>
           <?php $articlelist['hot']=articlelist(array('num'=>10,'orderby'=>'viewnum','sort'=>'DESC')); ?>           <ul>
           <?php if(is_array($articlelist['hot'])) { foreach($articlelist['hot'] as $list) { ?>           <li><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>"><?php echo $list['title'];?></a></li>
           <?php } } ?>           </ul>
        </div>
  </div>
  <div class="clearfix"></div>
</div><?php include template('footer_common'); ?>