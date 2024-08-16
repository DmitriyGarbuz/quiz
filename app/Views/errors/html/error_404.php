<?php header("HTTP/1.1 404 Not Found"); ?>
<!--Контент страницы-->
<? if ((isset($list->banShablon['header']))AND($list->banShablon['header']!='')) { echo '<div class="deliver">'.$list->banShablon['header'].'</div>'; } ?>
<section class="content--center--main error404">
	<div class="content--center--inner">
		<!--Левая колонка-->
		<? if ((isset($list->sitShablon['leftcolumn']['funcName']))AND($list->sitShablon['leftcolumn']['funcName']=='yes')) { ?>
		<section class="content--center--inner__left">
			<div class="content--center--inner--left__column">
				<!--Загрузка модулей конструктора страницы для левой колонки-->
				<? $list->pos='left'; ?>
				<? for ($col=1;$col<6;$col++) { ?>
				<? if ((isset($list->banShablon['left'.$col]))AND($list->banShablon['left'.$col]!='')) { echo '<div class="content--left__deliver">'.$list->banShablon['left'.$col].'</div>'; } ?>
				<? if ((isset($list->sitShablon['left'.$col]['funcName']))AND($list->sitShablon['left'.$col]['funcName']!='')) { ?>
				<div class="content--left__deliver">
				<? if ((isset($list->sitShablon['left'.$col]['funcName']))AND(strpos($list->sitShablon['left'.$col]['funcName'],'my_')!==FALSE)) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->sitShablon['left'.$col]['funcName']) { echo $one['text'.Langtext]; } endforeach; 
				} else { if ((isset($list->sitShablon['left'.$col]['funcName']))AND($list->sitShablon['left'.$col]['funcName']!='')) { echo view ('functions/'.$list->sitShablon['left'.$col]['funcName'],(array)$list,$list->sitShablon['left'.$col]['advancedData']); } } ?>
				</div>
				<? } } ?>
				<? if ((isset($list->banShablon['left6']))AND($list->banShablon['left6']!='')) { echo '<div class="content--left__deliver">'.$list->banShablon['left6'].'</div>'; } ?>
				<!---->
			</div>
		</section>
		<? } ?>
		<!---->
		<!--Ценральная колонка-->
		<section class="content--center--inner__center">
			<div class="content--center--inner--center__column">
				<!--Хлебные крошки-->
				<? echo view ('functions/templateBreads',(array)$list,array('pageName'=>$list->confLang['error404'])); ?>
				<!---->
				<!--Загрузка модулей конструктора страницы для центральной страницы колонки-->
				<? for ($col=1;$col<5;$col++) { ?>
				<? if (($col==1)OR($col==3)) { echo '<div class="content--center__separator content--center--separator__'.$col.'">'; } ?>
				<? if (((isset($list->sitShablon['center'.$col]['funcName']))AND($list->sitShablon['center'.$col]['funcName']!=''))OR((isset($list->banShablon['centerin'.$col]))AND($list->banShablon['centerin'.$col]!=''))) { ?>
				<div class="content--center__deliver content--center--deliver__<? echo $col; ?>">
					<? if ((isset($list->sitShablon['center'.$col]['funcName']))AND(strpos($list->sitShablon['center'.$col]['funcName'],'my_')!==FALSE)) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->sitShablon['center'.$col]['funcName']) { echo $one['text'.Langtext]; } endforeach;
					} else { if ((isset($list->sitShablon['center'.$col]['funcName']))AND($list->sitShablon['center'.$col]['funcName']!='')) { echo view ('functions/'.$list->sitShablon['center'.$col]['funcName'],(array)$list,$list->sitShablon['center'.$col]['advancedData']); } }
					if (isset($list->banShablon['centerin'.$col])) { echo $list->banShablon['centerin'.$col]; }
					?>
				</div>
				<? } ?>
				<? if (($col==2)OR($col==4)) { echo '</div>'; } ?>
				<? if ($col==2) { if ((isset($list->banShablon['center1']))AND($list->banShablon['center1']!='')) { echo '<div class="content--center__deliver">'.$list->banShablon['center1'].'</div>'; } } ?>
				<? } ?>	
				<!---->
				<!--Основной контент страницы-->
				<section class="error404--center--page">
					<?=$list->confLang['page404']; ?>
				</section>
				<!---->
				<!--Загрузка модулей конструктора страницы для центральной страницы колонки-->
				<? for ($col=5;$col<9;$col++) { ?>
				<? if (($col==5)OR($col==7)) { echo '<div class="content--center__separator content--center--separator--'.$col.'">'; } ?>
				<? if (((isset($list->sitShablon['center'.$col]['funcName']))AND($list->sitShablon['center'.$col]['funcName']!=''))OR((isset($list->banShablon['centerin'.$col]))AND($list->banShablon['centerin'.$col]!=''))) { ?>
				<div class="content--center__deliver content--center--deliver__<? echo $col; ?>">
					<? if ((isset($list->sitShablon['center'.$col]['funcName']))AND(strpos($list->sitShablon['center'.$col]['funcName'],'my_')!==FALSE)) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->sitShablon['center'.$col]['funcName']) { echo $one['text'.Langtext]; } endforeach;
					} else { if ((isset($list->sitShablon['center'.$col]['funcName']))AND($list->sitShablon['center'.$col]['funcName']!='')) { echo view ('functions/'.$list->sitShablon['center'.$col]['funcName'],(array)$list,$list->sitShablon['center'.$col]['advancedData']); } }
					if (isset($list->banShablon['centerin'.$col])) { echo $list->banShablon['centerin'.$col]; }
					?>
				</div>
				<? } ?>
				<? if (($col==6)OR($col==8)) { echo '</div>'; } ?>
				<? if ($col==6) { if ((isset($list->banShablon['center2']))AND($list->banShablon['center2']!='')) { echo '<div class="content--center__deliver">'.$list->banShablon['center2'].'</div>'; } } ?>
				<? } ?>	
				<!---->
			</div>
		</section>
		<!---->
		<!--Правая колонка-->
		<? if ((isset($list->sitShablon['rightcolumn']['funcName']))AND($list->sitShablon['rightcolumn']['funcName']=='yes')) { ?>
		<section class="content--center--inner__right">
			<div class="content--center--inner--right__column">
				<? $list->pos='right'; ?>
				<? for ($col=1;$col<6;$col++) { ?>
				<? if ((isset($list->banShablon['right'.$col]))AND($list->banShablon['right'.$col]!='')) { echo '<div class="content--right__deliver">'.$list->banShablon['right'.$col].'</div>'; } ?>
				<? if ((isset($list->sitShablon['right'.$col]['funcName']))AND($list->sitShablon['right'.$col]['funcName']!='')) { ?>
				<div class="content--right__deliver">
				<? if ((isset($list->sitShablon['right'.$col]['funcName']))AND(strpos($list->sitShablon['right'.$col]['funcName'],'my_')!==FALSE)) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->sitShablon['right'.$col]['funcName']) { echo $one['text'.Langtext]; } endforeach; 
				} else { if ((isset($list->sitShablon['right'.$col]['funcName']))AND($list->sitShablon['right'.$col]['funcName']!='')) { echo view ('functions/'.$list->sitShablon['right'.$col]['funcName'],(array)$list,$list->sitShablon['right'.$col]['advancedData']); } } ?>
				</div>
				<? } } ?>
				<? if ((isset($list->banShablon['right6']))AND($list->banShablon['right6']!='')) { echo '<div class="content--right__deliver">'.$list->banShablon['right6'].'</div>'; } ?>
			</div>
		</section>
		<? } ?>
		<!--Левая колонка-->
	</div>
</section>
<!---->
<? if ((isset($list->banShablon['footer']))AND($list->banShablon['footer']!='')) { echo '<div class="content--footer--deliver">'.$list->banShablon['footer'].'</div>'; } ?>