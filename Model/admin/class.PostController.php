<?php
namespace Admin;
class PostController extends BaseController{
	public function index(){
		$this->showlist();
	}
	
	/**
	 * 文章列表
	 */
	public function showlist(){
		if ($this->checkFormSubmit()){
			$articleids = $_GET['id'];
			if (is_array($articleids) && !empty($articleids)) {
				$articleids = $articleids ? implode(',', $articleids) : 0;
				if($_GET['option'] == 1){
					$where = "aid IN($articleids)";
					$this->t('post_title')->where("id IN($articleids)")->delete();
					$this->t('post_content')->where($where)->delete();
					$this->t('post_active')->where($where)->delete();
					$this->showSuccess('delete_succeed');
				}else {
					$status = $_GET['option'] == 2 ? 0 : 2;
					$this->t('post_title')->where("id IN($articleids)")->update(array('status'=>$status));
					$this->showSuccess('update_succeed');
				}
			}else{
				$this->showError('no_select');
			}
		}else {
			global $G,$lang;
			$pagesize  = 20;
			$condition = array();
			$catid     = intval($_GET['catid']);
			$status    = intval($_GET['status']);
			$kw        = trim($_GET['kw']);
			if ($catid) $condition['catid'] = array('IN',$catid);
			if ($status) $condition['status'] = $status;
			if ($kw) $condition['title'] = array('LIKE',$kw);
			$totalnum  = $this->t('post_title')->where($condition)->count();
			$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$fields = 'id,catid,uid,title,type,alias,commentnum,favtimes,viewnum,pubtime,modified,status';
			$articlelist = $this->t('post_title')->field($fields)->where($condition)->page($G['page'],$pagesize)->order('id','DESC')->select();
			$pages = $this->showPages($G['page'], $pagecount,$totalnum,"kw=$kw&catid=$catid&status=$status");
			
			$categorylist = cache('category_article');
			if (is_array($categorylist)){
				$category = new \Core\Category();
				$category->dataList = $categorylist;
				$categoryoptions = $category->getOptions(0,$catid);
			}
			
			if (!empty($articlelist)){
				$newarticlelist = array();
				foreach ($articlelist as $article){
					$article['pubtime']  = date('Y-m-d H:i:s',$article['pubtime']);
					$article['type']     = $article['type'] ? $article['type'] : 'article';
					$article['typename'] = $lang['posttypes'][$article['type']];
					$article['status']   = $lang['poststatus'][$article['status']];
					$article['cname']    = $categorylist[$article['catid']]['cname'];
					$newarticlelist[] = $article;
				}
				$articlelist = $newarticlelist;
				unset($newarticlelist);
			}
			include template('post_list');
		}
	}
	
	/**
	 * 发布文章
	 */
	public function publish(){
		if ($this->checkFormSubmit()){
			$this->save();
		}else {
			global $G,$lang,$config;
			$categorylist = cache('category_article');
			$category = new \Core\Category();
			$category->dataList = $categorylist;
			$categoryoptions = $category->getOptions(0,$_GET['catid']);
			$type = in_array($_GET['type'], array('image','video')) ? $_GET['type'] : 'article';
			include template('post_'.$type);
		}
	}
	
