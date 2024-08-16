<?php if (count($options['centGallery'])>0) { ?>
<div class="fnc--slider--gallery">
	<div class="fnc--slider--gallery__title">
		<? echo $options['chapter']['name'.session('Langtext')]; ?>
	</div>
	<div class="fnc--slider--gallery__container" id="js__slider--gallery--info<? echo $options['chapter']['chapterId']; ?>">
		<div class="fnc--slider--gallery--container__left js__slider--gallery__left">
			<button type="button" id="js__gallery--left<? echo $options['chapter']['chapterId']; ?>" data-parent="<? echo $options['chapter']['chapterId']; ?>" disabled style="opacity:0" data-info="0">◄</button>
		</div>
		<div class="fnc--slider--gallery--container__center">
			<div class="fnc--slider--gallery--container--center__slider" id="js__gallery--center--container<? echo $options['chapter']['chapterId']; ?>" data-parent="<? echo $options['chapter']['chapterId']; ?>" style="display:none; overflow:hidden;">
				<div class="fnc--slider--gallery--container--center__main js__slider--gallery__container">
					<? foreach ($options['centGallery'] as $one): ?>
					<div class="fnc--slider--gallery--container--center__listitem js__slider--gallery__main">
						<div class="fnc--slider--gallery--container--center__item">
							<div class="fnc--slider--gallery--container--center__image">
								<a href="/<? echo $one['previewbg']; ?>" title="<? echo $one['text'.session('Langtext')]; ?>"  data-fancybox="gallery<? echo $options['chapter']['chapterId']; ?>" data-animation-effect="false"><img alt="<? echo $one['text'.session('Langtext')]; ?>" src="/<? echo $one['previewsm']; ?>"></a> 
							</div>
							<div class="fnc--slider--gallery--container--center__link">
								<a href="<? echo $one['link'.session('Langtext')]; ?>"><? echo $one['text'.session('Langtext')]; ?></a>
							</div>
						</div>
					</div>
					<? endforeach; ?>
				</div>
			</div>
		</div>
		<div class="fnc--slider--gallery--container__right js__slider--gallery__right">
			<button type="button" id="js__gallery--right<? echo $options['chapter']['chapterId']; ?>" data-parent="<? echo $options['chapter']['chapterId']; ?>" disabled style="opacity:0" data-info="0">►</button>
		</div>
	</div>	
	<div class="fnc--slider--gallery--button">
		<a href="/<? echo session('Langlink'); ?><? echo $options['chapter']['url']; ?>"><? echo $list->confLang['seeAll']; ?></a>
	</div>		
</div>
<? } ?>