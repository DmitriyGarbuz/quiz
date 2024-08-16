<div class="fnc--login--popup--container">
	<div class="popup--container__close">
		<button type="button" class="js__close--popup">x</button>
	</div>
	<section class="fnc--forgot--fields">
		<div class="fnc--forgot--container">
			<div class="fnc--forgot__main">
				<div class="fnc--forgot--main__title">
					<? echo $list->confLang['enterYourEmail']; ?>
				</div>
				<div class="fnc--forgot--main__line">
					<input type="text" class="js__forgot--email" placeholder="Email" value="">
				</div>
				<div class="fnc--forgot--main__button">
					<button type="button" class="js__forgot--button"><? echo $list->confLang['send']; ?></button>
				</div>
				<div class="text--fail js__forgot--info">
						
				</div>
			</div>
		</div>
	</section>
</div>