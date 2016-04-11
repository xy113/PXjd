<?php
namespace Admin;
class PhotoController extends BaseController{
	public function index(){
		global $G,$lang;
		if($this->checkFormSubmit()){
			$delete = $_GET['delete'];
			if($delete && is_array($delete)){
				$deleteids = implodeids($delete);
				$photos = $this->t('photo')->where("photoid IN($deleteids)")->select();
				foreach ($photos as $pp){
					@unlink(ROOT_PATH.'/'.$pp['thumb']);
					@unlink(ROOT_PATH.'/'.$pp['picurl']);
				}
				$this->t('photo')->where("photoid IN($deleteids)")->delete();
			}
			$this->showSuccess('delete_succeed');
		}else {
			$pagesize  = 20;
			$totalnum  = $this->t('photo')->count();
			$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$photolist = $this->t('photo')->page($G['page'],$pagesize)->order('photoid','DESC')->select();
			if ($photolist){
				$newlist = array();
				foreach ($photolist as $list){
					$list['thumb']  = C('ATTACHURL').$list['thumb'];
					$list['size']   = formatsize($list['size']);
					$list['uptime'] = @date('Y-m-d H:i', $list['uptime']);
					$newlist[$list['photoid']] = $list;
				}
				$photolist = $newlist;
				unset($newlist);
			}
			$pages = $this->showPages($G['page'], $pagecount, $totalnum);
			include template('photo');
		}
	}
}