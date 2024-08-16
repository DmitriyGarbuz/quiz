<section class="fnc--search" >
	<div class="fnc--search__container">
		<div class="fnc--search__inner fnc--search__field">
			<input type="text" autocomplete="off" class="js__search--field" value="<? if (session('searchWord')!='') { echo session('searchWord'); }  ?>" placeholder="<? echo $list->confLang['search']; ?>...">
		</div>
		<div class="fnc--search__inner fnc--search__button">
			<button type="button" class="js__search--button"><? echo $list->confLang['search']; ?></button>
		</div>
	</div>
</section>