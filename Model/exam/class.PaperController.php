<?php
namespace Exam;
class PaperController extends BaseController{
	private $starttime;
	private $spenttime;
	public function index(){
		global $G,$lang;
		$this->checkRecord();
		$examset = $this->exam_setting;
		if ($this->checkFormSubmit()){
			$uid = intval($_GET['uid']);
			$recordid = intval($_GET['recordid']);
			if ($uid != $this->uid || !$recordid){
				$this->showError('undefined_action');
			}
			
			$totalscore = 0;
			$answers = $_GET['answers'];
			if ($answers && is_array($answers)){
				$subjectids = $comma = '';
				foreach ($answers as $id=>$value){
					$subjectids.= $comma.$id;
					$comma = ',';
				}
				!$subjectids && $subjectids = 0;
				$subjectlist = $this->t('exam_subject')->where("id IN($subjectids)")->select();
				if ($subjectlist){
					foreach ($subjectlist as $subject){
						$subjectid = $subject['id'];
						$subject_score = $this->paper_types[$subject['typeid']]['subject_score'];
						//echo $subject_score;
						if (isset($answers[$subjectid])){
								
							//单选题和是非题
							if ($subject['valuetype'] == 'radio' || $subject['valuetype'] == 'yesorno'){
								if ($answers[$subjectid] == $subject['answer']){
									$totalscore+= $subject_score;
								}
							}
								
							if ($subject['valuetype'] == 'checkbox'){
								$subject_answer = explode(',', $subject['answer']);
								sort($subject_answer);
								sort($answers[$subjectid]);
								$diff = array_diff($subject_answer, $answers[$subjectid]);
								if (!$diff){
									$totalscore+= $subject_score;
								}
								$answers[$subjectid] = implode(',', $answers[$subjectid]);
							}
						}
					
					}
				}
			}
			
			$data = array(
					'answers'=>serialize($answers),
					'submited'=>1,
					'submittime'=>time(),
					'score'=>$totalscore
			);
			//print_array($data);exit();
			$this->t('exam_record')->where(array('uid'=>$uid,'recordid'=>$recordid))->update($data);
			$record = $this->t('exam_record')->where(array('uid'=>$uid,'recordid'=>$recordid))->selectOne();
			$spenttime = $data['submittime'] - $record['starttime'];
			$spenttime = floor($spenttime/60).'分'.($spenttime%60).'秒';
			
			include template('paper_result');
		}else {
			
			$examinee = $this->getExaminee();
			if (!$examinee){
				$this->redirect('/?m=home&c=examsign');
			}
			
			$record   = $this->_getRecord();
			$subjects = $record['subjects'];
			$subjectlist = $this->t('exam_subject')->where("id IN($subjects)")->select();
			if ($subjectlist){
				$newlist = array();
				foreach ($subjectlist as $list){
					$newlist[$list['typeid']][] = $list;
				}
				$subjectlist = $newlist;
				unset($newlist);
			}else {
				$subjectlist = array();
			}
			
			$optionlist = $this->t('exam_option')->where("subjectid IN($subjects)")->order('ordernum ASC,optionid ASC')->select();
			if ($optionlist){
				$newlist = array();
				foreach ($optionlist as $list){
					$newlist[$list['subjectid']][] = $list;
				}
				$optionlist = $newlist;
				unset($newlist);
			}
			unset($subjects);
			$paper_config = $this->paper_config;
			$paper_types  = $this->paper_types;
			include template('paper');
		}
	}
	
