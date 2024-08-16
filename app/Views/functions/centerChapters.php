<?php
$chapters=array();
if ($list->chapter['atView']==1) { foreach ($list->chapters as $one): if ($one['parent']==0) { $chapters[] = $one; } endforeach; }
if ($list->chapter['atView']==2) { foreach ($list->chapters as $one): if ($one['parent']==$list->chapter['chapterId']) { $chapters[] = $one; } endforeach; }
if ($list->chapter['atView']==3) { $chapters=$list->compMenu; }
?>
<section class="fnc--center--chapters">
	<div class="fnc--center--chapters__container">
		<? foreach ($chapters as $one): ?>
		<div class="fnc--center--chapters__list--item <?=$one['addClass'];?>">
			
			<div class="fnc--center--chapters--item__main">
				<div class="fnc--center--chapters--item__name">
					<a <? if ($one['link'.session('Langtext')]=='') { ?>href="/<? echo session('Langlink'); ?><? echo $one['url']; ?>"<? } else { ?>href="<? echo $one['link'.session('Langtext')]; ?>"<? } ?>><? echo $one['name'.session('Langtext')]; ?></a>
				</div>
				<div class="fnc--center--chapters--item__image">
					<? if ($one['preview']!='') { ?>
						<a <? if ($one['link'.session('Langtext')]=='') { ?>href="/<? echo session('Langlink'); ?><? echo $one['url']; ?>"<? } else { ?>href="<? echo $one['link'.session('Langtext')]; ?>"<? } ?>><img alt="<? echo $one['name'.session('Langtext')]; ?>" src="/<? echo $one['preview']; ?>"></a>
					<? } else { ?>
						<a <? if ($one['link'.session('Langtext')]=='') { ?>href="/<? echo session('Langlink'); ?><? echo $one['url']; ?>"<? } else { ?>href="<? echo $one['link'.session('Langtext')]; ?>"<? } ?>><img alt="<? echo $one['name'.session('Langtext')]; ?>" src="/<? echo $list->confSet['noImage']; ?>"></a>
					<? } ?>
				</div>
			</div>
			<div class="fnc--center--chapters--item__additional">
				<div class="fnc--center--chapters--item__info">
					<? echo $one['info'.session('Langtext')]; ?>
				</div>
				<div class="fnc--center--chapters--item__button">
					<a <? if ($one['link'.session('Langtext')]=='') { ?>href="/<? echo session('Langlink'); ?><? echo $one['url']; ?>"<? } else { ?>href="<? echo $one['link'.session('Langtext')]; ?>"<? } ?>><? echo $list->confLang['moreInfo']; ?></a>
				</div>
			</div>
		</div>
		<? endforeach; ?>
	</div>
</section>