<section class="center--block">
	<? if (($list->inPage!='situation')AND($list->inPage!='false')) { ?>
	<section class="center--block__left">
		<? echo view('/controler/newevents'); ?>
		<? if (($list->inPage!='situation')AND($list->inPage!='false')) { ?>
		<div>
			<div class="margin--top--20">
				<div class="add--item--main--block--left" onClick="location='/controler/comments'">
					<div class="add--item--main--block--left__in">
						<div>
							<img border="0" src="/admin/img/icons/forum-outline.svg">
						</div>
						<div>
							<a href="/controler/comments"><? echo New_reviews; ?></a>
						</div>
					</div>
				</div>
				<div class="add--item--main--block--left" onClick="location='/controler/faq'">
					<div class="add--item--main--block--left__in">
						<div>
							<img border="0" src="/admin/img/icons/comment-question-outline.svg">
						</div>
						<div>
							<a href="/controler/faq"><? echo New_faq; ?></a>
						</div>
					</div>
				</div>
				<div class="add--item--main--block--left" onClick="location='/controler/callme'">
					<div class="add--item--main--block--left__in">
						<div>
							<img border="0" src="/admin/img/icons/phone-in-talk.svg">
						</div>
						<div>
							<a href="/controler/callme"><? echo Ordered_calls; ?></a>
						</div>
					</div>
				</div>
				<div class="add--item--main--block--left" onClick="location='/controler/connects'">
					<div class="add--item--main--block--left__in">
						<div>
							<img border="0" src="/admin/img/icons/account-multiple-outline.svg">
						</div>
						<div>
							<a href="/controler/connects"><? echo New_requests; ?></a>
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
		
			<? if ($list->inPage!='false') { ?>
			<div class="top--link--for--name">
				<? if ($list->inPage=='list') { ?>
				<div class="in--center--name">
					<? echo Ordered_calls; ?>
				</div>
				<? } ?>
				<? if ($list->inPage=='edit') { ?>
				<div class="in--center--name">
					<? echo Ordered_call; ?> <? echo from; ?> <? echo date('H:i d.m.y',$list->callme['date']); ?>
				</div>
				<div class="in--center--button">
					<div><button type="button" class="delete js__delete--button" data-id="<? echo $list->callme['id']; ?>" data-type="callme" data-module="Callme"><? echo Delete_; ?></button></div>
				</div>
				<? } ?>
			</div>
			<? } ?>
			
			<div class="in--center--tabs">
				<? if ($list->inPage=='list') { ?>
				<select class="js__alerts--type" data-page="callme" style="width:300px; border: 1px solid #eee;">
					<option value="1" <? if (session('callmeType')==1) { echo 'selected'; } ?>><? echo All; ?></option>
					<option value="0" <? if (session('callmeType')==0) { echo 'selected'; } ?>><? echo New_; ?></option>
					<option value="2" <? if (session('callmeType')==2) { echo 'selected'; } ?>><? echo Viewed; ?></option>
				</select>
				<? } ?>
			</div>
			
		</div>
	
		<div class="under--center--pole">
			<div class="in--shadow--block--11">
	
				<? if ($list->inPage=='list') { ?>
				<? if (count($list->callme)>0) { ?>
				<? foreach ($list->callme as $one): ?>
				<div class="one--list--block">
					<div class="art--list--first--line">
						<div class="linked--content">
							<div>
								<input type="checkbox" class="checkeye" id="js__change--callme--visible<? echo $one['id']; ?>" <? if ($one['visible']==1) { echo 'checked'; } ?> data-id="<? echo $one['id']; ?>" style="display:none;">
								<label class="top10" for="js__change--callme--visible<? echo $one['id']; ?>"></label>
							</div>
						</div>
						<div class="linked--content">
							<div>
								<? echo date('H:i d.m.y',$one['date']); ?>
							</div>
						</div>
					</div>
					<div class="comments--second--line">
						<div>
							<div class="some--name">
								<a class="tablelink" href="/controler/callme/index/edit/<? echo $list->setup['ctCallmePage']; ?>/<? echo $one['id']; ?>"><? echo $one['firstName']; ?>, <? echo $one['telnumber']; ?></a>
							</div>
							<div>
								<? echo $one['text']; ?>
							</div>
						</div>
					</div>
					<div class="art--list--third--line">
						<div>
							
						</div>
						<div>
							<button class="delete js__delete--button" data-id="<? echo $one['id']; ?>" data-type="callme" data-module="Callme"><? echo Delete_; ?></button>
						</div>
					</div>
				</div>
				<? endforeach; ?>
				<? if ($list->coun>$list->confSet['callmePerCt']) { ?>
				<div class="pagination">
					<? 
						$aaa = $list->coun%$list->confSet['callmePerCt']; $list->inPages = $list->coun/$list->confSet['callmePerCt']; $list->inPages = $list->inPages+1; 
						$j = ($list->setup['ctCallmePage']/$list->confSet['callmePerCt'])+1;
						$i = $j-6; $prim = $i; $max = $j+6;
						if ($max>$list->inPages) { $max=$list->inPages; }
						if ($i<1) { $i=1; }
						$rightctCallmePage = $j*$list->confSet['callmePerCt'];; $leftctCallmePage = ($j-2)*$list->confSet['callmePerCt'];;
						if ($list->setup['ctCallmePage']!=0) { ?><div onClick="location='/controler/callme/index/list/<? echo $leftctCallmePage; ?>'" ><a href="/controler/callme/index/list/<? echo $leftctCallmePage; ?>"><<</a></div><? }
							for ($i;$i<=$max;$i++) {
								$ctCallmePage = ($i-1)*$list->confSet['callmePerCt'];;
								$j = ($list->setup['ctCallmePage']/$list->confSet['callmePerCt'])+1;
								if ($j==$i) { echo '<div class="pagenow">'.$i.'</div>'; } else {
								if (($i!=$max)AND($i!=$prim)) { ?> <div onClick="location='/controler/callme/index/list/<? echo $ctCallmePage; ?>'" class="pagenotnow" ><a class="page" href="/controler/callme/index/list/<? echo $ctCallmePage; ?>"><? echo $i; ?></a></div> <?  } }
							}	
						if ($list->setup['ctCallmePage']/$list->confSet['callmePerCt']+2<$list->inPages) { ?><div onClick="location='/controler/callme/index/list/<? echo $rightctCallmePage; ?>'" ><a  href="/controler/callme/index/list/<? echo $rightctCallmePage; ?>">>></a></div><? } ?>
					</div>
				<? } ?>
				<? } ?>
				<? } ?>
				
				<? if ($list->inPage=='edit') { ?>
				<div class="item--back">
					<button onClick="location='/controler/callme/index/list/<? echo $list->setup['ctCallmePage']; ?>'"><? echo Back; ?></button>
				</div>
				<div class="data--table">
					<div class="table--all">
						<div class="cell--name">
							<? echo ViewedOne; ?>
						</div>
						<div class="cell--param">
							<input type="checkbox" class="checkeyewhite" id="js__change--callme--visible" <? if ($list->callme['visible']==1) { echo 'checked'; } ?> data-id="<? echo $list->callme['id']; ?>" style="display:none;">
							<label class="top10" for="js__change--callme--visible"></label>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Date_; ?>
						</div>
						<div class="cell--param">
							<div class="data--text"><? echo date('H:i d-m-Y',$list->callme['date']); ?></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Fio; ?>
						</div>
						<div class="cell--param">
							<div class="data--text"><? echo $list->callme['firstName']; ?></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Phone; ?>
						</div>
						<div class="cell--param">
							<div class="data--text"><? echo $list->callme['telnumber']; ?></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Ext_information; ?>
						</div>
						<div class="cell--param">
							<div class="data--text"><? echo $list->callme['text']; ?></div>
						</div>
					</div>
				</div>
				<? } ?>
			</div>
			
	
		</div>
		<? } ?>
	</section>
</section>

