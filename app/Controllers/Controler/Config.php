<?php namespace App\Controllers\Controler;

use App\Models\Config as ConfigModel;
use App\Models\Chapters as ChaptersModel;
use App\Models\Articles as ArticlesModel;
use App\Models\Moduls as ModulsModel;
use App\Models\Languages as LanguagesModel;
use \Config\Database as Database;

class Config extends Base
{
	public function index($inPage='default',$id=0) 
	{
		
		if (!$this->controlTest('config')) { $inPage='false'; } 
		$list = $this->getList('config',$inPage);
		
		$ModulsModel = new ModulsModel;
		if ($inPage=='moduls') { 
			$list['moduls'] = $ModulsModel->findAll();
		}
		if ($inPage=='editmodul') { 
			$list['modul'] = $id;
		}
		
		$data['list']=(object)$list;
		
		echo view($this->path.'top',$data);
		echo view($this->path.'config',$data);
		
	}
	
	function editDefaultChangeFreqChapters() {
	
		set_time_limit(200000000000);
		ini_set("max_execution_time", "10000000000"); 
		ini_set('memory_limit','512M');
	
		if (!$this->controlTest('config')) { exit; } 
		$ChaptersModel = new ChaptersModel;
		$ConfigModel = new ConfigModel;
		$session = session();
		
		if (isset($_POST['changefreqChapters'])) { 
			$Database = new Database;
			$mysqli = mysqli_connect($Database->default['hostname'], $Database->default['username'], $Database->default['password'], $Database->default['database']);
			$data['changefreqChapters']=$_POST['changefreqChapters']; 
			$changefreqChapters = $data['changefreqChapters'];
			$mysqli->query("ALTER TABLE ns_chapters ALTER changefreq DROP DEFAULT");
			$mysqli->query("ALTER TABLE ns_chapters ALTER changefreq SET DEFAULT '$changefreqChapters'");
			$chapters = $ChaptersModel->findAll();
			foreach ($chapters as $one):
				$dataChapter = array(
					'chapterId' => $one['chapterId'],
					'changefreq' => $changefreqChapters
				);
				$ChaptersModel->update($one['chapterId'],$dataChapter);
				unset($dataChapter);
			endforeach;
			$ConfigModel->editConfig($data);
			unset($data);
		}
			
		$session->set('message4',Saved); 
		redirect ('/controler/config/index/default');
			
	}
	
	function editDefaultPriorityChapters() {
	
		set_time_limit(200000000000);
		ini_set("max_execution_time", "10000000000"); 
		ini_set('memory_limit','512M');
	
		if (!$this->controlTest('config')) { exit; } 
		$ChaptersModel = new ChaptersModel;
		$ConfigModel = new ConfigModel;
		$session = session();
			
		if (isset($_POST['priorityChapters'])) { 
			$Database = new Database;
			$mysqli = mysqli_connect($Database->default['hostname'], $Database->default['username'], $Database->default['password'], $Database->default['database']);
			$data['priorityChapters']=$_POST['priorityChapters']; 
			$priorityChapters = $data['priorityChapters'];
			$mysqli->query("ALTER TABLE ns_chapters ALTER priority DROP DEFAULT");
			$mysqli->query("ALTER TABLE ns_chapters ALTER priority SET DEFAULT '$priorityChapters'");
			$chapters = $ChaptersModel->findAll();
			foreach ($chapters as $one):
				$dataChapter = array(
					'chapterId' => $one['chapterId'],
					'priority' => $priorityChapters
				);
				$ChaptersModel->update($one['chapterId'],$dataChapter);
				unset($dataChapter);
			endforeach;
			$ConfigModel->editConfig($data);
			unset($data);
		}
			
		$session->set('message4',Saved); 
		redirect ('/controler/config/index/default');
			
	}
	
