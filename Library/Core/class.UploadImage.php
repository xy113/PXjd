<?php
namespace Core;
class UploadImage extends Upload{
	public function saveImage(){
		$this->allowtypes = array('jpg','jpeg','png','gif');
		$this->maxsize = 1024*1024*5;
		$filename   = $this->setfilename();
		$filepath   = date('Y').'/'.date('m').'/'.$filename;
		$thumb      = 'thumb/'.$filepath;
		$attachment = 'photo/'.$filepath;
		if ($this->save(C('ATTACHDIR').$attachment)){
			$image = new Image(C('ATTACHDIR').$attachment);
			$image->thumb(210, 210);
			$image->save(C('ATTACHDIR').$thumb);
			return array(
					'name'=>$filename,
					'width'=>$image->width(),
					'height'=>$image->height(),
					'type'=>$image->type(),
					'filesize'=>$this->size(),
					'attachment'=>$attachment,
					'thumb'=>$thumb
			);
		}else {
			return false;
		}
	}
}