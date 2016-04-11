<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?></div>
<script type="text/javascript">
$(function(){
	$("#leftNav,#mainFrame").css('min-height',$("#home").height());
	$("#home").resize(function(e) {
        //$("#leftNav,#mainFrame").height($("#home").height());
    });
});
</script><?php include template('footer_common'); ?>