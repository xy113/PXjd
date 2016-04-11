/**
 * jQuery的Dialog插件。
 *
 * @param object content
 * @param object options 选项。
 * @return 
 */
function Dialog(content, options)
{
    var defaults = { // 默认值。 
        title:'标题',       // 标题文本，若不想显示title请通过CSS设置其display为none 
        showTitle:true,     // 是否显示标题栏。
		 showFooter:true,
        draggable:true,     // 是否移动 
        modal:true,         // 是否是模态对话框 
        center:true,        // 是否居中。 
        fixed:true,         // 是否跟随页面滚动。
        time:0,             // 自动关闭时间，为0表示不会自动关闭。 
        id:false,            // 对话框的id，若为false，则由系统自动产生一个唯一id。 
		width:500,
		callback:function(){}
    };
    var options = $.extend(defaults, options);
    options.id = options.id ? options.id : 'dialog-' + Dialog.__count; // 唯一ID
    var overlayId = options.id + '-overlay'; // 遮罩层ID
    var timeId = null;  // 自动关闭计时器 
    var isShow = false;
    var isIe = $.browser.msie;
    /* 对话框的布局及标题内容。*/
	var headHtml = !options.showTitle ? '' : '<div class="dialog-title" node="bar"><strong>'+options.title+'</strong><span class="icon close" node="close">&#xf00b3;</span></div>';
	var footerHtml = !options.showFooter ? '' : '<div class="dialog-footer"><div class="button submit" tabindex="1" node="submit">确定</div><div class="button cancel" tabindex="1" node="cancel">取消</div></div>';
	var dialog = $('<div id="' + options.id + '" class="ui-dialog">'+headHtml+'<div class="dialog-content" node="content"></div>'+footerHtml+'</div>').hide();
	$("body").append(dialog);
    /**
     * 重置对话框的位置。
     *
     * 主要是在需要居中的时候，每次加载完内容，都要重新定位
     *
     * @return void
     */
    var resetPos = function()
    {
        /* 是否需要居中定位，必需在已经知道了dialog元素大小的情况下，才能正确居中，也就是要先设置dialog的内容。 */
        if(options.center)
        {
            var left = ($(window).width() - dialog.width()) / 2;
            var top = ($(window).height() - dialog.height()) / 2;
			if(options.fixed){
				dialog.css({top:top,left:left});
			}else{
				dialog.css({top:top+$(document).scrollTop(),left:left+$(document).scrollLeft()});
			}
        }
    }
    /**
     * 初始化位置及一些事件函数。
     *
     * 其中的this表示Dialog对象而不是init函数。
     */
    var init = function()
    {
        /* 是否需要初始化背景遮罩层 */
        if(options.modal)
        {
            $("body").append('<div id="' + overlayId + '" class="ui-overlayer"></div>');
            $('#' + overlayId).css({'left':0, 'top':0,
                    'width':'100%',
                    'height':$(document).height(),
                    'z-index':++Dialog.__zindex,
                    'position':'absolute'})
                .hide();
        }
        dialog.css({'z-index':++Dialog.__zindex,width:options.width+'px', 'position':options.fixed ? 'fixed' : 'absolute'});
        /* 以下代码处理框体是否可以移动 */
        var mouse={x:0,y:0};
        function moveDialog(event)
        {
            var e = window.event || event;
            var top = parseInt(dialog.css('top')) + (e.clientY - mouse.y);
            var left = parseInt(dialog.css('left')) + (e.clientX - mouse.x);
            dialog.css({top:top,left:left});
            mouse.x = e.clientX;
            mouse.y = e.clientY;
        };
        dialog.find('[node=bar]').mousedown(function(event){
            if(!options.draggable){ return; }
            var e = window.event || event;
            mouse.x = e.clientX;
            mouse.y = e.clientY;
            $(document).bind('mousemove',moveDialog);
			$(this).css('cursor','move');
        });
        $(document).mouseup(function(event){
            $(document).unbind('mousemove', moveDialog);
			dialog.find('[node=bar]').css('cursor','default');
        });
        /* 绑定一些相关事件。 */
        dialog.find('[node=close]').bind('click', this.close);
		dialog.find('[node=cancel]').bind('click', this.close);
		dialog.find('[node=submit]').bind('click', options.callback);
        dialog.bind('mousedown', function(){dialog.css('z-index', ++Dialog.__zindex);});
        // 自动关闭 
        if(0 != options.time){timeId = setTimeout(this.close, options.time);}
    }
    /**
     * 设置对话框的内容。 
     *
     * @param string c 可以是HTML文本。
     * @return void
     */
    this.setContent = function(c){
		dialog.find('[node=content]').html(c);
	}
    /**
     * 显示对话框
     */
    this.show = function()
    {
        if(undefined != options.beforeShow){options.beforeShow();}
        /* 是否显示背景遮罩层 */
        if(options.modal)$('#' + overlayId).show();
        dialog.show(0, function(){
            if(undefined != options.afterShow){options.afterShow();}
            isShow = true;
        });
        // 自动关闭 
        if(0 != options.time){timeId = setTimeout(this.close, options.time);}
        resetPos();
    }
    /**
     * 隐藏对话框。但并不取消窗口内容。
     */
    this.hide = function()
    {
        if(!isShow){return;}
        if(undefined != options.beforeHide){options.beforeHide();}
        dialog.hide(0,function(){
            if(undefined != options.afterHide){options.afterHide();}
        });
        if(options.modal)
        {$('#' + overlayId).hide();}
        isShow = false;
    }
    /**
     * 关闭对话框 
     *
     * @return void
     */
    this.close = function()
    {
        if(undefined != options.beforeClose){options.beforeClose();}
        dialog.hide(0, function(){
            $(this).remove();
            isShow = false;
            if(undefined != options.afterClose){options.afterClose();}
        });
        if(options.modal)
        {   
			$('#'+overlayId).hide(0, function(){$(this).remove();}); 
		}
        clearTimeout(timeId);
    }
    init.call(this);
    this.setContent(content);
    Dialog.__count++;
    Dialog.__zindex++;
}
Dialog.__zindex = 9999;
Dialog.__count = 1;
function dialog(content,options)
{
	var dlg = new Dialog(content, options);
	dlg.show();
	return dlg;
}