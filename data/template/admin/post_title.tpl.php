<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><script type="text/javascript">
var GLOBAL_CONFIG = {
	imageURL:'<?php echo $G['config']['output']['attachurl'];?>'
}
</script>
<link rel="stylesheet" type="text/css" href="/static/css/post.css">
<form name="newpostform" method="post" autocomplete="off">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<input type="hidden" name="newpost[type]" value="<?php echo $type;?>">
<div class="newpost-main" style="width:75%;">
     <div class="newpost-item" id="p-content-title"><input type="text" class="input-post-title" value="<?php echo $article['title'];?>" placeholder="在这里输入标题" name="newpost[title]" node="title"></div>