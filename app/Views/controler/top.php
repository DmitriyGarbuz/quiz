<!DOCTYPE html><? header('Content-Type: text/html; charset=utf-8'); ?>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/favicon.ico"/>
	<title>NespiCMS V2.0. <?= Control_Panel; ?>.</title>
	<link rel="stylesheet" href="/<? echo $list->confSet['admincss']; ?>" type="text/css">
	<link rel="stylesheet" href="/css/jquery-ui.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="/admin/css/chosen.css" />
	<script src="/js/jquery.js"></script>
	<script src="/js/jquery-ui.js"></script>
	<script src="/js/jquery.inputmask.bundle.js"></script>
	<script src="/js/phone.js"></script>
	<script src="/js/jquery.form.js"></script>
	<script src="/js/chosen.js"></script>
	<script src="/js/tinymce/tinymce.min.js"></script>
	<script id="defaultTheme" data-theme="/<?= $list->confSet['themecss']; ?>" src="/js/tiny.js"></script>
	<script id="defaultLocale" data-lang="<?= defaultLocalePrefix; ?>" src="/admin/js/admin.js"></script>
	<script src="/js/datepicker.js"></script>
	<? if ($list->confSet['audio']!='') { ?><audio id="orderwav" data-per="<? echo $list->confSet['audioPer']; ?>"><source src="<? echo base_url().$list->confSet['audio']; ?>"></source></audio><? } ?>
</head>
<body>
<section class="body--height">
<div id="backall" class="background--pattern"></div>
<div class="js__popup--window">
	<div class="popup--close"><button class="js__popup--close">X</button></div>
	<div class="js__popup--text" id="popUpText"></div>
	<div class="popup--confirm"><button class="js__popup--confirm"><? echo Yes; ?></button></div>
</div>
<section id="leftdivnew" class="mobile--chapters">
	<?foreach ($list->ctChapters as $one): ?>
	<? if ($one['topMenu']==1) { ?>
	<div class="<? if ($list->actPage==$one['url']) { echo 'topmenuactive tm_'.$one['url'].'_act'; } else { echo 'topmenu tm_'.$one['url']; } ?>" style="border-right:0;">
		<a href="/controler/<? echo $one['url']; ?>"><? echo $one['name'.defaultLocalePrefix]; ?></a>
	</div>
	<? } ?>
	<?endforeach; ?>
</section>
<section class="header--block">
	<div class="header--block__left">
		<div class="mobile--menu">
			<div class="mobile--menu__absolute">
				<img class="pointer--hand" id="showmobilemenu" border="0" src="/admin/img/icons/list.svg">
			</div>
		</div>
		<div class="header">
			<a href="https://www.nespicms.com" target="_blank"><img border="0" src="/admin/img/nespicmsbusiness.png" class="max--height--28"></a>
		</div>
	</div>
	<div class="header--block__right">
		<div class="header--menu">
			<? foreach ($list->ctChapters as $one): if ($one['topMenu']==1) { ?><div onClick="location='/controler/<? echo $one['url']; ?>'" class="<? if ($list->actPage==$one['url']) { echo 'header--menu__menu--active tm--'.$one['url'].'_active'; } else { echo 'header--menu__menu tm--'.$one['url']; } ?>">
				<a href="/controler/<? echo $one['url']; ?>"><? echo $one['name'.defaultLocalePrefix]; ?></a>
			</div><? } endforeach; ?>
		</div>
		<div class="header--out">
			<? if (count($list->languages)>1) { ?>
			<? foreach ($list->languages as $one): ?>
			<div class="header--out__language">
				<span style="<? if (session('languageBase')=='_'.$one['url']) { ?> color:#fff; font-weight:Bolder;<? } else { ?> <? if ((session('languageBase')=='')AND($one['url']=='')) { ?> color:#fff; font-weight:Bolder;<? } else{ ?> color:#fff;<? }} ?>cursor:pointer; cursor:hand;" data-url="<? echo $one['url']; ?>" id="changeLanguage">[<? if ($one['url']=='') { echo 'main'; } else { echo $one['url']; } ?>]</span>
			</div>
			<? endforeach; ?>
			<? } ?>
			<div class="header--out__icon">
				<a class="text--decor_none" href="/" target="_blank"><img border="0" src="/admin/img/icons/home.svg"></a>
			</div>
			<div class="header--out__icon">
				<img class="pointer--hand js__logOut" border="0" src="/admin/img/icons/logout-variant.svg">
			</div>
		</div>
	</div>
</section>