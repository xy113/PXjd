<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>管理组</h2>
<form method="post" action="" autocomplete="off">
    <input type="hidden" name="formsubmit" value="yes" />
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
    <thead>
    <tr>
      <th width="30">GID</th>
      <th width="100">组名称</th>
      <th>组权限</th>
    </tr>
    </thead>
    <tbody>
    <?php if(is_array($usergrouplist)) { foreach($usergrouplist as $k => $group) { ?>    <?php if($group['type']=='system') { ?>
    <tr>
      <td><?php echo $group['gid'];?></td>
      <td><?php echo $group['title'];?></td>
      <td style="line-height:1.5;">
        <?php if(is_array($lang['adminperms'])) { foreach($lang['adminperms'] as $k=>$v) { ?>        <input type="checkbox" value="1" name="usergroup[<?php echo $group['gid'];?>][perm][<?php echo $k;?>]"<?php if($group['perm'][$k]) { ?> checked="checked"<?php } ?>><?php echo $v;?>
        <?php } } ?>      </td>
    </tr>
    <?php } ?>
    <?php } } ?>    </tbody>
    <tfoot>
    <tr>
        <td colspan="3">
            <input type="submit" class="button" value="提交" />　
            <input type="button" class="button" value="刷新" onclick="window.location.reload()" />
        </td>
    </tr>
    </tfoot>
  </table>
 </form>
<h2>用户组</h2>
<form method="post" name="form2" id="formop" action="" autocomplete="off">
    <input type="hidden" name="formsubmit" value="yes" />
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
    <thead>
    <tr>
      <th width="20"><input type="checkbox" class="checkbox" node="checkall" name="gid[]" value="0" /></th>
      <th width="30">GID</th>
      <th width="100">组名称</th>
      <th width="100">积分下线</th>
      <th width="100">积分上限</th>
      <th>组权限</th>
    </tr>
    </thead>
    <tbody id="tbcontent">
    <?php if(is_array($usergrouplist)) { foreach($usergrouplist as $k => $group) { ?>    <?php if($group['type']=='member') { ?>
    <tr>
      <td><input type="checkbox" name="gid[]" value="<?php echo $group['gid'];?>" /></td>
      <td><?php echo $group['gid'];?></td>
      <td><input type="text" class="text text200" name="usergroup[<?php echo $group['gid'];?>][title]" value="<?php echo $group['title'];?>" maxlength="10"></td>
      <td><input type="text" class="text text100" name="usergroup[<?php echo $group['gid'];?>][creditslower]" value="<?php echo $group['creditslower'];?>" maxlength="10"></td>
      <td><input type="text" class="text text100" name="usergroup[<?php echo $group['gid'];?>][creditshigher]" value="<?php echo $group['creditshigher'];?>" maxlength="10"></td>
      <td style="line-height:1.5;">
        <?php if(is_array($lang['member_perms'])) { foreach($lang['member_perms'] as $k=>$v) { ?>        <input type="checkbox" value="1" name="usergroup[<?php echo $group['gid'];?>][perm][<?php echo $k;?>]"<?php if($group['perm'][$k]) { ?> checked="checked"<?php } ?>><?php echo $v;?>
        <?php } } ?>      </td>
    </tr>
    <?php } ?>
    <?php } } ?>    </tbody>
    <tfoot>
    <tr>
    	<td></td>
        <td colspan="5"><a href="javascript:;" id="newgroup"><i class="icon">&#xf0154;</i>添加新分组</a></td>
    </tr>
    <tr>
        <td colspan="6">
            <input type="checkbox" class="checkbox"  node="checkall" name="gid[]" value="0" /> 删除
        </td>
    </tr>
    <tr>
        <td colspan="6">
            <span class="pagebox"><?php echo $pagelink;?></span>
            <input type="submit" class="button" value="提交" />　
            <input type="button" class="button" value="刷新" onclick="window.location.reload()" />
        </td>
    </tr>
    </tfoot>
  </table>
 </form>
<script type="text/html" id="rowtpl">
<tr>
  <td></td>
  <td></td>
  <td><input type="text" class="text text200" name="newgroup[nkey][title]" value="" maxlength="10"></td>
  <td><input type="text" class="text text100" name="newgroup[nkey][creditslower]" value="" maxlength="10"></td>
  <td><input type="text" class="text text100" name="newgroup[nkey][creditshigher]" value="" maxlength="10"></td>
  <td>
  <?php if(is_array($lang['member_perms'])) { foreach($lang['member_perms'] as $k=>$v) { ?>	<input type="checkbox" value="1" name="newgroup[nkey][perm][<?php echo $k;?>]"><?php echo $v;?> 
	<?php } } ?>  </td>
</tr>
</script>
<script type="text/javascript">
var nkey = 0;
$("#newgroup").click(function(){
	nkey++;
	$("#tbcontent").append($("#rowtpl").html().replace(/nkey/g,nkey));
});
$("input[node=checkall]").click(function(){
	if($(this).is(":checked")){
		$("input[name='gid[]']").attr('checked',true);
	}else{
		$("input[name='gid[]']").attr('checked',false);
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