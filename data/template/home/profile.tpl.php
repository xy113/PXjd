<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header_home'); ?><div id="mainFrame" class="tableView">
  <form id="form" method="post" action="" autocomplete="off">
  <input type="hidden" name="formsubmit" value="yes" />
  <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />
    <div class="itemRow">
        <div class="item-name">手机号</div>
        <div class="item-input"><input type="text" class="input-text" maxlength="11"  name="accountnew[mobile]" value="<?php echo $account['mobile'];?>" node="mobile"></div>
        <div class="item-tips">仅支持13,15,18开头的11位手机号码。</div>
    </div>
    <div class="itemRow">
        <div class="item-name">邮箱</div>
        <div class="item-input"><input type="text" class="input-text" maxlength="50" name="accountnew[email]" value="<?php echo $account['email'];?>" node="email"></div>
        <div class="item-tips">标准邮箱格式，长度不能超过50位字符。</div>
    </div>
    <div class="itemRow bc">
        <div class="item-name">性别</div>
        <div class="item-input">
            <?php if(is_array($lang['sexitems'])) { foreach($lang['sexitems'] as $k => $v) { ?>            <input type="radio" value="<?php echo $k;?>" name="profilenew[usersex]"<?php if($k==$profile['usersex']) { ?> checked="checked"<?php } if($profile['locked']) { ?> disabled="disabled"<?php } ?>> <?php echo $v;?>
            <?php } } ?>        </div>
        <div class="item-tips">选择你的性别</div>
    </div>
    <div class="itemRow">
        <div class="item-name">生日</div>
        <div class="item-input"><input type="text" class="input-text" name="profilenew[birthday]" onclick="WdatePicker()" value="<?php echo $profile['birthday'];?>" readonly></div>
        <div class="item-tips">填写你的出生年月</div>
    </div>
    <div class="itemRow">
        <div class="item-name">星座</div>
        <div class="item-input">
            <select class="input-select" name="profilenew[star]">
                  <?php if(is_array($lang['staritems'])) { foreach($lang['staritems'] as $k => $v) { ?>                <option value="<?php echo $k;?>"<?php if($k==$profile['star']) { ?> selected="selected"<?php } ?>><?php echo $v;?></option>
                <?php } } ?>            </select>
        </div>
        <div class="item-tips">选择你的星座</div>
    </div>
    <div class="itemRow">
        <div class="item-name">血型</div>
        <div class="item-input">
            <select class="input-select" name="profilenew[blood]">
                  <?php if(is_array($lang['blooditems'])) { foreach($lang['blooditems'] as $k => $v) { ?>                <option value="<?php echo $k;?>"<?php if($k==$profile['blood']) { ?> selected="selected"<?php } ?>><?php echo $v;?></option>
                <?php } } ?>            </select>
        </div>
        <div class="item-tips">选择你的血型</div>
    </div>
    <div class="itemRow">
        <div class="item-name">QQ</div>
        <div class="item-input"><input type="text" class="input-text" name="profilenew[qq]" value="<?php echo $profile['qq'];?>"></div>
        <div class="item-tips">填写你的QQ号</div>
    </div>
    <div class="itemRow">
        <div class="item-name">微信</div>
        <div class="item-input"><input type="text" class="input-text" name="profilenew[weixin]" value="<?php echo $profile['weixin'];?>"></div>
        <div class="item-tips">填写你的微信号</div>
    </div>
    <div class="itemRow">
        <div class="item-name">国籍</div>
        <div class="item-input">
            <select class="input-select" name="profilenew[country]">
               <option value="中国">中国</option>
            </select>
        </div>
        <div class="item-tips">填写你的国籍</div>
    </div>
    <div class="itemRow">
        <div class="item-name">所在地</div>
        <div class="item-input" id="district" style="width:80%;">
           <select class="input-select dist" id="province" name="profilenew[province]">
            <option value="">请选择</option>
          </select>
          <select class="input-select dist" id="city" name="profilenew[city]">
              <option value="">请选择</option>
          </select>
          <select class="input-select dist" id="county" name="profilenew[county]">
              <option value="">请选择</option>
          </select>
          <select class="input-select dist" id="town" name="profilenew[town]">
              <option value="">请选择</option>
          </select>
        </div>
        <!--<div class="item-tips">你当前所工作或生活的地方</div>-->
    </div>
    <div class="itemRow">
        <div class="item-name">个人描述</div>
        <div class="item-input"><textarea name="profilenew[introduction]" class="textarea" draggable="false"><?php echo $profile['introduction'];?></textarea></div>
        <div class="item-tips">简单地介绍一下自己，不超过300个字。</div>
    </div>
    <div class="itemRow item-button">
        <div class="item-name">&nbsp;</div>
        <div class="item-input"><button type="submit" class="input-button" node="button">保存资料</button></div>
    </div>
    </form>
</div>
<script type="text/javascript">
DSXCMS.showDistrict(0,'#province','<?php echo $profile['province'];?>','请选择省份');
$("#province").change(function(){
	var fid = $(this).find("option:selected").attr('idvalue');
	//if(!fid) return;
	DSXCMS.showDistrict(fid,'#city','<?php echo $profile['city'];?>','请选择城市');
});

$("#city").change(function(){
	var fid = $(this).find("option:selected").attr('idvalue');
	//if(!fid) return;
	DSXCMS.showDistrict(fid,'#county','<?php echo $profile['county'];?>','请选择区县州');
});

$("#county").change(function(){
	var fid = $(this).find("option:selected").attr('idvalue');
	//if(!fid) return;
	DSXCMS.showDistrict(fid,'#town','<?php echo $profile['town'];?>','请选择乡镇');
});

;(function(){
	$("#form").submit(function(){
		$("#form").find("input").removeClass("focus");
		var mobile = $("[node=mobile]");
		if(mobile.val() && !DSXCMS.IsMobile(mobile.val())){
			mobile.addClass("focus").focus();
			DSXUI.error('手机号码输入有误');
			return false;
		}
		var email = $("[node=email]");
		if(email.val() && !DSXCMS.IsEmail(email.val())){
			mobile.addClass("focus").focus();
			DSXUI.error('手机号码输入有误');
			return false;
		}
		if(!mobile.val() && !email.val()){
			DSXUI.error('手机号码和邮箱至少填一个');
			return false;
		}
		return true;
	});
})();
</script><?php include template('footer_home'); ?>