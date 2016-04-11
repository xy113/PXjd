<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>
<span class="right">
	<form name="search" id="form_search" action="">
        <input type="hidden" name="m" value="admin">
        <input type="hidden" name="c" value="page">
        <select name="catid" id="catid">
        <option value="0" class="bold">所有分类</option>
        <?php if(is_array($categorylist)) { foreach($categorylist as $clist) { ?>        <option value="<?php echo $clist['pageid'];?>"<?php if($catid==$clist['pageid']) { ?> selected="selected"<?php } ?>><?php echo $clist['title'];?></option>
        <?php } } ?>        </select>
    </form>
</span>
所有页面<a class="addnew" href="/?m=admin&c=page&a=publish">新建页面</a></h2>
<form method="post" action="">
    <input type="hidden" name="formsubmit" value="yes" />
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
	<thead>
  <tr>
    <th width="50"><input type="checkbox" class="checkbox" name="delete[]" value="0" node="checkall">删?</th>
    <th>标题</th>
    <th>别名</th>
    <th width="80">分类</th>
    <th width="80">排序</th>
    <th width="120">发布时间</th>
    <th width="120">最后修改</th>
    <th width="50">编辑</th>
  </tr>
 </thead>
 <tbody>
  <?php if(is_array($pagelist)) { foreach($pagelist as $key => $list) { ?>  <?php $list['pubtime']=formatTime($list['pubtime'],'Y-m-d H:i') ?>  <?php $list['modified']=formatTime($list['modified'],'Y-m-d H:i') ?>  <tr>
    <td><input type="checkbox" class="checkbox" name="delete[]" value="<?php echo $list['pageid'];?>"></td>
    <th><a href="/?m=admin&c=page&a=edit&pageid=<?php echo $list['pageid'];?>"><?php echo $list['title'];?></a></th>
    <td><?php echo $list['alias'];?></td>
    <td><?php echo $categorylist[$list['catid']]['title'];?></td>
    <td><input type="text" class="text text60" name="neworder[<?php echo $list['pageid'];?>]" value="<?php echo $list['displayorder'];?>" /></td>
    <td><?php echo $list['pubtime'];?></td>
    <td><?php echo $list['modified'];?></td>
    <td><a href="/?m=admin&c=page&a=edit&pageid=<?php echo $list['pageid'];?>">编辑</a></td>
  </tr>
  <?php } } ?>  </tbody>
  <tfoot>
  <tr>
      <td colspan="7">
          <span class="pages"><?php echo $pages;?></span>
          <input type="submit" class="button" value="提交">　 
          <input type="button" class="button" value="刷新" onclick="window.location.reload()">
      </td>
  </tr>
 </tfoot>
</table>
 </form>
<script type="text/javascript">
$("input[node=checkall]").click(function(){
	$("input[name='delete[]']").attr('checked',$(this).is(":checked"));
});
$("#catid").change(function(){
	$("#form_search").submit();
});
</script><?php include template('footer'); ?>