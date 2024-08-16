<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function makeUrl($name) {
	
		$search = array("™", " ", "а", "б", "в", "г", "д", "е", "ё", "ж", "з", "и", "й", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш", "щ", "ъ", "ы", "ь", "э", "ю", "я", ".", "/", "\\", ",", "\:", "(", ")", "і", "ї", "І", "є", '"', '\'', "`", "&", "-", "*", "!", "?", "+", "«", "»", "%", "#", "=", "№", ":", ";");
		$replace = array("", "_", "a", "b", "v", "g", "d", "e", "e", "zh", "z", "i", "i", "k", "l", "m", "n", "o", "p", "r", "s", "t", "u", "f", "h", "c", "ch", "sh", "sh", "", "i", "", "e", "yu", "ya", "", "", "", "", "", "", "", "i", "i", "i", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");
		$newstr = str_replace($search, $replace, $name);
		$search = array("А", "Б", "В", "Г", "Д", "Е", "Ё", "Ж", "З", "И", "Й", "К", "Л", "М", "Н", "О", "П", "Р", "С", "Т", "У", "Ф", "Х", "Ц", "Ч", "Ш", "Щ", "Ъ", "Ы", "Ь", "Э", "Ю", "Я");
		$replace = array("a", "b", "v", "g", "d", "e", "e", "zh", "z", "i", "i", "k", "l", "m", "n", "o", "p", "r", "s", "t", "u", "f", "h", "s", "ch", "sh", "sh", "", "i", "", "e", "yu", "ya");
		$newstr = str_replace($search, $replace, $newstr);
		$newstr = mb_strtolower($newstr);
	
		return preg_replace("/[^A-Za-z0-9\-\_]/i","",(string)$newstr);
	
	}	
	
	function getSameString ($col) {
	
		$string='';
		while (strlen($string)!=$col) {
			$char = chr(rand(48,122)); 
			if (mb_ereg("^([a-z0-9])+$",$char)) { $string .= $char; }
		}
		return $string;
	
	}
	
	function removeDirRec($dir) {
		
		if ($objs = glob($dir."/*")) {
			foreach($objs as $obj) {
				is_dir($obj) ? removeDirRec($obj) : unlink($obj);
			}
		}
		rmdir($dir);
	
	}
	
	function getNullString ($col) {
	
		$string='';
		while (strlen($string)!=$col) {
			$char = chr(rand(48,122)); 
			if (mb_ereg("^([0-9])+$",$char)) { $string .= $char; }
		}
		return $string;
	
	}
	
	function sendsms ($link,$login,$password,$sender,$destination,$text) {
		
		$client = new SoapClient ($link); 
		$auth = Array ( 
			'login' => $login, 
			'password' => $password,
		); 
		$result = $client->Auth ($auth); 
		$sms = Array ( 
			'sender' => $sender, 
			'destination' => $destination, 
			'text' => $text 
		); 
		$result = $client->SendSMS ($sms); 
		
	}
	