	/**
	 * 保存文章
	 */
	private function save(){
		global $G;
		if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {
			header('Allow: POST');
			header('HTTP/1.1 405 Method Not Allowed');
			header('Content-Type: text/plain');
			exit;
		}
		$newpost = $_GET ['newpost'];
		$content = $_GET['content'];
		if (is_array ( $newpost )) {
			$newpost['uid'] = $this->uid;
			$newpost['username'] = $this->username;
			if (empty($newpost['title']) || !isset($newpost['title'])){
				$this->showError('title_empty');
			}
			if (!$newpost['catid']){
				$this->showError('category_empty');
			}
			if (!in_array($newpost['type'], array('image','video','music','goods','active'))){
				$newpost['type'] = 'article';
			}
			$newpost['pubtime']  = TIMESTAMP;
			$newpost['modified'] = TIMESTAMP;
			$newpost['author']   = isset($newpost['author']) && !empty($newpost['author']) ? $newpost['author'] : $this->username;
			$newpost['from']     = isset($newpost['from']) ? $newpost['from'] : '';
			$newpost['fromurl']  = isset($newpost['fromurl']) ? $newpost['fromurl'] : '';
			$newpost['tags'] = $newpost['tags'] ? serialize($newpost['tags']) : '';
			$newpost['allowcomment'] = isset($newpost['allowcomment']) ? trim($newpost['allowcomment']) : 1;
			$newpost['summary'] = $newpost['summary'] ? $newpost['summary'] : '';
			$newpost['summary'] = $newpost['summary'] ? $newpost['summary'] : cutstr(stripHtml($content), 400);
			$newpost['summary'] = str_replace('&amp;', '&', $newpost['summary']);
			$newpost['summary'] = str_replace('&nbsp;', '', $newpost['summary']);
			$newpost['summary'] = preg_replace('/\s|　/', '', $newpost['summary']);
			$id = $this->t('post_title')->insert($newpost,true);
			//普通文章
			if ($newpost ['type'] == 'article') {
				$contentlist = preg_split('/###Pagebreak###/', $content);
				foreach ($contentlist as $key=>$value){
					$contentdata = array(
							'aid'=>$id,
							'catid'=>$newpost['catid'],
							'content'=>$value,
							'pageorder'=>$key+1,
							'dateline'=>time()
					);
					$this->t('post_content')->insert($contentdata);
				}
			}
			
			//图组
			if ($newpost ['type'] == 'image') {
				$piclist = isset($_GET['piclist']) ? $_GET['piclist'] : array();
				if (!empty($piclist)){
					$content = serialize($piclist);
					$contentdata = array(
							'aid'=>$id,
							'catid'=>$newpost['catid'],
							'content'=>$content,
							'pageorder'=>1,
							'dateline'=>time()
					);
					$this->t('post_content')->insert($contentdata);
				}
			}
			
			//视频
			if ($newpost ['type'] == 'video') {
				$videourl = trim ( $_GET['videourl'] );
				if ($videourl) {
					$videodata = \Core\ParseVideoUrl::ParseUrl ($videourl);
					$videodata['content'] = $content;
					$content = serialize($videodata);
					$contentdata = array(
							'aid'=>$id,
							'catid'=>$newpost['catid'],
							'content'=>$content,
							'pageorder'=>1,
							'dateline'=>time()
					);
					$this->t('post_content')->insert($contentdata);
					if (empty($newpost['pic'])){
						$this->t('post_title')->where(array('id'=>$id))->update(array('pic'=>$videodata['img']));
					}
				}
			}
			
			//音乐
			if ($newpost ['type'] == 'music') {
				$musicarray['songs']   = trim ($_GET['songs']);
				$musicarray['content'] = $content;
				$content = serialize($musicarray);
				$contentdata = array(
						'aid'=>$id,
						'catid'=>$newpost['catid'],
						'content'=>$content,
						'pageorder'=>1,
						'dateline'=>time()
				);
				$this->t('post_content')->insert($contentdata);
			}
				
			if ($newpost['type'] == 'goods'){
				$attributelist = isset($_GET['attribute']) ? $_GET['attribute'] : array();
				foreach ($attributelist as $attribute){
					$attribute['aid'] = $id;
					$this->t('post_goods_attribute')->insert($attribute);
				}
				$contentdata = array(
						'aid'=>$id,
						'catid'=>$newpost['catid'],
						'content'=>$content,
						'pageorder'=>1,
						'dateline'=>time()
				);
				$this->t('post_content')->insert($contentdata);
			}
				
			if ($newpost['type'] == 'active'){
				$active = isset($_GET['active']) ? $_GET['active'] : array('begin'=>time(),'end'=>'');
				$active['aid'] = $id;
				$active['begin'] = strtotime($active['begin']);
				$active['end'] = strtotime($active['end']);
				$this->t('post_active')->insert($active);
				$contentdata = array(
						'aid'=>$id,
						'catid'=>$newpost['catid'],
						'content'=>$content,
						'pageorder'=>1,
						'dateline'=>time()
				);
				$this->t('post_content')->insert($contentdata);
			}
			
			$links = array (
					array (
							'text' => 'continue_publish',
							'url' => '/?m=admin&c=post&a=publish&type='.$newpost['type'].'&catid='.$newpost ['catid']
					),
					array (
							'text'=>'view',
							'url'=>'/?m=post&c=detail&id='.$id,
							'target'=>'_blank'
					),
					array(
							'text'=>'go_home',
							'url'=>'/'
					)
			);
			$this->showSuccess('publish_succeed','', $links,'',true);
		} else {
			$this->showError('undefined_error');
		}
	}
	
