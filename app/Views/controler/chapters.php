<section class="center--block">
	<? if (($list->inPage!='situation')AND($list->inPage!='false')) { ?>
	<section class="center--block__left">
		<?= view('/controler/newevents'); ?>
		<? if (($list->inPage!='situation')AND($list->inPage!='false')) { ?>
		<div>
			<div class="margin--top--20">
				<div class="add--item--main--block--left" onClick="location='/controler/chapters'">
					<div class="add--item--main--block--left__in">
						<div><img border="0" src="/admin/img/icons/add_kategor.svg"></div>
						<div><a href="/controler/chapters"><? echo Add_chapter; ?></a></div>
					</div>
				</div>
				<div class="add--item--main--block--left" onClick="location='/controler/notes'">
					<div class="add--item--main--block--left__in">
						<div><img border="0" src="/admin/img/icons/list.svg"></div>
						<div><a href="/controler/notes"><? echo Notes; ?></a></div>
					</div>
				</div>
			</div>
			<div class="border--top--color">
				<? helper ('tree'); 
				chaptersCtTree($list->chapters,0,0,0,$list->setup['ctChapterTree'],$list->confSet['openChaptersCt'],$list->confSet['seeNoVisibleChapters'],session('languageBase')); ?>
			</div>
		</div>
		<? } ?>
	</section>
	<? } ?>

	<section class="center--block__right" <? if (($list->inPage=='situation')OR($list->inPage=='false')) { ?>style="flex-basis: 100%;"<? } ?>>

		<? if ($list->inPage=='false') { ?>
		<div class="false--admin"><? echo You_do_not_have_permission_to_access_this_section; ?></div>
		<? } else { ?>
		<div class="under--tabs--pole">
			
			<? if ($list->inPage=='add') { ?>
			<div ><div class="in--center--name"><? echo Add_chapter; ?></div></div>
			<? } ?>
			
			<? if (($list->inPage!='add')AND($list->inPage!='false')) { ?>
			<div class="top--link--for--name">
				<div class="in--center--name">
					<? 
					$tree = substr ($list->setup['ctChapterTree'],0,-1); $tree = substr ($tree,1);
					$array = explode('||',$tree); $i=0; 
					foreach ($array as $value):
						foreach ($list->chapters as $one):
							if ($value==$one['chapterId']) {
								if ($i!=0) { echo ' > '; } $i++; echo $one['name'.session('languageBase')]; break;
							}
						endforeach;
					endforeach;
					if (($list->inPage=='artcomments')OR($list->inPage=='editarticle')) { echo ' > '.$list->article['name']; }
					?>
				</div>
				<? if (($list->inPage!='artcomments')AND($list->inPage!='editarticle')) { ?>
				<div class="in--center--button">
					<button class="delete js__delete--button" data-id="<? echo $list->chapter['chapterId']; ?>" data-type="chapters" data-module="Chapter"><? echo Delete_; ?></button>
				</div>
				<? } else { ?>
				<div class="in--center--button">
					<button class="delete js__delete--button" data-id="<? echo $list->article['articleId']; ?>" data-type="chapters" data-module="Article"><? echo Delete_; ?></button>
				</div>
				<? } ?>
			</div>
			<? } ?>
			
			<? if ($list->setup['ctChapterTree']!='') { ?>
			<div class="in--center--tabs">
				<div onClick="location='/controler/chapters/index/text/<? echo $list->chapter['chapterId']; ?>'" <? if ($list->inPage=='text') { ?>class="tab--menu--active"<?} else { ?>class="tab--menu"<? } ?>>
					<a href="/controler/chapters/index/text/<? echo $list->chapter['chapterId']; ?>" ><? echo Text; ?></a>
				</div>
				<div onClick="location='/controler/chapters/index/edit/<? echo $list->chapter['chapterId']; ?>'" <? if ($list->inPage=='edit') { ?>class="tab--menu--active"<?} else { ?>class="tab--menu"<? } ?>>
					<a href="/controler/chapters/index/edit/<? echo $list->chapter['chapterId']; ?>" ><? echo Settings; ?></a>
				</div>
				<div onClick="location='/controler/chapters/index/advanced/<? echo $list->chapter['chapterId']; ?>'" <? if ($list->inPage=='advanced') { ?>class="tab--menu--active"<?} else { ?>class="tab--menu"<? } ?>>
					<a href="/controler/chapters/index/advanced/<? echo $list->chapter['chapterId']; ?>" ><? echo Advanced_settings; ?></a>
				</div>
				<? if ($list->chapter['atView']==3) { ?>
				<div onClick="location='/controler/chapters/index/composite/<? echo $list->chapter['chapterId']; ?>'" <? if ($list->inPage=='composite') { ?>class="tab--menu--active"<?} else { ?>class="tab--menu"<? } ?>>
					<a href="/controler/chapters/index/composite/<? echo $list->chapter['chapterId']; ?>" ><? echo Composite_menu; ?></a>
				</div>
				<? } ?>
				<? foreach ($list->sitChapters as $one) { if ($one['param']=='slider') { ?>
				<div onClick="location='/controler/chapters/index/slider/<? echo $list->chapter['chapterId']; ?>'" <? if ($list->inPage=='slider') { ?>class="tab--menu--active"<?} else { ?>class="tab--menu"<? } ?>>
					<a href="/controler/chapters/index/slider/<? echo $list->chapter['chapterId']; ?>" ><? echo Slider; ?></a>
				</div>
				<? break; } } ?>
				<? if (($list->chapter['type']=='articles')OR($list->chapter['type']=='gallery')OR($list->chapter['type']=='comments')OR($list->chapter['type']=='faq')) { ?>
				<div onClick="location='/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>'" <? if (($list->inPage=='editarticle')OR($list->inPage=='list')) { ?>class="tab--menu--active"<?} else { ?>class="tab--menu"<? } ?>>
					<a href="/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>" ><? echo Items_feed; ?></a>
				</div>
				<? if ($list->chapter['type']=='articles') { ?>
				<div onClick="location='/controler/chapters/index/addarticle/<? echo $list->chapter['chapterId']; ?>'" <? if ($list->inPage=='addarticle') { ?>class="tab--menu--active"<?} else { ?>class="tab--menu"<? } ?>>
					<a href="/controler/chapters/index/addarticle/<? echo $list->chapter['chapterId']; ?>" ><? echo Add_item; ?></a>
				</div>
				<? if (($list->inPage=='editarticle')OR($list->inPage=='artcomments')) { ?>
				<div onClick="location='/controler/chapters/index/artcomments/<? echo $list->chapter['chapterId']; ?>'" <? if ($list->inPage=='artcomments') { ?>class="tab--menu--active"<?} else { ?>class="tab--menu"<? } ?>>
					<a href="/controler/chapters/index/artcomments/<? echo $list->article['articleId']; ?>" ><? echo Item_reviews; ?></a>
				</div>
				<? } ?>
				<? } ?>
				<? } ?>
				<div onClick="location='/controler/chapters/index/situation/<? echo $list->chapter['chapterId']; ?>'" <? if ($list->inPage=='situation') { ?>class="tab--menu--active"<?} else { ?>class="tab--menu"<? } ?>>
					<a href="/controler/chapters/index/situation/<? echo $list->chapter['chapterId']; ?>" ><? echo Scheme; ?></a>
				</div>
			</div>
			<? } ?>
		</div>
	
		<div class="under--center--pole">
			<div class="in--shadow--block--11">
				<? if ($list->inPage=='add') { ?>
				<div class="data--table">
					<form method="post" action="/controler/chapters/addChapter" class="js__chapter--form">
					<input type="hidden" name="chapterId" class="js__chapter--id" value="0">
					<div class="table--all">
						<div class="cell--name">
							<? echo Visible; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check"><input type="checkbox" id="js__chapter--visible" name="visible" checked style="display:none;"><label for="js__chapter--visible"></label></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Parent_chapter; ?>
						</div>
						<div class="cell--param">
							<script>$(document).ready(function() {$(".js__chapter--parent").chosen({width: '100%',allow_single_deselect: true}).trigger("chosen:updated");});</script>
							<select name="parent" class="js__chapter--parent">
								<option value="0"><? echo Parent_chapter; ?></option>
								<? chapterSelectCtTree($list->chapters,0,0,0,0,session('languageBase')); ?>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" name="name" class="js__chapter--name">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Url
						</div>
						<div class="cell--param">
							<input type="text" name="url" class="js__chapter--url">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Number; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="number" value="100">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Type; ?>
						</div>
						<div class="cell--param">
							<select name="type">
								<option value="text"><? echo Texttype; ?></option>
								<option value="articles"><? echo Items_feed; ?></option>
								<option value="gallery"><? echo Gallery; ?></option>
								<option value="comments"><? echo Reviews; ?></option>
								<option value="faq"><? echo FAQ; ?></option>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Title <span class="js__title--span title--span--bad">(0)</span>
						</div>
						<div class="cell--param">
							<input type="text" name="title" class="js__title--change" value="">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Description <span class="js__description--span title--span--bad">(0)</span>
						</div>
						<div class="cell--param">
							<textarea name="description" class="js__description--change" rows="3"></textarea>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Keywords
						</div>
						<div class="cell--param">
							<input type="text" name="keywords" value="">
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__chapter--button"><? echo Add; ?></button>
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
				<div class="data--table">
					<form method="post" action="/controler/chapters/editChapter" class="js__chapter--form">
					<input type="hidden" name="chapterId" class="js__chapter--id" value="<? echo $list->chapter['chapterId']; ?>">
					<div class="table--all">
						<div class="cell--name">
							<? echo Visible; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check">
							<input type="checkbox" id="js__chapter--visible" name="visible" <? if ($list->chapter['visible']==1) { echo 'checked'; } ?> style="display:none;">
							<label for="js__chapter--visible"></label>
							</div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Parent_chapter; ?>
						</div>
						<div class="cell--param">
							<script>jQuery(document).ready(function($) {$(".js__chapter--parent").chosen({width: '100%',allow_single_deselect: true}).trigger("chosen:updated");});</script>
							<select name="parent" class="js__chapter--parent">
								<option value="0"><? echo Parent_chapter; ?></option>
								<? chapterSelectCtTree($list->chapters,0,0,$list->chapter['parent'],$list->chapter['chapterId'],session('languageBase')); ?>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" name="name" class="js__chapter--name" value="<? echo $list->chapter['name'.session('languageBase')]; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Url
						</div>
						<div class="cell--param">
							<input type="text" name="url" class="js__chapter--url" value="<? echo $list->chapter['url']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Number; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="number" value="<? echo $list->chapter['number']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Type; ?>
						</div>
						<div class="cell--param">
							<select name="type">
								<option value="text" <? if ($list->chapter['type']=='text') { echo 'selected'; } ?>><? echo Texttype; ?></option>
								<option value="articles" <? if ($list->chapter['type']=='articles') { echo 'selected'; } ?>><? echo Items_feed; ?></option>
								<option value="gallery" <? if ($list->chapter['type']=='gallery') { echo 'selected'; } ?>><? echo Gallery; ?></option>
								<option value="comments" <? if ($list->chapter['type']=='comments') { echo 'selected'; } ?>><? echo Reviews; ?></option>
								<option value="faq" <? if ($list->chapter['type']=='faq') { echo 'selected'; } ?>><? echo FAQ; ?></option>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Title <span class="js__title--span title--span--<? if ((mb_strlen($list->chapter['title'.session('languageBase')])>0)AND(mb_strlen($list->chapter['title'.session('languageBase')])<61)) { echo 'good'; } else { echo 'bad'; } ?>">(<? echo mb_strlen($list->chapter['title'.session('languageBase')]); ?>)</span>
						</div>
						<div class="cell--param">
							<input type="text" name="title" class="js__title--change" value="<? echo $list->chapter['title'.session('languageBase')]; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Description <span class="js__description--span title--span--<? if ((mb_strlen($list->chapter['description'.session('languageBase')])>0)AND(mb_strlen($list->chapter['description'.session('languageBase')])<161)) { echo 'good'; } else { echo 'bad'; } ?>">(<? echo mb_strlen($list->chapter['description'.session('languageBase')]); ?>)</span>
						</div>
						<div class="cell--param">
							<textarea name="description" rows="3" class="js__description--change"><? echo $list->chapter['description'.session('languageBase')]; ?></textarea>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Keywords
						</div>
						<div class="cell--param">
							<input type="text" name="keywords" value="<? echo $list->chapter['keywords'.session('languageBase')]; ?>">
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__chapter--button"><? echo Save; ?></button>
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
	
				<? if ($list->inPage=='text') { ?>
				<div class="data--table">
					<div class="sm--top" align="center">
						<? echo Text_content; ?>
					</div>
					<form method="post" action="/controler/chapters/editChapterText">
					<input type="hidden" name="chapterId" class="js__chapter--id" value="<? echo $list->chapter['chapterId']; ?>">
					<div>
						<div>
							<textarea class="mceAdmin" name="text" rows="40"><? echo $list->chapter['text'.session('languageBase')]; ?></textarea>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Save; ?></button>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full fail">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
					</form>
					<div class="sm--top" align="center">
						<? echo Short_text; ?>
					</div>
					<form method="post" action="/controler/chapters/editChapterTextShort">
					<input type="hidden" name="chapterId" class="js__chapter--id" value="<? echo $list->chapter['chapterId']; ?>">
					<div>
						<div>
							<textarea class="mceAdmin" name="info" rows="20"><? echo $list->chapter['info'.session('languageBase')]; ?></textarea>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Save; ?></button>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full fail">
							<? echo session('message1'); $session = session(); $session->remove('message1'); ?>
						</div>
					</div>
					</form>
				</div>
				<? } ?>
	
				<? if ($list->inPage=='advanced') { ?>
				<div class="data--table">
					<form method="post" action="/controler/chapters/editAdvancedSettings">
					<input type="hidden" name="chapterId" class="js__chapter--id" value="<? echo $list->chapter['chapterId']; ?>">
					<div class="table--all">
						<div class="cell--name">
							HEAD
						</div>
						<div class="cell--param">
							<textarea rows="10" name="head"><? echo $list->chapter['head']; ?></textarea>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Page_template; ?>
						</div>
						<div class="cell--param">
							<select name="theme">
								<option value=""><? echo Main_template; ?></option>
								<? foreach ($list->themes as $one): ?>
								<option value="<? echo trim($one['1']); ?>" <? if (trim($list->chapter['theme'])==trim($one['1'])) { echo 'selected'; } ?>><? echo $one['1']; ?></option>
								<? endforeach; ?>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Use_for_sitemap; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check">
							<input type="checkbox" id="js__chapter--sitemap" name="sitemap" <? if ($list->chapter['sitemap']==1) { echo 'checked'; } ?> style="display:none;">
							<label for="js__chapter--sitemap"></label>
							</div>
						</div>
					</div>
					<? if ($list->chapter['sitemap']==1) { ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Change_freq; ?>
						</div>
						<div class="cell--param">
							<select name="changefreq">
								<option value="always" <? if ($list->chapter['changefreq']=='always') { echo 'selected'; } ?>>always</option>
								<option value="hourly" <? if ($list->chapter['changefreq']=='hourly') { echo 'selected'; } ?>>hourly</option>
								<option value="daily" <? if ($list->chapter['changefreq']=='daily') { echo 'selected'; } ?>>daily</option>
								<option value="weekly" <? if ($list->chapter['changefreq']=='weekly') { echo 'selected'; } ?>>weekly</option>
								<option value="monthly" <? if ($list->chapter['changefreq']=='monthly') { echo 'selected'; } ?>>monthly</option>
								<option value="yearly" <? if ($list->chapter['changefreq']=='yearly') { echo 'selected'; } ?>>yearly</option>
								<option value="never" <? if ($list->chapter['changefreq']=='never') { echo 'selected'; } ?>>never</option>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Priority; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="priority" value="<? echo $list->chapter['priority']; ?>">
						</div>
					</div>
					<? } ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Rating_count; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="rating_count" value="<? echo $list->chapter['rating_count']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Rating_votes; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="rating_votes" value="<? echo $list->chapter['rating_votes']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Bread_crumbs; ?>
						</div>
						<div class="cell--param">
							<select name="breed">
								<option value="0" <? if ($list->chapter['breed']==0) { echo 'selected'; } ?>><? echo No; ?></option>
								<option value="1" <? if ($list->chapter['breed']==1) { echo 'selected'; } ?>><? echo Yes; ?></option>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Secondary_output; ?>
						</div>
						<div class="cell--param">
							<select name="atView">
								<option value="0" <? if ($list->chapter['atView']==0) { echo 'selected'; } ?>><? echo Nothing; ?></option>
								<option value="1" <? if ($list->chapter['atView']==1) { echo 'selected'; } ?>><? echo Chapters; ?></option>
								<option value="2" <? if ($list->chapter['atView']==2) { echo 'selected'; } ?>><? echo Subchapters; ?></option>
								<option value="3" <? if ($list->chapter['atView']==3) { echo 'selected'; } ?>><? echo Composite_menu; ?></option>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Output_area; ?>
						</div>
						<div class="cell--param">
							<select name="position">
								<option value="all" <? if ($list->chapter['position']=='all') { echo 'selected'; } ?>><? echo not_limited; ?></option>
								<option value="top" <? if ($list->chapter['position']=='top') { echo 'selected'; } ?>><? echo header; ?></option>
								<option value="left" <? if ($list->chapter['position']=='left') { echo 'selected'; } ?>><? echo left_column; ?></option>
								<option value="left1" <? if ($list->chapter['position']=='left1') { echo 'selected'; } ?>><? echo left_column_ext; ?></option>
								<option value="right" <? if ($list->chapter['position']=='right') { echo 'selected'; } ?>><? echo right_column; ?></option>
								<option value="right1" <? if ($list->chapter['position']=='right1') { echo 'selected'; } ?>><? echo right_column_ext; ?></option>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Subchapters_tree; ?>
						</div>
						<div class="cell--param">
							<select name="subChapters">
								<option value="0" <? if ($list->chapter['subChapters']==0) { echo 'selected'; } ?>><? echo From_main; ?></option>
								<option value="1" <? if ($list->chapter['subChapters']==1) { echo 'selected'; } ?>><? echo From_current; ?></option>
								<option value="2" <? if ($list->chapter['subChapters']==2) { echo 'selected'; } ?>><? echo From_parent; ?></option>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Redirect; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="link" value="<? echo $list->chapter['link'.session('languageBase')]; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Additional_css_class; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="addClass" value="<? echo $list->chapter['addClass']; ?>">
						</div>
					</div>
					<? foreach ($list->sitChapters as $one) { if ($one['param']=='slider') { ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Slider_width; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="sliderWidth" value="<? echo $list->chapter['sliderWidth']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Slider_height; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="sliderHeight" value="<? echo $list->chapter['sliderHeight']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Fixed_height_width; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check">
							<input type="checkbox" id="js__slider--fix" name="sliderFix" <? if ($list->chapter['sliderFix']==1) { echo 'checked'; } ?> style="display:none;">
							<label for="js__slider--fix"></label>
							</div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo The_frequency_of_changing_the_slider_images; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="sliderFreq" value="<? echo $list->chapter['sliderFreq']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Use_for_all_chapters; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check">
							<input type="checkbox" id="js__slider--for--all" name="sliderForAll" <? if ($list->chapter['sliderForAll']==1) { echo 'checked'; } ?> style="display:none;">
							<label for="js__slider--for--all"></label>
							</div>
						</div>
					</div>
					<? break; } } ?>
					<? if (($list->chapter['atView']=='6')OR($list->chapter['type']=='topItems')OR($list->chapter['type']=='actItems')OR($list->chapter['type']=='newItems')OR($list->chapter['type']=='brands')) { ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Products_output_type; ?>
						</div>
						<div class="cell--param">
							<select name="catalogType">
								<option value="0" <? if ($list->chapter['catalogType']==0) { echo 'selected'; } ?>><? echo Vertical; ?></option>
								<option value="1" <? if ($list->chapter['catalogType']==1) { echo 'selected'; } ?>><? echo Horizontal; ?></option>
							</select>
						</div>
					</div>
					<? } ?>
					<? if (($list->chapter['type']=='articles')OR($list->chapter['type']=='gallery')OR($list->chapter['type']=='comments')OR($list->chapter['type']=='faq')) { ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Items_per_page; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="perPage" value="<? echo $list->chapter['perPage']; ?>">
						</div>
					</div>
					<? if (($list->chapter['type']=='articles')OR($list->chapter['type']=='gallery')OR($list->chapter['type']=='comments')) { ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Items_per_column; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="perPageCol" value="<? echo $list->chapter['perPageCol']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Items_per_center; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="perPageCent" value="<? echo $list->chapter['perPageCent']; ?>">
						</div>
					</div>
					<? } ?>
					<? if ($list->chapter['type']=='articles') { ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Items_sort; ?>
						</div>
						<div class="cell--param">
							<select name="sort">
								<option value="date" <? if ($list->chapter['sort']=='date') { echo 'selected'; } ?>><? echo By_date; ?></option>
								<option value="number" <? if ($list->chapter['sort']=='number') { echo 'selected'; } ?>><? echo By_number; ?></option>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Items_reviews; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check">
							<input type="checkbox" id="js__blog" name="blog" <? if ($list->chapter['blog']==1) { echo 'checked'; } ?> style="display:none;">
							<label for="js__blog"></label>
							</div>
						</div>
					</div>
					<? } ?>
					<? } ?>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Save; ?></button>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full fail">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
					</form>
					<div>
						<div class="sm--top" align="center">
							<? echo Preview; ?>
						</div>
					</div>
					<form enctype="multipart/form-data" class="js__chapter--preview--form" method="post" action="/controler/chapters/editChapterPreview">
					<input type="hidden" name="chapterId" class="js__chapter--id" value="<? echo $list->chapter['chapterId']; ?>">
					<div class="table--all">
						<div class="cell--name">
							<? echo Select_an_image; ?>
						</div>
						<div class="cell--param">
							<div class="data--text"><? if ($list->chapter['preview']!='') { ?><img style="max-width:150px; max-height:150px;" border="0" src="/<? echo $list->chapter['preview']; ?>"><br><? } ?>
							<input type="file" class="js__chapter--preview--file" name="userfile"> 
							</div>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__chapter--preview--button"><? echo Save; ?></button>
						</div>
						<? if ($list->chapter['preview']!='') { ?>
						<div class="cell--full" align="right" >
							<button type="button" class="delete js__delete--button" data-id="<? echo $list->chapter['chapterId']; ?>" data-type="chapters" data-module="ChapterPreview"><? echo Delete_; ?></button>
						</div>
						<? } ?>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail js__info1--message">
							<? echo session('message1'); $session = session(); $session->remove('message1'); ?>
						</div>
					</div>
				</div>
				<? } ?>
				
				<? if ($list->inPage=='composite') { ?>
				<div class="data--table">
					<div align="center" class="sm--top">
						<? echo Add_chapter; ?>
					</div>
					<form  method="post" action="/controler/chapters/addChapterInComposite">
					<input type="hidden" name="chapterId" value="<? echo $list->chapter['chapterId']; ?>">
					<div class="table--all">
						<div class="cell--name">
							<? echo Chapter; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<script type="text/javascript">jQuery(document).ready(function($) {$(".js__menu--id").chosen({width: '100%',allow_single_deselect: true}).trigger("chosen:updated");});</script>
							<select name="menuId" class="js__menu--id">
								<? helper ('tree'); ?>
								<? chapterSecondCtTree($list->chapters,0,0,$list->chapter['chapterId'],$list->compmenu,session('languageBase')); ?>
							</select>
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
							<button><? echo Add; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail js__info--message">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
							
				<? if (count($list->compmenu)>0) { ?>
				<table class="all--width--list">
					<tr class="table--title" >
						<td style="width:1px;">
							<? echo Number; ?>
						</td>
						<td>
							<? echo Name_; ?>
						</td>
						<td align="center" style="width:1px;">
							
						</td>
					</tr>
					<? $rownum=0; ?>
					<? foreach ($list->compmenu as $one): ?>
					<tr class="table--row<? echo $rownum; ?>">
						<td align="center">
							<input type="text" style="text-align:center;" data-id="<? echo $one['id']; ?>" class="js__change--compmenu--number" value="<? echo $one['number']; ?>">
						</td>
						<td>
							<? echo $one['chapter']['name'.session('languageBase')]; ?>
						</td>
						<td align="center">
							<button type="button" class="deletesm js__delete--button" data-id="<? echo $one['id']; ?>" data-type="chapters" data-module="CompMenu">x</button>
						</td>
					</tr>
					<? $rownum++; if ($rownum==2) { $rownum=0; } ?>
					<? endforeach; ?>
				</table>
				<? } ?>
				<? } ?>
				
				<? if ($list->inPage=='slider') { ?>
				<div class="data--table">
					<form enctype="multipart/form-data" method="post" class="js__slider--form" action="/controler/chapters/addSlider">
					<input type="hidden" name="chapterId" class="js__chapter--id" value="<? echo $list->chapter['chapterId']; ?>">
					<div class="table--all">
						<div class="cell--name">
							<? echo Select_an_image; ?> (<? echo $list->chapter['sliderWidth'];?>x<? echo $list->chapter['sliderHeight']; ?>px)
						</div>
						<div class="cell--param">
							<div class="data--text">
							<input type="file" class="js__slider--file" name="userfile"> 
							</div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Number; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="number" value="100">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Link_; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="link">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Window; ?>
						</div>
						<div class="cell--param">
							<select name="target">
								<option value="_parent"><? echo in_the_same_window; ?></option>
								<option value="_blank"><? echo in_the_new_window; ?></option>
							</select>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__slider--button"><? echo Upload; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail js__info--message">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				<? if (count($list->sliders)>0) { ?>
				<? foreach ($list->sliders as $one): ?>
				<div class="one--list--block">
					<div class="sm--top"><? echo Slider; ?> <? echo $one['number']; ?></div>
						<form method="post" action="/controler/chapters/editSlider">
						<input type="hidden" name="id" value="<? echo $one['id']; ?>">
						<input type="hidden" name="chapterId" value="<? echo $list->chapter['chapterId']; ?>">
						<div class="sliderconfig">
							<div class="sliderconfig_1">
								<div class="data--table">
									<div class="table--all">
										<div class="cell--name">
											<? echo Number; ?>
										</div>
										<div class="cell--param">
											<input type="text" value="<? echo $one['number']; ?>"  name="number">
										</div>
									</div>
									<div class="table--all">
										<div class="cell--name">
											<? echo Link_; ?>
										</div>
										<div class="cell--param">
											<input type="text" name="link" value="<? echo $one['link'.session('languageBase')]; ?>">
										</div>
									</div>
									<div class="table--all">
										<div class="cell--name">
											<? echo Window; ?>
										</div>
										<div class="cell--param">
											<select name="target" >
												<option value="_parent" <? if ($one['target']=='_parent') { echo 'selected'; } ?>><? echo in_the_same_window; ?></option>
												<option value="_blank" <? if ($one['target']=='_blank') { echo 'selected'; } ?>><? echo in_the_new_window; ?></option>
											</select>
										</div>
									</div>
									<div class="table--all">
										<div class="cell--name">
											<? echo Visible; ?>
										</div>
										<div class="cell--param">
											<input type="checkbox" class="checkeyewhite" id="changeSliderVisible<? echo $one['id']; ?>" name="visible" <? if ($one['visible']==1) { echo 'checked'; } ?> style="display:none;">
											<label class="top10" for="changeSliderVisible<? echo $one['id']; ?>"></label>
										</div>
									</div>
								</div>
							</div>
							<div class="sliderconfig_2">
								<img style="max-width:100%" border="0" src="/<? echo $one['preview']; ?>">
							</div>
						</div>
						<div class="data--table">
							<div class="table--all">
								<div class="cell--full">
									<textarea name="text" rows="20" name="text" class="mceAdmin"><? echo $one['text'.session('languageBase')]; ?></textarea>
								</div>
							</div>
							<div class="table--all--no--border">
								<div class="cell--full">
									<button><? echo Save; ?></button>
								</div>
								<div class="cell--full" align="right">
									<button type="button" class="delete js__delete--button" data-id="<? echo $one['id']; ?>" data-type="chapters" data-module="Slider"><? echo Delete_; ?></button>
								</div>
							</div>
							<div class="table--all--no--border">
								<div class="cell--full fail js__info--message1">
									<? echo session('message'.$one['id']); $session->remove('message'.$one['id']); ?>
								</div>
							</div>
						</div>
					</form>
				</div>
				<? endforeach; ?>
				<? } ?>
				<? } ?>
	
				<? if ($list->inPage=='list') { ?>
				<? if ($list->chapter['type']=='articles') { ?>
				<? foreach ($list->articles as $one): ?>
				<div class="one--list--block">
					<div class="art--list--first--line">
						<div class="linked--content">
							<div>
								<input type="checkbox" class="checkeye" id="js__change--article--visible<? echo $one['articleId']; ?>" name="changeArticleVisible" <? if ($one['visible']==1) { echo 'checked'; } ?> data-id="<? echo $one['articleId']; ?>" style="display:none;">
								<label class="top10" for="js__change--article--visible<? echo $one['articleId']; ?>"></label>
							</div>
						</div>
						<div class="linked--content">
							<? if ($list->chapter['sort']=='number') { ?>
							<div>
								<? echo Number; ?>
							</div>
							<div>
								<input type="text" style="width:80px;" class="js__change--article--number" data-id="<? echo $one['articleId']; ?>" value="<? echo $one['number']; ?>">
							</div>
							<? } ?>
							<? if ($list->chapter['sort']=='date') { ?>
							<div>
								<? echo date('H:i d.m.y',$one['date']); ?>
							</div>
							<? } ?>
						</div>
					</div>
					<div class="art--list--second--line">
						<div <? if ($one['preview']=='') { ?>style="flex-basis: 0; min-width:unset;"<? } ?>>
							<? if ($one['preview']!='') { ?>
							<a href="/controler/chapters/index/editarticle/<? echo $list->chapter['chapterId']; ?>/<? echo $one['articleId']; ?>"><img src="/<? echo $one['preview']; ?>"></a>
							<? } ?>
						</div>
						<div <? if ($one['preview']=='') { ?>style="flex-grow: 1;"<? } ?>>
							<div class="some--name">
								<a href="/controler/chapters/index/editarticle/<? echo $list->chapter['chapterId']; ?>/<? echo $one['articleId']; ?>"><? echo $one['name'.session('languageBase')]; ?></a>
							</div>
							<div>
								<? echo $one['info']; ?>
							</div>
						</div>
					</div>
					<div class="art--list--third--line">
						<div style="width:300px;">
							<script type="text/javascript">jQuery(document).ready(function($) {$(".js__change--article--parent<? echo $one['articleId']; ?>").chosen({width: '100%',allow_single_deselect: true}).trigger("chosen:updated");});</script>
							<select class="js__change--article--parent<? echo $one['articleId']; ?>" data-id="<? echo $one['articleId']; ?>">
								<? chapterSelectArticlesCtTree($list->chapters,0,0,$one['parent'],session('languageBase')); ?>
							</select>
						</div>
						<div>
							<button type="button" class="delete js__delete--button" data-id="<? echo $one['articleId']; ?>" data-type="chapters" data-module="Article"><? echo Delete_; ?></button>
						</div>
					</div>
				</div>
				<? endforeach; ?>
				<? if ($list->coun>$list->chapter['perPage']) { ?>
				<div class="pagination">
					<? 
					$aaa = $list->coun%$list->chapter['perPage']; $list->inPages = $list->coun/$list->chapter['perPage']; $list->inPages = $list->inPages+1; 
					$j = ($list->setup['ctChapterPage']/$list->chapter['perPage'])+1;
					$i = $j-6; $prim = $i; $max = $j+6;
					if ($max>$list->inPages) { $max=$list->inPages; }
					if ($i<1) { $i=1; }
					$rightctChapterPage = $j*$list->chapter['perPage']; $leftctChapterPage = ($j-2)*$list->chapter['perPage'];
					if ($list->setup['ctChapterPage']!=0) { ?><div onClick="location='/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $leftctChapterPage; ?>'"><a href="/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $leftctChapterPage; ?>"><<</a></div><? }
						for ($i;$i<=$max;$i++) {
							$ctChapterPage = ($i-1)*$list->chapter['perPage'];
							$j = ($list->setup['ctChapterPage']/$list->chapter['perPage'])+1;
							if ($j==$i) { echo '<div class="pagenow">'.$i.'</div>'; } else {
							if (($i!=$max)AND($i!=$prim)) { ?><div class="pagenotnow" onClick="location='/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $ctChapterPage; ?>'"><a href="/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $ctChapterPage; ?>"><? echo $i; ?></a></div> <?  } }
						}	
					if ($list->setup['ctChapterPage']/$list->chapter['perPage']+2<$list->inPages) { ?><div onClick="location='/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $rightctChapterPage; ?>'"><a href="/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $rightctChapterPage; ?>">>></a></div><? } ?>
				</div>
				<? } ?>
				<? } ?>
				<? if ($list->chapter['type']=='comments') { ?>
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
								<a href="/controler/comments/index/edit/0/<? echo $one['commentId']; ?>"><? echo $one['firstName']; ?></a>
							</div>
							<div>
								<? echo $one['text']; ?>
							</div>
						</div>
					</div>
					<div class="art--list--third--line">
						<div style="width:300px;">
							<script type="text/javascript">jQuery(document).ready(function($) {$(".js__change--comment--parent<? echo $one['commentId']; ?>").chosen({width: '100%',allow_single_deselect: true}).trigger("chosen:updated");});</script>
							<select class="js__change--comment--parent<? echo $one['commentId']; ?>" data-id="<? echo $one['commentId']; ?>">
								<? helper ('tree'); ?>
								<? chapterSelectCommentsctTree($list->chapters,0,0,$one['parent'],session('languageBase')); ?>
							</select>
						</div>
						<div>
							<button class="delete js__delete--button" data-id="<? echo $one['commentId']; ?>" data-type="comments" data-module="Comment"><? echo Delete_; ?></button>
						</div>
					</div>
				</div>
				<? endforeach; ?>
				<? if ($list->coun>$list->chapter['perPage']) { ?>
				<div class="pagination">
					<? 
					$aaa = $list->coun%$list->chapter['perPage']; $list->inPages = $list->coun/$list->chapter['perPage']; $list->inPages = $list->inPages+1; 
					$j = ($list->setup['ctChapterPage']/$list->chapter['perPage'])+1;
					$i = $j-6; $prim = $i; $max = $j+6;
					if ($max>$list->inPages) { $max=$list->inPages; }
					if ($i<1) { $i=1; }
					$rightctChapterPage = $j*$list->chapter['perPage']; $leftctChapterPage = ($j-2)*$list->chapter['perPage'];
					if ($list->setup['ctChapterPage']!=0) { ?><div onClick="location='/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $leftctChapterPage; ?>'"><a href="/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $leftctChapterPage; ?>"><<</a></div><? }
						for ($i;$i<=$max;$i++) {
							$ctChapterPage = ($i-1)*$list->chapter['perPage'];
							$j = ($list->setup['ctChapterPage']/$list->chapter['perPage'])+1;
							if ($j==$i) { echo '<div class="pagenow">'.$i.'</div>'; } else {
							if (($i!=$max)AND($i!=$prim)) { ?> <div class="pagenotnow" onClick="location='/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $ctChapterPage; ?>'"><a href="/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $ctChapterPage; ?>"><? echo $i; ?></a></div> <?  } }
						}	
					if ($list->setup['ctChapterPage']/$list->chapter['perPage']+2<$list->inPages) { ?><div onClick="location='/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $rightctChapterPage; ?>'"><a href="/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $rightctChapterPage; ?>">>></a></div><? } ?>
					</div>
				<? } ?>
				<? } ?>
				<? } ?>
				<? if ($list->chapter['type']=='faq') { ?>
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
								<a href="/controler/faq/index/edit/0/<? echo $one['faqId']; ?>"><? echo $one['firstName']; ?></a>
							</div>
							<div>
								<? echo $one['text']; ?>
							</div>
						</div>
					</div>
					<div class="art--list--third--line">
						<div style="width:300px;">
							<script type="text/javascript">jQuery(document).ready(function($) {$(".js__change--faq--parent<? echo $one['faqId']; ?>").chosen({width: '100%',allow_single_deselect: true}).trigger("chosen:updated");});</script>
							<select class="js__change--faq--parent<? echo $one['faqId']; ?>" data-id="<? echo $one['faqId']; ?>">
								<? helper ('tree'); ?>
								<? chapterSelectFaqCtTree($list->chapters,0,0,$one['parent'],session('languageBase')); ?>
							</select>
						</div>
						<div>
							<button class="delete js__delete--button" data-id="<? echo $one['faqId']; ?>" data-type="faq" data-module="Faq"><? echo Delete_; ?></button>
						</div>
					</div>
				</div>
				<? endforeach; ?>
				<? if ($list->coun>$list->chapter['perPage']) { ?>
				<div class="pagination">
					<? 
					$aaa = $list->coun%$list->chapter['perPage']; $list->inPages = $list->coun/$list->chapter['perPage']; $list->inPages = $list->inPages+1; 
					$j = ($list->setup['ctChapterPage']/$list->chapter['perPage'])+1;
					$i = $j-6; $prim = $i; $max = $j+6;
					if ($max>$list->inPages) { $max=$list->inPages; }
					if ($i<1) { $i=1; }
					$rightctChapterPage = $j*$list->chapter['perPage']; $leftctChapterPage = ($j-2)*$list->chapter['perPage'];
					if ($list->setup['ctChapterPage']!=0) { ?><div onClick="location='/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $leftctChapterPage; ?>'"><a href="/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $leftctChapterPage; ?>"><<</a></div><? }
						for ($i;$i<=$max;$i++) {
							$ctChapterPage = ($i-1)*$list->chapter['perPage'];
							$j = ($list->setup['ctChapterPage']/$list->chapter['perPage'])+1;
							if ($j==$i) { echo '<div class="pagenow">'.$i.'</div>'; } else {
							if (($i!=$max)AND($i!=$prim)) { ?><div class="pagenotnow" onClick="location='/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $ctChapterPage; ?>'"><a href="/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $ctChapterPage; ?>"><? echo $i; ?></a></div> <?  } }
						}	
					if ($list->setup['ctChapterPage']/$list->chapter['perPage']+2<$list->inPages) { ?><div onClick="location='/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $rightctChapterPage; ?>'"><a href="/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $rightctChapterPage; ?>">>></a></div><? } ?>
				</div>
				<? } ?>
				<? } ?>
				<? } ?>
				<? if ($list->chapter['type']=='gallery') { ?>
				<div class="data--table">
					<form enctype="multipart/form-data" method="post" class="js__gallery--form" action="/controler/chapters/addGallery">
					<input type="hidden" name="chapterId" value="<? echo $list->chapter['chapterId']; ?>">
					<div class="table--all">
						<div class="cell--name">
							<? echo Select_an_image; ?>
						</div>
						<div class="cell--param">
							<div class="data--text"><input type="file" class="js__gallery--file" name="userfile"> </div>
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
					<div class="table--all">
						<div class="cell--name">
							<? echo Sign; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="text">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Link_; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="link">
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__gallery--button"><? echo Upload; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail js__info--message">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				<? foreach ($list->gallerys as $one): ?>
				<div class="one--list--block">
					<div class="art--list--first--line" style="justify-content: right;">
						<div>
							<button class="delete js__delete--button" data-id="<? echo $one['galleryId']; ?>" data-type="chapters" data-module="Gallery"><? echo Delete_; ?></button>
						</div>
					</div>
					<div class="art--list--second--line">
						<div>
							<img border="0" src="/<? echo $one['previewsm']; ?>">
						</div>
						<div>
							<div class="data--table" align="left" style="border-top: 1px solid #e4e4e4;">
								<form enctype="multipart/form-data" method="post" action="/controler/chapters/editGallery">
								<input type="hidden" value="<? echo $one['galleryId']; ?>" name="galleryId">
								<input type="hidden" value="<? echo $list->chapter['chapterId']; ?>" name="chapterId">
								<div class="table--all">
									<div class="cell--name" style="text-align:left;">
										<? echo Chapter; ?>
									</div>
									<div class="cell--param" style="text-align:left; flex-basis: 100%;">
										<script type="text/javascript">jQuery(document).ready(function($) {$(".js__change--gallery--parent<? echo $one['galleryId']; ?>").chosen({width: '100%',allow_single_deselect: true}).trigger("chosen:updated");});</script>
										<select class="js__change--gallery--parent<? echo $one['galleryId']; ?>" name="parent">
											<? helper ('tree'); ?>
											<? chapterSelectGalleryCtTree($list->chapters,0,0,$one['parent'],session('languageBase')); ?>
										</select>
									</div>
								</div>
								<div class="table--all">
									<div class="cell--name" style="text-align:left;">
										<? echo Number; ?>
									</div>
									<div class="cell--param" style="text-align:left; flex-basis: 100%;">
										<input type="text" value="<? echo $one['number']; ?>" name="number">
									</div>
								</div>
								<div class="table--all">
									<div class="cell--name" style="text-align:left;">
										<? echo Sign; ?>
									</div>
									<div class="cell--param" style="text-align:left; flex-basis: 100%;">
										<textarea name="text" rows="3"><? echo $one['text'.session('languageBase')]; ?></textarea>
									</div>
								</div>
								<div class="table--all">
									<div class="cell--name" style="text-align:left;">
										<? echo Link_; ?>
									</div>
									<div class="cell--param" style="text-align:left; flex-basis: 100%;">
										<input type="text" name="link" value="<? echo $one['link'.session('languageBase')]; ?>">
									</div>
								</div>
								<div class="table--all--no--border">
									<div class="cell--full" style="text-align: left;">
										<button><? echo Save; ?></button>
									</div>
								</div>
								</form>
								<div class="table--all--no--border">
									<div class="cell--full fail js__info--message<? echo $one['galleryId']; ?>" style="text-align: left;">
										<? echo session('message'.$one['galleryId']); $session = session(); $session->remove('message'.$one['galleryId']); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<? endforeach; ?>
				<? if ($list->coun>$list->chapter['perPage']) { ?>
				<div class="pagination">
					<? 
					$aaa = $list->coun%$list->chapter['perPage']; $list->inPages = $list->coun/$list->chapter['perPage']; $list->inPages = $list->inPages+1; 
					$j = ($list->setup['ctChapterPage']/$list->chapter['perPage'])+1;
					$i = $j-6; $prim = $i; $max = $j+6;
					if ($max>$list->inPages) { $max=$list->inPages; }
					if ($i<1) { $i=1; }
					$rightctChapterPage = $j*$list->chapter['perPage']; $leftctChapterPage = ($j-2)*$list->chapter['perPage'];
					if ($list->setup['ctChapterPage']!=0) { ?><div onClick="location='/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $leftctChapterPage; ?>'" ><a href="/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $leftctChapterPage; ?>"><<</a></div><? }
						for ($i;$i<=$max;$i++) {
							$ctChapterPage = ($i-1)*$list->chapter['perPage'];
							$j = ($list->setup['ctChapterPage']/$list->chapter['perPage'])+1;
							if ($j==$i) { echo '<div class="pagenow">'.$i.'</div>'; } else {
							if (($i!=$max)AND($i!=$prim)) { ?> <div class="pagenotnow" onClick="location='/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $ctChapterPage; ?>'" ><a href="/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $ctChapterPage; ?>"><? echo $i; ?></a></div> <?  } }
						}	
					if ($list->setup['ctChapterPage']/$list->chapter['perPage']+2<$list->inPages) { ?><div onClick="location='/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $rightctChapterPage; ?>'" ><a href="/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $rightctChapterPage; ?>">>></a></div><? } ?>
				</div>
				<? } ?>
				<? } ?>
				<? } ?>
	
				<? if ($list->inPage=='artcomments') { ?>
				<? if (count($list->comments)>0) { ?>
				<? foreach ($list->comments as $one): ?>
				<div class="one--list--block">
					<div class="art--list--first--line">
						<div class="linked--content">
							<div>
								<input type="checkbox" class="checkeye" id="js__change--comment--visible<? echo $one['commentId']; ?>" <? if ($one['visible']==1) { echo 'checked'; } ?> data-info="<? echo $one['commentId']; ?>" style="display:none;">
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
								<a href="/controler/comments/index/edit/0/<? echo $one['commentId']; ?>"><? echo $one['firstName']; ?></a>
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
							<select class="js__change--comment--parent<? echo $one['commentId']; ?>" name="<? echo $one['commentId']; ?>">
								<? helper ('tree'); ?>
								<? chapterSelectCommentsctTree($list->chapters,0,0,$one['parent'],session('languageBase')); ?>
							</select>
							<? } ?>
							<? if ($one['articleId']!=0) { ?>
							<? echo '<a class="tablelink" target="_blank" href="/article/'.$list->article['url'].'">'.$list->article['name'].'</a>'; ?>
							<? } ?>
						</div>
						<div>
							<button class="delete js__delete--button" data-id="<? echo $one['commentId']; ?>" data-type="comments" data-module="Comment"><? echo Delete_; ?></button>
						</div>
					</div>
				</div>
				<? endforeach; ?>
				
				<? if ($list->coun>$list->chapter['perPage']) { ?>
				<div class="pagination">
					<? 
					$aaa = $list->coun%$list->chapter['perPage']; $list->inPages = $list->coun/$list->chapter['perPage']; $list->inPages = $list->inPages+1; 
					$j = ($list->setup['ctChapterPage']/$list->chapter['perPage'])+1;
					$i = $j-6; $prim = $i; $max = $j+6;
					if ($max>$list->inPages) { $max=$list->inPages; }
					if ($i<1) { $i=1; }
					$rightctChapterPage = $j*$list->chapter['perPage']; $leftctChapterPage = ($j-2)*$list->chapter['perPage'];
					if ($list->setup['ctChapterPage']!=0) { ?><div onClick="location='/controler/chapters/index/artcomments/<? echo $list->article['articleId']; ?>/<? echo $leftctChapterPage; ?>'"><a href="/controler/chapters/index/artcomments/<? echo $list->article['articleId']; ?>/<? echo $leftctChapterPage; ?>"><<</a></div><? }
						for ($i;$i<=$max;$i++) {
							$ctChapterPage = ($i-1)*$list->chapter['perPage'];
							$j = ($list->setup['ctChapterPage']/$list->chapter['perPage'])+1;
							if ($j==$i) { echo '<div class="pagenow">'.$i.'</div>'; } else {
							if (($i!=$max)AND($i!=$prim)) { ?> <div class="pagenotnow" onClick="location='/controler/chapters/index/artcomments/<? echo $list->article['articleId']; ?>/<? echo $ctChapterPage; ?>'"><a href="/controler/chapters/index/artcomments/<? echo $list->article['articleId']; ?>/<? echo $ctChapterPage; ?>"><? echo $i; ?></a></div> <?  } }
						}	
					if ($list->setup['ctChapterPage']/$list->chapter['perPage']+2<$list->inPages) { ?><div onClick="location='/controler/chapters/index/artcomments/<? echo $list->article['articleId']; ?>/<? echo $rightctChapterPage; ?>'" ><a href="/controler/chapters/index/artcomments/<? echo $list->article['articleId']; ?>/<? echo $rightctChapterPage; ?>">>></a></div><? } ?>
				</div>
				<? } ?>
				<? } ?>
				<? } ?>
	
				<? if ($list->inPage=='addarticle') { ?>
				<div class="data--table" align="left" style="border-top: 1px solid #e4e4e4;">
					<form enctype="multipart/form-data" method="post" action="/controler/chapters/addArticle" class="js__article--form">
					<input type="hidden" name="chapterId" class="js__chapter--id" value="<? echo $list->chapter['chapterId']; ?>">
					<input type="hidden" name="articleId" class="js__article--id" value="0">
					<div class="table--all">
						<div class="cell--name">
							<? echo Visible; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check"><input type="checkbox" id="js__article--visible" name="visible" style="display:none;" checked><label for="js__article--visible"></label></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" name="name" class="js__article--name">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Url
						</div>
						<div class="cell--param">
							<input type="text" name="url" class="js__article--url">
						</div>
					</div>
					<? if ($list->chapter['sort']=='number') { ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Number; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="number" value="100">
						</div>
					</div>
					<? } else { ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Publish_date; ?>
						</div>
						<div class="cell--param">
							<script type="text/javascript">$(function() {$( ".js__article--date" ).datepicker({ dateFormat: 'dd/mm/yy'});});</script>
							<input type="text" class="js__article--date" name="date" value="<? echo date('d/m/Y'); ?>" >
						</div>
					</div>
					<? } ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Preview; ?>
						</div>
						<div class="cell--param">
							<div class="data--text"><input type="file" name="userfile"></div>
						</div>
					</div>
					<div >
						<div align="center" class="sm--top" >
							<? echo Short_text; ?>
						</div>
					</div>
					<div>
						<div >
							<textarea class="mceAdmin" rows="12" name="info"></textarea>
						</div>
					</div>
					<div>
						<div align="center" class="sm--top">
							<? echo Full_text; ?>
						</div>
					</div>
					<div>
						<div >
							<textarea rows="40" class="mceAdmin" name="text"></textarea>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Title
						</div>
						<div class="cell--param">
							<textarea name="title" rows="2"></textarea>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Description
						</div>
						<div class="cell--param">
							<textarea name="description" rows="4"></textarea>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Keywords
						</div>
						<div class="cell--param">
							<textarea name="keywords" rows="6"></textarea>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__article--button"><? echo Add; ?></button>
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
				
				<? if ($list->inPage=='editarticle') { ?>
				<div class="item--back">
					<button onClick="location='/controler/chapters/index/list/<? echo $list->chapter['chapterId']; ?>/<? echo $list->setup['ctChapterPage']; ?>'"><? echo Back; ?></button>
				</div>
				<div class="data--table">
					<form enctype="multipart/form-data" method="post" action="/controler/chapters/editArticle" class="js__article--form">
					<input type="hidden" name="chapterId" class="js__chapter--id" value="<? echo $list->chapter['chapterId']; ?>">
					<input type="hidden" name="articleId" class="js__article--id" value="<? echo $list->article['articleId']; ?>">
					<div class="table--all">
						<div class="cell--name">
							<? echo Visible; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check"><input type="checkbox" id="js_article--visible" name="visible" <? if ($list->article['visible']==1) { echo 'checked'; } ?> style="display:none;"><label for="js_article--visible"></label></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" name="name" class="js__article--name" value="<? echo $list->article['name'.session('languageBase')]; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Url
						</div>
						<div class="cell--param">
							<input type="text" name="url" class="js__article--url" value="<? echo $list->article['url']; ?>">
						</div>
					</div>
					<? if ($list->chapter['sort']=='number') { ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Number; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="number" value="<? echo $list->article['number']; ?>">
						</div>
					</div>
					<? } else { ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Publish_date; ?>
						</div>
						<div class="cell--param">
							<script type="text/javascript">$(function() {$( ".js__article--date" ).datepicker({ dateFormat: 'dd/mm/yy'});});</script>
							<input type="text" class="js__article--date" name="date" value="<? echo date('d/m/Y',$list->article['date']); ?>" >
						</div>
					</div>
					<? } ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Preview; ?>
						</div>
						<div class="cell--param">
							<div class="data--text"><img style="max-width:200px; max-height:200px;" border="0" src="/<? echo $list->article['preview']; ?>">
							<br><input type="file" name="userfile"></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Rating_count; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="rating_count" value="<? echo $list->article['rating_count']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Rating_votes; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="rating_votes" value="<? echo $list->article['rating_votes']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Use_for_sitemap; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check">
							<input type="checkbox" id="js__article--sitemap" name="sitemap" <? if ($list->article['sitemap']==1) { echo 'checked'; } ?> style="display:none;">
							<label for="js__article--sitemap"></label>
							</div>
						</div>
					</div>
					<? if ($list->article['sitemap']==1) { ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Change_freq; ?>
						</div>
						<div class="cell--param">
							<select name="changefreq">
								<option value="always" <? if ($list->article['changefreq']=='always') { echo 'selected'; } ?>>always</option>
								<option value="hourly" <? if ($list->article['changefreq']=='hourly') { echo 'selected'; } ?>>hourly</option>
								<option value="daily" <? if ($list->article['changefreq']=='daily') { echo 'selected'; } ?>>daily</option>
								<option value="weekly" <? if ($list->article['changefreq']=='weekly') { echo 'selected'; } ?>>weekly</option>
								<option value="monthly" <? if ($list->article['changefreq']=='monthly') { echo 'selected'; } ?>>monthly</option>
								<option value="yearly" <? if ($list->article['changefreq']=='yearly') { echo 'selected'; } ?>>yearly</option>
								<option value="never" <? if ($list->article['changefreq']=='never') { echo 'selected'; } ?>>never</option>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Priority; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="priority" value="<? echo $list->article['priority']; ?>">
						</div>
					</div>
					<? } ?>
					<? if ($list->chapter['blog']==1) { ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Access_reviews; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check">
							<input type="checkbox" id="js__article--blog" name="blog" <? if ($list->article['blog']==1) { echo 'checked'; } ?> style="display:none;">
							<label for="js__article--blog"></label>
							</div>
						</div>
					</div>
					<? } ?>
					
					
					<div >
						<div align="center" class="sm--top" >
							<? echo Short_text; ?>
						</div>
					</div>
					<div >
						<div>
							<textarea class="mceAdmin" rows="12" name="info"><? echo $list->article['info'.session('languageBase')]; ?></textarea>
						</div>
					</div>
					<div >
						<div align="center" class="sm--top" >
							<? echo Full_text; ?>
						</div>
					</div>
					<div>
						<div>
							<textarea rows="40" class="mceAdmin" name="text"><? echo $list->article['text'.session('languageBase')]; ?></textarea>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Title
						</div>
						<div class="cell--param">
							<textarea name="title" rows="2"><? echo $list->article['title'.session('languageBase')]; ?></textarea>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Description
						</div>
						<div class="cell--param">
							<textarea name="description" rows="4"><? echo $list->article['description'.session('languageBase')]; ?></textarea>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Keywords
						</div>
						<div class="cell--param">
							<textarea name="keywords" rows="6"><? echo $list->article['keywords'.session('languageBase')]; ?></textarea>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__article--button"><? echo Save; ?></button>
						</div>
						
					</div>
					<div class="table--all--no--border">
						<div class="cell--full fail js__info-mmessage">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
					</form>
				</div>
				<? } ?>
	
				<? if ($list->inPage=='situation') { ?>
				<? $data = array ('list' => $list); ?>
				<? echo view('/controler/scheme',$data); ?>	
				<? } ?>
			</div>
			
	
		</div>
		<? } ?>
	</section>
</section>

