<?php
namespace Admin;
class MemberController extends BaseController{
	public function index(){
		$this->showlist();
	}
	
	public function showlist(){
		if ($this->checkFormSubmit()){
			$this->_update();
		}else {
			global $G,$lang;
			$pagesize = 20;
			$q = trim($_GET['q']);
			$type = trim($_GET['type']);
			$wheresql = '';
			if(!empty($q)){
				switch ($type){
					case 'ID':
						$wheresql = "uid='$q'";
						break;
					case 'name':
						$wheresql = "username LIKE '%$q%'";
						break;
					case 'mobile':
						$wheresql = "mobile='$q'";
						break;
					case 'email':
						$wheresql = "email='$q'";
						break;
					default:$wheresql = '';
				}
			}
			$totalnum = $this->t('member')->where($wheresql)->count();
			$pagecount  = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$memberlist = $this->t('member')->where($wheresql)->page($G['page'],$pagesize)->order('uid ASC')->select();
			$usergrouplist = $this->t('member_group')->select();
			if ($usergrouplist){
				$newgrouplist = array();
				foreach ($usergrouplist as $group){
					$newgrouplist[$group['gid']] = $group['title'];
				}
				$usergrouplist = $newgrouplist;
				unset($newgrouplist);
			}
			
			if ($memberlist){
				$newmeberlist = $uids =  array();
				foreach ($memberlist as $member){
					$member['grouptitle'] = $usergrouplist[$member['gid']];
					$uids[] = $member['uid'];
					$newmemberlist[] = $member;
				}
				$memberlist = $newmemberlist;
			}
			
			$uids = !empty($uids) ? implode(',', $uids) : 0;
			$memberstatuslist = $this->t('member_status')->where("uid IN($uids)")->select();
			$memberstatus = array();
			if ($memberstatuslist){
				foreach ($memberstatuslist as $status){
					$memberstatus[$status['uid']] = $status;
				}
			}
			$pages = $this->showPages($G['page'], $pagecount, $totalnum);
			include template('member');
		}
	}
	
	private function _update(){
		$uids = $_GET['uid'];
		if (is_array($uids) && !empty($uids)) {
			$uids = implode(',', $uids);
			switch ($_GET['option']){
				case 1:
					$this->_delete($uids);
					break;
				case 2:
					$this->_updatestate($uids);
					break;
				case 3:
					$this->_updatestate($uids,2);
					break;
				case 4:
					$this->_updatestate($uids,3);
					break;
				default:$this->_updatestate($uids);
			}
		}else{
			$this->showError('no_select');
		}
	}
	
	private function _delete($uids){
		$where = "uid IN($uids)";
		$this->t('member')->where($where)->delete();
		$this->t('member_profile')->where($where)->delete();
		$this->t('member_status')->where($where)->delete();
		$this->t('member_count')->where($where)->delete();
		$this->t('member_field')->where($where)->delete();
		$this->t('member_count')->where($where)->delete();
		$this->t('member_log')->where($where)->delete();
		//$this->t('post_title')->where($where)->delete();
		//$this->t('post_content')->where($where)->delete();
		$this->showSuccess('delete_succeed');
	}
	
	private function _updatestate($uids,$status=0){
		$this->t('member')->where("uid IN($uids)")->update(array('status'=>$status));
		$this->showSuccess('update_succeed');
	}
	
	private function _editperm(){
		global $G,$lang;
		if($_GET['formsubmit'] == 'yes'){
			$uid = intval($_GET['uid']);
			$gid = intval($_GET['gid']);
			$adminid = intval($_GET['adminid']);
			$perm = serialize($_GET['perm']);
			if($uid){
				table('member')->where(array('uid'=>$uid))->update(array('gid'=>$gid,'adminid'=>$adminid));
				table('member_perm')->insert(array('perm'=>$perm,'uid'=>$uid),false,true);
				$this->showSuccess('save_success');
			}
		}else{
			$uid = intval($_GET['uid']);
			$member = table('member')->field('username,gid,adminid')->where(array('uid'=>$uid))->selectOne();
			$usergrouplist = table('usergroups')->select();
			$newgrouplist = array();
			foreach ($usergrouplist as $group){
				$group['perm'] = unserialize($group['perm']);
				$newgrouplist[] = $group;
			} 
			$usergrouplist = $newgrouplist;
			unset($newgrouplist);
			$perm = table('member_perm')->where(array('uid'=>$uid))->selectOne();
			$perm = unserialize($perm['perm']);
			//$options = CategoryAction::getOptions(0,$perm['catids']);
			include template('member');
		}
	}
}