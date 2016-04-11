<?php
namespace Weixin;
class ExamController extends BaseController{
	public function __construct(){
		parent::__construct();
		$this->checkLogined();
		$this->examInit();
	}
	
	public function index(){
		global $G,$lang;
		$examset = $this->exam_setting;
		$paper_config = $this->paper_config;
		$paper_types  = $this->paper_types;
		$G['title'] = $this->exam_setting['sysname'];
		include template('exam_index');
	}
	
	public function viewrecord(){
		global $G,$lang;
		$recordlist = $this->t('exam_record')->where(array('uid'=>$this->uid))->select();
		$questionlist = cache('exam_question');
		$G['title'] = '成绩查询';
		include template('exam_record');
	}
	
	public function sign(){
		if ($this->checkFormSubmit()){
			$newexaminee = $_GET['newexaminee'];
			if ($newexaminee['username'] && $newexaminee['idnumber'] && $newexaminee['tel']){
				$examineeid = $_GET['examineeid'];
				if ($examineeid){
					$this->t('exam_examinee')->where(array('uid'=>$this->uid))->update($newexaminee);
					$this->showSuccess('modi_succeed');
				}else {
					$this->t('exam_examinee')->insert($newexaminee);
					$this->showSuccess('save_succeed');
				}
	
			}
		}else {
			global $G,$lang;
			$examinee = $this->getExaminee();
			if ($examinee){
				$G['title'] = '信息修改';
			}else {
				$G['title'] = '信息登记';
			}
			$townlist = $this->t('district')->where(array('fid'=>4402))->select();
			include template('exam_sign');
		}
	}
}