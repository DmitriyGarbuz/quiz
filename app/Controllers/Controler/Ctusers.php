<?php namespace App\Controllers\Controler;

use App\Models\CtUsers as CtUsersModel;

class Ctusers extends Base
{
	public function index($inPage='list',$id=0) 
	{
		
		if (!$this->controlTest('ctusers')) { $inPage='false'; } 
		$list = $this->getList('ctusers',$inPage);
		
		$CtUsersModel = new CtUsersModel;
		
		$list['ctUsers'] = $CtUsersModel->findAll();
		$i=0;
		foreach ($list['ctUsers'] as $one):
			$list['ctUsers'][$i]['online'] = $CtUsersModel->testOnline($one['code']);
			$i++;
		endforeach;
		if ($inPage=='edit') { 
			$list['ctUser'] = $CtUsersModel->where('ctUserId',$id)->first(); 
			$list['ctUser']['online'] = $CtUsersModel->testOnline($list['ctUser']['code']);
			$access = $CtUsersModel->getCtAccess($id);
			$list['access'] = array(); 
			foreach ($access as $one) { $list['access'][$one['access']] = 1; } 
		}
		
		$data['list']=(object)$list;
		
		echo view($this->path.'top',$data);
		echo view($this->path.'ctusers',$data);
		
	}
	
	function addCtUser () {
	
		if (!$this->controlTest('ctusers')) { exit; } 
		$CtUsersModel = new CtUsersModel;
		$session  = session();
			
		helper('nespi');
		$code = getSameString($col=6);
		$newCtUserCode = $code; $testCode=true; $string='';
		while ($testCode!=false) {
			$testCode = $CtUsersModel->where('code',$newCtUserCode)->countAllResults();
			if ($testCode!=false) {
				$string = getSameString($col=6);
				$newCtUserCode = $string;
			}
		}
		$code = $newCtUserCode;
			
		$data = array (
			'login' => $_POST['login'], 
			'code' => $code, 
			'name' => $_POST['name'], 
			'password' => $_POST['password'], 
		);
			
		$CtUsersModel->insert($data);
		
		$ctUser = $CtUsersModel->where('code',$data['code'])->first();
		
		if (isset($_POST['access'])) {
			foreach ($_POST['access'] as $one):
				$dataaccess = array (
					'ctUserId' => $ctUser['ctUserId'],
					'access' => $one
				);
				$CtUsersModel->addCtUserAccess($dataaccess);
				unset($access);
			endforeach;
		}
				
		$session->set('message',Administrator_added); 
		redirect ('/controler/ctusers');
			
	}
	
	function editCtUser () {
	
		if (!$this->controlTest('ctusers')) { exit; } 
		$CtUsersModel = new CtUsersModel;
		$session = session();
			
		$access=0;
		if (isset($_POST['access'])) {
			foreach ($_POST['access'] as $one) { if ($one=='ctusers') { $access=1; } }
		}
		
		if ($access==0) {
			if (!$CtUsersModel->testCtUserConfig($_POST['ctUserId'])) {
				$session->set('message',Required_at_least_one_administrator_with_access_to_the_Administrators_chapter); 
				redirect ('/controler/ctusers/index/edit/'.$_POST['ctUserId']);
			}
		}
			
		$CtUsersModel->delCtUserAccess($_POST['ctUserId']);
			
		$data = array (
			'login' => $_POST['login'], 
			'name' => $_POST['name'], 
			'password' => $_POST['password'], 
		);
			
		$CtUsersModel->update($_POST['ctUserId'],$data);
		
		if (isset($_POST['access'])) {
			foreach ($_POST['access'] as $one):
				$dataaccess = array (
					'ctUserId' => $_POST['ctUserId'],
					'access' => $one
				);
				$CtUsersModel->addCtUserAccess($dataaccess);
				unset($access);
			endforeach;
		}
				
		$session->set('message',Saved); 
		redirect ('/controler/ctusers/index/edit/'.$_POST['ctUserId']);
			
	}
	
	function testCtUserLogin () {
	
		if (!$this->controlTest('ctusers')) { exit; } 
		$CtUsersModel = new CtUsersModel;
		echo $CtUsersModel->testCtUserLoginAdd($_POST['ctUserId'],$_POST['login']);
	
	}
	
	function delCtUser () {
	
		if (!$this->controlTest('ctusers')) { exit; } 
		$CtUsersModel = new CtUsersModel;
		$CtUsersModel->delCtUserAccess($_POST['ctUserId']);
		$CtUsersModel->delete($_POST['ctUserId']);
				
	}
	
	function testCtUser () {
	
		if (!$this->controlTest('ctusers')) { exit; } 
		$CtUsersModel = new CtUsersModel;
		echo $CtUsersModel->testCtUserConfig($_POST['ctUserId']);
		
	}
	
}
