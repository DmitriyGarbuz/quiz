<div class="fnc--feedback fnc--feedback_<? echo $options['feedback']['class']; ?>">
	<div class="fnc--feedback--container">
		<div class="fnc--feedback__title">
			<? echo $options['feedback']['name'.session('Langtext')]; ?>
		</div>
		<div class="fnc--feedback__second--title">
			<? echo $options['feedback']['secondName'.session('Langtext')]; ?>
		</div>
		<div class="fnc--feedback--main">
			<? foreach ($options['feedbackParams'] as $one): ?>
			<div class="fnc--feedback--main__line">
				<div class="fnc--feedback--main__name" <? if ($one['need']==1) { echo 'data-need="1"'; } ?>>
					<? if ($one['type']=='checkbox') { ?>
						<input class="js__feedback--param<? echo $options['feedback']['feedbackId']; ?>" value="1" data-id="<? echo $one['feedbackParamId']; ?>" type="checkbox">
					<? } ?> 
					<? echo $one['name'.session('Langtext')]; ?> 
					<? if ($one['type']=='file') { echo '('.$list->confLang['accessFormats'].': '.$one['text'].')'; } ?> 
					<? if ($one['need']==1) { echo '<span class="star">*</span>'; } ?> 
				</div>
				<div class="fnc--feedback--main__param" <? if ($one['need']==1) { echo 'data-need="1"'; } ?>>
					<? if ($one['type']=='text') { ?>
						<input <? if ($one['maxlength']>0) { ?>maxlength="<? echo $one['maxlength']; ?>"<? } ?> class="js__feedback--param<? echo $options['feedback']['feedbackId']; ?>-<? echo $one['feedbackParamId']; ?>" data-id="<? echo $one['feedbackParamId']; ?>" placeholder="<? echo $one['name'.session('Langtext')]; ?>" type="text">
						<? } ?>
					<? if ($one['type']=='data1') { ?>
						<input <? if ($one['maxlength']>0) { ?>maxlength="<? echo $one['maxlength']; ?>"<? } ?> class="js__feedback--param<? echo $options['feedback']['feedbackId']; ?>-<? echo $one['feedbackParamId']; ?>" data-id="<? echo $one['feedbackParamId']; ?>" placeholder="<? echo $one['name'.session('Langtext')]; ?>" type="datetime-local">
					<? } ?>
					<? if ($one['type']=='number') { ?>
						<input <? if ($one['maxlength']>0) { ?>maxlength="<? echo $one['maxlength']; ?>"<? } ?> class="js__feedback--param<? echo $options['feedback']['feedbackId']; ?>-<? echo $one['feedbackParamId']; ?>" data-id="<? echo $one['feedbackParamId']; ?>" placeholder="<? echo $one['name'.session('Langtext')]; ?>" type="number">
					<? } ?>
					<? if ($one['type']=='phone') { ?>
						<script type="text/javascript">$(function(){$( ".js__feedback--param<? echo $options['feedback']['feedbackId']; ?>-<? echo $one['feedbackParamId']; ?>" ).inputmask();});</script>
						<input class="js__feedback--param<? echo $options['feedback']['feedbackId']; ?>-<? echo $one['feedbackParamId']; ?>" data-inputmask="'alias': 'phone'" data-id="<? echo $one['feedbackParamId']; ?>" placeholder="<? echo $one['name'.session('Langtext')]; ?>" type="text">
					<? } ?>
					<? if ($one['type']=='data') { ?>
						<script type="text/javascript">$(function() {$( ".js__feedback--param<? echo $options['feedback']['feedbackId']; ?>-<? echo $one['feedbackParamId']; ?>" ).datepicker({ dateFormat: 'dd/mm/yy'});});</script>
						<input type="text" class="js__feedback--param<? echo $options['feedback']['feedbackId']; ?>-<? echo $one['feedbackParamId']; ?>" placeholder="<? echo $one['name'.session('Langtext')]; ?>" data-id="<? echo $one['feedbackParamId']; ?>">
					<? } ?>
					<? if ($one['type']=='radio') {
						$max = mb_substr_count($one['text'.session('Langtext')], ";"); $pos=0;
						for ($i=0;$i<$max;$i++) {$newpos = mb_strpos ($one['text'.session('Langtext')],';',$pos);if ($newpos!=$pos) {$value = mb_substr ($one['text'.session('Langtext')],$pos,$newpos-$pos);} else { $value=0; }$pos = $newpos+1;
						?>
						<div><input class="js__feedback--param<? echo $options['feedback']['feedbackId']; ?>" value="<? echo $value; ?>" data-id="<? echo $one['feedbackParamId']; ?>" name="<? echo $one['feedbackParamId']; ?>" type="radio" <? if ($i==0) { echo 'checked'; } ?>> <? echo $value; ?></div>
						<? } ?>
					<? } ?>
					<? if ($one['type']=='textarea') { ?>
						<textarea class="js__feedback--param<? echo $options['feedback']['feedbackId']; ?>-<? echo $one['feedbackParamId']; ?>" placeholder="<? echo $one['name'.session('Langtext')]; ?>" data-id="<? echo $one['feedbackParamId']; ?>" rows="<? echo $one['text']; ?>"></textarea>
					<? } ?>
					<? if ($one['type']=='vibor') { ?>
						<select class="js__feedback--param<? echo $options['feedback']['feedbackId']; ?>-<? echo $one['feedbackParamId']; ?>" data-id="<? echo $one['feedbackParamId']; ?>">
							<? $max = mb_substr_count($one['text'.session('Langtext')], ";"); $pos=0;
							for ($i=0;$i<$max;$i++) { $newpos = mb_strpos ($one['text'.session('Langtext')],';',$pos); if ($newpos!=$pos) { $value = mb_substr ($one['text'.session('Langtext')],$pos,$newpos-$pos); } else { $value=0; } $pos = $newpos+1; ?>
							<option value="<? echo $value; ?>"><? echo $value; ?></option>
							<? } ?>
						</select>
					<? } ?>
					<? if ($one['type']=='file') { ?>
						<form class="js__feedback--form<? echo $one['feedbackParamId']; ?>" method="post" enctype="multipart/form-data" action='/datawork/addFeedbackFile'>
						<div name="<? echo $one['feedbackParamId']; ?>"><input type="file" name="file[]" multiple data-id="<? echo $one['feedbackParamId']; ?>" class="js__feedback--file<? echo $options['feedback']['feedbackId']; ?>"></div>
						<input type="hidden" name="feedbackParamId" value="<? echo $one['feedbackParamId']; ?>">
						<input type="hidden" name="feedbackId" value="<? echo $options['feedback']['feedbackId']; ?>">
						<input type="hidden" class="js__feedback--file--format<? echo $one['feedbackParamId']; ?>" name="fileformat" value="<? echo $one['text']; ?>">
						</form>
						<div class="textfail" style="display:none;" id="divFeedbackParamFile<? echo $one['feedbackParamId']; ?>"><? echo $list->confLang['deniedFormats']; ?></div>
					<? } ?>
				</div>
			</div>
			<? endforeach; ?>
			<div class="fnc--feedback--main__line">
				<div class="fnc--feedback--main__button">
					<button type="button" class="js__feedback--button" data-id="<? echo $options['feedback']['feedbackId']; ?>"><? echo $list->confLang['send']; ?></button>
				</div>
			</div>
		</div>
	</div>
</div>