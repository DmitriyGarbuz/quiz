<div class="languages">
<? $langnow = str_replace('_','',Langtext); ?>
<? foreach ($list->languages as $one): ?>
	<div <? if ($one['url']==$langnow) { ?>class="languageact"<? } else { ?>class="language"<? } ?>>
		<? if ($one['url']!='') { ?>
		<a href="/<? echo $one['url']; ?>/<? echo $list->setup['nowPage']; ?>"><? echo $one['nameSite']; ?></a>
		<? } else { ?>
		<a href="/<? echo $list->setup['nowPage']; ?>"><? echo $one['nameSite']; ?></a>
		<? } ?>
	</div>
<? endforeach; ?>
</div>