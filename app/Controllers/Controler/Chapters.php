<?php namespace App\Controllers\Controler;

use \CodeIgniter\HTTP\Files\UploadedFile;
use App\Models\Chapters as ChaptersModel;
use App\Models\Design as DesignModel;
use App\Models\Moduls as ModulsModel;
use App\Models\Languages as LanguagesModel;
use App\Models\Articles as ArticlesModel;
use App\Models\Gallery as GalleryModel;
use App\Models\Faqs as FaqsModel;
use App\Models\Comments as CommentsModel;
use App\Models\Slider as SliderModel;
use App\Models\Compmenu as CompmenuModel;
use App\Models\Feedback as FeedbackModel;
use App\Models\Polls as PollsModel;
use App\Models\Config as ConfigModel;

class Chapters extends Base
{
	public function index($inPage='add',$id=0,$ctChapterPage=0)
	{
		
		if (!$this->controlTest('chapters')) { $inPage='false'; } 
		$session = session();
		
		$list = $this->getList('chapters',$inPage);
		if (($inPage=='list')OR($inPage=='artcomments')) { $session->set('ctChapterPage',$ctChapterPage); }
		
		$ChaptersModel = new ChaptersModel;
		$ArticlesModel = new ArticlesModel;
		
		$list['chapters'] = $ChaptersModel->orderBy('parent ASC, number ASC, name ASC')->find();
		$ctChapterTree='';
		if ($id!=0) {
			$list['chapter'] = $ChaptersModel->where('chapterId',$id)->first();
			if (!isset($list['chapter']['chapterId'])) { echo 2;
				redirect('/page404');
			}
			if ($inPage=='artcomments') {
				$list['article'] = $ArticlesModel->where('articleId',$id)->first();
				$list['chapter'] = $ChaptersModel->where('chapterId',$list['article']['parent'])->first();
				$id = $list['chapter']['chapterId'];
			}
			if (isset($list['chapter']['chapterId'])) { 
				$ctChapterTree = $list['chapter']['tree'].'|'.$id.'|'; 
				$list['sitChapters'] = $ChaptersModel->getSitChapters('chapterId',$id);
			} 
			if ($inPage=='advanced') {
				$DesignModel = new DesignModel;
				$list['themes'] = $DesignModel->getThemes();
			}
			if ($inPage=='composite') {
				$CompmenuModel = new CompmenuModel;
				$list['compmenu'] = $CompmenuModel->where('chapterId',$id)->orderBy ('number','ASC')->find();
				$i=0;
				foreach ($list['compmenu'] as $one):
					$list['compmenu'][$i]['chapter'] = $ChaptersModel->where('chapterId',$one['menuId'])->first();
					$i++;
				endforeach;
			}
			if ($inPage=='slider') {
				$SliderModel = new SliderModel;
				$list['sliders'] = $SliderModel->orderBy('number','ASC')->where('chapterId',$id)->find();
			}
			if ($inPage=='situation') {
				$FeedbackModel = new FeedbackModel;
				$PollsModel = new PollsModel;
				$ModulsModel = new ModulsModel;
				$list['banChapters'] = $ChaptersModel->getBanChapters('chapterId',$id);
				$list['feedbacks'] = $FeedbackModel->findAll();
				$list['polls'] = $PollsModel->findAll ();
				$list['artChapters'] = $ChaptersModel->where('type','articles')->find();
				$list['galChapters'] = $ChaptersModel->where('type','gallery')->find();
				$list['moduls'] = $ModulsModel->findAll();
			}
			if ($inPage=='list') {
				if ($list['chapter']['type']=='articles') {
					$list['articles'] = $ArticlesModel->getArticles($list['chapter']['chapterId'],$ctChapterPage,$list['chapter']['sort'],$list['chapter']['perPage'],0,'page');
					$list['coun'] = $ArticlesModel->getArticles($list['chapter']['chapterId'],$ctChapterPage,$list['chapter']['sort'],$list['chapter']['perPage'],0,'coun');
				}
				if ($list['chapter']['type']=='gallery') {
					$GalleryModel = new GalleryModel;
					$list['gallerys'] = $GalleryModel->getGallerys($list['chapter']['chapterId'],$ctChapterPage,$list['chapter']['perPage'],'page');
					$list['coun'] = $GalleryModel->getGallerys($list['chapter']['chapterId'],$ctChapterPage,$list['chapter']['perPage'],'coun');
				}
				if ($list['chapter']['type']=='comments') {
					$CommentsModel = new CommentsModel;
					$list['comments'] = $CommentsModel->getComments($list['chapter']['chapterId'],$ctChapterPage,$list['chapter']['perPage'],0,'page');
					$list['coun'] = $CommentsModel->getComments($list['chapter']['chapterId'],$ctChapterPage,$list['chapter']['perPage'],0,'coun');
				}
				if ($list['chapter']['type']=='faq') {
					$FaqsModel = new FaqsModel;
					$list['faqs'] = $FaqsModel->getFaqs($list['chapter']['chapterId'],$ctChapterPage,$list['chapter']['perPage'],0,'page');
					$list['coun'] = $FaqsModel->getFaqs($list['chapter']['chapterId'],$ctChapterPage,$list['chapter']['perPage'],0,'coun');
				}
			}
			if ($inPage=='editarticle') {
				$list['article'] = $ArticlesModel->where('articleId',$ctChapterPage)->first();
				if (!isset($list['article']['articleId'])) {
					redirect('/page404');
				}
			}
			if ($inPage=='artcomments') {
				$CommentsModel = new CommentsModel;
				$list['comments'] = $CommentsModel->getArCommentsCt($list['article']['articleId'],session('ctChapterPage'),$list['chapter']['perPage'],0,'page');
				$list['coun'] = $CommentsModel->getArCommentsCt($list['article']['articleId'],session('ctChapterPage'),$list['chapter']['perPage'],0,'coun');
			}
		}
		
		$list['setup']['ctChapterTree'] = $ctChapterTree;	
		$list['setup']['ctChapterPage'] = session('ctChapterPage');
		
		$data['list']=(object)$list;
		
		echo view($this->path.'top',$data);
		echo view($this->path.'chapters',$data);
		
	}
	
