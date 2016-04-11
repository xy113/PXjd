<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); if($G['a'] == 'editperm') { ?>
<h2>权限设置</h2>
<div class="perm-content">
	<form method="post" autocomplete="off" action="">
    <input type="hidden" name="formsubmit" value="yes" />
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
	<div class="menu-header"><?php echo $member['username'];?> 权限设置</div>
    <h3 class="perm-title">用户组</h3>
    <p class="perm-tips">提示:设置用户组后用户权限将继承于组权限</p>
    <div class="perm-item">
    	<select name="gid">
        <?php if(is_array($usergrouplist)) { foreach($usergrouplist as $group) { ?>        <?php if($group['type']=='member') { ?>
        <option value="<?php echo $group['gid'];?>"<?php if($member['gid']==$group['gid']) { ?> selected="selected"<?php } ?>><?php echo $group['title'];?></option>
        <?php } ?>
        <?php } } ?>        </select>
    </div>
    <h3 class="perm-title">用户权限</h3>
    <p class="perm-tips">提示:设置权限后用户权限将覆盖组权限</p>
    <div class="perm-item">
    <?php if(is_array($lang['member_perms'])) { foreach($lang['member_perms'] as $k=>$v) { ?>        <input type="checkbox" value="1" name="perm[<?php echo $k;?>]"<?php if($perm[$k]) { ?> checked="checked"<?php } ?>><?php echo $v;?>
        <?php } } ?>    </div>
    <h3 class="perm-title">管理权限</h3>
    <div class="perm-item">
    	<select name="adminid" id="groupperm">
        <option value="0">无管理权限</option>
        <?php if(is_array($usergrouplist)) { foreach($usergrouplist as $group) { ?>        <?php if($group['type'] == 'system') { ?>
        <option value="<?php echo $group['gid'];?>"<?php if($member['adminid']==$group['gid']) { ?> selected="selected"<?php } ?>><?php echo $group['title'];?></option>
        <?php } ?>
        <?php } } ?>        </select>
    </div>
    <span id="groupsetting"<?php if($member['adminid']==0) { ?> style="display:none;"<?php } ?>>
    <h3 class="perm-title">分类权限</h3>
    <p class="perm-tips">提示:同时按住Control可选择多个分类</p>
    <div class="perm-item">
    	<select multiple="multiple" size="10" name="perm[catids][]"><?php echo $options;?></select>
    </div>
    </span>
    <div class="menu-footer">
    	<input type="submit" class="button submit" value="提交" />　 
        <input type="button" class="button" value="刷新" onclick="window.location.reload();" />
    </div>
    </form>
</div>
<script type="text/javascript">
$("#groupperm").change(function(){
	if($(this).val()>0){
		$("#groupsetting").show();
	}else{
		$("#groupsetting").hide();
	}
});
</script>
<?php } else { ?>
<h2>
	会员管理
	<span class="right">
		<form method="get" name="search" action="/?">
		 <input type="hidden" name="mod" value="admin" />
        <input type="hidden" name="ac" value="member" />
		 <input type="text" class="text text200" name="q" value="<?php echo $_GET['q'];?>" />
        <select name="type">
        	<option value="ID">ID</option>
            <option value="name">姓名</option>
            <option value="mobile">手机号</option>
            <option value="email">邮箱</option>
        </select>
		<input type="submit" class="button search" value="搜索" />
		</form>
	</span>
</h2>
<form method="post" name="formuser" id="formuser" action="">
	<input type="hidden" name="formsubmit" value="yes">
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
    <thead>
    <tr>
      <th width="30"><input type="checkbox" class="checkbox" name="uid[]" value="0" onclick="DSXCMS.checkAll(this,'uid[]')" /></th>
      <th width="100">姓名</th>
      <th width="100">手机号</th>
      <th>电子邮箱</th>
      <th width="60">用户组</th>
      <th width="140">注册日期</th>
      <th width="140">最后登录</th>
      <th width="100">最后登录IP</th>
      <th width="60">状态</th>
      <!--<th width="60">权限</th>-->
    </tr>
    </thead>
    <tbody id="members">
    <?php if(is_array($memberlist)) { foreach($memberlist as $key => $member) { ?>    <?php $member['regdate']=@date('Y-m-d H:i',$memberstatus[$member['uid']]['regdate']); ?>    <?php $member['lastvisit']=@date('Y-m-d H:i',$memberstatus[$member['uid']]['lastvisit']); ?>    <tr>
      <td><input<?php if(!$member['admincp']) { ?> name="uid[]" value="<?php echo $member['uid'];?>"<?php } else { ?> disabled="disabled"<?php } ?> type="checkbox" /></td>
      <td><a href="/?m=space&uid=<?php echo $member['uid'];?>" target="_blank"><?php echo $member['username'];?></a></td>
      <td><?php echo $member['mobile'];?></td>
      <td><?php echo $member['email'];?></td>
      <td><?php echo $member['grouptitle'];?></td>
      <td><?php echo $member['regdate'];?></td>
      <td><?php echo $member['lastvisit'];?></td>
      <td><a href="http://www.ip138.com/ips.asp?ip=<?php echo $mb['lastvisitip'];?>" target="_blank">	<?php echo $memberstatus[$member['uid']]['lastvisitip'];?></a></td>
      <td><?php echo $lang['member_state'][$member['status']];?></td>
     <!-- <td><a href="/?m=admin&ac=member&op=editperm&uid=<?php echo $member['uid'];?>">编辑权限</a></td>-->
    </tr>
    <?php } } ?>    </tbody>
    <tfoot>
    <tr>
        <td colspan="9">
            <input type="checkbox" class="checkbox" name="uid[]" value="0" onclick="DSXCMS.checkAll(this,'uid[]')" /> 全选
            <input type="radio" name="option" value="1" checked> 删除
            <input type="radio" name="option" value="2"> 正常
            <input type="radio" name="option" value="3"> 禁止登录
            <input type="radio" name="option" value="4"> 禁止发言
        </td>
    </tr>
    <tr>
        <td colspan="10">
            <span class="pages"><?php echo $pages;?></span>
            <input type="submit" class="button" value="提交" />　
            <input type="button" class="button" value="刷新" onclick="window.location.reload()" />
        </td>
    </tr>
    </tfoot>
  </table>
 </form>
<script type="text/javascript">
$("#formuser").submit(function(){
	if($(this).find("input[name=optype]:checked").val() == 1){
		return confirm("您确定要删除所选用户吗？\n用户删除后将无法恢复");
	}else{
		return true;
	}
});
</script>
<?php } include template('footer'); ?>