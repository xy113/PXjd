<?php
namespace Core;
abstract class Controller{
	protected $uid = 0;
	protected $username  = '';
	protected $email     = '';
	protected $mobile    = '';
	protected $account = array();
	protected $group   = array();
	protected $setting = array();
	protected $config  = array();
	
	function __construct(){
		$this->uid      = $GLOBALS['G']['uid'];
		$this->username = $GLOBALS['G']['username'];
		$this->account  = $GLOBALS['G']['account'];
		$this->group    = $GLOBALS['G']['group'];
		$this->setting  = $GLOBALS['G']['setting'];
		$this->config   = $GLOBALS['G']['config'];
		ob_start();
	}
	
	public function t($tableName) {
		$model = new Model();
		return $model->db->t($tableName);
	}
	
	public function m($tableName) {
		return M($tableName);
	}
	
	/**
	 * 验证图形验证码
	 * @param string $code
	 */
	public function checkCaptchacode($code){
		$code = strtolower($code);
		if (!$code || ($code != cookie('captchacode'))){
			$this->showError('captchacode_verify_failed');
		}else {
			cookie('captchacode', null);
			return TRUE;
		}
	}
	
	/**
	 * 判断是否表单提交
	 */
	public function checkFormSubmit(){
		if ($_GET['formsubmit'] !== 'yes'){
			return false;
		}
		
		if ($_GET['formhash'] !== FORMHASH){
			return false;
		}
		return true;
	}
	
	/**
	 * 显示系统信息
	 * @param string $msg 提示信息
	 * @param string $type 信息类型
	 * @param string $forward 跳转页面
	 * @param array $links 可选链接
	 * @param string $tips 提示信息
	 * @param bool $autoredirect 是否自动跳转
	 */
	public function showMessage($msg='',$type='success',$forward='',$links=array(),$tips='',$autoredirect=false){
		global $G,$lang;
		$type = in_array($type, array('error', 'warning', 'information')) ? $type : 'success';
		$forward = $forward ? $forward : ($links ? $links[0]['url'] : $_SERVER['HTTP_REFERER']);
		if ($links){
			$newlinks = array();
			foreach ($links as $link){
				$link['text'] = $lang[$link['text']];
				$link['target'] = in_array($link['target'], array('_blank','_top','_self')) ? $link['target'] : '';
				$newlinks[] = $link;
			}
			$links = $newlinks;
			unset($newlinks);
		}
		$msg  = $msg ? $lang[$msg] : '';
		$tips = $lang[$tips];
		$G['title'] = $lang['system_message'];
		include template('message');
		exit();
	}
	public function showSuccess($msg,$forward='',$links=array(),$tips='',$autoredirect=false){
		$this->showmessage($msg,'success',$forward,$links,$tips,$autoredirect);
	}
	public function showError($msg,$forward='',$links=array(),$tips='',$autoredirect=false){
		$this->showmessage($msg,'error',$forward,$links,$tips,$autoredirect);
	}
	public function showWarning($msg,$forward='',$links=array(),$tips='',$autoredirect=false){
		$this->showmessage($msg,'warning',$forward,$links,$tips,$autoredirect);
	}
	public function showInformation($msg,$forward='',$links=array(),$tips='',$autoredirect=false){
		$this->showmessage($msg,'information',$forward,$links,$tips,$autoredirect);
	}
	public function notFound($message=''){
		!$message && $message = 'page_not_found';
		$this->showmessage($message,'error');
	}
	
	/**
	 * 无权限提示
	 * @param string $message
	 */
	public function noPermission($message=''){
		!$message && $message = 'no_permission';
		$this->showmessage($message,'error');
	}
	
	/**
	 * 未登录提示
	 */
	public function nologin(){
		$this->showmessage('nologin','information',array(
				array('text'=>$GLOBALS['lang']['click_login'],'url'=>'/?mod=member&ac=login'),
				array('text'=>$GLOBALS['lang']['go_back'],'url'=>'javascript:history.go(-1);'),
				array('text'=>$GLOBALS['lang']['go_home'],'url'=>'/')),'','',true);
	}
	
	/**
	 * 判断是否AJAX提交
	 */
	public function inAjax(){
		$inajax = isset($_GET['inajax']) ? intval($_GET['inajax']) : 0;
		return $inajax;
	}
	
	/**
	 * 返回Ajax数据
	 * @param id $data
	 */
	public function showAjaxReturn($data){
		echo json_encode(array('errno'=>0,'state'=>'success','data'=>$data));
		exit();
	}
	
	/**
	 * 返回Ajax错误信息
	 * @param unknown $errno
	 * @param string $error
	 * @param array $data
	 */
	public function showAjaxError($errno,$error='',$data=array()){
		echo json_encode(array('errno'=>$errno,'error'=>$error,'data'=>$data));
		exit();
	}
	
