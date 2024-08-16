<?php 

namespace App\Models;
use \CodeIgniter\Database\ConnectionInterface;
use \CodeIgniter\Model;
use App\Models\Design as DesignModel;
use App\Models\Slider as SliderModel;

class Notes extends Model
{
	
	protected $DBGroup = 'default';
    protected $table = 'notes';    
	protected $primaryKey = 'noteId';
	protected $returnType = 'array';
    protected $useSoftDeletes = false;

	protected $protectFields = false;
	protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;

	function getNoteCats ($field='',$param='') {
	
		$db = \Config\Database::connect();
		$builder = $db->table('notecat');
		if (is_array($field)) { $i=0;
			foreach ($field as $one) {
				if (isset($param[$i])) { $builder->where ($one,$param[$i]); } $i++;
			}
		} else {
			if ($field!='') { $builder->where ($field,$param); }
		}
		return $builder->get()->getResultArray();
	
	}
	
	function getBanNotes ($field='',$param='') {
	
		$db = \Config\Database::connect();
		$builder = $db->table('bannotes');
		if (is_array($field)) { $i=0;
			foreach ($field as $one) {
				if (isset($param[$i])) { $builder->where ($one,$param[$i]); } $i++;
			}
		} else {
			if ($field!='') { $builder->where ($field,$param); }
		}
		return $builder->get()->getResultArray();
	
	}
	
