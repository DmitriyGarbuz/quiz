<!--Контент страницы-->
<? if ((isset($list->banShablon['header']))AND($list->banShablon['header']!='')) { echo '<div class="deliver">'.$list->banShablon['header'].'</div>'; } ?>
<section class="content--center--main account">
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
				<? echo view ('functions/templateBreads',(array)$list,array('pageName'=>$list->confLang['account'])); ?>
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
				<section class="account--center--page">
					<div class="account--info--row">
						<div class="account--info--row__welcome"><? echo $list->confLang['welcome']; ?>, <? echo $list->user['fio']; ?>!</div>
					</div>
					<? if (count($list->userTabs)>0) { ?>
					<? $i=0; ?>
					<div class="account--tabs">
						<? foreach ($list->userTabs as $one): ?>
						<div class="account--tabs__position">
							<div data-tab="<? echo $one['userTabId']; ?>" <? if ($one['userTabId']!=session('activeAccountTab')) { echo 'class="js__account--button--tab account--tab"'; } else { echo 'class="js__account--button--tab account--tab__active"'; } ?>><? echo $one['name'.Langtext]; ?></div>
						</div>
						<? $i++; ?>
						<? endforeach; ?>
					</div>
					<? $i=0; ?>
					<? foreach ($list->userTabs as $tab): ?>
					<div class="account--tabs__inner js__account--window--tab" data-tab="<? echo $tab['userTabId']; ?>" <? if ($tab['userTabId']!=session('activeAccountTab')) { echo 'style="display:none;"'; } ?>> 
						<? if ($tab['type']==0) { foreach ($list->userTabData as $two): if ($tab['userTabId']==$two['userTabId']) { echo $two['text'.Langtext]; } endforeach; } ?>
						<? if ($tab['type']==1) { ?>
						<div class="account--tabs__columns">
							<div class="account--tabs---column__left">
								<div class="account--tabs--column__title"><? echo $list->confLang['personalData']; ?></div>
								<? if ($list->confSet['needAvatar']==1) { ?>
								<div class="account--main__line">															
									<div class="account--main__name">		
										<? echo $list->confLang['avatar']; ?>
									</div>
									<div class="account--main__param">		
										<div class="js__user--avatar--container"><? if ($list->user['preview']!='') { ?><img border="0" src="<? echo $list->user['preview']; ?>"><? } ?></div>
										<form class="js__edit--user--preview" method="post" enctype="multipart/form-data" action='/datawork/editPreviewUser'>
											<input class="js__edit--preview--user" type="file" name="userfile">
										</form>
									</div>
								</div>
								<? } ?>
								<? foreach ($list->userParams as $one): ?>
								<div class="account--main__line">															
									<div class="account--main__name">		
										<? if ($one['type']=='checkbox') {  ?><input class="js__user--data--param" id="js__user--data--param" value="1" data-id="<? echo $one['userParamId']; ?>" type="checkbox" <? foreach ($list->userData as $two): if (($two['userparam_id']==$one['userParamId'])AND($two['code']==$list->user['code'])) { if ($two['text']=='1') { echo ' checked '; } } endforeach; ?>><? } ?> <? echo $one['name'.Langtext]; if ($one['need']==1) { echo '<span class="star">*</span>'; }  ?>
									</div>
									<div class="account--main__param" <? if ($one['need']==1) { echo 'data-need="1"'; } ?>>	
										<? if ($one['type']=='fio') { ?>
											<input type="text" class="js__user--data--fio" placeholder="<? echo $one['name'.Langtext]; ?>" value="<? echo $list->user['fio']; ?>">
										<? } ?>
										<? if ($one['type']=='surname') { ?>
											<input type="text" class="js__user--data--surname" placeholder="<? echo $one['name'.Langtext]; ?>" value="<? echo $list->user['surname']; ?>">
										<? } ?>
										<? if ($one['type']=='phone') { ?>
											<script type="text/javascript">$(function() {$( "#js__user--data--phone<? echo $one['userParamId']; ?>" ).inputmask();});</script>
											<input type="text" class="js__user--data--phone" id="js__user--data--phone<? echo $one['userParamId']; ?>" data-inputmask="'alias': 'phone'" placeholder="<? echo $one['name'.Langtext]; ?>" value="<? echo $list->user['phone']; ?>">
										<? } ?>
										<? if ($one['type']=='phoneext') {  ?>
											<script type="text/javascript">$(function() {	$( ".js__user--data--param<? echo $one['userParamId']; ?>" ).inputmask();});</script>
											<input class="js__user--data--param<? echo $one['userParamId']; ?>" data-id="<? echo $one['userParamId']; ?>" data-inputmask="'alias': 'phone'" placeholder="<? echo $one['name'.Langtext]; ?>" type="text" <? foreach ($list->userData as $two): if (($two['userParamId']==$one['userParamId'])AND($two['code']==$list->user['code'])) { echo 'value="'.$two['text'].'"'; } endforeach; ?>>
										<? } ?>
										<? if ($one['type']=='date') { ?>
											<script type="text/javascript">$(function() {$( ".js__user--data--param<? echo $one['userParamId']; ?>" ).datepicker({ dateFormat: 'dd/mm/yy'});});</script>
											<input class="js__user--data--param<? echo $one['userParamId']; ?>" placeholder="<? echo $one['name'.Langtext]; ?>" data-id="<? echo $one['userParamId']; ?>" type="text" <? foreach ($list->userData as $two): if (($two['userParamId']==$one['userParamId'])AND($two['code']==$list->user['code'])) { echo 'value="'.$two['text'].'"'; } endforeach; ?>>
										<? } ?>
										<? if ($one['type']=='text') {  ?>
											<input class="js__user--data--param<? echo $one['userParamId']; ?>" data-id="<? echo $one['userParamId']; ?>" placeholder="<? echo $one['name'.Langtext]; ?>" type="text" <? foreach ($list->userData as $two): if (($two['userParamId']==$one['userParamId'])AND($two['code']==$list->user['code'])) { echo 'value="'.$two['text'].'"'; } endforeach; ?>>
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
											<div><input class="js__user--data--param<? echo $one['userParamId']; ?>" value="<? echo $value; ?>" data-id="<? echo $one['userParamId']; ?>" name="<? echo $one['userParamId']; ?>" type="radio" <? foreach ($list->userData as $two): if (($two['userParamId']==$one['userParamId'])AND($two['code']==$list->user['code'])AND($two['text']==$value)) { echo 'checked'; } endforeach; ?>> <? echo $value; ?></div>
											<? } ?>
										<? } ?>
										<? if ($one['type']=='textarea') {  ?>
											<textarea class="js__user--data--param<? echo $one['userParamId']; ?>" data-id="<? echo $one['userParamId']; ?>" placeholder="<? echo $one['name'.Langtext]; ?>" rows="<? echo $one['text']; ?>"><? foreach ($list->userData as $two): if (($two['userParamId']==$one['userParamId'])AND($two['code']==$list->user['code'])) { echo str_replace('<br>','',$two['text']); } endforeach; ?></textarea>
										<? }
										if ($one['type']=='vibor') { ?>
											<select class="js__user--data--param" data-id="<? echo $one['userParamId']; ?>">
											<? $pos=0;
											$max = substr_count($one['text'.Langtext], ";"); 
											for ($i=0;$i<$max;$i++) {
												$newpos = strpos ($one['text'.Langtext],';',$pos);
												if ($newpos!=$pos) {
												$value = substr ($one['text'.Langtext],$pos,$newpos-$pos);
												} else { $value=0; }
												$pos = $newpos+1;
											echo '<option value="'.$value.'" '; foreach ($list->userData as $two): if (($two['userParamId']==$one['userParamId'])AND($two['code']==$list->user['code'])AND($two['text']==$value)) { echo 'selected'; } endforeach; echo '>'.$value.'</option>';
											} ?>
											</select>
										<? } ?>
									</div>
								</div>
								<? endforeach; ?>
								<div class="account--main__button"><button type="button" class="js__user--data--button"><? echo $list->confLang['save']; ?></button></div>
								<div class="textfail js__user--data--info"></div>
							</div>
							<div class="account--tabs---column__right">
								<div class="account--tabs--column__title"><? echo $list->confLang['authorizationData']; ?></div>
								<div class="account--main__line">															
									<div class="account--main__name">		
										Email (<? echo $list->confLang['loginSmall']; ?>) <span class="star">*</span>
									</div>
									<div class="account--main__param">			
										<input type="text" class="js__user--main--email" placeholder="Email" value="<? echo $list->user['email']; ?>">
									</div>
								</div>
								<div class="account--main__line">															
									<div class="account--main__name">			
										<? echo $list->confLang['oldPassword']; ?> <span class="star">*</span>
									</div>
									<div class="account--main__param">			
										<input type="password" placeholder="<? echo $list->confLang['oldPassword']; ?>" class="js__user--main--oldpassword">
									</div>
								</div>
								<div class="account--main__line">															
									<div class="account--main__name">		
										<? echo $list->confLang['newPassword']; ?> <span class="star">*</span>
									</div>
									<div class="account--main__param">			
										<input type="password" placeholder="<? echo $list->confLang['newPassword']; ?>" class="js__user--main--password">
									</div>
								</div>
								<div class="account--main__line">															
									<div class="account--main__name">		
										<? echo $list->confLang['repeatPassword']; ?> <span class="star">*</span>
									</div>
									<div class="account--main__param">			
										<input type="password" placeholder="<? echo $list->confLang['repeatPassword']; ?>" class="js__user--main--repassword">
									</div>
								</div>
								<div class="account--main__button">			
									<button type="button" class="js__user--main--button"><? echo $list->confLang['save']; ?></button>
								</div>
								<div class="textfail js__user--main--info"></div>
							</div>
						</div>
						<? } ?>
					</div>
					<? $i++; ?>
					<? endforeach; ?>
					<? } ?>
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