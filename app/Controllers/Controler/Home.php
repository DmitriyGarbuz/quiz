<?php namespace App\Controllers\Controler;

use App\Models\Chapters as ChaptersModel;
use App\Models\Feedback as FeedbackModel;
use App\Models\Config as ConfigModel;

class Home extends Base
{
	public function index()
	{
		
		$this->controlTest('home');
		
		$ChaptersModel = new ChaptersModel;
		$FeedbackModel = new FeedbackModel;
		$ConfigModel = new ConfigModel;
		$session = session();
		
		if (session('dateStatFrom')==0) {
			$session->set('dateStatFrom',(date('U')-86400*7));
		}
		if (session('dateStatTo')==0) {
			$session->set('dateStatTo',(date('U')+86400));
		}
		$list = $this->getList('home');
		$list['newEvents'] = $ConfigModel->getNewEvents();
		
		$i=0;
		foreach ($list['newEvents']['comments'] as $one):
			if ($one['articleId']>0) {
				$list['newEvents']['comments'][$i]['article'] = $ArticlesModel->where('articleId',$one['articleId'])->first();
			}
			$i++;
		endforeach;
		
		$list['chapters'] = $ChaptersModel->findAll();
		$list['feedbacks'] = $FeedbackModel->findAll();
		$list['feedbackParams'] = $FeedbackModel->getFeedbackParams();
		
		$data['list']=(object)$list;
		
		echo view($this->path.'top',$data);
		echo view($this->path.'home',$data);
		
	}
	
	function testGaAnalytics() {
		
		if (!$this->controlTest($ctchap='home')){exit;}
		$ConfigModel = new ConfigModel;
		$session = session();
		helper('ga');
		
		$KEY_FILE_LOCATION = $ConfigModel->giveConfParam('gaJson');
		
		if (file_exists($KEY_FILE_LOCATION)) {
		
			$data = iniGa($KEY_FILE_LOCATION,session('graphstat1'),session('graphstat2'),session('alseecontrol'));
			if ((isset($data['alsee']))AND($data['alsee']==1)) {
				$session->set('alseecontrol',1);
				unset($data['alsee']);
			}
			
		} else {
			$data = array ('status' => 'error', 'text' => Dont_upload_ga_file.'<br><br><a href="/controler/moduls/index/analytics">'.Go_to_ga_link.'</a>');
		}
		
		echo json_encode($data);
		
	}
	
	function getSvgGraph() {
		
		if (!$this->controlTest($ctchap='home')){exit;}
		$ConfigModel = new ConfigModel;
		$session = session();
		helper('ga');
		
		$KEY_FILE_LOCATION = $ConfigModel->giveConfParam('gaJson');
		
		$string = getSvgGraph($KEY_FILE_LOCATION,session('dateStatFrom'),session('dateStatTo'));
			
		$session->set('graphstat2',$string);
		
		echo $string;
			
	}
	
	function changeGraphStatView() {
		
		if (!$this->controlTest($ctchap='home')){exit;}
		$ConfigModel = new ConfigModel;
		$session = session();
		helper('ga');
		
		$session->set('statstat',$_POST['type']);
		
		$KEY_FILE_LOCATION = $ConfigModel->giveConfParam('gaJson');
		
		$string = changeGraphStatView($KEY_FILE_LOCATION,session('statstat'),session('dateStatFrom'),session('dateStatTo'));
			
		$session->set('graphstat1',$string);
		
		echo $string;
			
	}
	
	function getResults($analytics, $profileId,$optParams,$metrics) {
		
		if (!$this->controlTest($ctchap='home')){exit;}
		
		return $analytics->data_ga->get(
		'ga:' . $profileId,
		date('Y-m-d',session('dateStatFrom')), 
		date('Y-m-d',session('dateStatTo')), 
		$metrics,
		$optParams);
	}
	
	function changeStatDates() {
		
		if (!$this->controlTest($ctchap='home')){exit;}
		$session = session();
		
		$array = explode('/',$_POST['dateStatFrom']);
		$dateStatFrom = date('U',mktime(0,0,0,$array[1],$array[0],$array[2]));
			
		$array = explode('/',$_POST['dateStatTo']);
		$dateStatTo = date('U',mktime(0,0,0,$array[1],$array[0],$array[2]));
			
		$session->set('dateStatFrom',$dateStatFrom);
		$session->set('dateStatTo',$dateStatTo);
			
		
	}
	
}
