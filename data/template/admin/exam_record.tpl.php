<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>
<span class="right">
	<form name="search" action="/?">
        <input type="hidden" name="m" value="admin">
        <input type="hidden" name="c" value="exam">
        <input type="hidden" name="a" value="record">
        <select name="paperid" id="paperid">
        	<option value="0">全部</option>
        <?php if(is_array($paperlist)) { foreach($paperlist as $list) { ?>           <option value="<?php echo $list['paperid'];?>"<?php if($paperid==$list['paperid']) { ?> selected<?php } ?>><?php echo $list['name'];?></option>
           <?php } } ?>        </select>
        <!--<input type="text" class="text text200" name="kw" value="<?php echo $kw;?>">-->
        <input type="submit" class="button search" value="<?php echo $lang['search'];?>">
    </form>
</span>
答题记录
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
  <?php if(is_array($recordlist)) { foreach($recordlist as $list) { ?>  <?php $examinee=$examineelist[$list['uid']]; ?>  <?php $list['spenttime']=$this->_formatTime($list['submittime']-$list['starttime']); ?>  <?php $list['starttime']=@date('Y-m-d H:i',$list['starttime']); ?>  <tr>
    <td><input type="checkbox" class="checkbox" name="delete[]" value="<?php echo $list['recordid'];?>"></td>
    <th><a href="/?m=exam&c=paper&a=viewpaper&uid=<?php echo $list['uid'];?>&recordid=<?php echo $list['recordid'];?>" target="_blank"><?php echo $examinee['username'];?></a></th>
    <td><?php echo $examinee['idnumber'];?></td>
    <td><?php echo $examinee['town'];?></td>
    <td><?php echo $examinee['company'];?></td>
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
          <?php if($questionid) { ?><a href="javascript:;" class="button" onclick="window.open('/?m=<?php echo $G['m'];?>&c=<?php echo $G['c'];?>&a=exportresult&questionid=<?php echo $questionid;?>&page=<?php echo $G['page'];?>');">导出EXCEL表格</a><?php } ?>
      </td>
  </tr>
 </tfoot>
</table>
</form>
<script type="text/javascript">
function toggleSort(field,asc){
	var asort = asc == 'ASC' ? 'DESC' : 'ASC';
	window.location.href = '/?m=<?php echo $G['m'];?>&c=<?php echo $G['c'];?>&a=<?php echo $G['a'];?>&orderby='+field+'&asc='+asort;
}
</script><?php include template('footer'); ?>