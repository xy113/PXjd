<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>
<span class="right">
	<form name="search" action="/?">
        <input type="hidden" name="m" value="admin">
        <input type="hidden" name="c" value="research">
        <input type="hidden" name="a" value="subject">
        <input type="hidden" name="paperid" value="<?php echo $paperid;?>">
        <input type="text" class="text text200" name="kw" value="<?php echo $kw;?>">
        <input type="submit" class="button search" value="<?php echo $lang['search'];?>">
    </form>
</span>
题目列表
<a class="addnew" href="/?m=admin&c=research&a=createsubject&paperid=<?php echo $paperid;?>">添加题目</a>
</h2>
<form method="post">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
<thead>
  <tr>
    <th width="30"><input type="checkbox" class="checkbox" onclick="DSXCMS.checkAll(this,'delete[]')"></th>
    <th width="400">题目标题</th>
    <th>查看选项记录</th>
    <th width="120">选项</th>
  </tr>
 </thead>
 <tbody>
  <?php if(is_array($subjectlist)) { foreach($subjectlist as $id => $list) { ?>  <?php $list['dateline']=@date('Y-m-d H:i',$list['dateline']) ?>  <tr>
    <td><input type="checkbox" class="checkbox" name="delete[]" value="<?php echo $id;?>"></td>
    <th><a href="javascript:;" onclick="viewResult(<?php echo $list['id'];?>);"><?php echo $list['subject'];?></a></th>
    <td>
    	<ul>
        <?php if(is_array($list['options'])) { foreach($list['options'] as $option) { ?>           <li><a href="javascript:;" onclick="viewOption(<?php echo $list['id'];?>,'<?php echo $option['optionkey'];?>');"><?php echo $option['optionkey'];?>、<?php echo $option['optionname'];?></a></li>
           <?php } } ?>        </ul>
    </td>
    <td>
    	<a href="/?m=admin&c=research&a=editsubject&paperid=<?php echo $paperid;?>&id=<?php echo $id;?>">编辑</a>&nbsp;&nbsp;
       <a href="javascript:;" onclick="viewResult(<?php echo $list['id'];?>);">查看结果</a>
    </td>
  </tr>
  <?php } } ?>  </tbody>
  <tfoot>
  <tr>
      <td colspan="7">
          <span class="pagebox"><?php echo $pages;?></span>
          <input type="submit" class="button" value="删除">　 
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
function viewOption(subjectid,optionvalue){
	var url = '/?m=<?php echo $G['m'];?>&c=<?php echo $G['c'];?>&a=viewoption&subjectid='+subjectid+'&answer='+optionvalue;
	var dlg = dialog('<iframe width="100%" height="450" border="0" frameborder="0" src="'+url+'"></iframe>',{showFooter:false,width:830,height:600,title:'调查结果'});
}
</script><?php include template('footer'); ?>