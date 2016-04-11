<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('weixin_header'); ?><div id="weixin">
	<table cellpadding="0" cellspacing="0" width="100%" class="listtable">
    	<tr>
        	<th>考试项目</th>
           <th width="60">考试时间</th>
           <th width="40"><center>成绩</center></th>
        </tr>
        <?php if(is_array($recordlist)) { foreach($recordlist as $list) { ?>        <?php $examtime=@date('y/m/d',$list['starttime']); ?>        <tr>
        	<th><a href="/?m=weixin&c=exampaper&a=viewpaper&recordid=<?php echo $list['recordid'];?>"><?php echo $questionlist[$list['questionid']]['name'];?></a></th>
           <td><?php echo $examtime;?></td>
           <td><center><?php echo $list['score'];?></center></td>
        </tr>
        <?php } } ?>    </table>
</div><?php include template('weixin_footer'); ?>