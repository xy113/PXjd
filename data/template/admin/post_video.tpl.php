<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('post_title'); ?><div class="newpost-content" id="p-content-postdata">
    <h3 class="content-sub-title">视频地址</h3>
    <div class="content-body">
    <input type="text" class="input-text" name="videourl" value="<?php echo $videocontent['url'];?>">
    <p>请输入QQ视频，优酷网、酷6网、56网的视频播放页链接</p>
   </div>
</div>
<div class="newpost-content">
    <h3 class="content-sub-title">视频介绍</h3>
    <div class="content-body"><textarea class="textarea-summary" name="content" style="height:200px;"><?php echo $videocontent['content'];?></textarea></div>
</div><?php include template('post_attribute'); ?>