<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>站点设置</h2>
<div class="wrapper">
<form method="post" name="settings" action="/?m=admin&c=setting&a=save">
<input type="hidden" name="formsubmit" value="yes">
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="formtable">
<tbody>
<tr>
  <td width="360" class="bold">开放用户注册：</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>
<input type="radio" value="1" class="radio" name="settingnew[regallowed]"<?php if($setting['regallowed']) { ?> checked<?php } ?>>
是&#12288;
  <input type="radio" value="0" class="radio" name="settingnew[regallowed]"<?php if(!$setting['regallowed']) { ?> checked<?php } ?>>
否			
  </td>
  <td>设置是否允许游客注册成为网站会员。</td>
  </tr>
<tr>
  <td class="bold">新用户注册验证:</td>
  <td>&nbsp;</td>
  </tr>
<tr>
  <td>
<select style="width:300px;" name="settingnew[regverify]">
<option value="0"<?php if($setting['regverify']=='0') { ?> selected<?php } ?>>无</option>
<option value="1"<?php if($setting['regverify']=='1') { ?> selected<?php } ?>>Email验证</option>
<option value="2"<?php if($setting['regverify']=='2') { ?> selected<?php } ?>>人工审核</option>
</select>
  </td>
  <td>选择“无”用户可直接注册成功；选择“Email 验证”将向用户注册 Email 发送一封验证邮件以确认邮箱的有效性；选择“人工审核”将由管理员人工逐个确定是否允许新用户注册</td>
  </tr>
<tr>
  <td class="bold">发送欢迎信息：</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>
<ul>
<li><input type="radio" value="0" class="radio" name="settingnew[wellcomemsg]"<?php if($setting['wellcomemsg']=='0') { ?> checked<?php } ?>> 不发送</li>
<li><input type="radio" value="1" class="radio" name="settingnew[wellcomemsg]"<?php if($setting['wellcomemsg']=='1') { ?> checked<?php } ?>> 发送欢迎短信息</li>
<li><input type="radio" value="2" class="radio" name="settingnew[wellcomemsg]"<?php if($setting['wellcomemsg']=='2') { ?> checked<?php } ?>> 发送欢迎Email</li>
</ul>		 	
</td>
  <td>可选择是否自动向新注册用户发送一条欢迎信息</td>
  </tr>
<tr>
  <td class="bold">欢迎邮件标题：</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td><input type="text" value="<?php echo $setting['wellcomemsgtitle'];?>" class="text" name="settingnew[wellcomemsgtitle]"></td>
  <td>系统发送的欢迎信息的标题，不支持 HTML，不超过 75 字节。</td>
  </tr>
<tr>
  <td class="bold">欢迎邮件内容：</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td><textarea class="textarea" name="settingnew[wellcomemsgtxt]"><?php echo $setting['wellcomemsgtxt'];?></textarea></td>
  <td>系统发送的欢迎信息的内容。标题内容均支持变量替换，可以使用如下变量:<br><?php echo username;?> : 用户名<br><?php echo time;?> : 发送时间<br><?php echo sitename;?> : 站点名称<br><?php echo adminemail;?> : 管理员email</td>
  </tr>
<tr>
  <td class="bold">显示许可协议：</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>
    <input type="radio" value="1" class="radio" name="settingnew[sysrules]"<?php if($setting['sysrules']) { ?> checked<?php } ?>>
    是&#12288;
    <input type="radio" value="0" class="radio" name="settingnew[sysrules]"<?php if(!$setting['sysrules']) { ?> checked<?php } ?>>
    否			
</td>
  <td>新用户注册时显示许可协议</td>
  </tr>
<tr>
  <td class="bold">许可协议内容：</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td><textarea class="textarea" name="settingnew[sysrulestxt]"><?php echo $setting['sysrulestxt'];?></textarea></td>
  <td>注册许可协议的详细内容</td>
  </tr>
</tbody>
<tfoot>
  <tr class="bottom">
	<td colspan="2"><input type="submit" value="提交" class="button submit" name="button-submit"></td>
  </tr>
</tfoot>
</table>
</form>
</div><?php include template('footer'); ?>