<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); if($G['a']=='edit') { ?>
<h2>编辑分类
<a class="addnew" href="/?m=admin&c=category&a=showlist&type=<?php echo $category['type'];?>">返回列表</a>
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
    <td>分类名称</td>
    <td><input type="text" class="text" name="category[cname]" value="<?php echo $category['cname'];?>" id="cname"></td>
  </tr>
  <tr>
    <td>上级分类</td>
    <td>
    	<select name="category[fid]" style="width:300px;">
        <?php if(is_array($categorylist)) { foreach($categorylist as $list) { ?>        <?php if($list['fid']==0&&$list['catid']!=$category['catid']) { ?>
        <option value="<?php echo $list['catid'];?>"<?php if($list['catid']==$category['fid']) { ?> selected<?php } ?>><?php echo $list['cname'];?></option>
        <?php } ?>
        <?php } } ?>        </select>
    </td>
  </tr>
  <tr>
    <td>首页模板</td>
    <td><input type="text" class="text" name="category[template_index]" value="<?php echo $category['template_index'];?>"></td>
  </tr>
  <tr>
    <td>列表模板</td>
    <td><input type="text" class="text" name="category[template_list]" value="<?php echo $category['template_list'];?>"></td>
  </tr>
  <tr>
    <td>详细模板</td>
    <td><input type="text" class="text" name="category[template_detail]" value="<?php echo $category['template_detail'];?>"></td>
  </tr>
  <tr>
    <td>分类图片</td>
    <td>
    	<?php if($pic) { ?><p><img src="<?php echo $pic;?>" width="100" height="80"></p><?php } ?>
       <input type="hidden" name="category[image]" value="<?php echo $category['image'];?>">
    	<input type="file" name="filedata">
    </td>
  </tr>
  <tr>
    <td>SEO关键字</td>
    <td><input type="text" class="text" name="category[keywords]" value="<?php echo $category['keywords'];?>"></td>
  </tr>
  <tr>
    <td>SEO描述</td>
    <td><textarea class="textarea" name="category[description]"><?php echo $category['description'];?></textarea></td>
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
	if(!$("#cname").val()){
		alert('分类名称不能为空');
		return false;
	}
	return true;
}
</script>
<?php } else { ?>
<h2>分类管理</h2>
<form method="post" action="">
    <input type="hidden" name="formsubmit" value="yes" />
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
    <thead>
    	<th width="30"><input type="checkbox" class="checkbox" onclick="DSXCMS.checkAll(this,'delete[]');" /></th>
       <th width="30">ID</th>
       <th width="60">图片</th>
       <th>分类名称</th>
       <th width="60">显示顺序</th>
       <th width="100">首页模板</th>
       <th width="100">列表模板</th>
       <th width="100">正文模板</th>
       <th width="40">可用</th>
       <th width="50">选项</th>
    </thead>
    <?php if(is_array($categorylist)) { foreach($categorylist as $list) { ?>    <?php if($list['fid']==0) { ?>
    <tbody id="group_<?php echo $list['catid'];?>">
    <tr>
      <td><input type="checkbox" name="delete[]" value="<?php echo $list['catid'];?>" /></td>
      <td><?php echo $list['catid'];?></td>
      <td><img src="<?php echo $list['image'];?>" width="50" height="50" onclick="openUploadWindow(this,<?php echo $list['catid'];?>);"></td>
      <td>
      <input type="text" class="text text200" name="categorylist[<?php echo $list['catid'];?>][cname]" value="<?php echo $list['cname'];?>" maxlength="10">
      <a href="javascript:;" onclick="addNew(<?php echo $list['catid'];?>)">+添加子分类</a>
      </td>
      <td><input type="text" class="text text60"  name="categorylist[<?php echo $list['catid'];?>][displayorder]" value="<?php echo $list['displayorder'];?>"></td>
	  <td><input type="text" class="text text100" name="categorylist[<?php echo $list['catid'];?>][template_index]" value="<?php echo $list['template_index'];?>"></td>
      <td><input type="text" class="text text100" name="categorylist[<?php echo $list['catid'];?>][template_list]" value="<?php echo $list['template_list'];?>"></td>
      <td><input type="text" class="text text100" name="categorylist[<?php echo $list['catid'];?>][template_detail]" value="<?php echo $list['template_detail'];?>"></td>
	  <td><input type="checkbox" class="checkbox" name="categorylist[<?php echo $list['catid'];?>][available]" value="1"<?php if($list['available']) { ?> checked="checked"<?php } ?>></td>
	  <td><a href="/?m=admin&c=category&a=edit&type=<?php echo $list['type'];?>&catid=<?php echo $list['catid'];?>" class="edit">编辑</a></td>
    </tr>
        <?php if(is_array($categorylist)) { foreach($categorylist as $sub) { ?>        <?php if($sub['fid']==$list['catid']) { ?>
        <tr class="white">
          <td><input type="checkbox" name="delete[]" value="<?php echo $sub['catid'];?>" /></td>
          <td><?php echo $list['catid'];?></td>
          <td><img src="<?php echo $sub['image'];?>" width="50" height="50" onclick="openUploadWindow(this,<?php echo $sub['catid'];?>);"></td>
          <td>
          <div class="join"></div>
          <input type="text" class="text text200" name="categorylist[<?php echo $sub['catid'];?>][cname]" value="<?php echo $sub['cname'];?>" maxlength="10">
          </td>
          <td><input type="text" class="text text60"  name="categorylist[<?php echo $sub['catid'];?>][displayorder]" value="<?php echo $sub['displayorder'];?>"></td>
          <td><input type="text" class="text text100" name="categorylist[<?php echo $sub['catid'];?>][template_index]" value="<?php echo $sub['template_index'];?>"></td>
          <td><input type="text" class="text text100" name="categorylist[<?php echo $sub['catid'];?>][template_list]" value="<?php echo $sub['template_list'];?>"></td>
          <td><input type="text" class="text text100" name="categorylist[<?php echo $sub['catid'];?>][template_detail]" value="<?php echo $sub['template_detail'];?>"></td>
          <td><input type="checkbox" class="checkbox" name="categorylist[<?php echo $sub['catid'];?>][available]" value="1"<?php if($sub['available']) { ?> checked="checked"<?php } ?>></td>
          <td><a href="/?m=admin&c=category&a=edit&type=<?php echo $list['type'];?>&catid=<?php echo $sub['catid'];?>" class="edit">编辑</a></td>
        </tr>
        <?php } ?>
        <?php } } ?>    <?php } ?>
    </tbody>
    <?php } } ?>    <tbody id="group_0"></tbody>
    <tfoot>
    <tr>
        <td colspan="8"><a href="javascript:;" onclick="addNew(0)"><i class="icon">&#xf0154;</i>添加分类</a></td>
    </tr>
    <tr>
        <td colspan="8">提示:选中复选框提交后选中项将被删除</td>
    </tr>
    <tr>
        <td colspan="8">
            <input type="submit" class="button" value="提交" />　
            <input type="button" class="button" value="刷新" onclick="window.location.reload()" />
        </td>
    </tr>
    </tfoot>
  </table>
 </form>
<script type="text/template" id="tpItem">
<tr>
	<td><input type="hidden" name="newcategory[fid][]" value="[#fid#]" /></td>
	<td></td>
	<td></td>
	<td>[#join#]<input type="text" class="text text200" name="newcategory[cname][]" value=""></td>
	<td><input type="text" class="text text60"  name="newcategory[displayorder][]" value="0"></td>
	<td><input type="text" class="text text100" name="newcategory[template_index][]" value=""></td>
	<td><input type="text" class="text text100" name="newcategory[template_list][]" value=""></td>
	<td><input type="text" class="text text100" name="newcategory[template_detail][]" value=""></td>
	<td><input type="checkbox" class="checkbox" name="newcategory[available][]" value="1" checked="checked"></td>
	<td><a href="javascript:;" class="delete">删除</a></td>
</tr>
</script>
<script type="text/javascript">
function addNew(fid){
	var html = $("#tpItem").html().replace(/\[#fid#\]/g,fid);
	if(fid > 0){
		html = html.replace(/\[#join#\]/g,'<div class="join"></div>');
	}
	var rowItem = $(html);
	rowItem.find('.delete').click(function(){
		rowItem.remove();
	});
	$("#group_"+fid).append(rowItem);
}
function openUploadWindow(obj,catid){
	DSXUI.showUpload({m:'admin',c:'<?php echo $G['c'];?>',a:'setimage',catid:catid},{callback:function(json){
		$(obj).attr('src',json.data.pic);
	}});
}
</script>
<?php } include template('footer'); ?>