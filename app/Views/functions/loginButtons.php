<div class="fnc--login--buttons">
<? if (session('userLogined')!='ok') { ?>
	<div class="fnc--login--buttons__container">
		<div class="fnc--login--buttons__inner fnc--login--buttons__login">
			<button type="button" class="js__login--form--open"><? echo $list->confLang['logIn']; ?></button>
		</div>
		<div class="fnc--login--buttons__inner fnc--login--buttons__signin">
			<button type="button" onClick="location='/<? echo session('Langlink'); ?>registration'"><? echo $list->confLang['signIn']; ?></button>
		</div>
	</div>
<? } else { ?>
	<div class="fnc--login--buttons__container">
		<div class="fnc--login--buttons__inner fnc--login--buttons__cabinet">
			<button type="button" onClick="location='/<? echo session('Langlink'); ?>account'"><? echo $list->confLang['toCabinet']; ?></button>
		</div>
		<div class="fnc--login--buttons__inner fnc--login--buttons__logout">
			<button type="button" class="js__logout--button"><? echo $list->confLang['logOut']; ?></button>
		</div>
	</div>
<? } ?>
</div>	