	function testChapterUrl () {
	
		if (!$this->controlTest('chapters')) { exit; }
		$ChaptersModel = new ChaptersModel;
		echo $ChaptersModel->where(['chapterId !=' => $_POST['chapterId'], 'url' => $_POST['url']])->countAllResults();
	
	}
	
	function addChapter () {
	
		if (!$this->controlTest('chapters')) { exit; } 
		$ChaptersModel = new ChaptersModel;
		helper ('nespi');
		
		$name = str_replace ('"','\'\'',$_POST['name']);
		
		if ($_POST['url']=='') {
			$url = makeUrl($name);
			$newChapterUrl = $url;
			$testUrl=1; 
			while ($testUrl!=0) {
				$testUrl = $ChaptersModel->where(['chapterId !=' => '0', 'url' => $newChapterUrl])->countAllResults();
				if ($testUrl!=0) { $newChapterUrl = $url.getSameString($col=5); }
			}
			$url = $newChapterUrl;
		} else { $url=$_POST['url']; }
				
		if ($_POST['parent']!=0) {
			$chapter = $ChaptersModel->where('chapterId',$_POST['parent'])->first();
			$tree = $chapter['tree'].'|'.$_POST['parent'].'|';
		} else { $tree=''; }
				
		$data = array (
			'name'.session('languageBase') => $name, 
			'url' => $url, 
			'tree' => $tree, 
			'type' => $_POST['type'], 
			'parent' => $_POST['parent'], 
			'number' => $_POST['number'], 
			'lastmod' => date('c',time()),
			'title'.session('languageBase') => $_POST['title'], 
			'description'.session('languageBase') => $_POST['description'], 
			'keywords'.session('languageBase') => $_POST['keywords']
		); 
		if (isset($_POST['visible'])) { $data['visible']=1; } else { $data['visible']=0; }
				
		$ChaptersModel->insert($data);
				
		$chapter = $ChaptersModel->where('url',$data['url'])->first();
		
		$ChaptersModel->addSitChapterStart($chapter['chapterId']);
		$ChaptersModel->addBanChapterStart($chapter['chapterId']);
		
		$this->sitemap();
			
		redirect ('/controler/chapters/index/text/'.$chapter['chapterId']);
		
			
	}
	
	function editChapter () {
	
		if (!$this->controlTest('chapters')) { exit; } 
		$ChaptersModel = new ChaptersModel;
		$GalleryModel = new GalleryModel;
		$ArticlesModel = new ArticlesModel;
		$FaqsModel = new FaqsModel;
		$CommentsModel = new CommentsModel;
		helper ('nespi');
		$session = session();
		
		if ($_POST['parent']==$_POST['chapterId']) {
			$session->set('message',Error_transfer_chapter); 
			redirect ('/controler/chapters/index/edit/'.$_POST['chapterId']);
		}
			
		$chapter = $ChaptersModel->where('chapterId',$_POST['chapterId'])->first();
		$_POST['oldtype'] = $chapter['type'];
		
		$name = str_replace ('"','\'\'',$_POST['name']);
			
		if ($_POST['url']=='') {
			$url = makeUrl($name);
			$newChapterUrl = $url;
			$testUrl=1; 
			while ($testUrl!=0) {
				$testUrl = $ChaptersModel->where(['chapterId !=' => $_POST['chapterId'], 'url' => $newChapterUrl])->countAllResults();
				if ($testUrl!=0) { $newChapterUrl = $url.getSameString($col=5); }
			}
			$url = $newChapterUrl;
		} else { $url=$_POST['url']; }
			
		$data = array (
			'name'.session('languageBase') => $name, 
			'url' => $url, 
			'parent' => $_POST['parent'], 
			'number' => $_POST['number'], 
			'type' => $_POST['type'], 
			'lastmod' => date('c',time()),
			'title'.session('languageBase') => $_POST['title'], 
			'description'.session('languageBase') => $_POST['description'], 
			'keywords'.session('languageBase') => $_POST['keywords']
		);
		if (isset($_POST['visible'])) { $data['visible']=1; } else { $data['visible']=0; }
		
		if ($_POST['parent']!=$chapter['parent']) {
				
			if ($_POST['parent']!=0) {
				$chapter = $ChaptersModel->where('chapterId',$_POST['parent'])->first();
				$tree = $chapter['tree'].'|'.$_POST['parent'].'|';
			} else { $tree=''; }
			$data['tree'] = $tree;
				
			$ChaptersModel->update($_POST['chapterId'],$data);
					
			$this->checkNewParent($_POST['chapterId'],$tree);
				
			$gallerys = $GalleryModel->like('tree','|'.$_POST['chapterId'].'|')->find();
			foreach ($gallerys as $one) {
				$chapter = $ChaptersModel->where('chapterId',$one['parent'])->first();
				$datatemp = array ('tree' => $chapter['tree'].'|'.$chapter['chapterId'].'|', 'galleryId' => $one['galleryId']);
				$GalleryModel->update($one['galleryId'],$datatemp);
				unset ($datatemp);
			}	
			
			$articles = $ArticlesModel->like('tree','|'.$_POST['chapterId'].'|')->find();
			foreach ($articles as $one):
				$chapter = $ChaptersModel->where('chapterId',$one['parent'])->first();
				$datatemp = array ('tree' => $chapter['tree'].'|'.$chapter['chapterId'].'|', 'articleId' => $one['articleId']);
				$ArticlesModel->update($one['articleId'],$datatemp);
				unset ($datatemp);
				$articleId = $one['articleId'];
				$ArticlesModel->delArtChapbyArt($articleId);
				$dataArtChap = array(
					'articleId' => $articleId,
					'chapterId' => $chapter['chapterId']
				);
				$ArticlesModel->addArtChap($dataArtChap);
				$this->articlesTreeBuilder($chapter['parent'],$articleId);
			endforeach;	
				
			$comments = $CommentsModel->like('tree','|'.$_POST['chapterId'].'|')->find();
			foreach ($comments as $one):
				$chapter = $ChaptersModel->where('chapterId',$one['parent'])->first();
				$datatemp = array ('tree' => $chapter['tree'].'|'.$chapter['chapterId'].'|', 'commentId' => $one['commentId']);
				$CommentsModel->update($one['commentId'],$datatemp);
				unset ($datatemp);
				$commentId = $one['commentId'];
				$CommentsModel->delComChapbyCom($commentId);
				$dataComChap = array(
					'commentId' => $commentId,
					'chapterId' => $chapter['chapterId']
				);
				$CommentsModel->addComChap($dataComChap);
				$this->commentsTreeBuilder($chapter['parent'],$commentId);
			endforeach;	
				
			$faqs = $FaqsModel->like('tree','|'.$_POST['chapterId'].'|')->find();
			foreach ($faqs as $one):
				$chapter = $ChaptersModel->where('chapterId',$one['parent'])->first();
				$datatemp = array ('tree' => $chapter['tree'].'|'.$chapter['chapterId'].'|', 'faqId' => $one['faqId']);
				$FaqsModel->update($one['faqId'],$datatemp);
				unset ($datatemp);
				$faqId = $one['faqId'];
				$FaqsModel->delFaqChapbyFaq($faqId);
				$dataFaqChap = array(
					'faqId' => $faqId,
					'chapterId' => $chapter['chapterId']
				);
				$FaqsModel->addFaqChap($dataFaqChap);
				$this->faqTreeBuilder($chapter['parent'],$faqId);
			endforeach;	
				
		} else {

			$ChaptersModel->update($_POST['chapterId'],$data);

		}	

		unset($data);
				
		if (($chapter['type']=='articles')AND($_POST['type']!='articles')) {
			$ArticlesModel->turnOffArticle($_POST['chapterId']);
		}
		if (($chapter['type']=='gallery')AND($_POST['type']!='gallery')) {
			$GalleryModel->turnOffGallery($_POST['chapterId']);
		}
		if ($chapter['sitemap']==1) { $this->sitemap(); }
			
		$session->set('message',Saved); 
		redirect ('/controler/chapters/index/edit/'.$_POST['chapterId']);

	}	
	
