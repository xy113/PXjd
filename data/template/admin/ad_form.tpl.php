<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>添加广告
<a class="addnew" href="/?m=admin&c=ad&a=showlist&groupid=<?php echo $groupid;?>">返回列表</a>
</h2>
<div class="wrapper">
<form method="post" enctype="multipart/form-data" onSubmit="return checkSubmit();">
<input type="hidden" name="formsubmit" value="yes">
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
  <tr>
    <th width="70"></th>
  </tr>
  <tr>
    <td>标题</td>
    <td><input type="text" class="text" name="adnew[title]" value="<?php echo $ad['title'];?>" id="title"></td>
  </tr>
  <tr>
    <td>分组</td>
    <td>
    	<select name="adnew[groupid]">
        <?php if(is_array($grouplist)) { foreach($grouplist as $glist) { ?>        <option value="<?php echo $glist['groupid'];?>"<?php if($glist['groupid']==$groupid) { ?> selected<?php } ?>><?php echo $glist['groupname'];?></option>
        <?php } } ?>        </select>
    </td>
  </tr>
  <tr>
    <td>数据ID</td>
    <td><input type="text" class="text" name="adnew[dataid]" id="dataid" value="<?php echo $ad['dataid'];?>"></td>
  </tr>
  <tr>
    <td>数据类型</td>
    <td>
    	<select name="adnew[datatype]">
        <?php if(is_array($lang['datatypes'])) { foreach($lang['datatypes'] as $key => $value) { ?>        	<option value="<?php echo $key;?>"<?php if($key==$ad['datatype']) { ?> selected<?php } ?>><?php echo $value;?></option>
           <?php } } ?>        </select>
    </td>
  </tr>
  <tr>
    <td>图片</td>
    <td>
    	<?php if($pic) { ?><p><img src="<?php echo $pic;?>" width="100" height="80"></p><?php } ?>
       <input type="hidden" name="adnew[pic]" value="<?php echo $ad['pic'];?>">
    	<input type="file" name="filedata">
    </td>
  </tr>
  <tr>
    <td colspan="2">
    	<input type="submit" class="button submit" value="提交"> &nbsp;&nbsp;
    	<input type="button" class="button" value="刷新" onclick="window.location.reload()">
    </td>
  </tr>
</table>
</form>
</div>
<script type="text/javascript">
function checkSubmit(){
	if(!$("#title").val()){
		alert('标题不能为空');
		return false;
	}
	if(!$("#dataid").val()){
		alert('数据ID不能为空');
		return false;
	}
	return true;
}
</script><?php include template('footer'); ?>