	/**
	 * 编辑文章
	 */
	public function edit(){
		if ($this->checkFormSubmit()){
			$this->update();
		}else {
			global $G,$lang;
			$G['title'] = $lang['edit'];
			$id = intval($_GET['id']);
			$article = $this->t('post_title')->where(array('id'=>$id))->selectOne();
			if (!in_array($article['type'], array('image','video','music','goods','active'))){
				$article['type'] = 'article';
			}
			$pic = $article['pic'] ? image($article['pic']) : '';
			$caitd = $article['catid'];
			$category = new \Core\Category();
			$category->dataList = cache('category_article');
			$categoryoptions = $category->getOptions(0,$caitd);
			if ($article['type'] == 'article'){
				$content = $pagebreak = '';
				$contentlist = $this->t('post_content')->where(array('aid'=>$id))->order('pageorder','ASC')->select();
				if ($contentlist){
					foreach ($contentlist as $con){
						$content.= $pagebreak.$con['content'];
						$pagebreak = '###Pagebreak###';
					}
				}
				include template('post_article');
			}
			
			if ($article['type'] == 'image'){
				$content = $this->t('post_content')->where(array('aid'=>$id,'pageorder'=>1))->selectOne();
				$piclist = unserialize($content['content']);
				include template('post_image');
			}
			
			if ($article['type'] == 'video'){
				$content = $this->t('post_content')->where(array('aid'=>$id,'pageorder'=>1))->selectOne();
				$videocontent = unserialize($content['content']);
				include template('post_video');
			}
			
			if ($article['type'] == 'music'){
				$content = $this->t('post_content')->where(array('aid'=>$id,'pageorder'=>1))->selectOne();
				$musiccontent = unserialize($content);
				include template('post_music');
			}
			
			if ($article['type'] == 'goods'){
				$content = $this->t('post_content')->where(array('aid'=>$id,'pageorder'=>1))->selectOne();
				$attributes = $this->t('post_goods_attribute')->where(array('aid'=>$id))->select();
				include template('post_goods');
			}
		}
	}
	