	/**
	 * 获取试卷
	 * @return array
	 */
	private function _getRecord(){
		$examset   = $this->exam_setting;
		$paperconf = $this->paper_config;
		$expire    = intval($paperconf['timelength']) * 60;
		$record = $this->t('exam_record')->where(array('uid'=>$this->uid,'submited'=>0,'paperid'=>$examset['paperid']))->order('recordid','DESC')->selectOne();
		if ($record && ((time() - $record['starttime']) < $expire)){
			return $record;
		}else {
			$subjectlist = array();
				
			if ($this->paper_types){
				foreach ($this->paper_types as $type){
					$array = $this->_createSubjects($type['typeid'], $type['subject_num'],$paperconf['make_type']);
					$subjectlist = array_merge($subjectlist,$array);
				}
			}
			if ($subjectlist){
				$subjects = $comma = '';
				foreach ($subjectlist as $list){
					$subjects.= $comma.$list['id'];
					$comma = ',';
				}
			}
			$data = array(
					'uid'=>$this->uid,
					'username'=>$this->username,
					'starttime'=>time(),
					'endtime'=>time() + $expire,
					'submited'=>0,
					'subjects'=>$subjects,
					'paperid'=>$examset['paperid']
			);
			$this->t('exam_record')->insert($data);
			return $this->_getRecord();
		}
	}
	
	private function _createSubjects($typeid,$num,$type=1){
		$orderby = $type == 1 ? 'RAND()' : 'id';
		$subjectlist = $this->t('exam_subject')->where(array('typeid'=>$typeid,'paperid'=>$this->exam_setting['paperid']))
		->order($orderby,'ASC')->limit(0,$num)->select();
		if ($subjectlist){
			/*
			$subjectids = $comma = '';
			foreach ($subjectids as $list){
				$subjectids.= $comma.$list['questionid'];
				$comma = ',';
			}
			*/
		}else {
			$subjectlist = array();
		}
		return $subjectlist;
	}
	
	/**
	 * 查看试卷
	 */
	public function viewpaper(){
		global $G,$lang;
		$examset  = $this->exam_setting;
		$recordid = intval($_GET['recordid']);
		$uid = isset($_GET['uid']) ? $_GET['uid'] : $this->uid;
		$where['recordid'] = $recordid;
		if ($this->account['admincp']){
			$where['uid'] = $uid;
		}else {
			$where['uid'] = $this->uid;
		}

		$record = $this->t('exam_record')->where($where)->selectOne();
		if ($record){
			$subjects = $record['subjects'];
			$answers  = unserialize($record['answers']);
			$answers  = is_array($answers) ? $answers : array();
			if ($subjects){
				$subjectlist = $this->t('exam_subject')->where("id IN($subjects)")->select();
				if ($subjectlist){
					$newlist = array();
					foreach ($subjectlist as $list){
						$subjectid = $list['id'];
						if ($list['valuetype'] == 'radio' || $list['valuetype'] == 'yesorno'){
							if ($answers[$subjectid] == $list['answer']){
								$list['yes'] = true;
							}else {
								$list['yes'] = false;
							}
						}
						
						if ($list['valuetype'] == 'checkbox'){
							$list['yes'] = ($answers[$subjectid] == $list['answer']);
						}
						
						$newlist[$list['typeid']][] = $list;
					}
					$subjectlist = $newlist;
					unset($newlist);
				}
				
				$optionlist = $this->t('exam_option')->where("subjectid IN($subjects)")->order('ordernum ASC,optionid ASC')->select();
				if ($optionlist){
					$newlist = array();
					foreach ($optionlist as $list){
						$newlist[$list['subjectid']][] = $list;
					}
					$optionlist = $newlist;
					unset($newlist);
				}else {
					$optionlist = array();
				}
			}
			$G['title'] = $record['username'].'的试卷';
			$paper_config = $this->paper_config;
			$paper_types  = $this->paper_types;
			
			$spenttime = $record['submittime'] ? $record['submittime'] - $record['starttime'] : 0;
			$spenttime = floor($spenttime/60).'分'.($spenttime%60).'秒';
			include template('paper_view');
		}else {
			$this->notFound();
		}
	}
	
	/**
	 * 检测是否已答过题
	 */
	private function checkRecord(){
		$paperset = $this->paper_config;
		$record = $this->t('exam_record')->where(array('uid'=>$this->uid,'paperid'=>$paperset['paperid']))->selectOne();
		if ($record){
			$timelast = $paperset['timelength']*60 - (time() - $record['starttime']);
			if (($timelast < 0) || $record['submited']){
				L('record_exists','你已经参加过答题了');
				$this->showError('record_exists','/?m=home');
				return false;
			}else {
				return true;
			}
		}else {
			return true;
		}
	}
}