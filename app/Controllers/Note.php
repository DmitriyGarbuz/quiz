<?php namespace App\Controllers;

use App\Models\Notes as NotesModel;
use App\Models\Chapters as ChaptersModel;
use App\Models\Slider as SliderModel;
use App\Models\Moduls as ModulsModel;

class Note extends Base
{
	function index($lang='',$url='',$tabUrl='') {
	
		$session = session();
		$NotesModel = new NotesModel;
		$ChaptersModel = new ChaptersModel;
		$SliderModel = new SliderModel;
		
		$session->remove('search'); 
		
		if ($lang=='') { 
			define('Langlink',''); define('Langtext',''); $session->set('Langtext',''); $session->set('Langlink',''); 
		} else { 
			define('Langlink',$lang.'/'); define('Langtext','_'.$lang); $session->set('Langtext','_'.$lang); $session->set('Langlink',$lang.'/'); 
		}
		
		$list = $this->getList('note',Langtext);
		
		if ($url!='') { $list['note'] = $NotesModel->where('url',$url)->first(); }
		if (!isset($list['note']['noteId'])) { redirect('page404'); }
		
		$list['noteTabs'] = $NotesModel->getNoteTabs ('noteId',$list['note']['noteId']);
		if ($tabUrl!='') {
			$list['tab'] = $tabUrl;
			$list['noteTab'] = $NotesModel->getNoteTabByUrl ($tabUrl);
		} else {
			$list['noteTab'] = $NotesModel->getFirstNoteTab ($list['note']['noteId']);
			$list['tab'] = $list['noteTab']['url'];
		}
		
		$sitNote = $NotesModel->getsitNotes('noteId',$list['note']['noteId']);
		$banNote = $NotesModel->getbanNotes('noteId',$list['note']['noteId']);
		$list['sitNote'] = array(); $list['banNote'] = array(); 
		foreach ($sitNote as $one) { 
			$list['sitNote'][$one['name']]['funcName'] = $one['param']; 
			$list['sitNote'][$one['name']]['bodyId'] = $one['bodyId']; 
			$list['sitNote'][$one['name']]['advancedData'] = array();
			if (($one['param']=='articlesColumn')OR($one['param']=='articlesCenter')OR($one['param']=='galleryColumn')OR($one['param']=='galleryCenter')) {
				$list['sitNote'][$one['name']]['advancedData']['chapter'] = $ChaptersModel->where('chapterId',$one['bodyId'])->first();
				if ($one['param']=='articlesColumn') { $list['sitNote'][$one['name']]['advancedData']['colArticles'] = $ArticlesModel->getArtModul($one['bodyId'],'Col');  }
				if ($one['param']=='articlesCenter') { $list['sitNote'][$one['name']]['advancedData']['centArticles'] = $ArticlesModel->getArtModul($one['bodyId'],'Cent'); }
				if ($one['param']=='galleryColumn') { $list['sitNote'][$one['name']]['advancedData']['colGallery'] = $GalleryModel->getGalModul($one['bodyId'],'Col');  }
				if ($one['param']=='galleryCenter') { $list['sitNote'][$one['name']]['advancedData']['centGallery'] = $GalleryModel->getGalModul($one['bodyId'],'Cent'); }
			}
			if ($one['param']=='commentsColumn') { $list['sitNote'][$one['name']]['advancedData']['colComments'] = $CommentsModel->getSitComments('Col'); }
			if ($one['param']=='commentsCenter') { $list['sitNote'][$one['name']]['advancedData']['centComments'] = $CommentsModel->getSitComments('Cent'); }
			if ($one['param']=='commentsSlide') { $list['sitNote'][$one['name']]['advancedData']['slideComments'] = $CommentsModel->getSitComments('Slide'); }
			if ($one['param']=='feedback') { 
				$list['sitNote'][$one['name']]['advancedData']['feedback'] = $FeedbackModel->where('feedbackId',$one['bodyId'])->first(); 
				$list['sitNote'][$one['name']]['advancedData']['feedbackParams'] = $FeedbackModel->getFeedbackParams('feedbackId',$one['bodyId']); 
			}
			if ($one['param']=='polls') { 
				$list['sitNote'][$one['name']]['advancedData']['poll'] = $PollsModel->where('pollId',$one['bodyId'])->first(); 
				$list['sitNote'][$one['name']]['advancedData']['pollParams'] = $PollsModel->getPollParams($one['bodyId']); 
				$list['sitNote'][$one['name']]['advancedData']['countPollVote'] = $PollsModel->countPollVote($one['bodyId']); 
			}
			if ($one['param']=='slider') { 
				$list['sitNote'][$one['name']]['advancedData']['slider'] = $SliderModel->orderBy('number','asc')->where('visible',1)->where('noteId',$list['note']['noteId'])->find();   
				$sliderChapter = $ChaptersModel->orderBy('number ASC, name ASC')->where('sliderForAll',1)->first();
				if ((isset($sliderChapter['chapterId']))AND(count($list['sitNote'][$one['name']]['advancedData']['slider'])==0)) {
					$list['sitNote'][$one['name']]['advancedData']['slider'] = $SliderModel->orderBy('number','asc')->where('visible',1)->where('chapterId',$sliderChapter['chapterId'])->find();     
				}
			}
		} 
		
		foreach ($banNote as $one) { $list['banNote'][$one['name']] = $one['param'.Langtext]; } 
		$list['topShablon'] = $list['sitNote'];
		
		if ($list['note']['chapterId']!=0) {
			$list['chapter'] = $ChaptersModel->where('chapterId',$list['note']['chapterId'])->first();
			if (!isset($list['chapter']['chapterId'])) { redirect('page404'); }
			$chapterTree = $list['chapter']['tree'].'|'.$list['chapter']['chapterId'].'|';
			$array = substr($chapterTree,0,-1); $array = substr($array,1); $array = explode('||',$array);
			$topChapter = $array[0]; $list['breedchapters'] = array();
			foreach ($array as $one) { $list['breedchapters'][] = $ChaptersModel->where('chapterId',$one)->first(); }
			if ($list['chapter']['parent']==0) { $topChapter = $list['chapter']['chapterId']; }
		} else { 
			$list['chapter'] = $ChaptersModel->where('parent',0)->first();
			$chapterTree='';  $topChapter=0; $list['breedchapters'] = array(); 
		} 
		
		$list['setup']['chapterTree'] = $chapterTree;	
		$list['setup']['topChapter'] = $topChapter;
		$list['setup']['nowPage'] = 'note/'.$url;
		
		$data['list']=(object)$list;
		
		echo view('header',$data);
		echo view('top',$data);
		echo view('note',$data);
		echo view('footer',$data);
		
	}
	

}
