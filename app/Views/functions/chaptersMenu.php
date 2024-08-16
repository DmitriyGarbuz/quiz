<div class="menu--chapters">
	<? $i=0; ?>
	<? foreach ($list->chapters as $one): ?>
	<? if (($one['parent']==0)AND(($one['position']=='top')OR($one['position']=='all'))) { ?>
	<div <? if (strpos($list->setup['chapterTree'],'|'.$one['chapterId'].'|')!==FALSE) { echo 'class="menu--chapters__item menu--chapters--item__active '.$one['addClass'].'"'; } else { echo 'class="menu--chapters__item '.$one['addClass'].'"'; } ?> >
		<a <? if (strpos($list->setup['chapterTree'],'|'.$one['chapterId'].'|')!==FALSE) { echo 'class="menu--chapters__link menu--chapters--link__active"'; } else { echo 'class="menu--chapters__link"'; } ?> <? if ($one['link'.session('Langtext')]=='') { ?>href="/<? echo session('Langlink'); ?><? echo $one['url']; ?>"<? } else { ?>href="<? echo $one['link'.session('Langtext')]; ?>"<? } ?>><? echo $one['name'.session('Langtext')]; ?></a>
	</div>
	<? $i++; ?>
	<? } ?>
	<? endforeach; ?>
</div>
<div class="menu--chapters--mobile"><div class="js__show--mobile--menu"><? echo $list->confLang['menu']; ?></div></div>