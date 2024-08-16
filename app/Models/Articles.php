<?php 

namespace App\Models;
use \CodeIgniter\Database\ConnectionInterface;
use \CodeIgniter\Model;
use App\Models\Chapters as ChaptersModel;

class Articles extends Model
{
	
	protected $DBGroup = 'default';
    protected $table = 'articles';    
	protected $primaryKey = 'articleId';
	protected $returnType = 'array';
    protected $useSoftDeletes = false;

	protected $protectFields = false;
	protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
	
	function getArticles($chapterId,$chaptersPage,$sort,$perPage,$visible=0,$typeList='page') {
	
		$db = \Config\Database::connect();
		$builder = $db->table($this->table);
		$builder->where ('chapterId',$chapterId);
		$builder->join('artchaplink', 'articles.articleId = artchaplink.articleId','inner');
		if ($visible==1) { $builder->where ('visible',1); }
		if ($sort=='date') { $builder->orderBy ('date','desc'); }
		if ($sort=='number') { $builder->orderBy ('number','asc'); }
		if ($typeList=='page') {
			$builder->limit($perPage,$chaptersPage);
			return $builder->get()->getResultArray();
		}
		if ($typeList=='coun') {
			return $builder->countAllResults();
		}
			
	}
	
	function addArtRating ($data) {
		
		$db = \Config\Database::connect();
		$builder = $db->table('artrating');
		$builder->insert ($data);
		
	}
	
	function getArtRating ($articleId) {
		
		$session = session();
		$db = \Config\Database::connect();
		$builder = $db->table('artrating');
		$builder->where ('articleId',$articleId);
		$builder->where ('ip_address',$_SERVER['REMOTE_ADDR']);
		$builder->where ('user_agent',$_SERVER['HTTP_USER_AGENT']);
		$builder->where ('session_id',session_id());
		return $builder->get()->getResultArray();
		
	}
	
	function delArtChapbyArt ($articleId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('artchaplink');
		$builder->where ('articleId',$articleId);
		$builder->delete ();
	
	}
	
	function addArtChap ($data) {
	
		$count = $this->testArtChapLink($data);
		if ($count==0) {	
			$db = \Config\Database::connect();
			$builder = $db->table('artchaplink');
			$builder->insert ($data);
		}
		
	}
	
	function testArtChapLink ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('artchaplink');
		$builder->where ('articleId',$data['articleId']);
		$builder->where ('chapterId',$data['chapterId']);
		return $builder->countAllResults();
	
	}
	
	function turnOffArticle ($chapterId) {
	
		$db = \Config\Database::connect();
		
		$builder = $db->table('sitchapters');
		$builder->where ('param','articlescent'.$chapterId);
		$builder->orWhere ('param','articlescol'.$chapterId);
		$builder->delete ();
		
		$builder = $db->table('sitnotes');
		$builder->where ('param','articlescent'.$chapterId);
		$builder->orWhere ('param','articlescol'.$chapterId);
		$builder->delete ();
		
		$builder = $db->table('shablon');
		$builder->where ('param','articlescent'.$chapterId);
		$builder->orWhere ('param','articlescol'.$chapterId);
		$builder->delete ();
		
	}
	
	function getArtModul ($chapterId,$pos='Col') {
	
		$ChaptersModel = new ChaptersModel;
		
		$chapter = $ChaptersModel->where('chapterId',$chapterId)->first();
		if (isset($chapter['chapterId'])) {
			
			$db = \Config\Database::connect();
			$builder = $db->table('articles');
			$builder->where ('chapterId',$chapterId);
			$builder->join('artchaplink', 'articles.articleId = artchaplink.articleId','inner');
			if ($chapter['sort']=='date') { $builder->orderBy ('date','desc'); }
			if ($chapter['sort']=='number') { $builder->orderBy ('number','asc'); }
			$builder->limit ($chapter['perPage'.$pos],0);
			$builder->where ('visible',1);
			return $builder->get()->getResultArray();
			
		} else {
			return array();
		}
		
	}
	
}