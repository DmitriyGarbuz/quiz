<?
$uploaddir = './';
$userfile = $uploaddir.basename($_FILES['userfile']['name']);
if (copy($_FILES['userfile']['tmp_name'], $userfile))
{
echo $_FILES['userfile']['name'];
}
else { exit; }