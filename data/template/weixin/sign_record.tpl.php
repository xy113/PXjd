<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('weixin_header'); ?><div id="weixin">
	<table cellpadding="0" cellspacing="0" width="100%" class="listtable">
    	<tr>
        	<th width="100">签到时间</th>
           <th>签到地点</th>
        </tr>
        <?php if(is_array($signlist)) { foreach($signlist as $list) { ?>        <?php $signtime=@date('y-m-d H:i',$list['dateline']); ?>        <tr>
        	<td><?php echo $signtime;?></td>
           <td><?php echo $list['location'];?></td>
        </tr>
        <?php } } ?>    </table>
</div><?php include template('weixin_tabbar'); include template('weixin_footer'); ?>