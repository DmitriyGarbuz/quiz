<?php namespace App\Controllers;

use App\Models\Chapters as ChaptersModel;
use App\Models\Moduls as ModulsModel;
use App\Models\Articles as ArticlesModel;
use App\Models\Gallery as GalleryModel;
use App\Models\Faqs as FaqsModel;
use App\Models\Comments as CommentsModel;
use App\Models\Slider as SliderModel;
use App\Models\Compmenu as CompmenuModel;
use App\Models\Feedback as FeedbackModel;
use App\Models\Polls as PollsModel;

class Chapter extends Base
{
	public function index($lang='',$url='',$chapterPage=0) {
	
		$session = session();
		$ChaptersModel = new ChaptersModel;
		$ModulsModel = new ModulsModel;
		$ArticlesModel = new ArticlesModel;
		$GalleryModel = new GalleryModel;
		$FaqsModel = new FaqsModel;
		$CommentsModel = new CommentsModel;
		$SliderModel = new SliderModel;
		$CompmenuModel = new CompmenuModel;
		$FeedbackModel = new FeedbackModel;
		$PollsModel = new PollsModel;
		
		$chapterPage = str_replace('page-','',$chapterPage);
		if (($chapterPage!='')AND($chapterPage!=0)) { $chapterPage = (int)$chapterPage-1; } else { $chapterPage = (int)$chapterPage;  }
		$session->remove('searchWord'); 
		
		if ($lang=='') { 
			define('Langlink',''); define('Langtext',''); $session->set('Langtext',''); $session->set('Langlink',''); 
		} else { 
			define('Langlink',$lang.'/'); define('Langtext','_'.$lang); $session->set('Langtext','_'.$lang); $session->set('Langlink',$lang.'/'); 
		}
		
		$list = $this->getList('chapter',Langtext);
		
		if ($url=='') { $list['chapter'] = $ChaptersModel->orderBy('number ASC, name ASC')->where('parent',0)->first();
		} else { $list['chapter'] = $ChaptersModel->where('url',$url)->first(); }
		if (!isset($list['chapter']['chapterId'])) { redirect('page404'); }
		
		$session->set('chapterBlog',$list['chapter']['url']); 
		$session->set('chapterPage',$chapterPage); 
		$chapterListPage = (int)$chapterPage*(int)$list['chapter']['perPage'];
		
		$list['chapRating'] = $ChaptersModel->getChapRating($list['chapter']['chapterId']);
		
		$sitChapter = $ChaptersModel->getSitChapters('chapterId',$list['chapter']['chapterId']);
		$banChapter = $ChaptersModel->getBanChapters('chapterId',$list['chapter']['chapterId']);
		$list['sitChapter'] = array(); $list['banChapter'] = array(); 
		foreach ($sitChapter as $one) { 
			$list['sitChapter'][$one['name']]['funcName'] = $one['param']; 
			$list['sitChapter'][$one['name']]['bodyId'] = $one['bodyId']; 
			$list['sitChapter'][$one['name']]['advancedData'] = array();
			if (($one['param']=='articlesColumn')OR($one['param']=='articlesCenter')OR($one['param']=='galleryColumn')OR($one['param']=='galleryCenter')) {
				$list['sitChapter'][$one['name']]['advancedData']['chapter'] = $ChaptersModel->where('chapterId',$one['bodyId'])->first();
				if ($one['param']=='articlesColumn') { $list['sitChapter'][$one['name']]['advancedData']['colArticles'] = $ArticlesModel->getArtModul($one['bodyId'],'Col');  }
				if ($one['param']=='articlesCenter') { $list['sitChapter'][$one['name']]['advancedData']['centArticles'] = $ArticlesModel->getArtModul($one['bodyId'],'Cent'); }
				if ($one['param']=='galleryColumn') { $list['sitChapter'][$one['name']]['advancedData']['colGallery'] = $GalleryModel->getGalModul($one['bodyId'],'Col');  }
				if ($one['param']=='galleryCenter') { $list['sitChapter'][$one['name']]['advancedData']['centGallery'] = $GalleryModel->getGalModul($one['bodyId'],'Cent'); }
			}
			if ($one['param']=='commentsColumn') { $list['sitChapter'][$one['name']]['advancedData']['colComments'] = $CommentsModel->getSitComments('Col'); }
			if ($one['param']=='commentsCenter') { $list['sitChapter'][$one['name']]['advancedData']['centComments'] = $CommentsModel->getSitComments('Cent'); }
			if ($one['param']=='commentsSlide') { $list['sitChapter'][$one['name']]['advancedData']['slideComments'] = $CommentsModel->getSitComments('Slide'); }
			if ($one['param']=='feedback') { 
				$list['sitChapter'][$one['name']]['advancedData']['feedback'] = $FeedbackModel->where('feedbackId',$one['bodyId'])->first(); 
				$list['sitChapter'][$one['name']]['advancedData']['feedbackParams'] = $FeedbackModel->getFeedbackParams('feedbackId',$one['bodyId']); 
			}
			if ($one['param']=='polls') { 
				$list['sitChapter'][$one['name']]['advancedData']['poll'] = $PollsModel->where('pollId',$one['bodyId'])->first(); 
				$list['sitChapter'][$one['name']]['advancedData']['pollParams'] = $PollsModel->getPollParams($one['bodyId']); 
				$list['sitChapter'][$one['name']]['advancedData']['countPollVote'] = $PollsModel->countPollVote($one['bodyId']); 
			}
			if ($one['param']=='slider') { 
				$list['sitChapter'][$one['name']]['advancedData']['slider'] = $SliderModel->orderBy('number','asc')->where('visible',1)->where('chapterId',$list['chapter']['chapterId'])->find();   
				$sliderChapter = $ChaptersModel->orderBy('number ASC, name ASC')->where('sliderForAll',1)->first();
				if ((isset($sliderChapter['chapterId']))AND(count($list['sitChapter'][$one['name']]['advancedData']['slider'])==0)) {
					$list['sitChapter'][$one['name']]['advancedData']['slider'] = $SliderModel->orderBy('number','asc')->where('visible',1)->where('chapterId',$sliderChapter['chapterId'])->find();     
				}
			}
		} 
		
		foreach ($banChapter as $one) { $list['banChapter'][$one['name']] = $one['param'.Langtext]; } 
		$list['topShablon'] = $list['sitChapter'];
		
		$chapterTree = $list['chapter']['tree'].'|'.$list['chapter']['chapterId'].'|';
		$array = substr($chapterTree,0,-1); $array = substr($array,1); $array = explode('||',$array);
		$topChapter = $array[0]; $list['breedchapters'] = array();
		foreach ($array as $one) { $list['breedchapters'][] = $ChaptersModel->where('chapterId',$one)->first(); }
		
		if ($list['chapter']['type']=='articles') {
			$list['articles'] = $ArticlesModel->getArticles($list['chapter']['chapterId'],$chapterListPage,$list['chapter']['sort'],$list['chapter']['perPage'],1,'page');
			$list['coun'] = $ArticlesModel->getArticles($list['chapter']['chapterId'],$chapterListPage,$list['chapter']['sort'],$list['chapter']['perPage'],1,'coun');
			if ($chapterListPage>$list['coun']) { redirect('/page404'); }
		}
		if ($list['chapter']['type']=='comments') {
			$list['comments'] = $CommentsModel->getComments($list['chapter']['chapterId'],$chapterListPage,$list['chapter']['perPage'],1,'page');
			$list['coun'] = $CommentsModel->getComments($list['chapter']['chapterId'],$chapterListPage,$list['chapter']['perPage'],1,'coun');
			if ($chapterListPage>$list['coun']) { redirect('/page404'); }
		}
		if ($list['chapter']['type']=='faq') {
			$list['faqs'] = $FaqsModel->getFaqs($list['chapter']['chapterId'],$chapterListPage,$list['chapter']['perPage'],1,'page');
			$list['coun'] = $FaqsModel->getFaqs($list['chapter']['chapterId'],$chapterListPage,$list['chapter']['perPage'],1,'coun');
			if ($chapterListPage>$list['coun']) { redirect('/page404'); }
		}
		if ($list['chapter']['type']=='gallery') {
			$list['gallerys'] = $GalleryModel->getGallerys($list['chapter']['chapterId'],$chapterListPage,$list['chapter']['perPage'],'page');
			$list['coun'] = $GalleryModel->getGallerys($list['chapter']['chapterId'],$chapterListPage,$list['chapter']['perPage'],'coun');
			//$list['allGallerys'] = $GalleryModel->like('tree','|'.$list['chapter']['chapterId'].'|')->orderBy('number','ASC')->find();
			$list['allGallerys'] = $GalleryModel->getAllGallerys($list['chapter']['chapterId']);
			if ($chapterListPage>$list['coun']) { redirect('/page404'); }
		}
		if ($list['chapter']['atView']==3) {
			$list['compMenu'] = $CompmenuModel->getDistCompMenu($list['chapter']['chapterId']);
		}
		
		$list['setup']['chapterTree'] = $chapterTree;	
		$list['setup']['chapterPage'] = session('chapterPage');
		$list['setup']['topChapter'] = $topChapter;
		$list['setup']['nowPage'] = $url;
		
		$data['list']=(object)$list;
		
		echo view('header',$data);
		echo view('top',$data);
		echo view('chapter',$data);
		echo view('footer',$data);
		
	}
	

}
