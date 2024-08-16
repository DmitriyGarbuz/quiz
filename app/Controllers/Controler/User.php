<?php namespace App\Controllers\Controler;

use \CodeIgniter\HTTP\Files\UploadedFile;
use App\Models\Users as UsersModel;

class User extends Base
{
	public function index($inPage='add',$id=0,$ctUserPage=0)
	{
		
		if (!$this->controlTest('users')) { $inPage='false'; } 
		$list = $this->getList('users',$inPage);
		
		$UsersModel = new UsersModel;
		
		$list['userCats'] = $UsersModel->getUserCats();
		$list['userParams'] = $UsersModel->getUserParams();
		
		if (($id!=0)AND($inPage!='add')) {
			$list['user'] = $UsersModel->where('userId',$id)->first();
			if (isset($list['user']['userId'])) {
				$list['userDatas'] = $UsersModel->getUserDatas('code',$list['user']['code']);
				$list['userCat'] = $UsersModel->getUserCat('userCatId',$list['user']['parent']);
				$list['user']['online'] = $UsersModel->testOnline($list['user']['code']);
				if (isset($list['userCat']['userCatId'])) {
					$ctUsersTree = $list['userCat']['tree'].'|'.$list['userCat']['userCatId'].'|'; 
					$userCatId=$list['userCat']['userCatId'];
				} else {
					$ctUsersTree='';
					$userCatId='';
				}
			} else { redirect ('/controler/users'); }
		
		} 
		
		if ($inPage=='add') { $ctUsersTree=''; $userCatId=0; }
		
		$list['setup']['ctUsersTree'] = $ctUsersTree;	
		$list['setup']['ctUsersPage'] = session('ctUsersPage');
		$list['setup']['ctUserPage'] = $ctUserPage;
		$list['setup']['ctUserCat'] = $userCatId;
		
		$data['list']=(object)$list;
		
		echo view($this->path.'top',$data);
		echo view($this->path.'user',$data);
		
	}
	
	function checkEmail () {
	
		if (!$this->controlTest('users')) { exit; }
		$UsersModel = new UsersModel;
		echo $UsersModel->checkEmail($_POST['email'],$_POST['userId']);
	
	}
	
