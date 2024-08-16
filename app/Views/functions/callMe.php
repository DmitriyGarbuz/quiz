<div class="popup--callme--container">
	<div class="popup--container__main">
		<div class="popup--container__close">
			<button type="button" class="js__close--popup">x</button>
		</div>
		<div class="popup--container__title"><?=$list->confLang['fillRequestedFields']; ?></div>
		<div class="popup--container__line">
			<div class="popup--container--line__inner">
				<input type="text" class="js__order--call--firstname" value="" placeholder="<?=$list->confLang['firstName']; ?>">
			</div>
		</div>
		<div class="popup--container__line">
			<div class="popup--container--line__inner">
				<script type="text/javascript">
					$(function(){$( ".js__order--call--telnumber" ).inputmask();});
				</script>
				<input type="text" class="js__order--call--telnumber" data-inputmask="'alias': 'phone'" value="" placeholder="<?=$list->confLang['phone']; ?>">
			</div>
		</div>
		<div class="popup--container__line">
			<div class="popup--container--line__inner">
				<textarea class="js__order--call--text" rows="5" placeholder="<?=$list->confLang['additionalInformation']; ?>"></textarea>
			</div>
		</div>
		<div class="popup--container__button">
			<button type="button" class="js__popup--order--call--button"><?=$list->confLang['requestCall']; ?></button>
		</div>
	</div>
</div>