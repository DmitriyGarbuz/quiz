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
					<? echo Reviews; ?>
				</div>
				<? } ?>
				<? if ($list->inPage=='edit') { ?>
				<div class="in--center--name">
					<? echo Review; ?> <? echo from; ?> <? echo date('H:i d.m.y',$list->comment['date']); ?>
				</div>
				<div class="in--center--button">
					<div><button type="button" class="delete js__delete--button" data-id="<? echo $list->comment['commentId']; ?>" data-type="comments" data-module="Comment"><? echo Delete_; ?></button></div>
				</div>
				<? } ?>
			</div>
			<? } ?>
			
			<div class="in--center--tabs">
				<? if ($list->inPage=='list') { ?>
				<select class="js__alerts--type" data-page="comments" style="width:300px; border: 1px solid #eee;">
					<option value="1" <? if (session('commentsType')==1) { echo 'selected'; } ?>><? echo All; ?></option>
					<option value="0" <? if (session('commentsType')==0) { echo 'selected'; } ?>><? echo New_; ?></option>
					<option value="2" <? if (session('commentsType')==2) { echo 'selected'; } ?>><? echo Viewed; ?></option>
				</select>
				<? } ?>
			</div>
			
		</div>
		
		<div class="under--center--pole">
			<div class="in--shadow--block--11">
				<? if ($list->inPage=='list') { ?>
				<? if (count($list->comments)>0) { ?>
				<? foreach ($list->comments as $one): ?>
				<div class="one--list--block">
					<div class="art--list--first--line">
						<div class="linked--content">
							<div>
								<input type="checkbox" class="checkeye" id="js__change--comment--visible<? echo $one['commentId']; ?>" <? if ($one['visible']==1) { echo 'checked'; } ?> data-id="<? echo $one['commentId']; ?>" style="display:none;">
								<label class="top10" for="js__change--comment--visible<? echo $one['commentId']; ?>"></label>
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
								<a class="tablelink" href="/controler/comments/index/edit/<? echo $list->setup['ctCommentsPage']; ?>/<? echo $one['commentId']; ?>"><? echo $one['firstName']; ?></a>
							</div>
							<div>
								<? echo $one['text']; ?>
							</div>
						</div>
					</div>
					<div class="art--list--third--line">
						<div style="width:300px;">
							<? if ($one['parent']!=0) { ?>
							<script type="text/javascript">jQuery(document).ready(function($) {$(".js__change--comment--parent<? echo $one['commentId']; ?>").chosen({width: '100%',allow_single_deselect: true}).trigger("chosen:updated");});</script>
							<select class="js__change--comment--parent<? echo $one['commentId']; ?>" data-info="<? echo $one['commentId']; ?>">
								<? helper ('tree'); ?>
								<? chapterSelectCommentsctTree($list->chapters,0,0,$one['parent']); ?>
							</select>
							<? } ?>
							<? if ($one['articleId']!=0) { ?>
							<? echo '<a class="tablelink" target="_blank" href="/article/'.$one['article']['url'].'">'.$one['article']['name'].'</a>'; ?>
							<? } ?>
						</div>
						<div>
							<button class="delete js__delete--button" data-id="<? echo $one['commentId']; ?>" data-type="comments" data-module="Comment"><? echo Delete_; ?></button>
						</div>
					</div>
				</div>
				<? endforeach; ?>
				<? if ($list->coun>$list->confSet['commentsPerCt']) { ?>
				<div class="pagination">
				<? 
					$aaa = $list->coun%$list->confSet['commentsPerCt']; $list->inPages = $list->coun/$list->confSet['commentsPerCt']; $list->inPages = $list->inPages+1; 
					$j = ($list->setup['ctCommentsPage']/$list->confSet['commentsPerCt'])+1;
					$i = $j-6; $prim = $i; $max = $j+6;
					if ($max>$list->inPages) { $max=$list->inPages; }
					if ($i<1) { $i=1; }
					$rightctCommentsPage = $j*$list->confSet['commentsPerCt'];; $leftctCommentsPage = ($j-2)*$list->confSet['commentsPerCt'];;
					if ($list->setup['ctCommentsPage']!=0) { ?><div onClick="location='/controler/comments/index/list/<? echo $leftctCommentsPage; ?>'"><a href="/controler/comments/index/list/<? echo $leftctCommentsPage; ?>"><<</a></div><? }
						for ($i;$i<=$max;$i++) {
							$ctCommentsPage = ($i-1)*$list->confSet['commentsPerCt'];;
							$j = ($list->setup['ctCommentsPage']/$list->confSet['commentsPerCt'])+1;
							if ($j==$i) { echo '<div class="pagenow">'.$i.'</div>'; } else {
							if (($i!=$max)AND($i!=$prim)) { ?> <div onClick="location='/controler/comments/index/list/<? echo $ctCommentsPage; ?>'" class="pagenotnow" ><a href="/controler/comments/index/list/<? echo $ctCommentsPage; ?>"><? echo $i; ?></a></div> <?  } }
						}	
					if ($list->setup['ctCommentsPage']/$list->confSet['commentsPerCt']+2<$list->inPages) { ?><div onClick="location='/controler/comments/index/list/<? echo $rightctCommentsPage; ?>'" ><a href="/controler/comments/index/list/<? echo $rightctCommentsPage; ?>">>></a></div><? } ?>
				</div>
				<? } ?>
				<? } ?>
				<? } ?>
				
				<? if ($list->inPage=='edit') { ?>
				<div class="item--back">
					<button onClick="location='/controler/comments/index/list/<? echo $list->setup['ctCommentsPage']; ?>'"><? echo Back; ?></button>
				</div>
				<div class="data--table">
					<form method="post" action="/controler/comments/editComment">
					<div class="table--all">
						<div class="cell--name">
							<? echo Visible; ?>
						</div>
						<div class="cell--param">
							<input type="checkbox" class="checkeyewhite" name="visible" id="change--comment--visible" <? if ($list->comment['visible']==1) { echo 'checked'; } ?> data-id="<? echo $list->comment['commentId']; ?>" style="display:none;">
							<label class="top10" for="change--comment--visible"></label>
						</div>
					</div>
					<input type="hidden" name="commentId" value="<? echo $list->comment['commentId']; ?>">
					<input type="hidden" name="ctCommentsPage" value="<? echo $list->setup['ctCommentsPage']; ?>">
					<div class="table--all">
						<div class="cell--name">
							<? echo Date_; ?>
						</div>
						<div class="cell--param">
							<div class="data--text"><? echo date('H:i d-m-Y',$list->comment['date']); ?></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Fio; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="firstName" value="<? echo $list->comment['firstName']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Chapter; ?>
						</div>
						<div class="cell--param">
							<? if ($list->comment['parent']!=0) { ?>
							<script type="text/javascript">jQuery(document).ready(function($) {$(".change--comment--parent").chosen({width: '100%',allow_single_deselect: true}).trigger("chosen:updated");});</script>
							<select class="change--comment--parent" name="chapterId" data-id="<? echo $list->comment['commentId']; ?>">
								<? helper ('tree'); ?>
								<? chapterSelectCommentsctTree($list->chapters,0,0,$list->comment['parent']); ?>
							</select>
							<? } ?>
							<? if ($list->comment['articleId']!=0) { ?>
							<? $article = $this->mdl_chapters->getArticle('articleId',$list->comment['articleId']); ?>
							<div class="data--text"><? echo '<a class="tablelink" target="_blank" href="/article/'.$article['url'].'">'.$article['name'].'</a>'; ?></div>
							<? } ?>
						</div>
					</div>
					<div>
						<div>
							<textarea name="text" rows="5" class="mceAdmin"><? echo $list->comment['text'.session('languageBase')]; ?></textarea>
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

