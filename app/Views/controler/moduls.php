<section class="center--block">
	<? if (($list->inPage!='situation')AND($list->inPage!='false')) { ?>
	<section class="center--block__left">
		<? echo view('/controler/newevents'); ?>
		<? if (($list->inPage!='situation')AND($list->inPage!='false')) { ?>
		<div>
			<div class="margin--top--20">
				<div class="add--item--main--block--left" onClick="location='/controler/ctusers'">
					<div class="add--item--main--block--left__in">
						<div>
							<img border="0" src="/admin/img/icons/admin.svg">
						</div>
						<div>
							<a href="/controler/ctusers"><? echo Administrators; ?></a>
						</div>
					</div>
				</div>
			</div>
			<div class="border--top--color">
				<div onClick="location='/controler/moduls/index/header'" <? if ($list->inPage=='header') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/moduls/index/header"><? echo Site_header; ?></a>
				</div>
				<div onClick="location='/controler/moduls/index/footer'" <? if ($list->inPage=='footer') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/moduls/index/footer"><? echo Site_basement; ?></a>
				</div>
				<div onClick="location='/controler/moduls/index/head'" <? if ($list->inPage=='head') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/moduls/index/head">HEAD</a>
				</div>
				<div onClick="location='/controler/moduls/index/organization'" <? if ($list->inPage=='organization') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/moduls/index/organization">Organization</a>
				</div>
				<div onClick="location='/controler/moduls/index/analytics'" <? if ($list->inPage=='analytics') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/moduls/index/analytics"><? echo Analytics; ?></a>
				</div>
				<div onClick="location='/controler/moduls/index/metas'" <? if ($list->inPage=='metas') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/moduls/index/metas"><? echo Metadata; ?></a>
				</div>
				<div onClick="location='/controler/moduls/index/letters'" <? if ($list->inPage=='letters') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/moduls/index/letters"><? echo Templates_of_letters; ?></a>
				</div>
				<div onClick="location='/controler/moduls/index/languages'" <? if (($list->inPage=='languages')OR($list->inPage=='editlanguage')) { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/moduls/index/languages"><? echo Languages; ?></a>
				</div>
				<div onClick="location='/controler/moduls/index/uservars'" <? if ($list->inPage=='uservars') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/moduls/index/uservars"><? echo Users_vars; ?></a>
				</div>
				<div onClick="location='/controler/moduls/index/users'" <? if ($list->inPage=='users') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/moduls/index/users"><? echo Users_settings; ?></a>
				</div>
				<div onClick="location='/controler/moduls/index/usertabs'" <? if ($list->inPage=='usertabs') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/moduls/index/usertabs"><? echo Users_tabs; ?></a>
				</div>
				<div onClick="location='/controler/moduls/index/comments'" <? if ($list->inPage=='comments') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/moduls/index/comments"><? echo Reviews_settings; ?></a>
				</div>
				<div onClick="location='/controler/moduls/index/connects'" <? if ($list->inPage=='connects') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/moduls/index/connects"><? echo Calls_FAQ_Comm_Audio; ?></a>
				</div>
				<div onClick="location='/controler/moduls/index/sms'" <? if ($list->inPage=='sms') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/moduls/index/sms"><? echo SMS_settings; ?></a>
				</div>
				<div onClick="location='/controler/moduls/index/feedback'" <? if (($list->inPage=='feedback')OR($list->inPage=='editfeedback')) { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/moduls/index/feedback"><? echo Communication_forms; ?></a>
				</div>
				<div onClick="location='/controler/moduls/index/poll'" <? if (($list->inPage=='poll')OR($list->inPage=='editpoll')) { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/moduls/index/poll"><? echo Polls; ?></a>
				</div>
				<div onClick="location='/controler/moduls/index/auth'" <? if ($list->inPage=='auth') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/moduls/index/auth"><? echo Log_in_social_networks; ?></a>
				</div>
				<div onClick="location='/controler/moduls/index/counters'" <? if ($list->inPage=='counters') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/moduls/index/counters"><? echo Counters; ?></a>
				</div>
				<div onClick="location='/controler/moduls/index/sitemap'" <? if ($list->inPage=='sitemap') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/moduls/index/sitemap"><? echo Sitemap; ?></a>
				</div>
			</div>
		</div>
		<? } ?>
	</section>
	<? } ?>

	<section class="center--block__right" <? if (($list->inPage=='situation')OR($list->inPage=='false')) { ?>style="flex-basis: 100%;"<? } ?>>

		<? if ($list->inPage=='false') { ?>
		<div class="false--admin">
			<? echo You_do_not_have_permission_to_access_this_section; ?>
		</div>
		<? } else { ?>
		
		<div class="under--tabs--pole">
			<div >
				<div class="in--center--name">
					<? if ($list->inPage=='default') { echo Chapters_settings; } ?>
					<? if ($list->inPage=='languages') { echo Languages; } ?>
					<? if ($list->inPage=='editlanguage') { echo Languages; echo ' > ';  if ($list->language['main']==1) { echo Main_language; } else { echo $list->language['name']; } } ?>
					<? if ($list->inPage=='feedback') { echo Communication_forms; } ?>
					<? if ($list->inPage=='editfeedback') { echo Communication_forms; echo ' > ';  echo $list->feedback['name']; } ?>
					<? if ($list->inPage=='poll') { echo Polls; } ?>
					<? if ($list->inPage=='editpoll') { echo Polls; echo ' > ';  echo $list->poll['name']; } ?>
					<? if ($list->inPage=='comments') { echo Reviews_settings; } ?>
					<? if ($list->inPage=='connects') { echo Calls_FAQ_Comm_Audio; } ?>
					<? if ($list->inPage=='users') { echo Users_settings; } ?>
					<? if ($list->inPage=='usertabs') { echo Users_tabs; } ?>
					<? if ($list->inPage=='auth') { echo Log_in_social_networks; } ?>
					<? if ($list->inPage=='letters') { echo Templates_of_letters; } ?>
					<? if ($list->inPage=='footer') { echo Site_basement; } ?>
					<? if ($list->inPage=='header') { echo Site_header; } ?>
					<? if ($list->inPage=='uservars') { echo Users_vars; } ?>
					<? if ($list->inPage=='sms') { echo SMS_settings; } ?>
					<? if ($list->inPage=='sitemap') { echo Sitemap; } ?>
					<? if ($list->inPage=='counters') { echo Counters; } ?>
					<? if ($list->inPage=='head') { echo 'HEAD'; } ?>
					<? if ($list->inPage=='organization') { echo 'Organization'; } ?>
					<? if ($list->inPage=='metas') { echo Metadata; } ?>
					<? if ($list->inPage=='analytics') { echo Analytics; } ?>
				</div>
			</div>
		</div>
		
		<div class="under--center--pole">
			<div class="in--shadow--block--11">
	
				<? if ($list->inPage=='metas') { ?>
				<div class="data--table">
					<form method="post" action="/controler/moduls/editMetas">
					<div class="table--all">
						<div class="cell--name">
							Title (<? echo Account; ?>)
						</div>
						<div class="cell--param">
							<input type="text" name="metaTitleAccount" value="<? echo $list->confSet['metaTitleAccount'.session('languageBase')]; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Description (<? echo Account; ?>)
						</div>
						<div class="cell--param">
							<textarea name="metaDescriptionAccount" rows="3"><? echo $list->confSet['metaDescriptionAccount'.session('languageBase')]; ?></textarea>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Title (<? echo Registration; ?>)
						</div>
						<div class="cell--param">
							<input type="text" name="metaTitleRegistration" " value="<? echo $list->confSet['metaTitleRegistration'.session('languageBase')]; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Description (<? echo Registration; ?>)
						</div>
						<div class="cell--param">
							<textarea name="metaDescriptionRegistration" " rows="3"><? echo $list->confSet['metaDescriptionRegistration'.session('languageBase')]; ?></textarea>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Title (<? echo Search; ?>)
						</div>
						<div class="cell--param">
							<input type="text" name="metaTitleSearch" value="<? echo $list->confSet['metaTitleSearch'.session('languageBase')]; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Description (<? echo Search; ?>)
						</div>
						<div class="cell--param">
							<textarea name="metaDescriptionSearch" rows="3"><? echo $list->confSet['metaDescriptionSearch'.session('languageBase')]; ?></textarea>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Title (Page 404)
						</div>
						<div class="cell--param">
							<input type="text" name="metaTitlePage404" value="<? echo $list->confSet['metaTitlePage404'.session('languageBase')]; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Description (Page 404)
						</div>
						<div class="cell--param">
							<textarea name="metaDescriptionPage404" rows="3"><? echo $list->confSet['metaDescriptionPage404'.session('languageBase')]; ?></textarea>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				<? } ?>
		
				<? if ($list->inPage=='comments') { ?>
				<div class="data--table">
					<form method="post" action="/controler/moduls/editComments">
					<div class="table--all">
						<div class="cell--name">
							<? echo Number_per_page; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="commentsPerCt" value="<? echo $list->confSet['commentsPerCt']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Number_per_center; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="commentsPerCent" value="<? echo $list->confSet['commentsPerCent']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Number_per_column; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="commentsPerCol" value="<? echo $list->confSet['commentsPerCol']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Moderation; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check"><input type="checkbox" id="needModeration" name="needModeration" <? if ($list->confSet['needModeration']==1) { echo 'checked'; } ?> style="display:none;"><label for="needModeration"></label></div>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				<? } ?>
		
				<? if ($list->inPage=='connects') { ?>
				<div class="data--table">
					<form method="post" action="/controler/moduls/editConnects">
					<div class="table--all">
						<div class="cell--name">
							<? echo Number_of_calls_per_page; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="callmePerCt" value="<? echo $list->confSet['callmePerCt']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Emails_for_new_calls_messaging_through; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="callmeEmail" value="<? echo $list->confSet['callmeEmail']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Number_of_faq_per_page; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="faqPerCt" value="<? echo $list->confSet['faqPerCt']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Emails_for_new_faq_messaging_through; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="faqEmail" value="<? echo $list->confSet['faqEmail']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Number_of_requests_per_page; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="connectsPerCt" value="<? echo $list->confSet['connectsPerCt']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo The_frequency_of_checking_for_new_messages_in_sec; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="audioPer" value="<? echo $list->confSet['audioPer']; ?>">
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
					<div>
						<div class="sm--top" align="center">
							<? echo Sound_alert; ?>
						</div>
					</div>
					<form enctype="multipart/form-data" method="post" action="/controler/moduls/editAudio">
					<div class="table--all">
						<div class="cell--name">
							<? echo Sound_alert; ?>
						</div>
						<div class="cell--param">
							<div class="data--text">
							<input type="file" name="userfile"> 
							</div>
						</div>
						<? if ($list->confSet['audio']!='') { ?>
						<div class="cell--button">
							<button  type="button" class="delete js__delete--button" data-id="0" data-type="moduls" data-module="Audio"><? echo Delete_; ?></button>
						</div>
						<? } ?>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail">
							<? echo session('message1'); $session = session(); $session->remove('message1'); ?>
						</div>
					</div>
				</div>
				<? } ?>

				<? if ($list->inPage=='analytics') { ?>
				<div class="data--table">
					<form method="post" action="/controler/moduls/editStats">
					<div class="table--all">
						<div class="cell--full tip--red">
							<? echo statstip; ?>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo GA_code; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="gaCode" value="<? echo $list->confSet['gaCode']; ?>">
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
					<div>
						<div class="sm--top" align="center">
							<? echo GA_json_file; ?>
						</div>
					</div>
					<form enctype="multipart/form-data" method="post" action="/controler/moduls/editGaJson">
					<div class="table--all">
						<div class="cell--name">
							<? echo GA_file; ?>
						</div>
						<div class="cell--param">
							<div class="data--text">
							<input type="file" name="userfile"> 
							</div>
						</div>
						<? if ($list->confSet['gaJson']!='') { ?>
						<div class="cell--button">
							<button type="button" class="delete js__delete--button" data-id="0" data-type="moduls" data-module="GaJson"><? echo Delete_; ?></button>
						</div>
						<? } ?>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail">
							<? echo session('message1'); $session = session(); $session->remove('message1'); ?>
						</div>
					</div>
				</div>
				<? } ?>

				<? if ($list->inPage=='feedback') { ?>
				<div class="data--table">
					<form class="js__feedback--form" method="post" action="/controler/moduls/addFeedback">
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input name="name" type="text" class="js__feedback--name">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Ext_name; ?>
						</div>
						<div class="cell--param">
							<input name="secondName" type="text">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Class_; ?>
						</div>
						<div class="cell--param">
							<input name="class" type="text">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Email
						</div>
						<div class="cell--param">
							<input type="text" name="email">
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__feedback--button"><? echo Add; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail js__info--message">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				<? if (count($list->feedbacks)>0) { ?>
				<table class="all--width--list">
					<tr class="table--title">
						<td>
							<? echo Name_; ?>
						</td>
						<td style="width:180px;">
							ID
						</td>
						<td style="width:180px;">
							Email
						</td>
						<td align="center" style="width:1px;">
							
						</td>
					</tr>
					<? $rownum=0; ?>
					<? foreach ($list->feedbacks as $one): ?>
					<tr class="table--row<? echo $rownum; ?>">
						<td>
							<a class="tablelink" href="/controler/moduls/index/editfeedback/<? echo $one['feedbackId']; ?>"><? echo $one['name']; ?></a>
						</td>
						<td>
							feedbackShow<? echo $one['feedbackId']; ?>
						</td>
						<td>
							<? echo $one['email']; ?>
						</td>
						<td align="center">
							<button class="deletesm js__delete--button" data-id="<? echo $one['feedbackId']; ?>" data-type="moduls" data-module="Feedback"><? echo Delete_; ?></button>
						</td>
					</tr>
					<? $rownum++; if ($rownum==2) { $rownum=0; } ?>
					<? endforeach; ?>
				</table>
				<? } ?>
				<? } ?>
						
				<? if ($list->inPage=='editfeedback') { ?>
				<div class="item--back">
					<button type="button" onClick="location='/controler/moduls/index/feedback'"><? echo Back; ?></button>
				</div>
				<div class="data--table">
					<div>
						<div class="sm--top" align="center" >
							<? echo Communication_form; ?> - <? echo $list->feedback['name']; ?>
						</div>
					</div>
					<form class="js__feedback--form" method="post" action="/controler/moduls/editFeedback">
					<input type="hidden" name="feedbackId" value="<? echo $list->feedback['feedbackId']; ?>">
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" name="name" class="js__feedback--name" value="<? echo $list->feedback['name'.session('languageBase')]; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Ext_name; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" name="secondName"  value="<? echo $list->feedback['secondName'.session('languageBase')]; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Class_; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" name="class"  value="<? echo $list->feedback['class']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Email
						</div>
						<div class="cell--param">
							<input type="text" name="email" value="<? echo $list->feedback['email']; ?>">
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__feedback--button"><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail js__info--message">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				
				<div class="data--table">
					<div>
						<div class="sm--top" align="center" >
							<? echo Add_field_to_form; ?>
						</div>
					</div>
					<form class="js__feedback--param--form" method="post" action="/controler/moduls/addFeedbackParam">
					<input type="hidden" name="feedbackId" value="<? echo $list->feedback['feedbackId']; ?>">
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" name="name" class="js__feedback--param--name">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Type; ?>
						</div>
						<div class="cell--param">
							<select name="type">
								<option value="text"><? echo Text; ?></option>
								<option value="phone"><? echo Phone; ?></option>
								<option value="textarea"><? echo Textarea; ?></option>
								<option value="number"><? echo Number; ?></option>
								<option value="checkbox"><? echo Checkbox; ?></option>
								<option value="radio"><? echo Radiobox; ?></option>
								<option value="vibor"><? echo Select; ?></option>
								<option value="file"><? echo File_; ?></option>
								<option value="data"><? echo Date_; ?></option>
								<option value="data1"><? echo Date_; ?>1</option>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Number; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="number">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Necessary_field; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check"><input type="checkbox" id="need" name="need" style="display:none;"><label for="need"></label></div>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__feedback--param--button"><? echo Add; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail js__info1--message">
							<? echo session('message1'); $session = session(); $session->remove('message1'); ?>
						</div>
					</div>
				</div>
				<? if (count($list->feedbackParams)>0) { ?>
				<table class="all--width--list" >
					<tr class="table--title">
						<td align="center" style="width:1px;">
							<? echo Number; ?>
						</td>
						<td align="center" style="width:1px;">
							<? echo Necs; ?>
						</td>
						<td style="width:120px;">
							<? echo Type; ?>
						</td>
						<td>
							<? echo Name_; ?>
						</td>
						<td align="center" style="width:1px;">
							
						</td>
					</tr>
					<? if (count($list->feedbackParams)>0) { ?>
					<? $rownum=0; ?>
					<? foreach ($list->feedbackParams as $one): ?>
					<tr class="table--row<? echo $rownum; ?>">
						<td align="center" >
							<input type="text" style="text-align:center;" data-id="<? echo $one['feedbackParamId']; ?>" class="js__change--feedback--param--number" value="<? echo $one['number']; ?>">
						</td>
						<td align="center">
							<div class="data--text--check"><input type="checkbox" data-id="<? echo $one['feedbackParamId']; ?>" id="js__change--feedback--param--need<? echo $one['feedbackParamId']; ?>" value="<? echo $one['feedbackParamId']; ?>" <? if ($one['need']==1) { echo 'checked'; } ?> style="display:none;"><label for="js__change--feedback--param--need<? echo $one['feedbackParamId']; ?>"></label></div>
						</td>
						<td align="center">
							<select data-id="<? echo $one['feedbackParamId']; ?>" style="width:120px;" class="js__change--feedback--param--type">
								<option value="text" <? if ($one['type']=='text') { echo 'selected'; } ?>><? echo Text; ?></option>
								<option value="phone" <? if ($one['type']=='phone') { echo 'selected'; } ?>><? echo Phone; ?></option>
								<option value="textarea" <? if ($one['type']=='textarea') { echo 'selected'; } ?>><? echo Textarea; ?></option>
								<option value="number" <? if ($one['type']=='number') { echo 'selected'; } ?>><? echo Number; ?></option>
								<option value="ckeckbox" <? if ($one['type']=='checkbox') { echo 'selected'; } ?>><? echo Checkbox; ?></option>
								<option value="radio" <? if ($one['type']=='radio') { echo 'selected'; } ?>><? echo Radiobox; ?></option>
								<option value="vibor" <? if ($one['type']=='vibor') { echo 'selected'; } ?>><? echo Select; ?></option>
								<option value="file" <? if ($one['type']=='file') { echo 'selected'; } ?>><? echo File_; ?></option>
								<option value="data" <? if ($one['type']=='data') { echo 'selected'; } ?>><? echo Date_; ?></option>
								<option value="data1" <? if ($one['type']=='data1') { echo 'selected'; } ?>><? echo Date_; ?>1</option>
							</select>
						</td>
						<td>
							<input type="text" data-id="<? echo $one['feedbackParamId']; ?>" class="js__change--feedback--param--name" value="<? echo $one['name'.session('languageBase')]; ?>">
						</td>
						<td align="center">
							<button class="deletesm js__delete--button" data-id="<? echo $one['feedbackParamId']; ?>" data-type="moduls" data-module="FeedbackParam"><? echo Delete_; ?></button>
						</td>
					</tr>
					<? if (($one['type']=='radio')OR($one['type']=='vibor')) { ?>
					<tr class="table--row<? echo $rownum; ?>">
						<td colspan="3">
							<? echo parameter_list; ?> (1;2;3;)
						</td>
						<td colspan="3">
							<input class="eeeborder js__change--feedback--param--text" type="text" data-id="<? echo $one['feedbackParamId']; ?>" value="<? echo $one['text'.session('languageBase')]; ?>">
						</td>
					</tr>
					<? } ?>
					<? if ($one['type']=='textarea') { ?>
					<tr class="table--row<? echo $rownum; ?>">
						<td colspan="3">
							<? echo number_of_rows; ?>
						</td>
						<td colspan="3">
							<input  class="eeeborder js__change--feedback--param--text" type="text" data-id="<? echo $one['feedbackParamId']; ?>" value="<? echo $one['text'.session('languageBase')]; ?>">
						</td>
					</tr>
					<? } ?>
					<? if ($one['type']=='file') { ?>
					<tr class="table--row<? echo $rownum; ?>">
						<td colspan="3">
							<? echo acceptable_formats; ?> (<? echo format; ?> - docx;doc;xls;)
						</td>
						<td colspan="3">
							<input  class="eeeborder js__change--feedback--param--text" type="text" data-id="<? echo $one['feedbackParamId']; ?>" value="<? echo $one['text']; ?>">
						</td>
					</tr>
					<? } ?>
					<? $rownum++; if ($rownum==2) { $rownum=0; } ?>
					<? endforeach; ?>
					<? } ?>
				</table>
				<? } ?>
				<? } ?>
		
				<? if ($list->inPage=='uservars') { ?>
				<div class="data--table">
					<form class="js__uservar--form" method="post" action="/controler/moduls/addUserVar">
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input name="name" type="text" class="js__uservar--name">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Variable_name; ?>
						</div>
						<div class="cell--param">
							<input name="variable" type="text">
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__uservar--button"><? echo Add; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail js__info--message">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				<? if (count($list->uservars)>0) { ?>
				<table class="all--width--list">
					<tr class="table--title">
						<td>
							<? echo Name_; ?>
						</td>
						<td style="width:180px;">
							<? echo Variable_name; ?>
						</td>
						<td align="center" style="width:1px;">
							
						</td>
					</tr>
					<? $rownum=0; ?>
					<? foreach ($list->uservars as $one): ?>
					<tr class="table--row<? echo $rownum; ?>">
						<td>
							<a class="tablelink" href="/controler/moduls/index/edituservar/<? echo $one['varId']; ?>"><? echo $one['name']; ?></a>
						</td>
						<td>
							$list->userVar['<? echo $one['variable']; ?>']
						</td>
						<td align="center">
							<button class="deletesm js__delete--button" data-id="<? echo $one['varId']; ?>" data-type="moduls" data-module="UserVar"><? echo Delete_; ?></button>
						</td>
					</tr>
					<? $rownum++; if ($rownum==2) { $rownum=0; } ?>
					<? endforeach; ?>
				</table>
				<? } ?>
				<? } ?>
						
				<? if ($list->inPage=='edituservar') { ?>
				<div class="item--back">
					<button type="button" onClick="location='/controler/moduls/index/uservars'"><? echo Back; ?></button>
				</div>
				<div class="data--table">
					<div>
						<div class="sm--top" align="center" >
							<? echo Users_vars; ?>
						</div>
					</div>
					<form class="js__uservar--form" method="post" action="/controler/moduls/editUserVar">
					<input type="hidden" name="varId" value="<? echo $list->userVar['varId']; ?>">
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" name="name" class="js__uservar--name" value="<? echo $list->userVar['name']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Variable_name; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" name="variable"  value="<? echo $list->userVar['variable']; ?>">
						</div>
					</div>
					<? foreach ($list->languages as $one): ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Value; ?> <? echo $one['url']; ?>
						</div>
						<div class="cell--param">
							<? if ($one['url']!='') { $prefix = '_'.$one['url']; } else { $prefix = $one['url']; } ?>
							<input type="text" name="param<? echo $prefix; ?>"  value="<? echo $list->userVar['param'.$prefix]; ?>">
						</div>
					</div>
					<? endforeach; ?>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__uservar--button"><? echo Save; ?></button>
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
		
				<? if ($list->inPage=='languages') { ?>
				<div class="data--table">
					<form class="js__add--language--form" method="post" action="/controler/moduls/addLanguage">
					<div class="table--all">
						<div class="cell--name">
							<? echo Visible; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<div class="data--text--check"><input type="checkbox" id="visible" name="visible" style="display:none;"><label for="visible"></label></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input name="name" type="text" class="js__add--language--name">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_at_site; ?>
						</div>
						<div class="cell--param">
							<input name="nameSite" type="text">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Prefix; ?> (ua,en,ru...)
						</div>
						<div class="cell--param">
							<input name="url" type="text" class="js__add--language--url">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--full tip--red">
							<? echo Tiplang1; ?>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Number; ?>
						</div>
						<div class="cell--param">
							<input name="number" type="text">
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__add--language--button"><? echo Add; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail js__info--message">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				<? if (count($list->languages)>0) { ?>
				<table class="all--width--list">
					<tr class="table--title">
						<td  align="center">
							<? echo act; ?>
						</td>
						<td  align="center">
							<? echo Number; ?>
						</td>
						<td>
							<? echo Prefix; ?>
						</td>
						<td>
							<? echo Name_; ?>
						</td>
						<td align="center" style="width:1px;">
							
						</td>
					</tr>
					<? $rownum=0; ?>
					<? foreach ($list->languages as $one): ?>
					<tr class="table--row<? echo $rownum; ?>">
						<td style="width:1px;text-align:center">
							<? if ($one['main']==0) { ?>
							<div class="data--text--check">
								<input type="checkbox" id="js__change--language--visible<? echo $one['id']; ?>" style="display:none;" value="<? echo $one['id']; ?>" <? if ($one['visible']==1) { echo 'checked'; } ?> >
								<label for="js__change--language--visible<? echo $one['id']; ?>"></label>
							</div>
							<? } ?>
						</td>
						<td style=" width:1px;">
							<input style="text-align:center;" type="text" class="js__change--language--number" value="<? echo $one['number']; ?>" data-id="<? echo $one['id']; ?>">
						</td>
						<td style="width:100px;">
							<? echo $one['url']; ?>
						</td>
						<td>
							<a class="tablelink" href="/controler/moduls/index/editlanguage/<? echo $one['id']; ?>"><? if ($one['main']==1) { ?><? echo Main_language; ?><? } else { ?><? echo $one['name']; ?><? } ?></a>
						</td>
						<td style="width:1px;">
							<? if ($one['main']==0) { ?>
							<form class="js__delete--language--form<? echo $one['id']; ?>" method="post" action="/controler/moduls/delLanguage">
							<input type="hidden" name="id" value="<? echo $one['id']; ?>">
							<button type="button" class="deletesm js__language--delete" data-id="<? echo $one['id']; ?>">x</button>
							</form>
							<? } ?>
						</td>
					</tr>
					<? $rownum++; if ($rownum==2) { $rownum=0; } ?>
					<? endforeach; ?>
				</table>
				<? } ?>
				<? } ?>
				
				<? if ($list->inPage=='editlanguage') { ?>
				<div class="item--back">
					<button onClick="location='/controler/moduls/index/languages'"><? echo Back; ?></button>
				</div>
				<div class="data--table">
					<form class="js__edit--language--form" method="post" action="/controler/moduls/editLanguage">
					<input type="hidden" name="id" value="<? echo $list->language['id']; ?>">
					<div class="table--all">
						<div class="cell--name">
							<? echo Visible; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<div class="data--text--check">
							<input type="checkbox" id="visible" name="visible" <? if ($list->language['main']==1) { ?>disabled<? } ?> <? if ($list->language['visible']==1) { echo 'checked'; } ?> style="display:none;">
							<label for="visible"></label>
							</div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>
						<? if ($list->language['main']==0) { ?>
						<div class="cell--param">
							<input type="text" name="name" class="js__edit--language--name" value="<? echo $list->language['name']; ?>">
						</div>
						<? } else { ?>
						<div class="cell--param">
							<div class="data--text"><? echo Main_language; ?></div>
						</div>
						<? } ?>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_at_site; ?>
						</div>
						<div class="cell--param">
							<input name="nameSite" type="text" value="<? echo $list->language['nameSite']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Prefix; ?>
						</div>
						<div class="cell--param">
							<div class="data--text"><? echo $list->language['url']; ?></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Number; ?>
						</div>
						<div class="cell--param">
							<? if ($list->language['main']==0) { ?>
							<input type="text" name="number"  value="<? echo $list->language['number']; ?>"  >
							<? } else { ?>
							<div class="data--text"><? echo $list->language['number']; ?></div>
							<? } ?>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__edit--language--button"><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail js__info--message">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
						
				<div class="data--table">
					<div align="center" class="sm--top">
						<? echo Translation; ?>
					</div>
					<form method="post" action="/controler/moduls/editLanguageNames">
					<input type="hidden" name="id" value="<? echo $list->language['id']; ?>">
					<input type="hidden" name="prefix" value="<? echo $list->language['url']; ?>">
					<? if ($list->language['url']=='') { $prefix=''; } else { $prefix='_'.$list->language['url']; } ?>
					<? foreach ($list->langnames as $one): ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo $one['nick']; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="<? echo $one['nick']; ?>"  value="<? echo $one['param'.$prefix]; ?>">
						</div>
					</div>
					<? endforeach; ?>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail">
							<? echo session('message1'); $session = session(); $session->remove('message1'); ?>
						</div>
					</div>
				</div>
				<? } ?>
		
				<? if ($list->inPage=='poll') { ?>
				<div class="data--table">
					<form class="js__poll--form" method="post" action="/controler/moduls/addPoll">
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" class="js__poll--name" name="name">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Number; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="number">
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__poll--button"><? echo Add; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail js__info--message">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
						
				<? if (count($list->polls)>0) { ?>
				<table class="all--width--list">
					<tr class="table--title">
						<td style="width:1px;">
							<? echo Number; ?>
						</td>
						<td>
							<? echo Name_; ?>
						</td>
						<td align="center" style="width:1px;">
									
						</td>
					</tr>
					<? $rownum=0; ?>
					<? foreach ($list->polls as $one): ?>
					<tr class="table--row<? echo $rownum; ?>">
						<td>
							<input type="text" class="js__change--poll--number" data-id="<? echo $one['pollId']; ?>" value="<? echo $one['number']; ?>">
						</td>
						<td>
							<a class="tablelink" href="/controler/moduls/index/editpoll/<? echo $one['pollId']; ?>"><? echo $one['name'.session('languageBase')]; ?></a>
						</td>
						<td align="center">
							<button class="deletesm js__delete--button" data-id="<? echo $one['pollId']; ?>" data-type="moduls" data-module="Poll"><? echo Delete_; ?></button>
						</td>
					</tr>
					<? $rownum++; if ($rownum==2) { $rownum=0; } ?>
					<? endforeach; ?>
				</table>
				<? } ?>
				<? } ?>
						
				<? if ($list->inPage=='editpoll') { ?>
				<div class="item--back">
					<button type="button" onClick="location='/controler/moduls/index/poll'"><? echo Back; ?></button>
				</div>
				<div class="data--table">
					<form class="js__poll--form" method="post" action="/controler/moduls/editPoll">
					<input type="hidden" name="pollId" value="<? echo $list->poll['pollId']; ?>">
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" class="js__poll--name" name="name" value="<? echo $list->poll['name'.session('languageBase')]; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Number; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="number" value="<? echo $list->poll['number']; ?>">
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__poll--button"><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail js__info--message">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
						
				<div class="data--table">
					<div class="sm--top"align="center">
						<? echo Adding_parameter; ?>
					</div>
					<form class="js__poll--param--form" method="post" action="/controler/moduls/addPollParam">
					<input type="hidden" name="pollId" value="<? echo $list->poll['pollId']; ?>">
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" name="name" class="js__poll--param--name">
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--name">
							<button type="button" class="js__poll--param--button"><? echo Add; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--name fail js__info1--messages">
							<? echo session('message1'); $session = session(); $session->remove('message1'); ?>
						</div>
					</div>
				</div>
						
				<? if (count($list->pollParams)>0) { ?>
				<table class="all--width--list">
					<tr class="table--title">
						<td align="left">
							<? echo Votes; ?>
						</td>
						<td>
							<? echo Name_; ?>
						</td>
						<td align="center" style="width:1%;">
							
						</td>
					</tr>
					<? $rownum=0; ?>
					<? foreach ($list->pollParams as $one): ?>
					<tr class="table--row<? echo $rownum; ?>">
						<td align="left" style="width:60px;">
							<input type="text" class="js__change--poll--param--votes" data-id="<? echo $one['pollParamId']; ?>" value="<? echo $one['votes']; ?>">
						</td>
						<td>
							<input type="text" class="js__change--poll--param--name" data-id="<? echo $one['pollParamId']; ?>" value="<? echo $one['name'.session('languageBase')]; ?>">
						</td>
						<td align="center">
							<button class="deletesm js__delete--button" data-id="<? echo $one['pollParamId']; ?>" data-type="moduls" data-module="PollParam"><? echo Delete_; ?></button>
						</td>
					</tr>
					<? $rownum++; if ($rownum==2) { $rownum=0; } ?>
					<? endforeach; ?>
				</table>
				<? } ?>
				<? } ?>
				
				<? if ($list->inPage=='users') { ?>
				<div class="data--table">
					<form method="post" action="/controler/moduls/editUsersConf">
					<div class="table--all">
						<div class="cell--name">
							<? echo Users_per_page; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="usersPer" value="<? echo $list->confSet['usersPer']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Activation_via_email; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check"><input type="checkbox" id="userActivation" name="userActivation" <? if ($list->confSet['userActivation']==1) { echo 'checked'; } ?> style="display:none;"><label for="userActivation"></label></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Default_group; ?>
						</div>
						<div class="cell--param">
							<script type="text/javascript">jQuery(document).ready(function($) {$("#userDefaultCat").chosen({width: '100%',allow_single_deselect: true}).trigger("chosen:updated");});</script>
							<select name="userDefaultCat" id="userDefaultCat">
								<option value="0">------ <? echo Parent_group; ?> ------</option>
								<? foreach ($list->userCats as $one) { ?>
								<option value="<? echo $one['userCatId']; ?>" <? if ($list->confSet['userDefaultCat']==$one['userCatId']) { echo 'selected'; } ?>><? echo $one['name']; ?></option>
								<? } ?>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Need_avatar; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check"><input type="checkbox" id="needAvatar" name="needAvatar" <? if ($list->confSet['needAvatar']==1) { echo 'checked'; } ?> style="display:none;"><label for="needAvatar"></label></div>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
					<div class="sm--top" align="center" >
							<? echo Registration_fields; ?>
					</div>
					<form class="js__user--param--form" method="post" action="/controler/moduls/addUserParam">
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" name="name" id="userParamName">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Type; ?>
						</div>
						<div class="cell--param">
							<select name="type">
								<option value="fio"><? echo Fioname; ?></option>
								<option value="surname"><? echo Surname; ?></option>
								<option value="phone"><? echo Phone; ?></option>
								<option value="phoneext"><? echo Phoneext; ?></option>
								<option value="text"><? echo Text; ?></option>
								<option value="date"><? echo Date_; ?></option>
								<option value="textarea"><? echo Textarea; ?></option>
								<option value="checkbox"><? echo Checkbox; ?></option>
								<option value="radio"><? echo Radiobox; ?></option>
								<option value="vibor"><? echo Select; ?></option>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Number; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="number">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Necessary_field; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check"><input type="checkbox" id="need" name="need" style="display:none;"><label for="need"></label></div>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__user--param--button"><? echo Add; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail js__info--message">
							<? echo session('message1'); $session = session(); $session->remove('message1'); ?>
						</div>
					</div>
				</div>
				<? if (count($list->userParams)>0) { ?>		
				<table class="all--width--list">
					<tr class="table--title">
						<td align="center" style="width:1px;">
							<? echo Number; ?>
						</td>
						<td align="center" style="width:1px;">
							<? echo Necs; ?>
						</td>
						<td style="width:120px;">
							<? echo Type; ?>
						</td>
						<td>
							<? echo Name_; ?>
						</td>
						<td align="center" style="width:1px;">
									
						</td>
					</tr>
					<? $rownum=0; ?>
					<? foreach ($list->userParams as $one): ?>
					<tr class="table--row<? echo $rownum; ?>">
						<td align="left">
							<input type="text" style="text-align:center;" data-id="<? echo $one['userParamId']; ?>" class="js__change--user--param--number" value="<? echo $one['number']; ?>">
						</td>
						<td align="left">
							<div class="data--text--check"><input type="checkbox" id="js__change--user--param--need<? echo $one['userParamId']; ?>" data-id="<? echo $one['userParamId']; ?>" value="<? echo $one['userParamId']; ?>" <? if ($one['need']==1) { echo 'checked'; } ?> style="display:none;"><label for="js__change--user--param--need<? echo $one['userParamId']; ?>"></label></div>
						</td>
						<td>
							<select data-id="<? echo $one['userParamId']; ?>" style="width:120px;" class="js__change--user--param--type">
								<option value="fio" <? if ($one['type']=='fio') { echo 'selected'; } ?>><? echo Fioname; ?></option>
								<option value="surname" <? if ($one['type']=='surname') { echo 'selected'; } ?>><? echo Surname; ?></option>
								<option value="phone" <? if ($one['type']=='phone') { echo 'selected'; } ?>><? echo Phone; ?></option>
								<option value="phoneext" <? if ($one['type']=='phoneext') { echo 'selected'; } ?>><? echo Phoneext; ?></option>
								<option value="text" <? if ($one['type']=='text') { echo 'selected'; } ?>><? echo Text; ?></option>
								<option value="date" <? if ($one['type']=='date') { echo 'selected'; } ?>><? echo Date_; ?></option>
								<option value="textarea" <? if ($one['type']=='textarea') { echo 'selected'; } ?>><? echo Textarea; ?></option>
								<option value="checkbox" <? if ($one['type']=='checkbox') { echo 'selected'; } ?>><? echo Checkbox; ?></option>
								<option value="radio" <? if ($one['type']=='radio') { echo 'selected'; } ?>><? echo Radiobox; ?></option>
								<option value="vibor" <? if ($one['type']=='vibor') { echo 'selected'; } ?>><? echo Select; ?></option>
							</select>
						</td>
						<td>
							<input type="text" data-id="<? echo $one['userParamId']; ?>" class="js__change--user--param--name" value="<? echo $one['name'.session('languageBase')]; ?>">
						</td>
						<td align="center">
							<button class="deletesm js__delete--button" data-id="<? echo $one['userParamId']; ?>" data-type="moduls" data-module="UserParam"><? echo Delete_; ?></button>
						</td>
					</tr>
					<? if (($one['type']=='vibor')OR($one['type']=='radio')) { ?>
					<tr class="table--row<? echo $rownum; ?>">
						<td colspan="3">
							<? echo parameter_list; ?> (1;2;3;)
						</td>
						<td colspan="2">
							<input type="text" data-id="<? echo $one['userParamId']; ?>" class="eeeborder js__change--user--param--text" value="<? echo $one['text'.session('languageBase')]; ?>">
						</td>
					</tr>
					<? } ?>
					<? if ($one['type']=='textarea') { ?>
					<tr class="table--row<? echo $rownum; ?>">
						<td colspan="3">
							<? echo number_of_rows; ?>
						</td>
						<td colspan="2">
							<input type="text" data-id="<? echo $one['userParamId']; ?>" class="eeeborder js__change--user--param--text" value="<? echo $one['text'.session('languageBase')]; ?>">
						</td>
					</tr>
					<? } ?>
					<? $rownum++; if ($rownum==2) { $rownum=0; } ?>
					<? endforeach; ?>
				</table>
				<? } ?>
				<? } ?>
				
				<? if ($list->inPage=='usertabs') { ?>
				<div class="data--table">
					<form method="post" class="js__user--tab--form" action="/controler/moduls/addUserTab">
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="name" class="js__user--tab--name">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Type; ?>
						</div>
						<div class="cell--param">
							<select name="type">
								<option value="0"><? echo Text; ?></option>
								<option value="1"><? echo Personal_data; ?></option>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Number; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="number">
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__user--tab--button"><? echo Add; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail js__info--message">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
							
				<? if (count($list->userTabs)>0) { ?>
				<table class="all--width--list">
					<tr class="table--title">
						<td style="text-align:center; width:50px;">
							<? echo Number; ?>
						</td>
						<td>
							<? echo Name_; ?>
						</td>
						<td style="width:200px">
							<? echo Type; ?>
						</td>
						<td align="center" style="width:1px;">
							x
						</td>
					</tr>
					<? $rownum=0; ?>
					<? foreach ($list->userTabs as $one): ?>
					<tr class="table--row<? echo $rownum; ?>">
						<td>
							<input type="text" class="js__change--user--tab--number"  style="text-align:center;" data-id="<? echo $one['userTabId']; ?>" value="<? echo $one['number']; ?>">
						</td>
						<td>
							<input type="text" class="js__change--user--tab--name" data-id="<? echo $one['userTabId']; ?>" value="<? echo $one['name'.session('languageBase')]; ?>">
						</td>
						<td>
							<select class="js__change--user--tab--type" data-id="<? echo $one['userTabId']; ?>">
								<option value="0" <? if ($one['type']==0) { echo 'selected'; } ?>><? echo Text; ?></option>
								<option value="1" <? if ($one['type']==1) { echo 'selected'; } ?>><? echo Personal_data; ?></option>
							</select>
						</td>
						<td align="center">
							<button class="deletesm js__delete--button" data-id="<? echo $one['userTabId']; ?>" data-type="moduls" data-module="UserTab"><? echo Delete_; ?></button>
						</td>
					</tr>
					<? $rownum++; if ($rownum==2) { $rownum=0; } ?>
					<? endforeach; ?>
				</table>
							
				<? } ?>
				<? } ?>
		
				<? if ($list->inPage=='auth') { ?>
				<div class="data--table" >
					<div class="sm--top" align="center">
						Facebook
					</div>
					<form method="post" action="/controler/moduls/editAuth">
					<div class="table--all">
						<div class="cell--name">
							<? echo Log_in_with_facebook; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check"><input type="checkbox" id="fbAuth" name="fbAuth" <? if ($list->confSet['fbAuth']==1) { echo 'checked'; }  ?> style="display:none;"><label for="fbAuth"></label></div>
						</div>
					</div>
					<? if ($list->confSet['fbAuth']==1) { ?>
					<div class="table--all">
						<div class="cell--name">
							APP ID
						</div>
						<div class="cell--param">
							<input type="text" value="<? echo $list->confSet['fbAppId']; ?>" name="fbAppId">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Secret_id; ?>
						</div>
						<div class="cell--param">
							<input type="text" value="<? echo $list->confSet['fbSecretId']; ?>" name="fbSecretId">
						</div>
					</div>
					<? } ?>
					<div class="sm--top" align="center">
							Vkontakte
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Log_in_with_vkontakte; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check"><input type="checkbox" id="vkAuth" name="vkAuth" <? if ($list->confSet['vkAuth']==1) { echo 'checked'; }  ?> style="display:none;"><label for="vkAuth"></label></div>
						</div>
					</div>
					<? if ($list->confSet['vkAuth']==1) { ?>
					<div class="table--all">
						<div class="cell--name">
							APP ID
						</div>
						<div class="cell--param">
							<input type="text" value="<? echo $list->confSet['vkAppId']; ?>" name="vkAppId">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Secret_id; ?>
						</div>
						<div class="cell--param">
							<input type="text" value="<? echo $list->confSet['vkSecretId']; ?>" name="vkSecretId">
						</div>
					</div>
					<? } ?>
					<div class="sm--top" align="center">
							Google
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Log_in_with_google; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check"><input type="checkbox" id="ggAuth" name="ggAuth" <? if ($list->confSet['ggAuth']==1) { echo 'checked'; }  ?> style="display:none;"><label for="ggAuth"></label></div>
						</div>
					</div>
					<? if ($list->confSet['ggAuth']==1) { ?>
					<div class="table--all">
						<div class="cell--name">
							APP ID
						</div>
						<div class="cell--param">
							<input type="text" value="<? echo $list->confSet['ggAppId']; ?>" name="ggAppId">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Secret_id; ?>
						</div>
						<div class="cell--param">
							<input type="text" value="<? echo $list->confSet['ggSecretId']; ?>" name="ggSecretId">
						</div>
					</div>
					<? } ?>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				<? } ?>
		
				<? if ($list->inPage=='header') { ?>
				<div class="data--table" >
					<form enctype="multipart/form-data" class="js__header--logo--form" method="post" action="/controler/moduls/editLogo">
					<div class="table--all">
						<div class="cell--name">
							<? echo Logo; ?>
						</div>
						<div class="cell--param">
							<div class="data--text">
							<? if ($list->confSet['bglogo']!='') { ?>
							<a href="/<? echo $list->confSet['bglogo']; ?>" target="_blank" class="tablelink"><? echo Uploaded_image; ?></a>
							<? } ?>
							<input type="file" class="js__header--logo--file" name="userfile"> 
							<? if ($list->confSet['bglogo']!='') { ?>
							<button type="button" class="delete js__delete--button" data-id="0" data-type="moduls" data-module="BgLogo"><? echo Delete_; ?></button>
							<? } ?>
							</div>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__header--logo--button"><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail js__header--logo--message">
							<? echo session('headerlogo'); $session = session(); $session->remove('headerlogo'); ?>
						</div>
					</div>
					<form method="post" action="/controler/moduls/editHeader">
					<div align="center" class="sm--top">
						<? echo Field; ?> #1
					</div>
					<div>
						<textarea class="mceAdmin" name="header" class="mceAdminconfig" rows="15"><? echo $list->confSet['header'.session('languageBase')]; ?></textarea>
					</div>
					<div align="center" class="sm--top">
						<? echo Field; ?> #2
					</div>
					<div>
						<textarea class="mceAdmin" name="header1" class="mceAdminconfig" rows="15"><? echo $list->confSet['header1'.session('languageBase')]; ?></textarea>
					</div>
					<div align="center" class="sm--top">
						<? echo Field; ?> #3
					</div>
					<div>
						<textarea class="mceAdmin" name="header2" class="mceAdminconfig" rows="15"><? echo $list->confSet['header2'.session('languageBase')]; ?></textarea>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail">
							<? echo session('message1'); $session = session(); $session->remove('message1'); ?>
						</div>
					</div>
				</div>
				<? } ?>
				
				<? if ($list->inPage=='footer') { ?>
				<div class="data--table" >
					<form method="post" action="/controler/moduls/editFooter">
					<div>
						<textarea class="mceAdmin" rows="30" name="footer"><? echo $list->confSet['footer'.session('languageBase')]; ?></textarea>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				<? } ?>
	
				<? if ($list->inPage=='letters') { ?>
				<div class="data--table" >
					<form method="post" action="/controler/moduls/editLetters">
					<div class="table--all">
						<div class="cell--name">
							<? echo From_who; ?> (email)
						</div>
						<div class="cell--param">
							<input type="text" name="fromEmail" value="<? echo $list->confSet['fromEmail']; ?>">
						</div>
					</div>
					<? foreach ($list->letters as $one): ?>
					<input type="hidden" name="id[]" value="<? echo $one['id']; ?>">
					<div class="sm--top" align="center" >
						<? if ($one['name']=='accountactivationletter') { echo Account_activation_letter; } ?>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Theme; ?>
						</div>
						<div class="cell--param">
							<input id="theme<? echo $one['id']; ?>" type="text" name="theme[]" value="<? echo $one['theme'.session('languageBase')]; ?>">
						</div>
					</div>
					<div align="center" class="sm--top">
						<? echo Text; ?>
					</div>
					<div>
						<textarea id="text<? echo $one['id']; ?>" name="text[]" rows="30" class="mceSubsc"><? echo $one['text'.session('languageBase')]; ?></textarea>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Send_a_test_letter_to_email; ?>
						</div>
						<div class="cell--param">
							<input class="eeeborder" type="text" value="" id="email<? echo $one['id']; ?>">
						</div>
						<div class="cell--button">
							<button type="button" class="js__send--test--letter" data-id="<? echo $one['id']; ?>"><? echo Send; ?></button>
						</div>
					</div>
					<? endforeach ?>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Save; ?></button>
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
		
				<? if ($list->inPage=='sms') { ?>
				<div class="data--table">
					<form method="post" action="/controler/moduls/editSms">
					<div class="table--all">
						<div class="cell--name" >
							<? echo Site_name_from_who_for_sms; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="fromSms" value="<? echo $list->confSet['fromSms']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name" >
							SOAP Client
						</div>
						<div class="cell--param">
							<input type="text" name="soapClient" value="<? echo $list->confSet['soapClient']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name" >
							ID
						</div>
						<div class="cell--param">
							<input type="text" value="<? echo $list->confSet['turboLogin']; ?>" name="turboLogin">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name" >
							<? echo Password; ?>
						</div>
						<div class="cell--param">
							<input type="text" value="<? echo $list->confSet['turboPass']; ?>" name="turboPass">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name" >
							<? echo Phone; ?> (<? echo format; ?> +380505500050)
						</div>
						<div class="cell--param">
							<input type="text" value="<? echo $list->confSet['turboPhone']; ?>" name="turboPhone">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name" >
							<? echo Sending_sms_when_a_new_request_from_the_form_received; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check">
							<input type="checkbox" id="smsConnect" name="smsConnect" <? if ($list->confSet['smsConnect']==1) { echo 'checked'; }  ?> style="display:none;">
							<label for="smsConnect">
							</div>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full" >
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				<? } ?>
				
				<? if ($list->inPage=='head') { ?>
				<div class="data--table">
					<form method="post" action="/controler/moduls/editHead">
					<div class="table--all">
						<div class="cell--name">
							<? echo Site_name; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="from" value="<? echo $list->confSet['from'.session('languageBase')]; ?>">
						</div>
					</div>
					<div class="sm--top">
						HEAD
					</div>
					<div class="table--all">
						<div class="cell--full" >
							<textarea rows="40" name="head"><? echo $list->confSet['head']; ?></textarea>
						</div>
					</div>
					<div class="sm--top">
						BODY
					</div>
					<div class="table--all">
						<div class="cell--full" >
							<textarea rows="40" name="body"><? echo $list->confSet['body'.session('languageBase')]; ?></textarea>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full" >
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail" >
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				<? } ?>
				
				<? if ($list->inPage=='organization') { ?>
				<div class="data--table">
					<form method="post" action="/controler/moduls/editOrganization">
					<div class="sm--top">
						Organization
					</div>
					<div class="table--all">
						<div class="cell--full" >
							<textarea rows="40" name="organization"><? echo $list->confSet['organization'.session('languageBase')]; ?></textarea>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full" >
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail" >
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				<? } ?>
							
				<? if ($list->inPage=='counters') { ?>
				<div class="data--table">
					<div align="center" class="sm--top">
						<? echo Paste_counter_code; ?>
					</div>
					<form method="post" action="/controler/moduls/addCounter">
					<div class="table--all">
						<div class="cell--full" >
							<textarea rows="15" name="counter" style="width:100%;"></textarea>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full" >
							<button><? echo Add; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail" id="infoMessage">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
							
				<? if (count($list->counters)>0) { ?>
				<table class="all--width--list">
					<tr class="table--title">
						<td style="width:1px; text-align:center;">
							<? echo Number; ?>
						</td>
						<td align="center" style="width:100px;">
							<? echo Display; ?>
						</td>
						<td>
							<? echo Code; ?>
						</td>
						<td align="center" style="width:1px;">
										
						</td>
					</tr>
					<? $rownum=0; ?>
					<? foreach ($list->counters as $one): ?>
					<tr class="table--row<? echo $rownum; ?>">
						<td>
							<input type="text" class="js__change--counter--number" style="text-align:center;" data-id="<? echo $one['id']; ?>" value="<? echo $one['number']; ?>">
						</td>
						<td align="center">
							<? echo $one['counter']; ?>
						</td>
						<td>
							<textarea rows="8" class="js__change--counter--code" data-id="<? echo $one['id']; ?>"><? echo $one['counter']; ?></textarea>
						</td>
						<td align="center">
							<button class="deletesm js__delete--button" data-id="<? echo $one['id']; ?>" data-type="moduls" data-module="Counter"><? echo Delete_; ?></button>
						</td>
					</tr>
					<? $rownum++; if ($rownum==2) { $rownum=0; } ?>
					<? endforeach; ?>
				</table>
				<? } ?>
				<? } ?>
							
				<? if ($list->inPage=='sitemap') { ?>
				<div class="data--table">
					<form method="post" action="/controler/moduls/editSitemap">
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Update; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail" >
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				<? } ?>
		
				</div>
			
	
		</div>
		<? } ?>
	</section>
</section>

