<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><script type="text/javascript">
var GLOBAL_CONFIG = {
	uid:'<?php echo $G['uid'];?>',
	username:'<?php echo $G['username'];?>',
	ownerid:'<?php echo $article['uid'];?>',
	owner:'<?php echo $article['username'];?>',
	postdata:[]
}
</script><?php $article['pubtime']=formatTime($article['pubtime'],'Y年m月d日 H:i') ?>