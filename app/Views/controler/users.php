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
					<? echo Add_group; ?>
				</div>
			</div>
			<? } ?>
			
			<? if ($list->setup['ctUsersTree']!='') { ?>
			<div class="top--link--for--name">
				<div class="in--center--name">
					<? 
					$tree = substr ($list->setup['ctUsersTree'],0,-1); $tree = substr ($tree,1);
					$array = explode('||',$tree); $i=0; 
					foreach ($array as $value):
						foreach ($list->userCats as $one):
							if ($value==$one['userCatId']) {
								if ($i!=0) { echo ' > '; } $i++; echo $one['name']; break;
							}
						endforeach;
					endforeach;
					?>
				</div>
				<div class="in--center--button">
					<button class="delete js__delete--button" data-id="<? echo $list->userCat['userCatId']; ?>" data-type="users" data-module="UserCat"><? echo Delete_; ?></button>
				</div>
			</div>
			<? } ?>
			
			<? if ($list->setup['ctUsersTree']!='') { ?>
			<div class="in--center--tabs">
				<div onClick="location='/controler/users/index/edit/<? echo $list->userCat['userCatId']; ?>'" <? if ($list->inPage=='editusercat') { ?>class="tab--menu--active"<?} else { ?>class="tab--menu"<? } ?>>
					<a href="/controler/users/index/edit/<? echo $list->userCat['userCatId']; ?>"><? echo Group_settings; ?></a>
				</div>
				<? foreach ($list->userTabs as $one): ?>
				<? if ($one['type']==0) { ?>
				<div onClick="location='/controler/users/index/editusertab/<? echo $list->userCat['userCatId']; ?>/<? echo $one['userTabId']; ?>'" <? if (($list->inPage=='editusertab')AND($list->setup['ctUsersPage']==$one['userTabId'])) { ?>class="tab--menu--active"<?} else { ?>class="tab--menu"<? } ?>>
					<a href="/controler/users/index/editusertab/<? echo $list->userCat['userCatId']; ?>/<? echo $one['userTabId']; ?>"><? echo $one['name']; ?></a>
				</div>
				<? } ?>
				<? endforeach; ?>
			</div>
			<? } else { ?>
			<div class="in--center--tabs">
				<? foreach ($list->userTabs as $one): ?>
				<? if ($one['type']==0) { ?>
				<div onClick="location='/controler/users/index/editusertab/0/<? echo $one['userTabId']; ?>'" <? if (($list->inPage=='editusertab')AND($list->setup['ctUsersPage']==$one['userTabId'])AND(!isset($list->userCat['userCatId']))) { ?>class="tab--menu--active"<?} else { ?>class="tab--menu"<? } ?>>
					<a href="/controler/users/index/editusertab/0/<? echo $one['userTabId']; ?>"><? echo $one['name']; ?></a>
				</div>
				<? } ?>
				<? endforeach; ?>
			</div>
			<? } ?>
			<? if ($list->inPage=='list') { ?>
			<div class="in--search--tabs">
				<form class="js__search--form" method="post" action="/controler/users/search">
				<div class="search--line">
					<div>
						<input type="text" class="searchpole js__search--pole" name="search" placeholder="<? echo Search; ?>" value="<? if (session('ctUserSearch')!='') { echo session('ctUserSearch'); } ?>">
					</div>
					<div>
						<button type="button" class="js__search--button"><? echo Search; ?></button>
					</div>
					<div>
						<button type="button" class="delete js__unsearch--button" data-page="users"><? echo Cancel; ?></button>
					</div>
				</div>
				</form>
			</div>
			<? } ?>
			
		</div>
	
		<div class="under--center--pole">
			<div class="in--shadow--block--11">
			
				<? if ($list->inPage=='add') { ?>
				<div class="data--table">
					<form method="post" class="js__user--cat--form" action="/controler/users/addUserCat">
					<div class="table--all">
						<div class="cell--name">
							<? echo Parent_group; ?>
						</div>
						<div class="cell--param">
							<script type="text/javascript">jQuery(document).ready(function($) {$(".js__user--cat--parent").chosen({width: '100%',allow_single_deselect: true}).trigger("chosen:updated");});</script>
							<select class="js__user--cat--parent" name="parent">
								<option value="0"><? echo Parent_group; ?></option>
								<? helper('tree'); ?>
								<? userSelectCtTree($list->userCats,0,0,0); ?>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" name="name" class="js__user--cat--name">
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
							<button type="button" class="js__user--cat--button"><? echo Add; ?></button>
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
				
				<? if ($list->inPage=='list') { ?>
				<? foreach ($list->users as $one): ?>
				<div class="one--list--block">
					<div class="art--list--first--line">
						<div class="linked--content">
							<div>
								<input type="checkbox" class="checkeye" id="js__change--user--active<? echo $one['userId']; ?>" <? if ($one['active']==1) { echo 'checked'; } ?> data-id="<? echo $one['userId']; ?>" style="display:none;">
								<label class="top10" for="js__change--user--active<? echo $one['userId']; ?>"></label>
							</div>
						</div>
						<div class="linked--content">
							<div>
								<? if ($one['online']>0) { ?><img border="0" src="/admin/img/useronline.png"><?} ?>
								<? if ($one['online']==0) { ?><img border="0" src="/admin/img/useroffline.png"><?} ?>
							</div>
						</div>
					</div>
					<div class="user--list--second--line">
						<div <? if ($one['preview']=='') { ?>class="noimage"<? } else { ?>class="image--isset"<? } ?>>
							<? if ($one['preview']!='') { ?>
							<img src="/<? echo $one['preview']; ?>">
							<? } ?>
						</div>
						<div>
							<div class="some--name">
								<a class="table--link" href="/controler/user/index/edit/<? echo $one['userId']; ?>"><b><? echo $one['surname']; ?> <? echo $one['fio']; ?></b></a>
							</div>
							<div class="some--name">
								<a class="table--link" href="/controler/user/index/edit/<? echo $one['userId']; ?>"><b><? echo $one['email']; ?></b></a>
							</div>
							<div>
								<div class="data--text--user" style="text-align: left;"><? echo Phone; ?>: <b><? echo $one['phone']; ?></b></div>
								<? if ($one['entDate']>0) { ?><div class="data--text--user"><? echo Last_visit; ?>: <b><? echo date('d.m.Y',$one['entDate']); ?></b></div><? } ?>
								<div class="data--text--user"><? echo Registration_date; ?>: <b><? echo date('d.m.Y',$one['regDate']); ?></b></div>
							</div>
						</div>
					</div>
					<div class="art--list--third--line">
						<div style="width:300px;">
							<script type="text/javascript">jQuery(document).ready(function($) {$(".js__change--user--parent<? echo $one['userId']; ?>").chosen({width: '100%',allow_single_deselect: true}).trigger("chosen:updated");});</script>
							<select class="js__change--user--parent<? echo $one['userId']; ?>" data-id="<? echo $one['userId']; ?>">
								<option value="0" <? if ($one['parent']==0) { echo 'selected'; } ?>><? echo Parent_group; ?></option>
								<? userSelectCtTree($list->userCats,0,0,$one['parent']); ?>
							</select>
						</div>
						<div>
							<button type="button" class="delete js__delete--button" data-id="<? echo $one['userId']; ?>" data-type="user" data-module="User"><? echo Delete_; ?></button>
						</div>
					</div>
				</div>
				<? endforeach; ?>
				<? if ($list->coun>$list->confSet['usersPerCt']) { ?>
				<div class="pagination">
					<? 
					$aaa = $list->coun%$list->confSet['usersPerCt']; $list->inPages = $list->coun/$list->confSet['usersPerCt']; $list->inPages = $list->inPages+1; 
					$j = ($list->setup['ctUsersPage']/$list->confSet['usersPerCt'])+1;
					$i = $j-6; $prim = $i; $max = $j+6;
					if ($max>$list->inPages) { $max=$list->inPages; }
					if ($i<1) { $i=1; }
					$rightctUsersPage = $j*$list->confSet['usersPerCt']; $leftctUsersPage = ($j-2)*$list->confSet['usersPerCt'];
					if ($list->setup['ctUsersPage']!=0) { ?><div onClick="location='/controler/users/index/list/<? echo $list->setup['ctUserCat']; ?>/<? echo $leftctUsersPage; ?>'"><a href="/controler/users/index/list/<? echo $list->setup['ctUserCat']; ?>/<? echo $leftctUsersPage; ?>"><<</a></div><? }
						for ($i;$i<=$max;$i++) {
							$ctUsersPage = ($i-1)*$list->confSet['usersPerCt'];
							$j = ($list->setup['ctUsersPage']/$list->confSet['usersPerCt'])+1;
							if ($j==$i) { echo '<div class="pagenow">'.$i.'</div>'; } else {
							if (($i!=$max)AND($i!=$prim)) { ?> <div onClick="location='/controler/users/index/list/<? echo $list->setup['ctUserCat']; ?>/<? echo $ctUsersPage; ?>'" class="pagenotnow" ><a href="/controler/users/index/list/<? echo $list->setup['ctUserCat']; ?>/<? echo $ctUsersPage; ?>"><? echo $i; ?></a></div> <?  } }
						}	
					if ($list->setup['ctUsersPage']/$list->confSet['usersPerCt']+2<$list->inPages) { ?><div onClick="location='/controler/users/index/list/<? echo $list->setup['ctUserCat']; ?>/<? echo $rightctUsersPage; ?>'"><a href="/controler/users/index/list/<? echo $list->setup['ctUserCat']; ?>/<? echo $rightctUsersPage; ?>">>></a></div><? } ?>
				</div>
				<? } ?>
				<? } ?>
				
				<? if ($list->inPage=='edit') { ?>
				<div class="data--table">
					<form method="post" class="js__user--cat--form" action="/controler/users/editUserCat">
					<input type="hidden" name="userCatId" class="js__user--cat--id" value="<? echo $list->userCat['userCatId']; ?>">
					<div class="table--all">
						<div class="cell--name">
							<? echo Parent_group; ?>
						</div>
						<div class="cell--param">
							<script type="text/javascript">jQuery(document).ready(function($) {$(".js__user--cat--parent").chosen({width: '100%',allow_single_deselect: true}).trigger("chosen:updated");});</script>
							<select class="js__user--cat--parent" name="parent">
								<option value="0">------ <? echo Parent_group; ?> ------</option>
								<? helper ('tree'); ?>
								<? userSelectCtTree($list->userCats,0,0,$list->userCat['parent'],$list->userCat['userCatId']); ?>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" name="name" class="js__user--cat--name" value="<? echo $list->userCat['name']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Number; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="number" value="<? echo $list->userCat['number']; ?>">
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__user--cat--button"><? echo Save; ?></button>
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
				
				<? if ($list->inPage=='editusertab') { ?>
				<div class="data--table">
					<form method="post" action="/controler/users/editUserTab">
					<? if (isset($list->userCat['userCatId'])) { ?>			
					<input type="hidden" name="userCatId" value="<? echo $list->userCat['userCatId']; ?>">
					<? } else { ?>
					<input type="hidden" name="userCatId" value="0">
					<? } ?>
					<input type="hidden" name="userTabId" value="<? echo $list->userTab['userTabId']; ?>">
					<div >
						<div >
							<textarea name="text" class="mceAdmin" rows="55"><? if (isset($list->userTabData['userTabId'])) { echo $list->userTabData['text'.session('languageBase')]; } ?></textarea>
						</div>
					</div>
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
			</div>
			
	
		</div>
		<? } ?>
	</section>
</section>

