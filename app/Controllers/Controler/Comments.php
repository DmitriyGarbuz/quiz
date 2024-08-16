<?php namespace App\Controllers\Controler;

use App\Models\Comments as CommentsModel;
use App\Models\Chapters as ChaptersModel;
use App\Models\Articles as ArticlesModel;

class Comments extends Base
{
	public function index($inPage='list',$ctCommentsPage=0,$id=0)
	{
		
		if (!$this->controlTest('comments')) { $inPage='false'; } 
		$list = $this->getList('comments',$inPage);
		
		$CommentsModel = new CommentsModel;
		$ChaptersModel = new ChaptersModel;
		$ArticlesModel = new ArticlesModel;
		
		$list['chapters'] = $ChaptersModel->orderBy('parent ASC, number ASC, name ASC')->find();
		
		$list['comments'] = $CommentsModel->getComments(0,$ctCommentsPage,$list['confSet']['commentsPerCt'],0,'page');
		$list['coun'] = $CommentsModel->getComments(0,$ctCommentsPage,$list['confSet']['commentsPerCt'],0,'coun');
		
		$i=0;
		foreach ($list['comments'] as $one):
			if ($one['articleId']>0) {
				$list['comments'][$i]['article'] = $ArticlesModel->where('articleId',$one['articleId'])->first();
			}
			$i++;
		endforeach;
		
		
		if ($inPage=='edit') { 
			$list['comment'] = $CommentsModel->where('commentId',$id)->first();
			if (!isset($list['comment']['commentId'])) { redirect('/page404'); }
		}
		$list['setup']['ctCommentsPage'] = $ctCommentsPage;	
		
		$data['list']=(object)$list;
		
		echo view($this->path.'top',$data);
		echo view($this->path.'comments',$data);
		
	}
	
	function editComment () {
	
		if (!$this->controlTest('comments')) { exit; } 
		$CommentsModel = new CommentsModel;
		$ChaptersModel = new ChaptersModel;
		$session = session();
		
		$chapter = $ChaptersModel->where('chapterId',$_POST['chapterId'])->first();
		$tree = $chapter['tree'].'|'.$_POST['chapterId'].'|';
		
		$data = array(
			'text' => $_POST['text'],
			'firstName' => $_POST['firstName'],
			'parent' => $_POST['chapterId'], 
			'tree' => $tree
		);
		if (isset($_POST['visible'])) { $data['visible']=1; } else { $data['visible']=0; }
		$CommentsModel->update($_POST['commentId'],$data);
		
		$comment = $CommentsModel->where('commentId',$_POST['commentId'])->first();
		
		$CommentsModel->delComChapbyCom($comment['commentId']);
		$chapter = $ChaptersModel->where('chapterId',$comment['parent'])->first();
		if (isset($chapter['chapterId'])) {
			$dataComTree = array(
				'commentId' => $comment['commentId'],
				'chapterId' => $chapter['chapterId']
			);
			$CommentsModel->addComChap($dataComTree);
			$this->commentsTreeBuilder($chapter['parent'],$comment['commentId']);
		}
		
		$session->set('message',Saved); 
		redirect ('/controler/comments/index/edit/'.$_POST['ctCommentsPage'].'/'.$_POST['commentId']);
		
	}
	
	function changeCommentData () {
	
		if (!$this->controlTest('comments')) { exit; } 
		$CommentsModel = new CommentsModel;
		
		$data = array (
			$_POST['type'] => $_POST['param']
		);
		$CommentsModel->update($_POST['commentId'],$data);
			
	}
	
	function delComment () {
	
		if (!$this->controlTest('comments')) { exit; } 
		$CommentsModel = new CommentsModel;
		$CommentsModel->where('parentComment',$_POST['id'])->delete();
		$CommentsModel->delete($_POST['id']);
		echo '/controler/comments';	
			
	}
	
	function changeCommentParent () {
	
		if (!$this->controlTest('comments')) { exit; } 
		$CommentsModel = new CommentsModel;
		$ChaptersModel = new ChaptersModel;
		
		$chapter = $ChaptersModel->where('chapterId',$_POST['chapterId'])->first();
		$tree = $chapter['tree'].'|'.$_POST['chapterId'].'|';
				
		$data = array (
			'parent' => $_POST['chapterId'], 
			'tree' => $tree
		);
		$CommentsModel->update($_POST['commentId'],$data);
		
		$comment = $CommentsModel->where('commentId',$_POST['commentId'])->first();
		
		$CommentsModel->delComChapbyCom($comment['commentId']);
		$chapter = $ChaptersModel->where('chapterId',$comment['parent'])->first();
		if (isset($chapter['chapterId'])) {
			$dataComTree = array(
				'commentId' => $comment['commentId'],
				'chapterId' => $chapter['chapterId']
			);
			$CommentsModel->addComChap($dataComTree);
			$this->commentsTreeBuilder($chapter['parent'],$comment['commentId']);
		}
			
	}
	
	function commentsTreeBuilder ($chapterId,$commentId) {
	
		if (!$this->controlTest('comments')) { exit; } 
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
	
	function changeType () {
	
		if (!$this->controlTest('comments')) { exit; } 
		$session = session();
		$session->set('commentsType',$_POST['type']);
			
	}
	
}
