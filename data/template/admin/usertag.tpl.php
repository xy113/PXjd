<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>标签管理</h2>
<form method="post" action="">
    <input type="hidden" name="formsubmit" value="yes" />
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
    <thead>
    <tr>
      <th width="20"><input type="checkbox" class="checkbox" node="checkall" name="tagid[]" value="0" /></th>
      <th width="200">标签</th>
      <th>热度</th>
    </tr>
    </thead>
    <tbody id="tbcontent">
    <?php if(is_array($taglist)) { foreach($taglist as $tag) { ?>    <tr class="white">
      <td><input type="checkbox" name="tagid[]" value="<?php echo $tag['tagid'];?>" /></td>
      <td><input type="text" class="text text200" name="tags[<?php echo $tag['tagid'];?>]" value="<?php echo $tag['tag'];?>" maxlength="10"></td>
      <td><?php echo $tag['counts'];?></td>
    </tr>
    <?php } } ?>    </tbody>
    <tfoot>
    <tr>
        <td colspan="3"><a href="javascript:;" id="newtag"><i class="icon">&#xf0154;</i>添加标签</a></td>
    </tr>
    <tr>
        <td colspan="3">
            <span class="pagebox"><?php echo $pages;?></span>
            <input type="submit" class="button" value="提交" />　
            <input type="button" class="button" value="刷新" onclick="window.location.reload()" />
        </td>
    </tr>
    </tfoot>
  </table>
 </form>
<script type="text/javascript">
$("#newtag").click(function(){
	$("#tbcontent").append('<tr class="white"><td></td><td><input type="text" class="text text200" name="newtag[]" value=""></td><td></td></tr>');
});
$("input[node=checkall]").click(function(){
	if($(this).is(":checked")){
		$("input[name='tagid[]']").attr('checked',true);
	}else{
		$("input[name='tagid[]']").attr('checked',false);
	}
});
$("#formop").submit(function(){
	if($(this).find("input[name=delete]:checked").val() == 1){
		return confirm("您确定要删除所选内容吗？\n信息删除后将无法恢复");
	}else{
		return true;
	}
});
</script><?php include template('footer'); ?>