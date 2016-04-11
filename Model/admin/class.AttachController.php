<?php
namespace Admin;
class AttachController extends BaseController{
	public function index(){
		global $G,$lang;
		if($this->checkFormSubmit()){
			$delete = $_GET['delete'];
			$attachids = implode(',', $delete);
			if ($attachids){
				$attachmentlist = $this->t('attachment')->where("attachid IN ($attachids)")->select();
				foreach ($attachmentlist as $attachment){
					@unlink(ROOT_PATH.'/'.$GLOBALS['config']['output']['attachdir'].'/'.$attachment['attachment']);
					@unlink(ROOT_PATH.'/'.$GLOBALS['config']['output']['attachdir'].'/'.$attachment['thumb']);
				}
				$this->t('attachment')->where("attachid IN ($attachids)")->delete();
			}
			$this->showSuccess('delete_succeed');
		}else {
			$pagesize  = 20;
			$totalnum  = $this->t('attachment')->count();
			$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$attachmentlist = $this->t('attachment')->page($G['page'],$pagesize)->select();
			$pages = $this->showPages($G['page'], $pagecount, $totalnum);
			include template('attach');
		}
	}
}