	function checkNewParent ($chapterId,$tree) {
	
		if (!$this->controlTest('chapters')) { exit; } 
		$ChaptersModel = new ChaptersModel;
		
		$chapters = $ChaptersModel->where('parent',$chapterId)->find();
		foreach ($chapters as $one):
			$datatemp = array ('tree' => $tree.'|'.$chapterId.'|', 'chapterId' => $one['chapterId']);
			$ChaptersModel->update($one['chapterId'],$datatemp);
			unset ($datatemp);
			$this->checkNewParent($one['chapterId'],$tree.'|'.$chapterId.'|');
		endforeach;
					
	}
	
	function articlesTreeBuilder ($chapterId,$articleId) {
	
		if (!$this->controlTest('chapters')) { exit; } 
		$ChaptersModel = new ChaptersModel;
		$ArticlesModel = new ArticlesModel;
		
		if ($chapterId!=0) {
			$chapter = $ChaptersModel->where('chapterId',$chapterId)->first();
			$dataArtTree = array(
				'articleId' => $articleId,
				'chapterId' => $chapter['chapterId']
			);
			$ArticlesModel->addArtChap($dataArtTree);
			$this->articlesTreeBuilder($chapter['parent'],$articleId);
		}			
	
	}
	
	function commentsTreeBuilder ($chapterId,$commentId) {
	
		if (!$this->controlTest('chapters')) { exit; } 
		$ChaptersModel = new ChaptersModel;
		$CommentsModel = new CommentsModel;
		
		if ($chapterId!=0) {
			$chapter = $ChaptersModel->where('chapterId',$chapterId)->first();
			$dataComTree = array(
				'commentId' => $commentId,
				'chapterId' => $chapter['chapterId']
			);
			$CommentsModel->addComChap($dataComTree);
			$this->commentsTreeBuilder($chapter['parent'],$commentId);
		}			
	
	}
	
	function faqTreeBuilder ($chapterId,$faqId) {
	
		if (!$this->controlTest('chapters')) { exit; } 
		$ChaptersModel = new ChaptersModel;
		$FaqsModel = new FaqsModel;
		
		if ($chapterId!=0) {
			$chapter = $ChaptersModel->where('chapterId',$chapterId)->first();
			$dataFaqTree = array(
				'faqId' => $faqId,
				'chapterId' => $chapter['chapterId']
			);
			$FaqsModel->addFaqChap($dataFaqTree);
			$this->faqTreeBuilder($chapter['parent'],$faqId);
		}			
	
	}
	
	function delChapter () {
		
		if (!$this->controlTest('chapters')) { exit; } 
		$this->deleteChapter($_POST['id']);
		echo '/controler/chapters';
		
	}
	
