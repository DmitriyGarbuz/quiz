<!--Слайдер-->
<section class="under--header--slider">
<? if ((isset($list->banChapter['sliderleft']))AND($list->banChapter['sliderleft']!='')) { ?><div class="under--header--slider__left"><? echo $list->banChapter['sliderleft']; ?></div><? } ?>
<? if ((isset($list->sitChapter['overcenter']['funcName']))AND($list->sitChapter['overcenter']['funcName']=='slider')) { ?><div class="under--header--slider__center"><? echo view ('functions/slider',(array)$list,$list->sitChapter['overcenter']['advancedData']); ?></div><? } ?>
<? if ((isset($list->sitChapter['overcenter']['funcName']))AND(strpos($list->sitChapter['overcenter']['funcName'],'my_')!==FALSE)) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->sitChapter['overcenter']['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach; } ?>
<? if ((isset($list->banChapter['sliderright']))AND($list->banChapter['sliderright']!='')) { ?><div class="under--header--slider__right"><? echo $list->banChapter['sliderright']; ?></div><? } ?>
</section>
<!---->
<!--Контент страницы-->
<? if ((isset($list->banChapter['header']))AND($list->banChapter['header']!='')) { echo '<div class="deliver">'.$list->banChapter['header'].'</div>'; } ?>
<section class="content--center--main <? echo $list->chapter['addClass']; ?>">
	<div class="content--center--inner">
		<!--Левая колонка-->
		<? if ((isset($list->sitChapter['leftcolumn']['funcName']))AND($list->sitChapter['leftcolumn']['funcName']=='yes')) { ?>
		<section class="content--center--inner__left">
			<div class="content--center--inner--left__column">
				<!--Загрузка модулей конструктора страницы для левой колонки-->
				<? $list->pos='left'; ?>
				<? for ($col=1;$col<6;$col++) { ?>
				<? if ((isset($list->banChapter['left'.$col]))AND($list->banChapter['left'.$col]!='')) { echo '<div class="content--left__deliver">'.$list->banChapter['left'.$col].'</div>'; } ?>
				<? if ((isset($list->sitChapter['left'.$col]['funcName']))AND($list->sitChapter['left'.$col]['funcName']!='')) { ?>
				<div class="content--left__deliver">
				<? if ((isset($list->sitChapter['left'.$col]['funcName']))AND(strpos($list->sitChapter['left'.$col]['funcName'],'my_')!==FALSE)) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->sitChapter['left'.$col]['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach; 
				} else { if ((isset($list->sitChapter['left'.$col]['funcName']))AND($list->sitChapter['left'.$col]['funcName']!='')) { echo view ('functions/'.$list->sitChapter['left'.$col]['funcName'],(array)$list,$list->sitChapter['left'.$col]['advancedData']); } } ?>
				</div>
				<? } } ?>
				<? if ((isset($list->banChapter['left6']))AND($list->banChapter['left6']!='')) { echo '<div class="content--left__deliver">'.$list->banChapter['left6'].'</div>'; } ?>
				<!---->
			</div>
		</section>
		<? } ?>
		<!---->
		<!--Ценральная колонка-->
		<section class="content--center--inner__center">
			<div class="content--center--inner--center__column">
				<!--Хлебные крошки-->
				<? if ($list->chapter['breed']==1) { echo view ('functions/articleBreads',(array)$list); } ?>
				<!---->
				<!--Загрузка модулей конструктора страницы для центральной страницы колонки-->
				<? for ($col=1;$col<5;$col++) { ?>
				<? if (($col==1)OR($col==3)) { echo '<div class="content--center__separator content--center--separator__'.$col.'">'; } ?>
				<? if (((isset($list->sitChapter['center'.$col]['funcName']))AND($list->sitChapter['center'.$col]['funcName']!=''))OR((isset($list->banChapter['centerin'.$col]))AND($list->banChapter['centerin'.$col]!=''))) { ?>
				<div class="content--center__deliver content--center--deliver__<? echo $col; ?>">
					<? if ((isset($list->sitChapter['center'.$col]['funcName']))AND(strpos($list->sitChapter['center'.$col]['funcName'],'my_')!==FALSE)) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->sitChapter['center'.$col]['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach;
					} else { if ((isset($list->sitChapter['center'.$col]['funcName']))AND($list->sitChapter['center'.$col]['funcName']!='')) { echo view ('functions/'.$list->sitChapter['center'.$col]['funcName'],(array)$list,$list->sitChapter['center'.$col]['advancedData']); } }
					if (isset($list->banChapter['centerin'.$col])) { echo $list->banChapter['centerin'.$col]; }
					?>
				</div>
				<? } ?>
				<? if (($col==2)OR($col==4)) { echo '</div>'; } ?>
				<? if ($col==2) { if ((isset($list->banChapter['center1']))AND($list->banChapter['center1']!='')) { echo '<div class="content--center__deliver">'.$list->banChapter['center1'].'</div>'; } } ?>
				<? } ?>	
				<!---->
				<!--Основной контент страницы-->
				<section class="content--center--article">
					<div class="page--article--back">
						<a href="/<? echo session('Langlink'); ?><? echo session('chapterBlog'); ?><? if ($list->setup['chapterPage']>0) { echo '/page-'.$list->setup['chapterPage']; } ?>"><? echo $list->confLang['back']; ?></a>
					</div>
					<div itemscope itemtype="http://schema.org/NewsArticle">
						<meta itemscope itemprop="mainEntityOfPage"  itemType="https://schema.org/WebPage" itemid="https://google.com/article"/>
						<div class="page--article--name">
							<h1 itemprop="headline"><? echo $list->article['name'.session('Langtext')]; ?></h1>
							<div style="display:none">
								<h3 itemprop="author" itemscope itemtype="https://schema.org/Person"><span itemprop="name"><? echo $list->confSet['from'.session('Langtext')]; ?></span></h3>
								<meta itemprop="datePublished" content="<? echo date('Y-m-d',$list->article['date']); ?>"/>
								<meta itemprop="dateModified" content="<? echo date('Y-m-d',$list->article['date']); ?>"/>
							</div>
						</div>
						<div style="display:none;" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
							<img border="0" src="/<? echo $list->article['preview']; ?>" style="max-width:100%;">
							<meta itemprop="url" content="<? echo base_url().$list->article['preview']; ?>">
						</div>
						<div style="display:none;" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
							<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
								<img src="<? echo base_url(); ?><? echo $list->confSet['bglogo']; ?>"/>
								<meta itemprop="url" content="<? echo base_url(); ?><? echo $list->confSet['bglogo']; ?>">
							</div>
							<meta itemprop="name" content="<? echo $list->confSet['from'.session('Langtext')]; ?>">
						</div>
						<div class="page--article--text">
							<span itemprop="description">
								<? echo '<img src="/'.$list->article['preview'].'">'; ?>
								<? echo $list->article['text'.session('Langtext')]; ?>
							</span>
						</div>
						<div style="display:none;" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
							<meta itemprop="bestRating" content="5" />
							<meta itemprop="worstRating" content="1" />
							<span style="display:none;"> 
								<span itemprop="ratingValue"><? echo $list->article['rating']; ?></span> 
								<span itemprop="reviewCount"><? echo $list->article['rating_votes']; ?></span>) 
							</span>
						</div>
					</div>
					<? if ($list->chapter['sort']=='date') { ?><div class="page--article--date"><? echo date('d.m.Y',$list->article['date']); ?></div><? } ?>
					<div class="content--center--article__rating">
						<div data-id="<? echo $list->article['articleId']; ?>" class="fnc--addcomment--vote">
							<input type="hidden" id="commentRating" value="<? echo ceil($list->article['rating']); ?>">
							<div class="fnc--addcomment--vote__rate"><div data-type="article" <? if (count($list->artRating)==0) { ?>id="itemVote1"<? } else { echo 'style="cursor:default"'; } ?> data-id="1" class="item--vote<? if (($list->article['rating']>0)OR(count($list->artRating)==0)) { ?>--act<? } ?>"></div></div>
							<div class="fnc--addcomment--vote__rate"><div data-type="article" <? if (count($list->artRating)==0) { ?>id="itemVote2"<? } else { echo 'style="cursor:default"'; } ?> data-id="2" class="item--vote<? if (($list->article['rating']>1)OR(count($list->artRating)==0)) { ?>--act<? } ?>"></div></div>
							<div class="fnc--addcomment--vote__rate"><div data-type="article" <? if (count($list->artRating)==0) { ?>id="itemVote3"<? } else { echo 'style="cursor:default"'; } ?> data-id="3" class="item--vote<? if (($list->article['rating']>2)OR(count($list->artRating)==0)) { ?>--act<? } ?>"></div></div>
							<div class="fnc--addcomment--vote__rate"><div data-type="article" <? if (count($list->artRating)==0) { ?>id="itemVote4"<? } else { echo 'style="cursor:default"'; } ?> data-id="4" class="item--vote<? if (($list->article['rating']>3)OR(count($list->artRating)==0)) { ?>--act<? } ?>"></div></div>
							<div class="fnc--addcomment--vote__rate"><div data-type="article" <? if (count($list->artRating)==0) { ?>id="itemVote5"<? } else { echo 'style="cursor:default"'; } ?> data-id="5" class="item--vote<? if (($list->article['rating']>4)OR(count($list->artRating)==0)) { ?>--act<? } ?>"></div></div>
						</div>
					</div>
					<? if (($list->chapter['blog']==1)&&($list->article['blog']==1)) { ?>
					<div class="fnc--article--comments">
						<div class="fnc--article--comments--container"><? if (count($list->comments)>0) { helper('tree'); commentsArTree($list->comments,0,0,$list->confLang['firstName'],$list->confLang['comment'],$list->confLang['addReview'],$list->confLang['makeAnswer']); } ?></div>
						<div class="fnc--addcomment--container">
							<div class="fnc--addcomment--title"><? echo $list->confLang['addReview']; ?></div>
							<div class="fnc--addcomment--item">
								<input placeholder="<? echo $list->confLang['firstName']; ?>" type="text" class="js__addcomment--firstname" value="">
							</div>
							<div class="fnc--addcomment--item">
								<textarea placeholder="<? echo $list->confLang['comment']; ?>" rows="5" class="js__addcomment--text"></textarea>
							</div>
							<div class="fnc--addcomment--item"><div class="addcomment_button"><button type="button" data-id="<? echo $list->article['articleId']; ?>" data-parent="<? echo $list->chapter['chapterId']; ?>" class="js__addcomment--article--button"><? echo $list->confLang['addReview']; ?></button></div></div>
							<div class="fnc--addcomment--item"><div class="addcomment_info js__addcomment--info"></div></div>
						</div>
					</div>
					<? } ?>
				</section>
				<!---->
				<!--Загрузка модулей конструктора страницы для центральной страницы колонки-->
				<? for ($col=5;$col<9;$col++) { ?>
				<? if (($col==5)OR($col==7)) { echo '<div class="content--center__separator content--center--separator--'.$col.'">'; } ?>
				<? if (((isset($list->sitChapter['center'.$col]['funcName']))AND($list->sitChapter['center'.$col]['funcName']!=''))OR((isset($list->banChapter['centerin'.$col]))AND($list->banChapter['centerin'.$col]!=''))) { ?>
				<div class="content--center__deliver content--center--deliver__<? echo $col; ?>">
					<? if ((isset($list->sitChapter['center'.$col]['funcName']))AND(strpos($list->sitChapter['center'.$col]['funcName'],'my_')!==FALSE)) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->sitChapter['center'.$col]['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach;
					} else { if ((isset($list->sitChapter['center'.$col]['funcName']))AND($list->sitChapter['center'.$col]['funcName']!='')) { echo view ('functions/'.$list->sitChapter['center'.$col]['funcName'],(array)$list,$list->sitChapter['center'.$col]['advancedData']); } }
					if (isset($list->banChapter['centerin'.$col])) { echo $list->banChapter['centerin'.$col]; }
					?>
				</div>
				<? } ?>
				<? if (($col==6)OR($col==8)) { echo '</div>'; } ?>
				<? if ($col==6) { if ((isset($list->banChapter['center2']))AND($list->banChapter['center2']!='')) { echo '<div class="content--center__deliver">'.$list->banChapter['center2'].'</div>'; } } ?>
				<? } ?>	
				<!---->
			</div>
		</section>
		<!---->
		<!--Правая колонка-->
		<? if ((isset($list->sitChapter['rightcolumn']['funcName']))AND($list->sitChapter['rightcolumn']['funcName']=='yes')) { ?>
		<section class="content--center--inner__right">
			<div class="content--center--inner--right__column">
				<? $list->pos='right'; ?>
				<? for ($col=1;$col<6;$col++) { ?>
				<? if ((isset($list->banChapter['right'.$col]))AND($list->banChapter['right'.$col]!='')) { echo '<div class="content--right__deliver">'.$list->banChapter['right'.$col].'</div>'; } ?>
				<? if ((isset($list->sitChapter['right'.$col]['funcName']))AND($list->sitChapter['right'.$col]['funcName']!='')) { ?>
				<div class="content--right__deliver">
				<? if ((isset($list->sitChapter['right'.$col]['funcName']))AND(strpos($list->sitChapter['right'.$col]['funcName'],'my_')!==FALSE)) { foreach ($list->moduls as $one): if ('my_'.$one['name']==$list->sitChapter['right'.$col]['funcName']) { echo view ('moduls/'.session('Langlink').$one['name'],(array)$list); } endforeach; 
				} else { if ((isset($list->sitChapter['right'.$col]['funcName']))AND($list->sitChapter['right'.$col]['funcName']!='')) { echo view ('functions/'.$list->sitChapter['right'.$col]['funcName'],(array)$list,$list->sitChapter['right'.$col]['advancedData']); } } ?>
				</div>
				<? } } ?>
				<? if ((isset($list->banChapter['right6']))AND($list->banChapter['right6']!='')) { echo '<div class="content--right__deliver">'.$list->banChapter['right6'].'</div>'; } ?>
			</div>
		</section>
		<? } ?>
		<!--Левая колонка-->
	</div>
</section>
<!---->
<? if ((isset($list->banChapter['footer']))AND($list->banChapter['footer']!='')) { echo '<div class="content--footer__deliver">'.$list->banChapter['footer'].'</div>'; } ?>