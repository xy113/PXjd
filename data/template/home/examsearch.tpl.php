<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header_home'); ?><div id="mainFrame">
	<div class="top">
        <span>成绩查询</span>
    </div>
	<form method="post" autocomplete="off">
    <input type="hidden" name="formsubmit" value="yes">
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable goodslist">
      <thead>
      <tr>
      	 <th width="40"><center>序号</center></th>
        <th>考试项目</th>
        <th width="140">考试时间</th>
        <th width="140">交卷时间</th>
        <th width="80">用时</th>
        <th width="60"><center>已交卷</center></th>
        <th width="60"><center>成绩</center></th>
      </tr>
      </thead>
      <tbody>
      <?php $orderno=1; ?>      <?php if(is_array($recordlist)) { foreach($recordlist as $recordid => $list) { ?>      <tr>
      	 <td><center><?php echo $orderno;?></center></td>
        <td>
        	<h3><a href="/?m=exam&c=paper&a=viewpaper&recordid=<?php echo $list['recordid'];?>" target="_blank"><?php echo $paperlist[$list['paperid']]['name'];?></a></h3>
        </td>
        <td><?php echo $list['starttime'];?></td>
        <td><?php echo $list['submittime'];?></td>
        <td><?php echo $list['spenttime'];?></td>
        <td><center><?php if($list['submited']) { ?>是<?php } else { ?>否<?php } ?></center></td>
        <td><center><?php echo $list['score'];?></center></td>
      </tr>
      <?php $orderno++; ?>      <?php } } ?>      </tbody>
    </table>
    </form>
</div><?php include template('footer_home'); ?>