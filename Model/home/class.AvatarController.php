<?php
namespace Home;
use Core\Image;
class AvatarController extends BaseController{
	public function index(){
		global $G,$lang;
		$avatarsmall  = avatar($this->uid,'small');
		$avatarmiddle = avatar($this->uid,'middle');
		$avatarbig    = avatar($this->uid,'big');
		include template('avatar');
	}
	
	public function snap(){
		$filename   = md5(time().rand(100,999)).'.jpg';
		$filepath   = date('Y').'/'.date('m').'/'.$filename;
		$attachment = 'photo/'.$filepath;
		$thumb      = 'thumb/'.$filename;
		@mkdir(dirname(C('ATTACHDIR').$attachment),0777,true);
		$content = file_put_contents(C('ATTACHDIR').$attachment, file_get_contents('php://input'));
		if (!$content) {
			$this->showAjaxError(-1, "ERROR: Failed to write data to $filepath, check permissions");
		}else {
			$image = new Image(C('ATTACHDIR').$attachment);
			$photo = array(
					'uid'=>$this->uid,
					'name'=>$filename.'.jpg',
					'attachment'=>$attachment,
					'thumb'=>$thumb,
					'width'=>$image->width(),
					'height'=>$image->height(),
					'type'=>$image->type(),
					'filesize'=>filesize($savepath),
					'uptime'=>time()
			);
			$image->thumb(210, 210);
			$image->save(C('ATTACHDIR').$thumb);
			$this->t('photo')->insert($photo,true);
			$this->showAjaxReturn(array('url'=>C('ATTACHURL').$attachment,'attachment'=>$attachment));
		}
	}
	
	public function upload(){
		$upload = new \Core\UploadImage();
		if ($photo = $upload->saveImage()){
			$photo['uid'] = $this->uid;
			$photo['uptime'] = time();
			$this->t('photo')->insert($photo);
			$this->showAjaxReturn(array('url'=>C('ATTACHURL').$photo['attachment'],'attachment'=>$photo['attachment']));
		}else {
			$this->showAjaxError(-1, 'upload Error');
		}
	}
	
	public function crop(){
		
		$img = $_GET['img'];
		$src = C('ATTACHDIR').$_GET['src'];
		$avatardir    = C('AVATARDIR').$this->uid;
		$avatarsmall  = $this->uid.'_avatar_small.jpg';
		$avatarmiddle = $this->uid.'_avatar_middle.jpg';
		$avatarbig    = $this->uid.'_avatar_big.jpg';
		@mkdir($avatardir,0777,true);
		$image = new Image($src);
		$scale = $image->width()/300;
		$img['w'] = $img['w']*$scale;
		$img['h'] = $img['h']*$scale;
		$img['x'] = $img['x']*$scale;
		$img['y'] = $img['y']*$scale;
		$image->crop($img['w'], $img['h'],$img['x'],$img['y'],150,150);
		$image->save($avatardir.'/'.$avatarbig);
		$image = new Image($src);
		$image->crop($img['w'], $img['h'],$img['x'],$img['y'],50,50);
		$image->save($avatardir.'/'.$avatarmiddle);
		$image = new Image($src);
		$image->crop($img['w'], $img['h'],$img['x'],$img['y'],30,30);
		$image->save($avatardir.'/'.$avatarsmall);
		$this->t('member')->where(array('uid'=>$this->uid))->update(array('avatarstatus'=>1));
		$this->showAjaxReturn('success');
	}
}