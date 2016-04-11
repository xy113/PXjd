<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header_common'); include template('detail_common'); ?><div class="area">
    <h1 class="video-detail-title">视频: <?php echo $article['title'];?></h1>
    <div class="video-detail-wrap">
    	<div class="video-detail-player">
        	<embed src="<?php echo $video['swf'];?>" allowFullScreen="true" quality="high" width="980" height="640" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash"></embed>
        </div>
        <div class="video-detail-left">
        	<div class="video-detail-bar">
            	  <span><?php echo $article['pubtime'];?></span>
                <span>播放:<?php echo $article['viewnum'];?></span>
                <span>评论:(<?php echo $article['commentnum'];?>)</span>
                <a href="javascript:;" onclick="Favorite(<?php echo $article['id'];?>)">收藏本视频</a>
                <?php if($allowdelpost) { ?><a href="javascript:;" onclick="deletePost(<?php echo $article['id'];?>)">删除</a><?php } ?>
                <?php if($G['uid']) { ?><a href="/?mod=post&ac=edit&id=<?php echo $article['id'];?>">编辑</a><?php } ?>
                <?php if($allowauditpost) { ?><a href="javascript:;" onclick="setPostState(<?php echo $article['id'];?>,0)">通过审核</a> <a href="javascript:;" onclick="setPostState(<?php echo $article['id'];?>,2)">取消审核</a><?php } ?>
            </div>
            <div class="video-detail-content"><?php echo $video['content'];?></div>
            <!--评论-->
            <?php if($article['allowcomment']) { ?>
            <?php if($allowcomment) { ?>
            <div class="post-comment-form">
            	<form method="post" name="formcomment">
            	<textarea class="comment-textarea" name="message" id="comment-text" placeholder="在这里输入评论内容"<?php if(!$G['islogin']) { ?> disabled<?php } ?>></textarea>
                <div class="comment-toolbar"><input type="button" class="comment-publish" id="comment-publish" value="发布"><span>已有<font node="comments"><?php echo $article['commentnum'];?></font>条评论</span></div>
            	</form>
                <?php if(!$G['islogin']) { ?><div class="errortips" style="display:block;"><i class="icon">&#xf0142;</i>登录后才能发评论哦，亲.</div><?php } ?>
                <div class="errortips" id="comment-tips"><i class="icon">&#xf0142;</i>不能发空评论哦，亲.</div>
            </div>
            <?php } ?>
            <h3 class="post-comment-title">最新评论</h3>
            <div class="comment-loading" id="comment-loading"><img src="/static/images/common/loading16.gif"> 正在加载评论...</div>
            <div id="post-comment-list-content"></div>
            <?php } ?>
        </div>
        <div class="video-detail-right">
        <?php $videolist=articlelist(array('type'=>'video','num'=>5)); ?>        	   <?php if(is_array($videolist)) { foreach($videolist as $list) { ?>              <?php $list['pubtime']=@date('Y-m-d',$list['dateline']); ?>              <dl class="video-item">
              		<dd><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>" title="<?php echo $list['title'];?>"><img src="<?php echo $list['pic'];?>"></a></dd>
                    <dt>
                    	<h3><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>"><?php echo $list['title'];?></a></h3>
                        <p><?php echo $list['pubtime'];?></p>
                        <p>播放:<?php echo $list['viewnum'];?></p>
                    </dt>
              </dl>
              <?php } } ?>        </div>
        <div class="clearfix"></div>
    </div>
</div><?php include template('footer_common'); ?>