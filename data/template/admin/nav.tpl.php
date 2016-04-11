<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>导航管理</h2>
<div class="nav-left">
	<form method="post" name="formcat" id="formcat">
	<div class="menu-header">分类目录</div>
    <div class="content">
    	<select multiple="true" size="10" name="cids[]" style="font-size:14px;"><?php echo $categoryoptions;?></select>
    </div>
    <div class="content">
    	<p style="padding:5px 0;">提示:按住Control键可同时选中多个选项</p>
    	<input type="button" id="addToNav" class="button submit" value="添加到导航">
    </div>
    </form>
</div>
<div class="nav-right">
	<div class="menu-header">拖放各个项目到您喜欢的顺序</div>
    <div class="nav-class">顶部导航</div>
    <div class="nav-item">
    	<div class="nav-title">标题</div>
        <div class="nav-url">URL</div>
        <div class="nav-position">位置</div>
        <div class="nav-target">打开方式</div>
        <div class="nav-available">可用</div>
    </div>
    <form method="post" name="formnav" id="formNav">
    <input type="hidden" name="formsubmit" value="yes">
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
    <div id="navTop">
   <?php if(is_array($navlist['top'])) { foreach($navlist['top'] as $nav) { ?>        <div class="nav-item" id="nav_item_<?php echo $nav['nid'];?>">
            <div class="nav-title"><input type="text" name="navnew[<?php echo $nav['nid'];?>][title]" class="text text100" value="<?php echo $nav['title'];?>"></div>
            <div class="nav-url"><input type="text" name="navnew[<?php echo $nav['nid'];?>][url]" class="text text200" value="<?php echo $nav['url'];?>"<?php if($nav['type']=='system') { ?> disabled<?php } ?>></div>
            <div class="nav-position">
            	<select name="navnew[<?php echo $nav['nid'];?>][position]">
            		<option value="top"<?php if($nav['position']=='top') { ?> selected<?php } ?>>顶部</option>
                    <option value="bottom"<?php if($nav['position']=='bottom') { ?> selected<?php } ?>>底部</option>
                </select>
            </div>
            <div class="nav-target">
            	<select name="navnew[<?php echo $nav['nid'];?>][target]">
                	<option value="_self"<?php if($nav['target']=='_self') { ?> selected<?php } ?>>本窗口</option>
                    <option value="_blank"<?php if($nav['target']=='_blank') { ?> selected<?php } ?>>新窗口</option>
                    <option value="_top"<?php if($nav['target']=='_top') { ?> selected<?php } ?>>顶层框架</option>
                </select>
            </div>
            <div class="nav-available"><input type="checkbox" name="navnew[<?php echo $nav['nid'];?>][available]" value="1"<?php if($nav['available']==1) { ?> checked<?php } ?>></div>
            <?php if($nav['type']=='custom') { ?><span class="delete"><a href="javascript:;" onclick="deleteNav(this,<?php echo $nav['nid'];?>)">删除</a></span><?php } ?>
            <input type="hidden" name="navnew[<?php echo $nav['nid'];?>][displayorder]" node="order" value="0">
        </div>
        <?php } } ?>    </div>
    <div class="nav-class">底部导航</div>
    <div id="navBottom">
    <?php if(is_array($navlist['bottom'])) { foreach($navlist['bottom'] as $nav) { ?>        <div class="nav-item" id="nav_item_<?php echo $nav['nid'];?>">
            <div class="nav-title"><input type="text" name="navnew[<?php echo $nav['nid'];?>][title]" class="text text100" value="<?php echo $nav['title'];?>"></div>
            <div class="nav-url"><input type="text" name="navnew[<?php echo $nav['nid'];?>][url]" class="text text200" value="<?php echo $nav['url'];?>"<?php if($nav['type']=='system') { ?> disabled<?php } ?>></div>
            <div class="nav-position">
            	<select name="navnew[<?php echo $nav['nid'];?>][position]">
            		<option value="top"<?php if($nav['position']=='top') { ?> selected<?php } ?>>顶部</option>
                    <option value="bottom"<?php if($nav['position']=='bottom') { ?> selected<?php } ?>>底部</option>
                </select>
            </div>
            <div class="nav-target">
            	<select name="navnew[<?php echo $nav['nid'];?>][target]">
                	<option value="_self"<?php if($nav['target']=='_self') { ?> selected<?php } ?>>本窗口</option>
                    <option value="_blank"<?php if($nav['target']=='_blank') { ?> selected<?php } ?>>新窗口</option>
                    <option value="_top"<?php if($nav['target']=='_top') { ?> selected<?php } ?>>顶层框架</option>
                </select>
            </div>
            <div class="nav-available"><input type="checkbox" name="navnew[<?php echo $nav['nid'];?>][available]" value="1"<?php if($nav['available']==1) { ?> checked<?php } ?>></div>
            <?php if($nav['type']=='custom') { ?><span class="delete"><a href="javascript:;" onclick="deleteNav(this,<?php echo $nav['nid'];?>)">删除</a></span><?php } ?>
            <input type="hidden" name="navnew[<?php echo $nav['nid'];?>][displayorder]" node="order" value="0">
        </div>
        <?php } } ?>    </div>
    <div id="newNavContent"></div>
    <div class="nav-class"><a href="javascript:;" onclick="addNav()"><i class="icon">&#xf0154;</i>添加导航</a></div>
    <div class="menu-header" style="border:0;"><input type="submit" class="button submit" value="保存菜单"></div>
    </form>
 </div>
 <div class="clearfix"></div>
<script type="text/template" id="tplNav">
<div class="nav-item">
	<div class="nav-title"><input type="text" name="newnav[nkey][title]" class="text text100"></div>
	<div class="nav-url"><input type="text" name="newnav[nkey][url]" class="text text200"></div>
	<div class="nav-position"><select name="newnav[nkey][position]"><option value="top">顶部</option><option value="bottom">底部</option></select></div>
	<div class="nav-target"><select name="newnav[nkey][target]"><option value="_self">本窗口</option><option value="_blank">新窗口</option><option value="_top">顶层框架</option></select></div>
	<div class="nav-available"><input type="checkbox" name="newnav[nkey][available]" value="1" checked></div>
	<input type="hidden" name="newnav[nkey][displayorder]" node="order" value="0">
</div>
</script>
<script type="text/javascript">
$("#newNavContent").sortable();
$("#navTop").sortable();
$("#navBottom").sortable();
$("#formNav").submit(function(){
	$("#formNav").find(".nav-item").each(function(index, element) {
        $(element).find("input[node=order]").val(index);
    });
	return true;
});
$("#addToNav").click(function(){
	$("#formcat").ajaxSubmit({
		url:'/?m=admin&c=nav&a=addcat&index='+$("#formNav").find(".nav-item").length,
		dataType:'json',
		success:function(json){
			if(json.state) window.location.reload();
		}
	});
});
var nkey = 1000;
function addNav(){
	nkey++;
	$("#newNavContent").append($("#tplNav").html().replace(/nkey/g,nkey));
}
function deleteNav(o,nid){
	if(!nid||!o) return false;
	if(confirm('你确定要删除吗?')){
		$.ajax({
			url:'/?m=admin&c=nav&a=delete&nid='+nid,
			dataType:"json",
			success: function(json){
				$("#nav_item_"+nid).slideUp('slow',function(){$(this).remove();});
			}
		});
	}
}
</script><?php include template('footer'); ?>