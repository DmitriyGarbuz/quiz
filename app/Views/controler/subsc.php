<section class="center--block">
	<? if ($list->inPage!='false') { ?>
	<section class="center--block__left">
		<? echo view('/controler/newevents'); ?>
		<? if (($list->inPage!='situation')AND($list->inPage!='false')) { ?>
		<div>
			<div class="margin--top--20">
				<div class="add--item--main--block--left" onClick="location='/controler/users/index/add'">
					<div class="add--item--main--block--left__in">
						<div>
							<img border="0" src="/admin/img/icons/add_group.svg">
						</div>
						<div>
							<a href="/controler/users/index/add"><? echo Add_group; ?></a>
						</div>
					</div>
				</div>
				<div class="add--item--main--block--left" onClick="location='/controler/user/index/add'">
					<div class="add--item--main--block--left__in">
						<div>
							<img border="0" src="/admin/img/icons/account-plus-outline.svg">
						</div>
						<div>
							<a href="/controler/user/index/add"><? echo Add_user; ?></a>
						</div>
					</div>
				</div>
				<div class="add--item--main--block--left" onClick="location='/controler/subsc'">
					<div class="add--item--main--block--left__in">
						<div>
							<img border="0" src="/admin/img/icons/rozsilka.svg">
						</div>
						<div>
							<a href="/controler/subsc"><? echo Emailing; ?></a>
						</div>
					</div>
				</div>
			</div>
			<div class="border--top--color">
				<div onClick="location='/controler/subsc'" <? if ($list->inPage=='list') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/subsc"><? echo Make_emailing; ?></a>
				</div>
				<div onClick="location='/controler/subsc/index/add'" <? if ($list->inPage=='addsubsc') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/subsc/index/add"><? echo Create_new_template; ?></a>
				</div>
				<? foreach ($list->subscs as $one): ?>
				<div onClick="location='/controler/subsc/index/edit/<? echo $one['id']; ?>'" <? if ((isset($list->subsc['id']))AND($list->subsc['id']==$one['id'])) { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/subsc/index/edit/<? echo $one['id']; ?>">- <? echo $one['name']; ?></a>
				</div>
				<? endforeach; ?>
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
		
			<? if ($list->inPage=='add') { ?>
			<div >
				<div class="in--center--name">
					<? echo Create_new_template; ?>
				</div>
			</div>
			<? } ?>
			
			<? if (isset($list->subsc['id'])) { ?>
			<div class="top--link--for--name">
				<div class="in--center--name">
					<? echo Emeiling_template; ?> > <? echo $list->subsc['name']; ?>
				</div>
				<div class="in--center--button">
					<button class="delete js__delete--button" data-id="<? echo $list->subsc['id']; ?>" data-type="subsc" data-module="Subsc"><? echo Delete_; ?></button>
				</div>
			</div>
			<? } ?>
			
		</div>
	
		<div class="under--center--pole">
			<div class="in--shadow--block--11">
			
				<? if ($list->inPage=='list') { ?>
				<div class="data--table">
					<form enctype="multipart/form-data" method="post" class="js__subsc--form" action="/controler/subsc/makeSubsc">
					<div class="table--all">
						<div class="cell--name">
							<? echo Theme; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="theme" class="js__subsc--theme">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Group; ?>
						</div>
						<div class="cell--param">
							<select name="userCatId">
								<option value="0">----- <? echo all_users; ?> -----</option>
								<? foreach ($list->userCats as $one): ?>
								<option value="<? echo $one['userCatId']; ?>"><? echo $one['name']; ?></option>
								<? endforeach; ?>
								</select>
						</div>
					</div>
					<div class="sm--top" align="center">
							<? echo User_settings_for_emailing; ?>
					</div>
					<? foreach ($list->userParams as $one): ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo $one['name']; ?>
						</div>
						<div class="cell--param" <? if ($one['need']==1) { echo 'data-info="1"'; } ?>>
							<? if ($one['type']=='fio') { ?>
								<input name="fio" type="text">
							<? } ?>
							<? if ($one['type']=='surname') { ?>
								<input name="surname" type="text">
							<? } ?>
							<? if ($one['type']=='phone') { ?>
								<script type="text/javascript">$(function() {$( "#usertelnumber" ).inputmask();});</script>
								<input id="userTelnumber" name="phone" data-inputmask="'alias': 'phone'"  type="text">
							<? } ?>
							<? if ($one['type']=='text') { ?>
								<input id="userParam" name="<? echo $one['userParamId']; ?>" type="text">
							<? } ?>
							<? if ($one['type']=='phoneext') { ?>
								<script type="text/javascript">$(function() {$( "#userParam<? echo $one['userParamId']; ?>" ).inputmask();});</script>
								<input id="userParam<? echo $one['userParamId']; ?>" name="<? echo $one['userParamId']; ?>" data-inputmask="'alias': 'phone'"  type="text">
							<? } ?>
							<? if ($one['type']=='checkbox') { ?>
								<input id="userParam" value="1" name="<? echo $one['userParamId']; ?>" type="checkbox">
							<? } ?>
							<? if ($one['type']=='textarea') { ?>
								<textarea id="userParam" name="<? echo $one['userParamId']; ?>" rows="<? echo $one['text']; ?>"></textarea>
							<? } ?>
							<? if ($one['type']=='radio') {
											$max = mb_substr_count($one['text'], ";"); $pos=0;
											for ($i=0;$i<$max;$i++) {$newpos = mb_strpos ($one['text'],';',$pos);if ($newpos!=$pos) {$value = mb_substr ($one['text'],$pos,$newpos-$pos);} else { $value=0; }$pos = $newpos+1;
											?>
											<div><input name="<? echo $one['userParamId']; ?>" value="<? echo $value; ?>" type="radio"> <? echo $value; ?></div>
											<? } ?>
										<? } ?>
							<? if ($one['type']=='vibor') { ?>
								<select id="userParam" name="<? echo $one['userParamId']; ?>">
								<option value="0"><? echo all_options; ?></option>
								<?					
								$max = substr_count($one['text'], ";"); 
								for ($i=0;$i<$max;$i++) {
									$newpos = strpos ($one['text'],';',$pos);
									if ($newpos!=$pos) {
									$value = substr ($one['text'],$pos,$newpos-$pos);
									} else { $value=0; }
									$pos = $newpos+1;
								?>
								<option value="<? echo $value; ?>"><? echo $value; ?></option>
								<? } ?>
								</select>
							<? } ?>
						</div>
					</div>
					<? endforeach; ?>
					<div align="center" class="sm--top">
						<? echo Text; ?>
					</div>
					<div>
						<div>
							<textarea class="mceSubsc" id="js__subsc--text" rows="60" name="text"></textarea>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Attach_file; ?>
						</div>
						<div class="cell--param">
							<div class="data--text">
								<input type="file" name="userfile">
							</div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Test_the_file_is_not_attached_to_the_test_mailing; ?>
						</div>
						<div class="cell--param">
							<input type="text" class="js__subsc--test--email">
						</div>
						<div class="cell--button">
							<button type="button" class="js__subsc--test--button"><? echo Send; ?></button>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__make--subsc--button"><? echo Make_emailing; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all">
						<div class="cell--name fail js__info--messages">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				<? } ?>
				
				<? if ($list->inPage=='add') { ?>
				<div class="data--table">
					<form class="js__subsc--form" method="post" action="/controler/subsc/addSubsc">
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="name" class="js__subsc--name">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Group; ?>
						</div>
						<div class="cell--param">
							<select name="userCatId">
								<option value="0">----- <? echo all_users; ?> -----</option>
								<? foreach ($list->userCats as $one): ?>
								<option value="<? echo $one['userCatId']; ?>"><? echo $one['name']; ?></option>
								<? endforeach; ?>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Theme; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="theme" >
						</div>
					</div>
					<div align="center" class="sm--top">
						<? echo Text; ?>
					</div>
					<div>
						<textarea class="mceSubsc" rows="60" name="text"></textarea>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__add--subsc--button"><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail" id="infoMessage">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				<? } ?>
				
				<? if ($list->inPage=='edit') { ?>
				<div class="data--table">
					<form enctype="multipart/form-data" method="post" class="js__subsc--form">
					<input type="hidden" name="id" value="<? echo $list->subsc['id']; ?>">
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?>
						</div>	
						<div class="cell--param">
							<input type="text" name="name" class="js__subsc--name" value="<? echo $list->subsc['name']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Number; ?>
						</div>	
						<div class="cell--param">
							<input type="text" name="number" value="<? echo $list->subsc['number']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Theme; ?>
						</div>	
						<div class="cell--param">
							<input type="text" name="theme" class="js__subsc--theme" value="<? echo $list->subsc['theme']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Group; ?>
						</div>	
						<div class="cell--param">
							<select name="userCatId">
								<option value="0" <? if ($list->subsc['userCatId']==0) { echo 'selected'; } ?>>----- <? echo all_users; ?> -----</option>
								<? foreach ($list->userCats as $one): ?>
								<option value="<? echo $one['userCatId']; ?>" <? if ($list->subsc['userCatId']==$one['userCatId']) { echo 'selected'; } ?>><? echo $one['name']; ?></option>
								<? endforeach; ?>
							</select>
						</div>
					</div>
					<div class="sm--top" align="center">
							<? echo User_settings_for_emailing; ?>
					</div>
					<? foreach ($list->userParams as $one): ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo $one['name']; ?>
						</div>	
						<div class="cell--param" <? if ($one['need']==1) { echo 'data-info="1"'; } ?>>
							<? if ($one['type']=='fio') { ?>
								<input name="fio" type="text">
							<? } ?>
							<? if ($one['type']=='surname') { ?>
								<input name="surname" type="text">
							<? } ?>
							<? if ($one['type']=='phone') { ?>
								<script type="text/javascript">$(function() {$( "#usertelnumber" ).inputmask();});</script>
								<input id="userTelnumber" name="phone" data-inputmask="'alias': 'phone'"  type="text">
							<? } ?>
							<? if ($one['type']=='text') { ?>
								<input id="userParam" name="<? echo $one['userParamId']; ?>" type="text">
							<? } ?>
							<? if ($one['type']=='phoneext') { ?>
								<script type="text/javascript">$(function() {$( "#userParam<? echo $one['userParamId']; ?>" ).inputmask();});</script>
								<input id="userParam<? echo $one['userParamId']; ?>" data-inputmask="'alias': 'phone'"  name="<? echo $one['userParamId']; ?>" type="text">
							<? } ?>
							<? if ($one['type']=='checkbox') { ?>
								<input id="userParam" value="1" name="<? echo $one['userParamId']; ?>" type="checkbox">
							<? } ?>
							<? if ($one['type']=='textarea') { ?>
								<textarea id="userParam" name="<? echo $one['userParamId']; ?>" rows="<? echo $one['text']; ?>"></textarea>
							<? } ?>
							<? if ($one['type']=='radio') {
								$max = mb_substr_count($one['text'], ";"); $pos=0;
								for ($i=0;$i<$max;$i++) {$newpos = mb_strpos ($one['text'],';',$pos);if ($newpos!=$pos) {$value = mb_substr ($one['text'],$pos,$newpos-$pos);} else { $value=0; }$pos = $newpos+1;
								?>
								<div><input name="<? echo $one['id']; ?>" value="<? echo $value; ?>" type="radio"> <? echo $value; ?></div>
								<? } ?>
							<? } ?>
							<? if ($one['type']=='vibor') { ?>
								<select id="userParam" name="<? echo $one['userParamId']; ?>">
								<option value="0">все варианты</option>
								<?					
								$max = substr_count($one['text'], ";"); 
								for ($i=0;$i<$max;$i++) {
									$newpos = strpos ($one['text'],';',$pos);
									if ($newpos!=$pos) {
									$value = substr ($one['text'],$pos,$newpos-$pos);
									} else { $value=0; }
									$pos = $newpos+1;
								?>
								<option value="<? echo $value; ?>"><? echo $value; ?></option>
								<? } ?>
								</select>
							<? } ?>
						</div>
					</div>
					<? endforeach; ?>
					<div align="center" class="sm--top">
						<? echo Text; ?>
					</div>
					<div>
						<textarea class="mceSubsc" rows="60" id="js__subsc--text" name="text"><? echo $list->subsc['text']; ?></textarea>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Attach_file; ?>
						</div>	
						<div class="cell--param">
							<div class="data--text"><input type="file" name="userfile"></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Test_the_file_is_not_attached_to_the_test_mailing; ?>
						</div>
						<div class="cell--param">
							<input type="text" class="js__subsc--test--email">
						</div>
						<div class="cell--button">
							<button type="button" class="js__subsc--test--button"><? echo Send; ?></button>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__edit--subsc--button"><? echo Save; ?></button>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" data-id="<? echo $list->subsc['id']; ?>" class="js__make--subsc--button"><? echo Make_emailing; ?></button>
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
				</div>
			
	
		</div>
		<? } ?>
	</section>
</section>

