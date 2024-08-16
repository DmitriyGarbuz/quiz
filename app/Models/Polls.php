<?php 

namespace App\Models;
use \CodeIgniter\Database\ConnectionInterface;
use \CodeIgniter\Model;

class Polls extends Model
{
	
	protected $DBGroup = 'default';
    protected $table = 'polls';    
	protected $primaryKey = 'pollId';
	protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $protectFields = false;
	
    protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
	
	function getPollParam ($pollParamId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('pollparams');
		$builder->where ('pollParamId',$pollParamId);
		return $builder->get()->getRowArray();
		
	}
	
	function getPollParams ($pollId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('pollparams');
		$builder->where ('pollId',$pollId); 
		$builder->orderBy ('votes','desc');
		return $builder->get()->getResultArray();
		
	}
	
	function turnOffPool ($pollId) {
	
		$db = \Config\Database::connect();
		
		$builder = $db->table('sitchapters');
		$builder->where ('param','poll'.$pollId);
		$builder->delete ();
		
		$builder = $db->table('sitnotes');
		$builder->where ('param','poll'.$pollId);
		$builder->delete ();
		
		$builder = $db->table('shablon');
		$builder->where ('param','poll'.$pollId);
		$builder->delete ();
	
	}
	
	function delPoll ($pollId) {
	
		$db = \Config\Database::connect();
	
		$builder = $db->table('pollparams');
		$builder->where ('pollId',$pollId);
		$builder->delete ();
	
		$builder = $db->table('pollvotes');
		$builder->where ('pollId',$pollId);
		$builder->delete ();
	
		$builder = $db->table('polls');
		$builder->where ('pollId',$pollId);
		$builder->delete ();
	
	}
	
	function delPollParam ($pollParamId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('pollparams');
		$builder->where ('pollParamId',$pollParamId);
		$builder->delete ();
	
	}
	
	function addPollParam ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('pollparams');
		$builder->insert ($data);
	
	}
	
	function editPollParam ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('pollparams');
		$builder->where ('pollParamId',$data['pollParamId']);
		$builder->update ($data);
	
	}
	
	function addPollVote ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('pollvotes');
		$builder->insert ($data);
	
	}
	
	function countPollVote ($pollId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('pollvotes');
		$builder->where ('ipAddress',$_SERVER['REMOTE_ADDR']);
		$builder->where ('userAgent',$_SERVER['HTTP_USER_AGENT']);
		$builder->where ('pollId',$pollId);
		return $builder->countAllResults();
	
	}
	
}