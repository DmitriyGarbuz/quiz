<? if ($list->setup['chapterPage']>0) { ?>
<? foreach ($list->allGallerys as $one): ?>
	<? if ($gall<$list->setup['chapterPage']) { ?><a title="<? echo $one['text'.session('Langtext')]; ?>" href="/<? echo $one['previewbg']; ?>" data-fancybox="gallery" data-animation-effect="false"><img title="<? echo $one['text'.session('Langtext')]; ?>" alt="<? echo $one['text'.session('Langtext')]; ?>" border="0" style="display:none;" src="/<? echo $one['previewsm']; ?>"></a><? } ?>
	<? $gall++; ?>
<? endforeach; ?>
<? } ?>
<section class="fnc--gallery--list">
<? if (count($list->gallerys)>0) { $gall=0; ?>
<? foreach ($list->gallerys as $one): ?>
	<div class="fnc--gallery--listitem">
		<div class="fnc--gallery--listitem__image" >
			<a title="<? echo $one['text'.session('Langtext')]; ?>" href="/<? echo $one['previewbg']; ?>" data-fancybox="gallery" data-animation-effect="false"><img title="<? echo $one['text'.session('Langtext')]; ?>" alt="<? echo $one['text'.session('Langtext')]; ?>" border="0" src="/<? echo $one['previewsm']; ?>"></a>
		</div>
		<? if ($one['text'.session('Langtext')]!='') { ?>
		<div class="fnc--gallery--listitem__text">
			<? if ($one['link'.session('Langtext')]!=''){ ?><a href="<? echo $one['link'.session('Langtext')]; ?>"><? } ?><? echo $one['text'.session('Langtext')]; ?><? if ($one['link'.session('Langtext')]!=''){?></a><? } ?>
		</div>
		<? } ?>
	</div>
	<? $gall++; ?>
<? endforeach; ?>
<? $gall++; $nowgal=0;?>
<? } else { ?>
<div class="no--info--find">
	<?=$list->confLang['noDataFound']; ?>
</div>
<? } ?>
</section>
<? foreach ($list->allGallerys as $one): ?>
	<? if (($gall-1)<=$nowgal) { ?>
		<a title="<? echo $one['text'.session('Langtext')]; ?>" href="/<? echo $one['previewbg']; ?>" data-fancybox="gallery" data-animation-effect="false"><img title="<? echo $one['text']; ?>" alt="<? echo $one['text'.session('Langtext')]; ?>" border="0" style="display:none;" src="/<? echo $one['previewsm']; ?>"></a>
	<? } ?>
<? $nowgal++; ?>
<? endforeach; ?>