<?php
namespace Common;
use Core\UploadImage;
class UploadController extends BaseController{
	public function uploadimage(){
		if ($_GET['uploadtype'] == 'swfupload'){
			$uid = intval($_GET['uid']);
			$username = trim($_GET['username']);
			$token = sha1($uid.$username.formhash());
			if (!$uid || !$username || $token != $_GET['token']){
				$this->showAjaxError(-1,'nologin');
			}else {
				$this->uid = $uid;
				$this->username = $username;
			}
		}else {
			if (!$this->uid || !$this->username){
				$this->showAjaxError(-1,'nologin');
			}
		}
		
		$upload = new UploadImage();
		if($photo = $upload->saveImage()){
			$photo['uid'] = $this->uid;
			$photo['uptime'] = time();
			$photo['photoid'] = M('photo')->insert($photo,true);
			$photo['url'] = image($photo['attachment']);
			$photo['pic'] = $photo['attachment'];
			$this->showAjaxReturn($photo);
		}
	}
	
	public function uploadfile(){
		if ($_GET['from'] == 'swfupload'){
			$uid = intval($_GET['uid']);
			$username = trim($_GET['username']);
			$token = sha1($uid.$username.formhash());
			if (!$uid || !$username || $token != $_GET['token']){
				$this->showAjaxError(-1,'nologin');
			}
		}else {
			if (!$GLOBALS['G']['uid']){
				$this->showAjaxError(-1,'nologin');
			}else {
				$uid = $GLOBALS['G']['uid'];
			}
		}
		$config = $GLOBALS['G']['config']['output'];
		$upload = new Upload();
		$attachment = 'attach/'.date('Y').'/'.date('m').'/'.$upload->setfilename();
		if ($upload->save(ROOT_PATH.'/'.$config['attachdir'].'/'.$attachment)){
			$attachdata = array(
					'uid'=>$uid,
					'attachname'=>$upload->oriname(),
					'attachment'=>$attachment,
					'attachsize'=>$upload->size(),
					'attachtype'=>$upload->type(),
					'attachtime'=>time()
			);
			$attachdata['attachid'] = M('attachment')->insert($attachdata,true);
			echo json_encode(array('state'=>1,'data'=>$attachdata));
			exit();
		}else {
			echo json_encode(array('state'=>0,'info'=>'Upload Failed('.$upload->error.')'));
			exit();
		}
	}
}