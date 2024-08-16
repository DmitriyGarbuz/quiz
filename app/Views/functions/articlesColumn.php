<?php 
if (count($options['colArticles'])>0) { ?>
<section class="fnc--column--articles fnc--column--articles__<?= $list->pos; ?> fnc--column--articles__<?=$options['chapter']['addClass']; ?>">
	<div class="fnc--column--articles__title">
		<? echo $options['chapter']['name'.session('Langtext')]; ?>
	</div>
	<div class="fnc--column--articles__container">
		<? foreach ($options['colArticles'] as $one): ?>
		<div class="fnc--column--article_listitem">
			<? if ($one['preview']!='') { ?>
			<div class="fnc--column--article--listitem__img">
				<a href="/<? echo session('Langlink'); ?>article/<? echo $one['url']; ?>"><img src="/<? echo $one['preview']; ?>" alt="<? echo $one['name'.session('Langtext')]; ?>"></a>
			</div>
			<? } ?>
			<div class="fnc--column--article--listitem__info">
				<div class="fnc--column--article--listitem__name">
					<a href="/<? echo session('Langlink'); ?>article/<? echo $one['url']; ?>"><? echo $one['name'.session('Langtext')]; ?></a>
				</div>
				<? if ($options['chapter']['sort']=='date') { ?>
				<div class="fnc--column--article--listitem__date">
					<? echo date('d.m.Y',$one['date']); ?>
				</div>
				<? } ?>
			</div>
		</div>
		<? endforeach; ?>
		<div class="fnc--column--articles__button">
			<a href="/<? echo session('Langlink'); ?><? echo $options['chapter']['url']; ?>"><? echo $list->confLang['moreInfo']; ?></a>
		</div>
	</div>
</section>
<? } ?>