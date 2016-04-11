<?php
namespace Weixin;
class ResearchController extends BaseController{
	private $paper = array();
	
	
	public function index(){
		if ($this->checkFormSubmit()){
			$paperid = $_GET['paperid'];
			$answers = $_GET['answers'];
			if ($paperid){
				if ($answers && is_array($answers)){
					foreach ($answers as $subjectid=>$answer){
						if (is_array($answer)) $answer = serialize($answer);
						$this->t('research_answer')->insert(array(
								'uid'=>intval($this->uid),
								'subjectid'=>$subjectid,
								'answer'=>$answer
						));
					}
				}
				$record = array(
						'uid'=>$this->uid,
						'username'=>$this->username,
						'paperid'=>$paperid,
						'answers'=>serialize($answers),
						'dateline'=>time()
				);
				$this->t('research_record')->insert($record);
				L('paper_save_succeed','问卷提交成功，谢谢您的参与。');
				$this->showSuccess('paper_save_succeed','/?m=weixin&c=home');
			}else {
				$this->showError('undefined_action');
			}
		}else {
			global $G,$lang;
			$this->paper = $this->getPaper();
			$paperid = $this->paper['paperid'];
			$where = array('paperid'=>$this->paper['paperid']);
			$subjectlist = $this->t('research_subject')->where($where)->order('id','ASC')->select();
			if ($subjectlist){
				$newlist = array();
				$idlist = $comma = '';
				foreach ($subjectlist as $list){
					$newlist[$list['id']] = $list;
					$idlist.= $comma.$list['id'];
					$comma = ',';
				}
				$subjectlist = $newlist;
				unset($newlist);
				if ($idlist){
					$optionlist = $this->t('research_option')->where("subjectid IN($idlist)")->order('ordernum ASC,optionid ASC')->select();
					if ($optionlist){
						foreach ($optionlist as $list){
							$subjectlist[$list['subjectid']]['options'][] = $list;
						}
					}
				}
			}else {
				$subjectlist = array();
			}
			//print_array($optionlist);
			include template('research_paper');
		}
	}
	
	private function getPaper(){
		return $this->t('research_paper')->where(array('isdefault'=>1))->selectOne();
	}
}