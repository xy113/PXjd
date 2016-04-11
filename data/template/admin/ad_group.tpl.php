<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>广告分组设置</h2>
<form method="post">
<input type="hidden" name="formsubmit" value="yes">
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
  <thead>
  <tr>
    <th width="45"><input type="checkbox" onclick="DSXCMS.checkAll(this,'delete[]')">删?</th>
    <th width="50">ID</th>
    <th>板块名称</th>
    <th width="80">排序</th>
    <th width="50">可用</th> 
  </tr>
  </thead>
  <?php if(is_array($grouplist)) { foreach($grouplist as $list) { ?>  <tbody>
  <tr>
    <td><input type="checkbox" name="delete[]" value="<?php echo $list['groupid'];?>"></td>
    <td><?php echo $list['groupid'];?></td>
    <td><input type="text" class="text" name="groupnew[<?php echo $list['groupid'];?>][groupname]" value="<?php echo $list['groupname'];?>"></td>
    <td><input type="text" class="text text60" name="groupnew[<?php echo $list['groupid'];?>][displayorder]" value="<?php echo $list['displayorder'];?>"></td>
    <td><input type="checkbox" name="groupnew[<?php echo $list['groupid'];?>][available]" value="1"<?php if($list['available']) { ?> checked<?php } ?>></td>
  </tr>
  </tbody>
  <?php } } ?>  <tbody id="newgroup">
  </tbody>
  <tfoot>
  <tr>
        <td colspan="6"><a href="javascript:;" id="addnew"><b class="icon">&#xf0154;</b>添加新板块</a></td>
  </tr>
  <tr>
        <td colspan="6" style="padding:10px 5px;">
        <button type="submit" class="button submit">提交</button>
            <button type="button" class="button" onclick="window.location.reload();">刷新</button>
       </td>
  </tr>
  </tfoot>
</table>
</form>
<script type="text/javascript">
var newscatkey = 0;
$("#addnew").click(function(){
	newscatkey++;
	$("#newgroup").append('<tr><td></td><td></td>'+
        '<td><input type="text" class="text" name="newgroup['+newscatkey+'][groupname]"></td>'+
        '<td><input type="text" class="text text60" value="0" name="newgroup['+newscatkey+'][displayorder]"></td>'+
        '<td><input type="checkbox" value="1" checked name="newgroup['+newscatkey+'][available]"></td>'+
      '</tr>');
});
</script><?php include template('footer'); ?>