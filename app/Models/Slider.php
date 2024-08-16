<?php 

namespace App\Models;
use \CodeIgniter\Database\ConnectionInterface;
use \CodeIgniter\Model;

class Slider extends Model
{
	
	protected $DBGroup = 'default';
    protected $table = 'slider';    
	protected $primaryKey = 'id';
	protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $protectFields = false;
	
    protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
	
	function delSliderByType ($type='chapterId',$id) {
		
		$db = \Config\Database::connect();
		
		$sliders = $this->where($type,$id)->findAll();
		
		foreach ($sliders as $one):
			if (file_exists($one['preview'])) {
				unlink($one['preview']);
			}
		endforeach;
		
		$this->where($type,$id)->delete();
		
	}
	
}