	function editDefaultChangeFreqArticles() {
	
		set_time_limit(200000000000);
		ini_set("max_execution_time", "10000000000"); 
		ini_set('memory_limit','512M');
	
		if (!$this->controlTest('config')) { exit; } 
		$ArticlesModel = new ArticlesModel;
		$ConfigModel = new ConfigModel;
		$session = session();
			
		if (isset($_POST['changefreqArticles'])) { 
			$Database = new Database;
			$mysqli = mysqli_connect($Database->default['hostname'], $Database->default['username'], $Database->default['password'], $Database->default['database']);
			$data['changefreqArticles']=$_POST['changefreqArticles']; 
			$changefreqArticles = $data['changefreqArticles'];
			$mysqli->query("ALTER TABLE ns_articles ALTER changefreq DROP DEFAULT");
			$mysqli->query("ALTER TABLE ns_articles ALTER changefreq SET DEFAULT '$changefreqArticles'");
			$articles = $ArticlesModel->findAll();
			foreach ($articles as $one):
				$dataArticle = array(
					'articleId' => $one['articleId'],
					'changefreq' => $changefreqArticles
				);
				$ArticlesModel->update($one['articleId'],$dataArticle);
				unset($dataArticle);
			endforeach;
			$ConfigModel->editConfig($data);
			unset($data);
		}
			
		$session->set('message4',Saved); 
		redirect ('/controler/config/index/default');
			
	}
	
	function editDefaultPriorityArticles() {
	
		set_time_limit(200000000000);
		ini_set("max_execution_time", "10000000000"); 
		ini_set('memory_limit','512M');
	
		if (!$this->controlTest('config')) { exit; } 
		$ArticlesModel = new ArticlesModel;
		$ConfigModel = new ConfigModel;
		$session = session();
			
		if (isset($_POST['priorityArticles'])) { 
			$Database = new Database;
			$mysqli = mysqli_connect($Database->default['hostname'], $Database->default['username'], $Database->default['password'], $Database->default['database']);
			$data['priorityArticles']=$_POST['priorityArticles']; 
			$priorityArticles = $data['priorityArticles'];
			$mysqli->query("ALTER TABLE ns_articles ALTER priority DROP DEFAULT");
			$mysqli->query("ALTER TABLE ns_articles ALTER priority SET DEFAULT '$priorityArticles'");
			$articles = $ArticlesModel->findAll();
			foreach ($articles as $one):
				$dataArticle = array(
					'articleId' => $one['articleId'],
					'priority' => $priorityArticles
				);
				$ArticlesModel->update($one['articleId'],$dataArticle);
				unset($dataArticle);
			endforeach;
			$ConfigModel->editConfig($data);
			unset($data);
		}
			
		$session->set('message4',Saved); 
		redirect ('/controler/config/index/default');
			
	}
	
	function editDefaultAtView() {
	
		set_time_limit(200000000000);
		ini_set("max_execution_time", "10000000000"); 
		ini_set('memory_limit','512M');
	
		if (!$this->controlTest('config')) { exit; } 
		$ChaptersModel = new ChaptersModel;
		$ConfigModel = new ConfigModel;
		$session = session();
				
		if (isset($_POST['defaultAtView'])) { 
			$Database = new Database;
			$mysqli = mysqli_connect($Database->default['hostname'], $Database->default['username'], $Database->default['password'], $Database->default['database']);
			$data['defaultAtView']=$_POST['defaultAtView']; 
			$defaultAtView = $data['defaultAtView'];
			$mysqli->query("ALTER TABLE ns_chapters ALTER atView DROP DEFAULT");
			$mysqli->query("ALTER TABLE ns_chapters ALTER atView SET DEFAULT '$defaultAtView'");
			$chapters = $ChaptersModel->findAll();
			foreach ($chapters as $one):
				$dataChapter = array(
					'chapterId' => $one['chapterId'],
					'atView' => $defaultAtView
				);
				$ChaptersModel->update($one['chapterId'],$dataChapter);
				unset($dataChapter);
			endforeach;
			$ConfigModel->editConfig($data);
			unset($data);
		}
			
		$session->set('message3',Saved); 
		redirect ('/controler/config/index/default');
			
	}
	
