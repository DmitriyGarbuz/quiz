<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Config as ConfigModel;
use App\Models\Languages as LanguagesModel;
use App\Models\Moduls as ModulsModel;
use App\Models\Chapters as ChaptersModel;
use App\Models\Categorys as CategorysModel;
use App\Models\Cart as CartModel;
use App\Models\Users as UsersModel;

class Base extends Controller
{
	
	protected $helpers = [];
	
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
	}
	
	function getList($metaPage='',$lang='')
	{
		
		$ConfigModel = new ConfigModel;
		$LanguagesModel = new LanguagesModel;
		$ModulsModel = new ModulsModel;
		$ChaptersModel = new ChaptersModel;
		
		return array (
			'confSet' => $ConfigModel->getConfSet(), 
			'confLang' => $LanguagesModel->getConfLang($lang), 
			'userVar' => $ConfigModel->getUserVarConf($lang), 
			'languages' => $LanguagesModel->orderBy('main DESC, number ASC')->find(),
			'moduls' => $ModulsModel->getModuls(),
			'chapters' => $ChaptersModel->orderBy('parent ASC, number ASC, name ASC')->where('visible',1)->find(),
			'counters' => $ConfigModel->getCounters(),
			'metaPage' => $metaPage,		
		);
		
	}
	
}
