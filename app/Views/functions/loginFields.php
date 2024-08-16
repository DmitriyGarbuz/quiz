<section class="fnc--login--fields">
<? if (session('userLogined')!='ok') { ?>
	<div class="fnc--login--fields--container">
		<div class="fnc--login--fields__main">
			<div class="fnc--login--fields__field">
				<input type="text" class="js__login--email" placeholder="Email">
			</div>
			<div class="fnc--login--fields__field">
				<input type="password" class="js__login--password" placeholder="<? echo $list->confLang['password']; ?>">
			</div>
		</div>
		<div class="fnc--login--fields__buttons">
			<div class="fnc--login--fields__button">
				<button type="button" class="js__login--button"><? echo $list->confLang['logIn']; ?></button>
			</div>
			<div class="fnc--login--fields__button">
				<button type="button" onClick="location='/<? echo session('Langlink'); ?>registration'"><? echo $list->confLang['signIn']; ?></button>
			</div>
		</div>
		<div class="text--fail js__login--info">
				
		</div>
		<? if (($list->confSet['vkAuth']==1)OR($list->confSet['fbAuth']==1)OR($list->confSet['ggAuth']==1)) { ?>
		<div class="fnc--login--fields__social">
			<? echo $list->confLang['authorizationThroughSocial']; ?>
		</div>
		<div class="fnc--login--fields--social__buttons">
			<? if ($list->confSet['fbAuth']==1) { ?>
			<div class="fnc--login--fields--social__button button--facebook">
				<button type="button" onClick="location='https://www.facebook.com/dialog/oauth?client_id=<? echo $list->confSet['fbAppId']; ?>&scope=email&redirect_uri=<? echo base_url(); ?><? echo session('Langlink'); ?>auth/facebook'">Facebook</button>
			</div>
			<? } ?>
			<? if ($list->confSet['ggAuth']==1) { ?>
			<div class="fnc--login--fields--social__button button--google">
				<button type="button" onClick="location='https://accounts.google.com/o/oauth2/auth?redirect_uri=<? echo base_url(); ?><? echo session('Langlink'); ?>auth%2Fgoogle&response_type=code&client_id=<? echo $list->confSet['ggAppId']; ?>&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile'">Google</button>
			</div>
			<? } ?>
			<? if ($list->confSet['vkAuth']==1) { ?>
			<div class="fnc--login--fields--social__button button--vkontakte">
				<button type="button" onClick="location='https://oauth.vk.com/authorize?client_id=<? echo $list->confSet['vkAppId']; ?>&redirect_uri=<? echo base_url(); ?><? echo session('Langlink'); ?>auth/vkontakte&scope=12&display=wap'">VKontakte</button>
			</div>
			<? } ?>
		</div>
		<? } ?>
		<div class="fnc--login--fields__forgot">
			<span class="js__forgot--button"><? echo $list->confLang['forgotPassword']; ?></span>
		</div>
	</div>
	<? } else { ?>
	<div class="fnc--login--fields--container">
		<div class="fnc--login--fields__title">
			<? echo $list->confLang['welcome']; ?>, <? echo session('userFio'); ?>!
		</div>
		<div class="fnc--login--fields__buttons">
			<div class="fnc--login--fields__button">
				<button type="button" onClick="location='/<? echo session('Langlink'); ?>account'"><? echo $list->confLang['toCabinet']; ?></button>
			</div>
			<div class="fnc--login--fields__button">
				<button type="button" class="js__logout--button"><? echo $list->confLang['logOut']; ?></button>
			</div>
		</div>
	</div>
	<? } ?>
</section>