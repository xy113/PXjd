<?php
namespace Home;
class ExamsearchController extends BaseController{
	public function index(){
		global $G,$lang;
		$recordlist = $this->t('exam_record')->where(array('uid'=>$this->uid))->order('recordid DESC')->select();
		if ($recordlist){
			$newlist = array();
			foreach ($recordlist as $list){
				
				$list['spenttime'] = $this->_formatTime($list['submittime'] - $list['starttime']);
				$list['starttime'] = @date('Y-m-d H:i:s', $list['starttime']);
				$list['submittime'] = @date('Y-m-d H:i:s', $list['submittime']);
				$newlist[$list['recordid']] = $list;
			}
			$recordlist = $newlist;
			unset($newlist);
		}
		$paperlist = cache('exam_paper');
		include template('examsearch');
	}
	
	private function _formatTime($time){
		$time = intval($time);
		if ($time <= 0) {
			return '0分0秒';
		}else {
			return floor($time/60).'分'.($time%60).'秒';
		}
	}
}