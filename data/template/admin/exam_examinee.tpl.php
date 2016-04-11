<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>
<span class="right">
	<form name="search" action="/?">
        <input type="hidden" name="m" value="admin">
        <input type="hidden" name="c" value="exam">
        <input type="hidden" name="a" value="examinee">
        <select name="field" id="field">
        	<option value="all">全部</option>
        	<option value="username"<?php if($field=='username') { ?> selected<?php } ?>>姓名</option>
           <option value="idnumber"<?php if($field=='idnumber') { ?> selected<?php } ?>>身份证号</option>
        </select>
        <input type="text" class="text text200" name="kw" value="<?php echo $kw;?>">
        <input type="submit" class="button search" value="<?php echo $lang['search'];?>">
    </form>
</span>
考生列表
</h2>
<form name="articles" id="articles" method="post">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
<thead>
  <tr>
    <th width="30"><input type="checkbox" class="checkbox" onclick="DSXCMS.checkAll(this,'delete[]')"></th>
    <th width="80">姓名</th>
    <th width="140">身份证号</th>
    <th width="120">所在乡镇</th>
    <th>所在单位</th>
    <th width="120">最后登录</th>
  </tr>
 </thead>
 <tbody>
  <?php if(is_array($examineelist)) { foreach($examineelist as $key => $list) { ?>  <?php $list['lastlogin']=@date('Y-m-d H:i',$list['lastlogin']) ?>  <tr>
    <td><input type="checkbox" class="checkbox" name="delete[]" value="<?php echo $list['uid'];?>"></td>
    <th><?php echo $list['username'];?></th>
    <td><?php echo $list['idnumber'];?></td>
    <td><?php echo $list['town'];?></td>
    <td><?php echo $list['company'];?></td>
    <td><?php echo $list['lastlogin'];?></td>
  </tr>
  <?php } } ?>  </tbody>
  <tfoot>
  <!--<tr>
  	<td colspan="7">
    	<input type="checkbox" class="checkbox" onclick="DSXCMS.checkAll(this,'id[]')"> <?php echo $lang['selectall'];?>
        <input type="radio" name="option" value="1" checked> 删除
        <input type="radio" name="option" value="2"> 通过审核
        <input type="radio" name="option" value="3"> 审核未通过
    </td>
  </tr>-->
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