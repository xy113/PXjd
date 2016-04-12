<?php
namespace Home;
class ExamsignController extends BaseController{
	public function index(){
		if ($this->checkFormSubmit()) {
			$newexaminee = $_GET['newexaminee'];
			if ($newexaminee['username'] && $newexaminee['idnumber'] && $newexaminee['tel']){
				$newexaminee['uid'] = $this->uid;
				$this->t('exam_examinee')->insert($newexaminee,false,true);
				$profile = array(
						'realname'=>$newexaminee['username'],
						'province'=>$newexaminee['province'],
						'city'=>$newexaminee['city'],
						'county'=>$newexaminee['county'],
						'town'=>$newexaminee['town']
				);
				member_update_profile($this->uid, $profile);
			}
			$this->showSuccess('save_succeed');
		}else {
			global $G,$lang;
			$examinee = $this->t('exam_examinee')->where(array('uid'=>$this->uid))->selectOne();
			if (!$examinee){
				$profile = member_get_profile($this->uid);
				$examinee = array(
						'username'=>$profile['realname'],
						'province'=>$profile['province'],
						'city'=>$profile['city'],
						'county'=>$profile['county'],
						'town'=>$profile['town']
				);
			}
			include template('examsign');
		}
	}
}