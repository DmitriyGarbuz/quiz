<div class="js__body--background"></div>
<div class="js__body--popup"></div>
<? if ((isset($list->topShablon['highcenter']['funcName']))AND($list->topShablon['highcenter']['funcName']=='slider')) { slider($list,$list->topShablon['highcenter']['advancedData']); } 
if ((isset($list->topShablon['highcenter']['funcName']))AND(strpos($list->topShablon['highcenter']['funcName'],'my_')!==FALSE)) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->topShablon['highcenter']['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach; } ?>
<section class="body">
<section class="header">
	<section class="header--overhead">
		<div class="header--overhead__inner">
			<? if ((isset($list->topShablon['overhead1']['funcName']))AND($list->topShablon['overhead1']['funcName']!='')) { ?>
			<div class="header--overhead--inner__left">
				<? if (strpos($list->topShablon['overhead1']['funcName'],'my_')!==FALSE) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->topShablon['overhead1']['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach;
				} else { echo view ('functions/'.$list->topShablon['overhead1']['funcName'],(array)$list); } ?>
			</div>
			<? } ?>
			<? if ((isset($list->topShablon['overhead2']['funcName']))AND($list->topShablon['overhead2']['funcName']!='')) { ?>
			<div class="header--overhead--inner__right">
				<? if (strpos($list->topShablon['overhead2']['funcName'],'my_')!==FALSE) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->topShablon['overhead2']['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach;
				} else { echo view ('functions/'.$list->topShablon['overhead2']['funcName'],(array)$list); } ?>
			</div>
			<? } ?>
		</div>
	</section>
	<section class="header--centerhead">
		<div class="header--centerhead__inner"> 
			<? if ($list->confSet['bglogo']!='') { ?>
			<div class="header--centerhead--inner__logo">
				<a href="/<? echo Langlink; ?>"><img alt="<? echo $list->confSet['from'.Langtext]; ?>" src="/<? echo $list->confSet['bglogo']; ?>"></a>
				<script type="application/ld+json">
					<? echo $list->confSet['organization'.Langtext]; ?>
				</script>
			</div>
			<? } ?>
			<div class="header--centerhead--inner__column1">
				<? echo $list->confSet['header'.Langtext]; ?>
			</div>
			<div class="header--centerhead--inner__column2">
				<div class="header--centerhead--inner--column2__in1">
					<? if ((isset($list->topShablon['head21']['funcName']))AND($list->topShablon['head21']['funcName']!='')) { 
						if (strpos($list->topShablon['head21']['funcName'],'my_')!==FALSE) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->topShablon['head21']['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach;
						} else { echo view ('functions/'.$list->topShablon['head21']['funcName'],(array)$list); }
					} else { 
						echo $list->confSet['header1'.Langtext]; 
					} ?>
				</div>
				<div class="header--centerhead--inner--column2__in2">
					<? if ((isset($list->topShablon['head22']['funcName']))AND($list->topShablon['head22']['funcName']!='')) { 
						if (strpos($list->topShablon['head22']['funcName'],'my_')!==FALSE) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->topShablon['head22']['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach;
						} else { echo view ('functions/'.$list->topShablon['head22']['funcName'],(array)$list); }
					} else { 
						if ((isset($list->topShablon['head21']['funcName']))AND($list->topShablon['head21']['funcName']!='')) {
							echo $list->confSet['header1'.Langtext]; 
						}
					} ?>
				</div>
			</div>
			<div class="header--centerhead--inner__column3">
				<div class="header--centerhead--inner--column3__in1">
					<? if ((isset($list->topShablon['head31']['funcName']))AND($list->topShablon['head31']['funcName']!='')) { 
						if (strpos($list->topShablon['head31']['funcName'],'my_')!==FALSE) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->topShablon['head31']['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach;
						} else { echo view ('functions/'.$list->topShablon['head31']['funcName'],(array)$list); }
					} else { 
						echo $list->confSet['header2'.Langtext]; 
					} ?>
				</div>
				<div class="header--centerhead--inner--column3__in2">
					<? if ((isset($list->topShablon['head32']['funcName']))AND($list->topShablon['head32']['funcName']!='')) { 
						if (strpos($list->topShablon['head32']['funcName'],'my_')!==FALSE) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->topShablon['head32']['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach;
						} else { echo view ('functions/'.$list->topShablon['head32']['funcName'],(array)$list); }
					} else { 
						if ((isset($list->topShablon['head31']['funcName']))AND($list->topShablon['head31']['funcName']!='')) {
							echo $list->confSet['header2'.Langtext]; 
						}
					} ?>
				</div>
			</div>
		</div>
	</section>
	<section class="header--underhead"> 
		<div class="header--underhead__inner">
			<? if ((isset($list->topShablon['underhead1']['funcName']))AND($list->topShablon['underhead1']['funcName']!='')) { ?>
			<div class="header--underhead--inner__left">
				<? if ((isset($list->topShablon['underhead1']['funcName']))AND(strpos($list->topShablon['underhead1']['funcName'],'my_')!==FALSE)) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->topShablon['underhead1']['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach;
				} else { echo view ('functions/'.$list->topShablon['underhead1']['funcName'],(array)$list); } ?>
			</div>
			<? } ?>
			<? if ((isset($list->topShablon['underhead2']['funcName']))AND($list->topShablon['underhead2']['funcName']!='')) { ?>
			<div class="header--underhead--inner__right">
				<? if ((isset($list->topShablon['underhead2']['funcName']))AND(strpos($list->topShablon['underhead2']['funcName'],'my_')!==FALSE)) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->topShablon['underhead2']['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach;
				} else { echo view ('functions/'.$list->topShablon['underhead2']['funcName'],(array)$list); } ?>
			</div>
			<? } ?>
		</div>
	</section>
</section>