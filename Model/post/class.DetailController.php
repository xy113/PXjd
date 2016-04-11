<?php
namespace Post;
class DetailController extends BaseController{
	public $id = 0;
	public $catid = 0;
	public function index(){
		global $G,$lang;
		$this->id = intval($_GET['id']);
		$this->t('post_title')->where(array('id'=>$this->id))->update('viewnum=viewnum+1');
		$article = $this->t('post_title')->where(array('id'=>$this->id))->selectOne();
		$article['tags'] = $article['tags'] ? unserialize($article['tags']) : array();
		if (!in_array($article['type'], array('image','video','music','goods','active'))){
			$article['type'] = 'article';
		}
		$content = $this->t('post_content')->where(array('aid'=>$this->id,'pageorder'=>$G['page']))->selectOne();
		
		$this->catid = $article['catid'];
		$category = $this->t('category')->where(array('catid'=>$this->catid))->selectOne();
		$G['title'] = $article['title'].' - '.$category['cname'];
		$G['keywords'] = $article['tags'] ? implode(',', $article['tags']) : $G['keywords'];
		$G['description'] = $article['summary'] ? $article['summary'] : $G['keywords'];
		if ($article['type'] == 'article'){
			$relateds   = $this->fetchRelatedArticles();
			include template('detail_article');
		}
		if ($article['type'] == 'image'){
			$piclist = unserialize($content['content']);
			if ($piclist && is_array($piclist)){
				$newlist = array();
				foreach ($piclist as $list){
					$list['thumb'] = image($list['thumb']);
					$list['attachment'] = image($list['attachment']);
					$newlist[] = $list;
				}
				$piclist = $newlist;
				unset($newlist);
			}else {
				$piclist = array();
			}
			include template('detail_image');
		}
		
		if($article['type'] == 'video'){
			$content['content'] = unserialize($content['content']);
			$video = $content['content'];
			include template('detail_video');
		}
		
		if ($article['type'] == 'goods') {
			$attributes = $this->t('post_goods_attribute')->where(array('aid'=>$id))->select();
			include template('detail_goods');
		}
		
		if ($article['type'] == 'active') {
			$active = $this->t('post_active')->where(array('aid'=>$id))->selectOne();
			include template('detail_active');
		}
	}
	
	public function fetchRelatedArticles(){
		$articlelist = $this->t('post_title')->where(array('catid'=>$this->catid,"id<>".$this->id))->order('id','DESC')->limit(0,10)->select();
		return $articlelist;
	}
}