	/**
	 * 页面跳转
	 * @param string $url
	 */
	public function redirect($url){
		@header('location:'.$url);
		exit();
	}
	
	/**
	 * Discuz 风格分页
	 * @param int $curr_page 当前页
	 * @param int $pagecount 总页数
	 * @param int $totalnum 总记录
	 * @param string $extra 附加参数
	 */
	public function showPages($curr_page, $pagecount, $totalnum, $extra=''){
		global $G,$lang;
		$multipage = '';
		$extra = $extra ? '&'.$extra : '';
		$url = '/?m='.$G['m'].'&c='.$G['c'].'&a='.$G['a'].$extra;
		if($pagecount>1){
			$page = 10;
			$offset = 2;
			$pages = $pagecount;
			$from = $curr_page-$offset;
			$to = $curr_page + $page - $offset - 1;
			if($page>$pages){
				$from=1;
				$to=$pages;
			}else{
				if($from<1){
					$to=$curr_page+1-$from;
					$from=1;
					if(($to-$from)<$page&&($to-$from)<$pages){
						$to=$page;
					}
				}elseif($to>$pages){
					$from=$curr_page-$pages+$to;
					$to=$pages;
					if(($to-$from)<$page&&($to-$from)<$pages){
						$from=$pages-$page+1;
					}
				}
			}
			$multipage .= "<a href=\"{$url}&page=1\">首页</a>";
			for($i=$from;$i<=$to;$i++){
				if($i!=$curr_page){
					$multipage.="<a href=\"{$url}&page=$i\">$i</a>";
				}else{
					$multipage.="<span class=\"cur\">$i</span>";
				}
			}
			$multipage.= $pages>$page ? "…<a href=\"{$url}&page=$pages\">尾页</a>" : "<a href=\"{$url}&page=$pages\">尾页</a>";
		}
		return   $multipage ;
	}
	
	/**
	 * google风格分页
	 * @param int $page 当前页
	 * @param int $total 总页数
	 * @param string $extra 附加参数
	 */
	public function googlePage($page,$total,$extra=''){
		$extra = !empty($extra) ? $extra.'&' : '';
		$scr = '/?m='.$G['m'].'&c='.$G['c'].'&a='.$G['a'].$extra;
		$prevs = $page-5;
		if($prevs<=0)$prevs = 1;
		$prev  = $page-1;
		if($prev<=0) $prev = 1;
		$nexts = $page+5;
		if($nexts>$total)$nexts=$total;
		$next  = $page+1;
		if($next>$total)$next=$total;
		$pagenavi ="<a href=\"{$scr}&page=1\">首页</a>";
		$pagenavi.="<a href=\"{$scr}&page=$prev\" class=\"prev\">上一页</a>";
		for($i=$prevs;$i<=$page-1;$i++){
			$pagenavi.="<a href=\"{$scr}&page=$i\">$i</a>";
		}
		$pagenavi.="<span class=\"cur\">$page</span>";
		for($i=$page+1;$i<=$nexts;$i++){
			$pagenavi.="<a href=\"{$scr}&page=$i\">$i</a>";
		}
		$pagenavi.="<a href=\"{$scr}&page=$next\" class=\"next\">下一页</a>";
		$pagenavi.="<a href=\"{$scr}&page=$total\">尾页</a>";
		return $pagenavi ;
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function __get($name) {
		return $this->$name;
	}
	public function __call($name,$args){
		die('Class "'.get_class($this).'" does not have a method named "'.$name.'".');
	}
	
	function __destruct(){
		$content = ob_get_contents();
		ob_end_clean();
		$content = preg_replace('/<a(.*?)href="\/\?m=post&c=detail&id=([0-9]+)"(.*?)>/is', '<a\\1href="/post/detail/\\2.html"\\3>', $content);
		$content = preg_replace('/<a(.*?)href="\/\?m=post&c=list&catid=([\d]+)"(.*?)>/is', '<a\\1href="/post/list/\\2/1.html"\\3>', $content);
		$content = preg_replace('/<a(.*?)href="\/\?m=post&c=list&catid=([\d]+)&page=([\d]+)"(.*?)>/is', '<a\\1href="/post/list/\\2/\\3.html"\\4>', $content);
		//$content = preg_replace('/<a(.*?)href="\/\?m=([\w]+)&c=([\w]+)"(.*?)>/is', '<a\\1href="/\\2/\\3"\\4>', $content);
		//$content = preg_replace('/<a(.*?)href="\/\?m=([\w]+)&c=([\w]+)&a=([\w]+)"(.*?)>/is', '<a\\1href="/\\2/\\3/\\4"\\5>', $content);
		echo $content;
	}
}