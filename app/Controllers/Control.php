<?php namespace App\Controllers;

class Control extends \App\Controllers\Controler\Base
{
	public function index()
	{
			
		$this->controlTest();
		echo view('control',array('list' => (object)$this->getList()));
	}

}
