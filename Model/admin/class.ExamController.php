<?php
namespace Admin;
use Core\phpExcel;
class ExamController extends BaseController{
	public function index(){}
	
	/**
	 * 系统设置
	 */
	public function setting(){
		
		if ($this->checkFormSubmit()){
			$settingnew = $_GET['settingnew'];
			if ($settingnew && is_array($settingnew)){
				foreach ($settingnew as $skey=>$svalue){
					$svalue = is_array($svalue) ? serialize($svalue) : $svalue;
					$this->t('exam_setting')->insert(array('skey'=>$skey,'svalue'=>$svalue),false,true);
				}
			}
			$this->_updateSetting();
			$this->showSuccess('save_succeed');
		}else {
			global $G,$lang;
			$settings = $this->t('exam_setting')->select();
			if ($settings){
				$newsetting = array();
				foreach ($settings as $set){
					$svalue = unserialize($set['svalue']);
					$newsetting[$set['skey']] = is_array($svalue) ? $svalue : $set['svalue'];
				}
				$settings = $newsetting;
				unset($newsetting);
			}else {
				$settings = array();
			}
			$paperlist = cache('exam_paper');
			include template('exam_setting');
		}
	}
	
	
	/**
	 * 更新设置
	 */
	private function _updateSetting(){
		$settings = $this->t('exam_setting')->select();
		if ($settings){
			$newsetting = array();
			foreach ($settings as $set){
				if ($set['skey'] == 'subject_type'){
					$categorylist = explode("\n", $set['svalue']);
					if ($categorylist){
						$newlist = array();
						foreach ($categorylist as $category){
							$arr = explode('=', $category);
							$newlist[] = array(
									'typeid'=>$arr[0],
									'typename'=>$arr[1]
							);
						}
						$set['svalue'] = $newlist;
					}else {
						$set['svalue'] = array();
					}
					
				}
				
				if ($set['skey'] == 'paper_set'){
					$categorylist = explode("\n", $set['svalue']);
					if ($categorylist){
						$newlist = array();
						foreach ($categorylist as $category){
							$arr = explode('=', $category);
							$newlist[$arr[0]] = array(
									'typeid'=>intval($arr[0]),
									'subject_num'=>intval($arr[1]),
									'subject_score'=>intval($arr[2])
							);
						}
						$set['svalue'] = $newlist;
					}else {
						$set['svalue'] = array();
					}
				}
				
				$newsetting[$set['skey']] = $set['svalue'];
				$settings = $newsetting;
			}
		}else {
			$settings = array();
		}
		cache('exam_setting',$settings);
	}
	
	/**
	 * 考试设置
	 */
	public function subject(){
		$paperid = intval($_GET['paperid']);
		if (!$paperid){
			$this->notFound();
		}
		
		if ($this->checkFormSubmit()){
			$delete = $_GET['delete'];
			if ($delete && is_array($delete)){
				$deleteids = implode(',', $delete);
				$this->t('exam_subject')->where("id IN($deleteids)")->delete();
				$this->t('exam_option')->where("subjectid IN($deleteids)")->delete();
				$this->showSuccess('delete_succeed');
			}else {
				$this->showError('no_select');
			}
		}else {
			global $G,$lang;
			$pagesize = 20;
			$typeid = intval($_GET['typeid']);
			$kw = trim($_GET['kw']);
			$where = "paperid='$paperid'";
			if ($typeid) $where.= " AND typeid='$typeid'";
			if ($kw) $where.= " AND subject LIKE '%$kw%'";
			$totalnum = $this->t('exam_subject')->where($where)->count();
			$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$subjectlist = $this->t('exam_subject')->where($where)->order('id','ASC')->page($G['page'],$pagesize)->select();
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
					$optionlist = $this->t('exam_option')->where("subjectid IN($idlist)")->order('ordernum ASC,optionid ASC')->select();
					if ($optionlist){
						foreach ($optionlist as $list){
							$subjectlist[$list['subjectid']]['options'][] = $list;
						}
					}
				}
			}else {
				$subjectlist = array();
			}
			
