<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header_common'); include template('detail_common'); ?><div class="area yourpos">当前位置:<a href="/">首页</a> > <a href="/?m=post&c=list&catid=<?php echo $category['catid'];?>"><?php echo $category['cname'];?></a> > 正文</div>
<div class="area post-detail-wrap">
	<div class="post-detail-main">
        <div class="post-content-body">
            <h1 class="post-title-h1"><?php echo $article['title'];?></h1> 
            <div class="post-info">        
            <span><?php echo $article['pubtime'];?></span>
            <span>阅读:<?php echo $article['viewnum'];?></span>
            <a href="#dsxcomment">评论:(<?php echo $article['commentnum'];?>)</a>
            <a href="javascript:;" onclick="Favorite(<?php echo $article['id'];?>)">收藏本文</a>
            <?php if($G['account']['adminid']) { ?><a href="javascript:;" onclick="deletePost(<?php echo $article['id'];?>)">删除</a><?php } ?>
            <?php if($G['account']['adminid']||$article['uid']==$G['uid']) { ?><a href="/?mod=home&ac=post&op=edit&id=<?php echo $article['id'];?>">编辑</a><?php } ?>
            <?php if($G['account']['adminid']) { ?><a href="javascript:;" onclick="setPostState(<?php echo $article['id'];?>,0)">通过审核</a> <a href="javascript:;" onclick="setPostState(<?php echo $article['id'];?>,2)">取消审核</a><?php } ?>

            </div>
            <div class="post-body"><?php echo $content['content'];?></div>
            <?php if($article['type']=='attach') { ?> 
            <div class="post-attach-down"> 
                <h3>下载附件</h3>
                <div class="urls">
                     <?php if(is_array($article['postdata'])) { foreach($article['postdata'] as $attach) { ?> 
                     <a href="<?php echo $attach['attachurl'];?>" target="_blank"><?php echo $attach['attachname'];?></a>
                    <?php } } ?>                </div>
            </div>
            
            <?php } ?>
            <?php if($article['tags']) { ?>
            <div class="post-tags">标签:
            	  <?php if(is_array($article['tags'])) { foreach($article['tags'] as $tag) { ?>                <a href="/?mod=post&act=search&tag=<?php echo $tag;?>"><?php echo $tag;?></a>
                <?php } } ?>            </div>
            <?php } ?>
            <div class="post-related-div">
                  <h3 class="post-title-h3">相关文章</h3> 
                  <ul class="post-list-ul">
                      <?php if(is_array($relateds)) { foreach($relateds as $k => $list) { ?>                      <?php $list['pubtime']=date('Y-m-d H:i',$list['pubtime']) ?>                      <li><span><?php echo $list['pubtime'];?></span><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>"><?php echo $list['title'];?></a></li>
                      <?php } } ?>                  </ul>
            </div>
        </div>
    </div>
    <div class="column-right">
        <div class="contentdiv">
        	<h3 class="title">最新动态</h3>
            <?php $articlelist['new']=articlelist(array('num'=>10)); ?>           <ul>
           <?php if(is_array($articlelist['new'])) { foreach($articlelist['new'] as $list) { ?>           <li><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>"><?php echo $list['title'];?></a></li>
           <?php } } ?>           </ul>
        </div>
        <div class="contentdiv">
        	<h3 class="title">热点导读</h3>
           <?php $articlelist['hot']=articlelist(array('num'=>10)); ?>           <ul>
           <?php if(is_array($articlelist['hot'])) { foreach($articlelist['hot'] as $list) { ?>           <li><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>"><?php echo $list['title'];?></a></li>
           <?php } } ?>           </ul>
        </div>
    </div>
    <div class="clearfix"></div>  
</div>
<script src="/static/js/postdetail.js" type="text/javascript"></script><?php include template('footer_common'); ?>