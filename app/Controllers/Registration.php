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

class Registration extends Base
{
	public function index($lang='',$inPage='registration',$activation=0) {
	
		$session = session();
		$DesignModel = new DesignModel;
		$ChaptersModel = new ChaptersModel;
		$ModulsModel = new ModulsModel;
		$UsersModel = new UsersModel;
		
		if ($lang=='') { 
			define('Langlink',''); define('Langtext',''); $session->set('Langtext',''); $session->set('Langlink',''); 
		} else { 
			define('Langlink',$lang.'/'); define('Langtext','_'.$lang); $session->set('Langtext','_'.$lang); $session->set('Langlink',$lang.'/'); 
		}
		
		$session->remove('searchWord'); 
		
		$list = $this->getList('registration',Langtext);
		$list['userCats'] = $UsersModel->getUserCats();
		$list['userParams'] = $UsersModel->getUserParams();
		$list['inPage'] = $inPage;
		
		$sitShablon = $DesignModel->getSitShablons('shablon','registration');
		$banShablon = $DesignModel->getBanShablons('shablon','registration');
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
		
		if ($inPage=='activation') {
			$list['inPage'] = $this->makeActive($activation);
		}
		$list['setup']['chapterTree'] = '';	
		$list['setup']['topChapter'] = 0;
		$list['setup']['nowPage'] = 'registration';
		
		$data['list']=(object)$list;
		
		echo view('header',$data);
		echo view('top',$data);
		echo view('registration',$data);
		echo view('footer',$data);
		
	}
	
	function makeActive ($activation) {
	
		$UsersModel = new UsersModel;
		$user = $UsersModel->where('activation',$activation)->first();
		if (isset($user['userId'])) {
			if ($user['active']==0) {
				$data = array (
					'active' => 1, 
					'userId' => $user['userId']
				);
				$UsersModel->update($user['userId'],$data);
				return $page='nowactive';
			} else {
				return $page='alreadyactive';
			}
		} else {
			return $page='falsecode';
		}
		
	}
	
}
