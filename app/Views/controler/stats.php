<div id="back1all" style="background:#fff;position:fixed;z-index:400;opacity:0.9;">
<div align="center" style="margin:0 auto; margin-top:150px;"><img style="max-width:150px;" border="0" src="/admin/img/loading.gif"></div>
</div>
<input type="hidden" id="needstatssee" value="1">
<div class="filter--stat--pole js__filter--stat--pole" style="opacity:0;">
	<div>
		<script>
			$(function() {
				$( ".js__date--stat--from" ).datepicker({ 
					dateFormat: 'dd/mm/yy'
				});
			});
		</script>
		<input type="text" class="js__date--stat--from" style="border: 1px solid #eee;" value="<? echo date('d/m/Y',session('dateStatFrom')); ?>">
	</div>
	<div>
		<script>
			$(function() {
				$( ".js__date--stat--to" ).datepicker({ 
					dateFormat: 'dd/mm/yy'
				});
			});
		</script>
		<input type="text" class="js__date--stat--to" style="border: 1px solid #eee;" value="<? echo date('d/m/Y',session('dateStatTo')); ?>">
	</div>
	<div >
		<select class="js__stat--graph--view" style="border: 1px solid #eee;">
			<option value="0" <? if (session('statstat')==0) { echo 'selected'; } ?>><? echo StatGraph1; ?></option>
			<option value="1" <? if (session('statstat')==1) { echo 'selected'; } ?>><? echo StatGraph2; ?></option>
			<option value="2" <? if (session('statstat')==2) { echo 'selected'; } ?>><? echo StatGraph3; ?></option>
			<option value="3" <? if (session('statstat')==3) { echo 'selected'; } ?>><? echo StatGraph4; ?></option>
			<option value="4" <? if (session('statstat')==4) { echo 'selected'; } ?>><? echo StatGraph5; ?></option>
		</select>
	</div>
	<div>
		<button type="button" class="js__see--new--stats"><? echo Update; ?></button>
	</div>
</div>
<div class="js__info--if--not--isset">
	<div class="js__svg--graph--pole" style="text-align: center;">

	</div>
	<div class="js__table--stat--pole">
	
	</div>
</div>

