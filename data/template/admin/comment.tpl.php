<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>评论管理</h2>
<form name="comment" id="comment" method="post">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
<thead>
  <tr>
    <th width="30"><input type="checkbox" class="checkbox" onclick="DSXCMS.checkAll(this,'delete[]');"></th>
    <th>评论内容</th>
  </tr>
 </thead>
 <tbody>
 <?php if(is_array($commentlist)) { foreach($commentlist as $k => $comm) { ?>  <tr>
    <td><input type="checkbox" class="checkbox" name="delete[]" value="<?php echo $comm['commid'];?>"></td>
    <td><p class="comment-content"><?php echo $comm['message'];?></p><div class="comment-attr"><?php echo $comm['pubtime'];?></div></td>
  </tr>
  <?php } } ?>  </tbody>
  <tfoot>
  <tr>
  	<td colspan="2">
    	<input type="checkbox" class="checkbox" name="delete[]" value="0" node="checkall"> 全选
    </td>
  </tr>
  <tr>
      <td colspan="2">
          <span class="pagebox"><?php echo $pages;?></span>
          <input type="submit" class="button" value="删除">　 
          <input type="button" class="button" value="刷新" onclick="window.location.reload()">
      </td>
  </tr>
 </tfoot>
</table>
</form><?php include template('footer'); ?>