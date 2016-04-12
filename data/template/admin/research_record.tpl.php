<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>问卷调查记录
<a class="addnew" href="/?m=<?php echo $G['m'];?>&c=<?php echo $G['c'];?>&a=paper">返回问卷列表</a>
</h2>
<form method="post">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
<thead>
  <tr>
    <th width="30"><input type="checkbox" class="checkbox" onclick="DSXCMS.checkAll(this,'delete[]')"></th>
    <th style="cursor:pointer;" onclick="toggleSort('<?php echo $asc;?>');" title="按时间排序">用户名</th>
    <th>省</th>
    <th>市</th>
    <th>县</th>
    <th>乡</th>
    <th width="120">答题时间</th>
  </tr>
 </thead>
 <tbody>
  <?php if(is_array($recordlist)) { foreach($recordlist as $list) { ?>  <?php $time=@date('Y-m-d H:i',$list['dateline']); ?>  <tr>
    <td><input type="checkbox" class="checkbox" name="delete[]" value="<?php echo $list['recordid'];?>"></td>
    <th><?php if($list['username']) { ?><a href="/?m=space&uid=<?php echo $list['uid'];?>" target="_blank"><?php echo $list['username'];?></a><?php } else { ?>游客<?php } ?></th>
    <td><?php echo $userlist[$list['uid']]['province'];?></td>
    <td><?php echo $userlist[$list['uid']]['city'];?></td>
    <td><?php echo $userlist[$list['uid']]['county'];?></td>
    <td><?php echo $userlist[$list['uid']]['town'];?></td>
    <td><?php echo $time;?></td>
  </tr>
  <?php } } ?>  </tbody>
  <tfoot>
  <tr>
      <td colspan="9">
          <span class="pagebox"><?php echo $pages;?></span>
          <input type="submit" class="button" value="删除">　 
          <input type="button" class="button" value="<?php echo $lang['refresh'];?>" onclick="window.location.reload()">
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
</script><?php include template('footer'); ?>