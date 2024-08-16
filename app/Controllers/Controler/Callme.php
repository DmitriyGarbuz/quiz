<?php namespace App\Controllers\Controler;

use App\Models\Callme as CallmeModel;

class Callme extends Base
{
	public function index($inPage='list',$ctCallmePage=0,$id=0)
	{
		
		if (!$this->controlTest('callme')) { $inPage='false'; } 
		$list = $this->getList('callme',$inPage);
		
		$CallmeModel = new CallmeModel;
		
		$list['callme'] = $CallmeModel->getCallme($ctCallmePage,$list['confSet']['callmePerCt'],'page');
		$list['coun'] = $CallmeModel->getCallme($ctCallmePage,$list['confSet']['callmePerCt'],'coun');
		
		if ($inPage=='edit') { 
			$list['callme'] = $CallmeModel->where('id',$id)->first();
			if (!isset($list['callme']['id'])) { redirect ('/page404'); }
		}
		$list['setup']['ctCallmePage'] = $ctCallmePage;	
		
		$data['list']=(object)$list;
		
		echo view($this->path.'top',$data);
		echo view($this->path.'callme',$data);
		
	}
	
	function changeCallmeData () {
	
		if (!$this->controlTest('callme')) { exit; } 
		$CallmeModel = new CallmeModel;
		$data = array ($_POST['type'] => $_POST['param']);
		$CallmeModel->update($_POST['id'],$data);
			
	}
	
	function delCallme () {
	
		if (!$this->controlTest('callme')) { exit; } 
		$CallmeModel = new CallmeModel;
		$CallmeModel->delete($_POST['id']);
		echo '/controler/callme';
			
	}
	
	function changeType () {
	
		if (!$this->controlTest('callme')) { exit; } 
		$session = session();
		$session->set('callmeType',$_POST['type']);
			
	}
	
}