	function deleteChapter ($chapterId=0) {
		
		if (!$this->controlTest('chapters')) { exit; } 
		$ChaptersModel = new ChaptersModel;
		$GalleryModel = new GalleryModel;
		$ArticlesModel = new ArticlesModel;
		$CommentsModel = new CommentsModel;
		$FaqsModel = new FaqsModel;
		$SliderModel = new SliderModel;
		$CompmenuModel = new CompmenuModel;
		
		$chapters = $ChaptersModel->like('tree','|'.$chapterId.'|')->find();
		foreach ($chapters as $one) {
			$this->deleteChapter($one['chapterId']);
		}
		
		$chapter = $ChaptersModel->where('chapterId',$chapterId)->first();
		
		if (file_exists($chapter['preview'])) { unlink($chapter['preview']); }
		
		if ($chapter['type']=='articles') { $ArticlesModel->turnOffArticle($chapterId); }
		if ($chapter['type']=='gallery') { $GalleryModel->turnOffGallery($chapterId); }
		
		$articles = $ArticlesModel->like('tree','|'.$chapterId.'|')->find();
		foreach ($articles as $one):
			if (file_exists($one['preview'])) { unlink($one['preview']); }
			$CommentsModel->where('articleId',$one['articleId'])->delete();
			$ArticlesModel->delete($one['articleId']);
		endforeach;
		$ChaptersModel->delArtChapbyChap($chapterId);
		
		$gallerys = $GalleryModel->like('tree','|'.$chapterId.'|')->find();
		foreach ($gallerys as $one):
			if (file_exists($one['previewsm'])) { unlink($one['previewsm']); }
			if (file_exists($one['previewbg'])) { unlink($one['previewbg']); }
			$GalleryModel->delGallery($one['galleryId']);
		endforeach;
		
		$comments = $CommentsModel->like('tree','|'.$chapterId.'|')->find();
		foreach ($comments as $one):
			$CommentsModel->delete($one['commentId']);
		endforeach;
		$ChaptersModel->delComChapbyChap($chapterId);
		
		$faqs = $FaqsModel->like('tree','|'.$chapterId.'|')->find();
		foreach ($faqs as $one):
			$FaqsModel->delete($one['faqId']);
		endforeach;
		$ChaptersModel->delFaqChapbyChap($chapterId);
		
		$sliders = $SliderModel->where('chapterId',$chapterId)->find();
		foreach ($sliders as $one):
			if (file_exists($one['preview'])) {
				unlink($one['preview']);
			}
		endforeach;
		$SliderModel->where('chapterId',$chapterId)->delete();
		
		$CompmenuModel->where('chapterId',$chapterId)->delete();
		$CompmenuModel->where('menuId',$chapterId)->delete();
		$ChaptersModel->delBanChapters($chapterId);
		$ChaptersModel->delSitChapters($chapterId);
		
		$ChaptersModel->delete($chapterId);
		
	}
	
	function editChapterText () {
	
		if (!$this->controlTest('chapters')) { exit; } 
		$session = session();
		$ChaptersModel = new ChaptersModel;
		
		$data = array (
			'text'.session('languageBase') => $_POST['text'],
			'lastmod' => date('c',time()),
		);
		$ChaptersModel->update($_POST['chapterId'],$data);
				
		$this->sitemap();
				
		$session->set('message',Saved); 
		redirect ('/controler/chapters/index/text/'.$_POST['chapterId']);
			
	}
	
	function editChapterTextShort () {
	
		if (!$this->controlTest('chapters')) { exit; } 
		$session = session();
		$ChaptersModel = new ChaptersModel;
		
		$data = array (
			'lastmod' => date('c',time()),
			'info'.session('languageBase') => $_POST['info'],
		);
		$ChaptersModel->update($_POST['chapterId'],$data);
				
		$this->sitemap();
				
		$session->set('message1',Saved); 
		redirect ('/controler/chapters/index/text/'.$_POST['chapterId']);
			
	}
	
	function changeBannerView () {
	
		if (!$this->controlTest('chapters')) { exit; } 
		$session = session();
		$session->set('adverbannerview',$_POST['type']);
			
	}
	
	function editSituation ($all='') {
	
		if (!$this->controlTest('chapters')) { exit; } 
		$DesignModel = new DesignModel;
		$ChaptersModel = new ChaptersModel;
		$session = session();
		
		$temp = $DesignModel->getSiteTemp();
		
		foreach ($temp as $one):
			if ((isset($_POST[$one]))AND($_POST[$one]!='')) {		
				$data = array (
					'chapterId' => $_POST['id'],
					'name' => $one,
					'param' => preg_replace("/[^_\-A-Za-z\s]/",'',$_POST[$one]),
					'bodyId' => preg_replace("/[^0-9\s]/",'',$_POST[$one])
				);
				if (strpos($data['param'],'my_')!==FALSE) { $data['param']=$_POST[$one]; $data['bodyId']=''; }
				$sitChapter = $ChaptersModel->getSitChapter(array('chapterId','name'),array($_POST['id'],$one));
				if (isset($sitChapter['id'])) {
					$data['id'] = $sitChapter['id'];
					$ChaptersModel->editSitChapter($data);
				} else {
					$ChaptersModel->addSitChapter($data);
				}
				unset($data);
			} else {
				$sitChapter = $ChaptersModel->getSitChapter(array('chapterId','name'),array($_POST['id'],$one));
				if (isset($sitChapter['id'])) {
					$ChaptersModel->delSitChapter($sitChapter['id']);
				}
			}
		endforeach;
		
		if ($all=='sub') {
			
			$chapters = $ChaptersModel->like ('tree','|'.$_POST['id'].'|')->find();
			
			foreach ($chapters as $cat) {
				foreach ($temp as $one):
					if ((isset($_POST[$one]))AND($_POST[$one]!='')) {		
						$data = array (
							'chapterId' => $cat['chapterId'],
							'name' => $one,
							'param' => preg_replace("/[^_\-A-Za-z\s]/",'',$_POST[$one]),
							'bodyId' => preg_replace("/[^0-9\s]/",'',$_POST[$one])
						);
						if (strpos($data['param'],'my_')!==FALSE) { $data['param']=$_POST[$one]; $data['bodyId']=''; }
						$sitChapter = $ChaptersModel->getSitChapter(array('chapterId','name'),array($cat['chapterId'],$one));
						if (isset($sitChapter['id'])) {
							$data['id'] = $sitChapter['id'];
							$ChaptersModel->editSitChapter($data);
						} else {
							$ChaptersModel->addSitChapter($data);
						}
						unset($data);
					} else {
						$sitChapter = $ChaptersModel->getSitChapter(array('chapterId','name'),array($cat['chapterId'],$one));
						if (isset($sitChapter['id'])) {
							$ChaptersModel->delSitChapter($sitChapter['id']);
						}
					}
				endforeach;
			}
			
		}
		
		$session->set('message',Saved); 
		redirect ('/controler/chapters/index/situation/'.$_POST['id']);
			
	}	
	
