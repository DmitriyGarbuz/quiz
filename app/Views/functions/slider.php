<section class="fnc--slider--container" data-freq="<? echo $list->chapter['sliderFreq']; ?>" data-fix="<? echo $list->chapter['sliderFix']; ?>" data-width="<? echo $list->chapter['sliderWidth']; ?>" data-height="<? echo $list->chapter['sliderHeight']; ?>">
	<div class="fnc--slider--inner">
		<div class="fnc--slider--inner__images" >
			<?$i=0; ?>
			<div class="js__fnc--slider--inner__relative" style="height:<? echo $list->chapter['sliderHeight']; ?>px; opacity:0;">
				<div class="js__fnc--slider--inner__absolute">
					<? if (count($options['slider'])>1) { ?>
					<div class="fnc--slider--inner--arrows__left">
						<div class="fnc--slider--inner--arrow__left"><button id="advbanleft" type="button">◄</button></div>
					</div>
					<? } ?>
					<? foreach ($options['slider'] as $one): ?>
						<? if ($one['link'.Langtext]!='') { echo '<a href="'.$one['link'.Langtext].'" target="'.$one['target'].'">'; }?>
						<div class="js__adv--banner__absolute js__adv--banner<? echo $i; ?>" style=" background:url('/<? echo $one['preview']; ?>') 100% 100%; height:<? echo $list->chapter['sliderHeight']; ?>px; background-repeat: no-repeat; background-position:center;  -o-background-size: cover; -webkit-background-size: cover; -moz-background-size: cover; khtml-background-size: cover; background-size: cover; <? if ($i!=0) { echo 'display:none;';} ?>">
						<div class="fnc--slider--inner__text"><? echo $one['text'.Langtext]; ?></div>
						</div>
						<? if ($one['link'.Langtext]!='') { echo '</a>'; } ?>
					<? $i++; ?>
					<? endforeach; ?>
					<? if (count($options['slider'])>1) { ?>
					<div class="fnc--slider--inner--arrows__right">
						<div class="fnc--slider--inner--arrow__right"><button id="advbanright" type="button">►</button></div>
					</div>
					<? } ?>
					<? if (count($options['slider'])>1) { ?>
					<div class="fnc--slider--inner__buttons">
						<div class="fnc--slider--inner--buttons__inner">
							<? $i=1; ?>
							<? foreach ($options['slider'] as $one): ?>
								<div id="slidedivbut<? echo $i-1; ?>" <? if ($i==1) { ?> class="pointerhand fnc--slider--inner--button__active" <?} else { ?>class="pointerhand fnc--slider--inner--button"<? } ?> data-info="<? echo $i; ?>"><? echo $i; ?></div>
							<? $i++; ?>
							<? endforeach; ?>
						</div>
					</div>
					<? } ?>
				</div>
			</div>
		</div>
	</div>
</section>
