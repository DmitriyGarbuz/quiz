<?php 

namespace App\Models;
use \CodeIgniter\Database\ConnectionInterface;
use \CodeIgniter\Model;

class Users extends Model
{
	
	protected $DBGroup = 'default';
    protected $table = 'users';    
	protected $primaryKey = 'userId';
	protected $returnType = 'array';
    protected $useSoftDeletes = false;

	protected $protectFields = false;
	protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
	
	function getUserDataBySubsc ($text,$userParamId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('userdata');
		$builder->like ('text',$text);
		$builder->where ('userParamId',$userParamId);
		return $builder->get()->getResultArray();
	
	}
	
	function getUserDatas ($field='',$param='') {
	
		$db = \Config\Database::connect();
		$builder = $db->table('userdata');
		if (is_array($field)) { $i=0;
			foreach ($field as $one) {
				if (isset($param[$i])) { $builder->where ($one,$param[$i]); } $i++;
			}
		} else {
			if ($field!='') { $builder->where ($field,$param); }
		}
		return $builder->get()->getResultArray();
	
	}
	
	function getUserData ($userParamId,$code) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('userdata');
		$builder->where ('userParamId',$userParamId);
		$builder->where ('code',$code);
		return $builder->get()->getRowArray();
	
	}
	
	function getUsers($userCatId,$page,$perPage,$typelist='page') {
	
		$db = \Config\Database::connect();
		$builder = $db->table($this->table);
	
		if (session('ctUserSearch')!='') { 
			
			$search = session('ctUserSearch');
			
			$builder->like ('text',$search);
			$builder->join('userdata', 'users.code = userdata.code','inner');
			$builder->orLike ('email',$search);
			$builder->orLike ('fio',$search);
			$builder->orLike ('phone',$search);
			$builder->orLike ('surname',$search);
			$builder->groupBy ('users.code');
			
		} else {
			if ($userCatId>0) {
				$builder->where ('userCatId',$userCatId);
				$builder->join('usercatlink', 'users.userId = usercatlink.userId','inner');
			}
		}
		
		$builder->orderBy ('regDate','desc'); 
		
		if ($typelist=='page') {
			$builder->select('*, users.userId as userId');
			$builder->limit($perPage,$page);
			return $builder->get()->getResultArray();
		}
		
		if ($typelist=='coun') {
			return $builder->countAllResults();
		}
		
	}
	
	function getUserTabDataByCat ($userCatId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('usertabdata');
		$builder->where ('userCatId',$userCatId);
		return $builder->get()->getResultArray();
		
	}
	
	function getUserParams () {
	
		$db = \Config\Database::connect();
		$builder = $db->table('userparams');
		$builder->orderBy ('number','asc');
		return $builder->get()->getResultArray();
		
	}
	
	function getUserTabs () {
	
		$db = \Config\Database::connect();
		$builder = $db->table('usertabs');
		$builder->orderBy ('number','asc');
		return $builder->get()->getResultArray();
		
	}
	
	function getUserTab ($field='',$param='') {
		
		$db = \Config\Database::connect();
		$builder = $db->table('usertabs');
		if (is_array($field)) { $i=0;
			foreach ($field as $one) {
				if (isset($param[$i])) { $builder->where ($one,$param[$i]); } $i++;
			}
		} else {
			if ($field!='') { $builder->where ($field,$param); }
		}
		return $builder->get()->getRowArray();
		
	}
	
	function getUserCats () {

		$db = \Config\Database::connect();
		$builder = $db->table('usercat');
		$builder->orderBy ('number','asc');
		return $builder->get()->getResultArray();
		
	}
	
	function getUsersByTree ($userCatId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('users');
		$builder->like ('tree','|'.$userCatId.'|');
		return $builder->get()->getResultArray();
	
	}
	
	function getUserCat ($field='',$param='') {
		
		$db = \Config\Database::connect();
		$builder = $db->table('usercat');
		if (is_array($field)) { $i=0;
			foreach ($field as $one) {
				if (isset($param[$i])) { $builder->where ($one,$param[$i]); } $i++;
			}
		} else {
			if ($field!='') { $builder->where ($field,$param); }
		}
		return $builder->get()->getRowArray();
		
	}
	
	function getUserCatsBy ($field='',$param='') {
		
		$db = \Config\Database::connect();
		$builder = $db->table('usercat');
		if (is_array($field)) { $i=0;
			foreach ($field as $one) {
				if (isset($param[$i])) { $builder->where ($one,$param[$i]); } $i++;
			}
		} else {
			if ($field!='') { $builder->where ($field,$param); }
		}
		return $builder->get()->getResultArray();
		
	}
	
	function addUserCat ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('usercat');
		$builder->insert ($data);
	
	}
	
	function editUserCat ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('usercat');
		$builder->where ('userCatId',$data['userCatId']);
		$builder->update ($data);
	
	}
	
	function addUserLink ($data) {
	
		$count = $this->testUserCatLink($data);
		if ($count==0) {	
			$db = \Config\Database::connect();
			$builder = $db->table('usercatlink');
			$builder->insert ($data);
			
		}
		
	}
	
	function testUserCatLink ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('usercatlink');
			
		$builder->where ('userId',$data['userId']);
		$builder->where ('userCatId',$data['userCatId']);
		return $builder->countAllResults();
		
	}
	
	function delUserLinkByUser ($userId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('usercatlink');
		$builder->where ('userId',$userId);
		$builder->delete ();
	
	}
	
	function delUserLinkByCat ($userCatId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('usercatlink');
		$builder->where ('userCatId',$userCatId);
		$builder->delete ();
	
	}
	
	function delUserData ($code) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('userdata');
		$builder->where ('code',$code);
		$builder->delete ();
	
	}
	
	function delUserCat ($userCatId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('usercat');
		$builder->where ('userCatId',$userCatId);
		$builder->delete ();
	
	}
	
	function delUserTabData ($userCatId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('usertabdata');
		$builder->where ('userCatId',$userCatId);
		$builder->delete ();
	
	}
	
	function getUserCatByTree ($userCatId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('usercat');
		$builder->like ('tree','|'.$userCatId.'|');
		return $builder->get()->getResultArray();
	
	}
	
	function addUserData ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('userdata');
		$builder->insert ($data);
		
	}
	
	function editUserData ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('userdata');
		$builder->where ('userDataId',$data['userDataId']);
		$builder->update ($data);
	
	}
	
	function addUserParam ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('userparams');
		$builder->insert ($data);
	
	}
	
	function editUserParam ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('userparams');
		$builder->where ('userParamId',$data['userParamId']);
		$builder->update ($data);
		
	}
	
	function getUserTabData ($userTabId,$userCatId) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('usertabdata');
		$builder->where ('userCatId',$userCatId);
		$builder->where ('userTabId',$userTabId);
		return $builder->get()->getRowArray();
		
	}
	
	function editUserTabData ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('usertabdata');
		$builder->where ('userTabDataId',$data['userTabDataId']);
		$builder->update ($data);
	
	}
	
	function addUserTabData ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('usertabdata');
		$builder->insert ($data);
	
	}
	
	function editUserTab ($data) {
		
		$db = \Config\Database::connect();
		$builder = $db->table('usertabs');
		$builder->where ('userTabId',$data['userTabId']);
		$builder->update ($data);
	
	}
	
	function delUserParam ($userParamId) {
	
		$db = \Config\Database::connect();
		
		$builder = $db->table('userdata');
		$builder->where ('userParamId',$userParamId);
		$builder->delete ();
		
		$builder = $db->table('userparams');
		$builder->where ('userParamId',$userParamId);
		$builder->delete ();
	
	}
	
	function delUserTab ($userTabId) {
	
		$db = \Config\Database::connect();
		
		$builder = $db->table('usertabdata');
		$builder->where ('userTabId',$userTabId);
		$builder->delete ();
	
		$builder = $db->table('usertabs');
		$builder->where ('userTabId',$userTabId);
		$builder->delete ();
	
	}
	
	function testUserTabUrl ($url) {
	
		$db = \Config\Database::connect();
		
		$builder = $db->table('usertabs');
		$builder->where ('url',$url);
		return $builder->countAllResults();
		
	}
	
	function addUserTab ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('usertabs');
		$builder->insert ($data);
	
	}
	
	function checkEmail ($email,$userId=0) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('users');
	
		if ($userId!=0) { $builder->where ('userId !=',$userId); }
		$builder->where ('email',$email);
		return $builder->countAllResults();
		
	}
	
	function checkEmailPassword ($email,$password) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('users');
	
		$builder->where ('password',$password); 
		$builder->where ('email',$email);
		return $builder->countAllResults();
		
	}
	
	function testOnline ($code) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('sessions');
		$builder->like ('data','"'.$code.'"');
		return $builder->countAllResults();
	
	}
	
	function setCheckParam ($code) {

		$db = \Config\Database::connect();
		$builder = $db->table('userdata');
		$data = array ('text' => 0);
		$builder->where ('type','checkbox');
		$builder->where ('code',$code);
		$builder->update ($data);
		
	}
	
	function testIssetUserParam ($userParamId,$code) {
	
		$userData = $this->getUserData($userParamId,$code);
		if (!isset($userData['userDataId'])) {
			return 0;
		} else {
			return $userData['userDataId'];
		}
		
	}
	
	function testUserCode ($code,$userId=0) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('users');
	
		if ($userId!=0) { $builder->where ('userId !=',$userId); }
		$builder->where ('code',$code);
		return $builder->countAllResults();
	
	}
	
	function testUserActivation ($activation) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('users');
	
		$builder->where ('activation',$activation);
		return $builder->countAllResults();
	
	}
	
	function ctCountUsers ($userCatId) {
		
		$db = \Config\Database::connect();
		$builder = $db->table('users');
		if ($userCatId>0) {
			$builder->where ('userCatId',$userCatId);
			$builder->join('usercatlink', 'users.userId = usercatlink.userId','inner');
		} 
		if (session('ctUsersSearch')!='') { 
			$search = session('ctUsersSearch');
			$where = "(code LIKE '%$search%' OR firstName LIKE '%$search%' OR phone LIKE '%$search%' OR email LIKE '%$search%' OR surname LIKE '%$search%')";
			$builder->where ($where);
		}
		return $builder->countAllResults();
		
	}
	
}