	function editBanner () {
	
		if (!$this->controlTest('chapters')) { exit; } 
		$LanguagesModel = new LanguagesModel;
		$ChaptersModel = new ChaptersModel;
		
		$languages = $LanguagesModel->orderBy('main DESC, number ASC')->find();
		
		$banChapter = $ChaptersModel->getBanChapter(array('chapterId','name'),array($_POST['id'],$_POST['banner']));
	
		if ($_POST['text']!='') {
			$data = array (
				'chapterId' => $_POST['id'],
				'name' => $_POST['banner'],
				'param'.session('languageBase') => $_POST['text']
			);
			if (isset($banChapter['id'])) {
				$data['id'] = $banChapter['id'];
				$ChaptersModel->editBanChapter($data);
			} else {
				$ChaptersModel->addBanChapter($data);
			}
			unset($data);
		} else {
			if (isset($banChapter['id'])) {
				$del=1;
				foreach ($languages as $one): 
					if ($one['url']!=str_replace('_','',session('languageBase'))) { 
						if ($one['url']!='') {
							if ($banChapter['param_'.$one['url']]!='') { $del=0; }
						} else {
							if ($banChapter['param']!='') { $del=0; }
						}
					}
				endforeach;
				if ($del==1) { 
					$ChaptersModel->delBanChapter($banChapter['id']);
				} else {
					$data = array (
						'chapterId' => $_POST['id'],
						'name' => $_POST['banner'],
						'param'.session('languageBase') => $_POST['text']
					);
					if (isset($banChapter['id'])) {
						$data['id'] = $banChapter['id'];
						$ChaptersModel->editBanChapter($data);
					} else {
						$ChaptersModel->addBanChapter($data);
					}
				}
			}
		}
		
		if ($_POST['all']==1) {
				
			$chapters = $ChaptersModel->like ('tree','|'.$_POST['id'].'|')->find();
			
			foreach ($chapters as $one) {
				$banChapter = $ChaptersModel->getBanChapter(array('chapterId','name'),array($one['chapterId'],$_POST['banner']));
				if ($_POST['text']!='') {
					$data = array (
						'chapterId' => $one['chapterId'],
						'name' => $_POST['banner'],
						'param'.session('languageBase') => $_POST['text']
					);
					if (isset($banChapter['id'])) {
						$data['id'] = $banChapter['id'];
						$ChaptersModel->editBanChapter($data);
					} else {
						$ChaptersModel->addBanChapter($data);
					}
					unset($data);
				} else {
					if (isset($banChapter['id'])) {
						$del=1;
						foreach ($languages as $two):
							if ($two['url']!=str_replace('_','',session('languageBase'))) {
								if ($two['url']!='') {
									if ($banChapter['param_'.$two['url']]!='') { $del=0; }
								} else {
									if ($banChapter['param']!='') { $del=0; }
								}
							}
						endforeach;
						if ($del==1) {
							$ChaptersModel->delBanChapter($banChapter['id']);
						} else {
							$data = array (
								'chapterId' => $one['chapterId'],
								'name' => $_POST['banner'],
								'param'.session('languageBase') => $_POST['text']
							);
							if (isset($banChapter['id'])) {
								$data['id'] = $banChapter['id'];
								$ChaptersModel->editBanChapter($data);
							} else {
								$ChaptersModel->addBanChapter($data);
							}
						}
					}
				}
			}
				
		}
			
	}
	
	function editAdvancedSettings () {
	
		if (!$this->controlTest('chapters')) { exit; } 
		$ChaptersModel = new ChaptersModel;
		$CompmenuModel = new CompmenuModel;
		$session = session();
		
		$chapter = $ChaptersModel->where('chapterId',$_POST['chapterId'])->first();
	
		if (isset($_POST['rating_count'])) { $data['rating_count']=$_POST['rating_count']; }
		if (isset($_POST['rating_votes'])) { $data['rating_votes']=$_POST['rating_votes']; 
			if ($_POST['rating_votes']>0) {
			$data['rating'] = $_POST['rating_count']/$_POST['rating_votes']; 
			} else {
			$data['rating']=0;
			}
		}
		if (isset($_POST['sliderWidth'])) { $data['sliderWidth']=$_POST['sliderWidth']; }
		if (isset($_POST['sliderHeight'])) { $data['sliderHeight']=$_POST['sliderHeight']; }
		if (isset($_POST['sliderFreq'])) { $data['sliderFreq']=$_POST['sliderFreq']; }
		if (isset($_POST['sort'])) { $data['sort']=$_POST['sort']; }
		if (isset($_POST['priority'])) { $data['priority']=$_POST['priority']; }
		if (isset($_POST['changefreq'])) { $data['changefreq']=$_POST['changefreq']; }
		if (isset($_POST['breed'])) { $data['breed']=$_POST['breed']; }
		if (isset($_POST['position'])) { $data['position']=$_POST['position']; }
		if (isset($_POST['link'])) { $data['link'.session('languageBase')]=$_POST['link']; }
		if (isset($_POST['subChapters'])) { $data['subChapters']=$_POST['subChapters']; }
		if (isset($_POST['perPage'])) { if ($_POST['perPage']==0) { $_POST['perPage']=1; } $data['perPage']=$_POST['perPage']; }
		if (isset($_POST['sliderForAll'])) { $data['sliderForAll']=1; } else { $data['sliderForAll']=0; }
		if (isset($_POST['blog'])) { $data['blog']=1; } else { $data['blog']=0; }
		if (isset($_POST['perPageCent'])) { if ($_POST['perPageCent']==0) { $_POST['perPageCent']=1; } $data['perPageCent']=$_POST['perPageCent']; }
		if (isset($_POST['perPageCol'])) { if ($_POST['perPageCol']==0) { $_POST['perPageCol']=1; } $data['perPageCol']=$_POST['perPageCol']; }
		if (isset($_POST['atView'])) { $data['atView']=$_POST['atView']; 
			if (($chapter['atView']==3)AND($_POST['atView']!=3)) {
				$CompmenuModel->where('chapterId',$_POST['chapterId'])->delete();
			}
		} 
		if (isset($_POST['head'])) { $data['head']=$_POST['head']; } 
		if (isset($_POST['sliderFix'])) { $data['sliderFix']=1; } else { { $data['sliderFix']=0; }  }
		if (isset($_POST['sliderCoef'])) { $data['sliderCoef']=$_POST['sliderCoef']; } 
		if (isset($_POST['addClass'])) { $data['addClass']=$_POST['addClass']; } 
		if (isset($_POST['theme'])) { $data['theme']=$_POST['theme']; } 
		if (isset($_POST['sitemap'])) { $data['sitemap']=1; } else { $data['sitemap']=0; }
		
		$ChaptersModel->update($_POST['chapterId'],$data);
			
		$session->set('message',Saved); 
		redirect ('/controler/chapters/index/advanced/'.$_POST['chapterId']);
			
	}
	
