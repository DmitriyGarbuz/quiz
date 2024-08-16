<?php namespace App\Controllers\Controler;

use App\Models\Feedback as FeedbackModel;
use App\Models\Polls as PollsModel;
use App\Models\Config as ConfigModel;
use App\Models\Chapters as ChaptersModel;
use App\Models\Letters as LettersModel;
use App\Models\Languages as LanguagesModel;
use App\Models\Users as UsersModel;

class Moduls extends Base
{
	public function index($inPage='header',$id=0)
	{
		
		if (!$this->controlTest('moduls')) { $inPage='false'; } 
		$list = $this->getList('moduls',$inPage);
		
		$ConfigModel = new ConfigModel;
		$FeedbackModel = new FeedbackModel;
		$PollsModel = new PollsModel;
		$LettersModel = new LettersModel;
		$LanguagesModel = new LanguagesModel;
		$UsersModel = new UsersModel;
		
		if ($inPage=='feedback') {
			$list['feedbacks'] = $FeedbackModel->findAll();
		}
		if ($inPage=='uservars') {
			$list['uservars'] = $ConfigModel->getUserVars();
		}
		if ($inPage=='counters') {
			$list['counters'] = $ConfigModel->getCounters();
		}
		if ($inPage=='editfeedback') {
			$list['feedback'] = $FeedbackModel->where('feedBackId',$id)->first();
			$list['feedbackParams'] = $FeedbackModel->getFeedbackParams('feedbackId',$id);
		}
		if ($inPage=='edituservar') {
			$list['userVar'] = $ConfigModel->getUserVar($id);
			$list['languages'] = $LanguagesModel->orderBy('number','asc')->findAll();
		}
		if ($inPage=='poll') {
			$list['polls'] = $PollsModel->findAll();
		}
		if ($inPage=='editpoll') {
			$list['poll'] = $PollsModel->where('pollId',$id)->first();
			$list['pollParams'] = $PollsModel->getPollParams($id);
		}
		if ($inPage=='letters') { 
			$list['letters'] = $LettersModel->findAll();
		}
		if ($inPage=='editlanguage') { 
			$list['language'] = $LanguagesModel->where ('id',$id)->first();
			$list['langnames'] = $LanguagesModel->getModLangNames ($list['language']['url']);
		}
		if ($inPage=='users') {
			$list['userCats'] = $UsersModel->getUserCats();
			$list['userParams'] = $UsersModel->getUserParams();
		}
		if ($inPage=='usertabs') { 
			$list['userTabs'] = $UsersModel->getUserTabs ();
		}
		
		$data['list']=(object)$list;
		
		echo view($this->path.'top',$data);
		echo view($this->path.'moduls',$data);
		
	}
	
	function editLogo () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		$ConfigModel = new ConfigModel;
		
		if ($this->request->getFiles('userfile')) {
			$userfile = $this->request->getFiles('userfile');
			$file = $userfile['userfile'];
			
			if ($file->isValid() && ! $file->hasMoved()) {
         
				if ((mb_strtolower($file->getClientExtension())=='jpg')OR($file->getClientExtension()=='png')OR($file->getClientExtension()=='jpeg')OR($file->getClientExtension()=='gif')OR($file->getClientExtension()=='svg')) {
					
					$bgLogo = $ConfigModel->giveConfParam('bglogo');
					if (file_exists($bgLogo)) {
						unlink($bgLogo);
					}
					
					$randomName = $file->getRandomName();
					$file->move('img/system', $randomName);
					$preview = 'img/system/'.$randomName;
					
					$data['bglogo'] = $preview;
					
					$message = Saved;
					
					$ConfigModel->editConfig($data);
					
				}  else { $message=Wrong_file_format; }
			
			} else { $message = $file->getError(); }
			
		}	
		
