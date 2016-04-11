<?php
namespace Exam;
class IndexController extends BaseController{
	public function index(){
		global $G,$lang;
		//print_array($this->exam_setting);
		//print_array($this->subject_types);
		//print_array($this->paper_config);
		//print_array($this->paper_types);
		
		$examinee = $this->getExaminee();
		$examset = $this->exam_setting;
		include template('index');
	}
}