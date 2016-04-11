<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('weixin_header'); ?><div id="profile">
	<div class="mheader">
    	<div class="avatar"><img src="/?m=member&c=avatar&size=big&uid=<?php echo $G['uid'];?>"></div>
       <div class="username"><?php echo $G['username'];?></div>
    </div>
    
    <div class="box-hd">
    	<div class="box">
        	<a href="/?m=weixin&c=exam&a=sign">
        	<div class="icon">&#xf0168;</div>
           <div class="title">答题登记</div>
           </a>
        </div>
        <div class="box">
        	<a href="/?m=weixin&c=exam&a=viewrecord">
        	<div class="icon">&#xf012c;</div>
           <div class="title">成绩查询</div>
           </a>
        </div>
        <div class="box">
        	<a href="/?m=weixin&c=sign">
        	<div class="icon">&#xf014f;</div>
           <div class="title">签到</div>
           </a>
        </div>
        <div class="box">
        	<a href="/?m=weixin&c=exam">
        	<div class="icon">&#xf0199;</div>
           <div class="title">答题</div>
           </a>
        </div>
        <div class="box">
        	<a href="/?m=weixin&c=research">
        	<div class="icon">&#xf01ec;</div>
           <div class="title">问卷调查</div>
           </a>
        </div>
        <div class="box">
        	<a href="/?m=weixin&c=member&a=logout">
        	<div class="icon">&#xf017c;</div>
           <div class="title">退出登录</div>
           </a>
        </div>
    </div>
    
    <div class="content">
    	<h3><div class="icon">&#xf0199;</div>签到记录</h3>
       <table cellpadding="0" cellspacing="0" width="100%" class="listtable">
            <tr>
                <th width="100">签到时间</th>
               <th>签到地点</th>
            </tr>
            <?php if(is_array($signrecordlist)) { foreach($signrecordlist as $list) { ?>            <?php $signtime=@date('y-m-d H:i',$list['dateline']); ?>            <tr>
                <td><?php echo $signtime;?></td>
               <td><?php echo $list['location'];?></td>
            </tr>
            <?php } } ?>        </table>
        <div style="height:40px; text-align:center;"><a href="/?m=weixin&c=sign&a=viewrecord" style="display:block; line-height:40px; font-size:16px;">查看更多</a></div>
    </div>
</div><?php include template('weixin_tabbar'); include template('weixin_footer'); ?>