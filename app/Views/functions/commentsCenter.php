<?php if (count($options['centComments'])>0) { ?>
<div class="fnc--center--comments">
	<div class="fnc--center--comments__title">
		<? echo $list->confLang['comments']; ?>
	</div>
	<? foreach ($options['centComments'] as $one): ?>
	<div class="fnc--center--comments__listitem">
		<div class="fnc--center--comments--listitem__main">
			<div class="fnc--center--comments--listitem__name">
				<? echo $one['firstName']; ?>
			</div>
			<div class="fnc--center-comments--listitem__date">
				<? echo date('d.m.Y',$one['date']); ?>
			</div>
		</div>
		<div class="fnc--center--comments--listitem__text">
			<? echo $one['text']; ?>
		</div>
	</div>
	<? endforeach; ?>
</div>
<? } ?>