<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>参数设置</h2>
<div class="wrapper">
<form method="post">
<input type="hidden" name="formsubmit" value="yes">
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<table class="formtable" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody id="basic">
  <tr>
    <td class="bold">系统名称：</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input name="settingnew[sysname]" class="text" value="<?php echo $settings['sysname'];?>" type="text"></td>
    <td>考试系统的名称</td>
  </tr>
  <tr>
    <td class="bold">关闭系统：</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <input type="radio" name="settingnew[closed]" value="1"<?php if($settings['closed']) { ?> checked<?php } ?>> 是
      <input type="radio" name="settingnew[closed]" value="0"<?php if(!$settings['closed']) { ?> checked<?php } ?>> 否
    </td>
    <td>开启则考试系统不可用</td>
  </tr>
  <tr>
    <td class="bold">关闭提示：</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><textarea name="settingnew[closed_tips]" class="textarea" style="height:60px;"><?php echo $settings['closed_tips'];?></textarea></td>
    <td>请输入系统关闭后的提示信息</td>
  </tr>
  
  <tr>
    <td class="bold">题库选择：</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
    	<select class="select" name="settingnew[paperid]">
        <?php if(is_array($paperlist)) { foreach($paperlist as $list) { ?>        <option value="<?php echo $list['paperid'];?>"<?php if($settings['paperid']==$list['paperid']) { ?> selected<?php } ?>><?php echo $list['name'];?></option>
        <?php } } ?>        </select>
    </td>
    <td>请选择当前考试的题库</td>
  </tr>
  <tr>
    <td class="bold">考题分类：</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><textarea name="settingnew[subject_type]" class="textarea" style="height:120px;"><?php echo $settings['subject_type'];?></textarea></td>
    <td>每行一个，格式:分类ID=分类名称</td>
  </tr>
  </tbody>
  <tfoot>
    <tr class="bottom">
      <td colspan="2"><input name="button-submit" class="button submit" value="提交" type="submit"></td>
    </tr>
  </tfoot>
</table>
</form>
</div><?php include template('footer'); ?>