<section class="fnc--articles--list">
<? if (count($list->articles)>0) { ?>
<? foreach ($list->articles as $one): ?>
	<div class="fnc--articles--listitem" >
		<div class="fnc--articles--listitem__main">
			<div class="fnc--articles--listitem__name">
				<a href="/<? echo session('Langlink'); ?>article/<? echo $one['url']; ?>"><? echo $one['name'.session('Langtext')]; ?></a>
			</div>
			<? if ($one['preview']!='') { ?>
			<div class="fnc--articles--listitem__image">
				<a href="/<? echo session('Langlink'); ?>article/<? echo $one['url']; ?>"><img src="/<? echo $one['preview']; ?>" alt="<? echo $one['name'.session('Langtext')]; ?>"></a>
			</div>
			<? }?>
		</div>
		<div class="fnc--articles--listitem__info">
			<? echo $one['info'.session('Langtext')]; ?>
		</div>
		<? if ($list->chapter['sort']=='date') { ?>
		<div class="fnc--articles--listitem__date">
			<? if ((date('H',$one['date'])!=0)OR((date('i',$one['date'])!=0))) { ?>
				<? echo date('d.m.Y H.i',$one['date']); ?>
			<? } else { ?>
				<? echo date('d.m.Y',$one['date']); ?>
			<? } ?>
		</div>
		<? } ?>
	</div>
<? endforeach; ?>
<? } else { ?>
<div class="no--info--find">
	<?=$list->confLang['noDataFound']; ?>
</div>
<? } ?>
</section>
