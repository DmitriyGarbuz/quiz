<?php namespace App\Controllers\Controler;

use App\Models\Faqs as FaqsModel;
use App\Models\Chapters as ChaptersModel;

class Faq extends Base
{
	public function index($inPage='list',$ctFaqPage=0,$id=0)
	{
		
		if (!$this->controlTest('faq')) { $inPage='false'; } 
		$list = $this->getList('faq',$inPage);
		
		$FaqsModel = new FaqsModel;
		$ChaptersModel = new ChaptersModel;
		
		$list['chapters'] = $ChaptersModel->orderBy('parent ASC, number ASC, name ASC')->find();
		
		$list['faqs'] = $FaqsModel->getFaqs(0,$ctFaqPage,$list['confSet']['faqPerCt'],0,'page');
		$list['coun'] = $FaqsModel->getFaqs(0,$ctFaqPage,$list['confSet']['faqPerCt'],0,'coun');
		
		if ($inPage=='edit') {
			$list['faq'] = $FaqsModel->where('faqId',$id)->first();
			if (!isset($list['faq']['faqId'])) { redirect('/page404'); }
		}
		$list['setup']['ctFaqPage'] = $ctFaqPage;	
		
		$data['list']=(object)$list;
		
		echo view($this->path.'top',$data);
		echo view($this->path.'faq',$data);
		
	}
	
	function editFaq () {
	
		if (!$this->controlTest('faq')) { exit; } 
		$FaqsModel = new FaqsModel;
		$ChaptersModel = new ChaptersModel;
		$session = session();
		
		$chapter = $ChaptersModel->where('chapterId',$_POST['chapterId'])->first();
		$tree = $chapter['tree'].'|'.$_POST['chapterId'].'|';
		
		$data = array(
			'answer' => $_POST['answer'],
			'text' => $_POST['text'],
			'firstName' => $_POST['firstName'],
			'parent' => $_POST['chapterId'], 
			'tree' => $tree
		);
		if (isset($_POST['visible'])) { $data['visible']=1; } else { $data['visible']=0; }
		$FaqsModel->update($_POST['faqId'],$data);
		
		$faq = $FaqsModel->where('faqId',$_POST['faqId'])->first();
		
		$FaqsModel->delFaqChapbyFaq($faq['faqId']);
		$chapter = $ChaptersModel->where('chapterId',$faq['parent'])->first();
		if (isset($chapter['chapterId'])) {
			$dataFaqTree = array(
				'faqId' => $faq['faqId'],
				'chapterId' => $chapter['chapterId']
			);
			$FaqsModel->addFaqChap($dataFaqTree);
			$this->faqTreeBuilder($chapter['parent'],$faq['faqId']);
		}
		
		$session->set('message',Saved); 
		redirect ('/controler/faq/index/edit/'.$_POST['ctFaqPage'].'/'.$_POST['faqId']);
		
	}
	
	function changeFaqData () {
	
		if (!$this->controlTest('faq')) { exit; } 
		$FaqsModel = new FaqsModel;
		
		$data = array (
			$_POST['type'] => $_POST['param']
		);
		$FaqsModel->update($_POST['faqId'],$data);
			
	}
	
	function delFaq () {
	
		if (!$this->controlTest('faq')) { exit; } 
		$FaqsModel = new FaqsModel;
		$FaqsModel->delete($_POST['id']);
		echo '/controler/faq';
			
	}
	
	function changeFaqParent () {
	
		if (!$this->controlTest('faq')) { exit; } 
		$FaqsModel = new FaqsModel;
		$ChaptersModel = new ChaptersModel;
		
		$chapter = $ChaptersModel->where('chapterId',$_POST['chapterId'])->first();
		$tree = $chapter['tree'].'|'.$_POST['chapterId'].'|';
				
		$data = array (
			'parent' => $_POST['chapterId'], 
			'tree' => $tree
		);
		$FaqsModel->update($_POST['faqId'],$data);
		
		$faq = $FaqsModel->where('faqId',$_POST['faqId'])->first();
		
		$FaqsModel->delFaqChapbyFaq($faq['faqId']);
		$chapter = $ChaptersModel->where('chapterId',$faq['parent'])->first();
		if (isset($chapter['chapterId'])) {
			$dataFaqTree = array(
				'faqId' => $faq['faqId'],
				'chapterId' => $chapter['chapterId']
			);
			$FaqsModel->addFaqChap($dataFaqTree);
			$this->faqTreeBuilder($chapter['parent'],$faq['faqId']);
		}
			
	}
	
	function faqTreeBuilder ($chapterId,$faqId) {
	
		if (!$this->controlTest('faq')) { exit; } 
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
	
	function changeType () {
	
		if (!$this->controlTest('faq')) { exit; } 
		$session = session();
		$session->set('faqType',$_POST['type']);
			
	}
	
}
