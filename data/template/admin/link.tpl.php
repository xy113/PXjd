<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>链接管理</h2>
<form method="post" action="">
    <input type="hidden" name="formsubmit" value="yes" />
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
    <thead>
    <tr>
      <th width="50"><input type="checkbox" class="checkbox" onclick="DSXCMS.checkAll(this,'delete[]')" />删?</th>
      <th width="60">显示顺序</th>
      <th width="200">名称</th>
      <th width="200">网址</th>
      <th>图片</th>
    </tr>
    </thead>
    <?php if(is_array($linkclasses)) { foreach($linkclasses as $cla) { ?>    <tbody id="tbcontent_<?php echo $cla['linkid'];?>">
    <tr class="white">
      <td>
      <input type="checkbox" name="delete[]" value="<?php echo $cla['linkid'];?>" />
      <input type="hidden" name="newclass[linkid][]" value="<?php echo $cla['linkid'];?>">
      </td>
      <td><input type="text" class="text text30" name="newclass[displayorder][]" value="<?php echo $cla['displayorder'];?>" maxlength="4"></td>
      <td colspan="3">
      	<input type="text" class="text text100" name="newclass[title][]" value="<?php echo $cla['title'];?>" maxlength="10" style="font-weight:bold;"> 
      	<a href="javascript:;" onclick="addLink(<?php echo $cla['linkid'];?>)"><i class="icon">&#xf0154;</i>添加链接</a>
      </td>
    </tr>
    <?php if(is_array($linklist)) { foreach($linklist as $link) { ?>    <?php if($link['classid']==$cla['linkid']) { ?>
    <tr class="white">
      <td>
      <input type="checkbox" name="delete[]" value="<?php echo $link['linkid'];?>" />
      <input type="hidden" name="newlink[linkid][]" value="<?php echo $link['linkid'];?>" />
      <input type="hidden" name="newlink[classid][]" value="<?php echo $link['classid'];?>" />
      </td>
      <td><input type="text" class="text text30" name="newlink[displayorder][]" value="<?php echo $link['displayorder'];?>" maxlength="4"></td>
      <td>|––<input type="text" class="text text100" name="newlink[title][]" value="<?php echo $link['title'];?>" maxlength="10"></td>
      <td><input type="text" class="text text200" name="newlink[url][]" value="<?php echo $link['url'];?>"></td>
      <td><input type="text" class="text text200" name="newlink[pic][]" value="<?php echo $link['pic'];?>"></td>
    </tr>
    <?php } ?>
    <?php } } ?>    </tbody>
    <?php } } ?>    <tbody id="tbclass"></tbody>
    <tfoot>
    <tr>
        <td colspan="5"><a href="javascript:;" onclick="addClass()"><i class="icon">&#xf0154;</i>添加分类</a></td>
    </tr>
    <tr>
        <td colspan="5">
            <span class="pagebox"><?php echo $pagelink;?></span>
            <input type="submit" class="button" value="提交" />　
            <input type="button" class="button" value="刷新" onclick="window.location.reload()" />
        </td>
    </tr>
    </tfoot>
  </table>
 </form>
<script type="text/template" id="tplLink">
<tr class="white">
<td><input type="hidden" name="newlink[classid][]" value="[[classid]]" /><input type="hidden" name="newlink[linkid][]" value="0" /></td>
<td><input type="text" class="text text30" name="newlink[displayorder][]" value="0" maxlength="4"></td>
<td>|––<input type="text" class="text text100" name="newlink[title][]" value="" maxlength="10"></td>
<td><input type="text" class="text text200" name="newlink[url][]" value=""></td>
<td><input type="text" class="text text200" name="newlink[pic][]" value=""></td>
</tr>
</script>
<script type="text/template" id="tplClass">
<tr class="white">
  <td><input type="hidden" name="newclass[linkid][]" value="0"></td>
  <td><input type="text" class="text text30" name="newclass[displayorder][]" value="0" maxlength="4"></td>
  <td colspan="3"><input type="text" class="text text100" name="newclass[title][]" value="" maxlength="10"></td>
</tr>
</script>
<script type="text/javascript">
function addClass(){
	$("#tbclass").append($("#tplClass").html());
}
function addLink(classid){
	$("#tbcontent_"+classid).append($("#tplLink").html().replace(/\[\[classid\]\]/g,classid));
}
</script><?php include template('footer'); ?>