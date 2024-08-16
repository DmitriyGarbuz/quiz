<?php namespace App\Controllers\Controler;

use App\Models\Users as UsersModel;
use App\Models\Subsc as SubscModel;
use App\Models\Config as ConfigModel;

class Subsc extends Base
{
	public function index($inPage='list',$id=0)
	{
		
		if (!$this->controlTest('subsc')) { $inPage='false'; } 
		$list = $this->getList('subsc',$inPage);
		
		$UsersModel = new UsersModel;
		$SubscModel = new SubscModel;
		
		$list['userCats'] = $UsersModel->getUserCats();
		$list['userParams'] = $UsersModel->getUserParams();
		$list['subscs'] = $SubscModel->findAll();
		
		if ($id!=0) {
			$list['subsc'] = $SubscModel->where('id',$id)->first();
		} 
		
		$data['list']=(object)$list;
		
		echo view($this->path.'top',$data);
		echo view($this->path.'subsc',$data);
		
	}
	
	function sendTestSubsc () {
	
		if (!$this->controlTest('subsc')) { exit; }
		$ConfigModel = new ConfigModel;
		$email = \Config\Services::email();
		
		$theme = $_POST['theme'];
		$text = $_POST['text'];
		
		$fromName = $ConfigModel->giveConfParam($param='fromName');
		$fromEmail = $ConfigModel->giveConfParam($param='fromEmail');
		$arrayReceiver = $_POST['email'];
		
		$email->setFrom($fromEmail, $fromName);
		$email->setTo($arrayReceiver);
		
		$email->setSubject($theme);
		$email->setMessage($text);

		$email->send();
		
	}
	
	function addSubsc () {
	
		if (!$this->controlTest('subsc')) { exit; }
		$SubscModel = new SubscModel;
		
		$data = array (
			'name' => $_POST['name'], 
			'theme' => $_POST['theme'], 
			'text' => $_POST['text'], 
			'userCatId' => $_POST['userCatId']
		);
		$SubscModel->insert($data);
			
		redirect ('/controler/subsc');
			
	}
	
	function editSubsc () {
	
		if (!$this->controlTest('subsc')) { exit; }
		$SubscModel = new SubscModel;	
		$session = session();
		
		$data = array ('id' => $_POST['id'], 'number' => $_POST['number'], 'name' => $_POST['name'], 'theme' => $_POST['theme'], 'text' => $_POST['text'], 'userCatId' => $_POST['userCatId']);
			
		$SubscModel->update($_POST['id'],$data);
			
		$session->set('message',Saved); 
		redirect ('/controler/subsc/index/edit/'.$_POST['id']);
			
	}
	
	function delSubsc () {
	
		if (!$this->controlTest('subsc')) { exit; }
		$SubscModel = new SubscModel;
		$SubscModel->delete($_POST['id']);
			
	}
	
