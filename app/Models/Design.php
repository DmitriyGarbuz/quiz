<?php 

namespace App\Models;
use \CodeIgniter\Database\ConnectionInterface;
use \CodeIgniter\Model;
use App\Models\Config as ConfigModel;

class Design extends Model
{
	
	protected $DBGroup = 'default';
    protected $table = 'shablon';    
	protected $primaryKey = 'id';
	protected $returnType = 'array';
    protected $useSoftDeletes = false;

	protected $protectFields = false;
	
    protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
	
	function getSiteTemp () {
		
		return array ('rightcolumn','leftcolumn','highcenter','overcenter','overhead1','overhead2','underhead1','underhead2','head21','head22','head31','head32','center1','center2','center3','center4','center5','center6','center7','center8','left1','left2','left3','left4','left5','right1','right2','right3','right4','right5');
		
	}
	
	function getSitShablons ($field='',$param='') {
	
		$db = \Config\Database::connect();
		
		$builder = $db->table('shablon');
		
		if (is_array($field)) { $i=0;
			foreach ($field as $one) {
				if (isset($param[$i])) { $builder->where ($one,$param[$i]); } $i++;
			}
		} else {
			if ($field!='') { $builder->where ($field,$param); }
		}
		
		return $builder->get()->getResultArray();
	
	}
	
	function getBanShablons ($field='',$param='') {
	
		$db = \Config\Database::connect();
		
		$builder = $db->table('banshablon');
		
		if (is_array($field)) { $i=0;
			foreach ($field as $one) {
				if (isset($param[$i])) { $builder->where ($one,$param[$i]); } $i++;
			}
		} else {
			if ($field!='') { $builder->where ($field,$param); }
		}
		
		return $builder->get()->getResultArray();
	
	}
	
	function getSitShablon ($field='',$param='') {
	
		$db = \Config\Database::connect();
		
		$builder = $db->table('shablon');
	
		if (is_array($field)) { $i=0;
			foreach ($field as $one) {
				if (isset($param[$i])) { $builder->where ($one,$param[$i]); } $i++;
			}
		} else {
			if ($field!='') { $this->db->where ($field,$param); }
		}
		return $builder->get()->getRowArray();
	
	}
	
	function getBanShablon ($field='',$param='') {
	
		$db = \Config\Database::connect();
		
		$builder = $db->table('banshablon');
	
		if (is_array($field)) { $i=0;
			foreach ($field as $one) {
				if (isset($param[$i])) { $builder->where ($one,$param[$i]); } $i++;
			}
		} else {
			if ($field!='') { $builder->where ($field,$param); }
		}
		return $builder->get()->getRowArray();
	
	}
	
	function getThemes () {
	
		$sdir = array();
		if (false!==($files = scandir('themes'))) {  
			foreach ($files as $entry):
                if ((strpos($entry,'.ns'))AND($entry!='.')AND($entry!='..')) {
				   $sdir[] = $entry;
				}
			endforeach;
        }
		foreach ($sdir as $one):
			$themes[] = file('themes/'.$one);
		endforeach;
		return $themes;
		
	}
	
	function addSitShablon ($data) {
		
		$db = \Config\Database::connect();
		$builder = $db->table('shablon');
		$builder->insert ($data);
		
	}
	
	function editSitShablon ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('shablon');
		$builder->where ('id',$data['id']);
		$builder->update ($data);
		
	}
	
	function editBanShablon ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('banshablon');
		$builder->where ('id',$data['id']);
		$builder->update ($data);
		
	}
	
	function delBanShablon ($id) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('banshablon');
		$builder->where ('id',$id);
		$builder->delete ();
	
	}
	
	function addBanShablon ($data) {
		
		$db = \Config\Database::connect();
		$builder = $db->table('banshablon');
		$builder->insert ($data);
		
	}
	
	function delSitShablon ($id) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('shablon');
		$builder->where ('id',$id);
		$builder->delete ();
	
	}
	
	function changeTheme ($data) {
	
		$ConfigModel = new ConfigModel;
	
		$sdir = array();
      
		if (false !== ($files = scandir('themes'))) {  
    
            foreach ($files as $entry):
                if ((strpos($entry,'.ns'))AND($entry!='.')AND($entry!='..')) {
				   $sdir[] = $entry;
				}
			endforeach;
        
		}
   
		foreach ($sdir as $one):
		
			$list = file('themes/'.$one);
			$list[1] = trim($list[1]);
			
			$data['theme'] = trim($data['theme']);
			
			if ($data['theme']==$list[1]) {
				
				$dataconf['themecss'] = 'themes/'.(trim($list[3]));
				$ConfigModel->editConfig($dataconf);
				$dataconf['themeid'] = trim($list[1]);
				$ConfigModel->editConfig($dataconf);
				
			}
			
		endforeach;
	
	}
	
	function addTheme ($data) {
	
		fopen('themes/'.$data['file'].'.css', 'w');
		
		$content1=file_get_contents(base_url().'admin/css/main_template.css');
		
		$lscss1 = fopen('themes/'.$data['file'].'.css', 'w');
		fputs($lscss1,$content1);
		
		$ns = fopen('themes/'.$data['file'].'.ns', 'w');
		fputs($ns,"Theme name:\r\n");
		fputs($ns,$data['name']);
		fputs($ns,"\r\n");
		fputs($ns,"Theme css file:\r\n");
		fputs($ns,$data['file'].'.css');
		fputs($ns,"\r\n");
		fputs($ns,"Theme author:\r\n");
		fputs($ns,$data['author']);
		
		

	}
	
}