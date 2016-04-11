<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>
<span class="right">
	<form name="search" action="/?">
        <input type="hidden" name="m" value="admin">
        <input type="hidden" name="c" value="exam">
        <input type="hidden" name="a" value="subject">
        <input type="hidden" name="paperid" value="<?php echo $paperid;?>">
        <select name="typeid" id="typeid">
        	<option value="0">全部</option>
           <?php if(is_array($typelist)) { foreach($typelist as $key => $value) { ?>        	<option value="<?php echo $key;?>"<?php if($key==$typeid) { ?> selected<?php } ?>><?php echo $value;?></option>
           <?php } } ?>        </select>
        <input type="text" class="text text200" name="kw" value="<?php echo $kw;?>">
        <input type="submit" class="button search" value="<?php echo $lang['search'];?>">
    </form>
</span>
考题列表
<a class="addnew" href="/?m=admin&c=exam&a=createsubject&paperid=<?php echo $paperid;?>">添加考题</a>
</h2>
<form method="post">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
<thead>
  <tr>
    <th width="30"><input type="checkbox" class="checkbox" onclick="DSXCMS.checkAll(this,'delete[]')"></th>
    <th width="300">题目</th>
    <th>选项</th>
    <th width="200">答案</th>
    <th width="60">类型</th>
    <th width="40">编辑</th>
  </tr>
 </thead>
 <tbody>
  <?php if(is_array($subjectlist)) { foreach($subjectlist as $id => $list) { ?>  <?php $list['dateline']=@date('Y-m-d H:i',$list['dateline']) ?>  <?php $list['options']=$this->_getOptionString($list['options']); ?>  <tr>
    <td><input type="checkbox" class="checkbox" name="delete[]" value="<?php echo $id;?>"></td>
    <th><?php echo $list['subject'];?></th>
    <td><?php echo $list['options'];?></td>
    <td><?php echo $list['answer'];?></td>
    <td><?php echo $typelist[$list['typeid']];?></td>
    <td><a href="/?m=admin&c=exam&a=editsubject&paperid=<?php echo $paperid;?>&id=<?php echo $id;?>">编辑</a></td>
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