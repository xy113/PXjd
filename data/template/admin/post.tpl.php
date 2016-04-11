<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>
<span class="right">
	<form name="search" action="/?">
        <input type="hidden" name="m" value="admin">
        <input type="hidden" name="c" value="post">
        <input type="hidden" name="a" value="showlist">
        <select name="catid" id="catid">
        <option value="0" class="bold">所有栏目</option>
        <?php echo $categoryoptions;?>
        </select>
        <input type="text" class="text text200" name="kw" value="<?php echo $kw;?>">
        <input type="submit" class="button search" value="<?php echo $lang['search'];?>">
    </form>
</span>
文章管理
<a class="addnew" href="/?m=admin&c=post&a=publish">写文章</a>
</h2>
<form name="articles" id="articles" method="post">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
<thead>
  <tr>
    <th width="30"><input type="checkbox" class="checkbox" onclick="DSXCMS.checkAll(this,'id[]')"></th>
    <th><?php echo $lang['article_title'];?></th>
    <th width="80">形式</th>
    <th width="80">目录分类</th>
    <th width="50"><?php echo $lang['article_views'];?></th>
    <th width="130"><?php echo $lang['pubtime'];?></th>
    <th width="50">状态</th>
  </tr>
 </thead>
 <tbody>
  <?php if(is_array($articlelist)) { foreach($articlelist as $key => $list) { ?>  <tr>
    <td><input type="checkbox" class="checkbox" name="id[]" value="<?php echo $list['id'];?>"></td>
    <th>
    	<a href="/?m=post&c=detail&id=<?php echo $list['id'];?>" target="_blank"><?php echo $list['title'];?></a>
        <div class="actions">
        	<a href="/?m=home&c=post&a=edit&id=<?php echo $list['id'];?>">编辑</a> |
            <!--<a href="javascript:;">快速编辑</a> |-->
            <a href="/?m=post&c=detail&id=<?php echo $list['id'];?>" target="_blank">查看</a>
        </div>
    </th>
    <td><?php echo $list['typename'];?></td>
    <td><?php echo $list['cname'];?></td>
    <td><?php echo $list['viewnum'];?></td>
    <td><?php echo $list['pubtime'];?></td>
    <td><?php echo $list['status'];?></td>
  </tr>
  <?php } } ?>  </tbody>
  <tfoot>
  <tr>
  	<td colspan="7">
    	<input type="checkbox" class="checkbox" onclick="DSXCMS.checkAll(this,'id[]')"> <?php echo $lang['selectall'];?>
        <input type="radio" name="option" value="1" checked> 删除
        <input type="radio" name="option" value="2"> 通过审核
        <input type="radio" name="option" value="3"> 审核未通过
    </td>
  </tr>
  <tr>
      <td colspan="7">
          <span class="pagebox"><?php echo $pages;?></span>
          <input type="submit" class="button" value="<?php echo $lang['submit'];?>">　 
          <input type="button" class="button" value="<?php echo $lang['refresh'];?>" onclick="window.location.reload()">
      </td>
  </tr>
 </tfoot>
</table>
</form><?php include template('footer'); ?>