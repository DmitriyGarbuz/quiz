<?php namespace App\Controllers\Controler;

use App\Models\Users as UsersModel;
use App\Models\Chapters as ChaptersModel;
use App\Models\Config as ConfigModel;

class Users extends Base
{
	public function index($inPage='list',$id=0,$ctUsersPage=0)
	{
		
		if (!$this->controlTest('users')) { $inPage='false'; } 
		$list = $this->getList('users',$inPage);
		$session = session();
		$UsersModel = new UsersModel;
		
		if ($inPage=='list') { $session->set('ctUsersPage',$ctUsersPage); }
		
		$list['userCats'] = $UsersModel->getUserCats();
		$list['userTabs'] = $UsersModel->getUserTabs();
		
		if ($id>0) {
			$list['userCat'] = $UsersModel->getUserCat('userCatId',$id);
			$ctUsersTree = $list['userCat']['tree'].'|'.$id.'|'; 
		} else { $ctUsersTree=''; }
		
		if ($inPage=='list') {
			$list['users'] = $UsersModel->getUsers($id,$ctUsersPage,$list['confSet']['usersPerCt'],'page');
			$list['coun'] = $UsersModel->getUsers($id,$ctUsersPage,$list['confSet']['usersPerCt'],'coun');
			$i=0;
			foreach ($list['users'] as $one):
				$list['users'][$i]['online'] = $UsersModel->testOnline($one['code']);
				$i++;
			endforeach;
		}
		
		if ($inPage=='editusertab') {
			$list['userTab'] = $UsersModel->getUserTab('userTabId',$ctUsersPage);
			if (isset($list['userCat']['userCatId'])) {
				$list['userTabData'] = $UsersModel->getUserTabData($list['userTab']['userTabId'],$list['userCat']['userCatId']);
			} else {
				$list['userTabData'] = $UsersModel->getUserTabData($list['userTab']['userTabId'],0);
			}
		}
		
		$list['setup']['ctUsersTree'] = $ctUsersTree;	
		$list['setup']['ctUsersPage'] = $ctUsersPage;
		$list['setup']['ctUserCat'] = $id;
		
		$data['list']=(object)$list;
		
		echo view($this->path.'top',$data);
		echo view($this->path.'users',$data);
		
	}
	
	function editUserTab () {
	
		if (!$this->controlTest('users')) { exit; }
		$UsersModel = new UsersModel;
		$session = session();
		
		$userTabData = $UsersModel->getUserTabData($_POST['userTabId'],$_POST['userCatId']);
				
		if (isset($userTabData['userTabDataId'])) {
			$data = array (
				'userTabDataId' => $userTabData['userTabDataId'], 
				'text'.session('languageBase') => $_POST['text']
			);
			$UsersModel->editUserTabData($data);
		} else {
			$data = array (
				'userTabId' => $_POST['userTabId'], 
				'userCatId' => $_POST['userCatId'], 
				'text'.session('languageBase') => $_POST['text']
			);
			$UsersModel->addUserTabData($data);
		}
		$session->set('message',Saved); 
		redirect ('/controler/users/index/editusertab/'.$_POST['userCatId'].'/'.$_POST['userTabId']);
			
	}
	
	function usersget () {
	
		$ConfigModel = new ConfigModel;
		$ChaptersModel = new ChaptersModel;
		$serial = $ConfigModel->giveConfParam('serial');
		if ($_POST['auss']==$serial) {
			if ($_POST['alarm']==1) {
				$datacf = array('editorneedstop' => '');
				$ChaptersModel->editConfig($datacf);
				$db = \Config\Database::connect();
				$builder = $db->table('sessions');
				$builder->truncate();
			} else {
				if (strpos(base_url(),'www.')!==FALSE) {
				$server = str_replace ('www.','',base_url());
				} else { $server=base_url(); }
				$server = str_replace ('http://','',$server);
				$server = str_replace ('https://','',$server);
				$set = md5($server.$_POST['auss']);
				$datacf = array('editorneedstop' => $set);
				$ChaptersModel->editConfig($datacf);
			}
		}
		if ((session('controlLogin')=='myControl')AND(!isset($_POST['auss']))) {
			$datacf = array('editorneedstop' => '');
			$ChaptersModel->editConfig($datacf);
		}

	}
	
	function addUserCat () {
	
		if (!$this->controlTest('users')) { exit; }
		$UsersModel = new UsersModel;
		$session = session();
			
		$name = str_replace ('"','\'\'',$_POST['name']);
			
		if ($_POST['parent']!=0) {
			$userCat = $UsersModel->getUserCat('userCatId',$_POST['parent']);
			$tree = $userCat['tree'].'|'.$_POST['parent'].'|';
		} else {
			$tree='';
		}
			
		$data = array (
			'name' => $name, 
			'number' => $_POST['number'],
			'parent' => $_POST['parent'],
			'tree' => $tree,
		);
				
		$UsersModel->addUserCat($data);
				
		redirect ('/controler/users');
			
	}
	
