<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><h2>区域管理</h2>
<h2>
<form method="get" name="formsearch">
	<select name="province" onchange="this.form.city.value=0;this.form.county.value=0;refreshdistrict()">
    	<option>--省份--</option>
        <?php if(is_array($provincelist)) { foreach($provincelist as $pro) { ?>        <option value="<?php echo $pro['id'];?>"<?php if($pro['id']==$province) { ?> selected="selected"<?php } ?>><?php echo $pro['name'];?></option>
        <?php } } ?>    </select>
    <select name="city" onchange="this.form.county.value='';refreshdistrict()">
    	<option value="0">--城市--</option>
        <?php if(is_array($citylist)) { foreach($citylist as $ct) { ?>        <option value="<?php echo $ct['id'];?>"<?php if($ct['id']==$city) { ?> selected="selected"<?php } ?>><?php echo $ct['name'];?></option>
        <?php } } ?>    </select>
    <select name="county" onchange="refreshdistrict()">
    	<option value="0">--州县--</option>
        <?php if(is_array($countylist)) { foreach($countylist as $cot) { ?>        <option value="<?php echo $cot['id'];?>"<?php if($cot['id']==$county) { ?> selected="selected"<?php } ?>><?php echo $cot['name'];?></option>
        <?php } } ?>    </select>
</form>
</h2>
<form method="post" action="">
    <input type="hidden" name="formsubmit" value="yes" />
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
    <thead>
    	<th width="30"><input type="checkbox" class="checkbox" onclick="DSXCMS.checkAll(this,'delete[]');" /></th>
        <th>名称</th>
    </thead>
    <tbody id="tbcontent">
    <?php if(is_array($districtlist)) { foreach($districtlist as $dst) { ?>    <tr class="white">
      <td><input type="checkbox" name="delete[]" value="<?php echo $dst['id'];?>" /></td>
      <td><input type="text" class="text text200" name="name[<?php echo $dst['id'];?>]" value="<?php echo $dst['name'];?>" maxlength="10"></td>
    </tr>
    <?php } } ?>    </tbody>
    <tfoot>
    <tr>
        <td colspan="2"><a href="javascript:;" id="newtag"><i class="icon">&#xf0154;</i>添加区域</a></td>
    </tr>
    <tr>
        <td colspan="2">提示:选中复选框提交后选中项将被删除</td>
    </tr>
    <tr>
        <td colspan="2">
            <span class="pagebox"><?php echo $pagelink;?></span>
            <input type="submit" class="button" value="提交" />　
            <input type="button" class="button" value="刷新" onclick="window.location.reload()" />
        </td>
    </tr>
    </tfoot>
  </table>
 </form>
<script type="text/template" id="tplDistrict">
<tr>
	<td><input type="hidden" name="newfid[]" value="<?php echo $fid;?>" /></td>
	<td><input type="text" class="text text200" name="newname[]" value=""></td>
</tr>
</script>
<script type="text/javascript">
$("#newtag").click(function(){
	$("#tbcontent").append($("#tplDistrict").html());
});

function refreshdistrict(){
	var form = $("form[name=formsearch]");
	var province = form.find("[name=province]").val();
	var city = form.find("[name=city]").val();
	var county = form.find("[name=county]").val();
	window.location = '/?m=admin&c=district&province='+province+'&city='+city+'&county='+county;
}
//$("form[name=formsearch]").find("select").change(function(){
//	$("form[name=formsearch]").submit();
//});
</script><?php include template('footer'); ?>