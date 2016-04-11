<?php
namespace Exam;
use Core\Controller;
class BaseController extends Controller{
	protected $exam_setting  = array();
	protected $subject_types = array();
	protected $paper_config  = array();
	protected $paper_types   = array();
	protected $examinee  = array();
	public function __construct(){
		parent::__construct();
		if(!$this->uid || !$this->username){
			member_show_login();
		}
		$this->exam_setting = cache('exam_setting');
		if ($this->exam_setting['closed']){
			L('exam_closed','考试系统已关闭，请等待管理员开启');
			$this->showError('exam_closed');
		}
		if (is_array($this->exam_setting['subject_type'])){
			foreach ($this->exam_setting['subject_type'] as $type){
				$this->subject_types[$type['typeid']] = $type['typename'];
			}
		}
		
		$paperlist = cache('exam_paper');
		$this->paper_config = $paperlist[$this->exam_setting['paperid']];
		
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