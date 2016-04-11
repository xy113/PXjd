<?php
namespace Admin;
class SignController extends BaseController{
	public function index(){
		if ($this->checkFormSubmit()){
			$delete = $_GET['delete'];
			if ($delete && is_array($delete)){
				$deleteids = implode(',', $delete);
				$this->t('sign')->where("signid IN($deleteids)")->delete();
				$this->showSuccess('delete_succeed');
			}else {
				$this->showError('no_select');
			}
		}else {
			global $G,$lang;
			$pagesize = 50;
			$field = $_GET['field'];
			$kw = trim($_GET['kw']);
			$where = '';
			if ($kw){
				if ($field == 'uid') $where = array('uid'=>$kw);
				if ($field == 'username') $where = "username LIKE '%$kw%'";
			}
			$totalnum = $this->t('sign')->where($where)->count();
			$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$signlist = $this->t('sign')->where($where)->order('signid DESC')->page($G['page'],$pagesize)->select();
			if ($signlist){
				$newlist = array();
				foreach ($signlist as $list){
					$list['pic'] = image($list['pic']);
					$list['signtime'] = @date('Y-m-d H:i',$list['dateline']);
					$newlist[$list['signid']] = $list;
				}
				$signlist = $newlist;
				unset($newlist);
			}else {
				$signlist = array();
			}
			$pages = $this->showPages($G['page'], $pagecount, $totalnum,"field=$field&kw=$kw");
			include template('sign_list');
		}
		
	}
	
	/**
	 * 导出Excel表格
	 */
	public function export(){
		$uid = intval($_GET['uid']);
		$data[0] = array(
				'UID',
				'姓名',
				'签到时间',
				'签到位置',
				'IP地址'
		);
		$signlist = $this->t('sign')->where(array('uid'=>$uid))->order('signid DESC')->select();
		if($signlist){
			foreach ($signlist as $list){
				$data[] = array(
						$list['uid'],
						$list['username'],
						@date('Y-m-d H:i',$list['dateline']),
						$list['location'],
						$list['userip']
				);
			}
			$excel = new \Core\phpExcel();
			$excel->setWorksheetTitle('签到记录');
			$excel->addArray($data);
			$excel->generateXML($uid);
		}
	}
}