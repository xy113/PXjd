<?php
namespace Upgrade;
use Core\Controller;
class ExamController extends Controller{
	public $ac = 'uprecoed';
	public function index(){
		if ($this->ac == 'member'){
			echo 'http://kaoshi.pxjd.org/api.php?page='.G('page').'<br>';
			$json = file_get_contents('http://kaoshi.pxjd.org/examapi.php?page='.G('page'));
			$array = json_decode($json,true);
			
			if ($array){
				foreach ($array as $examinee){
					$examinee['company'] = addslashes($examinee['company']);
					print_array($examinee);
					$this->t('exam_examinee')->insert($examinee);
					$member = array(
							'uid'=>$examinee['uid'],
							'username'=>$examinee['username'],
							'password'=>$examinee['password'],
							'random'=>$examinee['random']
					);
					print_array($member);
					$this->t('member')->insert($member);
				}
				echo '<script>setTimeout(function(){window.location="http://pxjd.org/?m=upgrade&c=exam&page='.(G('page')+1).'";},2000);</script>';
			}else {
				echo 'Complete!';
			}
		}
		
		if ($this->ac == 'options'){
			echo 'http://kaoshi.pxjd.org/api.php?page='.G('page').'<br>';
			$json = file_get_contents('http://kaoshi.pxjd.org/examapi.php?page='.G('page'));
			$array = json_decode($json,true);
			if ($array){
				foreach ($array as $option){
					$option['optionname'] = addslashes($option['optionname']);
					print_array($option);
					$this->t('exam_options')->insert($option);
				}
				echo '<script>setTimeout(function(){window.location="http://pxjd.org/?m=upgrade&c=exam&page='.(G('page')+1).'";},2000);</script>';
			}else {
				echo 'Complete!';
			}
		}
		
		if ($this->ac == 'questions'){
			echo 'http://kaoshi.pxjd.org/api.php?page='.G('page').'<br>';
			$json = file_get_contents('http://kaoshi.pxjd.org/examapi.php?page='.G('page'));
			$array = json_decode($json,true);
			if ($array){
				foreach ($array as $option){
					print_array($option);
					$this->t('exam_questions')->insert($option);
				}
				//echo '<script>setTimeout(function(){window.location="http://pxjd.org/?m=upgrade&c=exam&page='.(G('page')+1).'";},2000);</script>';
			}else {
				echo 'Complete!';
			}
			echo 'Complete!';
		}
		
		if ($this->ac == 'examineequestions'){
			echo 'http://kaoshi.pxjd.org/api.php?page='.G('page').'<br>';
			$json = file_get_contents('http://kaoshi.pxjd.org/examapi.php?page='.G('page'));
			$array = json_decode($json,true);
			if ($array){
				foreach ($array as $data){
					$data['sysanswer'] = addslashes($data['sysanswer']);
					$data['answer'] = addslashes($data['answer']);
					print_array($data);
					$this->t('examinee_question')->insert($data);
				}
				echo '<script>setTimeout(function(){window.location="http://pxjd.org/?m=upgrade&c=exam&page='.(G('page')+1).'";},2000);</script>';
			}else {
				echo 'Complete!';
			}
		}
		
		if ($this->ac == 'examineeresult'){
			echo 'http://kaoshi.pxjd.org/api.php?page='.G('page').'<br>';
			$json = file_get_contents('http://kaoshi.pxjd.org/examapi.php?page='.G('page'));
			$array = json_decode($json,true);
			if ($array){
				foreach ($array as $data){
					print_array($data);
					$this->t('examinee_result')->insert($data);
				}
				echo '<script>setTimeout(function(){window.location="http://pxjd.org/?m=upgrade&c=exam&page='.(G('page')+1).'";},2000);</script>';
			}else {
				echo 'Complete!';
			}
		}
		
		if ($this->ac == 'memberstatus') {
			//echo 'http://kaoshi.pxjd.org/api.php?page='.G('page').'<br>';
			$examineelist = $this->t('exam_examinee')->where('uid<1000000')->order('uid','ASC')->page(G('page'),500)->select();
			if ($examineelist){
				foreach ($examineelist as $data){
					$status = array(
							'uid'=>$data['uid'],
							'regdate'=>$data['lastlogin'],
							'regip'=>$data['lastip'],
							'lastvisit'=>$data['lastlogin'],
							'lastvisitip'=>$data['lastip']
					);
					print_array($status);
					$this->t('member_status')->insert($status,false,true);
				}
				echo '<script>setTimeout(function(){window.location="http://pxjd.org/?m=upgrade&c=exam&page='.(G('page')+1).'";},2000);</script>';
			}else {
				echo 'Complete!';
			}
		}
		
		if ($this->ac == 'memberprofile') {
			//echo 'http://kaoshi.pxjd.org/api.php?page='.G('page').'<br>';
			$examineelist = $this->t('exam_examinee')->where('uid<1000000')->order('uid','ASC')->page(G('page'),500)->select();
			if ($examineelist){
				foreach ($examineelist as $data){
					$profile = array(
							'uid'=>$data['uid'],
							'country'=>'中国',
							'province'=>'贵州',
							'city'=>'六盘水',
							'county'=>$data['county'] ? $data['county'] : '盘县',
							'town'=>$data['town']
					);
					print_array($profile);
					$this->t('member_profile')->insert($profile,false,true);
				}
				echo '<script>setTimeout(function(){window.location="http://pxjd.org/?m=upgrade&c=exam&page='.(G('page')+1).'";},2000);</script>';
			}else {
				echo 'Complete!';
			}
		}
		
		
		if ($this->ac == 'record'){
			$datalist = $this->t('examinee_result')->order('uid','ASC')->page(G('page'),500)->select();
			if ($datalist){
				foreach ($datalist as $data){
					$record = array(
							'uid'=>$data['uid'],
							'starttime'=>$data['timestart'],
							'endtime'=>($data['timestart']+2400),
							'submittime'=>($data['timestart'] + $data['timespent']),
							'submited'=>$data['done'],
							'score'=>$data['total']
					);
					print_array($record);
					$this->t('exam_record')->insert($record);
				}
				
				echo '<script>setTimeout(function(){window.location="http://pxjd.org/?m=upgrade&c=exam&page='.(G('page')+1).'";},2000);</script>';
			}else {
				echo 'Complete!';
			}
		}
		
		if ($this->ac == 'uprecoed'){
			$datalist = $this->t('exam_record')->order('uid','ASC')->page(G('page'),100)->select();
			if ($datalist) {
				foreach ($datalist as $list){
					$data = $this->getSubjectsAndAnswer($list['uid']);
					$subjects = implode(',', $data['questions']);
					$answers = serialize($data['answers']);
					$d = array('subjects'=>$subjects,'answers'=>$answers);
					print_array($d);
					$this->t('exam_record')->where(array('uid'=>$list['uid']))->update($d);
				}
				echo '<script>setTimeout(function(){window.location="http://pxjd.org/?m=upgrade&c=exam&page='.(G('page')+1).'";},2000);</script>';
			}else {
				echo 'Complete!';
			}
		}
	}
	
	
	function getSubjectsAndAnswer($uid){
		$subjectlist = $this->t('examinee_question')->where(array('uid'=>$uid))->select();
		if ($subjectlist){
			$questions = array();
			$answers = array();
			foreach ($subjectlist as $list){
				$questions[] = $list['qid'];
				$answers[$list['qid']] = addslashes($list['answer']);
			}
			return array('questions'=>$questions,'answers'=>$answers);
		}else {
			return array();
		}
	}
}