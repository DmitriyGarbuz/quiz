<section class="center--block">
	<? if (($list->inPage!='shablon')AND($list->inPage!='false')) { ?>
	<section class="center--block__left">
		<? echo view('/controler/newevents'); ?>
		<? if (($list->inPage!='shablon')AND($list->inPage!='false')) { ?>
		<div>
			<div class="border-top-color">
				<div onClick="location='/controler/design/index/default'" <? if ($list->inPage=='default') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/design/index/default"><? echo Available_templates; ?></a>
				</div>
				<div onClick="location='/controler/design/index/addtheme'" <? if ($list->inPage=='addtheme') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/design/index/addtheme"><? echo Create_template; ?></a>
				</div>
				<div onClick="location='/controler/design/index/shablon/chapters'" <? if (($list->inPage=='shablon')AND($list->setup['id']=='chapters')) { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/design/index/shablon/chapters"><? echo Chapters; ?></a>
				</div>
				<div onClick="location='/controler/design/index/shablon/notes'" <? if (($list->inPage=='shablon')AND($list->setup['id']=='notes')) { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/design/index/shablon/notes"><? echo Notes; ?></a>
				</div>
				<div onClick="location='/controler/design/index/shablon/search'" <? if (($list->inPage=='shablon')AND($list->setup['id']=='search')) { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/design/index/shablon/search"><? echo Search; ?></a>
				</div>
				<div onClick="location='/controler/design/index/shablon/registration'" <? if (($list->inPage=='shablon')AND($list->setup['id']=='registration')) { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/design/index/shablon/registration"><? echo Registration; ?></a>
				</div>
				<div onClick="location='/controler/design/index/shablon/account'" <? if (($list->inPage=='shablon')AND($list->setup['id']=='account')) { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/design/index/shablon/account"><? echo Account; ?></a>
				</div>
				<div onClick="location='/controler/design/index/shablon/page404'" <? if (($list->inPage=='shablon')AND($list->setup['id']=='page404')) { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/design/index/shablon/page404"><? echo Page404; ?></a>
				</div>
			</div>
		</div>
		<? } ?>
	</section>
	<? } ?>

	<section class="center--block__right" <? if (($list->inPage=='shablon')OR($list->inPage=='false')) { ?>style="flex-basis: 100%;"<? } ?>>

		<? if ($list->inPage=='false') { ?>
		<div class="false--admin">
			<? echo You_do_not_have_permission_to_access_this_section; ?>
		</div>
		<? } else { ?>
		
		<div class="under--tabs--pole">
			<div >
				<div class="in--center--name">
					<? if ($list->inPage=='default') { echo Templates; } ?>
					<? if ($list->inPage=='addtheme') { echo Create_new_template; } ?>
					<? if ($list->inPage=='shablon') { echo Scheme.' > ';
					if ($list->setup['id']=='chapters') { echo Chapters; } 
					if ($list->setup['id']=='page404') { echo Page404; } 
					if ($list->setup['id']=='registration') { echo Registration; } 
					if ($list->setup['id']=='account') { echo Account; } 
					if ($list->setup['id']=='search') { echo Search; } 
					if ($list->setup['id']=='notes') { echo Notes; } 
					} ?>
					<? if ($list->inPage=='backcall') { echo Communication_forms; } ?>
					<? if ($list->inPage=='editbackcall') { echo Communication_forms; echo ' > ';  echo $list_backcallid['name']; } ?>
					<? if ($list->inPage=='poll') { echo Polls; } ?>
					<? if ($list->inPage=='editpoll') { echo Polls; echo ' > ';  echo $list_pollid['name']; } ?>
					<? if ($list->inPage=='comments') { echo Reviews_settings; } ?>
					<? if ($list->inPage=='connects') { echo Calls_FAQ_Comm_Audio; } ?>
					<? if ($list->inPage=='users') { echo Users_settings; } ?>
					<? if ($list->inPage=='usertabs') { echo Users_tabs; } ?>
					<? if ($list->inPage=='auth') { echo Log_in_social_networks; } ?>
					<? if ($list->inPage=='letters') { echo Templates_of_letters; } ?>
					<? if ($list->inPage=='footer') { echo Site_basement; } ?>
					<? if ($list->inPage=='header') { echo Site_header; } ?>
					<? if ($list->inPage=='sms') { echo SMS_settings; } ?>
					<? if ($list->inPage=='sitemap') { echo Sitemap; } ?>
					<? if ($list->inPage=='counters') { echo Counters; } ?>
					<? if ($list->inPage=='head') { echo 'HEAD'; } ?>
				</div>
			</div>
		</div>
		
		<div class="under--center--pole">
			<div class="in--shadow--block--11">
			
				<? if ($list->inPage=='default') { ?>
				<div class="data--table">
					<form method="post" action="/controler/design/selectTheme">
					<div class="table--all">
						<div class="cell--name">
							<? echo Available_templates; ?>
						</div>
						<div class="cell--param">
							<select name="theme" style="font-size:14px;">
								<? foreach ($list->themes as $one): ?>
								<option value="<? echo trim($one['1']); ?>" <? if (trim($list->confSet['themeid'])==trim($one['1'])) { echo 'selected'; } ?>><? echo trim($one['1']); ?></option>
								<? endforeach; ?>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--full">
							<button><? echo Set; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail" >
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
					<div>
						<textarea spellchecking="false" name="css" class="js__theme--css" rows="46"><? echo file_get_contents ($list->theme); ?></textarea>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__save--css"><? echo Save; ?></button>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full fail js__info1--message" >
							
						</div>
					</div>
				</div>
				<? } ?>
	
				<? if ($list->inPage=='addtheme') { ?>
				<div class="data--table">
					<form method="post" class="js__theme--form" action="/controler/design/addTheme">
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="name" class="js__theme--name">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo File_name; ?> css<br>(<? echo sample; ?>: mytheme)
						</div>
						<div class="cell--param">
							<input type="text" name="file" class="js__theme--file">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Template_author; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="author">
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__theme--button"><? echo Create_template; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail js__info--message">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				<? } ?>
	
				<? if ($list->inPage=='shablon') { ?>
				<? $data = array ('list' => $list); ?>
				<? echo view('/controler/scheme',$data); ?>	
				<? } ?>
	
				
	
			</div>
			
	
		</div>
		<? } ?>
	</section>
</section>

