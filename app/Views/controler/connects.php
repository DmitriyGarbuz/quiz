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
					<? echo Requests; ?>
				</div>
				<? } ?>
				<? if ($list->inPage=='edit') { ?>
				<div class="in--center--name">
					<? echo Request; ?> <? echo from; ?> <? echo date('H:i d.m.y',$list->feed['date']); ?>
				</div>
				<div class="in--center--button">
					<div><button type="button" class="delete js__delete--button" data-id="<? echo $list->feed['feedId']; ?>" data-type="connects" data-module="Feed"><? echo Delete_; ?></button></div>
				</div>
				<? } ?>
			</div>
			<? } ?>	
		
			<div class="in--center--tabs">
				<? if ($list->inPage=='list') { ?>
				<select class="js__alerts--type" data-page="connects" style="width:300px; border: 1px solid #eee;">
					<option value="1" <? if (session('connectsType')==1) { echo 'selected'; } ?>><? echo All; ?></option>
					<option value="0" <? if (session('connectsType')==0) { echo 'selected'; } ?>><? echo New_; ?></option>
					<option value="2" <? if (session('connectsType')==2) { echo 'selected'; } ?>><? echo Viewed; ?></option>
				</select>
				<? } ?>
			</div>
			
		</div>
		
		<div class="under--center--pole">
			<div class="in--shadow--block--11">
			
				<? if ($list->inPage=='list') { ?>
				<? if (count($list->feeds)>0) { ?>
				<table class="all--width--list">
					<tr class="table--title">
						<td style="width:1px;">
							
						</td>
						<td>
							<? echo Communication_form; ?>
						</td>
						<td style="width:120px">
							<? echo Date_; ?>
						</td>
						<td align="center" style="width:1px;">
							
						</td>
					</tr>
					<? $rownum=0; ?>
					<? foreach ($list->feeds as $one): ?>
					<tr class="table--row<? echo $rownum; ?>">
						<td align="center">
							<input type="checkbox" class="checkeyewhite" id="js__change--feed--visible<? echo $one['feedId']; ?>" <? if ($one['visible']==1) { echo 'checked'; } ?> data-id="<? echo $one['feedId']; ?>" style="display:none;">
							<label class="top10" for="js__change--feed--visible<? echo $one['feedId']; ?>"></label>
						</td>
						<td >
							<? foreach ($list->feedbacks as $three): ?>
								<? if ($three['feedbackId']==$one['feedbackId']) { ?>
									<a class="tablelink" href="/controler/connects/index/edit/<? echo $list->setup['ctConnectsPage']; ?>/<? echo $one['feedId']; ?>"><? echo $three['name']; ?></a>
								<? } ?>
							<? endforeach; ?>
						</td>
						<td>
							<? echo date('d.m.Y H:i',$one['date']); ?>
						</td>
						<td align="center">
							<button type="button" class="deletesm js__delete--button" data-id="<? echo $one['feedId']; ?>" data-type="connects" data-module="Feed"><? echo Delete_; ?></button>
						</td>
					</tr>
					<? $rownum++; if ($rownum==2) { $rownum=0; } ?>
					<? endforeach; ?>
				</table>
				<? if ($list->coun>$list->confSet['connectsPerCt']) { ?>
				<div class="pagination">
					<? 
						$aaa = $list->coun%$list->confSet['connectsPerCt']; $list->inPages = $list->coun/$list->confSet['connectsPerCt']; $list->inPages = $list->inPages+1; 
						$j = ($list->setup['ctConnectsPage']/$list->confSet['connectsPerCt'])+1;
						$i = $j-6; $prim = $i; $max = $j+6;
						if ($max>$list->inPages) { $max=$list->inPages; }
						if ($i<1) { $i=1; }
						$rightctConnectsPage = $j*$list->confSet['connectsPerCt'];; $leftctConnectsPage = ($j-2)*$list->confSet['connectsPerCt'];;
						if ($list->setup['ctConnectsPage']!=0) { ?><div onClick="location='/controler/connects/index/list/<? echo $leftctConnectsPage; ?>'" ><a href="/controler/connects/index/list/<? echo $leftctConnectsPage; ?>"><<</a></div><? }
							for ($i;$i<=$max;$i++) {
								$ctConnectsPage = ($i-1)*$list->confSet['connectsPerCt'];;
								$j = ($list->setup['ctConnectsPage']/$list->confSet['connectsPerCt'])+1;
								if ($j==$i) { echo '<div class="pagenow">'.$i.'</div>'; } else {
								if (($i!=$max)AND($i!=$prim)) { ?> <div onClick="location='/controler/connects/index/list/<? echo $ctConnectsPage; ?>'" class="pagenotnow" ><a href="/controler/connects/index/list/<? echo $ctConnectsPage; ?>"><? echo $i; ?></a></div> <?  } }
							}	
						if ($list->setup['ctConnectsPage']/$list->confSet['connectsPerCt']+2<$list->inPages) { ?><div onClick="location='/controler/connects/index/list/<? echo $rightctConnectsPage; ?>'" ><a href="/controler/connects/index/list/<? echo $rightctConnectsPage; ?>">>></a></div><? } ?>
				</div>
				<? } ?>
				<? } ?>
				<? } ?>
				
				<? if ($list->inPage=='edit') { ?>
				<div class="item--back">
					<button type="button" onClick="location='/controler/connects/index/list/<? echo $list->setup['ctConnectsPage']; ?>'"><? echo Back; ?></button>
				</div>
				<div class="data--table">
					<div class="table--all">
						<div class="cell--name">
							<? echo ViewedOne; ?>
						</div>
						<div class="cell--param">
							<input type="checkbox" class="checkeyewhite" id="js__change--feed--visible" <? if ($list->feed['visible']==1) { echo 'checked'; } ?> data-id="<? echo $list->feed['feedId']; ?>" style="display:none;">
							<label class="top10" for="js__change--feed--visible"></label>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Date_; ?>
						</div>
						<div class="cell--param">
							<div class="data--text"><? echo date('d-m-Y H:i',$list->feed['date']); ?></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Request_from_form; ?>
						</div>
						<div class="cell--param">
							<? foreach ($list->feedbacks as $three): ?>
								<? if ($three['feedbackId']==$list->feed['feedbackId']) { ?>
									<div class="data--text"><? echo $three['name']; ?></div>
								<? } ?>
							<? endforeach; ?>
						</div>
					</div>
					<? foreach ($list->feedbackParams as $two): ?>
					<? if ($two['feedbackId']==$list->feed['feedbackId']) { ?>
					<? foreach ($list->feedParams as $three): ?>
					<? if ($three['code']==$list->feed['code']) { ?>
					<? if ($two['feedbackParamId']==$three['feedbackParamId']) { ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo $two['name'.session('languageBase')]; ?>
						</div>
						<div class="cell--param">
							<div class="data--text"><? echo $three['text']; ?></div>
						</div>
					</div>
					<? } ?>
					<? } ?>
					<? endforeach; ?>
					<? } ?>
					<? endforeach; ?>
					</div>
				</div>
				<? } ?>
				</div>
			
	
		</div>
		<? } ?>
	</section>
</section>

