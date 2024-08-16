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
				<div onClick="location='/controler/users'" <? if ($list->setup['ctUsersTree']=='') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/users"><? echo All_users; ?> <span class="js__see--count--users" data-id="0"></span></a>
				</div>
				<? helper ('tree'); ?>
				<? usersCtTree($list->userCats,0,0,0,$list->setup['ctUsersTree']); ?>
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
					<? echo Add_user; ?>
				</div>
			</div>
			<? } ?>
			
			<? if (isset($list->user['userId'])) { ?>
			<div class="top--link--for--name">
				<div class="in--center--name">
					<? 
					$tree = substr ($list->setup['ctUsersTree'],0,-1); $tree = substr ($tree,1);
					$array = explode('||',$tree); $i=0; 
					foreach ($array as $value):
						foreach ($list->userCats as $one):
							if ($value==$one['userCatId']) {
								echo $one['name'].' > '; break;
							}
						endforeach;
					endforeach;
					echo $list->user['fio'].' '.$list->user['surname'];
					?>
				</div>
				<div class="in--center--button">
					<button class="delete js__delete--button" data-id="<? echo $list->user['userId']; ?>" data-type="user" data-module="User"><? echo Delete_; ?></button>
				</div>
			</div>
			<div class="in--center--tabs">
				<div onClick="location='/controler/user/index/edit/<? echo $list->user['userId']; ?>'" <? if ($list->inPage=='edit') { ?>class="tab--menu--active"<?} else { ?>class="tab--menu"<? } ?>>
					<a href="/controler/user/index/edit/<? echo $list->user['userId']; ?>"><? echo User_settings; ?></a>
				</div>
			</div>
			<? } ?>
			
		</div>
	
		<div class="under--center--pole">
			<div class="in--shadow--block--11">
			
				<? if ($list->inPage=='add') { ?>
				<div class="data--table">
					<form enctype="multipart/form-data" method="post" class="js__user--form" action="/controler/user/addUser">
					<input type="hidden" class="js__user--id" value="0">
					<? if ($list->confSet['needAvatar']) { ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Preview; ?>
						</div>
						<div class="cell--param">
							<div class="data--text">
							<input type="file" name="userfile">
							</div>
						</div>
					</div>
					<? } ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Active; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check"><input type="checkbox" id="js__user--active" name="active" style="display:none;"><label for="js__user--active"></label></div>
						</div>
					</div>
					<div class="table--all js__user--tr--active">
						<div class="cell--name">
							<? echo Block_reason; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="whyactive">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Parent_group; ?>
						</div>
						<div class="cell--param">
							<script type="text/javascript">jQuery(document).ready(function($) {$(".js__user--parent").chosen({width: '100%',allow_single_deselect: true}).trigger("chosen:updated");});</script>
							<select name="parent" class="js__user--parent">
								<option value="0">------ <? echo Parent_group; ?> ------</option>
								<? userSelectCtTree($list->userCats,0,0,0); ?>
							</select>
						</div>
					</div>
					<? foreach ($list->userParams as $one): ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo $one['name'.session('languageBase')]; ?> <? if ($one['need']==1) { echo '<span class="star">*</span>'; } ?>
						</div>
						<div class="cell--param" <? if ($one['need']==1) { echo 'data-need="1"'; } ?>>
							<? if ($one['type']=='fio') { ?>
								<input name="fio" type="text" class="js__user--fio" value="" >
							<? } ?>
							<? if ($one['type']=='surname') { ?>
								<input name="surname" type="text" class="js__user--surname" value="" >
							<? } ?>
							<? if ($one['type']=='phone') { ?>
								<script type="text/javascript">$(function() {$( ".js__user--phone" ).inputmask();});</script>
								<input name="phone" class="js__user--phone" type="text" data-inputmask="'alias': 'phone'"  value="">
							<? } ?>
							<? if ($one['type']=='text') { ?>
								<input class="js__user--param" name="<? echo $one['userParamId']; ?>" type="text">
							<? } ?>
							<? if ($one['type']=='date') { ?>
								<script type="text/javascript">$(function() {$( "#userUserParam<? echo $one['userParamId']; ?>" ).datepicker({ dateFormat: 'dd/mm/yy'});});</script>
								<input class="js__user--param<? echo $one['userParamId']; ?>" name="<? echo $one['userParamId']; ?>" type="text">
							<? } ?>
							<? if ($one['type']=='phoneext') { ?>
								<script type="text/javascript">$(function() {$( "#userUserParam<? echo $one['userParamId']; ?>" ).inputmask();});</script>
								<input class="js__user--param<? echo $one['userParamId']; ?>" name="<? echo $one['userParamId']; ?>" data-inputmask="'alias': 'phone'"  type="text">
							<? } ?>
							<? if ($one['type']=='checkbox') { ?>
								<div class="data--text--check">
								<input type="checkbox" id="js__user--param<? echo $one['userParamId']; ?>" value="1" name="<? echo $one['userParamId']; ?>" style="display:none;">
								<label for="js__user--param<? echo $one['userParamId']; ?>"></label>
								</div>
							<? } ?>
							<? if ($one['type']=='textarea') { ?>
								<textarea class="js__user--param" name="<? echo $one['userParamId']; ?>" rows="<? echo $one['text']; ?>"></textarea>
							<? } ?>
							<? if ($one['type']=='radio') { ?>
								<?					
								$max = substr_count($one['text'], ";");  $pos=0;
								for ($i=0;$i<$max;$i++) {
									$newpos = strpos ($one['text'],';',$pos);
									if ($newpos!=$pos) {
									$value = substr ($one['text'],$pos,$newpos-$pos);
									} else { $value=0; }
									$pos = $newpos+1;
								?>
								<div><input class="js__user--param" value="<? echo $value; ?>" name="<? echo $one['userParamId']; ?>" type="radio" <? if ($i==0) { echo ' checked '; } ?>> <? echo $value; ?></div>
								<? } ?>
							<? } ?>
							<? if ($one['type']=='vibor') { ?>
								<select class="js__user--param" name="<? echo $one['userParamId']; ?>">
								<?					
								$max = substr_count($one['text'], ";");  $pos=0;
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
					<div class="table--all">
						<div class="cell--name">
							Email <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" name="email" class="js__user--email">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Password; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" name="password" class="js__user--password">
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__user--button"><? echo Add; ?></button>
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
				
				<? if ($list->inPage=='edit') { ?>
				<div class="item--back">
					<button type="button" onClick="location='/controler/users/index/list/<? echo $list->setup['ctUserCat']; ?>/<? echo $list->setup['ctUsersPage']; ?>'"><? echo Back; ?></button>
				</div>
				<div class="data--table">
					<form enctype="multipart/form-data" method="post" class="js__user--form" action="/controler/user/editUser">
					<input type="hidden" class="js__user--id" name="userId" value="<? echo $list->user['userId']; ?>">
					<input type="hidden" name="code" value="<? echo $list->user['code']; ?>">
					<? if ($list->confSet['needAvatar']) { ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Preview; ?>
						</div>
						<div class="cell--param">
							<div class="data--text">
							<img style="max-width:200px; max-height:200px;" border="0" src="/<? echo $list->user['preview']; ?>">
							<br>
							<input type="file" name="userfile">
							</div>
						</div>
					</div>
					<? } ?>
					<div class="table--all">
						<div class="cell--name">
							Online
						</div>
						<div class="cell--param">
							<div class="data--text">
							<? if ($list->user['online']>0) { ?><img border="0" src="/admin/img/useronline.png"><?} ?>
							<? if ($list->user['online']==0) { ?><img border="0" src="/admin/img/useroffline.png"><?} ?>
							</div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Registration_date; ?>
						</div>
						<div class="cell--param">
							<div class="data--text"><? echo date('H:i d.m.Y',$list->user['regDate']); ?></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Last_visit_date; ?>
						</div>
						<div class="cell--param">
							<div class="data--text"><? if ($list->user['entDate']>0) { echo date('H:i d.m.Y',$list->user['entDate']); } ?></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Code; ?>
						</div>
						<div class="cell--param">
							<div class="data--text"><? echo $list->user['code']; ?></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Active; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check">
							<input type="checkbox" id="js__user--active" name="active" <? if ($list->user['active']==1) { echo 'checked'; } ?> style="display:none;">
							<label for="js__user--active"></label>
							</div>
						</div>
					</div>
					<div class="table--all js__user--tr--active" <? if ($list->user['active']==1) { echo 'style="display:none;"'; } ?>>
						<div class="cell--name">
							<? echo Block_reason; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="whyactive" value="<? echo $list->user['whyactive'.session('languageBase')]; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Parent_group; ?>
						</div>
						<div class="cell--param">
							<script type="text/javascript">jQuery(document).ready(function($) {$(".js__user--parent").chosen({width: '100%',allow_single_deselect: true}).trigger("chosen:updated");});</script>
							<select class="js__user--parent" name="parent">
								<option value="0" <? if ($list->user['parent']==0) { echo 'selected'; } ?>><? echo Parent_group; ?></option>
								<? userSelectCtTree($list->userCats,0,0,$list->user['parent']); ?>
							</select>
						</div>
					</div>
					<? foreach ($list->userParams as $one): ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo $one['name'.session('languageBase')]; ?> <? if ($one['need']==1) { echo '<span class="star">*</span>'; } ?>
						</div>
						<div class="cell--param" <? if ($one['need']==1) { echo 'data-need="1"'; } ?>>
							<? if ($one['type']=='fio') { ?>
								<input name="fio" type="text" class="js__user--fio" value="<? echo $list->user['fio']; ?>" >
							<? } ?>
							<? if ($one['type']=='surname') { ?>
								<input name="surname" type="text" class="js__user--surname" value="<? echo $list->user['surname']; ?>" >
							<? } ?>
							<? if ($one['type']=='phone') { ?>
								<script type="text/javascript">$(function() {$( ".js__user--phone" ).inputmask();});</script>
								<input name="phone" class="js__user--phone" type="text" data-inputmask="'alias': 'phone'"  value="<? echo $list->user['phone']; ?>">
							<? } ?>
							<? if ($one['type']=='text') { ?>
								<input class="js__user--param" name="<? echo $one['userParamId']; ?>" type="text" <? foreach ($list->userDatas as $two): if (($two['userParamId']==$one['userParamId'])AND($two['code']==$list->user['code'])) { echo 'value="'.$two['text'].'"'; } endforeach; ?>>
							<? } ?>
							<? if ($one['type']=='date') { ?>
								<script type="text/javascript">$(function() {$( "#userUserParam<? echo $one['userParamId']; ?>" ).datepicker({ dateFormat: 'dd/mm/yy'});});</script>
								<input class="js__user--param<? echo $one['userParamId']; ?>" name="<? echo $one['userParamId']; ?>" type="text" <? foreach ($list->userDatas as $two): if (($two['userParamId']==$one['userParamId'])AND($two['code']==$list->user['code'])) { echo 'value="'.$two['text'].'"'; } endforeach; ?>>
							<? } ?>
							<? if ($one['type']=='phoneext') { ?>
								<script type="text/javascript">$(function() {$( "#userUserParam<? echo $one['userParamId']; ?>" ).inputmask();});</script>
								<input class="js__user--param<? echo $one['userParamId']; ?>" name="<? echo $one['userParamId']; ?>" data-inputmask="'alias': 'phone'"  type="text" <? foreach ($list->userDatas as $two): if (($two['userParamId']==$one['userParamId'])AND($two['code']==$list->user['code'])) { echo 'value="'.$two['text'].'"'; } endforeach; ?>>
							<? } ?>
							<? if ($one['type']=='checkbox') { ?>
								<div class="data--text--check">
								<input value="1" id="js__user--param<? echo $one['userParamId']; ?>" <? foreach ($list->userDatas as $two): if (($two['userParamId']==$one['userParamId'])AND($two['code']==$list->user['code'])) { if ($two['text']=='1') { echo 'checked'; } } endforeach; ?> name="<? echo $one['id']; ?>" type="checkbox" style="display:none;">
								<label for="js__user--param<? echo $one['userParamId']; ?>"></label>
								</div>
							<? } ?>
							<? if ($one['type']=='textarea') { ?>
								<textarea class="js__user--param" name="<? echo $one['userParamId']; ?>" rows="<? echo $one['text']; ?>"><? foreach ($list->userDatas as $two): if (($two['userParamId']==$one['userParamId'])AND($two['code']==$list->user['code'])) { echo str_replace('<br>','',$two['text']); } endforeach; ?></textarea>
							<? } ?>
							<? if ($one['type']=='radio') { ?>
								<?					
								$max = substr_count($one['text'], ";"); $pos=0;
								for ($i=0;$i<$max;$i++) {
									$newpos = strpos ($one['text'],';',$pos);
									if ($newpos!=$pos) {
									$value = substr ($one['text'],$pos,$newpos-$pos);
									} else { $value=0; }
									$pos = $newpos+1;
								?>
								<div><input value="<? echo $value; ?>" class="js__user--param" <? foreach ($list->userDatas as $two): if (($two['userParamId']==$one['userParamId'])AND($two['code']==$list->user['code'])AND($two['text']==$value)) { echo 'checked'; } endforeach; ?> name="<? echo $one['userParamId']; ?>" type="radio"> <? echo $value; ?></div>
								<? } ?>
							<? } ?>
							<? if ($one['type']=='vibor') { ?>
								<select class="js__user--param" name="<? echo $one['userParamId']; ?>">
								<?					
								$max = substr_count($one['text'], ";"); $pos=0;
								for ($i=0;$i<$max;$i++) {
									$newpos = strpos ($one['text'],';',$pos);
									if ($newpos!=$pos) {
									$value = substr ($one['text'],$pos,$newpos-$pos);
									} else { $value=0; }
									$pos = $newpos+1;
								?>
								<option value="<? echo $value; ?>" <? foreach ($list->userDatas as $two): if (($two['userParamId']==$one['userParamId'])AND($two['code']==$list->user['code'])AND($two['text']==$value)) { echo 'selected'; } endforeach; ?>><? echo $value; ?></option>
								<? } ?>
								</select>
							<? } ?>
						</div>
					</div>
					<? endforeach; ?>
					<div class="table--all">
						<div class="cell--name">
							Email <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" class="js__user--email" name="email" value="<? echo $list->user['email']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Password; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" class="js__user--password" name="password" value="<? echo $list->user['password']; ?>">
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__user--button"><? echo Save; ?></button>
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

