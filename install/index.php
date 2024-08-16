<?php 
$settings = file_get_contents("settings.json"); $settings = json_decode($settings);   
foreach ($settings as $one) { $one = (array)$one; if ($one['name']=='language') { $language=$one['param']; } if ($one['name']=='prefix') { $prefix=$one['param']; } } 
header("Cache-control: no-cache"); 
require_once '../app/Language/'.$language.'/language.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>NespiCMS V2.0 <? echo Install; ?></title>
	<link rel="stylesheet" href="/admin/css/title.css" type="text/css">
	<link rel="shortcut icon" href="/favicon.ico"/>
	<script src="/js/jquery.js"></script>
	<script src="/js/jquery-ui.js"></script>
	<script id="defaultLocale" data-lang="<?= $prefix; ?>" src="/admin/js/admin.js"></script>
	<script src="/js/jquery.form.js"></script>
</head>
<body>
<div id="backall" style="display:none;background:#000000;width:100%;height:100%;position:fixed;z-index:400;opacity:0.9;"><div align="center" style="margin:0 auto; margin-top:150px;"><img style="max-width:150px;" border="0" src="/admin/img/loading.gif"></div></div>
<div class="loginbg">
	<div class="logoheader">
		<div align="center">
			<a href="https://www.nespicms.com" target="_blank"><img border="0" src="/admin/img/nespicmsbusiness.png"></a>
		</div>
	</div>
	<div class="titlename">
		NespiCMS V2.0 Business - <? echo Install; ?>
	</div>
	<div class="initshadblock">
		<div class="table_all">
			<div class="cellname">
				<? echo Language; ?>
			</div>
			<div class="cellparam">
				<select id="installlanguage" name="installlanguage">
					<option  value="ukrainian" <? if ($language=='ukrainian') { echo 'selected'; } ?>><? echo Ukrainian; ?></option>
					<option  value="russian" <? if ($language=='russian') { echo 'selected'; } ?>><? echo Russian; ?></option>
					<option  value="english" <? if ($language=='english') { echo 'selected'; } ?>><? echo English; ?></option>
				</select>
			</div>
		</div>
		<div class="table_all">
			<div class="cellname">
				<? echo Sitename; ?>
			</div>
			<div class="cellparam">
				<input autocomplete="off" type="text"  id="sitename" name="sitename" >
				<div class="sminfotext"><? echo Lettersenttext; ?></div>
			</div>
		</div>
		<div class="table_all">
			<div class="cellname">
				<? echo Admin_email; ?>
			</div>
			<div class="cellparam">
				<input autocomplete="off" type="text"  id="siteemail" name="siteemail" >
				<div class="sminfotext"><? echo Emailsenttext; ?></div>
			</div>
		</div>
		<div class="table_all">
			<div class="cellname">
				<div class="bginfotext"><? echo Serialproduct; ?></div>
			</div>
		</div>
		<div class="table_all">
			<div class="cellname">
				<? echo SerialNumber; ?>
			</div>
			<div class="cellparam">
				<input autocomplete="off" type="text"  id="serial" name="serial" >
				<div class="sminfotext"><? echo Numberatnespicms; ?> - <a target="_blank" href="https://nespicms.com">nespicms.com</a></div>
			</div>
		</div>
		<div class="table_all">
			<div class="cellname">
				<div class="bginfotext"><? echo Dataforconnect; ?></div>
			</div>
		</div>
		<div class="table_all">
			<div class="cellname">
				<? echo BDHost; ?>
			</div>
			<div class="cellparam">
				<input autocomplete="off" name="bdhost" id="bdhost" type="text">
			</div>
		</div>
		<div class="table_all">
			<div class="cellname">
				<? echo Database; ?>
			</div>
			<div class="cellparam">
				<input autocomplete="off" type="text" id="bdname" name="bdname">
			</div>
		</div>
		<div class="table_all">
			<div class="cellname">
				<? echo User; ?>
			</div>
			<div class="cellparam">
				<input autocomplete="off" type="text"  id="bduser" name="bduser" >
			</div>
		</div>
		<div class="table_all">
			<div class="cellname">
				<? echo Password; ?>
			</div>
			<div class="cellparam">
				<input autocomplete="off" type="text"  id="bdpass" name="bdpass" >
			</div>
		</div>
		<div class="table_all">
			<div class="cellname">
				<? echo Createdatabase; ?>
			</div>
			<div class="cellparam">
				<input style="width: unset;" type="checkbox"  name="makebase" checked id="makebase">
			</div>
		</div>
		<div class="table_all">
			<div class="cellname">
				<? echo Uplobasefile; ?>
			</div>
			<div class="cellparam">
				<form id="bdfileform"  method="post" enctype="multipart/form-data" action="/install/initbase.php"><input type="file" name="userfile" id="bdfile"></form>
				<div class="sminfotext"><? echo Transferdatabase; ?></div>	
			</div>
		</div>
		<div class="table_all">
			<div class="cellfull" style="text-align: center;">
				<input type="submit" id="initbut" value="<? echo Install_NespiCMS; ?>" class="stand">
			</div>
		</div>
		<div class="table_all_no_border">
			<div class="cellfull fail" id="initInfo">
						
			</div>
		</div>
	</div>	
	<div id="allfooterinit" style="padding:10px 0;">
		<div align="center" style="font-size:11px;" cellpadding="5px">
			<table align="center">
				<tr>
					<td align="center">
						+38 (044) 3607529, +38 (094) 9254529, +38 (050) 9483260
					</td>
				</tr>
				<tr>
					<td align="center">
						email: office@nespicms.com, <a style="color:#444947;" href="https://nespicms.com" target="_blank">https://nespicms.com</a>
					</td>
				</tr>
				<tr>
					<td>
						<div style="height:1px; border-bottom:1px solid #000; width:100%;"></div>
					</td>
				</tr>
				<tr>
					<td align="center">
						©"NespiCMS" 2010-<? echo date('Y'); ?>. <? echo All_rights_reserved; ?>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
</body>
