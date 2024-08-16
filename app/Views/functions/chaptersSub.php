<?php
$stop=0; 
foreach ($list->chapters as $one): 
	if (($one['parent']==$list->setup['topChapter'])AND($list->chapter['subChapters']==0)) { $stop=1; } 
	if (($one['parent']==$list->chapter['chapterId'])AND($list->chapter['subChapters']==1)) { $stop=1; } 
	if (($one['parent']==$list->chapter['parent'])AND($list->chapter['subChapters']==2)) { $stop=1; } 
endforeach;
if ($stop==1) { ?>
<section class="fnc--column--chapters">
	<div class="fnc--column--chapters__title">
		<? if ($list->chapter['subChapters']==0) { foreach ($list->chapters as $one): if ($one['chapterId']==$list->setup['topChapter']) { echo $one['name'.session('Langtext')]; } endforeach; } ?>
		<? if ($list->chapter['subChapters']==1) { foreach ($list->chapters as $one): if ($one['chapterId']==$list->chapter['chapterId']) { echo $one['name'.session('Langtext')]; } endforeach; } ?>
		<? if ($list->chapter['subChapters']==2) { 
			if ($list->chapter['parent']!=0) { 
				foreach ($list->chapters as $one): if ($one['chapterId']==$list->chapter['parent']) { echo $one['name'.session('Langtext')]; } endforeach; 
			} else { echo $list->confLang['chapters']; } 
		} ?>
	</div>
	<div class="fnc--column--chapters__container">
		<? helper ('tree'); ?>
		<? if ($list->chapter['subChapters']==0) { chaptersTree($list->chapters,$list->setup['topChapter'],$list->setup['topChapter'],0,0,$list->setup['chapterTree'],$list->confSet['openChapters'],$list->pos,session('Langtext'),session('Langlink')); } ?>
		<? if ($list->chapter['subChapters']==1) { chaptersTree($list->chapters,$list->chapter['chapterId'],$list->chapter['chapterId'],0,0,$list->setup['chapterTree'],$list->confSet['openChapters'],$list->pos,session('Langtext'),session('Langlink')); } ?>
		<? if ($list->chapter['subChapters']==2) { chaptersTree($list->chapters,$list->chapter['parent'],$list->chapter['parent'],0,0,$list->setup['chapterTree'],$list->confSet['openChapters'],$list->pos,session('Langtext'),session('Langlink')); } ?>
	</div>
</section>
<?php } ?>