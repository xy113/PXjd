<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>后台管理中心</title>
<link rel="stylesheet" type="text/css" href="/static/css/admincp.css">
<script src="/static/js/jquery.js" type="text/javascript"></script>
<script src="/static/js/common.js?<?php echo TIMESTAMP;?>" type="text/javascript"></script>
<script src="/static/js/jquery.dialog.js" type="text/javascript"></script>
<script src="/static/js/jquery.form.js" type="text/javascript"></script>
<script src="/static/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
</head>

<body>
<form method="post">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
<thead>
  <tr>
    <!--<th width="30"><input type="checkbox" class="checkbox" onclick="DSXCMS.checkAll(this,'delete[]')"></th>-->
    <th style="cursor:pointer;" onclick="toggleSort('<?php echo $asc;?>');" title="按时间排序">用户名</th>
    <th>省</th>
    <th>市/州/区</th>
    <th>县</th>
    <th>乡镇</th>
  </tr>
 </thead>
 <tbody>
  <?php if(is_array($answerlist)) { foreach($answerlist as $list) { ?>  <?php $list['username']=$userlist[$list['uid']]['username']; ?>  <tr>
    <!--<td><input type="checkbox" class="checkbox" name="delete[]" value="<?php echo $list['answerid'];?>"></td>-->
    <th><?php if($list['username']) { ?><a href="/?m=space&uid=<?php echo $list['uid'];?>" target="_blank"><?php echo $list['username'];?></a><?php } else { ?>游客<?php } ?></th>
    <td><?php echo $userlist[$list['uid']]['province'];?></td>
    <td><?php echo $userlist[$list['uid']]['city'];?></td>
    <td><?php echo $userlist[$list['uid']]['county'];?></td>
    <td><?php echo $userlist[$list['uid']]['town'];?></td>
  </tr>
  <?php } } ?>  </tbody>
  <tfoot>
  <tr>
      <td colspan="9">
          <span class="pagebox"><?php echo $pages;?></span>
          <!--
          <input type="submit" class="button" value="删除">　 
          <input type="button" class="button" value="<?php echo $lang['refresh'];?>" onclick="window.location.reload()">
          -->
      </td>
  </tr>
 </tfoot>
</table>
</form>
<script type="text/javascript">
function toggleSort(asc){
	var asort = asc == 'ASC' ? 'DESC' : 'ASC';
	window.location.href = '/?m=<?php echo $G['m'];?>&c=<?php echo $G['c'];?>&a=<?php echo $G['a'];?>&asc='+asort;
}
</script>
</body>
</html>