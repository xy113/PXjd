<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); if($G['op']=='edit') { ?>
<h2>编辑页面</h2>
<?php } else { ?>
<h2>新建页面</h2>
<?php } $token = sha1($G['uid'].$G['username'].formhash()); ?><script src="/static/editor/jquery.UBBEditor.js?<?php echo TIMESTAMP;?>" type="text/javascript"></script>
<script src="/static/uploadify/jquery.uploadify-3.1.min.js" type="text/javascript"></script>
<form method="post" action="">
    <input type="hidden" name="formsubmit" value="yes" />
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
    <div class="pages-left-frame">
    	<div class="pages-content">
        <input type="text" name="newpage[title]" class="pages-title-input" placeholder="在此输入标题" value="<?php echo $page['title'];?>">
        </div>
        <div class="pages-content"><?php include template('editor'); ?></div>
    </div>
    <div class="pages-right-frame">
    	<!--<div class="pages-content">
        	<div class="subdiv">
            	<div class="handle">图像</div>
                <div class="content"><a href="javascript:;" id="upload-image"><span class="icon">&#xf0154;</span>添加文章图片<input class="file" name="" type="file"></a></div>
            </div>
        </div>-->
        <div class="pages-content">
        	<div class="subdiv">
            	<div class="handle">别名</div>
                <div class="content"><input type="text" class="text input-text" name="newpage[alias]" value="<?php echo $page['alias'];?>" /></div>
            </div>
        </div>
    	<div class="pages-content">
        	<div class="subdiv">
            	<div class="handle">分类</div>
                <div class="content">
                    <select class="select" name="newpage[catid]" id="catid">
                        <?php if(is_array($categorylist)) { foreach($categorylist as $clist) { ?>                        <option value="<?php echo $clist['pageid'];?>"<?php if($clist['pageid']==$page['catid']) { ?> selected="selected"<?php } ?>><?php echo $clist['title'];?></option>
                        <?php } } ?>                    </select>
                </div>
            </div>
        </div>
        
        <div class="pages-content">
        	<div class="subdiv">
            	<div class="handle">模板</div>
                <div class="content"><input type="text" class="text input-text" name="newpage[template]" value="<?php echo $page['template'];?>" /></div>
            </div>
        </div>
        
        <div class="pages-content">
        	<div class="subdiv">
            	<div class="handle">发布</div>
                <div class="content">
                	  	<?php if($G['op']=='edit') { ?>
                      <input type="submit" class="button" value="更新" /> 
                      <?php } else { ?>
                	  	<input type="submit" class="button" value="发布" /> 
                      <?php } ?>
                    	&nbsp;&nbsp; 
                    <input type="button" class="button" value="刷新" onclick="window.location.reload()" />
                </div>
            </div>
        </div>
    </div>
 </form>
 <div class="clearfix"></div><?php include template('footer'); ?>