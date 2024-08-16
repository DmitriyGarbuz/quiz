<?php 

namespace App\Models;
use \CodeIgniter\Database\ConnectionInterface;
use \CodeIgniter\Model;

class Callme extends Model
{
	
	protected $DBGroup = 'default';
    protected $table = 'callme';    
	protected $primaryKey = 'id';
	protected $returnType = 'array';
    protected $useSoftDeletes = false;

	protected $protectFields = false;
	protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
	
	function getCallme($callmePage,$perPage,$typeList='page') {
	
		$db = \Config\Database::connect();
		$builder = $db->table($this->table);
		
		if (session('callmeType')==0) { $builder->where ('visible',0); }
		if (session('callmeType')==2) { $builder->where ('visible',1); }
		
		$builder->orderBy ('date','desc'); 
		if ($typeList=='page') {
			$builder->limit($perPage,(int)$callmePage);
			return $builder->get()->getResultArray();
		}
		if ($typeList=='coun') {
			return $builder->countAllResults();
		}
			
	}
	
}