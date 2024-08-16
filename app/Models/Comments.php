<?php 

namespace App\Models;
use \CodeIgniter\Database\ConnectionInterface;
use \CodeIgniter\Model;
use App\Models\Articles as ArticlesModel;
use App\Models\Config as ConfigModel;

class Comments extends Model
{
	
	protected $DBGroup = 'default';
    protected $table = 'comments';    
	protected $primaryKey = 'commentId';
	protected $returnType = 'array';
    protected $useSoftDeletes = false;

	protected $protectFields = false;
	protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
	
	function getComments($chapterId,$commentsPage,$perPage,$visible=0,$typeList='page') {
	
		$db = \Config\Database::connect();
		$builder = $db->table($this->table);
		if ($chapterId>0) {
			$builder->where ('chapterId',$chapterId);
			$builder->join('comchaplink', 'comments.commentId = comchaplink.commentId','inner');
		}
		if ($visible==0) {
			if (session('commentsType')==0) { $builder->where ('visible',0); }
			if (session('commentsType')==2) { $builder->where ('visible',1); }
		}
		if ($visible==1) { $builder->where ('visible',1); }
		$builder->orderBy ('date','desc'); 
		if ($typeList=='page') {
			$builder->limit($perPage,$commentsPage);
			return $builder->get()->getResultArray();
		}
		if ($typeList=='coun') {
			return $builder->countAllResults();
		}
			
	}
	
	function getArCommentsCt($articleId,$page,$perPage,$visible=0,$typelist='page') {
	
		$ArticlesModel = new ArticlesModel;
		$db = \Config\Database::connect();
		$builder = $db->table($this->table);
		$builder->where ('articleId',$articleId);
		$builder->orderBy ('date','desc'); 
		if ($typelist=='page') {
			$builder->limit($perPage,(int)$page);
			return $builder->get()->getResultArray();
		}
		if ($typelist=='coun') {
			return $builder->countAllResults();
		}
	
	}
	
	function delComChapbyCom ($commentId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('comchaplink');
		$builder->where ('commentId',$commentId);
		$builder->delete ();
	
	}
	
	function addComChap ($data) {
	
		$count = $this->testComChapLink($data);
		if ($count==0) {	
			$db = \Config\Database::connect();
			$builder = $db->table('comchaplink');
			$builder->insert ($data);
		}
		
	}
	
	function testComChapLink ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('comchaplink');
		$builder->where ('commentId',$data['commentId']);
		$builder->where ('chapterId',$data['chapterId']);
		return $builder->countAllResults();
	
	}
	
	function getSitComments ($pos='Cent') {
	
		$ConfigModel = new ConfigModel;
		$db = \Config\Database::connect();
		$builder = $db->table('comments');
		
		if ($pos=='Cent') { $commentsPer = $ConfigModel->giveConfParam($param='commentsPerCent'); }
		if ($pos=='Col') { $commentsPer = $ConfigModel->giveConfParam($param='commentsPerCol'); }
		if ($pos=='Slide') { $commentsPer = 2; }
		$builder->where ('parent !=',0);
		$builder->where ('visible',1);
		$builder->orderBy ('date','desc');
		$builder->limit ($commentsPer,0);
		return $builder->get()->getResultArray();
		
	}
	
	function getSliderComment ($page) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('comments');
	
		$builder->where ('parent !=',0);
		$builder->where ('visible',1);
		$builder->orderBy ('date','desc');
		$builder->limit (1,(int)$page);
		return $builder->get()->getRowArray();
		
	}
	
	function countSliderComments () {
	
		$db = \Config\Database::connect();
		$builder = $db->table('comments');
	
		$builder->where ('parent !=',0);
		$builder->where ('visible',1);
		$builder->orderBy ('date','desc');
		return $builder->countAllResults();
		
	}
	
}