	function editChapterPreview () {
	
		if (!$this->controlTest('chapters')) { exit; } 
		$ChaptersModel = new ChaptersModel;
		$session = session();
		
		if ($this->request->getFiles('userfile')) {
			$userfile = $this->request->getFiles('userfile');
			$file = $userfile['userfile'];
			
			if ($file->isValid() && ! $file->hasMoved()) {
         
				if ((mb_strtolower($file->getClientExtension())=='jpg')OR($file->getClientExtension()=='png')OR($file->getClientExtension()=='jpeg')OR($file->getClientExtension()=='gif')OR($file->getClientExtension()=='svg')) {
					
					$randomName = $file->getRandomName();
					$file->move('img/chapters', $randomName);
					$preview = 'img/chapters/'.$randomName;
					
					$chapter = $ChaptersModel->where('chapterId',$_POST['chapterId'])->first();
					if (file_exists($chapter['preview'])) {
						unlink($chapter['preview']);
					}
					
					$data = array ('preview' => $preview);
					$ChaptersModel->update($_POST['chapterId'],$data);
					
					$session->set('message1',Saved); 
					
				} else {
					
					$session->set('message1',Wrong_file_format); 
					
				}
			
			} else {
				
				$session->set('message1',$file->getError()); 
				
			}
			
		}
		
		redirect ('/controler/chapters/index/advanced/'.$_POST['chapterId']);
			
	}
	
	function delChapterPreview () {
	
		if (!$this->controlTest('chapters')) { exit; } 
		$ChaptersModel = new ChaptersModel;
		
		$chapter = $ChaptersModel->where('chapterId',$_POST['id'])->first();
		if (file_exists($chapter['preview'])) {
			unlink($chapter['preview']);
		}
		$data = array ('preview' => '');
		$ChaptersModel->update($_POST['id'],$data);
			
	}
	
	function addGallery () {
	
		if (!$this->controlTest('chapters')) { exit; } 
		$ChaptersModel = new ChaptersModel;
		$GalleryModel = new GalleryModel;
		$ConfigModel = new ConfigModel;
		$session = session();
		
		$text = str_replace ('"','\'\'',$_POST['text']);
				
		$smWidth = $ConfigModel->giveConfParam('gallerySmWidth');
		$smHeight = $ConfigModel->giveConfParam('gallerySmHeight');
				
		$chapter = $ChaptersModel->where('chapterId',$_POST['chapterId'])->first();
		$tree = $chapter['tree'].'|'.$_POST['chapterId'].'|';
		
		$data = array (
			'text'.session('languageBase') => $text, 
			'tree' => $tree, 
			'parent' => $_POST['chapterId'], 
			'link'.session('languageBase') => $_POST['link'], 
			'number' => $_POST['number']
		);
		
		if ($this->request->getFiles('userfile')) {
			$userfile = $this->request->getFiles('userfile');
			$file = $userfile['userfile'];
			
			if ($file->isValid() && ! $file->hasMoved()) {
         
				if ((mb_strtolower($file->getClientExtension())=='jpg')OR($file->getClientExtension()=='png')OR($file->getClientExtension()=='jpeg')OR($file->getClientExtension()=='gif')OR($file->getClientExtension()=='svg')) {
					
					$randomName = $file->getRandomName();
					$file->move('img/gallery/prebg', $randomName);
					$preview = 'img/gallery/prebg/'.$randomName;
					
					$data['previewbg'] = $preview;
					
					$image = \Config\Services::image()
					->withFile($preview)
					->resize($smWidth, $smHeight, true, 'width')
					->save('img/gallery/presm/'.$randomName.'_thumb.jpg');
					
					$data['previewsm'] = 'img/gallery/presm/'.$randomName.'_thumb.jpg';
					
					$GalleryModel->insert($data);
					
					$message = Image_uploaded;
					
				} else { $session->set('message',Wrong_file_format);  }
			
			} else { $session->set('message',$file->getError());  }
			
		}	
		
		$session->set('message',$message); 
		redirect ('/controler/chapters/index/list/'.$_POST['chapterId']);
			
	}
	
	function editGallery () {
	
		if (!$this->controlTest('chapters')) { exit; } 
		$ChaptersModel = new ChaptersModel;
		$GalleryModel = new GalleryModel;
		helper ('nespi');
		$session = session();
		
		$text = str_replace ('"','\'\'',$_POST['text']);
		
		$chapter = $ChaptersModel->where('chapterId',$_POST['parent'])->first();
		$tree = $chapter['tree'].'|'.$_POST['parent'].'|';
		
		$data = array (
			'text'.session('languageBase') => $text, 
			'tree' => $tree, 
			'parent' => $_POST['parent'], 
			'link'.session('languageBase') => $_POST['link'], 
			'number' => $_POST['number']
		);
		$GalleryModel->update($_POST['galleryId'],$data);
				
		$session->set('message'.$_POST['galleryId'],Saved); 
		redirect ('/controler/chapters/index/list/'.$_POST['chapterId']);
			
	}
	
	function delGallery () {
	
		if (!$this->controlTest('chapters')) { exit; } 
		$GalleryModel = new GalleryModel;
		$gallery = $GalleryModel->where('galleryId',$_POST['id'])->first();
		if (file_exists($gallery['previewbg'])) {
			unlink($gallery['previewbg']);
		}
		if (file_exists($gallery['previewsm'])) {
			unlink($gallery['previewsm']);
		}
		$GalleryModel->delete($_POST['id']);
				
	}
	
