<!--Контент страницы-->
<? if ((isset($list->banShablon['header']))AND($list->banShablon['header']!='')) { echo '<div class="deliver">'.$list->banShablon['header'].'</div>'; } ?>
<section class="content--center--main registration">
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
				<? if ((isset($list->sitShablon['left'.$col]['funcName']))AND(strpos($list->sitShablon['left'.$col]['funcName'],'my_')!==FALSE)) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->sitShablon['left'.$col]['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach; 
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
				<? echo view ('functions/templateBreads',(array)$list,array('pageName'=>$list->confLang['registration'])); ?>
				<!---->
				<!--Загрузка модулей конструктора страницы для центральной страницы колонки-->
				<? for ($col=1;$col<5;$col++) { ?>
				<? if (($col==1)OR($col==3)) { echo '<div class="content--center__separator content--center--separator__'.$col.'">'; } ?>
				<? if (((isset($list->sitShablon['center'.$col]['funcName']))AND($list->sitShablon['center'.$col]['funcName']!=''))OR((isset($list->banShablon['centerin'.$col]))AND($list->banShablon['centerin'.$col]!=''))) { ?>
				<div class="content--center__deliver content--center--deliver__<? echo $col; ?>">
					<? if ((isset($list->sitShablon['center'.$col]['funcName']))AND(strpos($list->sitShablon['center'.$col]['funcName'],'my_')!==FALSE)) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->sitShablon['center'.$col]['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach;
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
				<section class="registration--center--page">
					<? if (($list->inPage=='registration')OR($list->inPage=='')) { ?>
					<div class="registration--main">
						<div class="js__registration--page--content">
							<div class="registration--main__title"><? echo $list->confLang['registrationData']; ?></div>
							<div class="registration--main__inner">
								<? foreach ($list->userParams as $one): ?>
								<div class="registration--main__line">
									<div class="registration--main__name">		
										<? if ($one['type']=='checkbox') { ?><input id="js__registration--user--param<? echo $one['userParamId']; ?>" class="js__registration--user--param" value="1" name="<? echo $one['userParamId']; ?>" type="checkbox"><? } ?> <? echo $one['name'.Langtext]; ?> <? if ($one['need']==1) { echo '<span class="star">*</span>'; } ?>
									</div>
									<div class="registration--main__param" <? if ($one['need']==1) { echo 'data-need="1"'; } ?>>
										<? if ($one['type']=='fio') { ?>
											<input type="text" class="js__registration--fio" placeholder="<? echo $one['name'.Langtext]; ?>">
										<? } ?>
										<? if ($one['type']=='surname') { ?>
											<input type="text" class="js__registration--surname" placeholder="<? echo $one['name'.Langtext]; ?>" >
										<? } ?>
										<? if ($one['type']=='phone') { ?>
											<script type="text/javascript">$(function() {$( "#js__registration--phone<? echo $one['userParamId']; ?>" ).inputmask();});</script>
											<input type="text" class="js__registration--phone" id="js__registration--phone<? echo $one['userParamId']; ?>" data-inputmask="'alias': 'phone'" placeholder="<? echo $one['name'.Langtext]; ?>" >
										<? } ?>
										<? if ($one['type']=='text') { ?>
											<input class="js__registration--user--param<? echo $one['userParamId']; ?>" placeholder="<? echo $one['name'.Langtext]; ?>" data-id="<? echo $one['userParamId']; ?>" type="text">
										<? } ?>
										<? if ($one['type']=='date') { ?>
											<script type="text/javascript">$(function() {$( "#registrationUserParam<? echo $one['userParamId']; ?>" ).datepicker({ dateFormat: 'dd/mm/yy'});});</script>
											<input class="js__registration--user--param<? echo $one['userParamId']; ?>" placeholder="<? echo $one['name'.Langtext]; ?>" data-id="<? echo $one['userParamId']; ?>" type="text">
										<? } ?>
										<? if ($one['type']=='phoneext') { ?>
											<script type="text/javascript">$(function() {$( "#registrationUserParam<? echo $one['userParamId']; ?>" ).inputmask();});</script>
											<input class="js__registration--user--param<? echo $one['userParamId']; ?>" data-inputmask="'alias': 'phone'" placeholder="<? echo $one['name'.Langtext]; ?>" data-id="<? echo $one['userParamId']; ?>" type="text">
										<? } ?>
										<? if ($one['type']=='radio') { ?>
											<?	
											$max = mb_substr_count($one['text'.Langtext], ";"); $pos=0;
											for ($i=0;$i<$max;$i++) {
												$newpos = mb_strpos ($one['text'.Langtext],';',$pos);
												if ($newpos!=$pos) {
												$value = mb_substr ($one['text'.Langtext],$pos,$newpos-$pos);
												} else { $value=0; }
												$pos = $newpos+1;
											?>
											<div><input class="js__registration--user--param<? echo $one['userParamId']; ?>" value="<? echo $value; ?>" data-id="<? echo $one['userParamId']; ?>" type="radio" <? if ($i==0) { echo ' checked '; } ?>> <? echo $value; ?></div>
											<? } ?>
										<? } ?>
										<? if ($one['type']=='textarea') { ?>
											<textarea class="js__registration--user--param<? echo $one['userParamId']; ?>" data-id="<? echo $one['userParamId']; ?>" placeholder="<? echo $one['name'.Langtext]; ?>" rows="<? echo $one['text']; ?>"></textarea>
										<? } ?>
										<? if ($one['type']=='vibor') { ?>
											<select class="js__registration--user--param<? echo $one['userParamId']; ?>" data-id="<? echo $one['userParamId']; ?>">
											<?		
											$pos=0;
											$max = substr_count($one['text'.Langtext], ";"); 
											for ($i=0;$i<$max;$i++) {
												$newpos = strpos ($one['text'.Langtext],';',$pos);
												if ($newpos!=$pos) {
												$value = substr ($one['text'.Langtext],$pos,$newpos-$pos);
												} else { $value=0; }
												$pos = $newpos+1;
											?>
											<option value="<? echo $value; ?>"><? echo $value; ?></option>
											<? } ?>
											</select>
										<? } ?>
									</div>
								</div>
								<? endforeach; ?>
								<div class="registration--main__line">											
									<div class="registration--main__name">		
										Email (<? echo $list->confLang['loginSmall']; ?>) <span class="star">*</span>
									</div>
									<div class="registration--main__param">	
										<input type="text" class="js__registration--email" placeholder="Email">
									</div>									
								</div>
								<div class="registration--main__line">														
									<div class="registration--main__name">		
										<? echo $list->confLang['password']; ?> <span class="star">*</span>
									</div>
									<div class="registration--main__param">		
										<input type="password" class="js__registration--password" placeholder="<? echo $list->confLang['password']; ?>">
									</div>									
								</div>
								<div class="registration--main__line">															
									<div class="registration--main__name">		
										<? echo $list->confLang['repeatPassword']; ?> <span class="star">*</span>
									</div>
									<div class="registration--main__param">	
										<input type="password" class="js__registration--repassword" placeholder="<? echo $list->confLang['repeatPassword']; ?>">
									</div>									
								</div>
								<div class="registration--main__line">							
									<div class="registration--main__button">							
										<button type="button" class="js__registration--button registrationbut"><? echo $list->confLang['signIn']; ?></button>
									</div>									
								</div>
							</div>
						</div>
						<div class="registration--main__line">					
							<div class="text--fail js__registration--info">	
								
							</div>									
						</div>
					</div>
					<? } ?>
					<? if ($list->inPage=='nowactive') { ?><div class="js__registration--page--info"><div><? echo $list->confLang['successfulActivation']; ?></div></div><? } ?>
					<? if ($list->inPage=='alreadyactive') { ?><div class="js__registration--page--info"><div><? echo $list->confLang['alreadyActivated']; ?></div></div><? } ?>
					<? if ($list->inPage=='falsecode') { ?><div class="js__registration--page--info"><div><? echo $list->confLang['activationError']; ?></div></div><? } ?>
				</section>
				<!---->
				<!--Загрузка модулей конструктора страницы для центральной страницы колонки-->
				<? for ($col=5;$col<9;$col++) { ?>
				<? if (($col==5)OR($col==7)) { echo '<div class="content--center__separator content--center--separator--'.$col.'">'; } ?>
				<? if (((isset($list->sitShablon['center'.$col]['funcName']))AND($list->sitShablon['center'.$col]['funcName']!=''))OR((isset($list->banShablon['centerin'.$col]))AND($list->banShablon['centerin'.$col]!=''))) { ?>
				<div class="content--center__deliver content--center--deliver__<? echo $col; ?>">
					<? if ((isset($list->sitShablon['center'.$col]['funcName']))AND(strpos($list->sitShablon['center'.$col]['funcName'],'my_')!==FALSE)) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->sitShablon['center'.$col]['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach;
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
				<? if ((isset($list->sitShablon['right'.$col]['funcName']))AND(strpos($list->sitShablon['right'.$col]['funcName'],'my_')!==FALSE)) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->sitShablon['right'.$col]['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach; 
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