<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>题库列表<a class="addnew" href="/?m=admin&c=exam&a=createquestion">添加项目</a></h2>
<form method="post">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
<thead>
  <tr>
    <th width="30"><input type="checkbox" class="checkbox" onclick="DSXCMS.checkAll(this,'delete[]')"></th>
    <th>考试项目</th>
    <th width="80">时间限制</th>
    <th width="300">考试说明</th>
    <th width="80">出题方式</th>
    <th width="100">选项</th>
  </tr>
 </thead>
 <tbody>
  <?php if(is_array($questionlist)) { foreach($questionlist as $list) { ?>  <tr>
    <td><input type="checkbox" class="checkbox" name="delete[]" value="<?php echo $list['questionid'];?>"></td>
    <th><?php echo $list['name'];?></th>
    <th><?php echo $list['timelength'];?></th>
    <td><?php echo $list['tips'];?></td>
    <td><?php if($list['make_type']==1) { ?>随机出题<?php } else { ?>统一出题<?php } ?></td>
    <td>
       <a href="/?m=admin&c=exam&a=editquestion&questionid=<?php echo $list['questionid'];?>">编辑</a>  
       <a href="/?m=admin&c=exam&a=subject&questionid=<?php echo $list['questionid'];?>">题目管理</a>
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
</form><?php include template('footer'); ?>