<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header_common'); ?><script src="/static/js/jquery.SuperSlide.2.1.1.js" type="text/javascript"></script>
<div class="area" id="homepage" style="margin-top:0;">
	<div style="margin:10px auto;"><img src="/static/images/ad.jpg" width="980" style="display:block;"></div><?php $articlelist=articlelist(array('num'=>5,'isimage'=>1)); ?><div class="slideBox">
    	<div class="hd">
          <ul><li>1</li><li>2</li><li>3</li><li>4</li><li>5</li></ul>
      </div>
    	<ul class="bd">
        <?php if(is_array($articlelist)) { foreach($articlelist as $list) { ?>           <li>
           	<div><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>" target="_blank"><img src="<?php echo $list['pic'];?>"></a></div>
            	<p><?php echo $list['summary'];?></p>
           </li>
           <?php } } ?>        </ul>
        <a class="prev" href="javascript:void(0)"></a>
	    <a class="next" href="javascript:void(0)"></a>
    </div>
    <script type="text/javascript">
	jQuery(".slideBox").slide({mainCell:".bd",autoPlay:true,delayTime:1000});
	function submitSign(data){
		data = data || {};
		$.ajax({
			url:'/?m=post&c=index&a=sign',
			dataType:"json",
			data:data,
			success: function(json){
				if(json.errno == 0){
					alert('签到成功\n本次签到时间:'+json.data.time+'\n签到位置:'+json.data.location);
				}else {
					alert('你今天已经签过到了');
				}
			}
		});
	}
	function Sign(){
		var uid = <?php echo $G['uid'];?>;
		if(uid){
			if (navigator.geolocation){ 
				navigator.geolocation.getCurrentPosition(function(position){
					submitSign({logitude:position.coords.longitude,latitude:position.coords.latitude});
				},function(error){
					submitSign(); 
				}); 
			}else{ 
				submitSign(); 
			}
		}else {
			window.location = '/?m=member&c=login';
		}
	}
	</script>
    <div class="focus">
    	<h3>今日聚焦</h3>
       <?php $articlelist=articlelist(array('num'=>10)); ?>       <ul>
       <?php if(is_array($articlelist)) { foreach($articlelist as $list) { ?>            <li><span<?php if($list['orderno']<4) { ?> class="red"<?php } ?>><?php echo $list['orderno'];?></span><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>" target="_blank"><?php echo $list['title'];?></a></li>
           <?php } } ?>       </ul>
       <div class="sign"><a href="/?m=exam">参与竞赛答题</a></div>
    </div>
    <div class="blank"></div>
    <div class="titlediv">
    	<span class="more"><a href="/?m=post&c=list&catid=110">更多</a></span>
    	<strong>图片新闻</strong>
    </div>
    <div class="marquee">
    <?php $articlelist=articlelist(array('num'=>20,'isimage'=>1)); ?>        <div class="hd">
    	<ul>
        <?php if(is_array($articlelist)) { foreach($articlelist as $list) { ?>           <li>
           	<div class="pic"><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>" target="_blank"><img src="<?php echo $list['pic'];?>"></a></div>
            	<div class="title"><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>" target="_blank"><?php echo $list['title'];?></a></div>
           </li>
           <?php } } ?>        </ul>
        </div>
    </div>
    <script type="text/javascript">
	jQuery(".marquee").slide({mainCell:".hd ul",autoPlay:true,effect:"leftMarquee",vis:5,interTime:50});
	</script>
    <div class="blank"></div>
    <div class="left-frame">
    	 <div class="content">
        	<div class="titlediv"><span class="more"><a href="/?m=post&c=list&catid=2">更多</a></span><strong>盘县关注</strong></div>
           <?php $articlelist=articlelist(array('num'=>8,'catid'=>2)); ?>           <ul>
           <?php if(is_array($articlelist)) { foreach($articlelist as $list) { ?>            <?php $list['pubdate']=@date('m-d',$list['dateline']); ?>            	<li><span><?php echo $list['pubdate'];?></span><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>" target="_blank"><?php echo $list['title'];?></a></li>
            	<?php } } ?>           </ul>
        </div>
        
        <div class="content content2">
        	<div class="titlediv"><span class="more"><a href="/?m=post&c=list&catid=3">更多</a></span><strong>缉毒战报</strong></div>
           <?php $articlelist=articlelist(array('num'=>8,'catid'=>3)); ?>           <ul>
           <?php if(is_array($articlelist)) { foreach($articlelist as $list) { ?>            <?php $list['pubdate']=@date('m-d',$list['dateline']); ?>            	<li><span><?php echo $list['pubdate'];?></span><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>" target="_blank"><?php echo $list['title'];?></a></li>
            	<?php } } ?>           </ul>
        </div>
    	
        <div class="content">
        	<div class="titlediv"><span class="more"><a href="/?m=post&c=list&catid=4">更多</a></span><strong>媒体聚焦</strong></div>
           <?php $articlelist=articlelist(array('num'=>8,'catid'=>4)); ?>           <ul>
           <?php if(is_array($articlelist)) { foreach($articlelist as $list) { ?>            <?php $list['pubdate']=@date('m-d',$list['dateline']); ?>            	<li><span><?php echo $list['pubdate'];?></span><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>" target="_blank"><?php echo $list['title'];?></a></li>
            	<?php } } ?>           </ul>
        </div>
        
        <div class="content content2">
        	<div class="titlediv"><span class="more"><a href="/?m=post&c=list&catid=5">更多</a></span><strong>乡镇动态</strong></div>
           <?php $articlelist=articlelist(array('num'=>8,'catid'=>5)); ?>           <ul>
           <?php if(is_array($articlelist)) { foreach($articlelist as $list) { ?>            <?php $list['pubdate']=@date('m-d',$list['dateline']); ?>            	<li><span><?php echo $list['pubdate'];?></span><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>" target="_blank"><?php echo $list['title'];?></a></li>
            	<?php } } ?>           </ul>
        </div>
        <div class="banner">
        	<embed width="100%" height="100" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" quality="high" src="/static/swf/banner.swf">
        </div>
        
        <div class="content">
        	<div class="titlediv"><span class="more"><a href="/?m=post&c=list&catid=6">更多</a></span><strong>戒毒常识</strong></div>
           <?php $articlelist=articlelist(array('num'=>8,'catid'=>6)); ?>           <ul>
           <?php if(is_array($articlelist)) { foreach($articlelist as $list) { ?>            <?php $list['pubdate']=@date('m-d',$list['dateline']); ?>            	<li><span><?php echo $list['pubdate'];?></span><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>" target="_blank"><?php echo $list['title'];?></a></li>
            	<?php } } ?>           </ul>
        </div>
        
        <div class="content content2">
        	<div class="titlediv"><span class="more"><a href="/?m=post&c=list&catid=7">更多</a></span><strong>法制天地</strong></div>
           <?php $articlelist=articlelist(array('num'=>8,'catid'=>7)); ?>           <ul>
           <?php if(is_array($articlelist)) { foreach($articlelist as $list) { ?>            <?php $list['pubdate']=@date('m-d',$list['dateline']); ?>            	<li><span><?php echo $list['pubdate'];?></span><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>" target="_blank"><?php echo $list['title'];?></a></li>
            	<?php } } ?>           </ul>
        </div>
    	
        <div class="content">
        	<div class="titlediv"><span class="more"><a href="/?m=post&c=list&catid=8">更多</a></span><strong>禁毒视频</strong></div>
           <?php $articlelist=articlelist(array('num'=>8,'catid'=>8)); ?>           <ul>
           <?php if(is_array($articlelist)) { foreach($articlelist as $list) { ?>            <?php $list['pubdate']=@date('m-d',$list['dateline']); ?>            	<li><span><?php echo $list['pubdate'];?></span><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>" target="_blank"><?php echo $list['title'];?></a></li>
            	<?php } } ?>           </ul>
        </div>
        
        <div class="content content2">
        	<div class="titlediv"><span class="more"><a href="/?m=post&c=list&catid=9">更多</a></span><strong>毒品知识</strong></div>
           <?php $articlelist=articlelist(array('num'=>8,'catid'=>9)); ?>           <ul>
           <?php if(is_array($articlelist)) { foreach($articlelist as $list) { ?>            <?php $list['pubdate']=@date('m-d',$list['dateline']); ?>            	<li><span><?php echo $list['pubdate'];?></span><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>" target="_blank"><?php echo $list['title'];?></a></li>
            	<?php } } ?>           </ul>
        </div>      
    </div>
    
    <div class="right-frame">
    	<div class="qrcode"><img src="/static/images/weixin.jpg"><h3>扫一扫上面的二维码在微信关注我们</h3></div>
    	<div class="blank"></div>
        <div class="titlediv"><span class="more"><a href="/?m=post&c=list&catid=10">更多</a></span><strong>禁毒宣传片</strong></div>
       <div class="videobox">
       		<embed width="230" height="180" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" autostart="true" quality="high" src="http://player.youku.com/player.php/sid/XNjM0NDI0Mjc2/v.swf">
       </div>
    	<div class="titlediv"><span class="more"><a href="/?m=post&c=list&catid=10">更多</a></span><strong>预防教育</strong></div>
       <?php $articlelist=articlelist(array('num'=>8,'catid'=>10)); ?>       <ul class="list">
        <?php if(is_array($articlelist)) { foreach($articlelist as $list) { ?>        <li><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>" target="_blank"><?php echo $list['title'];?></a></li>
        <?php } } ?>       </ul>
       <div class="titlediv"><span class="more"><a href="/?m=post&c=list&catid=11">更多</a></span><strong>推荐阅读</strong></div>
       <?php $articlelist=articlelist(array('num'=>8,'catid'=>11)); ?>       <ul class="list">
        <?php if(is_array($articlelist)) { foreach($articlelist as $list) { ?>        <li><a href="/?m=post&c=detail&id=<?php echo $list['id'];?>" target="_blank"><?php echo $list['title'];?></a></li>
        <?php } } ?>       </ul>
    </div>
    <div class="blank"></div>
    <div class="titlediv"><strong>友情链接</strong></div>
    <div class="flinklist">
    <?php $linklist=cache('link'); ?>       <?php if(is_array($linklist)) { foreach($linklist as $list) { ?>       <?php if($list['classid']>0) { ?>
       <a href="<?php echo $list['url'];?>" target="_blank"><?php echo $list['title'];?></a>
       <?php } ?>
       <?php } } ?>    </div>
</div><?php include template('footer_common'); ?>