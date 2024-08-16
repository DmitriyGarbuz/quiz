<?php namespace App\Controllers\Controler;

use App\Models\Notes as NotesModel;

class Notes extends Base
{
	function index($inPage='list',$id=0,$ctNotesPage=0) 
	{
		
		if (!$this->controlTest('notes')) { $inPage='false'; } 
		$session = session();
		
		$list = $this->getList('notes',$inPage);
		
		if ($inPage=='list') { $session->set('ctNotesPage',$ctNotesPage); }
		$NotesModel = new NotesModel;
		
		$list['noteCats'] = $NotesModel->getNoteCats();
		
		if ($id>0) {
			$list['noteCat'] = $NotesModel->getNoteCat('noteCatId',$id);
			$ctNotesTree = $list['noteCat']['tree'].'|'.$list['noteCat']['noteCatId'].'|';
		} else { $ctNotesTree=''; }
		
		if ($inPage=='list') {
			$list['notes'] = $NotesModel->getNotes($id,$ctNotesPage,$list['confSet']['notesPerCt'],'page');
			$list['coun'] = $NotesModel->getNotes($id,$ctNotesPage,$list['confSet']['notesPerCt'],'coun');
		}
		
		$list['setup']['ctNotesTree'] = $ctNotesTree;	
		$list['setup']['ctNotesPage'] = session('ctNotesPage');
		$list['setup']['ctNoteCat'] = $id;
		
		$data['list']=(object)$list;
		
		echo view($this->path.'top',$data);
		echo view($this->path.'notes',$data);
		
	}
	
	function addNoteCat () {
	
		if (!$this->controlTest('notes')) { exit; } 
		$NotesModel = new NotesModel;
			
		$name = str_replace ('"','\'\'',$_POST['name']);
			
		if ($_POST['parent']!=0) {
			$noteCat = $NotesModel->getNoteCat('noteCatId',$_POST['parent']);
			$tree = $noteCat['tree'].'|'.$_POST['parent'].'|';
		} else {
			$tree='';
		}
			
		$data = array (
			'name' => $name, 
			'number' => $_POST['number'],
			'parent' => $_POST['parent'],
			'tree' => $tree
		);
				
		$NotesModel->addNoteCat($data);
				
		redirect ('/controler/notes');
			
	}
	
	function editNoteCat () {
	
		if (!$this->controlTest('notes')) { exit; } 
		$NotesModel = new NotesModel;
		$session = session();
			
		$name = str_replace ('"','\'\'',$_POST['name']);
			
		$noteCat = $NotesModel->getNoteCat('noteCatId',$_POST['noteCatId']);
			
		$data = array (
			'noteCatId' => $_POST['noteCatId'], 
			'name' => $name, 
			'parent' => $_POST['parent'], 
			'number' => $_POST['number'], 
		);
			
		if ($_POST['parent']!=$noteCat['parent']) {
			
			if ($_POST['parent']!=0) {
				$noteCat = $NotesModel->getNoteCat('noteCatId',$_POST['parent']);
				$tree = $noteCat['tree'].'|'.$_POST['parent'].'|';
			} else { $tree=''; }
			$data['tree'] = $tree;
				
			$NotesModel->editNoteCat($data);
					
			$this->checkNewParent($_POST['noteCatId'],$tree);
			
			$notes = $NotesModel->like('tree','|'.$_POST['noteCatId'].'|')->find();
			foreach ($notes as $one):
				$noteCat = $NotesModel->getNoteCat('noteCatId',$one['parent']);
				$datatemp = array ('tree' => $noteCat['tree'].'|'.$noteCat['noteCatId'].'|', 'noteId' => $one['noteId']);
				$NotesModel->editNote($datatemp);
				unset ($datatemp);
				$noteId = $one['noteId'];
				$NotesModel->delNoteLinkbyNote($noteId);
				$dataNoteChap = array(
					'noteId' => $noteId,
					'noteCatId' => $noteCat['noteCatId']
				);
				$NotesModel->addNoteLinkCat($dataNoteChap);
				$this->notesTreeBuilder($noteCat['parent'],$noteId);
			endforeach;	
				
		} else {

			$NotesModel->editNoteCat($data);

		}		
				
		$session->set('message',Saved); 
		redirect ('/controler/notes/index/edit/'.$_POST['noteCatId']);
		
	}	
	
	function notesTreeBuilder ($noteCatId,$notesId) {
	
		if (!$this->controlTest('notes')) { exit; } 
		$NotesModel = new NotesModel;
		
		if ($noteCatId!=0) {
			$noteCat = $NotesModel->getNoteCat('noteCatId',$noteCatId);
			$dataNoteTree = array(
				'noteId' => $noteId,
				'noteCatId' => $noteCat['noteCatId']
			);
			$NotesModel->addNoteLinkCat($dataNoteTree);
			$this->notesTreeBuilder($noteCat['parent'],$noteId);
		}			
	
	}
	
	function checkNewParent ($noteCatId,$tree) {
	
		if (!$this->controlTest('notes')) { exit; } 
		$NotesModel = new NotesModel;
		
		$noteCats = $NotesModel->getNoteCats('parent',$noteCatId);
		foreach ($noteCats as $one):
			$datatemp = array ('tree' => $tree.'|'.$noteCatId.'|', 'noteCatId' => $one['noteCatId']);
			$NotesModel->editNoteCat($datatemp);
			unset ($datatemp);
			$this->checkNewParent($one['noteCatId'],$tree.'|'.$noteCatId.'|');
		endforeach;
					
	}
	
	function delNoteCat () {
		
		if (!$this->controlTest('notes')) { exit; } 
		$this->deleteNoteCat($_POST['id']);
		echo '/controler/notes';
		
	}
	
	function deleteNoteCat ($noteCatId=0) {
		
		if (!$this->controlTest('notes')) { exit; } 
		$NotesModel = new NotesModel;
		
		$noteCats = $NotesModel->getNoteCatByTree($noteCatId);
		foreach ($noteCats as $one) {
			$this->deleteNoteCat($one['noteCatId']);
		}
		
		$notes = $NotesModel->like('tree','|'.$noteCatId.'|')->find();
				
		foreach ($notes as $one):
			$data = array ( 'tree' => '', 'parent' => 0 );
			$NotesModel->update($one['noteId'],$data);
			unset($data);
		endforeach;
		
		$NotesModel->delNoteLinkbyCat($noteCatId);
		
		$NotesModel->delNoteCat($noteCatId);
		
	}
	
	function search () {
	
		if (!$this->controlTest('notes')) { exit; } 
		$session = session();
		$session->set('ctNoteSearch',$_POST['search']);
		redirect ('/controler/notes');
			
	}
	
	function unsearch () {
	
		if (!$this->controlTest('notes')) { exit; } 
		$session = session();
		$session->remove('ctNoteSearch');
		redirect ('/controler/notes');
			
	}
	
}
