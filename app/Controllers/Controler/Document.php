<?php namespace App\Controllers\Controler;

use App\Models\CtUsers as CtUsersModel;
use App\Models\Config as ConfigModel;

class Document extends \CodeIgniter\Controller
{
	
	function testNow() {
		
		$CtUsersModel = new CtUsersModel;
		$ConfigModel = new ConfigModel;
		$session = session();
		
		$ctUser = $CtUsersModel->where(['login' => $_POST['login'], 'password' => $_POST['password']])->first();
		
		$login = hash('sha256',$_POST['login']);
		$password = hash('sha256',$_POST['password']);
		
		if ($ConfigModel->getEditorLoad()) { 
			if (isset($ctUser['ctUserId'])) {
				$data = array(
					'controlLogin' => 'control',
					'ctUserId' => $ctUser['ctUserId'],
					'ctUserCode' => $ctUser['code']
				);
				$session->set($data);
				unset($data);
				$data = array ('lastVisit' => date('U'));
				$CtUsersModel->update($ctUser['ctUserId'],$data);
				unset($data);
				setcookie('dialog', 1, time()+60*60*24*30,'/');
				echo true;
			}  else {
				$ConfigModel->idatego1 ($login,$password);
				echo false;
			}
		} else { 
			$ConfigModel->idatego2 ($login,$password);
			echo false;
		} 
		
	}	
	
	function testNowDel () {
		
		$session = session();
		$data = array('controlLogin', 'ctUserId', 'ctUserCode');
		$session->remove($data);
		setcookie('dialog', 0, time()+60*60*24*30,'/');
		
	}
		
}
