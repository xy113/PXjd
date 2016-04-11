<?php
define('version', '2.0');
defined('ROOT_PATH')   or define('ROOT_PATH', dirname($_SERVER['SCRIPT_FILENAME']).'/');
defined('LIB_PATH')    or define('LIB_PATH', __DIR__.'/');
defined('APP_PATH')    or define('APP_PATH', ROOT_PATH.'/Model/');
defined('CONFIG_PATH') or define('CONFIG_PATH', ROOT_PATH.'Config/');
defined('LANG_PATH')   or define('LANG_PATH', ROOT_PATH.'Lang/');
defined('DATA_PATH')   or define('DATA_PATH', ROOT_PATH.'data/');
defined('CACHE_PATH')  or define('CACHE_PATH', ROOT_PATH.'data/cache/');
defined('TPL_PATH')    or define('TPL_PATH', ROOT_PATH.'templates/');
defined('DEFAULT_MODEL')  or define('DEFAULT_MODEL', 'home');
defined('DEFAULT_LANG')   or define('DEFAULT_LANG', 'zh_cn');
defined('THEME')  or define('THEME', 'default');

class Application{
	private $var = array();
	function __construct(){
		spl_autoload_register('Application::autoload');
		$this->timezone_set(8);
		if(version_compare(PHP_VERSION,'5.4.0','<')) {
			@ini_set('magic_quotes_runtime',0);
			define('MAGIC_QUOTES_GPC',get_magic_quotes_gpc() ? true : false);
		}else{
			define('MAGIC_QUOTES_GPC',false);
		}
		
		include LIB_PATH.'functions/function.common.php';
		if(!MAGIC_QUOTES_GPC) {
			$_GET = daddslashes($_GET);
			$_POST = daddslashes($_POST);
		}
		
		if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
			$_GET = array_merge($_GET, $_POST);
		}
		//加载配置文件
		global $config;
		$config = include CONFIG_PATH.'config.php';
		$config = array_merge($config,include(CONFIG_PATH.'db.php'));
		if (is_array(C('AUTO_LOAD_CONFIG'))){
			foreach (C('AUTO_LOAD_CONFIG') as $name){
				if (is_file(CONFIG_PATH.$name.'.php') && !in_array($name, array('config','db'))){
					$config = array_merge($config,include(CONFIG_PATH.$name.'.php'));
				}
			}
		}
		
		//加载function文件
		if (is_array(C('AUTO_LOAD_FUNCTIONS'))){
			foreach (C('AUTO_LOAD_FUNCTIONS') as $name){
				$funcfile = LIB_PATH.'functions/function.'.$name.'.php';
				if (is_file($funcfile) && $name != 'common'){
					include $funcfile;
				}
			}
		}
		
		//加载语言包
		global $lang;
		$lang = include LANG_PATH.DEFAULT_LANG.'/lang.common.php';
		if (is_array(C('AUTO_LOAD_LANGS'))){
			foreach (C('AUTO_LOAD_LANGS') as $name){
				if (is_file(LANG_PATH.DEFAULT_LANG.'/lang.'.$name.'.php')){
					$lang = array_merge($lang,include(LANG_PATH.DEFAULT_LANG.'/lang.'.$name.'.php'));
				}
			}
		}
		
		global $G;
		$G = array(
				'uid'=>0,
				'username'=>'',
				'email'=>'',
				'mobile'=>'',
				'group'=>array(),
				'account'=>array(),
				'profile'=>array(),
				'status'=>array(),
				'setting'=>array(),
		);
		$this->var = &$G;
		
		$this->var['m'] = isset($_GET['m']) ? $_GET['m'] : DEFAULT_MODEL;
		$this->var['c'] = isset($_GET['c']) ? $_GET['c'] : 'index';
		$this->var['a'] = isset($_GET['a']) ? $_GET['a'] : 'index';
		$this->var['page'] = isset($_GET['page']) ? max(array(intval($_GET['page']), 1)) : 1;
		$this->var['BASEURL'] = rawurlencode(curPageURL());
		
		define('FORMHASH', formhash());
		define('TIMESTAMP', time());
		define('DATESTAMP', date('Ymd',time()));
		@header('Content-type: text/html;charset=utf8');
		@header('Expires: Fri, 14 Mar 1980 20:53:00 GMT');
		@header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		@header('Cache-Control: no-cache, must-revalidate');
		@header('Pragma: no-cache');
		@mkdir(ROOT_PATH.'data/cache',0777,true);
		@mkdir(ROOT_PATH.'data/session',0777,true);
		@ini_set('session.save_path', ROOT_PATH.'data/session');
		session_start();
		$this->var['session'] = &$_SESSION;
		if(mobilecheck() || isset($_GET['ismobile'])){
			define('ISMOBILE', true);
		}else {
			define('ISMOBILE', false);
		}
		
		$this->var['setting'] = cache('settings');
		if (!$this->var['setting']){
			$settinglist = M('setting')->select();
			foreach ($settinglist as $list){
				$svalue = unserialize($list['svalue']);
				$this->var['setting'][$list['skey']] = is_array($svalue) ? $svalue : $list['svalue'];
			}
			cache('settings', $this->var['setting']);
		}
		$this->var['keywords'] = $this->var['setting']['keywords'];
		$this->var['description'] = $this->var['setting']['description'];
		
		$account = cookie('member_account');
		$this->var['account'] = $account ? unserialize($account) : array();
		if(!empty($this->var['account'])){
			$this->var['uid'] = $this->var['account']['uid'];
			$this->var['username'] = $this->var['account']['username'];
			$this->var['email']    = $this->var['account']['email'];
			$this->var['mobile']   = $this->var['account']['mobile'];
			if ($this->var['uid'] && $this->var['username']){
				$this->var['islogined'] = 1;
				$group = cookie('member_group');
				$this->var['group'] = $group ? unserialize($group) : array();
		
				$profile = cookie('member_profile');
				$this->var['profile'] = $profile ? unserialize($profile) : array();
		
				$status = cookie('member_status');
				$this->var['status'] = $status ? unserialize($status) : array();
			}
		}
	}

	public function start(){
		$model = $this->var['m'];
		$controller = $this->var['c'];
		$action = $this->var['a'];
		$class = $model.'\\'.ucfirst($controller).'Controller';
		$app = new $class();
		$app->$action();
	}
	
	/**
	 * 设置时区
	 * @param number $timeoffset
	 */
	public function timezone_set($timeoffset = 0) {
		if(function_exists('date_default_timezone_set')) {
			@date_default_timezone_set('Etc/GMT'.($timeoffset > 0 ? '-' : '+').(abs($timeoffset)));
		}
	}
	
	/**
	 * 字段加载类库
	 * @param string $class
	 */
	public static function autoload($class){
		if (false !== strpos($class, '\\')){
			$namespace = strstr($class, '\\', true);
			$array = explode('\\', $class);
			$classname = end($array);
			if ($namespace == 'Core'){
				$path = LIB_PATH.str_replace($classname, '', $class);
			}else {
				$path = APP_PATH.strtolower(str_replace($classname, '', $class));
			}
			$path = str_replace('\\', '/', $path);
			if (is_file($path.'class.'.$classname.'.php')){
				require $path.'class.'.$classname.'.php';
			}else {
				//die($path.'class.'.$classname.'.php');
				die('Class "'.$class.'" does not exists.');
			}
		}else {
			
			if (is_file(APP_PATH.'Core/class.'.$class.'.php')){
				require APP_PATH.'Core/class.'.$class.'.php';
			}else {
				die('Class "'.$class.'" does not exists.');
			}
		}
	}
}