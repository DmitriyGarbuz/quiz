<!--Слайдер-->
<section class="under--header--slider">
<? if ((isset($list->banNote['sliderleft']))AND($list->banNote['sliderleft']!='')) { ?><div class="under--header--slider__left"><? echo $list->banNote['sliderleft']; ?></div><? } ?>
<? if ((isset($list->sitNote['overcenter']['funcName']))AND($list->sitNote['overcenter']['funcName']=='slider')) { ?><div class="under--header--slider__center"><? echo view ('functions/slider',(array)$list,$list->sitNote['overcenter']['advancedData']); ?></div><? } ?>
<? if ((isset($list->sitNote['overcenter']['funcName']))AND(strpos($list->sitNote['overcenter']['funcName'],'my_')!==FALSE)) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->sitNote['overcenter']['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach; } ?>
<? if ((isset($list->banNote['sliderright']))AND($list->banNote['sliderright']!='')) { ?><div class="under--header--slider__right"><? echo $list->banNote['sliderright']; ?></div><? } ?>
</section>
<!---->
<!--Контент страницы-->
<? if ((isset($list->banNote['header']))AND($list->banNote['header']!='')) { echo '<div class="deliver">'.$list->banNote['header'].'</div>'; } ?>
<section class="content--center--main <? echo $list->note['addClass']; ?>">
	<div class="content--center--inner">
		<!--Левая колонка-->
		<? if ((isset($list->sitNote['leftcolumn']['funcName']))AND($list->sitNote['leftcolumn']['funcName']=='yes')) { ?>
		<section class="content--center--inner__left">
			<div class="content--center--inner--left__column">
				<!--Загрузка модулей конструктора страницы для левой колонки-->
				<? $list->pos='left'; ?>
				<? for ($col=1;$col<6;$col++) { ?>
				<? if ((isset($list->banNote['left'.$col]))AND($list->banNote['left'.$col]!='')) { echo '<div class="content--left__deliver">'.$list->banNote['left'.$col].'</div>'; } ?>
				<? if ((isset($list->sitNote['left'.$col]['funcName']))AND($list->sitNote['left'.$col]['funcName']!='')) { ?>
				<div class="content--left__deliver">
				<? if ((isset($list->sitNote['left'.$col]['funcName']))AND(strpos($list->sitNote['left'.$col]['funcName'],'my_')!==FALSE)) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->sitNote['left'.$col]['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach; 
				} else { if ((isset($list->sitNote['left'.$col]['funcName']))AND($list->sitNote['left'.$col]['funcName']!='')) { echo view ('functions/'.$list->sitNote['left'.$col]['funcName'],(array)$list,$list->sitNote['left'.$col]['advancedData']); } } ?>
				</div>
				<? } } ?>
				<? if ((isset($list->banNote['left6']))AND($list->banNote['left6']!='')) { echo '<div class="content--left__deliver">'.$list->banNote['left6'].'</div>'; } ?>
				<!---->
			</div>
		</section>
		<? } ?>
		<!---->
		<!--Ценральная колонка-->
		<section class="content--center--inner__center">
			<div class="content--center--inner--center__column">
				<!--Хлебные крошки-->
				<? if ($list->chapter['breed']==1) { echo view ('functions/chapterBreads',(array)$list); } ?>
				<!---->
				<!--Загрузка модулей конструктора страницы для центральной страницы колонки-->
				<? for ($col=1;$col<5;$col++) { ?>
				<? if (($col==1)OR($col==3)) { echo '<div class="incenter incenter_'.$list->metaPage.$col.'_'.$list->chapter['url'].'">'; } ?>
				<? if (((isset($list->sitNote['center'.$col]['funcName']))AND($list->sitNote['center'.$col]['funcName']!=''))OR((isset($list->banNote['centerin'.$col]))AND($list->banNote['centerin'.$col]!=''))) { ?>
				<div class="delivercent delivercent_<? echo $list->metaPage.$col.'_'.$list->chapter['url']; ?>">
					<? if ((isset($list->sitNote['center'.$col]['funcName']))AND(strpos($list->sitNote['center'.$col]['funcName'],'my_')!==FALSE)) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->sitNote['center'.$col]['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach;
					} else { if ((isset($list->sitNote['center'.$col]['funcName']))AND($list->sitNote['center'.$col]['funcName']!='')) { $list->sitNote['center'.$col]['funcName']($list,$list->sitNote['center'.$col]['advancedData']); } }
					if (isset($list->banNote['centerin'.$col])) { echo $list->banNote['centerin'.$col]; }
					?>
				</div>
				<? } ?>
				<? if (($col==2)OR($col==4)) { echo '</div>'; } ?>
				<? if ($col==2) { if ((isset($list->banNote['center1']))AND($list->banNote['center1']!='')) { echo '<div class="deliver">'.$list->banNote['center1'].'</div>'; } } ?>
				<? } ?>	
				<!---->
				<!--Основной контент страницы-->
				<section class="content--center--note">
					<div class="notemenu">
						<? foreach ($list->noteTabs as $one): ?>
						<div class="notetabposition">
						<div onClick="location='/<? echo Langlink; ?>note/<? echo $list->note['url']; ?>/<? echo $one['url']; ?>'" class="<? if ($list->tab==$one['url']) { ?>notetabact<? } else { ?>notetab<? } ?>">
							<a href="/<? echo Langlink; ?>note/<? echo $list->note['url']; ?>/<? echo $one['url']; ?>"><? echo $one['name'.Langtext]; ?></a>
						</div>
						</div>
						<? endforeach; ?>
					</div>
					<? if (isset($list->noteTab['text'.Langtext])) { ?>
						<div class="notetext"><? echo $list->noteTab['text'.Langtext]; ?></div>
					<? } else { ?>
						<div class="notetext"><? echo $list->note['text'.Langtext]; ?></div>
					<? } ?>
				</section>
				<!---->
				<!--Загрузка модулей конструктора страницы для центральной страницы колонки-->
				<? for ($col=5;$col<9;$col++) { ?>
				<? if (($col==5)OR($col==7)) { echo '<div class="content--center__separator content--center--separator--'.$col.'">'; } ?>
				<? if (((isset($list->sitNote['center'.$col]['funcName']))AND($list->sitNote['center'.$col]['funcName']!=''))OR((isset($list->banNote['centerin'.$col]))AND($list->banNote['centerin'.$col]!=''))) { ?>
				<div class="content--center__deliver content--center--deliver__<? echo $col; ?>">
					<? if ((isset($list->sitNote['center'.$col]['funcName']))AND(strpos($list->sitNote['center'.$col]['funcName'],'my_')!==FALSE)) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->sitNote['center'.$col]['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach;
					} else { if ((isset($list->sitNote['center'.$col]['funcName']))AND($list->sitNote['center'.$col]['funcName']!='')) { echo view ('functions/'.$list->sitNote['center'.$col]['funcName'],(array)$list,$list->sitNote['center'.$col]['advancedData']); } }
					if (isset($list->banNote['centerin'.$col])) { echo $list->banNote['centerin'.$col]; }
					?>
				</div>
				<? } ?>
				<? if (($col==6)OR($col==8)) { echo '</div>'; } ?>
				<? if ($col==6) { if ((isset($list->banNote['center2']))AND($list->banNote['center2']!='')) { echo '<div class="content--center__deliver">'.$list->banNote['center2'].'</div>'; } } ?>
				<? } ?>	
				<!---->
			</div>
		</section>
		<!---->
		<!--Правая колонка-->
		<? if ((isset($list->sitNote['rightcolumn']['funcName']))AND($list->sitNote['rightcolumn']['funcName']=='yes')) { ?>
		<section class="content--center--inner__right">
			<div class="content--center--inner--right__column">
				<? $list->pos='right'; ?>
				<? for ($col=1;$col<6;$col++) { ?>
				<? if ((isset($list->banNote['right'.$col]))AND($list->banNote['right'.$col]!='')) { echo '<div class="content--right__deliver">'.$list->banNote['right'.$col].'</div>'; } ?>
				<? if ((isset($list->sitNote['right'.$col]['funcName']))AND($list->sitNote['right'.$col]['funcName']!='')) { ?>
				<div class="content--right__deliver">
				<? if ((isset($list->sitNote['right'.$col]['funcName']))AND(strpos($list->sitNote['right'.$col]['funcName'],'my_')!==FALSE)) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->sitNote['right'.$col]['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach; 
				} else { if ((isset($list->sitNote['right'.$col]['funcName']))AND($list->sitNote['right'.$col]['funcName']!='')) { echo view ('functions/'.$list->sitNote['right'.$col]['funcName'],(array)$list,$list->sitNote['right'.$col]['advancedData']); } } ?>
				</div>
				<? } } ?>
				<? if ((isset($list->banNote['right6']))AND($list->banNote['right6']!='')) { echo '<div class="content--right__deliver">'.$list->banNote['right6'].'</div>'; } ?>
			</div>
		</section>
		<? } ?>
		<!--Левая колонка-->
	</div>
</section>
<!---->
<? if ((isset($list->banNote['footer']))AND($list->banNote['footer']!='')) { echo '<div class="content--footer__deliver">'.$list->banNote['footer'].'</div>'; } ?>