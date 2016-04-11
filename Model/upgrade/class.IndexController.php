<?php
namespace Upgrade;
use Core\Controller;
class IndexController extends Controller{
	public function index(){
		global $G,$lang;
		include template('index');
	}
	
	public function article(){
		echo 'http://www.pxjd.org/api.php?page='.G('page');
		$json = file_get_contents('http://www.pxjd.org/api.php?page='.G('page'));
		//echo $json;exit();
		$array = json_decode($json,true);
		if ($array){
			foreach ($array as $arr){
				$title = array(
						'id'=>$arr['id'],
						'catid'=>$arr['cid'],
						'title'=>$arr['title'],
						'pic'=>$arr['image'],
						'summary'=>$arr['summary'] ? $arr['summary'] : cutstr(stripHtml($arr['content']), 200),
						'uid'=>$arr['authorid'],
						'username'=>$arr['author'],
						'author'=>$arr['author'],
						'pubtime'=>(strpos($arr['dateline'], '-')===false) ? $arr['dateline'] : strtotime($arr['dateline']),
						'type'=>'article',
						'viewnum'=>$arr['views']
				);
				$content = array(
						'aid'=>$title['id'],
						'catid'=>$title['catid'],
						'content'=>daddslashes($arr['content']),
						'dateline'=>$title['pubtime'],
						'pageorder'=>1
				);
				$this->t('post_title')->insert($title);
				$this->t('post_content')->insert($content);
				print_array($title);
				print_array($content);
				
			}
			echo '<script>setTimeout(function(){window.location="/?m=upgrade&c=index&a=article&page='.(G('page')+1).'";},2000);</script>';
		}else {
			echo 'complete!';
		}
	}
	
	public function articlecat(){
		$json = file_get_contents('http://www.pxjd.org/api.php');
		$array = json_decode($json,true);
		if ($array){
			
		}
	}
	
	public function video(){
		$json = file_get_contents('http://www.pxjd.org/api.php');
		$array = json_decode($json,true);
		if ($array){
			foreach ($array as $arr){
				$title = array(
						'catid'=>8,
						'title'=>$arr['title'],
						'pic'=>$arr['image'],
						'summary'=>$arr['summary'],
						'uid'=>$arr['authorid'],
						'username'=>$arr['author'],
						'author'=>$arr['author'],
						'pubtime'=>(strpos($arr['dateline'], '-')===false) ? $arr['dateline'] : strtotime($arr['dateline']),
						'type'=>'video',
						'viewnum'=>$arr['views']
				);
				$id = $this->t('post_title')->insert($title,true);
				$videodata = array(
						'img'=>$title['pic'],
						'tit'=>$title['title'],
						'url'=>$arr['linkurl'],
						'swf'=>$arr['videourl'],
						'content'=>daddslashes($arr['content'])
				);
				$content = array(
						'aid'=>$id,
						'catid'=>8,
						'content'=>serialize($videodata),
						'dateline'=>$title['pubtime'],
						'pageorder'=>1
				);
				//$this->t('post_title')->insert($title);
				$this->t('post_content')->insert($content);
				print_array($title);
				print_array($content);
			}
		}
		echo 'complete!';
	}
	
	public function image(){
		$json = file_get_contents('http://www.pxjd.org/api.php');
		$array = json_decode($json,true);
		if ($array){
			foreach ($array as $arr){
				$title = array(
						'catid'=>110,
						'title'=>$arr['title'],
						'pic'=>$arr['image'],
						'summary'=>$arr['summary'],
						'uid'=>$arr['authorid'],
						'username'=>$arr['author'],
						'author'=>$arr['author'],
						'pubtime'=>(strpos($arr['dateline'], '-')===false) ? $arr['dateline'] : strtotime($arr['dateline']),
						'type'=>'image',
						'viewnum'=>$arr['views']
				);
				print_array($title);
				$id = $this->t('post_title')->insert($title,true);
				$piclist = $arr['files'];
				$picdata = array();
				if ($piclist){
					foreach ($piclist as $pic){
						
						$photoid = $this->t('photo')->insert(array(
								'title'=>$arr['title'],
								'name'=>$pic['filename'],
								'attachment'=>$pic['attachment'],
								'thumb'=>$pic['thumbnail'],
								'uptime'=>$pic['dateline']
						));
						
						$picdata[] = array(
								'photoid'=>$photoid,
								'thumb'=>$pic['thumbnail'],
								'attachment'=>$pic['attachment']
						);
					}
				}
				print_array($picdata);
				$content = array(
						'aid'=>$id,
						'catid'=>110,
						'content'=>serialize($picdata),
						'dateline'=>$title['pubtime'],
						'pageorder'=>1
				);
				//$this->t('post_title')->insert($title);
				$this->t('post_content')->insert($content);
				
				print_array($content);
			}
		}
		echo 'complete!';
	}
}