	function editDefaultBreed() {
	
		set_time_limit(200000000000);
		ini_set("max_execution_time", "10000000000"); 
		ini_set('memory_limit','512M');
	
		if (!$this->controlTest('config')) { exit; } 
		$ChaptersModel = new ChaptersModel;
		$ConfigModel = new ConfigModel;
		$session = session();
			
		if (isset($_POST['defaultBreed'])) { 
			$Database = new Database;
			$mysqli = mysqli_connect($Database->default['hostname'], $Database->default['username'], $Database->default['password'], $Database->default['database']);
			$data['defaultBreed']=$_POST['defaultBreed']; 
			$defaultBreed = $data['defaultBreed'];
			$mysqli->query("ALTER TABLE ns_chapters ALTER breed DROP DEFAULT");
			$mysqli->query("ALTER TABLE ns_chapters ALTER breed SET DEFAULT '$defaultBreed'");
			$chapters = $ChaptersModel->findAll();
			foreach ($chapters as $one):
				$dataChapter = array(
					'chapterId' => $one['chapterId'],
					'breed' => $defaultBreed
				);
				$ChaptersModel->update($one['chapterId'],$dataChapter);
				unset($dataChapter);
			endforeach;
			$ConfigModel->editConfig($data);
			unset($data);
		}
		
		$session->set('message3',Saved); 
		redirect ('/controler/config/index/default');
			
	}
	
	function editDefaultSlider() {
	
		set_time_limit(200000000000);
		ini_set("max_execution_time", "10000000000"); 
		ini_set('memory_limit','512M');
	
		if (!$this->controlTest('config')) { exit; } 
		$ChaptersModel = new ChaptersModel;
		$ConfigModel = new ConfigModel;
		$session = session();
		
		$_POST['defaultSliderWidth'] = (int)$_POST['defaultSliderWidth'];
		$_POST['defaultSliderHeight'] = (int)$_POST['defaultSliderHeight']/1;
		if (!is_int($_POST['defaultSliderWidth'])) {
			$_POST['defaultSliderWidth']=1; 
		}
		if (!is_int($_POST['defaultSliderHeight'])) {
			$_POST['defaultSliderHeight']=1; 
		}
		
		if (isset($_POST['defaultSliderWidth'])) { 
			$Database = new Database;
			$mysqli = mysqli_connect($Database->default['hostname'], $Database->default['username'], $Database->default['password'], $Database->default['database']);
			if ($_POST['defaultSliderWidth']<1) {
				$data['defaultSliderWidth']=1; 
			} else {
				$data['defaultSliderWidth']=$_POST['defaultSliderWidth']; 
			}
			$defaultSliderWidth = $data['defaultSliderWidth'];
			$mysqli->query("ALTER TABLE ns_chapters ALTER sliderWidth DROP DEFAULT");
			$mysqli->query("ALTER TABLE ns_chapters ALTER sliderWidth SET DEFAULT '$defaultSliderWidth'");
			$chapters = $ChaptersModel->findAll();
			foreach ($chapters as $one):
				$dataChapter = array(
					'chapterId' => $one['chapterId'],
					'sliderWidth' => $defaultSliderWidth
				);
				$ChaptersModel->update($one['chapterId'],$dataChapter);
				unset($dataChapter);
			endforeach;
				
			$ConfigModel->editConfig($data);
			unset($data);
		}
			
		if (isset($_POST['defaultSliderHeight'])) { 
			$Database = new Database;
			$mysqli = mysqli_connect($Database->default['hostname'], $Database->default['username'], $Database->default['password'], $Database->default['database']);
			if ($_POST['defaultSliderHeight']<1) {
				$data['defaultSliderHeight']=1; 
			} else {
				$data['defaultSliderHeight']=$_POST['defaultSliderHeight']; 
			}
			$defaultSliderHeight = $data['defaultSliderHeight'];
			$mysqli->query("ALTER TABLE ns_chapters ALTER sliderHeight DROP DEFAULT");
			$mysqli->query("ALTER TABLE ns_chapters ALTER sliderHeight SET DEFAULT '$defaultSliderHeight'");
			$chapters = $ChaptersModel->findAll();
			foreach ($chapters as $one):
				$dataChapter = array(
					'chapterId' => $one['chapterId'],
					'sliderHeight' => $defaultSliderHeight
				);
				$ChaptersModel->update($one['chapterId'],$dataChapter);
				unset($dataChapter);
			endforeach;
				
			$ConfigModel->editConfig($data);
			unset($data);
		}
			
		if (isset($_POST['defaultSliderFix'])) { 
			$Database = new Database;
			$mysqli = mysqli_connect($Database->default['hostname'], $Database->default['username'], $Database->default['password'], $Database->default['database']);
			$data['defaultSliderFix']=1; 
			$defaultSliderFix = $data['defaultSliderFix'];
			$mysqli->query("ALTER TABLE ns_chapters ALTER sliderFix DROP DEFAULT");
			$mysqli->query("ALTER TABLE ns_chapters ALTER sliderFix SET DEFAULT '$defaultSliderFix'");
			$chapters = $ChaptersModel->findAll();
			foreach ($chapters as $one):
				$dataChapter = array(
					'chapterId' => $one['chapterId'],
					'sliderFix' => $defaultSliderFix
				);
				$ChaptersModel->update($one['chapterId'],$dataChapter);
				unset($dataChapter);
			endforeach;
				
			$ConfigModel->editConfig($data);
			unset($data);
		} else {
			$Database = new Database;
			$mysqli = mysqli_connect($Database->default['hostname'], $Database->default['username'], $Database->default['password'], $Database->default['database']);
			$data['defaultSliderFix']=0; 
			$defaultSliderFix = $data['defaultSliderFix'];
			$mysqli->query("ALTER TABLE ns_chapters ALTER sliderFix DROP DEFAULT");
			$mysqli->query("ALTER TABLE ns_chapters ALTER sliderFix SET DEFAULT '$defaultSliderFix'");
			$chapters = $ChaptersModel->findAll();
			foreach ($chapters as $one):
				$dataChapter = array(
					'chapterId' => $one['chapterId'],
					'sliderFix' => $defaultSliderFix
				);
				$ChaptersModel->update($one['chapterId'],$dataChapter);
				unset($dataChapter);
			endforeach;
				
			$ConfigModel->editConfig($data);
			unset($data);
		}
			
		if (isset($_POST['defaultSliderFreq'])) { 
			$Database = new Database;
			$mysqli = mysqli_connect($Database->default['hostname'], $Database->default['username'], $Database->default['password'], $Database->default['database']);
			if ($_POST['defaultSliderFreq']<1) {
				$data['defaultSliderFreq']=1; 
			} else {
				$data['defaultSliderFreq']=$_POST['defaultSliderFreq']; 
			}
			$defaultSliderFreq = $data['defaultSliderFreq'];
			$mysqli->query("ALTER TABLE ns_chapters ALTER sliderFreq DROP DEFAULT");
			$mysqli->query("ALTER TABLE ns_chapters ALTER sliderFreq SET DEFAULT '$defaultSliderFreq'");
			$chapters = $ChaptersModel->findAll();
			foreach ($chapters as $one):
				$dataChapter = array(
					'chapterId' => $one['chapterId'],
					'sliderFreq' => $defaultSliderFreq
				);
				$ChaptersModel->update($one['chapterId'],$dataChapter);
				unset($dataChapter);
			endforeach;
				
			$ConfigModel->editConfig($data);
			unset($data);
		}
			
			
		$session->set('message6',Saved); 
		redirect ('/controler/config/index/default');
			
	}
	
