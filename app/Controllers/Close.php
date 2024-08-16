<?php namespace App\Controllers;

use App\Models\Config as ConfigModel;

class Close extends Base {

	function index() {
	
		$ConfigModel = new ConfigModel;
		
		$login = $ConfigModel->giveConfParam('closelogin');
		$password = $ConfigModel->giveConfParam('closepassword');
		
		$list = $this->getList('home');
		$data['list']=(object)$list;
		
		if (isset($_POST['login'])) { 
			if (($login==$_POST['login'])AND($password==$_POST['password'])) {
				error_reporting(0);
				setcookie('goClose', 1, time()+60*60*24*30,'/');
				echo 1;
			} else {
				echo view('close',$data);
			}
			
		} else {
			echo view('close',$data);
		}
		
	}
	
	
	
	
	
}