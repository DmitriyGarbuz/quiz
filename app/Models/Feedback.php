<?php 

namespace App\Models;
use \CodeIgniter\Database\ConnectionInterface;
use \CodeIgniter\Model;

class Feedback extends Model
{
	
	protected $DBGroup = 'default';
    protected $table = 'feedback';    
	protected $primaryKey = 'feedbackId';
	protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $protectFields = false;
	
    protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
	
	function turnOffFeedback ($feedbackId) {
	
		$db = \Config\Database::connect();
		
		$builder = $db->table('sitchapters');
		$builder->where ('param','feedback'.$feedbackId);
		$builder->delete ();
		
		$builder = $db->table('sitnotes');
		$builder->where ('param','feedback'.$feedbackId);
		$builder->delete ();
		
		$builder = $db->table('shablon');
		$builder->where ('param','feedback'.$feedbackId);
		$builder->delete ();
	
	}
	
	function testFeedCode ($code) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('feeds');
		$builder->where ('code',$code);
		return $builder->countAllResults();
		
	}
	
	function getFeeds($page,$perPage,$typelist='page') {
	
		$db = \Config\Database::connect();
		$builder = $db->table('feeds');
		if (session('connectsType')==0) { $builder->where ('visible',0); }
		if (session('connectsType')==2) { $builder->where ('visible',1); }
		$builder->orderBy ('date','desc'); 
		if ($typelist=='page') {
			$builder->limit($perPage,$page);
			return $builder->get()->getResultArray();
		}
		if ($typelist=='coun') {
			return $builder->countAllResults();
		}
	
	}
	
	function getFeedParam ($code,$feedbackParamId,$feedbackId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('feedsparams');
		$builder->where ('feedbackParamId',$feedbackParamId);
		$builder->where ('feedbackId',$feedbackId);
		$builder->where ('code',$code);
		return $builder->get()->getRowArray();
		
	}
	
	function getFeedParams ($field='',$param='') {
	
		$db = \Config\Database::connect();
		$builder = $db->table('feedsparams');
		if (is_array($field)) { $i=0;
			foreach ($field as $one) {
				if (isset($param[$i])) { $builder->where ($one,$param[$i]); } $i++;
			}
		} else {
			if ($field!='') { $builder->where ($field,$param); }
		}
		return $builder->get()->getResultArray();
		
	}
	
	function getFeed ($field='',$param='') {
		
		$db = \Config\Database::connect();
		$builder = $db->table('feeds');
		if (is_array($field)) { $i=0;
			foreach ($field as $one) {
				if (isset($param[$i])) { $builder->where ($one,$param[$i]); } $i++;
			}
		} else {
			if ($field!='') { $builder->where ($field,$param); }
		}
		return $builder->get()->getRowArray();
		
	}
	
	function getFeedbackParams ($field='',$param='') {
		
		$db = \Config\Database::connect();
		$builder = $db->table('feedbackparams');
		$builder->orderBy ('number','asc');
		if (is_array($field)) { $i=0;
			foreach ($field as $one) {
				if (isset($param[$i])) { $builder->where ($one,$param[$i]); } $i++;
			}
		} else {
			if ($field!='') { $builder->where ($field,$param); }
		}
		return $builder->get()->getResultArray();
		
	}
	
	function delFeedback ($feedbackId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('feedsparams');
		$builder->where ('feedbackId',$feedbackId);
		$builder->delete ();
		$builder = $db->table('feeds');
		$builder->where ('feedbackId',$feedbackId);
		$builder->delete ();
		$builder = $db->table('feedbackparams');
		$builder->where ('feedbackId',$feedbackId);
		$builder->delete ();
		$builder = $db->table('feedback');
		$builder->where ('feedbackId',$feedbackId);
		$builder->delete ();
	
	}
	
	function delFeed ($feedId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('feeds');
		$builder->where ('feedId',$feedId); 
		$feed = $builder->get()->getRowArray();
		$builder = $db->table('feeds');
		$builder->where ('feedId',$feedId);
		$builder->delete ();
		$builder = $db->table('feedsparams');
		$builder->where ('code',$feed['code']);
		$builder->delete ();
	
	}
	
	function delFeedbackParam ($feedbackParamId) {
	
		$db = \Config\Database::connect();
	
		$builder = $db->table('feedbackparams');
		$builder->where ('feedbackParamId',$feedbackParamId);
		$builder->delete ();
	
	}
	
	function editFeedbackParam ($data) {
	
		$db = \Config\Database::connect();
	
		$builder = $db->table('feedbackparams');
		$builder->where ('feedbackParamId',$data['feedbackParamId']);
		$builder->update ($data);
	
	}
	
	function addFeedbackParam ($data) {
	
		$db = \Config\Database::connect();
	
		$builder = $db->table('feedbackparams');
		$builder->insert ($data);
	
	}
	
	function addFeed ($data) {
	
		$db = \Config\Database::connect();
	
		$builder = $db->table('feeds');
		$builder->insert ($data);
	
	}
	
	function editFeed ($data) {
	
		$db = \Config\Database::connect();
	
		$builder = $db->table('feeds');
		$builder->where ('feedId',$data['feedId']);
		$builder->update ($data);
	
	}
	
	function addFeedParam ($data) {
	
		$db = \Config\Database::connect();
	
		$builder = $db->table('feedsparams');
		$builder->insert ($data);
	
	}
	
}