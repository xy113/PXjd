<?php
namespace Admin;
class ResearchController extends BaseController{
	public function index(){
		
	}
	
	public function paper(){
		if ($this->checkFormSubmit()){
			$newpaper = $_GET['newpaper'];
			$paperlist = $_GET['paperlist'];
			$delete = $_GET['delete'];
			if ($delete && is_array($delete)){
				$deleteids = implode(',', $delete);
				$this->t('research_paper')->where("paperid IN($deleteids)")->delete();
			}
			
			if ($newpaper && is_array($newpaper)){
				foreach ($newpaper as $paper){
					if ($paper['papername']){
						$this->t('research_paper')->insert($paper);
					}
				}
			}
			
			if ($paperlist && is_array($paperlist)){
				foreach ($paperlist as $paperid=>$paper){
					$this->t('research_paper')->where(array('paperid'=>$paperid))->update($paper);
				}
			}
			
			$isdefault = intval($_GET['isdefault']);
			$this->t('research_paper')->where(array('paperid'=>$isdefault))->update(array('isdefault'=>1));
			$this->showSuccess('save_succeed');
		}else {
			global $G,$lang;
			$paperlist = $this->t('research_paper')->order('paperid DESC')->select();
			include template('research_paper');
		}
	}
	
	/**
	 * 题目设置
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
				$this->t('research_subject')->where("id IN($deleteids)")->delete();
				$this->t('research_option')->where("subjectid IN($deleteids)")->delete();
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
			$totalnum = $this->t('research_subject')->where($where)->count();
			$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$subjectlist = $this->t('research_subject')->where($where)->order('id','ASC')->page($G['page'],$pagesize)->select();
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
			$pages = $this->showPages($G['page'], $pagecount, $totalnum, "paperid=$paperid&typeid=$typeid&kw=$kw");
			include template('research_subject_list');
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
			$id = $this->t('research_subject')->insert($newsubject,true);
			if ($options){
				$optionlist = explode("\n", $options);
				if ($optionlist){
					foreach ($optionlist as $option){
						$arr = explode('=', $option);
						if ($arr[0] && $arr[1]){
							$this->t('research_option')->insert(array(
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
			include template('research_subject_form');
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
			$this->t('research_subject')->where(array('id'=>$id))->update($newsubject);
			$this->t('research_option')->where(array('subjectid'=>$id))->delete();
			if ($options){
				$optionlist = explode("\n", $options);
				if ($optionlist){
					foreach ($optionlist as $option){
						$arr = explode('=', $option);
						if ($arr[0] && $arr[1]){
							$this->t('research_option')->insert(array(
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
			$subject  = $this->t('research_subject')->where(array('id'=>$id))->selectOne();
			$optionlist = $this->t('research_option')->where(array('subjectid'=>$id))->order('ordernum ASC,optionid ASC')->select();
			$options = $comma = '';
			if ($optionlist){
				foreach ($optionlist as $option){
					$options.= $comma.$option['optionkey'].'='.$option['optionname']."\n";
				}
			}
			include template('research_subject_form');
		}
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
	 * 调查记录
	 */
	public function record(){
		$paperid = intval($_GET['paperid']);
		if ($this->checkFormSubmit()){
			$delete = $_GET['delete'];
			if ($delete && is_array($delete)){
				$deleteids = implode(',', $delete);
				$this->t('research_record')->where("recordid IN($deleteids)")->delete();
				$this->showSuccess('delete_succeed');
			}else {
				$this->showError('no_select');
			}
		}else {
			global $G,$lang;
			$pagesize   = 50;
			$where = $paperid ? "paperid='$paperid'" : '';
			$totalnum   = $this->t('research_record')->where($where)->count();
			$pagecount  = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$asc = (isset($_GET['asc']) && strtoupper($_GET['asc']) == 'DESC')  ? 'DESC' : 'ASC';
			$recordlist = $this->t('research_record')->where($where)->order('recordid',$asc)->page($G['page'],$pagesize)->select();
			if ($recordlist){
				
				$uids = $comma = '';
				foreach ($recordlist as $list){
					$uids.= $comma.$list['uid'];
					$comma = ',';
				}
				
				if ($uids){
					$userlist = $this->t('member_profile')->where("uid IN($uids)")->select();
					if ($userlist){
						$newlist = array();
						foreach ($userlist as $list){
							$newlist[$list['uid']] = $list;
						}
						$userlist = $newlist;
						unset($newlist);
					}
				}
			}else {
				$recordlist = array();
			}
			$pages = $this->showPages($G['page'], $pagecount, $totalnum, "paperid=$paperid&asc=$asc");
			include template('research_record');
		}
	}
	