	function addArticle () {
	
		if (!$this->controlTest('chapters')) { exit; } 
		$ChaptersModel = new ChaptersModel;
		$ArticlesModel = new ArticlesModel;
		helper ('nespi');
		$session = session();
		
		$name = str_replace ('"','\'\'',$_POST['name']);
		
		if ($_POST['url']=='') {
			$url = makeUrl($name);
			$newArticleUrl = $url;
			$testUrl=1; 
			while ($testUrl!=0) {
				$testUrl = $ArticlesModel->where(['articleId !=' => '0', 'url' => $newArticleUrl])->countAllResults();
				if ($testUrl!=0) { $newArticleUrl = $url.getSameString($col=5); }
			}
			$url = $newArticleUrl;
		} else { $url=$_POST['url']; }
				
		$chapter = $ChaptersModel->where('chapterId',$_POST['chapterId'])->first();
		$tree = $chapter['tree'].'|'.$_POST['chapterId'].'|';
						
		$data = array (
			'name'.session('languageBase') => $name, 
			'url' => $url, 
			'keywords'.session('languageBase') => $_POST['keywords'], 
			'description'.session('languageBase') => $_POST['description'], 
			'title'.session('languageBase') => $_POST['title'], 
			'tree' => $tree, 
			'lastmod' => date('c',time()),
			'parent' => $_POST['chapterId'], 
			'text'.session('languageBase') => $_POST['text'], 
			'info'.session('languageBase') => $_POST['info']
		);
		if ($chapter['blog']==1) { $data['blog']=1; } else { $data['blog']=0; }
		if (isset($_POST['visible'])) { $data['visible']=1; } else { $data['visible']=0; }
		if (isset($_POST['number'])) { 
			$data['number']=$_POST['number']; 
			$data['date']=date('U'); 
		} else {
			$array = explode('/',$_POST['date']);
			$data['date'] = date('U',mktime(0,0,0,$array[1],$array[0],$array[2]));
		}
			
		if ($this->request->getFiles('userfile')) {
			$userfile = $this->request->getFiles('userfile');
			$file = $userfile['userfile'];
			
			if ($file->isValid() && ! $file->hasMoved()) {
         
				if ((mb_strtolower($file->getClientExtension())=='jpg')OR($file->getClientExtension()=='png')OR($file->getClientExtension()=='jpeg')OR($file->getClientExtension()=='gif')OR($file->getClientExtension()=='svg')) {
					
					$randomName = $file->getRandomName();
					$file->move('img/articles', $randomName);
					$preview = 'img/articles/'.$randomName;
					
					$data['preview'] = $preview;
					
				} 
			
			}
			
		}	
			
		$ArticlesModel->insert($data);
				
		$this->sitemap();
				
		$article = $ArticlesModel->where('url',$data['url'])->first();
		
		$chapter = $ChaptersModel->where('chapterId',$_POST['chapterId'])->first();
		if (isset($chapter['chapterId'])) {
			$dataArtTree = array(
				'articleId' => $article['articleId'],
				'chapterId' => $chapter['chapterId']
			);
			$ArticlesModel->addArtChap($dataArtTree);
			$this->articlesTreeBuilder($chapter['parent'],$article['articleId']);
		}
				
		redirect ('/controler/chapters/index/editarticle/'.$_POST['chapterId'].'/'.$article['articleId']);
	
	}
	
	function editArticle () {
	
		if (!$this->controlTest('chapters')) { exit; } 
		$ChaptersModel = new ChaptersModel;
		$ArticlesModel = new ArticlesModel;
		helper ('nespi');
		$session = session();
		
		$name = str_replace ('"','\'\'',$_POST['name']);
		
		if ($_POST['url']=='') {
			$url = makeUrl($name);
			$newArticleUrl = $url;
			$testUrl=1; 
			while ($testUrl!=0) {
				$testUrl = $ArticlesModel->where(['articleId !=' => $_POST['articleId'], 'url' => $newArticleUrl])->countAllResults();
				if ($testUrl!=0) { $newArticleUrl = $url.getSameString($col=5); }
			}
			$url = $newArticleUrl;
		} else { $url=$_POST['url']; }
				
		$data = array (
			'changefreq' => $_POST['changefreq'], 
			'priority' => $_POST['priority'], 
			'rating_count' => $_POST['rating_count'], 
			'rating_votes' => $_POST['rating_votes'], 
			'lastmod' => date('c',time()),
			'name'.session('languageBase') => $name, 
			'url' => $url, 
			'keywords'.session('languageBase') => $_POST['keywords'], 
			'description'.session('languageBase') => $_POST['description'], 
			'title'.session('languageBase') => $_POST['title'], 
			'text'.session('languageBase') => $_POST['text'], 
			'info'.session('languageBase') => $_POST['info']
		);
		if ($data['rating_votes']>0) {
			$data['rating'] = $data['rating_count']/$data['rating_votes'];
		} else { $data['rating']=0; }
		if (isset($_POST['blog'])) { $data['blog']=1; } else { $data['blog']=0; }
		if (isset($_POST['visible'])) { $data['visible']=1; } else { $data['visible']=0; }
		if (isset($_POST['sitemap'])) { $data['sitemap']=1; } else { $data['sitemap']=0; }
		if (isset($_POST['number'])) { 
			$data['number']=$_POST['number']; 
		} else {
			$array = explode('/',$_POST['date']);
			$data['date'] = date('U',mktime(0,0,0,$array[1],$array[0],$array[2]));
		}
				
		if ($this->request->getFiles('userfile')) {
			$userfile = $this->request->getFiles('userfile');
			$file = $userfile['userfile'];
			
			if ($file->isValid() && ! $file->hasMoved()) {
         
				if ((mb_strtolower($file->getClientExtension())=='jpg')OR($file->getClientExtension()=='png')OR($file->getClientExtension()=='jpeg')OR($file->getClientExtension()=='gif')OR($file->getClientExtension()=='svg')) {
					
					$article = $ArticlesModel->where('articleId',$_POST['articleId'])->first();
					if (file_exists($article['preview'])) {
						unlink($article['preview']);
					}
					
					$randomName = $file->getRandomName();
					$file->move('img/articles', $randomName);
					$preview = 'img/articles/'.$randomName;
					
					$data['preview'] = $preview;
					
				} 
			
			}
			
		}	
			
		$ArticlesModel->update($_POST['articleId'],$data);
		
		if (isset($_POST['sitemap'])) { $this->sitemap(); }
		
		$session->set('message',Saved); 
		redirect ('/controler/chapters/index/editarticle/'.$_POST['chapterId'].'/'.$_POST['articleId']);
			
	}
	
