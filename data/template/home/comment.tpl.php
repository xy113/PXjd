<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header_home'); ?><div id="mainFrame">
	<form method="post" autocomplete="off">
    <input type="hidden" name="formsubmit" value="yes">
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable goodslist">
      <thead>
      <tr>
        <th width="30"><input type="checkbox" class="checkbox"></th>
        <th>评论内容</th>
        <th width="110">评论时间</th>
      </tr>
      </thead>
      <tbody>
      <?php if(is_array($commentlist)) { foreach($commentlist as $list) { ?>      <tr>
        <td><input type="checkbox" value="<?php echo $list['cid'];?>" name="cid[]"></td>
        <td><?php echo $list['message'];?></td>
        <td><?php echo $list['dateline'];?></td>
      </tr>
      <?php } } ?>      </tbody>
      <tfoot>
      <tr>
        <td colspan="8" style="padding:15px 10px;">
        	<div class="pages"><?php echo $pages;?></div>
           <input type="submit" class="button submit" value="删除">
        </td>
      </tr>
      </tfoot>
    </table>
    </form>
</div><?php include template('footer_home'); ?>