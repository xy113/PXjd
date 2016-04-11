<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>照片管理</h2>
<form method="post" action="">
    <input type="hidden" name="formsubmit" value="yes" />
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
<thead>
  <tr>
    <th width="45"><input type="checkbox" class="checkbox" onclick="DSXCMS.checkAll(this,'delete[]');">删?</th>
    <th width="80">预览</th>
    <th>名称</th>
    <th width="100">大小</th>
    <th width="100">类型</th>
    <th width="120">上传时间</th>
  </tr>
 </thead>
 <tbody>
  <?php if(is_array($photolist)) { foreach($photolist as $list) { ?>  <tr>
    <td><input type="checkbox" class="checkbox" name="delete[]" value="<?php echo $list['photoid'];?>"></td>
    <td><img src="<?php echo $list['thumb'];?>" width="60" height="60"></td>
    <th><?php echo $list['name'];?></th>
    <td><?php echo $list['size'];?></td>
    <td><?php echo $list['type'];?></td>
    <td><?php echo $list['uptime'];?></td>
  </tr>
  <?php } } ?>  </tbody>
  <tfoot>
  <tr>
      <td colspan="6">
          <span class="pages"><?php echo $pages;?></span>
          <input type="submit" class="button" value="删除">　 
          <input type="button" class="button" value="<?php echo $lang['refresh'];?>" onclick="window.location.reload()">
      </td>
  </tr>
 </tfoot>
</table>
 </form><?php include template('footer'); ?>