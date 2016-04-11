<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?>        <div class="newpost-content" id="p-content-subtitle">
        	<h3 class="content-sub-title">别名</h3>
			<div class="content-body"><input type="text" class="input-text" name="newpost[alias]" value="<?php echo $article['alias'];?>"></div>
        </div>
        <div class="newpost-content" id="p-content-summary">
        	<h3 class="content-sub-title">摘要</h3>
			<div class="content-body"><textarea class="textarea-summary" name="newpost[summary]"><?php echo $article['summary'];?></textarea></div>
        </div>
     
    </div>
    <div class="newpost-attribute">
        <!--图像-->
        <div class="newpost-content" id="p-content-image">
        	<h3 class="content-sub-title">图像</h3>
            <div class="content-body">
                <input type="hidden" name="newpost[pic]" node="pic" value="<?php echo $article['pic'];?>">
                <?php if($G['a']=='edit' && $pic) { ?>
                <div id="image-view">
                    <div class="image-preview"><img src="<?php echo $pic;?>" id="imagePreview"></div>
                    <div class="action-item"><a href="javascript:;" class="add-new" id="remove-image"><span class="icon">&#xf0153;</span>移除图像</a></div>
                </div>
                <div class="action-item" id="upload-view" style="display:none;"><a href="javascript:;" class="add-new" id="upload-image"><span class="icon">&#xf0154;</span>添加图像</a></div>
                <?php } else { ?>
                <div id="image-view" style="display:none;">
                    <div class="image-preview"><img src="" id="imagePreview"></div>
                    <div class="action-item"><a href="javascript:;" class="add-new" id="remove-image"><span class="icon">&#xf0153;</span>移除图像</a></div>
                </div>
                <div class="action-item" id="upload-view"><a href="javascript:;" class="add-new" id="upload-image"><span class="icon">&#xf0154;</span>添加图像</a></div>
                <?php } ?>
            </div>
        </div>
        <div class="newpost-content" id="p-content-category">
        	 <h3 class="content-sub-title">目录分类</h3>
            <div class="content-body">
                <select name="newpost[catid]" class="select" node="catid">
                    <?php echo $categoryoptions;?>
                </select>
            </div>
        </div>
        <div class="newpost-content" id="p-content-publish">
        	 <h3 class="content-sub-title">发布</h3>
            <div class="content-body">
            	 <?php if($G['a']=='edit') { ?>
            	 <span class="input-button input-publish" tabindex="1" id="publish">更新</span>
               <?php } else { ?>
               <span class="input-button input-publish" tabindex="1" id="publish">发布</span>
               <?php } ?>
                <!--<span class="input-button" tabindex="1" onclick="preView()">预览</span>-->
            </div>
        </div>
        
        <div class="newpost-content" id="p-content-tag">
        	<h3 class="content-sub-title">标签</h3>
            <div class="content-body">
                <div id="tagLabel" class="tagLabel"></div>
                <input type="text" class="input-text input-text2" node="newtag">
                <span class="input-button input-button-small" tabindex="1" id="button-addtag">添加</span>
                <div class="action-item"><a href="javascript:;" class="add-new" onclick="$('#tagSelectLabel').toggle()">从常用标签中选择</a></div>
                <div id="tagSelectLabel" style="display:none;">
                    <?php if(is_array($tags)) { foreach($tags as $k => $tag) { ?>                    <a href="javascript:;" class="tagitem" title="<?php echo $tag['tag'];?>"><span><?php echo $tag['tag'];?></span></a>
                    <?php } } ?>                </div>
            </div>
        </div>
        
        <div class="newpost-content" id="p-content-comment">
        	<h3 class="content-sub-title">评论设置</h3>
            <div class="content-body">
                <p><input type="checkbox" value="-1" name="newpost[allowcomment]"> 禁止评论</p>
            </div>
        </div>
        
    </div>
    <div class="clearfix"></div>
    </form>
