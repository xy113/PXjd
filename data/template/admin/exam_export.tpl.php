<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>
导出数据
<a class="addnew" href="/?m=admin&c=exam&a=record&paperid=<?php echo $paperid;?>">返回列表</a>
</h2>
<div class="wrapper">
<form method="get" action="/?">
<input type="hidden" name="formsubmit" value="yes">
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<input type="hidden" name="m" value="<?php echo $G['m'];?>">
<input type="hidden" name="c" value="<?php echo $G['c'];?>">
<input type="hidden" name="a" value="<?php echo $G['a'];?>">
<input type="hidden" name="paperid" value="<?php echo $paperid;?>">
<table class="formtable" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody id="basic">
  <tr>
    <td class="bold">所在单位：</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input name="company" class="text" value="" type="text"></td>
    <td></td>
  </tr>
  <tr>
    <td class="bold">所在地：</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
    <select class="input-select dist" id="province" name="province">
            <option value="">请选择</option>
          </select>
          <select class="input-select dist" id="city" name="city">
              <option value="">请选择</option>
          </select>
          <select class="input-select dist" id="county" name="county">
              <option value="">请选择</option>
          </select>
          <select class="input-select dist" id="town" name="town">
              <option value="">请选择</option>
          </select>
    </td>
    <td></td>
  </tr>
  <tr>
    <td class="bold">答题用时：</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input name="spenttime1" class="text text100" value="" type="text"> - <input name="spenttime2" class="text text100" value="" type="text"></td>
    <td>单位分钟</td>
  </tr>
  <tr>
    <td class="bold">成绩：</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input name="score1" class="text text100" value="" type="text"> - <input name="score2" class="text text100" value="" type="text"></td>
    <td></td>
  </tr>
  <tr>
    <td class="bold">排序按：</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
    	<input name="orderby" class="text" value="submittime" type="radio"> 交卷时间
       <input name="orderby" class="text" value="spenttime" type="radio"> 考试用时
       <input name="orderby" class="text" value="score" type="radio" checked> 考试成绩
    </td>
    <td></td>
  </tr>
  <tr>
    <td class="bold">排序方式：</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
    	<input name="asc" class="text" value="asc" type="radio"> 升序
       <input name="asc" class="text" value="desc" type="radio" checked> 降序
    </td>
    <td></td>
  </tr>
  </tbody>
  <tfoot>
  	<?php if($lastexport) { ?>
    <tr class="bottom">
      <td colspan="2">上次导出时间为:<?php echo $lastexport;?>,你可以点击此处直接<a href="/?m=<?php echo $G['m'];?>&c=<?php echo $G['c'];?>&a=getxml&paperid=<?php echo $paperid;?>" target="_blank">下载表格</a></td>
    </tr>
    <?php } ?>
    <tr class="bottom">
      <td colspan="2"><input name="button-submit" class="button submit" value="导出EXCEL" type="submit"></td>
    </tr>
  </tfoot>
</table>
</form>
</div>
<script type="text/javascript">
DSXCMS.showDistrict(0,'#province','贵州省','请选择省份');
$("#province").change(function(){
	var fid = $(this).find("option:selected").attr('idvalue');
	//if(!fid) return;
	DSXCMS.showDistrict(fid,'#city','六盘水市','请选择城市');
});

$("#city").change(function(){
	var fid = $(this).find("option:selected").attr('idvalue');
	//if(!fid) return;
	DSXCMS.showDistrict(fid,'#county','盘县','请选择区县州');
});

$("#county").change(function(){
	var fid = $(this).find("option:selected").attr('idvalue');
	//if(!fid) return;
	DSXCMS.showDistrict(fid,'#town','','请选择乡镇');
});
</script><?php include template('footer'); ?>