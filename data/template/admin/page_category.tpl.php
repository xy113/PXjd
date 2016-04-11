<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>页面分类管理</h2>
<form method="post" action="">
    <input type="hidden" name="formsubmit" value="yes" />
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
    <thead>
    <tr>
      <th width="20"><input type="checkbox" class="checkbox" node="checkall" name="delete[]" value="0" /></th>
      <th width="60">显示顺序</th>
      <th width="300">标题</th>
      <th></th>
    </tr>
    </thead>
    <tbody id="newPage">
    <?php if(is_array($categorylist)) { foreach($categorylist as $clist) { ?>    <tr class="white">
      <td>
      <input type="checkbox" name="delete[]" value="<?php echo $clist['pageid'];?>" />
      <input type="hidden" name="newclass[pageid][]" value="<?php echo $clist['pageid'];?>">
      </td>
      <td><input type="text" class="text text60" name="newclass[displayorder][]" value="<?php echo $clist['displayorder'];?>" maxlength="4"></td>
      <td colspan="3">
      	<input type="text" class="text text100" name="newclass[title][]" value="<?php echo $clist['title'];?>" maxlength="10"> 
      </td>
    </tr>
    <?php } } ?>    </tbody>
    <tfoot>
    <tr>
    	<td></td>
        <td colspan="4"><a href="javascript:;" onclick="addClass()"><i class="icon">&#xf0154;</i>添加分类</a></td>
    </tr>
    <tr>
        <td colspan="5">
            <input type="checkbox" class="checkbox"  node="checkall" name="delete[]" value="0" /> 删除
        </td>
    </tr>
    <tr>
        <td colspan="5">
            <input type="submit" class="button" value="提交" />　
            <input type="button" class="button" value="刷新" onclick="window.location.reload()" />
        </td>
    </tr>
    </tfoot>
  </table>
 </form>
<script type="text/template" id="tplClass">
<tr class="white">
  <td><input type="hidden" name="newclass[pageid][]" value="0"></td>
  <td><input type="text" class="text text30" name="newclass[displayorder][]" value="0" maxlength="4"></td>
  <td colspan="3"><input type="text" class="text text100" name="newclass[title][]" value="" maxlength="10"></td>
</tr>
</script>
<script type="text/javascript">
function addClass(){
	$("#newPage").append($("#tplClass").html());
}
$("input[node=checkall]").click(function(){
	$("input[name='delete[]']").attr('checked',$(this).is(":checked"));
});
</script><?php include template('footer'); ?>