	function makeSubsc ($id=0) {
	
		if (!$this->controlTest('subsc')) { exit; }
		$SubscModel = new SubscModel;
		$UsersModel = new UsersModel;
		$ConfigModel = new ConfigModel;
		$session = session();
			
		$theme = $_POST['theme'];
		$text = $_POST['text'];
			
		if ($_POST['userCatId']!=0) { 
			$users = $UsersModel->where('parent',$_POST['userCatId'])->find();
		} else {
			$users = $UsersModel->findAll();
		}
			
		if ((isset($_POST['fio']))AND($_POST['fio']!='')) {
			$usersTest = $UsersModel->where('fio',$_POST['fio'])->find();
			if (count($usersTest)>0) {
				$newUsers = array();
				foreach ($users as $two):
					foreach ($usersTest as $three):
						if ($two['code']==$three['code']) {
							$stop=0;
							foreach ($newUsers as $four):
								if ($four['code']==$two['code']) {
									$stop=1;
								}
							endforeach;
							if ($stop==0) {
								$newUsers[] = $two;
							}
						}
					endforeach;
				endforeach;
				$users = $newUsers;
			}
		}
		if ((isset($_POST['surname']))AND($_POST['surname']!='')) {
			$usersTest = $UsersModel->where('surname',$_POST['surname'])->find();
			if (count($usersTest)>0) {
				$newUsers = array();
				foreach ($users as $two):
					foreach ($usersTest as $three):
						if ($two['code']==$three['code']) {
							$stop=0;
							foreach ($newUsers as $four):
								if ($four['code']==$two['code']) {
									$stop=1;
								}
							endforeach;
							if ($stop==0) {
								$newUsers[] = $two;
							}
						}
					endforeach;
				endforeach;
				$users = $newUsers;
			}
		}
		if ((isset($_POST['phone']))AND($_POST['phone']!='')) {
			$usersTest = $UsersModel->where('phone',$_POST['phone'])->find();
			if (count($usersTest)>0) {
				$newUsers = array();
				foreach ($users as $two):
					foreach ($usersTest as $three):
						if ($two['code']==$three['code']) {
							$stop=0;
							foreach ($newUsers as $four):
								if ($four['code']==$two['code']) {
									$stop=1;
								}
							endforeach;
							if ($stop==0) {
								$newUsers[] = $two;
							}
						}
					endforeach;
				endforeach;
				$users = $newUsers;
			}
		}
			
		$allusers = array();
			
		$userParams = $UsersModel->getUserParams();
			
		foreach ($userParams as $one):
					
			$param = $one['userParamId'];
				
			if ((isset($_POST[$param]))AND($_POST[$param]!='')) {
					
				$textparam = str_replace("\n","\n<br>",$_POST[$param]);
					
				if ((($one['type']=='checkbox')OR($one['type']=='vibor'))AND($textparam==0)) { $textparam=''; }
					
				if ($textparam!='') {
						
					$userdata = $UsersModel->getUserDataBySubsc($textparam,$one['userParamId']);
						
					$i=0; 
					$newUsers = array();
					foreach ($users as $two):
							
							
						foreach ($userdata as $three):
							
							if ($two['code']==$three['code']) {
								$stop=0;
								foreach ($newUsers as $four):
									if ($four['code']==$two['code']) {
										$stop=1;
									}
								endforeach;
								if ($stop==0) {
									$newUsers[] = $two;
								}
							}
							
						endforeach;
							
					$i++;
					endforeach;
						
					$users = $newUsers;
					
				}
					
					
						
			} 
					
		endforeach;
			
		$userid = array();
		$i=0;
			
		$email = \Config\Services::email();
		
		$fromName = $ConfigModel->giveConfParam($param='fromName');
		$fromEmail = $ConfigModel->giveConfParam($param='fromEmail');
		
		
		$array = '';
		foreach ($users as $one):
			$array = $array.$one['email'].',';
		endforeach;
		$arrayReceiver = $array;
		
		$email->setFrom($fromEmail, $fromName);
		$email->setTo($arrayReceiver);
		
		$email->setSubject($theme);
		$email->setMessage($text);
		
		if ($this->request->getFiles('userfile')) {
			$userfile = $this->request->getFiles('userfile');
			$file = $userfile['userfile'];
			
			if ($file->isValid() && ! $file->hasMoved()) {
         
				$randomName = $file->getRandomName();
				$file->move('img/temp', $randomName);
				$path = 'img/temp/'.$randomName;
				$email->attach($path);
					
			}
			
		}	

		$email->send($autoClear = true);
		
		if (isset($path)) {
			
			unlink($path);
			
		}
			
		if ($id==0) {
				
			$session->set('message',Emailing_successful); 
			redirect ('/controler/subsc');
				
		} else {
			
			$session->set('message',Emailing_successful); 
			redirect ('/controler/subsc/index/edit/'.$_POST['id']);
			
		}
			
	}
	
}
