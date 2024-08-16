<?php namespace App\Controllers\Controler;

use App\Models\Feedback as FeedbackModel;

class Connects extends Base
{
	public function index($inPage='list',$ctConnectsPage=0,$id=0)
	{
		
		if (!$this->controlTest('connects')) { $inPage='false'; } 
		$list = $this->getList('connects',$inPage);
		
		$FeedbackModel = new FeedbackModel;
		
		$list['feedbacks'] = $FeedbackModel->findAll();
		$list['feeds'] = $FeedbackModel->getFeeds($ctConnectsPage,$list['confSet']['connectsPerCt'],'page');
		$list['coun'] = $FeedbackModel->getFeeds($ctConnectsPage,$list['confSet']['connectsPerCt'],'coun');
		
		if ($inPage=='edit') { 
			$list['feed'] = $FeedbackModel->getFeed('feedId',$id);
			if (!isset($list['feed']['feedId'])) { redirect('/page404'); }
			$list['feedParams'] = $FeedbackModel->getFeedParams('feedbackId',$list['feed']['feedbackId']);
			$list['feedbackParams'] = $FeedbackModel->getFeedbackParams('feedbackId',$list['feed']['feedbackId']);
		}
		$list['setup']['ctConnectsPage'] = $ctConnectsPage;	
		
		$data['list']=(object)$list;
		
		echo view($this->path.'top',$data);
		echo view($this->path.'connects',$data);
		
	}
	
	function changeFeedData () {
	
		if (!$this->controltest($ctchap='connects')){exit;}
		$FeedbackModel = new FeedbackModel;
		
		$data = array (
			'feedId' => $_POST['feedId'], 
			$_POST['type'] => $_POST['param']
		);
		$FeedbackModel->editFeed($data);
			
	}
	
	function delFeed () {
	
		if (!$this->controltest($ctchap='connects')){exit;}
		$FeedbackModel = new FeedbackModel;
		$FeedbackModel->delFeed($_POST['id']);
		echo '/controler/connects';
			
	}
	
	function changeType () {
	
		if (!$this->controltest($ctchap='connects')){exit;}
		$session = session();
		$session->set('connectsType',$_POST['type']);
			
	}
	
}
