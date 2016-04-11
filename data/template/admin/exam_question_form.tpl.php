<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2><?php if($G['a']=='createquestion') { ?>添加项目<?php } else { ?>编辑项目<?php } ?>
<a class="addnew" href="/?m=admin&c=exam&a=question">项目列表</a>
</h2>
<div class="wrapper">
<form method="post">
<input type="hidden" name="formsubmit" value="yes">
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<table class="formtable" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody id="basic">
  <tr>
    <td class="bold">项目名称：</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input name="question[name]" class="text" value="<?php echo $question['name'];?>" type="text"></td>
    <td>考试项目的名称</td>
  </tr>
  <tr>
    <td class="bold">考试时长：</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input name="question[timelength]" class="text" value="<?php echo $question['timelength'];?>"></td>
    <td>设置考试时间，一分钟为单位</td>
  </tr>
  
  <tr>
    <td class="bold">出题方式：</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <input type="radio" name="question[make_type]" value="1"<?php if($question['make_type']!=2) { ?> checked<?php } ?>> 随机出题
      <input type="radio" name="question[make_type]" value="2"<?php if($question['make_type']==2) { ?> checked<?php } ?>> 统一出题
    </td>
    <td>随机出题则系统随机抽取题目，统一出题则系统按题目顺序统一出题。</td>
  </tr>
  <tr>
    <td class="bold">考卷设置：</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><textarea name="question[subject_set]" class="textarea" style="height:120px;"><?php echo $question['subject_set'];?></textarea></td>
    <td>每行一个，格式:考题分类ID=题目数=单题分值</td>
  </tr>
  <tr>
    <td class="bold">考试说明：</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><textarea name="question[tips]" class="textarea" style="height:120px;"><?php echo $question['tips'];?></textarea></td>
    <td>请输入考试规则及评分标准等</td>
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