<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header_home'); ?><div id="mainFrame">
    <div class="infoblock">
    	<form class="infotitle">
        	<fieldset>
            	<legend>基本信息</legend>
            </fieldset>
        </form>
        <div>
        	<div class="pf_item">
            	<div class="label">显示名称</div>
                <div class="con"><?php echo $member['username'];?></div>
            </div>
            <div class="pf_item">
            	<div class="label">性别</div>
                <div class="con"><?php echo $lang['sexitems'][$profile['usersex']];?></div>
            </div>
            <div class="pf_item">
            	<div class="label">生日:</div>
                <div class="con"><?php echo $profile['birthday'];?></div>
            </div>
            <div class="pf_item">
            	<div class="label">血型</div>
                <div class="con"><?php echo $lang['blooditems'][$profile['blood']];?></div>
            </div>
            <div class="pf_item">
            	<div class="label">所在地</div>
                <div class="con"><?php echo $profile['province'];?>  <?php echo $profile['city'];?>  <?php echo $profile['county'];?></div>
            </div>
            <div class="pf_item">
            	<div class="label">个人简介</div>
                <div class="con"><?php echo $profile['introduction'];?></div>
            </div>
        </div>
    </div>
    <!--联系信息-->
    <div class="infoblock">
    	<form class="infotitle">
        	<fieldset>
            	<legend>联系信息</legend>
            </fieldset>
        </form>
        <div>
        	<div class="pf_item">
            	<div class="label">QQ</div>
                <div class="con"><?php echo $profile['qq'];?></div>
            </div>
            <div class="pf_item">
            	<div class="label">微信</div>
                <div class="con"><?php echo $profile['weixin'];?></div>
            </div>
            <div class="pf_item">
            	<div class="label">邮箱</div>
                <div class="con"><?php echo $member['email'];?></div>
            </div>
        </div>
    </div>
    <!--教育信息-->
    <div class="infoblock">
    	<form class="infotitle">
        	<fieldset>
            	<legend>教育信息</legend>
            </fieldset>
        </form>
        <div>
        <?php if(is_array($educations)) { foreach($educations as $edu) { ?>        	<div class="pf_item">
            	<div class="label"><?php echo $lang['eduitems'][$edu['edutype']];?></div>
                <div class="con">
                    <p><?php echo $edu['schoolname'];?> <?php echo $edu['faculty'];?></p>
                    <p><?php echo $edu['startdate'];?> — <?php echo $edu['enddate'];?></p>
                </div>
            </div>
            <?php } } ?>        </div>
    </div>
    <!--教育信息-->
    <div class="infoblock">
    	<form class="infotitle">
        	<fieldset>
            	<legend>工作经历</legend>
            </fieldset>
        </form>
        <div>
        <?php if(is_array($workexp)) { foreach($workexp as $work) { ?>        	<div class="pf_item">
            	<div class="label" style="width:150px;"><?php echo $work['company'];?></div>
                <div class="con">
                    <p><?php echo $work['position'];?></p>
                    <p><?php echo $work['startdate'];?> — <?php echo $work['enddate'];?></p>
                </div>
            </div>
            <?php } } ?>        </div>
    </div>
    <!--个人标签-->
    <div class="infoblock">
    	<form class="infotitle">
        	<fieldset>
            	<legend>个人标签</legend>
            </fieldset>
        </form>
        <div>
        	<div class="pf_item">
            	<div class="label">标签</div>
                <div class="con"><?php if(is_array($tags)) { foreach($tags as $tag) { ?><a href="javascript:;"><?php echo $tag;?></a>&nbsp;&nbsp;<?php } } ?></div>
            </div>
        </div>
    </div>
</div><?php include template('footer_home'); ?>