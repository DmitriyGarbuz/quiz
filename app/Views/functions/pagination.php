<?php
$aaa = $list->coun%$options['perPage']; $pages = ($list->coun/$options['perPage'])+1; 
$j = ($options['nowPage']/$options['perPage'])+1;
$i = $j-6; $prim = $i; $max = $j+6; if ($max>$pages) { $max=$pages; } if ($i<1) { $i=1; }
$rightchapterpage = $j*$options['perPage']; $leftchapterpage = ($j-2)*$options['perPage'];
if ($options['nowPage']!=0) { ?>
<div class="fnc--paging--button pointerhand js__pagination--button" data-page="<?= $leftchapterpage/$options['perPage']; ?>" data-type="<?= $options['linkType']; ?>" data-url="<?= $options['linkUrl']; ?>">
	◄
</div>
<? }
for ($i;$i<=$max;$i++) {
	$chapterpage = ($i-1)*$options['perPage'];
	$j = ($options['nowPage']/$options['perPage'])+1;
	if ($j==$i) { ?>
	<div class="fnc--paging--button__now"><?= $i; ?></div>
	<? } else { if (($i!=$max)AND($i!=$prim)) { ?>
	<div class="fnc--paging--button pointerhand js__pagination--button" data-page="<?= $chapterpage/$options['perPage']; ?>" data-type="<?= $options['linkType']; ?>" data-url="<?= $options['linkUrl']; ?>"><?= $i; ?></div> 
	<? } } 
}
if ($options['nowPage']/$options['perPage']+2<$pages) { ?>
<div class="fnc--paging--button pointerhand js__pagination--button" data-page="<?= $rightchapterpage/$options['perPage']; ?>" data-type="<?= $options['linkType']; ?>" data-url="<?= $options['linkUrl']; ?>">
	►
</div>
<? } ?>