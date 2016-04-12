// JavaScript Document
//元素居中
(function($){
	$.fn.extend({
		//层居中
		center: function (settings) {
			settings = $.extend({'fixed':true},settings);
			return this.each(function() {
				var top = ($(window).height() - $(this).height()) / 2;
				var left = ($(window).width() - $(this).width()) / 2;
				if(settings.fixed){
					$(this).css({position:'fixed', margin:0, top:top,left:left});
				}else{
					$(this).css({position:'absolute', margin:0, top:top+$(document).scrollTop(),left:left+$(document).scrollLeft()});
				}			
			});
		},
		//层可拖动
		dragable:function(options){
			options = $.extend({},options);
			var mouse = {x:0,y:0};
			var div = $(this);
			var _this = this;
			div.css({'position':'absolute','z-index':1000});
			_this.moveDiv = function(event){
				var e = window.event || event;
				var position = div.offset();
				var top = position.top + (e.clientY - mouse.y);
				var left = position.left + (e.clientX - mouse.x);
				div.css({top:top,left:left});
				mouse.x = e.clientX;
				mouse.y = e.clientY;
			}
			var handle = options.handle ? $(options.handle) : div;
			handle.mousedown(function(event){
				var e = window.event || event;
				mouse.x = e.clientX;
				mouse.y = e.clientY;
				$(document).bind('mousemove',_this.moveDiv);
			});
			$(document).mouseup(function(){
				$(document).unbind('mousemove',_this.moveDiv);
			});
		},
		insertContent: function(myValue, t) {
            var $t = $(this)[0];
            if (document.selection) { //ie
                this.focus();
                var sel = document.selection.createRange();
                sel.text = myValue;
                sel.moveStart('character', -l);
                var wee = sel.text.length;
                if (arguments.length == 2) {
                    var l = $t.value.length;
                    sel.moveEnd("character", wee + t);
                    t <= 0 ? sel.moveStart("character", wee - 2 * t - myValue.length) : sel.moveStart("character", wee - t - myValue.length);
                    sel.select();
                }
            } else if ($t.selectionStart || $t.selectionStart == '0') {
                var startPos = $t.selectionStart;
                var endPos = $t.selectionEnd;
                var scrollTop = $t.scrollTop;
                $t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);
                this.focus();
                $t.selectionStart = startPos + myValue.length;
                $t.selectionEnd = startPos + myValue.length;
                $t.scrollTop = scrollTop;
                if (arguments.length == 2) {
                    $t.setSelectionRange(startPos - t, $t.selectionEnd + t);
                    this.focus();
                }
            }
            else {
                this.value += myValue;
                this.focus();
            }
        }
	});
})(jQuery);
var DSXCMS = {
	mb_cutstr : function(str, maxlen, dot) {
		var len = 0;
		var ret = '';
		var dot = !dot ? '...' : '';
		maxlen = maxlen - dot.length;
		for(var i = 0; i < str.length; i++) {
			len += str.charCodeAt(i) < 0 || str.charCodeAt(i) > 255 ? (charset == 'utf-8' ? 3 : 2) : 1;
			if(len > maxlen) {
				ret += dot;
				break;
			}
			ret += str.substr(i, 1);
		}
		return ret;
	},
	IsURL : function(url){ 
		return /^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\:+!]*([^<>])*$/.test(url);
	},
	IsEmail : function(email){
		return /^[-._A-Za-z0-9]+@([A-Za-z0-9]+\.)+[A-Za-z]{2,3}$/.test(email);
	},
	IsMobile : function(num){
		return /^1[3|5|8]\d{9}$/.test(num);
	},
	IsPassword : function(str){
		return /^.{6,20}$/.test(str);
	},
	paramToJSON : function(str){
		if(!str) return;
		var json = {};
		var arr = str.split('&');
		$.each(arr,function(i,o){
			var arr2 = o.split('=');
			json[arr2[0]] = arr2[1] ? arr2[1] : '';
		});
		return json;
	},
	randomString : function (len) {
	　　len = len || 32;
	　　var $chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';    /****默认去掉了容易混淆的字符oOLl,9gq,Vv,Uu,I1****/
	　　var maxPos = $chars.length;
	　　var pwd = '';
	　　for (i = 0; i < len; i++) {
	　　　　pwd += $chars.charAt(Math.floor(Math.random() * maxPos));
	　　}
	　　return pwd;
	},
	openDiy : function(){
		if(location.href.indexOf('?') != -1){
			if(location.href.indexOf('&') != -1){
				location.href = location.href+'&diy=yes';
			}else{
				location.href = location.href+'diy=yes';
			}
		}else{
			location.href = location.href+'?diy=yes';
		}
	},
	getQueryString : function(item){
		var svalue = location.search.match(new RegExp("[\?\&]" + item + "=([^\&]*)(\&?)","i"));
		return svalue ? svalue[1] : svalue;
	},
	checkAll : function(o,input){return $("[name='"+input+"']").attr('checked',$(o).is(":checked"));},
	showDistrict:function(fid, obj, defaultval, tips){
		if(!tips) tips = '请选择';
		var optionhtml = '<option value="">'+tips+'</option>';
		$.ajax({
			url:'/?m=common&c=district&a=fetchdistrict&fid='+fid,
			dataType:'json',
			success: function(json){
				if(json.errno == 0){
					for(var k in json.data){
						var optionitem = json.data[k];
						optionhtml+= '<option idvalue="'+optionitem.id+'" value="'+
						optionitem.name+'"'+((optionitem.name == defaultval) ? '  selected="selected"' : '')+'>'+optionitem.name+'</option>';
						
					}
					$(obj).html(optionhtml).change();
				}
			}
		});
	}
}
var DSXUI = {
	success : function(content,callback,error){
		callback = callback||function(){}
		var div = error ? '<div class="ui-error"><span class="icon">&#xf00b3;</span>'+content+'</div>' : '<div class="ui-success"><span class="icon">&#xf00b2;</span>'+content+'</div>';
		var el = $('<div/>').addClass("ui-message-box").html(div).appendTo(window.top.document.body)
		.fadeIn('fast').center();
		//$(window.top.document);
		setTimeout(function(){el.remove();callback();},1500);
	},
	error : function(content,callback){
		DSXUI.success(content,callback,1);
	},
	confirm : function(o,text,callback){
		text = text || '确定要做此项操作吗？';
		$('#ui-confirm-box').remove();
		var dlg = $('<div id="ui-confirm-box" class="ui-confirm-box">'+
		'<dl><dt class="txt">'+text+'</dt><dd><span class="button submit" tabindex="1">确定</span>'+
		'<span class="button cancel" tabindex="1">取消</span></dd></dl></div>').appendTo("body");
		var position = $(o).offset();
		dlg.css({"top":(position.top+25)+"px","display":"none",'position':'absolute'})
		.bind('mouseleave',function(){$(this).remove();}).fadeIn("fast");
		if(position.left<($(document).width()/2)){
			dlg.css({'left':position.left+'px'});
		}else{
			dlg.css({'left':(position.left-dlg.width()+30)+'px'});
		}
		dlg.find(".submit").one('click',function(){
			callback();
			dlg.remove();
		});
		dlg.find(".cancel").click(function(){dlg.remove();});
	},
	showloading : function(text){
		text = text||'正在加载数据....';
		var overlayer = $("<div/>").addClass("ui-overlayer").css({'height':$(window.top.document).height()}).appendTo(window.top.document.body);
		var loading = $('<div class="ui-loading-box"><span class="ico"></span>'+text+'</div>').center().appendTo(window.top.document.body);
		this.close = function(){
			overlayer.remove();
			loading.remove();
		}
		return this;
	},
	dialogConfirm : function(settings){
		settings = $.extend({
			title:'删除确认',
			width:300,
			text:'确定要删除此项目吗？',
			callback:function(){}
		},settings);
		var dlg = dialog('<div class="content-confirm">'+settings.text+'</div>',
		{title:settings.title,width:settings.width,callback:settings.callback});
		return dlg;
	},
	showUpload:function(formdata,settings){
		settings = $.extend({
			title:'上传图片',
			width:300,
			callback:function(c){}
		},settings);
		//data = $.extend({},data);
		var dlg = dialog('<form id="ui-dialog-upload" style="margin:20px 0;" enctype="multipart/form-data" method="POST"><input type="file" name="filedata" style="width:200px;"></form>',
		{title:settings.title,width:settings.width,callback:function(){
			$("#ui-dialog-upload").ajaxSubmit({
				url:'/?',
				dataType:'json',
				data:formdata,
				success:function(json){
					if(json.errno == 0){
						dlg.close();
						settings.callback(json);
					}
				}
			});
		}});
		return dlg;
	},
	
}