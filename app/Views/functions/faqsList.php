<section class="fnc--faqs--list">
<? if (count($list->faqs)>0) { ?>
<? foreach ($list->faqs as $one): ?>
	<div class="fnc--faqs--listitem">
		<div class="fnc--faqs--listitem__main">
			<div class="fnc--faqs--listitem--main__name">
				<? echo $one['name']; ?>
			</div>
			<div class="fnc--faqs--listitem--main__date">
				<? echo date('d.m.Y',$one['date']); ?>
			</div>
		</div>
		<div class="fnc--faqs--listitem--main__text">
			<? echo $one['text']; ?>
		</div>
		<div class="fnc--faqs--listitem__answer">
			<div class="fnc--faqs--listitem--answer__name">
				<? echo $list->confLang['Answer']; ?>:
			</div>
			<div class="fnc--faqs--listitem--answer__date">
				<? echo date('d.m.Y',$one['date']); ?>
			</div>
		</div>
		<div class="fnc--faqs--listitem--answer__text">
			<? echo $one['answer']; ?>
		</div>
	</div>
<? endforeach; ?>
<? } else { ?>
<div class="no--info--find">
	<?=$list->confLang['noDataFound']; ?>
</div>
<? } ?>
</section>