	function testNoteTabUrl ($url) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('notetabs');
		$builder->where ('url',$url);
		return $builder->countAllResults();
	
	}
	
	function delNoteTab ($noteTabId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('notetabs');
		$builder->where ('noteTabId',$noteTabId);
		$builder->delete ();
	
	}
	
	function addNoteTab ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('notetabs');
		$builder->insert ($data);
	
	}
	
	function giveNoteName () {
	
		return 'f4eb27cea7255cea4d1ffabf593372e8';
	
	}
	
	function editNoteCat ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('notecat');
		$builder->where ('noteCatId',$data['noteCatId']);
		$builder->update ($data);
	
	}
	
	function editNoteTab ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('notetabs');
		$builder->where ('noteTabId',$data['noteTabId']);
		$builder->update ($data);
	
	}
	
	function addNoteCat ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('notecat');
		$builder->insert ($data);
	
	}
	
	function getNoteCatByTree ($noteCatId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('notecat');
		$builder->like ('tree','|'.$noteCatId.'|');
		return $builder->get()->getResultArray();
	
	}
	
	function getNoteCat ($field='',$param='') {
		
		$db = \Config\Database::connect();
		$builder = $db->table('notecat');
		$builder->orderBy ('number','asc');
		$builder->orderBy ('name','asc');
		if ($field!='') { $builder->where ($field,$param); }
		return $builder->get()->getRowArray();
		
	}
	
	function getNotes($noteCatId,$page,$perPage,$typelist='page') {
	
		$db = \Config\Database::connect();
		$builder = $db->table('notes');
	
		if (session('ctNoteSearch')!='') { 
			$builder->like ('name',$CI->session->userdata('ctNoteSearch'));
		} else {
			if ($noteCatId>0) {
				$builder->where ('noteCatId',$noteCatId);
				$builder->join('notecatlink', 'notes.noteId = notecatlink.noteId','inner');
			}
		}
		
		$builder->orderBy ('number','asc'); 
		$builder->orderBy ('name','asc'); 
		
		if ($typelist=='page') {
			$builder->limit($perPage,$page);
			return $builder->get()->getResultArray();
		}
		
		if ($typelist=='coun') {
			return $builder->countAllResults();
		}
		
	}
	
	function testNoteUrl ($noteId=0,$url='') {
	
		$db = \Config\Database::connect();
		$builder = $db->table('notes');
		if ($noteId!=0) { $builder->where ('noteId !=',$noteId); }
		$builder->where ('url',$url);
		return $builder->countAllResults();
	
	}
	
	function addNoteLinkCat ($data) {
	
		$db = \Config\Database::connect();
		
		$count = $this->testNoteCatLink($data);
		if ($count==0) {	
			$builder = $db->table('notecatlink');
			$builder->insert ($data);
		}
		
	}
	
	function testNoteCatLink ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('notecatlink');
		$builder->where ('noteId',$data['noteId']);
		$builder->where ('noteCatId',$data['noteCatId']);
		return $builder->countAllResults();
		
	}
	
	function delNoteLinkbyNote ($noteId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('notecatlink');
		$builder->where ('noteId',$noteId);
		$builder->delete ();
	
	}
	
	function delNoteLinkbyCat ($noteCatId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('notecatlink');
		$builder->where ('noteCatId',$noteCatId);
		$builder->delete ();
	
	}
	
	function delNoteCat ($noteCatId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('notecat');
		$builder->where ('noteCatId',$noteCatId);
		$builder->delete ();
	
	}
	
	function addSitNoteStart ($noteId) {
		
		$db = \Config\Database::connect();
		
		$DesignModel = new DesignModel;
		
		$sitNotes = $DesignModel->getSitShablons('shablon','notes');
		foreach ($sitNotes as $one) { 
			unset($one['id']);
			unset($one['shablon']);
			$one['noteId']=$noteId;
			$builder = $db->table('sitnotes');
			$builder->insert ($one);
		}
		
	}
	
	function addBanNoteStart ($noteId) {
	
		$db = \Config\Database::connect();
	
		$DesignModel = new DesignModel;
		
		$banNotes = $DesignModel->getBanShablons('shablon','notes');
		foreach ($banNotes as $one) { 
			unset($one['id']);
			unset($one['shablon']);
			$one['noteId']=$noteId;
			$builder = $db->table('bannotes');
			$builder->insert ($one);
		}
	
	}
	
	function getNoteTabs ($field='',$param='') {
		
		$db = \Config\Database::connect();
		$builder = $db->table('notetabs');
		$builder->orderBy ('number','asc');
		$builder->orderBy ('name','asc');
		if ($field!='') { $builder->where ($field,$param); }
		return $builder->get()->getResultArray();
		
	}
	
	function delNoteTabs ($noteId) {
		
		$db = \Config\Database::connect();
		$builder = $db->table('notetabs');
		$builder->where ('noteId',$noteId);
		$builder->delete ();
		
	}
	
	function delSitNotes ($noteId) {
		
		$db = \Config\Database::connect();
		$builder = $db->table('sitnotes');
		$builder->where ('noteId',$noteId);
		$builder->delete ();
		
	}
	
	function getNoteTab ($field='',$param='') {
		
		$db = \Config\Database::connect();
		$builder = $db->table('notetabs');
		$builder->orderBy ('number','asc');
		$builder->orderBy ('name','asc');
		if ($field!='') { $builder->where ($field,$param); }
		return $builder->get()->getRowArray();
		
	}
	
	function getSitNotes ($field='',$param='') {
	
		$db = \Config\Database::connect();
		$builder = $db->table('sitnotes');
		if (is_array($field)) { $i=0;
			foreach ($field as $one) {
				if (isset($param[$i])) { $builder->where ($one,$param[$i]); } $i++;
			}
		} else {
			if ($field!='') { $builder->where ($field,$param); }
		}
		return $builder->get()->getResultArray();
	
	}
	
	function getSitNote ($field='',$param='') {
	
		$db = \Config\Database::connect();
		$builder = $db->table('sitnotes');
		if (is_array($field)) { $i=0;
			foreach ($field as $one) {
				if (isset($param[$i])) { $builder->where ($one,$param[$i]); } $i++;
			}
		} else {
			if ($field!='') { $builder->where ($field,$param); }
		}
		return $builder->get()->getRowArray();
	
	}
	
	function addSitNote ($data) {
		
		$db = \Config\Database::connect();
		$builder = $db->table('sitnotes');
		$builder->insert ($data);
		
	}
	
	function editSitNote ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('sitnotes');
		$builder->where ('id',$data['id']);
		$builder->update ();
		
	}
	
	function delSitNote ($id) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('sitnotes');
		$builder->where ('id',$id);
		$builder->delete ();
	
	}
	
	function getBanNote ($field='',$param='') {
	
		$db = \Config\Database::connect();
		$builder = $db->table('bannotes');
		if (is_array($field)) { $i=0;
			foreach ($field as $one) {
				if (isset($param[$i])) { $builder->where ($one,$param[$i]); } $i++;
			}
		} else {
			if ($field!='') { $builder->where ($field,$param); }
		}
		return $builder->get()->getRowArray();
	
	}
	
	function editBanNote ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('bannotes');
		$builder->where ('id',$data['id']);
		$builder->update ($data);
		
	}
	
	function delBanNotes ($noteId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('bannotes');
		$builder->where ('noteId',$noteId);
		$builder->delete ();
	
	}
	
	function delBanNote ($id) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('bannotes');
		$builder->where ('id',$id);
		$builder->delete ();
	
	}
	
	function addBanNote ($data) {
		
		$db = \Config\Database::connect();
		$builder = $db->table('bannotes');
		$builder->insert ($data);
		
	}
	
}