	function addUser () {
	
		if (!$this->controlTest('users')) { exit; }
		$UsersModel = new UsersModel;
			
		$userParams = $UsersModel->getUserParams();
				
		helper('nespi');
		$code = getNullString($col=8);
		$newUserCode = $code;
		$testCode=TRUE;
		$string='';
		while ($testCode!=FALSE) {
			$testCode = $UsersModel->testUserCode($newUserCode);
			if ($testCode!=FAlSE) {
				$string = getNullString($col=8);
				$newUserCode = $string;
			}
		}
		$code = $newUserCode;
				
		$activation = getSameString($col=15);
		$newUserActivation = $activation;
		$testActivation=TRUE;
		$string='';
		while ($testActivation!=FALSE) {
			$testActivation = $UsersModel->testUserActivation($newUserActivation);
			if ($testActivation!=FALSE) {
				$string = getSameString($col=15);
				$newUserActivation = $string;
			}
		}
		$activation = $newUserActivation;
			
		if ($_POST['parent']!=0) {
			$userCat = $UsersModel->getUserCat('userCatId',$_POST['parent']);
			$tree = $userCat['tree'].'|'.$_POST['parent'].'|';
		} else { $tree=''; }
			
		$data = array (
			'regDate' => date('U'), 
			'parent' => $_POST['parent'], 
			'email' => $_POST['email'], 
			'password' => $_POST['password'], 
			'code' => $code, 
			'tree' => $tree,
			'activation' => $activation
		);
		if (isset($_POST['active'])) { $data['active']=1; } else { $data['active']=0; }
		if (isset($_POST['phone'])) { $data['phone']=$_POST['phone']; } 
		if (isset($_POST['fio'])) { $data['fio']=$_POST['fio']; } 
		if (isset($_POST['surname'])) { $data['surname']=$_POST['surname']; } 
		if (isset($_POST['whyactive'])) { $data['whyactive'.session('languageBase')]=$_POST['whyactive']; } 
			
		if ($this->request->getFiles('userfile')) {
			$userfile = $this->request->getFiles('userfile');
			$file = $userfile['userfile'];
			
			if ($file->isValid() && ! $file->hasMoved()) {
         
				if ((mb_strtolower($file->getClientExtension())=='jpg')OR($file->getClientExtension()=='png')OR($file->getClientExtension()=='jpeg')OR($file->getClientExtension()=='gif')OR($file->getClientExtension()=='svg')) {
					
					$randomName = $file->getRandomName();
					$file->move('img/users', $randomName);
					$preview = 'img/users/'.$randomName;
					
					$data['preview'] = $preview;
					
				} 
			
			}
			
		}	
			
		$UsersModel->insert ($data);
				
		$user = $UsersModel->where('code',$data['code'])->first();
		$userCat = $UsersModel->getUserCat('userCatId',$_POST['parent']);
		if (isset($userCat['userCatId'])) {
			$dataUserTree = array(
				'userId' => $user['userId'],
				'userCatId' => $userCat['userCatId']
			);
			$UsersModel->addUserLink($dataUserTree);
			$this->usersTreeBuilder($userCat['parent'],$user['userId']);
		}
		unset ($data);
				
		foreach ($userParams as $one):
			$param = $one['userParamId'];
			if ((isset($_POST[$param]))AND($one['type']!='fio')AND($one['type']!='phone')AND($one['type']!='surname')) { 
				$text = str_replace("\n","\n<br>",$_POST[$param]);
				$data = array (
					'userParamId' => $one['userParamId'], 
					'code' => $code,
					'text' => $text, 
					'type' => $one['type']
				);
				$UsersModel->addUserData ($data);
				unset ($data);
			}
		endforeach;
				
		redirect ('/controler/users');
			
	}
	
	function usersTreeBuilder ($userCatId,$userId) {
	
		if (!$this->controlTest('users')) { exit; }
		$UsersModel = new UsersModel;
		
		if ($userCatId!=0) {
			$userCat = $UsersModel->getUserCat('userCatId',$userCatId);
			$dataUserTree = array(
				'userId' => $userId,
				'userCatId' => $userCat['userCatId']
			);
			$UsersModel->addUserLink($dataUserTree);
			$this->usersTreeBuilder($userCat['parent'],$userId);
		}			
	
	}
	
