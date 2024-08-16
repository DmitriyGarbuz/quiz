<? 
$fp = fopen('settings.json', "w"); 
$string = '';
$string = $string."[\r\n";
$string = $string.'{"name": "language","param": "'.$_POST['language'].'"},';
$string = $string."\r\n";
if ($_POST['language']=='russian') {  
	$string = $string.'{"name": "prefix","param": "_ru"},';
}
if ($_POST['language']=='ukrainian') {  
	$string = $string.'{"name": "prefix","param": "_ua"},';
}
if ($_POST['language']=='english') {  
	$string = $string.'{"name": "prefix","param": "_en"},';
}
$string = mb_substr($string, 0, -1);
$string = $string."\r\n";
$string = $string."]\r\n";
fwrite($fp, $string); 		