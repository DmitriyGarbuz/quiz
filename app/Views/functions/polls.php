<?php if (isset($options['poll']['pollId'])) { ?>
<div class="fnc--polls">
	<div class="fnc--polls__title">
		<? echo $options['poll']['name'.Langtext]; ?>
	</div>
	<div class="fnc--polls__container">
		<? $imax=1; $max=1;?>
		<? foreach ($options['pollParams'] as $one): ?>
		<? if ($one['pollId']==$options['poll']['pollId']) { ?>
		<? if ($imax==1) { if ($one['votes']!=0) { $max = $one['votes'];  } } ?>
		<div class="fnc--polls__main">
			<div class="fnc--polls--main__inner">
				<div class="fnc--polls--main--inner__box">
					<input type="radio" id="js__poll--check<? echo $one['pollParamId']; ?>" data-id="<? echo $one['pollParamId']; ?>" data-poll="<? echo $options['poll']['pollId']; ?>" class="js__poll--check" <? if ($options['countPollVote']>0) { echo 'disabled'; } ?>>
					<label for="js__poll--check<? echo $one['pollParamId']; ?>"></label>
				</div>
				<div class="fnc--polls--main--inner__name">
					<? echo $one['name'.Langtext]; ?> 
				</div>
				<div class="fnc--polls--main--inner__votes">
					<? echo $one['votes']; ?>
				</div>
			</div>
			<div class="fnc--polls--main__line"><div class="fnc--polls--main__linein" style="width:<? echo (100/$max)*$one['votes']; ?>%"></div></div>
		</div>
		<? $imax++; ?>
		<? } ?>
	<? endforeach; ?>
	</div>	
</div>	
<? } ?>