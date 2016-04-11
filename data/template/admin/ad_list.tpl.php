<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><style type="text/css">
.file{display:block; width:100%; height:100%; position:absolute; opacity:0; cursor:pointer; top:0; left:0;}
#uploadbutton{background:#09c; color:#fff; font-size:14px; border-radius:5px; height:120px; 
line-height:120px; width:120px; display:block; position:fixed; z-index:100; text-align:center;}
</style>
<h2>
<span class="right">
<form method="get" action="/" id="search">
<input type="hidden" name="m" value="admin">
<input type="hidden" name="c" value="<?php echo $G['c'];?>">
<input type="hidden" name="a" value="<?php echo $G['a'];?>">
<select name="groupid" onChange="$('#search').submit();">
	<option value="0">选择分组</option><?php if(is_array($grouplist)) { foreach($grouplist as $glist) { ?>    <option value="<?php echo $glist['groupid'];?>"<?php if($glist['groupid']==$groupid) { ?> selected<?php } ?>><?php echo $glist['groupname'];?></option>
    <?php } } ?></select>
</form>
</span>
推荐信息列表
<a class="addnew" href="/?m=admin&c=ad&a=publish&groupid=<?php echo $groupid;?>">添加广告信息</a>
</h2>
<form method="post" autocomplete="off">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
<thead>
  <tr>
    <th width="45"><input type="checkbox" class="checkbox" onclick="DSXCMS.checkAll(this,'delete[]')">删?</th>
    <th width="80">图片</th>
    <th>标题</th>
    <th width="80">数据ID</th>
    <th width="80">数据类型</th>
    <th width="160">分组</th>
    <th width="80">排序</th>
    <th width="50">编辑</th>
  </tr>
 </thead>
 <tbody id="mainbody">
  <?php if(is_array($adlist)) { foreach($adlist as $list) { ?>  <tr>
    <td><input type="checkbox" class="checkbox" name="delete[]" value="<?php echo $list['id'];?>"></td>
    <td><img src="<?php echo $list['pic'];?>" width="60" height="40" id="pic_<?php echo $list['id'];?>" onclick="showUpload(<?php echo $list['id'];?>)"></td>
    <td><input type="text" class="text" name="adlist[<?php echo $list['id'];?>][title]" value="<?php echo $list['title'];?>"></td>
    <td><input type="text" class="text text60" name="adlist[<?php echo $list['id'];?>][dataid]" value="<?php echo $list['dataid'];?>"></td>
    <td><?php echo $typelist[$list['idtype']];?></td>
    <td><?php echo $grouplist[$list['groupid']]['groupname'];?></td>
    <td><input type="text" class="text text60" name="adlist[<?php echo $list['id'];?>][displayorder]" value="<?php echo $list['displayorder'];?>"></td>
    <td><a href="/?m=admin&c=ad&a=edit&id=<?php echo $list['id'];?>">编辑</a></td>
  </tr>
  <?php } } ?>  </tbody>
  <tfoot>
  <tr>
      <td colspan="8">
          <span class="pages"><?php echo $pages;?></span>
          <input type="submit" class="button" value="<?php echo $lang['submit'];?>">　 
          <input type="button" class="button" value="<?php echo $lang['refresh'];?>" onclick="window.location.reload()">
      </td>
  </tr>
 </tfoot>
</table>
</form>
<script type="text/template" id="uploadtemplate">
<div id="uploadbutton">
<span>选择图片</span>
<form method="post" id="uploadForm" enctype="multipart/form-data" action="/?m=admin&c=ad&a=setimage">
<input type="hidden" name="id" value="{<?php echo id;?>}">
<input type="file" name="filedata" class="file">
</form>
</div>
</script>
<script type="text/javascript">
function showUpload(id){
	$("#uploadbutton").remove();
	var template = $("#uploadtemplate").html().replace(/\{id\}/,id);
	var button = $(template).appendTo("body");
	var left = ($(window).width() - button.width())/2;
	var top  = ($(window).height() - button.height())/2;
	button.css({'left':left,'top':top});
	$(button).find(".file").change(function(){
		$(button).find("span").text('正在上传...');
		$("#uploadForm").ajaxSubmit({
			dataType:'json',
			success:function(json){
				if(json.state){
					$("#pic_"+id).attr('src',json.data.pic);					
				}else {
					alert(json.error);
				}
				$(button).remove();
			}
		});
	});
}
</script><?php include template('footer'); ?>