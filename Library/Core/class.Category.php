<?php
namespace Core;
class Category{
	public $catid = 0;
	public $cname = '';
	public $data  = array();
	public $dataList = array();
	
	function __construct(){
		
	}
	
	public function getCatid(){
		return $this->catid;
	}
	
	public function getData(){
		if (!$this->data){
			foreach ($this->dataList as $data){
				if ($data['catid'] == $this->catid){
					$this->data = $data;
					break;
				}
			}
		}
		return $this->data;
	}
	
	public function getDataList(){
		return $this->dataList;
	}
	
	public function getAllids(){
		$idarry = array();
		if ($this->dataList){
			foreach ($this->dataList as $list){
				$idarry[] = $list['catid'];
			}
		}
		return $idarry;
	}
	
	public function getChildids($fid=0){
		$childids = array();
		$childlist = $this->getChilds($fid);
		if($childlist){
			foreach ($childlist as $list){
				$childids[] = $list['catid'];
			}
		}
		return $childids;
	}
	
	public function getAllChildids($fid=0){
		$childids = array();
		$childlist = $this->getAllChilds($fid);
		if($childlist){
			foreach ($childlist as $list){
				$childids[] = $list['catid'];
			}
		}
		return $childids;
	}
	
	public function getChilds($fid=0){
		$childlist = array();
		if ($this->dataList){
			foreach ($this->dataList as $list){
				if ($list['fid'] == $fid){
					$childlist[] = $list;
				}
			}
		}
		return $childlist;
	}
	
	public function getAllChilds($fid=0){
		$childlist = array();
		if ($this->dataList){
			foreach ($this->dataList as $list){
				if ($list['fid'] == $fid){
					$childlist[] = $list;
					$childlist = array_merge($childlist,$this->getChilds($list['catid']));
				}
			}
		}
		return $childlist;
	}
	
	public function getOptions($fid=0,$selected=0,$seperator=''){
		if ($this->dataList){
			$options = '';
			foreach ($this->dataList as $category){
				if ($category['fid'] == $fid){
					$options.= '<option value="'.$category['catid'].'"'.
					($category['available'] ? '' : ' disabled="disabled"').
					($category['catid'] == $selected ? ' selected="selected"' : '').'>'.
					$seperator.$category['cname'].'</option>'."\n";
					$options.= $this->getOptions($category['catid'],$selected,$seperator.'|--');
				}
			}
			return $options;
		}else {
			return '';
		}
	}
	
	public function serializeByFid(){
		$categorylist = array();
		if ($this->dataList){
			foreach ($this->dataList as $list){
				$categorylist[$list['fid']][] = $list;
			}
		}
		return $categorylist;
	}
}