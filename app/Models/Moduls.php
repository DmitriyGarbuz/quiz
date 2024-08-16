<?php 

namespace App\Models;
use \CodeIgniter\Database\ConnectionInterface;
use \CodeIgniter\Model;

class Moduls extends Model
{
	
	protected $DBGroup = 'default';
    protected $table = 'moduls';    
	protected $primaryKey = 'id';
	protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $protectFields = false;
	
    protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
	
	function getModuls () {
		
		$dir    = APPPATH.'/Views/moduls';
		$moduls = scandir($dir);
		$array = array(); $i=0;
		foreach ($moduls as $one):
		if (($one!='.')AND($one!='..')AND(!is_dir(APPPATH.'Views/moduls/'.$one))) { 
			$path_parts = pathinfo($one);
			$array[$i]['name'] = $path_parts['filename'];
			$i++;
		}
		endforeach;
		return $array;
		
	}
	
	function turnOffModuls ($modul) {
	
		$db = \Config\Database::connect();
		
		$builder = $db->table('sitchapters');
		$builder->where ('param','my_'.$modul);
		$builder->delete ();
		
		$builder = $db->table('sitnotes');
		$builder->where ('param','my_'.$modul);
		$builder->delete ();
		
		$builder = $db->table('shablon');
		$builder->where ('param','my_'.$modul);
		$builder->delete ();
	
	}
	
}