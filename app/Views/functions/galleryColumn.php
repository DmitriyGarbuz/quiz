<?php if (count($options['colGallery'])>0) { ?>
<div class="fnc--column--gallery">
	<div class="fnc--column--gallery__title">
		<? echo $options['chapter']['name']; ?>
	</div>
	<div class="fnc--column--gallery__container">
		<? foreach ($options['colGallery'] as $one): ?>
		<div class="fnc--column--gallery__listitem">
			<div class="fnc--column--gallery--listitem__name">
				<? if ($one['link'.session('Langtext')]!='') { echo '<a href="'.$one['link'.session('Langtext')].'">'; } ?>
				<? echo $one['text'.session('Langtext')]; ?>
				<? if ($one['link'.session('Langtext')]!='') { echo '</a>'; } ?>
			</div>
			<div class="fnc--column--gallery--listitem__image">
				<a title="<? echo $one['text'.session('Langtext')]; ?>" href="/<? echo $one['previewbg']; ?>" data-fancybox="gallery" data-animation-effect="false"><img src="/<? echo $one['previewsm']; ?>" alt="<? echo $one['text'.session('Langtext')]; ?>"></a>
			</div>
		</div>
		<? endforeach; ?>
		<div class="fnc--column--gallery__button"><a href="/<? echo session('Langlink'); ?><? echo $options['chapter']['url']; ?>"><? echo $list->confLang['seeAll']; ?></a></div>
	</div>
</div>
<? } ?>