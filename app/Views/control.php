<!DOCTYPE html><? header('Content-Type: text/html; charset=utf-8'); ?>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/favicon.ico"/>
	<title>NespiCMS V2.0. <?= Control_Panel; ?>.</title>
	<link rel="stylesheet" href="/<? echo $list->confSet['admincss']; ?>" type="text/css">
	<script src="/js/jquery.js"></script>
	<script src="/js/jquery-ui.js"></script>
	<script id="defaultLocale" data-lang="<?= defaultLocalePrefix; ?>" src="/admin/js/admin.js"></script>
</head>
<body>
	<section class="full--height--section">
		<section class="auth--header little--padding">
			<a href="https://www.nespicms.com" target="_blank"><img border="0" src="/admin/img/nespicmsbusiness.png"></a>
		</section>
		
		<section class="auth--block little--padding">
			<div class="auth--block_line">
				<input type="text" placeholder="<?= Login; ?>" class="js__control--user--login">
			</div>
			<div class="auth--block_line">
				<input type="password" placeholder="<?= Password; ?>" class="js__control--user--password">
			</div>
			<div class="auth--block_line">
				<button class="js__control--button--login"><?= Enter; ?></button>
			</div>
			<div class="fail--message js__control--info--message"></div>
		</section>
		
		<section class="auth--header little--padding">
			<div>
				+38 (044) 3607529, +38 (094) 9254529, +38 (050) 9483260
			</div>
			<div>
				email: office@nespicms.com, <a style="color:#444947;" href="https://nespicms.com" target="_blank">https://nespicms.com</a>
			</div>
			<div>
				©"NespiCMS" 2010-<?=date('Y');?>.  <?= All_rights_reserved; ?>
			</div>
		</section>
	</section>
</body>




