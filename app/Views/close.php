<!DOCTYPE html><? header('Content-Type: text/html; charset=utf-8'); ?>
<html>
<head>
	<title>NespiCMS V2.0.</title>
	<link rel="stylesheet" href="/<? echo $list->confSet['admincss']; ?>" type="text/css">
	<link rel="shortcut icon" href="/favicon.ico"/>
	<script type="text/javascript" src="/js/jquery.js"></script>
	<script type="text/javascript" src="/js/jquery-ui.js"></script>
	<script id="defaultLocale" data-lang="<?= defaultLocalePrefix; ?>" src="/admin/js/admin.js"></script>
</head>
<body>
	<section class="full--height--section">
		<section class="auth--header little--padding">
			<a href="https://nespicms.com" target="_blank"><img border="0" src="/admin/img/nespi.png"></a>
		</section>

		<section class="auth--block little--padding">
			<div class="auth--block_line">
				<input autocomplete="off" type="text" class="js__close--login" placeholder="<? echo Login; ?>">
			</div>
			<div class="auth--block_line">
				<input autocomplete="off" type="password" class="js__close--password" placeholder="<? echo Enter; ?>">
			</div>
			<div class="auth--block_line">
				<button type="button" class="js__close--conf--but"><? echo Enter; ?></button>
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



