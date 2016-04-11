<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>附件管理</h2>
<form method="post" id="formattach" action="">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
<thead>
  <tr>
    <th width="30"><input type="checkbox" class="checkbox" name="delete[]" value="0" node="checkall"></th>
    <th>附件名称</th>
    <th width="100">大小</th>
    <th width="180">类型</th>
    <th width="120">上传时间</th>
  </tr>
 </thead>
 <tbody>
  <?php if(is_array($attachmentlist)) { foreach($attachmentlist as $attach) { ?>  <?php $attach['attachtime']=formatTime($attach['attachtime'],'Y-m-d H:i') ?>  <?php $attach['attachsize']=formatsize($attach['attachsize']) ?>  <tr>
    <td><input type="checkbox" class="checkbox" name="delete[]" value="<?php echo $attach['attachid'];?>"></td>
    <th><?php echo $attach['attachname'];?></th>
    <td><?php echo $attach['attachsize'];?></td>
    <td><?php echo $attach['attachtype'];?></td>
    <td><?php echo $attach['attachtime'];?></td>
  </tr>
  <?php } } ?>  </tbody>
  <tfoot>
  <tr>
      <td colspan="5">
          <span class="pagebox"><?php echo $pagination;?></span>
          <input type="submit" class="button" value="删除">　 
          <input type="button" class="button" value="<?php echo $lang['refresh'];?>" onclick="window.location.reload()">
      </td>
  </tr>
 </tfoot>
</table>
 </form>
<script type="text/javascript">
$("input[node=checkall]").click(function(){
	$("input[name='delete[]']").attr('checked',$(this).is(":checked"));
});
</script><?php include template('footer'); ?>