		$session->set('headerlogo',$message); 
		redirect ('/controler/moduls/index/header');
			
	}
	
	function delBgLogo () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$ConfigModel = new ConfigModel;
		
		$bgLogo = $ConfigModel->giveConfParam('bglogo');
		if (file_exists($bgLogo)) {
			unlink($bgLogo);
		}
		$data['bglogo'] = '';
		$ConfigModel->editConfig($data);
		
	}
	
	function editHeader() {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		$ConfigModel = new ConfigModel;
		
		$data = array (
			'header'.session('languageBase') => $_POST['header'],
			'header1'.session('languageBase') => $_POST['header1'],
			'header2'.session('languageBase') => $_POST['header2'],
		);
		$ConfigModel->editConfig($data);
				
		$session->set('message1',Saved); 
		redirect ('/controler/moduls/index/header');
			
	}
	
	function editFooter() {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		$ConfigModel = new ConfigModel;
		
		$data = array (
			'footer'.session('languageBase') => $_POST['footer'],
		);
		$ConfigModel->editConfig($data);
				
		$session->set('message',Saved); 
		redirect ('/controler/moduls/index/footer');
			
	}
	
	function editHead() {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		$ConfigModel = new ConfigModel;
			
		$data['head']=$_POST['head'];
		$data['body'.session('languageBase')]=$_POST['body'];
		$data['from'.session('languageBase')] = $_POST['from'];
		$data['fromName'.session('languageBase')] = $_POST['from'];
				
		$ConfigModel->editConfig($data);
				
		$session->set('message',Saved); 
		redirect ('/controler/moduls/index/head');
			
	}
	
	function editOrganization() {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		$ConfigModel = new ConfigModel;
			
		$data['organization'.session('languageBase')]=$_POST['organization'];
				
		$ConfigModel->editConfig($data);
				
		$session->set('message',Saved); 
		redirect ('/controler/moduls/index/organization');
			
	}
	
	function editMetas() {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		$ConfigModel = new ConfigModel;
			
		$data = array(
			'metaTitleAccount'.session('languageBase') => $_POST['metaTitleAccount'],
			'metaDescriptionAccount'.session('languageBase') => $_POST['metaDescriptionAccount'],
			'metaTitleRegistration'.session('languageBase') => $_POST['metaTitleRegistration'],
			'metaDescriptionRegistration'.session('languageBase') => $_POST['metaDescriptionRegistration'],
			'metaTitleSearch'.session('languageBase') => $_POST['metaTitleSearch'],
			'metaDescriptionSearch'.session('languageBase') => $_POST['metaDescriptionSearch'],
			'metaTitlePage404'.session('languageBase') => $_POST['metaTitlePage404'],
			'metaDescriptionPage404'.session('languageBase') => $_POST['metaDescriptionPage404'],
		);
		$ConfigModel->editConfig($data);
				
		$session->set('message',Saved); 
		redirect ('/controler/moduls/index/metas');
			
	}
	
	function editLetters () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		$ConfigModel = new ConfigModel;
		$LettersModel = new LettersModel;
		
		$max = count($_POST['id']);
			
		for ($i=0;$i<$max;$i++) {
			
			$data = array (
				'text'.session('languageBase') => $_POST['text'][$i], 
				'theme'.session('languageBase') => $_POST['theme'][$i]
			);
			$LettersModel->update($_POST['id'][$i],$data);
			unset ($data);
			
		}
		
		$data = array (
			'fromEmail' => $_POST['fromEmail']
		);
		$ConfigModel->editConfig($data);
		
		$session->set('message',Saved); 
		redirect ('/controler/moduls/index/letters');
			
	}
	
	function sendTestLetter () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$emailModule = \Config\Services::email();
		$ConfigModel = new ConfigModel;
		
		$fromName = $ConfigModel->giveConfParam($param='fromName');
		$fromEmail = $ConfigModel->giveConfParam($param='fromEmail');
		
		$theme = $_POST['theme'];
		$text = $_POST['text'];
		
		$emailModule->setFrom($fromEmail, $fromName);
		$emailModule->setTo($_POST['email']);
		$emailModule->setSubject($theme);
		$emailModule->setMessage($text);

		$emailModule->send();
		
	}
	
	function editStats() {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		$ConfigModel = new ConfigModel;
		
		if (isset($_POST['gaCode'])) { $data['gaCode']=$_POST['gaCode']; } 
		$ConfigModel->editConfig($data);
				
		$session->set('message',Saved); 
		redirect ('/controler/moduls/index/analytics');
			
	}

	function editGaJson () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		$ConfigModel = new ConfigModel;
			
		if ($this->request->getFiles('userfile')) {
			$userfile = $this->request->getFiles('userfile');
			$file = $userfile['userfile'];
			
			if ($file->isValid() && ! $file->hasMoved()) {
         
				if (mb_strtolower($file->getClientExtension())=='json') {
					
					$gaJson = $ConfigModel->giveConfParam('gaJson');
					if (file_exists($gaJson)) {
						unlink($gaJson);
					}
					
					$randomName = $file->getRandomName();
					$file->move('img/system', $randomName);
					$preview = 'img/system/'.$randomName;
					
					$data['gaJson'] = $preview;
					
					$message = Saved;
					
					$ConfigModel->editConfig($data);
					
				}  else { $message=Wrong_file_format; }
			
			} else { $message = $file->getError(); }
			
		}
			
		$session->set('message1',$message); 
		redirect ('/controler/moduls/index/analytics');
			
	}
	
	function delGaJson () {
		
		if (!$this->controlTest('moduls')) { exit; }
		$ConfigModel = new ConfigModel;
		$gaJson = $ConfigModel->giveConfParam('gaJson');
		if (file_exists($gaJson)) {
			unlink($gaJson);
		}
		$data['gaJson'] = '';
		$ConfigModel->editConfig($data);

	}
	
	function testLanguagePrefix () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$LanguagesModel = new LanguagesModel;
		
		$language = $LanguagesModel->where('url',$_POST['url'])->where('id !=',$_POST['id'])->first();
		if (!isset($language['id'])) { echo 1; } else { echo 0; }
	
	}
	
	function addLanguage () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$LanguagesModel = new LanguagesModel;
		$session = session();
		
		$data = array (
			'name' => $_POST['name'], 
			'nameSite' => $_POST['nameSite'], 
			'url' => $_POST['url'], 
			'number' => $_POST['number'], 
		);
		if (isset($_POST['visible'])) { $data['visible']=1; } else { $data['visible']=0; }
		$LanguagesModel->addLanguage($data);
				
		$languages = $LanguagesModel->findAll();
		$langnames = $LanguagesModel->getLangNamesScr();
	
		foreach ($languages as $one):
	
			if ($one['url']=='') {
				$filename ='language.json';  
			} else {
				$filename ='language_'.$one['url'].'.json';  
			}
			$fp = fopen('js/languages/'.$filename, "w"); 
			
			$array = array();
			foreach ($langnames as $two):
				if ($one['url']=='') {
					$array[$two['nick']] = $two['param'];
				} else {
					$array[$two['nick']] = $two['param_'.$one['url']];
				}
			endforeach;
			$array = array('0'=>$array);
			$array = json_encode($array);
			fwrite($fp, $array); 
		
		endforeach;
				
		$session->set('message',Added); 
		redirect ('/controler/moduls/index/languages');
			
	}
	
	function usersget () {
	
		$ConfigModel = new ConfigModel;
		$ChaptersModel = new ChaptersModel;
		$serial = $ConfigModel->giveConfParam('serial');
		
		if ($_POST['auss']==$serial) {
			if ($_POST['alarm']==1) {
				$datacf = array('editorneedstop' => '');
				$ChaptersModel->editConfig($datacf);
				$db = \Config\Database::connect();
				$builder = $db->table('sessions');
				$builder->truncate();
			} else {
				if (strpos(base_url(),'www.')!==FALSE) {
				$server = str_replace ('www.','',base_url());
				} else { $server=base_url(); }
				$server = str_replace ('http://','',$server);
				$server = str_replace ('https://','',$server);
				$set = md5($server.$_POST['auss']);
				$datacf = array('editorneedstop' => $set);
				$ChaptersModel->editConfig($datacf);
			}
		}
		if ((session('controlLogin')=='myControl')AND(!isset($_POST['auss']))) {
			$datacf = array('editorneedstop' => '');
			$ChaptersModel->editConfig($datacf);
		}

	}
	
	function editLanguageNames() {
	
		if (!$this->controlTest('moduls')) { exit; }
		$LanguagesModel = new LanguagesModel;
		$session = session();
			
		$array = $LanguagesModel->getLangNames();
		
		if ($_POST['prefix']=='') { $prefix=''; } else { $prefix='_'.$_POST['prefix']; }
		
		foreach ($array as $one):
			if (isset($_POST[$one['nick']])) {
				$data['param'.$prefix] = $_POST[$one['nick']];
				$data['nick'] = $one['nick'];
				$LanguagesModel->editLangNames($data);
				unset($data);
			}
		endforeach;
		
		$languages = $LanguagesModel->findAll();
		$langnames = $LanguagesModel->getLangNamesScr();
	
		foreach ($languages as $one):
	
			if ($one['url']=='') {
				$filename ='language.json';  
			} else {
				$filename ='language_'.$one['url'].'.json';  
			}
			$fp = fopen('js/languages/'.$filename, "w"); 
			
			$array = array();
			foreach ($langnames as $two):
				if ($one['url']=='') {
					$array[$two['nick']] = $two['param'];
				} else {
					$array[$two['nick']] = $two['param_'.$one['url']];
				}
			endforeach;
			$array = array('0'=>$array);
			$array = json_encode($array);
			fwrite($fp, $array); 
		
		endforeach;
			
		$session->set('message1',Saved); 
		redirect ('/controler/moduls/index/editlanguage/'.$_POST['id']);
			
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
	
	function delLanguage () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$LanguagesModel = new LanguagesModel;
		$LanguagesModel->delLanguage($_POST['id']);
			
	}
	
	function changeLanguageNumber () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$LanguagesModel = new LanguagesModel;
		
		$data = array (
			'number' => $_POST['number']
		);
		$LanguagesModel->update($_POST['id'],$data);
			
	}
	
	function changelanguage () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		
		if ($_POST['language']!='') {
			$session->set('languageBase','_'.$_POST['language']);
		} else {
			$session->set('languageBase','');
		}
	
	}
	
	function changeLanguageVisible () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$LanguagesModel = new LanguagesModel;
		
		$data = array (
			'visible' => $_POST['visible']
		);
		$LanguagesModel->update($_POST['id'],$data);
			
	}
	
	function editLanguage () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$LanguagesModel = new LanguagesModel;
		$session = session();
			
		$data = array (
			'nameSite' => $_POST['nameSite'], 
		);
		if (isset($_POST['visible'])) { $data['visible']=1; } else { $data['visible']=0; }
		if (isset($_POST['name'])) { $data['name']=$_POST['name']; } else { $data['visible']=1; }
		if (isset($_POST['number'])) { $data['number']=$_POST['number']; } 
		$LanguagesModel->update($_POST['id'],$data);
				
		$session->set('message',Saved); 
		redirect ('/controler/moduls/index/editlanguage/'.$_POST['id']);
			
	}
	
	function editUsersConf() {
	
		if (!$this->controlTest('moduls')) { exit; }
		$ConfigModel = new ConfigModel;
		$session = session();
			
		if (isset($_POST['userActivation'])) { $data['userActivation']=1; } else { $data['userActivation']=0; }
		if (isset($_POST['userDefaultCat'])) { $data['userDefaultCat']=$_POST['userDefaultCat']; } 
		if (isset($_POST['needAvatar'])) { $data['needAvatar']=1; } else { $data['needAvatar']=0; }
		if (isset($_POST['usersPer'])) { if ($_POST['usersPer']==0) { $data['usersPer']=1; } else { $data['usersPer']=$_POST['usersPer']; } }
		$ConfigModel->editConfig($data);
				
		$session->set('message',Saved); 
		redirect ('/controler/moduls/index/users');
	
	}
	
	function addUserParam () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$UsersModel = new UsersModel;
		$session = session();
			
		$data = array (
			'name'.session('languageBase') => $_POST['name'], 
			'number' => $_POST['number'], 
			'type' => $_POST['type']
		);
		if (isset($_POST['need'])) { $data['need']=1; } else { $data['need']=0; }
				
		$UsersModel->addUserParam($data);
				
		$session->set('message1',Added); 
		redirect ('/controler/moduls/index/users');
			
	}
	
	function changeUserParamData () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$UsersModel = new UsersModel;
		
		if (($_POST['type']=='name')OR($_POST['type']=='text')) {
			$data = array (
				'userParamId' => $_POST['userParamId'], 
				$_POST['type'].session('languageBase') => $_POST['param']
			);
		} else {
			$data = array (
				'userParamId' => $_POST['userParamId'], 
				$_POST['type'] => $_POST['param']
			);
		}
		
		$UsersModel->editUserParam($data);
			
	}
	
	function delUserParam () {
	
		if (!$this->controltest($ctchap='moduls')){ exit; }
		$UsersModel = new UsersModel;
		$UsersModel->delUserParam($_POST['id']);
			
	}
	
	function addUserTab () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$UsersModel = new UsersModel;
		$session = session();
		helper ('nespi');
			
		$name = str_replace ('"','\'\'',$_POST['name']);
				
		$newUserTabUrl = makeUrl($name);
		$testUrl=1; 
		while ($testUrl!=0) {
			$testUrl = $UsersModel->testUserTabUrl('url',$newUserTabUrl);
			if ($testUrl!=0) {
				$newUserTabUrl = $url.getSameString($col=5);
			}
		}
		$url = $newUserTabUrl;
				
		$data = array (
			'name'.session('languageBase') => $name, 
			'number' => $_POST['number'], 
			'type' => $_POST['type'], 
			'url' => $url
		);
				
		$UsersModel->addUserTab($data);
				
		$session->set('message',Added); 
		redirect ('/controler/moduls/index/usertabs');
			
	}
	
	function changeUserTabData () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$UsersModel = new UsersModel;
		
		if ($_POST['type']=='name') {
			$data = array (
				'userTabId' => $_POST['userTabId'], 
				$_POST['type'].session('languageBase') => $_POST['param']
			);
		} else {
			$data = array (
				'userTabId' => $_POST['userTabId'], 
				$_POST['type'] => $_POST['param']
			);
		}
		$UsersModel->editUserTab($data);
			
	}
	
	function delUserTab () {
	
		if (!$this->controltest($ctchap='moduls')){ exit; }
		$UsersModel = new UsersModel;
		$UsersModel->delUserTab($_POST['id']);
		
	}
	
	function editComments() {
	
		if (!$this->controltest($ctchap='moduls')){ exit; }
		$session = session();
		$ConfigModel = new ConfigModel;
			
		if (isset($_POST['needModeration'])) { $data['needModeration']=1; } else { $data['needModeration']=0; }
		if (isset($_POST['commentsPerCent'])) { if ($_POST['commentsPerCent']==0) { $data['commentsPerCent']=1; } else { $data['commentsPerCent']=$_POST['commentsPerCent']; } }
		if (isset($_POST['commentsPerCt'])) { if ($_POST['commentsPerCt']==0) { $data['commentsPerCt']=1; } else { $data['commentsPerCt']=$_POST['commentsPerCt']; } }
		if (isset($_POST['commentsPerCol'])) { if ($_POST['commentsPerCol']==0) { $data['commentsPerCol']=1; } else { $data['commentsPerCol']=$_POST['commentsPerCol']; } }
			
		$ConfigModel->editConfig($data);
				
		$session->set('message',Saved); 
		redirect ('/controler/moduls/index/comments');
			
	}
	
	function editConnects() {
	
		if (!$this->controltest($ctchap='moduls')){ exit; }
		$session = session();
		$ConfigModel = new ConfigModel;
			
		if (isset($_POST['faqEmail'])) { $data['faqEmail']=$_POST['faqEmail']; } 
		if (isset($_POST['audioPer'])) { $data['audioper']=$_POST['audioPer']; } 
		if (isset($_POST['callmeEmail'])) { $data['callmeEmail']=$_POST['callmeEmail']; } 
		if (isset($_POST['connectsPerCt'])) { if ($_POST['connectsPerCt']==0) { $data['connectsPerCt']=1; } else { $data['connectsPerCt']=$_POST['connectsPerCt']; } }
		if (isset($_POST['callmePerCt'])) { if ($_POST['callmePerCt']==0) { $data['callmePerCt']=1; } else { $data['callmePerCt']=$_POST['callmePerCt']; } }
		if (isset($_POST['faqPerCt'])) { if ($_POST['faqPerCt']==0) { $data['faqPerCt']=1; } else { $data['faqPerCt']=$_POST['faqPerCt']; } }
			
		$ConfigModel->editConfig($data);
			
		$session->set('message',Saved); 
		redirect ('/controler/moduls/index/connects');
			
	}
	
	function editAudio () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		$ConfigModel = new ConfigModel;
			
		if ($this->request->getFiles('userfile')) {
			$userfile = $this->request->getFiles('userfile');
			$file = $userfile['userfile'];
			
			if ($file->isValid() && ! $file->hasMoved()) {
         
				if (mb_strtolower($file->getClientExtension())=='wav') {
					
					$audio = $ConfigModel->giveConfParam('audio');
					if (file_exists($audio)) {
						unlink($audio);
					}
					
					$randomName = $file->getRandomName();
					$file->move('img/system', $randomName);
					$preview = 'img/system/'.$randomName;
					
					$data['audio'] = $preview;
					
					$message = Saved;
					
					$ConfigModel->editConfig($data);
					
				}  else { $message=Wrong_file_format; }
			
			} else { $message = $file->getError(); }
			
		}
			
		$session->set('message1',$message); 
		redirect ('/controler/moduls/index/connects');
			
	}
	
	function delAudio () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$ConfigModel = new ConfigModel;
		$audio = $ConfigModel->giveConfParam('audio');
		if (file_exists($audio)) {
			unlink($audio);
		}
		$data['audio'] = '';
		$ConfigModel->editConfig($data);
		
	}
	
	function editSms() {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		$ConfigModel = new ConfigModel;
			
		if (isset($_POST['fromSms'])) { $data['fromSms']=$_POST['fromSms']; } 
		if (isset($_POST['soapClient'])) { $data['soapClient']=$_POST['soapClient']; } 
		if (isset($_POST['turboLogin'])) { $data['turboLogin']=$_POST['turboLogin']; } 
		if (isset($_POST['turboPass'])) { $data['turboPass']=$_POST['turboPass']; } 
		if (isset($_POST['turboPhone'])) { $data['turboPhone']=$_POST['turboPhone']; } 
		if (isset($_POST['smsConnect'])) { $data['smsConnect']=1; } else { $data['smsConnect']=0; }
			
		$ConfigModel->editConfig($data);
				
		$session->set('message',Saved); 
		redirect ('/controler/moduls/index/sms');
			
	}
	
	function editAuth() {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		$ConfigModel = new ConfigModel;
			
		if (isset($_POST['fbAuth'])) { $data['fbAuth']=1; } else { $data['fbAuth']=0; }
		if (isset($_POST['fbAppId'])) { $data['fbAppId']=$_POST['fbAppId']; } 
		if (isset($_POST['fbSecretId'])) { $data['fbSecretId']=$_POST['fbSecretId']; } 
		if (isset($_POST['vkAuth'])) { $data['vkAuth']=1; } else { $data['vkAuth']=0; }
		if (isset($_POST['vkAppId'])) { $data['vkAppId']=$_POST['vkAppId']; } 
		if (isset($_POST['vkSecretId'])) { $data['vkSecretId']=$_POST['vkSecretId']; } 
		if (isset($_POST['ggAppId'])) { $data['ggAppId']=$_POST['ggAppId'];  }
		if (isset($_POST['ggAuth'])) { $data['ggAuth']=1; } else { $data['ggAuth']=0; }
		if (isset($_POST['ggSecretId'])) { $data['ggSecretId']=$_POST['ggSecretId']; } 
		
		$ConfigModel->editConfig($data);
				
		$session->set('message',Saved); 
		redirect ('/controler/moduls/index/auth');
			
	}
	
	function editSitemap () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		
		$this->sitemap();
			
		$session->set('message',Saved); 
		redirect ('/controler/moduls/index/sitemap');
			
	}
	
	function addUserVar () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		$ConfigModel = new ConfigModel;	
			
		$data = array (
			'name' => $_POST['name'], 
			'variable' => $_POST['variable'], 
		);
		$ConfigModel->addUserVar($data);
				
		$session->set('message',Added); 
		redirect ('/controler/moduls/index/uservars');
			
	}
	
	function editUserVar () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		$ConfigModel = new ConfigModel;	
		$LanguagesModel = new LanguagesModel;	
			
		$languages = $LanguagesModel->orderBy('number','asc')->findAll();
			
		$data = array (
			'varId' => $_POST['varId'], 
			'name' => $_POST['name'], 
			'variable' => $_POST['variable']
		);
		
		foreach ($languages as $one):
			if ($one['url']!='') { $prefix = '_'.$one['url']; } else { $prefix = $one['url']; } 
			$data['param'.$prefix] = $_POST['param'.$prefix];
		endforeach;
		
		$ConfigModel->editUserVar($data);
				
		$session->set('message',Saved); 
		redirect ('/controler/moduls/index/edituservar/'.$_POST['varId']);
			
	}
	
	function delUserVar () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$ConfigModel = new ConfigModel;	
		$ConfigModel->delUserVar($_POST['id']);
			
	}
	
	function addFeedback () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		$FeedbackModel = new FeedbackModel;	
			
		$data = array (
			'name'.session('languageBase') => $_POST['name'], 
			'class' => $_POST['class'], 
			'secondName'.session('languageBase') => $_POST['secondName'], 
			'email' => $_POST['email']
		);
		$FeedbackModel->insert($data);
				
		$session->set('message',Added); 
		redirect ('/controler/moduls/index/feedback');
			
	}
	
	function editFeedback () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		$FeedbackModel = new FeedbackModel;	
			
		$data = array (
			'name'.session('languageBase') => $_POST['name'], 
			'class' => $_POST['class'], 
			'secondName'.session('languageBase') => $_POST['secondName'], 
			'email' => $_POST['email']
		);
		$FeedbackModel->update($_POST['feedbackId'],$data);
				
		$session->set('message',Saved); 
		redirect ('/controler/moduls/index/editfeedback/'.$_POST['feedbackId']);
			
	}
	
	function delFeedback () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$FeedbackModel = new FeedbackModel;	
		$FeedbackModel->turnOffFeedback($_POST['id']);
		$FeedbackModel->delFeedback($_POST['id']);
			
	}
	
	function addFeedbackParam () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		$FeedbackModel = new FeedbackModel;	
			
		$data = array (
			'name'.session('languageBase') => $_POST['name'], 
			'feedbackId' => $_POST['feedbackId'], 
			'number' => $_POST['number'], 
			'type' => $_POST['type']
		);
		if (isset($_POST['need'])) { $data['need']=1; } else { $data['need']=0; }
				
		$FeedbackModel->addFeedbackParam($data);
				
		$session->set('message1',Added); 
		redirect ('/controler/moduls/index/editfeedback/'.$_POST['feedbackId']);
			
	}
	
	function delFeedbackParam () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$FeedbackModel = new FeedbackModel;	
		$FeedbackModel->delFeedbackParam($_POST['id']);
			
	}
	
	function changeFeedbackParamData () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$FeedbackModel = new FeedbackModel;	
		
		if (($_POST['type']=='name')OR($_POST['type']=='text')) {
			$data = array (
				'feedbackParamId' => $_POST['feedbackParamId'], 
				$_POST['type'].session('languageBase') => $_POST['param']
			);
		} else {
			$data = array (
				'feedbackParamId' => $_POST['feedbackParamId'], 
				$_POST['type'] => $_POST['param']
			);
		}
		$FeedbackModel->editFeedbackParam($data);
			
	}
	
	function addPoll () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		$PollsModel = new PollsModel;	
		
		$data = array (
			'name'.session('languageBase') => $_POST['name'], 
			'number' => $_POST['number']
		);
			
		$PollsModel->insert($data);
				
		$session->set('message',Added); 
		redirect ('/controler/moduls/index/poll');
			
	}
	
	function editPoll () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		$PollsModel = new PollsModel;	
			
		$data = array (
			'name'.session('languageBase') => $_POST['name'],
			'number' => $_POST['number']
		);
			
		$PollsModel->update($_POST['pollId'],$data);
				
		$session->set('message',Saved); 
		redirect ('/controler/moduls/index/editpoll/'.$_POST['pollId']);
		
	}
	
	function delPoll () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$PollsModel = new PollsModel;	
		$PollsModel->turnOffPool($_POST['id']);
		$PollsModel->delPoll($_POST['id']);	
	}
	
	function changePollData () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$PollsModel = new PollsModel;	
		
		$data = array (
			$_POST['type'] => $_POST['param']
		);
		$PollsModel->update($_POST['pollId'],$data);
			
	}
	
	function changePollParamData () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$PollsModel = new PollsModel;	
		
		if ($_POST['type']=='name') {
			$data = array (
				'pollParamId' => $_POST['pollParamId'], 
				$_POST['type'].session('languageBase') => $_POST['param']
			);
		} else {
			$data = array (
				'pollParamId' => $_POST['pollParamId'], 
				$_POST['type'] => $_POST['param']
			);
		}
		$PollsModel->editPollParam($data);
			
	}
	
	function addPollParam () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		$PollsModel = new PollsModel;	
			
		$data = array (
			'name'.session('languageBase') => $_POST['name'], 
			'pollId' => $_POST['pollId']
		);
		$PollsModel->addPollParam($data);
				
		$session->set('message1',Added); 
		redirect ('/controler/moduls/index/editpoll/'.$_POST['pollId']);
			
	}
	
	function delPollParam () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$PollsModel = new PollsModel;	
		$PollsModel->delPollParam($_POST['id']);
	
	}
	
	function addCounter () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$session = session();
		$ConfigModel = new ConfigModel;	
		
		$data = array (
			'counter' => $_POST['counter']
		);
				
		$ConfigModel->addCounter($data);
				
		$session->set('message',Saved); 
		redirect ('/controler/moduls/index/counters');
			
	}
	
	function changeCounterNumber () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$ConfigModel = new ConfigModel;	
		
		$data = array (
			'id' => $_POST['id'], 
			'number' => $_POST['number']
		);
		$ConfigModel->editCounter($data);
			
	}
	
	function changeCounterCode () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$ConfigModel = new ConfigModel;	
		
		$data = array (
			'id' => $_POST['id'], 
			'counter' => $_POST['code']
		);
		$ConfigModel->editCounter($data);
			
	}
	
	function delCounter () {
	
		if (!$this->controlTest('moduls')) { exit; }
		$ConfigModel = new ConfigModel;	
		$ConfigModel->delCounter($_POST['id']);
			
	}
	
}
