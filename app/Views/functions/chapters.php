<section class="fnc--column--chapters">
	<div class="fnc--column--chapters__title"><? echo $list->confLang['chapters']; ?></div>
	<? helper ('tree'); ?>
	<div class="fnc--column--chapters__container"><? chaptersTree($list->chapters,0,0,0,0,$list->setup['chapterTree'],$list->confSet['openChapters'],$list->pos,session('Langtext'),session('Langlink')); ?></div>
</section>