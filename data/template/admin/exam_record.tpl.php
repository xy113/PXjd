<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>
<span class="right">
	<form name="search" action="/?">
        <input type="hidden" name="m" value="<?php echo $G['m'];?>">
        <input type="hidden" name="c" value="<?php echo $G['c'];?>">
        <input type="hidden" name="a" value="<?php echo $G['a'];?>">
        <input type="hidden" name="paperid" value="<?php echo $paperid;?>">
        <select name="field" id="field">
        	<option value="">不限</option>
        	<option value="uid"<?php if($field=='uid') { ?> selected<?php } ?>>UID</option>
           <option value="username"<?php if($field=='username') { ?> selected<?php } ?>>姓名</option>
           <option value="idnumber"<?php if($field=='idnumber') { ?> selected<?php } ?>>身份号</option>
        </select>
        <input type="text" class="text text200" name="kw" value="<?php echo $kw;?>">
        <input type="submit" class="button search" value="<?php echo $lang['search'];?>">
    </form>
</span>
答题记录
<a class="addnew" href="/?m=<?php echo $G['m'];?>&c=<?php echo $G['c'];?>&a=paper">试卷列表</a>
</h2>
<form name="articles" id="articles" method="post">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
<thead>
  <tr>
    <th width="30"><input type="checkbox" class="checkbox" onclick="DSXCMS.checkAll(this,'delete[]')"></th>
    <th width="80" style="cursor:pointer;" onclick="toggleSort('recordid','<?php echo $asc;?>');" title="按考试时间排序">姓名</th>
    <th width="150">身份证号</th>
    <th width="120">所在乡镇</th>
    <th>所在单位</th>
    <th width="120">考试时间</th>
    <th width="60">正常交卷</th>
    <th width="80" style="cursor:pointer;" onclick="toggleSort('spenttime','<?php echo $asc;?>');" title="按用时排序">答题用时</th>
    <th width="60" style="cursor:pointer;" onclick="toggleSort('score','<?php echo $asc;?>');" title="按成绩排序">答题成绩</th>
  </tr>
 </thead>
 <tbody>
  <?php if(is_array($recordlist)) { foreach($recordlist as $list) { ?>  <?php $list['spenttime']=$this->_formatTime($list['submittime']-$list['starttime']); ?>  <?php $list['starttime']=@date('Y-m-d H:i',$list['starttime']); ?>  <tr>
    <td><input type="checkbox" class="checkbox" name="delete[]" value="<?php echo $list['recordid'];?>"></td>
    <th><a href="/?m=exam&c=paper&a=viewpaper&uid=<?php echo $list['uid'];?>&recordid=<?php echo $list['recordid'];?>" target="_blank"><?php echo $list['username'];?></a></th>
    <td><?php echo $list['idnumber'];?></td>
    <td><?php echo $list['town'];?></td>
    <td><?php echo $list['company'];?></td>
    <td><?php echo $list['starttime'];?></td>
    <td><center><?php if($list['submited']) { ?>是<?php } else { ?>否<?php } ?></center></td>
    <td><?php echo $list['spenttime'];?></td>
    <th><center><?php echo $list['score'];?></center></th>
  </tr>
  <?php } } ?>  </tbody>
  <tfoot>
  <tr>
      <td colspan="9">
          <span class="pagebox"><?php echo $pages;?></span>
          <input type="submit" class="button" value="删除">　 
          <input type="button" class="button" value="<?php echo $lang['refresh'];?>" onclick="window.location.reload()">　 
          <a class="button" href="/?m=<?php echo $G['m'];?>&c=<?php echo $G['c'];?>&a=exportresult&paperid=<?php echo $paperid;?>">导出EXCEL表格</a>
      </td>
  </tr>
 </tfoot>
</table>
</form>
<script type="text/javascript">
function toggleSort(field,asc){
	var asort = asc == 'ASC' ? 'DESC' : 'ASC';
	window.location.href = '/?m=<?php echo $G['m'];?>&c=<?php echo $G['c'];?>&a=<?php echo $G['a'];?>&paperid=<?php echo $paperid;?>&orderby='+field+'&asc='+asort;
}
</script><?php include template('footer'); ?>