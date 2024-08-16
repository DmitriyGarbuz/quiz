<?php if (count($options['colComments'])>0) { ?>	
<div class="fnc--column--comments">
	<div class="fnc--column--comments__title">
		<? echo $list->confLang['comments']; ?>
	</div>
	<div class="fnc--center--comments--container">
		<? foreach ($options['colComments'] as $one): ?>
		<div class="fnc--center--comments--listitem__main">
			<div class="fnc--center--comments--listitem__name">
				<? echo $one['firstName']; ?>
			</div>
			<div class="fnc--center--comments--listitem__text">
				<? echo mb_substr($one['text'],0,100,'UTF-8'); if (mb_strlen($one['text'])>100) { echo "..."; } ?>
			</div>
			<div class="fnc--center--comments--listitem__date">
				<? echo date('d.m.Y',$one['date']); ?>
			</div>
		</div>
		<? endforeach; ?>
	</div>
</div>
<? } ?>