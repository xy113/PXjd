<?php
namespace Weixin;
use Core\Controller;
class BaseController extends Controller{
	protected $appid = 'wx681e02d69eae358d';
	protected $appsecrect = '';
	protected $longitude = '';
	protected $latitude ='';
	public function __construct(){
		parent::__construct();
	}
	
	protected function checkLogined(){
		if (!$this->uid || !$this->username){
			$this->showLogin();
		}
	}
	
	protected function showLogin(){
		global $G,$lang;
		G('title',$lang['login']);
		include template('login');
		exit();
	}
	
	protected function examInit(){
		$this->checkLogined();
		$this->__set('examinee', array());
		$this->__set('exam_setting', array());
		$this->__set('subject_types', array());
		$this->__set('paper_config', array());
		$this->__set('paper_types', array());
		$this->exam_setting = cache('exam_setting');
		if ($this->exam_setting['closed']){
			L('exam_closed',$this->exam_setting['closed_tips']);
			$this->showError('exam_closed');
		}
		if (is_array($this->exam_setting['subject_type'])){
			foreach ($this->exam_setting['subject_type'] as $type){
				$this->subject_types[$type['typeid']] = $type['typename'];
			}
		}
		$questionlist = cache('exam_question');
		$this->paper_config = $questionlist[$this->exam_setting['questionid']];
		
		if ($this->paper_config['subject_set']){
			foreach ($this->paper_config['subject_set'] as $type){
				$type['typename'] = $this->subject_types[$type['typeid']];
				$this->paper_types[$type['typeid']] = $type;
			}
		}
		
		G('title', $this->exam_setting['sysname']);
	}
	
	protected function getExaminee($uid=0){
		!$uid && $uid = $this->uid;
		$this->examinee = $this->t('exam_examinee')->where(array('uid'=>$uid))->selectOne();
		return $this->examinee;
	}
}