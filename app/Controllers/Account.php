<?php namespace App\Controllers;

use App\Models\Design as DesignModel;
use App\Models\Chapters as ChaptersModel;
use App\Models\Moduls as ModulsModel;
use App\Models\Articles as ArticlesModel;
use App\Models\Gallery as GalleryModel;
use App\Models\Comments as CommentsModel;
use App\Models\Slider as SliderModel;
use App\Models\Feedback as FeedbackModel;
use App\Models\Polls as PollsModel;
use App\Models\Users as UsersModel;

class Account extends Base
{
	public function index($lang='') {
	
		$session = session();
		$DesignModel = new DesignModel;
		$ChaptersModel = new ChaptersModel;
		$ModulsModel = new ModulsModel;
		$UsersModel = new UsersModel;
		$FeedbackModel = new FeedbackModel;
		$PollsModel = new PollsModel;
		
		if ($lang=='') { 
			define('Langlink',''); define('Langtext',''); $session->set('Langtext',''); $session->set('Langlink',''); 
		} else { 
			define('Langlink',$lang.'/'); define('Langtext','_'.$lang); $session->set('Langtext','_'.$lang); $session->set('Langlink',$lang.'/'); 
		}
		
		$session->remove('searchWord'); 
		
		$list = $this->getList('account',Langtext);
		$list['userCats'] = $UsersModel->getUserCats();
		$list['userTabs'] = $UsersModel->getUserTabs();
		
		$sitShablon = $DesignModel->getSitShablons('shablon','account');
		$banShablon = $DesignModel->getBanShablons('shablon','account');
		$list['sitShablon'] = array(); $list['banShablon'] = array(); 
		foreach ($sitShablon as $one) { 
			$list['sitShablon'][$one['name']]['funcName'] = $one['param']; 
			$list['sitShablon'][$one['name']]['bodyId'] = $one['bodyId']; 
			$list['sitShablon'][$one['name']]['advancedData'] = array();
			if (($one['param']=='articlesColumn')OR($one['param']=='articlesCenter')OR($one['param']=='galleryColumn')OR($one['param']=='galleryCenter')) {
				$list['sitShablon'][$one['name']]['advancedData']['chapter'] = $ChaptersModel->where('chapterId',$one['bodyId'])->first();
				if ($one['param']=='articlesColumn') { $list['sitShablon'][$one['name']]['advancedData']['colArticles'] = $ArticlesModel->getArtModul($one['bodyId'],'Col');  }
				if ($one['param']=='articlesCenter') { $list['sitShablon'][$one['name']]['advancedData']['centArticles'] = $ArticlesModel->getArtModul($one['bodyId'],'Cent'); }
				if ($one['param']=='galleryColumn') { $list['sitShablon'][$one['name']]['advancedData']['colGallery'] = $GalleryModel->getGalModul($one['bodyId'],'Col');  }
				if ($one['param']=='galleryCenter') { $list['sitShablon'][$one['name']]['advancedData']['centGallery'] = $GalleryModel->getGalModul($one['bodyId'],'Cent'); }
			}
			if ($one['param']=='commentsColumn') { $list['sitShablon'][$one['name']]['advancedData']['colComments'] = $CommentsModel->getSitComments('Col'); }
			if ($one['param']=='commentsCenter') { $list['sitShablon'][$one['name']]['advancedData']['centComments'] = $CommentsModel->getSitComments('Cent'); }
			if ($one['param']=='commentsSlide') { $list['sitShablon'][$one['name']]['advancedData']['slideComments'] = $CommentsModel->getSitComments('Slide'); }
			if ($one['param']=='feedback') { 
				$list['sitShablon'][$one['name']]['advancedData']['feedback'] = $FeedbackModel->where('feedbackId',$one['bodyId'])->first(); 
				$list['sitShablon'][$one['name']]['advancedData']['feedbackParams'] = $FeedbackModel->getFeedbackParams('feedbackId',$one['bodyId']); 
			}
			if ($one['param']=='polls') { 
				$list['sitShablon'][$one['name']]['advancedData']['poll'] = $PollsModel->where('pollId',$one['bodyId'])->first(); 
				$list['sitShablon'][$one['name']]['advancedData']['pollParams'] = $PollsModel->getPollParams($one['bodyId']); 
				$list['sitShablon'][$one['name']]['advancedData']['countPollVote'] = $PollsModel->countPollVote($one['bodyId']); 
			}
			if ($one['param']=='slider') { 
				$sliderChapter = $ChaptersModel->orderBy('number ASC, name ASC')->where('sliderForAll',1)->first();
				if (isset($sliderChapter['chapterId'])) {
					$list['sitShablon'][$one['name']]['advancedData']['slider'] = $SliderModel->orderBy('number','asc')->where('visible',1)->where('chapterId',$sliderChapter['chapterId'])->find();     
				}
			}
		} 
		foreach ($banShablon as $one) { $list['banShablon'][$one['name']] = $one['param'.Langtext]; } 
		$list['topShablon'] = $list['sitShablon'];
		
		$list['chapter'] = $ChaptersModel->orderBy('number ASC, name ASC')->where('parent',0)->first();
		if (!isset($list['chapter']['chapterId'])) { redirect('page404'); }
		if (session('userLogined')=='ok') { 
			$list['user'] = $UsersModel->where('userId',session('userId'))->first();
			if (isset($list['user']['userId'])) { 
				$list['userParams'] = $UsersModel->getUserParams();
				$list['userData'] = $UsersModel->getUserDatas('code',$list['user']['code']);
				$list['userCat'] = $UsersModel->getUserCat('userCatId',$list['user']['parent']);
				if (isset($list['userCat']['userCatId'])) { 
					$list['userTabData'] = $UsersModel->getUserTabDataByCat($list['userCat']['userCatId']);
				} else { 
					$list['userTabData'] = $UsersModel->getUserTabDataByCat(0);
				}
				if (session('activeAccountTab')==0) {
					if (isset($list['userTabs'][0]['userTabId'])) {
						$session->set('activeAccountTab',$list['userTabs'][0]['userTabId']);
					}
				}
			} else { 
				redirect('page404'); 
			}
			
		} else { echo 3;
			redirect('page404'); 
		}
		
		$list['setup']['chapterTree'] = '';	
		$list['setup']['topChapter'] = 0;
		$list['setup']['nowPage'] = 'account';
		
		$data['list']=(object)$list;
		
		echo view('header',$data);
		echo view('top',$data);
		echo view('account',$data);
		echo view('footer',$data);
		
	}
	
}