			$typelist = $this->_getSubjectTypes();
			$pages = $this->showPages($G['page'], $pagecount, $totalnum, "paperid=$paperid&typeid=$typeid&kw=$kw");
			include template('exam_subject_list');
		}
	}
	
	/**
	 * 新增题目
	 */
	public function createsubject(){
		$paperid = intval($_GET['paperid']);
		if (!$paperid){
			$this->notFound();
		}
		if ($this->checkFormSubmit()){
			$newsubject = $_GET['newsubject'];
			$options = $_GET['options'];
			$newsubject['paperid'] = $paperid;
			$id = $this->t('exam_subject')->insert($newsubject,true);
			if ($options){
				$optionlist = explode("\n", $options);
				if ($optionlist){
					foreach ($optionlist as $option){
						$arr = explode('=', $option);
						if ($arr[0] && $arr[1]){
							$this->t('exam_option')->insert(array(
									'subjectid'=>$id,
									'optionkey'=>trim($arr[0]),
									'optionname'=>trim($arr[1])
							));
						}
					}
				}
			}
			$this->showSuccess('save_succeed');
		}else {
			global $G,$lang;
			$typelist = $this->_getSubjectTypes();
			include template('exam_subject_form');
		}
	}

	/**
	 * 编辑题目
	 */
	public function editsubject(){
		$id = intval($_GET['id']);
		$paperid = intval($_GET['paperid']);
		if($this->checkFormSubmit()){
			$newsubject = $_GET['newsubject'];
			$options = $_GET['options'];
			$this->t('exam_subject')->where(array('id'=>$id))->update($newsubject);
			$this->t('exam_option')->where(array('subjectid'=>$id))->delete();
			if ($options){
				$optionlist = explode("\n", $options);
				if ($optionlist){
					foreach ($optionlist as $option){
						$arr = explode('=', $option);
						if ($arr[0] && $arr[1]){
							$this->t('exam_option')->insert(array(
									'subjectid'=>$id,
									'optionkey'=>trim($arr[0]),
									'optionname'=>trim($arr[1])
							));
						}
					}
				}
			}
			$this->showSuccess('modi_succeed');
		}else {
			global $G,$lang;
			$subject  = $this->t('exam_subject')->where(array('id'=>$id))->selectOne();
			$optionlist = $this->t('exam_option')->where(array('subjectid'=>$id))->order('ordernum ASC,optionid ASC')->select();
			$options = $comma = '';
			if ($optionlist){
				foreach ($optionlist as $option){
					$options.= $comma.$option['optionkey'].'='.$option['optionname']."\n";
				}
			}
			$typelist = $this->_getSubjectTypes();
			include template('exam_subject_form');
		}
	}
	
	private function _getSubjectTypes(){
		$typelist = array();
		$examset = cache('exam_setting');
		if ($examset['subject_type']){
			foreach ($examset['subject_type'] as $type){
				$typelist[$type['typeid']] = $type['typename'];
			}
		}
		return $typelist;
	}
	
	private function _getOptionString($options,$suffix='<br>'){
		$string = '';
		if ($options){
			foreach ($options as $option){
				$string.= $option['optionkey'].'、'.$option['optionname'].$suffix;
			}
		}
		return $string;
	}
	
	/**
	 * 考试列表
	 */
	public function examinee(){
		if ($this->checkFormSubmit()){
			$delete = $_GET['delete'];
			if ($delete && is_array($delete)){
				$deleteids = implode(',', $delete);
				$this->t('exam_examinee')->where("uid IN($deleteids)")->delete();
				$this->showSuccess('delete_succeed');
			}else {
				$this->showError('no_select');
			}
		}else {
			global $G,$lang;
			$pagesize = 50;
			$kw = trim($_GET['kw']);
			$field = $_GET['field'];
			if ($kw){
				if ($field == 'idnumber'){
					$where = "idnumber='$kw'";
				}else {
					$where = "username LIKE '%$kw%'";
				}
			}else {
				$where = "";
			}
			$totalnum = $this->t('exam_examinee')->where($where)->count();
			$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$examineelist = $this->t('exam_examinee')->where($where)->order('uid','ASC')->page($G['page'],$pagesize)->select();
			$pages = $this->showPages($G['page'], $pagecount, $totalnum,"field=$field&kw=$kw");
			include template('exam_examinee');
		}
	}
	
	/**
	 * 答题记录
	 */
	public function record(){
		if ($this->checkFormSubmit()){
			$delete = $_GET['delete'];
			if ($delete && is_array($delete)){
				$deleteids = implode(',', $delete);
				$this->t('exam_record')->where("recordid IN($deleteids)")->delete();
				$this->showSuccess('delete_succeed');
			}else {
				$this->showError('no_select');
			}
		}else {
			global $G,$lang;
			$pagesize   = 50;
			$paperid = intval($_GET['paperid']);
			$where = $paperid ? "paperid='$paperid'" : '';
			$totalnum  = $this->t('exam_record')->where($where)->count();
			$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$orderby = isset($_GET['orderby']) ? $_GET['orderby'] : '';
			$orderby = in_array($orderby, array('spenttime','score')) ? $orderby : 'recordid';
			$asc = (isset($_GET['asc']) && strtoupper($_GET['asc']) == 'DESC')  ? 'DESC' : 'ASC';
			$recordlist = $this->t('exam_record')->field('*,(submittime-starttime) as spenttime')->where($where)
			->order($orderby,$asc)->page($G['page'],$pagesize)->select();
			$examineelist = array();
			if ($recordlist){
				$uids = $comma = '';
				foreach ($recordlist as $list){
					$uids.= $comma.$list['uid'];
					$comma = ',';
				}
				if ($uids){
					$examineelist = $this->t('exam_examinee')->where("uid IN($uids)")->select();
					if ($examineelist){
						$newlist = array();
						foreach ($examineelist as $list){
							$newlist[$list['uid']] = $list;
						}
						$examineelist = $newlist;
						unset($newlist);
					}else {
						$examineelist = array();
					}
				}
				unset($uids,$comma);
			}
			$pages = $this->showPages($G['page'], $pagecount, $totalnum, "paperid=$paperid&orderby=$orderby&asc=$asc");
			$paperlist = cache('exam_paper');
			include template('exam_record');
		}
	}
	
	/**
	 * 导出成绩
	 */
	public function exportresult(){
		global $G;
		$paperid = intval($_GET['paperid']);
		$where['paperid'] = $paperid;
		if ($G['page'] == 1){
			$data[0] = array(
					'名次',
					'姓名',
					'身份证号',
					'所在乡镇',
					'所在单位',
					'考试时间',
					'正常交卷',
					'答题用时',
					'答题成绩'
			);
		}
		
		$recordlist = $this->t('exam_record')->field('*,(submittime-starttime) as spenttime')
		->where($where)->page($G['page'],100)->order('score','DESC')->select();
		if ($recordlist){
			$ordernum = ($G['page'] - 1)*100;
			echo '<h3><center>正在导出数据...,请不要刷新或关闭页面</center></h3>';
			echo '<h3><center>已完成:'.$ordernum.'</center></h3>';
			
			$uids = $comma = '';
			foreach ($recordlist as $list){
				$uids.= $comma.$list['uid'];
				$comma = ',';
			}
			if ($uids){
				$examineelist = $this->t('exam_examinee')->where("uid IN($uids)")->select();
				if ($examineelist){
					$newlist = array();
					foreach ($examineelist as $list){
						$newlist[$list['uid']] = $list;
					}
					$examineelist = $newlist;
					unset($newlist);
				}else {
					$examineelist = array();
				}
			}
				
			foreach ($recordlist as $list){
				$ordernum++;
				$data[] = array(
						$ordernum,
						$examineelist[$list['uid']]['username'],
						$examineelist[$list['uid']]['idnumber'],
						$examineelist[$list['uid']]['town'],
						$examineelist[$list['uid']]['company'],
						@date('Y-m-d H:i',$list['starttime']),
						($list['submited'] ? '是' : '否'),
						$this->_formatTime($list['spenttime']),
						$list['score']
				);
			}
			$results = cache('exam_export');
			if ($results){
				$results = array_merge($results,$data);
			}else {
				$results = $data;
			}
			cache('exam_export', $results);
			$url = '/?m='.$G['m'].'&c='.$G['c'].'&a='.$G['a'].'&paperid='.$paperid.'&page='.($G['page']+1);
			echo '<script>setTimeout(function(){window.location.href="'.$url.'"},2000);</script>';
			exit();
		}else {
			echo '<h3><center>导出完成，总计:'.count($results).'条数据。</center></h3>';
			$results = cache('exam_export');
			$excel = new phpExcel();
			$excel->addArray($results);
			$excel->generateXML($paperid);
		}
	}
	
	private function _formatTime($time){
		$time = intval($time);
		if ($time <= 0) {
			return '0分0秒';
		}else {
			return floor($time/60).'分'.($time%60).'秒';
		}
	}
	
	public function paper(){
		if ($this->checkFormSubmit()){
			$delete = $_GET['delete'];
			if ($delete && is_array($delete)){
				$deleteids = implode(',', $delete);
				$this->t('exam_paper')->where("paperid IN($deleteids)")->delete();
				$this->_updatePaper();
				$this->showSuccess('delete_succeed');
			}else {
				$this->showError('no_select');
			}
		}else {
			global $G,$lang;
			$paperlist = $this->t('exam_paper')->order('paperid DESC')->select();
			include template('exam_paper_list');
		}
	}
	
	public function createpaper(){
		if ($this->checkFormSubmit()) {
			$newpaper = $_GET['newpaper'];
			if ($newpaper['name'] && $newpaper['timelength']){
				$this->t('exam_paper')->insert($newpaper);
				$this->_updatePaper();
				$this->showSuccess('save_succeed');
			}
		}else {
			global $G,$lang;
			include template('exam_paper_form');
		}
	}
	
	public function editpaper(){
		$paperid = intval($_GET['paperid']);
		if ($this->checkFormSubmit()) {
			$newpaper = $_GET['newpaper'];
			if ($newpaper['name'] && $newpaper['timelength']){
				$this->t('exam_paper')->where(array('paperid'=>$paperid))->update($newpaper);
				$this->_updatePaper();
				$this->showSuccess('modi_succeed');
			}
		}else {
			global $G,$lang;
			$paper = $this->t('exam_paper')->where(array('paperid'=>$paperid))->selectOne();
			include template('exam_paper_form');
		}
	}
	
	private function _updatePaper(){
		$paperlist = $this->t('exam_paper')->order('paperid DESC')->select();
		if ($paperlist){
			$newlist = array();
			foreach ($paperlist as $list){
				if ($list['subject_set']){
					$subject_types = array();
					$subject_set = explode("\n", $list['subject_set']);
					if ($subject_set){
						
						foreach ($subject_set as $set){
							$arr = explode('=', $set);
							if ($arr[0] && $arr[1] && $arr[2]){
								$subject_types[$arr[0]] = array(
										'typeid'=>$arr[0],
										'subject_num'=>$arr[1],
										'subject_score'=>$arr[2]
								);
							}
						}
					}
					$list['subject_set'] = $subject_types;
				}else {
					$list['subject_set'] = array();
				}
				$newlist[$list['paperid']] = $list;
			}
			cache('exam_paper',$newlist);
		}else {
			cache('exam_paper',array());
		}
	}
}