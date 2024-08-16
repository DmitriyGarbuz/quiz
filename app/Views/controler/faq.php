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
					<? echo Faqs; ?>
				</div>
				<? } ?>
				<? if ($list->inPage=='edit') { ?>
				<div class="in--center--name">
					<? echo Faq; ?> <? echo from; ?> <? echo date('H:i d.m.y',$list->faq['date']); ?>
				</div>
				<div class="in--center--button">
					<div><button type="button" class="delete js__delete--button" data-id="<? echo $list->faq['faqId']; ?>" data-type="faq" data-module="Faq"><? echo Delete_; ?></button></div>
				</div>
				<? } ?>
			</div>
			<? } ?>
			
			<div class="in--center--tabs">
				<? if ($list->inPage=='list') { ?>
				<select class="js__alerts--type" data-page="faq" style="width:300px; border: 1px solid #eee;">
					<option value="1" <? if (session('faqType')==1) { echo 'selected'; } ?>><? echo All; ?></option>
					<option value="0" <? if (session('faqType')==0) { echo 'selected'; } ?>><? echo New_; ?></option>
					<option value="2" <? if (session('faqType')==2) { echo 'selected'; } ?>><? echo Viewed; ?></option>
				</select>
				<? } ?>
			</div>
			
		</div>
	
		<div class="under--center--pole">
			<div class="in--shadow--block--11">
			
				<? if ($list->inPage=='list') { ?>
				<? if (count($list->faqs)>0) { ?>
				<? foreach ($list->faqs as $one): ?>
				<div class="one--list--block">
					<div class="art--list--first--line">
						<div class="linked--content">
							<div>
								<input type="checkbox" class="checkeye" id="js__change--faq--visible<? echo $one['faqId']; ?>" <? if ($one['visible']==1) { echo 'checked'; } ?> data-id="<? echo $one['faqId']; ?>" style="display:none;">
								<label class="top10" for="js__change--faq--visible<? echo $one['faqId']; ?>"></label>
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
								<a class="tablelink" href="/controler/faq/index/edit/<? echo $list->setup['ctFaqPage']; ?>/<? echo $one['faqId']; ?>"><? echo $one['firstName']; ?></a>
							</div>
							<div>
								<? echo $one['text']; ?>
							</div>
						</div>
					</div>
					<div class="art--list--third--line">
						<div style="width:300px;">
							<script type="text/javascript">jQuery(document).ready(function($) {$(".js__change--faq--parent<? echo $one['faqId']; ?>").chosen({width: '100%',allow_single_deselect: true}).trigger("chosen:updated");});</script>
							<select  class="js__change--faq--parent<? echo $one['faqId']; ?>" data-info="<? echo $one['faqId']; ?>">
								<? helper ('tree'); ?>
								<? chapterSelectFaqCtTree($list->chapters,0,0,$one['parent']); ?>
							</select>
						</div>
						<div>
							<button class="delete js__delete--button" data-id="<? echo $one['faqId']; ?>" data-type="faq" data-module="Faq"><? echo Delete_; ?></button>
						</div>
					</div>
				</div>
				<? endforeach; ?>
				<? if ($list->coun>$list->confSet['faqPerCt']) { ?>
				<div class="pagination">
					<? 
						$aaa = $list->coun%$list->confSet['faqperct']; $list->inPages = $list->coun/$list->confSet['faqperct']; $list->inPages = $list->inPages+1; 
						$j = ($list->setup['ctFaqPage']/$list->confSet['faqperct'])+1;
						$i = $j-6; $prim = $i; $max = $j+6;
						if ($max>$list->inPages) { $max=$list->inPages; }
						if ($i<1) { $i=1; }
						$rightctFaqPage = $j*$list->confSet['faqperct']; $leftctFaqPage = ($j-2)*$list->confSet['faqperct'];
						if ($list->setup['ctFaqPage']!=0) { ?><div onClick="location='/controler/faq/index/list/<? echo $leftctFaqPage; ?>'"><a href="/controler/faq/index/list/<? echo $leftctFaqPage; ?>"><<</a></div><? }
							for ($i;$i<=$max;$i++) {
								$ctFaqPage = ($i-1)*$list->confSet['faqperct'];
								$j = ($list->setup['ctFaqPage']/$list->confSet['faqperct'])+1;
								if ($j==$i) { echo '<div class="pagenow">'.$i.'</div>'; } else {
								if (($i!=$max)AND($i!=$prim)) { ?> <div onClick="location='/controler/faq/index/list/<? echo $ctFaqPage; ?>'" class="pagenotnow"><a href="/controler/faq/index/list/<? echo $ctFaqPage; ?>"><? echo $i; ?></a></div> <?  } }
							}	
						if ($list->setup['ctFaqPage']/$list->confSet['faqperct']+2<$list->inPages) { ?><div onClick="location='/controler/faq/index/list/<? echo $rightctFaqPage; ?>'" ><a  href="/controler/faq/index/list/<? echo $rightctFaqPage; ?>">>></a></div><? } ?>
				</div>
				<? } ?>
				<? } ?>
				<? } ?>
				
				<? if ($list->inPage=='edit') { ?>
				<div class="item--back">
					<button onClick="location='/controler/faq/index/list/<? echo $list->setup['ctFaqPage']; ?>'"><? echo Back; ?></button>
				</div>
				<div class="data--table">
					<form method="post" action="/controler/faq/editFaq" >
					<div class="table--all">
						<div class="cell--name">
							<? echo Visible; ?>
						</div>
						<div class="cell--param">
							<input type="checkbox" class="checkeyewhite" name="visible" id="change--faq--visible" <? if ($list->faq['visible']==1) { echo 'checked'; } ?> data-id="<? echo $list->faq['faqId']; ?>" style="display:none;">
							<label class="top10" for="change--faq--visible"></label>
						</div>
					</div>
					<input type="hidden" name="faqId" value="<? echo $list->faq['faqId']; ?>">
					<input type="hidden" name="ctFaqPage" value="<? echo $list->setup['ctFaqPage']; ?>">
					<div class="table--all">
						<div class="cell--name">
							<? echo Date_; ?>
						</div>
						<div class="cell--param">
							<div class="data--text"><? echo date('H:i d-m-Y',$list->faq['date']); ?></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Fio; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="firstName" value="<? echo $list->faq['firstName']; ?>">
						</div>
					</div>	
					<div class="table--all">
						<div class="cell--name">
							<? echo Chapter; ?>
						</div>
						<div class="cell--param">
							<script type="text/javascript">jQuery(document).ready(function($) {$(".change--faq--parent").chosen({width: '100%',allow_single_deselect: true}).trigger("chosen:updated");});</script>
							<select style="width:300px; border:1px solid #eee" class="change--faq--parent" name="chapterId" data-id="<? echo $list->faq['faqId']; ?>">
								<? helper ('tree'); ?>
								<? chapterSelectFaqCtTree($list->chapters,0,0,$list->faq['parent']); ?>
							</select>
						</div>
					</div>
					<div>
						<div>
							<textarea class="mceAdmin" name="text" rows="5"><? echo $list->faq['text']; ?></textarea>
						</div>
					</div>
					<div>
						<div align="center" class="sm--top" >
							<? echo Answer; ?>
						</div>
					</div>
					<div>
						<div>
							<textarea class="mceAdmin" name="answer" rows="10"><? echo $list->faq['answer']; ?></textarea>
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
			</div>
			
	
		</div>
		<? } ?>
	</section>
</section>

