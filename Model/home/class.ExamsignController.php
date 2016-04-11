<?php
namespace Home;
class ExamsignController extends BaseController{
	public function index(){
		if ($this->checkFormSubmit()) {
			$newexaminee = $_GET['newexaminee'];
			if ($newexaminee['username'] && $newexaminee['idnumber'] && $newexaminee['tel']){
				$newexaminee['uid'] = $this->uid;
				$this->t('exam_examinee')->insert($newexaminee,false,true);
			}
			$this->showSuccess('save_succeed');
		}else {
			global $G,$lang;
			$examinee = $this->t('exam_examinee')->where(array('uid'=>$this->uid))->selectOne();
			$townlist = $this->t('district')->where(array('fid'=>4402))->select();
			include template('examsign');
		}
	}
}