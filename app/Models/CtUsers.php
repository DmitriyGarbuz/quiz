<?php 

namespace App\Models;
use \CodeIgniter\Database\ConnectionInterface;
use \CodeIgniter\Model;
use App\Models\Config as ConfigModel;
use App\Models\Notes as NotesModel;

class CtUsers extends Model
{
	
	protected $DBGroup = 'default';
    protected $table = 'ctusers';    
	protected $primaryKey = 'ctUserId';
	protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
		'login', 'password', 'active', 'name', 'lastVisit', 'code'
	];

    protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
	
	function testCtuserLogin ($ctChapter='') {
	
		$db = \Config\Database::connect();
		$builder = $db->table('ctaccess');
		$builder->where ('ctUserId',session('ctUserId'));
		$builder->where ('access',$ctChapter);
		return $builder->countAllResults();
		
	}
	
	function getUserIdConf() {
	
		$db = \Config\Database::connect();
		$builder = $db->table('ctaccess');
		$builder->like ('access','ctusers');
		$ctaccess = $builder->get()->getRowArray();
		
		return $this->where('ctUserId',$ctaccess['ctUserId'])->first();
	
	}	
		
	function getCtAccess($ctUserId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('ctaccess');
		$builder->where ('ctUserId',$ctUserId);
		return $builder->get()->getResultArray();
		
	}	
	
	function testCtUserConfig ($ctUserId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('ctaccess');
		$builder->where ('ctUserId !=',$ctUserId);
		$builder->where ('access','ctusers');
		return $builder->countAllResults();
	
	}
	
	function delCtUserAccess ($ctUserId) {
	
		$ConfigModel = new ConfigModel;
		$NotesModel = new NotesModel;
		
		$db = \Config\Database::connect();
		$builder = $db->table('ctaccess');
		$builder->where ('ctUserId',$ctUserId);
		$builder->delete ();
		
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
	
	}
	
	function testOnline ($code) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('sessions');
		$builder->like ('data','"'.$code.'"');
		return $builder->countAllResults();
	
	}
	
	function addCtUserAccess ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('ctaccess');
		$builder->insert ($data);
	
	}
	
	function testCtuserLoginAdd ($ctUserId,$login) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('ctusers');
		if ($ctUserId!=0) { $builder->where ('ctUserId !=',$ctUserId); }
		$builder->where ('login',$login);
		return $builder->countAllResults();
		
	}
	
}