	/**
	 * 调查结果
	 */
	public function result(){
		global $G,$lang;
		$paperid = intval($_GET['paperid']);
		$paper = $this->t('research_record')->where(array('paperid'=>$paperid))->selectOne();
		$subjectlist = $this->t('research_subject')->where(array('paperid'=>$paperid))->select();
		if ($subjectlist){
			$newlist = array();
			$adlist = $comma = '';
			foreach ($subjectlist as $list){
				$newlist[$list['id']] = $list;
				$idlist.= $comma.$list['id'];
				$comma = ',';
			}
			$subjectlist = $newlist;
			unset($newlist);
			/*
			$optionlist = $this->t('research_option')->where("subjectid IN($idlist)")->select();
			if ($optionlist){
				foreach ($optionlist as $option){
					$subjectlist[$option['subjectid']][] = $option;
				}
			}
			*/
		}
		
		include template('research_result');
	}
	
	public function viewsubject(){
		global $G,$lang;
		$paperid = intval($_GET['paperid']);
		$subjectid = intval($_GET['subjectid']);
		$totalnum = $this->t('research_record')->where(array('paperid'=>$paperid))->count();
		$subject = $this->t('research_subject')->where(array('id'=>$subjectid))->selectOne();
		$optionlist = $this->t('research_option')->where(array('subjectid'=>$subjectid))->order('optionid ASC')->select();
		$flashvars = array();
		$totalstat = 0;
		if ($optionlist){
			foreach ($optionlist as $option) {
				$where = array('subjectid'=>$subjectid,'answer'=>$option['optionkey']);
				$stat = $this->t('research_answer')->where($where)->count();
				$option['optionname'] = str_replace(array("\n","\r"), array("",""), $option['optionname']);
				$flashvars['xdata'].= $option['optionname'].':'.$stat.'人\t'.$stat.'\n';
				$totalstat+= $stat;
			}
			$other = $totalnum - $totalstat;
			$flashvars['xdata'].= $other > 0 ? '未选择答案:'.$other.'人\t'.$other.'\n' : '';
			unset($totalstat,$other);
		}
		//include template('research_subject_result');
		$flash = '<embed src="/static/swf/category.swf" quality="high" width="800" height="360" align="middle" wmode="transparent" '.
		'FlashVars="ntitle=总计'.$totalnum.'人参与&toggle=全部显示|全部隐藏&vtitle=数值&cnames=&datatype=20&rtitle='.$subject['subject'].'&gtypes=pie&total='.$totalnum.'&xdata='.$flashvars[xdata].'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>';
		echo $flash;
		exit();
	}
	
	public function viewoption(){
		global $G,$lang;
		$subjectid = intval($_GET['subjectid']);
		$answer = trim($_GET['answer']);
		$where = "subjectid='$subjectid' AND (answer='$answer' OR answer LIKE '%\"$answer\"%')";
		$totalnum = $this->t('research_answer')->where($where)->count();
		$pagecount = $totalnum < 20 ? 1 : ceil($totalnum/20);
		$answerlist = $this->t('research_answer')->where($where)->page($G['page'], 20)->select();
		if ($answerlist){
			$uids = $comma = '';
			foreach ($answerlist as $list){
				$uids.= $comma.$list['uid'];
				$comma = ',';
			}
			if ($uids){
				$userlist = $this->t('member_profile')->where("uid IN($uids)")->select();
				if ($userlist){
					$newlist = array();
					foreach ($userlist as $list){
						$newlist[$list['uid']] = $list;
					}
					$userlist = $newlist;
					unset($newlist);
				}
				$namelist = $this->t('member')->field('uid,username')->where("uid IN($uids)")->select();
				if ($namelist){
					foreach ($namelist as $list){
						$userlist[$list['uid']]['username'] = $list['username'];
					}
				}
			}
		}else {
			$answerlist = array();
		}
		$pages = $this->showPages($G['page'], $pagecount, $totalnum, "subjectid=$subjectid&answer=$answer");
		include template('research_option_record');
	}
}