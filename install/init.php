<?php 
$settings = file_get_contents("settings.json"); $settings = json_decode($settings);   
foreach ($settings as $one) { $one = (array)$one; if ($one['name']=='language') { $language=$one['param']; } } 
require_once '../app/Language/'.$language.'/language.php';

$mysqli = new mysqli($_POST['bdhost'],$_POST['bduser'],$_POST['bdpass'],$_POST['bdname']);
if ($mysqli->connect_errno) {
    printf(No_connect_base.": %s\n", $mysqli->connect_error); 
	exit;
} else {
	$mysqli->set_charset("utf8");
	$sitename = $_POST['sitename'];
	$siteemail = $_POST['siteemail'];
	if ($_POST['makebase']==1) {
		if (file_exists('../nespicms_business.sql')) {
			$sqlSource = file_get_contents('../nespicms_business.sql');
			if ($mysqli->multi_query($sqlSource)) {
				do {
				   if ($result = mysqli_store_result($mysqli)) { mysqli_free_result($result); }
				   if (mysqli_more_results($mysqli)) {}
				} while (mysqli_next_result($mysqli));
			}
		} else { 
			echo Install_file_missed.' "nespicms_business.sql"';
			exit;
		}
	}
	if ($_POST['bdfile']!='') {
		$sqlSource = file_get_contents($_POST['bdfile']);
		if ($mysqli->multi_query($sqlSource)) {
			do {
				if ($result = mysqli_store_result($mysqli)) { mysqli_free_result($result); }
				if (mysqli_more_results($mysqli)) {}
			} while (mysqli_next_result($mysqli));
		}
	}
	$cool=0;
	$result = $mysqli->query("SELECT * FROM `ns_config` WHERE `name`='serial'");
	while($obj = $result->fetch_object()){
		if  ($obj->param==trim($_POST['serial'])) { $cool=1; } else {
			echo  Wrong_serial_number; 
			exit;
		}
	}
	if ($cool==1) {
		$file_array = file("../app/Config/Database.php");
		$str1=0; $str2=0; $str3=0; $str4=0; $str=0;
		foreach ($file_array as $one):
			if (strpos($one,"'hostname'")!==FALSE) { $file_array[$str] = '\'hostname\' => \''.$_POST['bdhost'].'\','; $file_array[$str] = $file_array[$str]."\r\n"; }
			if (strpos($one,"'username'")!==FALSE) { $file_array[$str] = '\'username\' => \''.$_POST['bduser'].'\','; $file_array[$str] = $file_array[$str]."\r\n"; }
			if (strpos($one,"'password'")!==FALSE) { $file_array[$str] = '\'password\' => \''.$_POST['bdpass'].'\','; $file_array[$str] = $file_array[$str]."\r\n"; }
			if (strpos($one,"'database'")!==FALSE) { $file_array[$str] = '\'database\' => \''.$_POST['bdname'].'\','; $file_array[$str] = $file_array[$str]."\r\n"; }
			$str++;
		endforeach;
		$fp = fopen("../app/Config/Database.php", "w");
		foreach ($file_array as $one):
			fputs($fp,$one);
		endforeach;
		$name='editorneedstop';
		if (strpos($_SERVER['HTTP_HOST'],'www.')!==FALSE) {
			$server = str_replace ('www.','',$_SERVER['HTTP_HOST']);
		} else { $server=$_SERVER['HTTP_HOST']; }
		$set = md5($server.'/'.$_POST['serial']);
		$mysqli->query("UPDATE ns_config SET `param` = '$set' WHERE name = '$name'");
		$mysqli->query("UPDATE ns_config SET `param` = '$siteemail' WHERE name = 'fromEmail'");
		$mysqli->query("UPDATE ns_config SET `param` = '$siteemail' WHERE name = 'faqemail'");
		$mysqli->query("UPDATE ns_config SET `param` = '$siteemail' WHERE name = 'callmeemail'");
		$mysqli->query("UPDATE ns_config SET `param` = '$sitename' WHERE name = 'from'");
		
		if (isset($_POST['installlanguage'])) {
			if ($_POST['installlanguage']=='russian') {}
			if ($_POST['installlanguage']=='ukrainian') {
				$mysqli->query("ALTER TABLE `ns_langnames` ADD `param_ru` varchar(255) NOT NULL");
				$result = $mysqli->query("SELECT * FROM `ns_langnames`");
				while($obj = $result->fetch_object()){
					$param = $obj->param_ua;
					$param_ru = $obj->param;
					$nick = $obj->nick;
					$mysqli->query("UPDATE ns_langnames SET `param` = '$param' WHERE nick = '$nick'");
					$mysqli->query("UPDATE ns_langnames SET `param_ru` = '$param_ru' WHERE nick = '$nick'");
				}
				$mysqli->query("ALTER TABLE ns_langnames DROP param_ua");
			}
			if ($_POST['installlanguage']=='english') {
				$mysqli->query("ALTER TABLE `ns_langnames` ADD `param_ru` varchar(255) NOT NULL");
				$result = $mysqli->query("SELECT * FROM `ns_langnames`");
				while($obj = $result->fetch_object()){
					$param = $obj->param_en;
					$param_ru = $obj->param;
					$nick = $obj->nick;
					$mysqli->query("UPDATE ns_langnames SET `param` = '$param' WHERE nick = '$nick'");
					$mysqli->query("UPDATE ns_langnames SET `param_ru` = '$param_ru' WHERE nick = '$nick'");
				}
				$mysqli->query("ALTER TABLE ns_langnames DROP param_en");
			}
			
			$languages = file_get_contents("../app/Language/ctlang.json"); 
			$languages = json_decode($languages);    
			$array = array(); 
			foreach ($languages as $one) { 
				if($one->nick==$_POST['installlanguage']) {
					$one->selected = 1;
				} else {
					$one->selected = 0;
				}
				array_push($array,$one);
			}
			$array = json_encode($array);
			file_put_contents('../app/Language/ctlang.json', $array);
		}
		
		echo 'OK';
		exit;
	} else  {
		echo  Wrong_serial_number; 
		exit;
	}	
}
