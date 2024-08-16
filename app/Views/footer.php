<section class="content--footer">
	<div class="content--footer__inner">
		<? echo $list->confSet['footer'.Langtext]; ?>
	</div>
</section>
</section>
<div class="mobilemenuchapters"><?= view ('functions/mobileChapters',(array)$list); ?></div>
</body>
<? if ($list->metaPage=='page404') { die; } ?>