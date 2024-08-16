<?php namespace App\Controllers;

use App\Models\Articles as ArticlesModel;
use App\Models\Chapters as ChaptersModel;
use App\Models\Comments as CommentsModel;
use App\Models\Moduls as ModulsModel;
use App\Models\Feedback as FeedbackModel;
use App\Models\Polls as PollsModel;

class Article extends Base
{
	public function index($lang='',$url='') {
	
		$session = session();
		$ArticlesModel = new ArticlesModel;
		$ChaptersModel = new ChaptersModel;
		$CommentsModel = new CommentsModel;
		$ModulsModel = new ModulsModel;
		$FeedbackModel = new FeedbackModel;
		$PollsModel = new PollsModel;
		
		$chapterPage = session('chapterPage');
		$session->remove('search'); 
		
		if ($lang=='') { 
			define('Langlink',''); define('Langtext',''); $session->set('Langtext',''); $session->set('Langlink',''); 
		} else { 
			define('Langlink',$lang.'/'); define('Langtext','_'.$lang); $session->set('Langtext','_'.$lang); $session->set('Langlink',$lang.'/'); 
		}
		
		$list = $this->getList('article',Langtext);
		
		if ($url!='') { $list['article'] = $ArticlesModel->where('url',$url)->first(); }
		if (!isset($list['article']['articleId'])) { redirect('page404'); }
		$list['chapter'] = $ChaptersModel->where('chapterId',$list['article']['parent'])->first();
		
		$list['artRating'] = $ArticlesModel->getArtRating($list['article']['articleId']);
		
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
		
		$list['comments'] = $CommentsModel->where ('articleId',$list['article']['articleId'])->where ('visible',1)->orderBy ('date','desc')->find(); 
		
		$list['setup']['chapterTree'] = $chapterTree;	
		$list['setup']['chapterPage'] = $chapterPage;
		$list['setup']['topChapter'] = $topChapter;
		$list['setup']['nowPage'] = 'article/'.$url;
		
		$data['list']=(object)$list;
		
		echo view('header',$data);
		echo view('top',$data);
		echo view('article',$data);
		echo view('footer',$data);
		
	}
	

}
