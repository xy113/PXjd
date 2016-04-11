<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>调查问卷</h2>
<form method="post">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
<thead>
  <tr>
    <th width="45"><input type="checkbox" class="checkbox" onclick="DSXCMS.checkAll(this,'delete[]')">删?</th>
    <th>问卷名称</th>
    <th>默认</th>
    <th width="200">选项</th>
  </tr>
 </thead>
 <tbody id="paperlist">
  <?php if(is_array($paperlist)) { foreach($paperlist as $list) { ?>  <tr>
    <td><input type="checkbox" class="checkbox" name="delete[]" value="<?php echo $list['paperid'];?>"></td>
    <th><input type="text" class="text" name="paperlist[<?php echo $list['paperid'];?>][papername]" value="<?php echo $list['papername'];?>"></th>
    <td><input type="radio" name="isdefault" value="<?php echo $list['paperid'];?>"<?php if($list['isdefault']) { ?> checked<?php } ?>></td>
    <td>
       <a href="/?m=admin&c=<?php echo $G['c'];?>&a=subject&paperid=<?php echo $list['paperid'];?>">题目设置</a>&nbsp;&nbsp;  
       <a href="/?m=admin&c=<?php echo $G['c'];?>&a=record&paperid=<?php echo $list['paperid'];?>">查看记录</a>&nbsp;&nbsp; 
       <a href="/?m=admin&c=<?php echo $G['c'];?>&a=result&paperid=<?php echo $list['paperid'];?>">查看结果</a>
    </td>
  </tr>
  <?php } } ?>  </tbody>
  <tbody>
  		<tr>
        	<td colspan="5"><a href="javascript:;" id="newpaper"><i class="icon">&#xf0154;</i>添加新项</a></td>
        </tr>
  </tbody>
  <tfoot>
  <tr>
      <td colspan="5">
          <span class="pagebox"><?php echo $pages;?></span>
          <input type="submit" class="button" value="提交">　 
          <input type="button" class="button" value="<?php echo $lang['refresh'];?>" onclick="window.location.reload()">
      </td>
  </tr>
 </tfoot>
</table>
</form>
<script type="text/javascript">
var paperid = 0;
$("#newpaper").click(function(){
	paperid--;
	$("#paperlist").append('<tr><td></td>'+
    '<th><input type="text" class="text" name="newpaper['+paperid+'][papername]" value=""></th>'+
    '<td></td><td></td></tr>');
});
</script><?php include template('footer'); ?>