	function editDefaultSubChapters() {
	
		set_time_limit(200000000000);
		ini_set("max_execution_time", "10000000000"); 
		ini_set('memory_limit','512M');
	
		if (!$this->controlTest('config')) { exit; } 
		$ChaptersModel = new ChaptersModel;
		$ConfigModel = new ConfigModel;
		$session = session();
			
		if (isset($_POST['subChapters'])) { 
			$Database = new Database;
			$mysqli = mysqli_connect($Database->default['hostname'], $Database->default['username'], $Database->default['password'], $Database->default['database']);
			$data['subChapters']=$_POST['subChapters']; 
			$subChapters = $data['subChapters'];
			$mysqli->query("ALTER TABLE ns_chapters ALTER subChapters DROP DEFAULT");
			$mysqli->query("ALTER TABLE ns_chapters ALTER subChapters SET DEFAULT '$subChapters'");
			$chapters = $ChaptersModel->findAll();
			foreach ($chapters as $one):
				$dataChapter = array(
					'chapterId' => $one['chapterId'],
					'subChapters' => $subChapters
				);
				$ChaptersModel->update($one['chapterId'],$dataChapter);
				unset($dataChapter);
			endforeach;
			$ConfigModel->editConfig($data);
			unset($data);
		}
			
		$session->set('message3',Saved); 
		redirect ('/controler/config/index/default');
			
	}
	
