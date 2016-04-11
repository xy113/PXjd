<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>题目列表</h2>
<form method="post">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
<thead>
  <tr>
    <th width="30">编号</th>
    <th>调查项目</th>
    <th width="80">统计结果</th>
  </tr>
 </thead>
 <tbody>
 <?php $orderno=1; ?>  <?php if(is_array($subjectlist)) { foreach($subjectlist as $id => $list) { ?>  <tr>
    <td><?php echo $orderno;?></td>
    <th><a href="javascript:;" onclick="viewResult(<?php echo $list['id'];?>);"><?php echo $list['subject'];?></a></th>
    <td><a href="javascript:;" onclick="viewResult(<?php echo $list['id'];?>);">查看统计结果</a></td>
  </tr>
  <?php $orderno++; ?>  <?php } } ?>  </tbody>
  <tfoot>
  <tr>
      <td colspan="7">
          <span class="pagebox"><?php echo $pages;?></span>
          <input type="button" class="button" value="<?php echo $lang['refresh'];?>" onclick="window.location.reload()">
      </td>
  </tr>
 </tfoot>
</table>
</form>
<script type="text/javascript">
function viewResult(subjectid){
	$.ajax({
		url:'/?m=<?php echo $G['m'];?>&c=<?php echo $G['c'];?>&a=viewsubject&paperid=<?php echo $paperid;?>&subjectid='+subjectid,
		success: function(c){
			var dlg = dialog(c,{showFooter:false,width:830,title:'调查结果'});
		}
	});
}
</script><?php include template('footer'); ?>