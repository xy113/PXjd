<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>
<span class="right">
	<form name="search" action="/?">
        <input type="hidden" name="m" value="admin">
        <input type="hidden" name="c" value="<?php echo $G['c'];?>">
        <input type="hidden" name="a" value="<?php echo $G['a'];?>">
        <select name="field" id="field">
        	<option value="all">全部</option>
           <option value="uid"<?php if($field=='uid') { ?> selected<?php } ?>>UID</option>
        	<option value="username"<?php if($field=='username') { ?> selected<?php } ?>>姓名</option>
        </select>
        <input type="text" class="text text200" name="kw" value="<?php echo $kw;?>">
        <input type="submit" class="button search" value="<?php echo $lang['search'];?>">
    </form>
</span>
签到记录
</h2>
<form method="post">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
<thead>
  <tr>
    <th width="30"><input type="checkbox" class="checkbox" onclick="DSXCMS.checkAll(this,'delete[]')"></th>
    <th width="50">照片</th>
    <th width="60">UID</th>
    <th width="100">姓名</th>
    <th width="130">签到时间</th>
    <th width="200">签到位置</th>
    <th>备注</th>
    <th width="110">IP地址</th>
    
  </tr>
 </thead>
 <tbody>
  <?php if(is_array($signlist)) { foreach($signlist as $signid => $list) { ?>  <tr>
    <td><input type="checkbox" class="checkbox" name="delete[]" value="<?php echo $signid;?>"></td>
    <td><a href="<?php echo $list['pic'];?>" target="_blank"><img src="<?php echo $list['pic'];?>" width="50" height="50"></a></td>
    <td><?php echo $list['uid'];?></td>
    <th><a href="/?m=<?php echo $G['m'];?>&c=<?php echo $G['c'];?>&a=<?php echo $G['a'];?>&field=uid&kw=<?php echo $list['uid'];?>"><?php echo $list['username'];?></a></th>
    <td><?php echo $list['signtime'];?></td>
    <td><?php echo $list['location'];?></td>
    <td><?php echo $list['remark'];?></td>
    <td><?php echo $list['userip'];?></td>
  </tr>
  <?php } } ?>  </tbody>
  <tfoot>
  <tr>
      <td colspan="8">
          <span class="pagebox"><?php echo $pages;?></span>
          <input type="submit" class="button" value="删除">　 
          <input type="button" class="button" value="<?php echo $lang['refresh'];?>" onclick="window.location.reload()">　 
          <?php if($field=='uid'&&$kw) { ?><a href="javascript:;" class="button" onclick="window.open('/?m=<?php echo $G['m'];?>&c=<?php echo $G['c'];?>&a=export&uid=<?php echo $kw;?>');">导出EXCEL表格</a><?php } ?>
      </td>
  </tr>
 </tfoot>
</table>
</form><?php include template('footer'); ?>