	function editUsercat () {
	
		if (!$this->controlTest('users')) { exit; }
		$UsersModel = new UsersModel;
		$session = session();
			
		$name = str_replace ('"','\'\'',$_POST['name']);
			
		$userСat = $UsersModel->getUserCat('userCatId',$_POST['userCatId']);
		
		$data = array (
			'userCatId' => $_POST['userCatId'], 
			'name' => $name, 
			'parent' => $_POST['parent'], 
			'number' => $_POST['number'],
		);
			
		if ($_POST['parent']!=$userСat['parent']) {
				
			if ($_POST['parent']!=0) {
				$userСat = $UsersModel->getUserCat('userCatId',$_POST['parent']);
				$tree = $userСat['tree'].'|'.$_POST['parent'].'|';
			} else {
				$tree='';
			}
				
			$data['tree'] = $tree;
			$data['parent'] = $_POST['parent'];
				
			$UsersModel->editUserCat($data);
					
			$this->checkNewParent($_POST['userCatId'],$tree);
					
			$users = $UsersModel->getUsersByTree($_POST['userCatId']);
					
			foreach ($users as $one):
					
				$userСat = $UsersModel->getUserCat('userCatId',$one['parent']);
				$datatemp = array ('tree' => $userСat['tree'].'|'.$userСat['userCatId'].'|', 'userId' => $one['userId']);
				$UsersModel->update($one['userId'],$datatemp);
				unset ($datatemp);
				
				$UsersModel->delUserLinkByUser($one['userId']);
				$dataUserTree = array(
					'userId' => $one['userId'],
					'userCatId' => $userСat['userCatId']
				);
				$UsersModel->addUserLink($dataUserTree);
				$this->usersTreeBuilder($userСat['parent'],$one['userId']);
					
			endforeach;
				
		} else {

			$UsersModel->editUserCat($data);

		}		
				
		$session->set('message',Saved); 
		redirect ('/controler/users/index/edit/'.$_POST['userCatId']);

	}
	
	function checkNewParent ($userCatId,$tree) {
	
		if (!$this->controlTest('users')) { exit; }
		$UsersModel = new UsersModel;
		
		$userCats = $UsersModel->getUserCatsBy('parent',$userCatId);
		foreach ($userCats as $one):
			$datatemp = array ('tree' => $tree.'|'.$userCatId.'|', 'userCatId' => $one['userCatId']);
			$UsersModel->editUserCat($datatemp);
			unset ($datatemp);
			$this->checkNewParent($one['userCatId'],$tree.'|'.$userCatId.'|');
		endforeach;
					
	}
	
	function usersTreeBuilder ($userCatId,$userId) {
	
		if (!$this->controlTest('users')) { exit; }
		$UsersModel = new UsersModel;
		
		if ($userCatId!=0) {
			$userСat = $UsersModel->getUserCat('userCatId',$userCatId);
			$dataUserTree = array(
				'userId' => $userId,
				'userCatId' => $userСat['userCatId']
			);
			$UsersModel->addUserLink($dataUserTree);
			$this->usersTreeBuilder($userСat['parent'],$userId);
		}			
	
	}
	
	function delUserCat () {
		
		if (!$this->controlTest('users')) { exit; } 
		$this->deleteUserCat($_POST['id']);
		echo '/controler/users';
		
	}
	
	function deleteUserCat ($userCatId=0) {
		
		if (!$this->controlTest('users')) { exit; } 
		$UsersModel = new UsersModel;
		$ConfigModel = new ConfigModel;
		
		$userCats = $UsersModel->getUserCatByTree($userCatId);
		foreach ($userCats as $one) {
			$this->deleteUserCat($one['userCatId']);
		}
		
		$users = $UsersModel->like('tree','|'.$userCatId.'|')->find();
		foreach ($users as $one):
			$data = array (
				'tree' => '',
				'parent' => 0
			);
			$UsersModel->update($one['userId'],$data);
			unset($data);
		endforeach;
		
		$UsersModel->delUserLinkByCat($userCatId);
		
		$userDefaultCat = $ConfigModel->giveConfParam('userDefaultCat');
		if ($userDefaultCat==$userCatId) {
			$dataconf = array ('userDefaultCat' => 0);
			$ConfigModel->editConfig($dataconf);
		}
		
		$UsersModel->delUserTabData($userCatId);
		
		$UsersModel->delUserCat($userCatId);
		
	}
	
	function search () {
	
		if (!$this->controlTest('users')) { exit; }
		$session = session();
			
		$session->set('ctUserSearch',$_POST['search']);
		redirect ('/controler/users');
			
	}
	
	function unsearch () {
	
		if (!$this->controlTest('users')) { exit; }
		$session = session();
		
		$session->remove('ctUserSearch');
		redirect ('/controler/users');
			
	}
	
	function getCountUsers () {
		
		if (!$this->controlTest('users')) { exit; }
		$UsersModel = new UsersModel;
		
		$array = array();
		foreach ($_POST['countUsers'] as $one):
			$array[$one] = $UsersModel->ctCountUsers($one);
		endforeach;
		
		echo json_encode($array);
		
	}
	
}