<script type="text/template" id="tplUploadImage">
<div class="upload-image">
	<div class="title"><span class="close" title="关闭">×</span>上传图像</div>
	<div class="content">
		<div class="preview"><img id="uploadedimage" title="点击插入图片"></div>
		<div class="loading"><img src="/static/images/common/loading32.gif" border="0">正在上传图片...</div>
		<form method="post" enctype="multipart/form-data" id="form-upload-image" action="/?m=common&c=upload&a=uploadimage">
			<div class="upload-image-button"><span class="icon">&#xf0024;</span>上传图片<input type="file" name="filedata" class="file"></div>
		</form>
	</div>
</div>
</script>
<script type="text/javascript">
(function(){
	$("#publish").click(function(){
		var form = $("form[name=newpostform]");
		var title = form.find("input[node=title]").val();
		var catid = form.find("select[node=catid]").val();
		if(!title){
			DSXUI.error('亲，文章标题不能留空哦');
			return false;
		}
		if(!(catid>0)){
			DSXUI.error('亲，请选择一个目录分类');
			return false;
		}
		form.submit();
	});
	$("#upload-image").die().live('click',function(){
		var _this = this;
		var layer = $("<div/>").addClass('ui-overlayer').css({'height':$(document).height()}).appendTo('body');
		var box = $($("#tplUploadImage").html()).appendTo("body");
		box.center().draggable({handle:'.title',cursor:'move'});
		box.find(".close").bind('click',function(){_this.close();});
		box.find(".file").change(function(){
			$("#form-upload-image").ajaxSubmit({
				beforeSend:function(){
					box.find(".loading").show();
					$("#form-upload-image").hide();
				},
				dataType:'json',
				success:function(json){
					if(json.errno == 0){
						$("#uploadedimage").attr('src',json.data.url).die().live('click',function(){
							$("#imagePreview").attr("src",json.data.url);
							$("input[node=pic]").val(json.data.pic);
							$("#image-view").show();
							$("#upload-view").hide();
							_this.close();
						});
						box.find(".preview").show();
						box.find(".loading").hide();
						$("#form-upload-image").hide();
					}else{
					}
				}
			});
		});
		_this.close = function(){
			box.remove();
			layer.remove();
		}
	});
	$("#remove-image").die().live('click',function(){
		$("input[node=image]").val('');
		$("#image-view").hide();
		$("#upload-view").show();
	});
	$("#tagLabel>a>i").die().live('click',function(){
		$(this).parent().remove();
	});
	$("#button-addtag").die().live('click',function(){
		var tag = $("[node=newtag]").val();
		if(!tag) return false;
		if($("#tagLabel>.tagitem").length>=5){
			DSXUI.error('最多只能添加5个标签');
		}
		if(!(/^[a-zA-Z0-9_\u4e00-\u9fa5]+$/i).test(tag)){
			DSXUI.error('标签格式错误，只能输入英文、数字、下划线和中文');
		}else{
			$.ajax({
				url:'/?mod=post&ac=misc&op=addtag&tag='+tag,
				dataType:"json",
				success: function(json){
					if(json.state){
						$("#tagLabel").append('<a href="javascript:;" class="tagitem" title="'+tag+'">'+
						'<input type="hidden" value="'+tag+'" name="newpost[tags][]"><span>'+tag+'</span><i>×</i></a>');
					}
				}	
			});
		}
	});
	$("#tagSelectLabel>.tagitem").die().live('click',function(){
		var tag = $(this).attr("title");
		if($("#tagLabel>.tagitem").length>=5){
			DSXUI.error('最多只能添加5个标签');
			return false;
		}
		if($("#tagLabel").find("a[title="+tag+"]").length>0){
			return false;
		}
		$("#tagLabel").append('<a href="javascript:;" class="tagitem" title="'+tag+'">'+
		'<input type="hidden" value="'+tag+'" name="newpost[tags][]"><span>'+tag+'</span><i>×</i></a>');
	});
})();
</script><?php include template('footer'); ?>