	function delArticle () {
	
		if (!$this->controlTest('chapters')) { exit; }
		$ArticlesModel = new ArticlesModel;
		$CommentsModel = new CommentsModel;
		$ChaptersModel = new ChaptersModel;
		
		$article = $ArticlesModel->where('articleId',$_POST['id'])->first();
		if (file_exists($article['preview'])) {
			unlink($article['preview']);
		}
		$CommentsModel->where('articleId',$_POST['id'])->delete();
		$ArticlesModel->delArtChapbyArt($_POST['id']);
		$ArticlesModel->delete($_POST['id']);
			
	}
	
	function testArticleUrl () {
	
		if (!$this->controlTest('chapters')) { exit; }
		$ArticlesModel = new ArticlesModel;
		echo $ArticlesModel->where(['articleId !=' => $_POST['articleId'], 'url' => $_POST['url']])->countAllResults();
	
	}
	
	function changeArticleData () {
	
		if (!$this->controlTest('chapters')) { exit; }
		$data = array ($_POST['type'] => $_POST['param']);
		$ArticlesModel = new ArticlesModel;
		$ArticlesModel->update($_POST['articleId'],$data);
			
	}
	
	function changeArticleParent () {
	
		if (!$this->controlTest('chapters')) { exit; }
		$ChaptersModel = new ChaptersModel;
		$ArticlesModel = new ArticlesModel;
		
		$chapter = $ChaptersModel->where('chapterId',$_POST['chapterId'])->first();
		$tree = $chapter['tree'].'|'.$_POST['chapterId'].'|';
				
		$data = array (
			'parent' => $_POST['chapterId'], 
			'tree' => $tree
		);
		$ArticlesModel->update($_POST['articleId'],$data);
		
		$article = $ArticlesModel->where('articleId',$_POST['articleId'])->first();
		
		$ArticlesModel->delArtChapbyArt($article['articleId']);
		$chapter = $ChaptersModel->where('chapterId',$article['parent'])->first();
		if (isset($chapter['chapterId'])) {
			$dataArtTree = array(
				'articleId' => $article['articleId'],
				'chapterId' => $chapter['chapterId']
			);
			$ArticlesModel->addArtChap($dataArtTree);
			$this->articlesTreeBuilder($chapter['parent'],$article['articleId']);
		}
			
	}
	
	function addSlider () {
	
		if (!$this->controlTest('chapters')) { exit; }
	
		$SliderModel = new SliderModel;
		$session = session();
		
		if ($this->request->getFiles('userfile')) {
			$userfile = $this->request->getFiles('userfile');
			$file = $userfile['userfile'];
			
			if ($file->isValid() && ! $file->hasMoved()) {
         
				if ((mb_strtolower($file->getClientExtension())=='jpg')OR($file->getClientExtension()=='png')OR($file->getClientExtension()=='jpeg')OR($file->getClientExtension()=='gif')OR($file->getClientExtension()=='svg')) {
					
					$randomName = $file->getRandomName();
					$file->move('img/slider', $randomName);
					$preview = 'img/slider/'.$randomName;
		
					$data = array (
						'preview' => $preview, 
						'number' => $_POST['number'], 
						'link'.session('languageBase') => $_POST['link'], 
						'target' => $_POST['target'], 
						'visible' => 1, 
						'chapterId' => $_POST['chapterId']
					);
				
					$SliderModel->insert($data);
					
					$session->set('message',Added); 
					
				} else {
				
					$session->set('message',Wrong_file_format); 
				
				}
				
			} else {
				
				$session->set('message',$file->getError()); 
				
			}
			
		}
				
		redirect ('/controler/chapters/index/slider/'.$_POST['chapterId']);
			
	}
	
	function editSlider () {
	
		if (!$this->controlTest('chapters')) { exit; }
		$SliderModel = new SliderModel;
		$session = session();
		
		$data = array (
			'number' => $_POST['number'], 
			'link'.session('languageBase') => $_POST['link'], 
			'target' => $_POST['target'], 
			'text'.session('languageBase') => $_POST['text'], 
		);
		if (isset($_POST['visible'])) { $data['visible']=1; } else { $data['visible']=0; }
		
		$SliderModel->update($_POST['id'],$data);
				
		$session->set('message'.$_POST['id'],Saved); 
		redirect ('/controler/chapters/index/slider/'.$_POST['chapterId']);
			
	}
	
	function delSlider () {
	
		if (!$this->controlTest('chapters')) { exit; }
		$SliderModel = new SliderModel;
		
		$slider = $SliderModel->where('id',$_POST['id'])->first();
		
		if (file_exists($slider['preview'])) {
			unlink($slider['preview']);
		}
		
		$SliderModel->delete($_POST['id']);
			
	}
	
	function addChapterInComposite () {
	
		if (!$this->controlTest('chapters')) { exit; }
		$CompmenuModel = new CompmenuModel;
		$session = session();
			
		$data = array (
			'chapterId' => $_POST['chapterId'],
			'menuId' => $_POST['menuId'],
			'number' => $_POST['number']
		);
			
		$message = $CompmenuModel->addChapterInComposite($data);
		
		$session->set('message',$message); 
		redirect ('/controler/chapters/index/composite/'.$_POST['chapterId']);	
			
	}
	
	function changeCompMenuNumber () {
	
		if (!$this->controlTest('chapters')) { exit; }
		$CompmenuModel = new CompmenuModel;
		
		$data = array (
			'number' => $_POST['number']
		);
		$CompmenuModel->update($_POST['id'],$data);
			
	}
	
	function delCompMenu () {
	
		if (!$this->controlTest('chapters')) { exit; }
		$CompmenuModel = new CompmenuModel;
		$CompmenuModel->delete($_POST['id']);
			
	}
	
}
