<?php 

namespace App\Models;
use \CodeIgniter\Database\ConnectionInterface;
use \CodeIgniter\Model;
use App\Models\Chapters as ChaptersModel;

class Compmenu extends Model
{
	
	protected $DBGroup = 'default';
    protected $table = 'compmenu';    
	protected $primaryKey = 'id';
	protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $protectFields = false;
	
    protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
	
	function getDistCompMenu ($chapterId) {
	
		$ChaptersModel = new ChaptersModel;
		$db = \Config\Database::connect();
		$builder = $db->table('compmenu');
		$builder->where('chapterId',$chapterId);
		$builder->orderBy ('number','asc');
		$compMenu = $builder->get()->getResultArray();
		$array = array();
		foreach ($compMenu as $one):
			$array[] = $ChaptersModel->where('chapterId',$one['menuId'])->first();
		endforeach;
		return $array;
	
	}
	
	function addChapterInComposite ($data) {
	
		$compmenu = $this->where('chapterId',$data['chapterId'])->where('menuId',$data['menuId'])->first();
		if (isset($compmenu['id'])) {
			return This_chapter_is_already_in_the_menu;
		} else {
			$this->insert ($data);
			return Chapter_added_to_the_menu;
		}
	
	}
	
}