<?php if (count($options['centArticles'])>0) { ?>
<section class="fnc--center--articles <?=$options['chapter']['addClass']; ?>">
	<div class="fnc--center--articles__title">
		<? echo $options['chapter']['name'.Langtext]; ?>
	</div>
	<div class="fnc--center--articles__container">	
		<? foreach ($options['centArticles'] as $one): ?>
		<div class="fnc--center--articles__listitem">
			<div class="fnc--center--articles__listitem_main">
				<div class="fnc--center--articles--listitem__name">
					<a href="/<? echo Langlink; ?>article/<? echo $one['url']; ?>"><? echo $one['name'.Langtext]; ?></a>
				</div>
				<? if ($one['preview']!='') { ?>
				<div class="fnc--center--articles--listitem__image">
					<a href="/<? echo Langlink; ?>article/<? echo $one['url']; ?>"><img alt="<? echo $one['name'.Langtext]; ?>" src="/<? echo $one['preview']; ?>"></a>
				</div>
				<? } ?>
			</div>
			<div class="fnc--center--articles--listitem__info">
				<? echo $one['info'.Langtext]; ?>
			</div>
		</div>
		<? endforeach; ?>
	</div>	
	<div class="fnc--center--articles__button">
		<a href="/<? echo Langlink; ?><? echo $options['chapter']['url']; ?>"><? echo $list->confLang['moreInfo']; ?></a>
	</div>
</section>
<? } ?>