	function editDefaultChapters() {
	
		if (!$this->controlTest('config')) { exit; } 
		$ConfigModel = new ConfigModel;
		$session = session();
			
		if (isset($_POST['openChapters'])) { $data['openChapters']=1; } else { $data['openChapters']=0; }
		if (isset($_POST['openChaptersCt'])) { $data['openChaptersCt']=1; } else { $data['openChaptersCt']=0; }
		if (isset($_POST['seeNoActiveChapters'])) { $data['seeNoActiveChapters']=1; } else { $data['seeNoActiveChapters']=0; }
		$ConfigModel->editConfig($data);
				
		$session->set('message',Saved); 
		redirect ('/controler/config/index/default');
			
	}
	
	function editImageChapters () {
	
		if (!$this->controlTest('config')) { exit; } 
		$ConfigModel = new ConfigModel;
		$session = session();
			
		if ($this->request->getFiles('userfile')) {
			$userfile = $this->request->getFiles('userfile');
			$file = $userfile['userfile'];
			
			if ($file->isValid() && ! $file->hasMoved()) {
         
				if ((mb_strtolower($file->getClientExtension())=='jpg')OR($file->getClientExtension()=='png')OR($file->getClientExtension()=='jpeg')OR($file->getClientExtension()=='gif')OR($file->getClientExtension()=='svg')) {
					
					$randomName = $file->getRandomName();
					$file->move('img/system', $randomName);
					$preview = 'img/system/'.$randomName;
					
					$noImage = $ConfigModel->giveConfParam('noImage');
					if (file_exists($noImage)) {
						unlink($noImage);
					}
					
					$data = array ('noImage' => $preview);
					$ConfigModel->editConfig($data);
					
					$session->set('message1',Saved); 
					
				} 
			
			} 
			
		}
			
		if (isset($_POST['gallerySmWidth'])) { 
			if ($_POST['gallerySmWidth']<1) {
				$data['gallerySmWidth']=1; 
			} else {
				$data['gallerySmWidth']=$_POST['gallerySmWidth']; 
			}
		}
		if (isset($_POST['gallerySmHeight'])) { 
			if ($_POST['gallerySmHeight']<1) {
				$data['gallerySmHeight']=1; 
			} else {
				$data['gallerySmHeight']=$_POST['gallerySmHeight']; 
			}
		}
			
		$ConfigModel->editConfig($data);
				
		$session->set('message1',Saved); 
		redirect ('/controler/config/index/default');
			
	}
	
	function delNoImage () {
	
		if (!$this->controlTest('config')) { exit; } 
		$ConfigModel = new ConfigModel;
		
		$noImage = $ConfigModel->giveConfParam('noImage');
		if (file_exists($noImage)) {
			unlink($noImage);
		}
		$data = array ('noImage' => '');
		$ConfigModel->editConfig($data);
			
	}
	
	function editLanguage() {
	
		if (!$this->controlTest('config')) { exit; } 
		$ConfigModel = new ConfigModel;
		$session = session();
			
		$languages = file_get_contents(APPPATH.'Language/ctlang.json'); 
		$languages = json_decode($languages);    
		$array = array(); 
		foreach ($languages as $one) { 
			if($_POST['language']==$one->nick) {
				$one->selected = 1;
			} else {
				$one->selected = 0;
			}
			array_push($array,$one);
		}
		$array = json_encode($array);
		
		file_put_contents(APPPATH.'Language/ctlang.json', $array);

		$session->set('message',Saved); 
		redirect ('/controler/config/index/language');
			
	}

	function editProtokol() {
	
		if (!$this->controlTest('config')) { exit; } 
		$ConfigModel = new ConfigModel;
		$session = session();
		
		$data = array (
			'protokol' => $_POST['protokol'],
		);
			
		$ConfigModel->editConfig($data);
				
		$session->set('message',Saved); 
		redirect ('/controler/config/index/protocol');
			
	}

	function editTemplate() {
	
		if (!$this->controlTest('config')) { exit; } 
		$ConfigModel = new ConfigModel;
		$session = session();
		
		$data = array (
			'admincss' => $_POST['admincss'],
		);
			
		$ConfigModel->editConfig($data);
				
		$session->set('message',Saved); 
		redirect ('/controler/config/index/template');
			
	}
	
