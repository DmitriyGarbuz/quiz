<?php namespace App\Controllers\Controler;
use App\Models\CtUsers as CtUsersModel;
$CtUsersModel = new CtUsersModel;
helper('tree');
?>
<div <? if ($CtUsersModel->testCtuserLogin('stats')) {?>class="home--center--column"<? } else { ?>class="home_center--column__without"<? } ?>>
<div <? if ($CtUsersModel->testCtuserLogin('stats')) {?>class="home--leftmain"<? } else { ?>class="home--leftmain__without"<? } ?>>
	<? if ($CtUsersModel->testCtuserLogin('connects')) { ?>
	<? if (count($list->newEvents['feeds'])>0) { ?>
	<div <? if ($CtUsersModel->testCtuserLogin('stats')) {?>class="home--element__stats"<? } else { ?>class="home--element"<? } ?>>
		<div class="sm--top--color" align="center">
			<? echo New_requests; ?>
		</div>
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
			<? foreach ($list->newEvents['feeds'] as $one): ?>
			<tr class="table--row<? echo $rownum; ?>">
				<td align="center">
					<input type="checkbox" class="checkeyewhite" id="js__change--feed--visible<? echo $one['feedId']; ?>" <? if ($one['visible']==1) { echo 'checked'; } ?> data-id="<? echo $one['feedId']; ?>" style="display:none;">
					<label class="top10" for="js__change--feed--visible<? echo $one['feedId']; ?>"></label>
				</td>
				<td >
					<? foreach ($list->feedbacks as $three): ?>
						<? if ($three['feedbackId']==$one['feedbackId']) { ?>
							<a class="tablelink" href="/controler/connects/index/edit/0/<? echo $one['feedId']; ?>"><? echo $three['name']; ?></a>
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
	</div>
	<? } } ?>
	<? if ($CtUsersModel->testCtuserLogin('comments')) { ?>
	<? if (count($list->newEvents['comments'])>0) { ?>
	<div <? if ($CtUsersModel->testCtuserLogin('stats')) {?>class="home--element__stats"<? } else { ?>class="home--element"<? } ?>>
		<div class="sm--top--color" align="center">
			<? echo New_reviews; ?>
		</div>
		<? foreach ($list->newEvents['comments'] as $one): ?>
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
						<a class="table--link" href="/controler/comments/index/edit/0/<? echo $one['commentId']; ?>"><? echo $one['firstName']; ?></a>
					</div>
					<div>
						<? echo $one['text']; ?>
					</div>
				</div>
			</div>
			<div class="art--list--third--line">
				<div style="width:240px;">
					<? if ($one['parent']!=0) { ?>
					<script type="text/javascript">jQuery(document).ready(function($) {$(".js__change--comment--parent<? echo $one['commentId']; ?>").chosen({width: '100%',allow_single_deselect: true}).trigger("chosen:updated");});</script>
					<select class="js__change--comment--parent<? echo $one['commentId']; ?>" data-id="<? echo $one['commentId']; ?>">
						<? chapterSelectCommentsctTree($list->chapters,0,0,$one['parent']); ?>
					</select>
					<? } ?>
					<? if ($one['articleId']!=0) { ?>
					<? echo '<a class="tablelink" target="_blank" href="/article/'.$one['article']['url'].'">'.$one['article']['name'].'</a>'; ?>
					<? } ?>
				</div>
				<div>
					<button class="deletesm js__delete--button" data-id="<? echo $one['commentId']; ?>" data-type="comments" data-module="Comment"><? echo Delete_; ?></button>
				</div>
			</div>
		</div>
	<? endforeach; ?>
	</div>
	<? } } ?>
	<? if ($CtUsersModel->testCtuserLogin('faq')) { ?>
	<? if (count($list->newEvents['faq'])>0) { ?>
	<div <? if ($CtUsersModel->testCtuserLogin('stats')) {?>class="home--element__stats"<? } else { ?>class="home--element"<? } ?>>
		<div class="sm--top--color" align="center" >
			<? echo New_faq; ?>
		</div>
		<? foreach ($list->newEvents['faq']as $one): ?>
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
						<a class="table--link" href="/controler/faq/index/edit/0/<? echo $one['faqId']; ?>"><? echo $one['firstName']; ?></a>
					</div>
					<div>
						<? echo $one['text']; ?>
					</div>
				</div>
			</div>
			<div class="art--list--third--line">
				<div style="width:240px;">
					<script type="text/javascript">jQuery(document).ready(function($) {$(".js__change--faq--parent<? echo $one['faqId']; ?>").chosen({width: '100%',allow_single_deselect: true}).trigger("chosen:updated");});</script>
					<select  class="js__change--faq--parent<? echo $one['faqId']; ?>" data-id="<? echo $one['faqId']; ?>">
						<? chapterSelectFaqCtTree($list->chapters,0,0,$one['parent']); ?>
					</select>
				</div>
				<div>
					<button class="deletesm js__delete--button" data-id="<? echo $one['faqId']; ?>" data-type="faq" data-module="Faq"><? echo Delete_; ?></button>
				</div>
			</div>
		</div>
		<? endforeach; ?>
	</div>
	<? } } ?>
	<? if ($CtUsersModel->testCtuserLogin('callme')) { ?>
	<? if (count($list->newEvents['callme'])>0) { ?>
	<div <? if ($CtUsersModel->testCtuserLogin('stats')) {?>class="home--element__stats"<? } else { ?>class="home--element"<? } ?>>
		<div class="sm--top--color" align="center" >
			<? echo Ordered_calls; ?>
		</div>
		<? foreach ($list->newEvents['callme'] as $one): ?>
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
						<a class="tablelink" href="/controler/callme/index/edit/0/<? echo $one['id']; ?>"><? echo $one['firstName']; ?>, <? echo $one['telnumber']; ?></a>
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
					<button class="deletesm js__delete--button" data-id="<? echo $one['id']; ?>" data-type="callme" data-module="Callme"><? echo Delete_; ?></button>
				</div>
			</div>
		</div>
		<? endforeach; ?>
	</div>
	<? } } ?>
</div>
<? if ($CtUsersModel->testCtuserLogin('stats')) { ?>
<div class="home--rightmain js__need--stats" >
	<? echo view('/controler/stats'); ?>
</div>
<? } ?>
</div>

