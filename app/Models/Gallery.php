<?php 

namespace App\Models;
use \CodeIgniter\Database\ConnectionInterface;
use \CodeIgniter\Model;
use App\Models\Chapters as ChaptersModel;

class Gallery extends Model
{
	
	protected $DBGroup = 'default';
    protected $table = 'gallery';    
	protected $primaryKey = 'galleryId';
	protected $returnType = 'array';
    protected $useSoftDeletes = false;

	protected $protectFields = false;
	protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
	
	function getGallerys($chapterId,$chaptersPage,$perPage,$typeList='page') {
	
		$db = \Config\Database::connect();
		if ($typeList=='page') {
			$query = $db->query("(SELECT * FROM ns_gallery WHERE `tree` LIKE '%|$chapterId|%') ORDER BY `number` ASC LIMIT $chaptersPage, $perPage");
			return $query->getResultArray();
		}
		if ($typeList=='coun') {
			$query = $db->query("(SELECT * FROM ns_gallery WHERE `tree` LIKE '%|$chapterId|%') ORDER BY `number` ASC");
			$array = $query->getResultArray();
			return count($array);
		}
			
	}
	
	function getAllGallerys($chapterId) {
	
		$db = \Config\Database::connect();
		$query = $db->query("(SELECT * FROM ns_gallery WHERE `tree` LIKE '%|$chapterId|%') ORDER BY `number` ASC");
		return $query->getResultArray();
				
	}
	
	function getGalModul ($chapterId,$pos='Cent') {
	
		$db = \Config\Database::connect();
		$ChaptersModel = new ChaptersModel;
		$chapter = $ChaptersModel->where('chapterId',$chapterId)->first();
		if (isset($chapter['chapterId'])) {
			$perPage = $chapter['perPage'.$pos];
			$query = $db->query("(SELECT * FROM ns_gallery WHERE `tree` LIKE '%|$chapterId|%') ORDER BY `number` ASC LIMIT 0, $perPage");
			return $query->getResultArray();
		} else {
			return array();
		}
		
	}
	
	function turnOffGallery ($chapterId) {
	
		$db = \Config\Database::connect();
		
		$builder = $db->table('sitchapters');
		$builder->where ('param','gallerycent'.$chapterId);
		$builder->orWhere ('param','gallerycol'.$chapterId);
		$builder->delete ();
		
		$builder = $db->table('sitnotes');
		$builder->where ('param','gallerycent'.$chapterId);
		$builder->orWhere ('param','gallerycol'.$chapterId);
		$builder->delete ();
		
		$builder = $db->table('shablon');
		$builder->where ('param','gallerycent'.$chapterId);
		$builder->orWhere ('param','gallerycol'.$chapterId);
		$builder->delete ();
		
	}
	
}