	function editClose () {
	
		if (!$this->controlTest('config')) { exit; } 
		$ConfigModel = new ConfigModel;
		$session = session();
		
		$data = array ('closelogin' => $_POST['closelogin'], 'closepassword' => $_POST['closepassword']);
		if (isset($_POST['close'])) { $data['close']=1; } else { $data['close']=0; }
				
		$ConfigModel->editConfig($data);
		
		$session->set('message',Saved); 
		redirect ('/controler/config/index/close');
			
	}
	
	function changeMyModulView () {
	
		if (!$this->controlTest('config')) { exit; } 
		$session = session();
		$session->set('myModulView',$_POST['type']);
			
	}
	
	function addModul () {
	
		if (!$this->controlTest('config')) { exit; } 
		$ModulsModel = new ModulsModel;
		$session = session();
			
		$language = str_replace ('_','',session('languageBase'));
		if ($language!='') { $language = $language.'/'; }
			
		$dir = APPPATH.'/Views/moduls';
		$moduls = scandir($dir);
			
		$stop=0;
		foreach ($moduls as $one):
			if ($one==$_POST['name'].'.php') {
				$message = Module_already_isset;
				$stop=1;
			}
		endforeach;
			
		if ($stop==0) {
				
			$file = APPPATH.'Views/moduls/'.$language.$_POST['name'].'.php';
			$fp = fopen($file, "w"); 
			fwrite($fp, '<?=\''.$_POST['name'].'\'?>');
			fclose($fp);
			
			if ($language!='') {
				$file = APPPATH.'Views/moduls/'.$_POST['name'].'.php';
				$fp = fopen($file, "w"); 
				fwrite($fp, '<?=\''.$_POST['name'].'\'?>');
				fclose($fp);
			}
				
			$message = Added;
				
		}	
			
		$session->set('message',$message); 
		redirect ('/controler/config/index/moduls');
			
	}
	
	function editModul () {
	
		if (!$this->controlTest('config')) { exit; } 
		$ModulsModel = new ModulsModel;
		$session = session();
			
		$language = str_replace ('_','',session('languageBase'));
		if ($language!='') { $language = $language.'/'; }
		
		if ($_POST['id']==$_POST['name']) {
		
			$file = APPPATH.'Views/moduls/'.$language.$_POST['name'].'.php';
			$fp = fopen($file, "w"); 
			fwrite($fp, $_POST['text']);
			fclose($fp);
			$message = Saved;
			
		} else {
			
			$dir = APPPATH.'/Views/moduls';
			$moduls = scandir($dir);
			
			$stop=0;
			foreach ($moduls as $one):
				if ($one==$_POST['name'].'.php') {
					$message = Module_already_isset;
					$stop=1;
				}
			endforeach;
			
			if ($stop==0) {
				
				$file = APPPATH.'Views/moduls/'.$language.$_POST['name'].'.php';
				$fp = fopen($file, "w"); 
				fwrite($fp, $_POST['text']);
				fclose($fp);
				
				if (file_exists(APPPATH.'Views/moduls/'.$language.$_POST['id'].'.php')) {
					unlink(APPPATH.'Views/moduls/'.$language.$_POST['id'].'.php');
				}
				if (file_exists(APPPATH.'Views/moduls/'.$_POST['id'].'.php')) {
					unlink(APPPATH.'Views/moduls/'.$_POST['id'].'.php');
				}
				
				$message = Saved;
				
			}
			
		}
				
		$session->set('message',$message); 
		redirect ('/controler/config/index/editmodul/'.$_POST['name']);
			
	}
	
	function delModul () {
	
		if (!$this->controlTest('config')) { exit; } 
		$ModulsModel = new ModulsModel;
		$LanguagesModel = new LanguagesModel;
		$languages = $LanguagesModel->findAll();
		
		$file = APPPATH.'Views/moduls/'.$_POST['id'].'.php';
		if (file_exists($file)) {
			unlink($file);
			foreach ($languages as $one):
				if (file_exists(APPPATH.'Views/moduls/'.$one['url'].'/'.$_POST['id'].'.php')) {
					unlink(APPPATH.'Views/moduls/'.$one['url'].'/'.$_POST['id'].'.php');
				}
			endforeach;
		}
		
		$ModulsModel->turnOffModuls($_POST['id']);
		
	}
			
	
}
