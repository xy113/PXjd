<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>
<?php if($G['a']=='editsubject') { ?>编辑题目<?php } else { ?>新增题目<?php } ?>
<a class="addnew" href="/?m=admin&c=research&a=subject&paperid=<?php echo $paperid;?>">返回列表</a>
</h2>
<div class="wrapper">
<form method="post">
<input type="hidden" name="formsubmit" value="yes">
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<table class="formtable" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody id="basic">
  <tr>
    <td class="bold">题目标题：</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input name="newsubject[subject]" class="text" value="<?php echo $subject['subject'];?>" type="text"></td>
    <td>题目标题，不要加题号</td>
  </tr>
  <tr>
    <td class="bold">答题方式：</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      	<select name="newsubject[valuetype]" style="width:300px;">
        	<option value="radio"<?php if($subject['valuetype']=='radio') { ?> selected<?php } ?>>单选按钮</option>
           <option value="checkbox"<?php if($subject['valuetype']=='checkbox') { ?> selected<?php } ?>>多选按钮</option>
           <option value="text"<?php if($subject['valuetype']=='text') { ?> selected<?php } ?>>单行文本框</option>
           <option value="textarea"<?php if($subject['valuetype']=='textarea') { ?> selected<?php } ?>>多行文本框</option>
        </select>
    </td>
    <td>答题方式,单选题和是非题选择“单选按钮”，多选题选择“多选按钮”，论述题选择“多行文本框”</td>
  </tr>
  <tr>
    <td class="bold">题目选项：</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><textarea name="options" class="textarea" style="height:120px;"><?php echo $options;?></textarea></td>
    <td>每行一个，格式:选项=选项值，如A=好，是非题论述题请留空</td>
  </tr>
  <tr>
    <td class="bold">题目说明：</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><textarea name="newsubject[description]" class="textarea" style="height:120px;"><?php echo $subject['description'];?></textarea></td>
    <td>题目说明，没有则留空</td>
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