<?php 

namespace App\Models;
use \CodeIgniter\Database\ConnectionInterface;
use \CodeIgniter\Model;

class Faqs extends Model
{
	
	protected $DBGroup = 'default';
    protected $table = 'faq';    
	protected $primaryKey = 'faqId';
	protected $returnType = 'array';
    protected $useSoftDeletes = false;

	protected $protectFields = false;
	protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
	
	function getFaqs($chapterId,$faqPage,$perPage,$visible=0,$typeList='page') {
	
		$db = \Config\Database::connect();
		$builder = $db->table($this->table);
		if ($chapterId>0) {
			$builder->where ('chapterId',$chapterId);
			$builder->join('faqchaplink', 'faq.faqId = faqchaplink.faqId','inner');
		}
		if ($visible==0) {
			if (session('faqType')==0) { $builder->where ('visible',0); }
			if (session('faqType')==2) { $builder->where ('visible',1); }
		}
		if ($visible==1) { $builder->where ('visible',1); }
		$builder->orderBy ('date','desc'); 
		if ($typeList=='page') {
			$builder->limit($perPage,$faqPage);
			return $builder->get()->getResultArray();
		}
		if ($typeList=='coun') {
			return $builder->countAllResults();
		}
			
	}
	
	function addFaqChap ($data) {
	
		$count = $this->testFaqChapLink($data);
		if ($count==0) {	
			$db = \Config\Database::connect();
			$builder = $db->table('faqchaplink');
			$builder->insert ($data);
		}
		
	}
	
	function testFaqChapLink ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('faqchaplink');
		$builder->where ('faqId',$data['faqId']);
		$builder->where ('chapterId',$data['chapterId']);
		return $builder->countAllResults();
		
	}
	
	function delFaqChapbyFaq ($faqId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('faqchaplink');
		$builder->where ('faqId',$faqId);
		$builder->delete ();
	
	}
	
}