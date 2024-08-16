<?php namespace App\Controllers;

use App\Models\Users as UsersModel;
use App\Models\Config as ConfigModel;

class Auth extends Base {

	function google ($lang='') {
	
		$ConfigModel = new ConfigModel;
		$session = session();
		helper('nespi');
		$ggAppId = $ConfigModel->giveConfParam($param='ggAppId');
		$ggSecret = $ConfigModel->giveConfParam($param='ggSecretId');
		$redirect_uri = base_url().'auth/google';
		
		if ($_SERVER['REMOTE_ADDR']!='127.0.0.1') {
		
			if (isset($_GET['code'])) {
				$result = false;
				$params = array(
					'client_id'     => $ggAppId,
					'client_secret' => $ggSecret,
					'redirect_uri'  => $redirect_uri,
					'grant_type'    => 'authorization_code',
					'code'          => $_GET['code']
				);
				$url = 'https://accounts.google.com/o/oauth2/token';
			}

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($curl);
			curl_close($curl);
			
			$tokenInfo = json_decode($result, true);

			if (isset($tokenInfo['access_token'])) {
				$params['access_token'] = $tokenInfo['access_token'];
				$userInfo = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo' . '?' . urldecode(http_build_query($params))), true);
				if (isset($userInfo['id'])) {
					$userInfo = $userInfo;
					$result = true;
				}
			}

			$uid = $userInfo['id'];
			$first_name = $userInfo['given_name'];
			$last_name = $userInfo['family_name'];
			$email = $userInfo['email'];
			
			$user = $UsersModel->where ('uid',$uid)->first();
			
			if (isset($user['userId'])) {
				if ($user['active']==1) {
					$session->set('userLogined','ok');
					$session->set('userId',$user['userId']);	
					$session->set('userCode',$user['code']);		
					$session->set('userFio',$user['fio']);					
					$session->set('userGroup',$user['parent']);	
					$session->set('userEmail',$user['email']);	
					$datauser = array (
						'entDate' => date('U'), 
						'userId' => $user['userId']
					);
					$UsersModel->update ($user['userId'],$datauser);
				}
				redirect ('/'.Langlink);
			} else {
				
				$userDefaultCat = $ConfigModel->giveConfParam($param='userDefaultCat');
		
				$code = getNullString($col=6);
				$newUserCode = $code;
				$testCode=TRUE;
				$string='';
				while ($testCode!=FALSE) {
					$testCode = $UsersModel->testUserCode($newUserCode);
					if ($testCode!=FALSE) {
						$string = getNullString($col=6);
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
						
				if ($userDefaultCat!=0) {
					$userCat = $UsersModel->getUserCat('userCatId',$userDefaultCat);
					$tree = $userCat['tree'].'|'.$userDefaultCat.'|';
				} else { $tree=''; }
					
				$datauser = array (
					'regDate' => date('U'), 
					'parent' => $userDefaultCat, 
					'tree' => $tree, 
					'email' => $email, 
					'password' => getSameString($col=10),
					'code' => $code, 
					'active' => 1,
					'activation' => $activation,
					'fio' => $last_name.' '.$first_name, 
					'uid' => $uid,
				);
				$UsersModel->insert ($datauser);
			
				$user = $UsersModel->where('code',$code)->first();
				$session->set('userLogined','ok');
				$session->set('userFio',$user['fio']);
				$session->set('userId',$user['userId']);	
				$session->set('userCode',$user['code']);								
				$session->set('userGroup',$user['parent']);	
				$session->set('userEmail',$user['email']);	
				redirect ('/'.Langlink);
				
			}
		
		}
		
		
	}
	
	function facebook ($lang='') {
	
		$ConfigModel = new ConfigModel;
		$session = session();
		helper('nespi');
		$fbAppId = $ConfigModel->giveConfParam($param='fbAppId');
		$fbSecretId = $ConfigModel->giveConfParam($param='fbSecretId');
	
		if ($_SERVER['REMOTE_ADDR']!='127.0.0.1') {
		
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/oauth/access_token?client_id='.$fbAppId.'&redirect_uri='.base_url().'auth/facebook&client_secret='.$fbSecretId.'&code='.$_GET['code']);
			$answer = curl_exec($ch);
			curl_close($ch);
		
			$jsontest = json_decode($answer,true);
			
			$token = $jsontest['access_token'];
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/me?locale=en_US&fields=name,email&access_token='.$token);
			$answer1 = curl_exec($ch);
			curl_close($ch);
		
			$json = json_decode($answer1,true);
		
			$user = $UsersModel->where ('uid',$json['id'])->where ('email',$json['email'])->first();
			
			if (isset($user['userId'])) {
				if ($user['active']==1) {
					$session->set('userLogined','ok');
					$session->set('userId',$user['userId']);	
					$session->set('userCode',$user['code']);		
					$session->set('userFio',$user['fio']);					
					$session->set('userGroup',$user['parent']);	
					$session->set('userEmail',$user['email']);	
					$datauser = array (
						'entDate' => date('U'), 
						'userId' => $user['userId']
					);
					$UsersModel->update ($user['userId'],$datauser);
				}
				redirect ('/'.Langlink);
			} else{
		
				$userDefaultCat = $ConfigModel->giveConfParam($param='userDefaultCat');
		
				$code = getNullString($col=6);
				$newUserCode = $code;
				$testCode=TRUE;
				$string='';
				while ($testCode!=FALSE) {
					$testCode = $UsersModel->testUserCode($newUserCode);
					if ($testCode!=FALSE) {
						$string = getNullString($col=6);
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
						
				if ($userDefaultCat!=0) {
					$userCat = $UsersModel->getUserCat('userCatId',$userDefaultCat);
					$tree = $userCat['tree'].'|'.$userDefaultCat.'|';
				} else { $tree=''; }
					
				$datauser = array (
					'regDate' => date('U'), 
					'parent' => $userDefaultCat, 
					'tree' => $tree, 
					'email' => $json['email'], 
					'password' => getSameString($col=10),
					'code' => $code, 
					'active' => 1,
					'activation' => $activation,
					'fio' => $json['name'], 
					'uid' => $json['id'],
				);
				$UsersModel->insert ($datauser);
			
				$user = $UsersModel->where('code',$code)->first();
				$session->set('userLogined','ok');
				$session->set('userFio',$user['fio']);
				$session->set('userId',$user['userId']);	
				$session->set('userCode',$user['code']);								
				$session->set('userGroup',$user['parent']);	
				$session->set('userEmail',$user['email']);	
				redirect ('/'.Langlink);
		
			}
		
		}
		
		
	}
	
	function vkontakte ($lang='') {
	
		$ConfigModel = new ConfigModel;
		$session = session();
		helper('nespi');
		$vkAppId = $ConfigModel->giveConfParam($param='vkAppId');
		$vkSecretId = $ConfigModel->giveConfParam($param='vkSecretId');
	
		if ($_SERVER['REMOTE_ADDR']!='127.0.0.1') {
		
			$ch = curl_init();
		
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_URL, 'https://oauth.vk.com/access_token?client_id='.$vkAppId.'&client_secret='.$vkSecretId.'&code='.$_GET['code'].'&redirect_uri='.base_url().'auth/vkontakte');
			$answer = curl_exec($ch);
			curl_close($ch);
		
			$answer = json_decode($answer,true);
		
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_URL, 'https://api.vk.com/method/getProfiles.xml?uid='.$answer['user_id'].'&access_token='.$answer['access_token']);
			$answer1 = curl_exec($ch);
			curl_close($ch);
		
			$pos1 = strpos ($answer1,'<uid>');
			$pos2 = strpos ($answer1,'</uid>');
			$leng = $pos2-($pos1+5);
			$uid = trim(substr ($answer1,$pos1+5,$leng));
		
			$pos1 = strpos ($answer1,'<first_name>');
			$pos2 = strpos ($answer1,'</first_name>');
			$leng = $pos2-($pos1+12);
			$first_name = trim(substr ($answer1,$pos1+12,$leng));
		
			$pos1 = strpos ($answer1,'<last_name>');
			$pos2 = strpos ($answer1,'</last_name>');
			$leng = $pos2-($pos1+11);
			$last_name = trim(substr ($answer1,$pos1+11,$leng));
		
			$user = $UsersModel->where ('uid',$uid)->first();
			
			if (isset($user['userId'])) {
				if ($user['active']==1) {
					$session->set('userLogined','ok');
					$session->set('userId',$user['userId']);	
					$session->set('userCode',$user['code']);		
					$session->set('userFio',$user['fio']);					
					$session->set('userGroup',$user['parent']);	
					$session->set('userEmail',$user['email']);	
					$datauser = array (
						'entDate' => date('U'), 
						'userId' => $user['userId']
					);
					$UsersModel->update ($user['userId'],$datauser);
				}
				redirect ('/'.Langlink);
			} else {
			
				$userDefaultCat = $ConfigModel->giveConfParam($param='userDefaultCat');
		
				$code = getNullString($col=6);
				$newUserCode = $code;
				$testCode=TRUE;
				$string='';
				while ($testCode!=FALSE) {
					$testCode = $UsersModel->testUserCode($newUserCode);
					if ($testCode!=FALSE) {
						$string = getNullString($col=6);
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
						
				if ($userDefaultCat!=0) {
					$userCat = $UsersModel->getUserCat('userCatId',$userDefaultCat);
					$tree = $userCat['tree'].'|'.$userDefaultCat.'|';
				} else { $tree=''; }
					
				$datauser = array (
					'regDate' => date('U'), 
					'parent' => $userDefaultCat, 
					'tree' => $tree, 
					'email' => $email, 
					'password' => getSameString($col=10),
					'code' => $code, 
					'active' => 1,
					'activation' => $activation,
					'fio' => $first_name.' '.$last_name, 
					'uid' => $uid,
				);
				$UsersModel->insert ($datauser);
			
				$user = $UsersModel->where('code',$code)->first();
				$session->set('userLogined','ok');
				$session->set('userFio',$user['fio']);
				$session->set('userId',$user['userId']);	
				$session->set('userCode',$user['code']);								
				$session->set('userGroup',$user['parent']);	
				$session->set('userEmail',$user['email']);	
				redirect ('/'.Langlink);
			
			}
		
		}
		
	}
	
}