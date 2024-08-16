<section class="center--block">
	<? if ($list->inPage!='false') { ?>
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
				<div class="add--item--main--block--left" onClick="location='/controler/ctusers/index/add'">
					<div class="add--item--main--block--left__in">
						<div>
							<img border="0" src="/admin/img/icons/account-plus-outline.svg">
						</div>
						<div>
							<a href="/controler/ctusers/index/add"><? echo Add_admin; ?></a>
						</div>
					</div>
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
		
			<? if ($list->inPage=='add') { ?>
			<div >
				<div class="in--center--name">
					<? echo Add_admin; ?>
				</div>
			</div>
			<? } ?>
			<? if ($list->inPage=='list') { ?>
			<div >
				<div class="in--center--name">
					<? echo Administrators; ?>
				</div>
			</div>
			<? } ?>
			
			<? if ($list->inPage=='edit') { ?>
			<div class="top--link--for--name">
				<div class="in--center--name">
					<? echo Edit_admin; ?> > <? echo $list->ctUser['name']; ?>
				</div>
				<div class="in--center--button">
					<button class="delete js__user--control--delete--button" data-id="<? echo $list->ctUser['ctUserId']; ?>" data-type="ctusers" data-module="CtUser"><? echo Delete_; ?></button>
				</div>
			</div>
			<? } ?>
		</div>
	
		<div class="under--center--pole" style="">
			<div class="in--shadow--block--11">

				<? if ($list->inPage=='list') { ?>
				<table class="all--width--list">
					<tr class="table--title">
						<td>
										
						</td>
						<td>
							<? echo Name_; ?>
						</td>
						<td>
							<? echo Last_visit; ?>
						</td>
						<td>
										
						</td>
					</tr>
					<? $rownum=0; ?>
					<? foreach ($list->ctUsers as $one): ?>
					<tr class="table--row<? echo $rownum; ?>">
						<td style="width:1px">
							<? if ($one['online']>0) { ?><img border="0" src="/admin/img/useronline.png"><?} ?>
							<? if ($one['online']==0) { ?><img border="0" src="/admin/img/useroffline.png"><?} ?>
						</td>
						<td>
							<a class="table--link" href="/controler/ctusers/index/edit/<? echo $one['ctUserId']; ?>"><? echo $one['name']; ?></a>
						</td>
						<td style="width:200px">
							<? if ($one['lastVisit']!=0) { echo date('d.m.Y H:i',$one['lastVisit']); } ?>
						</td>
						<td style="width:1px">
							<button class="deletesm js__user--control--delete--button" data-id="<? echo $one['ctUserId']; ?>" data-type="ctusers" data-module="CtUser"><? echo Delete_; ?></button>
						</td>
					</tr>
					<? $rownum++; if ($rownum==2) { $rownum=0; } ?>
					<? endforeach; ?>
				</table>
				<? } ?>
				
				<? if ($list->inPage=='add') { ?>
				<div class="data--table" >
					<form method="post" action="/controler/ctusers/addCtUser" class="js__ct--user--form">
					<input type="hidden" class="js__ct--user--id" name="ctUserId" value="0">
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="name" class="js__ct--user--name">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Login; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="login" class="js__ct--user--login">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Password; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="password" class="js__ct--user--password">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Access; ?>
						</div>
						<div class="cell--param--column">
							<? foreach ($list->ctChapters as $one): ?>
							<div class="table--all">
								<div class="cell--name" style="width:1px !important; flex-basis:32px">
									<div class="data--text--check">
									<input type="checkbox" id="access<? echo $one['url']; ?>" name="access[]" value="<? echo $one['url']; ?>" style="display:none;">
									<label for="access<? echo $one['url']; ?>"></label>
									</div>
								</div>
								<div class="cell--param">
									<div class="data--text"><? echo $one['name'.defaultLocalePrefix]; ?></div>
								</div>
							</div>
							<? endforeach; ?>
							<div class="table--all">
								<div class="cell--name" style="width:1px !important; flex-basis:32px">
									<div class="data--text--check">
									<input type="checkbox" id="accessstats" name="access[]" value="stats" style="display:none;">
									<label for="accessstats"></label>
									</div>
								</div>
								<div class="cell--param">
									<div class="data--text"><? echo Analytics; ?></div>
								</div>
							</div>
							<div class="table--all">
								<div class="cell--name" style="width:1px !important; flex-basis:32px">
									<div class="data--text--check">
									<input type="checkbox" id="accesscallme" name="access[]" value="callme" style="display:none;">
									<label for="accesscallme"></label>
									</div>
								</div>
								<div class="cell--param">
									<div class="data--text"><? echo Calls; ?></div>
								</div>
							</div>
							<div class="table--all">
								<div class="cell--name" style="width:1px !important; flex-basis:32px">
									<div class="data--text--check">
									<input type="checkbox" id="accesscomments" name="access[]" value="comments" style="display:none;">
									<label for="accesscomments"></label>
									</div>
								</div>
								<div class="cell--param">
									<div class="data--text"><? echo Reviews; ?></div>
								</div>
							</div>
							<div class="table--all">
								<div class="cell--name" style="width:1px !important; flex-basis:32px">
									<div class="data--text--check">
									<input type="checkbox" id="accessconnects" name="access[]" value="connects" style="display:none;">
									<label for="accessconnects"></label>
									</div>
								</div>
								<div class="cell--param">
									<div class="data--text"><? echo Communication_forms; ?></div>
								</div>
							</div>
							<div class="table--all">
								<div class="cell--name" style="width:1px !important; flex-basis:32px">
									<div class="data--text--check">
									<input type="checkbox" id="accessfaq" name="access[]" value="faq" style="display:none;">
									<label for="accessfaq"></label>
									</div>
								</div>
								<div class="cell--param">
									<div class="data--text"><? echo FAQ; ?></div>
								</div>
							</div>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__user--ct--button"><? echo Add; ?></button>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full fail js__info--message">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
					</form>
				</div>
				<? } ?>
				
				<? if ($list->inPage=='edit') { ?>
				<div class="item--back">
					<button type="button" onClick="location='/controler/ctusers'"><? echo Back; ?></button>
				</div>
				<div class="data--table" >
					<form method="post" action="/controler/ctusers/editCtUser" class="js__ct--user--form">
					<input type="hidden" class="js__ct--user--id" name="ctUserId" value="<? echo $list->ctUser['ctUserId']; ?>">
					<div class="table--all">
						<div class="cell--name">
							Online
						</div>
						<div class="cell--param">
							<div class="data--text">
							<? if ($list->ctUser['online']>0) { ?><img border="0" src="/admin/img/useronline.png"><?} ?>
							<? if ($list->ctUser['online']==0) { ?><img border="0" src="/admin/img/useroffline.png"><?} ?>
							
						</div></div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Fio; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="name" class="js__ct--user--name" value="<? echo $list->ctUser['name']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Login; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="login" class="js__ct--user--login" value="<? echo $list->ctUser['login']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Password; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="password" class="js__ct--user--password" value="<? echo $list->ctUser['password']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Access; ?>
						</div>
						<div class="cell--param--column">
							<? foreach ($list->ctChapters as $one): ?>
							<div class="table--all">
								<div class="cell--name" style="width:1px !important; flex-basis:32px">
									<div class="data--text--check">
									<input type="checkbox" id="access<? echo $one['url']; ?>" name="access[]" value="<? echo $one['url']; ?>" <? if (isset($list->access[$one['url']])) { echo 'checked'; } ?> style="display:none;">
									<label for="access<? echo $one['url']; ?>"></label>
									</div>
								</div>
								<div class="cell--param">
									<div class="data--text"><? echo $one['name'.defaultLocalePrefix]; ?></div>
								</div>
							</div>
							<? endforeach; ?>
							<div class="table--all">
								<div class="cell--name" style="width:1px !important; flex-basis:32px">
									<div class="data--text--check">
									<input type="checkbox" id="accessstats" name="access[]" value="stats" <? if (isset($list->access['stats'])) { echo 'checked'; } ?> style="display:none;">
									<label for="accessstats"></label>
									</div>
								</div>
								<div class="cell--param">
									<div class="data--text"><? echo Analytics; ?></div>
								</div>
							</div>
							<div class="table--all">
								<div class="cell--name" style="width:1px !important; flex-basis:32px">
									<div class="data--text--check">
									<input type="checkbox" id="accesscallme" name="access[]" value="callme" <? if (isset($list->access['callme'])) { echo 'checked'; } ?> style="display:none;">
									<label for="accesscallme"></label>
									</div>
								</div>
								<div class="cell--param">
									<div class="data--text"><? echo Calls; ?></div>
								</div>
							</div>
							<div class="table--all">
								<div class="cell--name" style="width:1px !important; flex-basis:32px">
									<div class="data--text--check">
									<input type="checkbox" id="accesscomments" name="access[]" value="comments" <? if (isset($list->access['comments'])) { echo 'checked'; } ?> style="display:none;">
									<label for="accesscomments"></label>
									</div>
								</div>
								<div class="cell--param">
									<div class="data--text"><? echo Reviews; ?></div>
								</div>
							</div>
							<div class="table--all">
								<div class="cell--name" style="width:1px !important; flex-basis:32px">
									<div class="data--text--check">
									<input type="checkbox" id="accessconnects" name="access[]" value="connects" <? if (isset($list->access['connects'])) { echo 'checked'; } ?> style="display:none;">
									<label for="accessconnects"></label>
									</div>
								</div>
								<div class="cell--param">
									<div class="data--text"><? echo Communication_forms; ?></div>
								</div>
							</div>
							<div class="table--all">
								<div class="cell--name" style="width:1px !important; flex-basis:32px">
									<div class="data--text--check">
									<input type="checkbox" id="accessfaq" name="access[]" value="faq" <? if (isset($list->access['faq'])) { echo 'checked'; } ?> style="display:none;">
									<label for="accessfaq"></label>
									</div>
								</div>
								<div class="cell--param">
									<div class="data--text"><? echo FAQ; ?></div>
								</div>
							</div>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button"  class="js__user--ct--button"><? echo Save; ?></button>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full fail js__info--message">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
					</form>
				</div>
				<? } ?>
			</div>
			
	
		</div>
		<? } ?>
	</section>
</section>

