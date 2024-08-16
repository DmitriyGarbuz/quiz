<section class="fnc--comments--list">
<? if (count($list->comments)>0) { ?>
<? foreach ($list->comments as $one): ?>
	<div class="fnc--comments--listitem">
		<div class="fnc--comments--listitem__main">
			<div class="fnc--comments--listitem__name"><? echo $one['firstName']; ?></div>
			<div class="fnc--comments--listitem__date"><? echo date('d.m.Y',$one['date']); ?></div>
		</div>
		<div class="fnc--comments--listitem__text"><? echo $one['text']; ?></div>
	</div>
<? endforeach; ?>
<? } else { ?>
<div class="no--info--find">
	<?=$list->confLang['noDataFound']; ?>
</div>
<? } ?>
</section>
