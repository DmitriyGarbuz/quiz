<?php if (count($options['slideComments'])>0) { ?>
<div class="fnc--slider--comments">
	<div class="fnc--slider--comments__title">
		<? echo $list->confLang['comments']; ?>
	</div>
	<div class="fnc--slider--comments--container">
		<? if (isset($options['slideComments'][1])) {?>
		<div class="fnc--slider--comments__left">
			<button type="button" class="js__comment--slider--left">◄</button>
		</div>
		<? } ?>
		<div class="fnc--slider--comments__main js__slider--comment--next" data-info="0">
			<? echo view('functions/commentsOneSlide',array(),$options['slideComments'][0]); ?>
		</div>
		<? if (isset($options['slideComments'][1])) { ?>
		<div class="fnc--slider--comments__right">
			<button type="button" class="js__comment--slider--right">►</button>
		</div>
		<? } ?>
	</div>	
</div>
<? } ?>