	/**
	 * 更新文章
	 */
	public function update(){
		global $G;
		if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {
			header('Allow: POST');
			header('HTTP/1.1 405 Method Not Allowed');
			header('Content-Type: text/plain');
			exit;
		}
		if (!isset($_GET['formsubmit']) || $_GET['formsubmit']!='yes'){
			$this->showError('undefined_action');
		}
		$id = intval($_GET['id']);
		$newpost = $_GET['newpost'];
		$content = $_GET['content'];
		if (is_array ( $newpost )) {
			$newpost['uid'] = $this->uid;
			$newpost['username'] = $this->username;
			if (empty($newpost['title']) || !isset($newpost['title'])){
				$this->showError('title_empty');
			}
			if (!$newpost['catid']){
				$this->showError('category_empty');
			}
			$where['id'] = $id;
			if (!$this->account['adminid']){
				$where['uid'] = $this->uid;
			}
				
			$newpost['modified'] = TIMESTAMP;
			$newpost['author']   = isset($newpost['author']) && !empty($newpost['author']) ? $newpost['author'] : $this->username;
			$newpost['from']     = isset($newpost['from']) ? $newpost['from'] : '';
			$newpost['fromurl']  = isset($newpost['fromurl']) ? $newpost['fromurl'] : '';
			$newpost['tags'] = $newpost['tags'] ? serialize($newpost['tags']) : '';
			$newpost['allowcomment'] = isset($newpost['allowcomment']) ? trim($newpost['allowcomment']) : 1;
			$newpost['summary'] = $newpost['summary'] ? $newpost['summary'] : '';
			$newpost['summary'] = $newpost['summary'] ? $newpost['summary'] : cutstr(stripHtml($content), 400);
			$newpost['summary'] = str_replace('&amp;', '&', $newpost['summary']);
			$newpost['summary'] = str_replace('&nbsp;', '', $newpost['summary']);
			$newpost['summary'] = preg_replace('/\s|　/', '', $newpost['summary']);
			$this->t('post_title')->where($where)->update($newpost);
			$this->t('post_content')->where(array('aid'=>$id))->delete();
			if (!in_array($newpost['type'], array('image','video','music','goods','active'))){
				$newpost['type'] = 'article';
			}
			if ($newpost ['type'] == 'article') {
				$content = $content ? $content : $_GET['content'];
				$contentlist = preg_split('/###Pagebreak###/', $content);
				if (count($contentlist) == 1){
					$contentarray = array(
							'aid'=>$id,
							'catid'=>$newpost['catid'],
							'content'=>$content,
							'pageorder'=>1,
							'dateline'=>time()
					);
					$this->t('post_content')->insert($contentarray);
				}else {
					foreach ($contentlist as $key=>$value){
						$contentarray = array(
								'aid'=>$id,
								'catid'=>$newpost['catid'],
								'content'=>$value,
								'pageorder'=>$key+1,
								'dateline'=>time()
						);
						$this->t('post_content')->insert($contentarray);
					}
				}
		
			}
			if ($newpost ['type'] == 'image') {
				$piclist = isset($_GET['piclist']) ? $_GET['piclist'] : array();
				if (!empty($piclist)){
					$content = serialize($piclist);
					$contentarray = array(
							'aid'=>$id,
							'catid'=>$newpost['catid'],
							'content'=>$content,
							'pageorder'=>1,
							'dateline'=>time()
					);
					$this->t('post_content')->insert($contentarray);
				}
		
			}
		
			if ($newpost ['type'] == 'video') {
				$videourl = trim ( $_GET['videourl'] );
				if ($videourl) {
					$videodata = \Core\ParseVideoUrl::ParseUrl ($videourl);
					$videodata['content'] = $content ? $content : trim($_GET['content']);
					$content = serialize($videodata);
					$contentarray = array(
							'aid'=>$id,
							'catid'=>$newpost['catid'],
							'content'=>$content,
							'pageorder'=>1,
							'dateline'=>time()
					);
					$this->t('post_content')->insert($contentarray);
					if (empty($newpost['pic'])){
						$this->t('post_title')->where(array('id'=>$id))->update(array('pic'=>$videodata['img']));
					}
				}
			}
		
			if ($newpost ['type'] == 'music') {
				$musicarray['songs']   = trim ($_GET['songs']);
				$musicarray['content'] = $content ? $content : $_GET['content'];
				$content = serialize($musicarray);
				$contentarray = array(
						'aid'=>$id,
						'catid'=>$newpost['catid'],
						'content'=>$content,
						'pageorder'=>1,
						'dateline'=>time()
				);
				$this->t('post_content')->insert($contentarray);
			}
		
			if ($newpost['type'] == 'goods'){
				$attributelist = isset($_GET['attribute']) ? $_GET['attribute'] : array();
				foreach ($attributelist as $attribute){
					$attribute['aid'] = $id;
					$this->t('post_goods_attribute')->insert($attribute);
				}
				$content = $content ? $content : $_GET['content'];
				$contentarray = array(
						'aid'=>$id,
						'catid'=>$newpost['catid'],
						'content'=>$content,
						'pageorder'=>1,
						'dateline'=>time()
				);
				$this->t('post_content')->insert($contentarray);
			}
		
			if ($newpost['type'] == 'active'){
				$active = isset($_GET['active']) ? $_GET['active'] : array('begin'=>time(),'end'=>'');
				$active['aid'] = $id;
				$active['begin'] = strtotime($active['begin']);
				$active['end'] = strtotime($active['end']);
				$this->t('post_active')->insert($active);
				$content = $content ? $content : $_GET['content'];
				$contentarray = array(
						'aid'=>$id,
						'catid'=>$newpost['catid'],
						'content'=>$content,
						'pageorder'=>1,
						'dateline'=>time()
				);
				$this->t('post_content')->insert($contentarray);
			}
		
			$links = array (
					array (
							'text' => 'reedit',
							'url' => '/?m=admin&c=post&a=edit&id='.$id
					),
					array (
							'text' => 'view',
							'url' => '/?m=post&c=detail&id=' . $id,
							'target' => '_blank'
					)
			);
			$this->showSuccess('modi_succeed','', $links,'',true);
		} else {
			$this->showError( 'undefined_error' );
		}
	}
}