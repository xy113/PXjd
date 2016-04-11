<?php
namespace Admin;
class UsergroupController extends BaseController{
	public function index(){
		global $G,$lang;
		if($this->checkFormSubmit()){
			$newgroup  = $_GET['newgroup'];
			$usergroup = $_GET['usergroup'];
			if($_GET['delete']){
				$gids = $_GET['gid'];
				if(!empty($gids) && is_array($gids)){
					$gids = implode(',', $gids);
					M('member_group')->where("gid IN($gids)")->delete();
					$data = M('member_group')->field('gid')->order('creditslower ASC')->selectOne();
					M('member')->where("gid IN($gids)")->update(array('gid'=>$data['gid']));
				}
			}
			if(is_array($newgroup)){
				foreach ($newgroup as $k=>$group){
					if($group['title']){
						$group['perm'] = serialize($group['perm']);
						M('member_group')->insert($group);
					}
				}
			}
			if(is_array($usergroup)){
				foreach ($usergroup as $gid=>$group){
					$group['perm'] = serialize($group['perm']);
					M('member_group')->where(array('gid'=>$gid))->update($group);
				}
			}
			$this->showSuccess('save_succeed');
		}else{
			$usergrouplist = M('member_group')->order('type ASC,creditslower ASC')->select();
			if ($usergrouplist){
				$newgrouplist = array();
				foreach ($usergrouplist as $group){
					$group['perm'] = unserialize($group['perm']);
					$newgrouplist[] = $group;
				}
				$usergrouplist = $newgrouplist;
				unset($newgrouplist);
			}else {
				$usergrouplist = array();
			}
			include template('usergroup');
		}
	}
}