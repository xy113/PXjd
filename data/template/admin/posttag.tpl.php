<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>标签管理</h2>
<form method="post" action="">
    <input type="hidden" name="formsubmit" value="yes" />
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
    <thead>
    <tr>
      <th width="20"><input type="checkbox" class="checkbox" node="checkall" name="delete[]" value="0" /></th>
      <th width="200">标签</th>
      <th>热度</th>
    </tr>
    </thead>
    <tbody id="tbcontent">
    <?php if(is_array($tags)) { foreach($tags as $tag) { ?>    <tr class="white">
      <td><input type="checkbox" name="delete[]" value="<?php echo $tag['tagid'];?>" /></td>
      <td><input type="text" class="text text200" name="tagnew[<?php echo $tag['tagid'];?>][tag]" value="<?php echo $tag['tag'];?>" maxlength="10"></td>
      <td><input type="text" class="text text60" name="tagnew[<?php echo $tag['tagid'];?>][counts]" value="<?php echo $tag['counts'];?>" maxlength="10"></td>
    </tr>
    <?php } } ?>    </tbody>
    <tfoot>
    <tr>
        <td colspan="3"><a href="javascript:;" id="newtag"><i class="icon">&#xf0154;</i>添加标签</a></td>
    </tr>
    <tr>
        <td colspan="3">
            <span class="pagebox"><?php echo $pagination;?></span>
            <input type="submit" class="button" value="提交" />　
            <input type="button" class="button" value="刷新" onclick="window.location.reload()" />
        </td>
    </tr>
    </tfoot>
  </table>
 </form>
<script type="text/javascript">
$("#newtag").click(function(){
	var key = DSXCMS.randomString(10);
	$("#tbcontent").append('<tr class="white"><td></td><td><input type="text" class="text text200" name="newtag['+key+'][tag]" value=""></td><td><input type="text" class="text text60" name="newtag['+key+'][counts]" value="0" maxlength="6"></td></tr>');
});
$("input[node=checkall]").click(function(){
	$("input[name='delete[]']").attr('checked',$(this).is(":checked"));
});
</script><?php include template('footer'); ?>