	function editUser () {
	
		if (!$this->controlTest('users')) { exit; }
		$UsersModel = new UsersModel;
		$session = session();
			
		if ($_POST['parent']!=0) {
			$userCat = $UsersModel->getUserCat('userCatId',$_POST['parent']);
			$tree = $userCat['tree'].'|'.$_POST['parent'].'|';
		} else { $tree=''; }
				
		$data = array (
			'parent' => $_POST['parent'], 
			'email' => $_POST['email'], 
			'tree' => $tree,
			'password' => $_POST['password']
		);
		if (isset($_POST['active'])) { $data['active']=1; } else { $data['active']=0; }
		if (isset($_POST['phone'])) { $data['phone']=$_POST['phone']; } 
		if (isset($_POST['fio'])) { $data['fio']=$_POST['fio']; } 
		if (isset($_POST['surname'])) { $data['surname']=$_POST['surname']; } 
		if (isset($_POST['whyactive'])) { $data['whyactive']=$_POST['whyactive']; } 
			
		if ($this->request->getFiles('userfile')) {
			$userfile = $this->request->getFiles('userfile');
			$file = $userfile['userfile'];
			
			if ($file->isValid() && ! $file->hasMoved()) {
         
				if ((mb_strtolower($file->getClientExtension())=='jpg')OR($file->getClientExtension()=='png')OR($file->getClientExtension()=='jpeg')OR($file->getClientExtension()=='gif')OR($file->getClientExtension()=='svg')) {
					
					$user = $UsersModel->where('userId',$_POST['userId'])->first();
					if (file_exists($user['preview'])) {
						unlink($user['preview']);
					}
					
					$randomName = $file->getRandomName();
					$file->move('img/users', $randomName);
					$preview = 'img/users/'.$randomName;
					
					$data['preview'] = $preview;
					
				} 
			
			}
			
		}	
			
			
		$UsersModel->update ($_POST['userId'],$data);
		unset ($data);
				
		$user = $UsersModel->where('userId',$_POST['userId'])->first();
		$UsersModel->delUserLinkByUser($user['userId']);
		$userCat = $UsersModel->getUserCat('userCatId',$_POST['parent']);
		if (isset($userCat['userCatId'])) {
			$dataUserTree = array(
				'userId' => $user['userId'],
				'userCatId' => $userCat['userCatId']
			);
			$UsersModel->addUserLink($dataUserTree);
			$this->usersTreeBuilder($userCat['parent'],$user['userId']);
		}
				
		$UsersModel->setCheckParam($_POST['code']);
		$userParams = $UsersModel->getUserParams();
		foreach ($userParams as $one):
			$param = $one['userParamId'];
			if ((isset($_POST[$param]))AND($one['type']!='fio')AND($one['type']!='phone')AND($one['type']!='surname')) { 
				$text = str_replace("\n","\n<br>",$_POST[$param]);
				$data = array (
					'userParamId' => $one['userParamId'], 
					'text' => $text, 
					'code' => $_POST['code'], 
					'type' => $one['type']
				);
				$userDataId = $UsersModel->testIssetUserParam($data['userParamId'],$_POST['code']);
				if ($userDataId==0){
					$UsersModel->addUserData ($data);
				} else {
					$data['userDataId'] = $userDataId;
					$UsersModel->editUserData($data);
				}
				unset ($data);
			}
		endforeach;
				
		$session->set('message',Saved); 
		redirect ('/controler/user/index/edit/'.$_POST['userId']);
		
	}
	
	function changeUserParent () {
		
		if (!$this->controlTest('users')) { exit; }
		$UsersModel = new UsersModel;
		$session = session();
		
		if ($_POST['parent']!=0) {
			$userCat = $UsersModel->getUserCat($_POST['parent']);
			$tree = $userCat['tree'].'|'.$_POST['parent'].'|';
		} else { $tree=''; }
				
		$data = array (
			'parent' => $_POST['parent'], 
			'tree' => $tree
		);
				
		$UsersModel->update($_POST['userId'],$data);
			
		$user = $UsersModel->where('userId',$_POST['userId'])->first();
		$UsersModel->delUserLinkByUser($user['userId']);
		$userCat = $UsersModel->getUserCat('userCatId',$_POST['parent']);
		if (isset($userCat['userCatId'])) {
			$dataUserTree = array(
				'userId' => $user['userId'],
				'userCatId' => $userCat['userCatId']
			);
			$UsersModel->addUserLink($dataUserTree);
			$this->usersTreeBuilder($userCat['parent'],$user['userId']);
		}
			
	}
	
	function changeUserActive () {
		
		if (!$this->controlTest('users')) { exit; }
		$UsersModel = new UsersModel;
		$session = session();
		
		$data = array (
			'active' => $_POST['active']
		);
				
		$UsersModel->update($_POST['userId'],$data);
					
	}
	
	function delUser () {
	
		if (!$this->controlTest('users')) { exit; }
		$UsersModel = new UsersModel;
		
		$user = $UsersModel->where('userId',$_POST['id'])->first();
		if (file_exists($user['preview'])) {
			unlink ($user['preview']);
		}
		$UsersModel->delUserData($user['code']);
		$UsersModel->delUserLinkByUser($_POST['id']);
		$UsersModel->delete($_POST['id']);
		echo '/controler/users';
			
	}
	
}
