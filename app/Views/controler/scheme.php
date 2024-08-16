<div class="margin-top-20">
	<select class="js__change--banner--view">
		<option value="0" <? if (session('adverbannerview')==0) { echo 'selected'; } ?>>textarea</option>
		<option value="1" <? if (session('adverbannerview')==1) { echo 'selected'; } ?>>tinymce</option>
	</select>
</div>
<?
$sitchapter = array(); $banchapter = array();
foreach ($list->sitChapters as $one) { $sitchapter[$one['name']] = $one['param'].$one['bodyId']; } 
foreach ($list->banChapters as $one) { $banchapter[$one['name']] = $one['param'.session('languageBase')]; } 
$dir = APPPATH.'/Views/moduls'; $moduls = scandir($dir);
?>
<form method="post" id="situationForm">
	<input type="hidden" name="test" value="ghgfhfhf">
	<? if ($list->actPage=='chapters') { ?>
		<input type="hidden" id="id" name="id" value="<? echo $list->chapter['chapterId']; ?>">
		<input type="hidden" id="actPage" value="<? echo $list->actPage; ?>">
	<? } ?>
	<? if ($list->actPage=='notes') { ?>
		<input type="hidden" id="id" name="id" value="<? echo $list->note['noteId']; ?>">
		<input type="hidden" id="actPage" value="note">
	<? } ?>
	<? if ($list->actPage=='design') { ?>
		<input type="hidden" id="id" name="id" value="<? echo $list->setup['id']; ?>">
		<input type="hidden" id="actPage" value="<? echo $list->actPage; ?>">
	<? } ?>
	<div class="sheme">
		<div class="scheme_allheader">
			<div class="scheme_highcenter">
				<select name="highcenter" style="text-align:center">
					<option value="" <? if ((isset($sitchapter['highcenter']))AND($sitchapter['highcenter']=='')) { echo 'selected'; } ?>><? echo Empty_; ?></option>
					<option value="slider" <? if ((isset($sitchapter['highcenter']))AND($sitchapter['highcenter']=='slider')) { echo 'selected'; } ?>><? echo Slider; ?></option>
					<? foreach ($moduls as $one): if (($one!='.')AND($one!='..')AND(!is_dir(APPPATH.'Views/moduls/'.$one))) { $path_parts = pathinfo($one); ?>
					<option value="my_<? echo $path_parts['filename']; ?>" <? if ((isset($sitchapter['highcenter']))AND($sitchapter['highcenter']=='my_'.$path_parts['filename'])) { echo 'selected'; } ?>><? echo $path_parts['filename']; ?></option>
					<? } endforeach; ?>
				</select>
			</div>
			<div class="scheme_overhead">
				<? for ($col=1;$col<3;$col++) { ?>
				<div class="scheme_overhead_in">
					<select name="overhead<? echo $col; ?>" >
						<option value="" <? if ((isset($sitchapter['overhead'.$col]))AND($sitchapter['overhead'.$col]=='')) { echo 'selected'; } ?>><? echo Empty_; ?></option>
						<option value="chaptersMenu" <? if ((isset($sitchapter['overhead'.$col]))AND($sitchapter['overhead'.$col]=='chaptersMenu')) { echo 'selected'; } ?>><? echo Chapters; ?></option>
						<option value="chapterMenuSub" <? if ((isset($sitchapter['overhead'.$col]))AND($sitchapter['overhead'.$col]=='chapterMenuSub')) { echo 'selected'; } ?>><? echo Chapters_subchapters; ?></option>
						<option value="search" <? if ((isset($sitchapter['overhead'.$col]))AND($sitchapter['overhead'.$col]=='search')) { echo 'selected'; } ?>><? echo Search; ?></option>
						<option value="orderCall" <? if ((isset($sitchapter['overhead'.$col]))AND($sitchapter['overhead'.$col]=='orderCall')) { echo 'selected'; } ?>><? echo Order_call; ?></option>
						<option value="loginButtons" <? if ((isset($sitchapter['overhead'.$col]))AND($sitchapter['overhead'.$col]=='loginButtons')) { echo 'selected'; } ?>><? echo Account_buttons; ?></option>
						<option value="loginFields" <? if ((isset($sitchapter['overhead'.$col]))AND($sitchapter['overhead'.$col]=='loginFields')) { echo 'selected'; } ?>><? echo Account_fields; ?></option>
						<option value="languages" <? if ((isset($sitchapter['overhead'.$col]))AND($sitchapter['overhead'.$col]=='languages')) { echo 'selected'; } ?>><? echo Languages; ?></option>
						<? foreach ($moduls as $one): if (($one!='.')AND($one!='..')AND(!is_dir(APPPATH.'Views/moduls/'.$one))) { $path_parts = pathinfo($one); ?>
						<option value="my_<? echo $path_parts['filename']; ?>" <? if ((isset($sitchapter['overhead'.$col]))AND($sitchapter['overhead'.$col]=='my_'.$path_parts['filename'])) { echo 'selected'; } ?>><? echo $path_parts['filename']; ?></option>
						<? } endforeach; ?>
					</select>
				</div>
				<? } ?>
			</div>
			<div class="scheme_head">
				<div class="scheme_head_in1">
					<? echo Site_header; ?>
				</div>
				<div class="scheme_head_in2">
					<? for ($col=21;$col<23;$col++) { ?>
					<div>
						<select name="head<? echo $col; ?>" >
							<option value="" <? if ((isset($sitchapter['head'.$col]))AND($sitchapter['head'.$col]=='')) { echo 'selected'; } ?>><? echo Place_for_code; ?></option>
							<option value="chaptersMenu" <? if ((isset($sitchapter['head'.$col]))AND($sitchapter['head'.$col]=='chaptersMenu')) { echo 'selected'; } ?>><? echo Chapters; ?></option>
							<option value="chapterMenuSub" <? if ((isset($sitchapter['head'.$col]))AND($sitchapter['head'.$col]=='chapterMenuSub')) { echo 'selected'; } ?>><? echo Chapters_subchapters; ?></option>
							<option value="search" <? if ((isset($sitchapter['head'.$col]))AND($sitchapter['head'.$col]=='search')) { echo 'selected'; } ?>><? echo Search; ?></option>
							<option value="orderCall" <? if ((isset($sitchapter['head'.$col]))AND($sitchapter['head'.$col]=='orderCall')) { echo 'selected'; } ?>><? echo Order_call; ?></option>
							<option value="loginButtons" <? if ((isset($sitchapter['head'.$col]))AND($sitchapter['head'.$col]=='loginButtons')) { echo 'selected'; } ?>><? echo Account_buttons; ?></option>
							<option value="loginFields" <? if ((isset($sitchapter['head'.$col]))AND($sitchapter['head'.$col]=='loginFields')) { echo 'selected'; } ?>><? echo Account_fields; ?></option>
							<option value="languages" <? if ((isset($sitchapter['head'.$col]))AND($sitchapter['head'.$col]=='languages')) { echo 'selected'; } ?>><? echo Languages; ?></option>
							<? foreach ($moduls as $one): if (($one!='.')AND($one!='..')AND(!is_dir(APPPATH.'Views/moduls/'.$one))) { $path_parts = pathinfo($one); ?>
							<option value="my_<? echo $path_parts['filename']; ?>" <? if ((isset($sitchapter['head'.$col]))AND($sitchapter['head'.$col]=='my_'.$path_parts['filename'])) { echo 'selected'; } ?>><? echo $path_parts['filename']; ?></option>
							<? } endforeach; ?>
						</select>
					</div>
					<? } ?>
				</div>
				<div class="scheme_head_in3">
					<? for ($col=31;$col<33;$col++) { ?>
					<div>
						<select name="head<? echo $col; ?>" >
							<option value="" <? if ((isset($sitchapter['head'.$col]))AND($sitchapter['head'.$col]=='')) { echo 'selected'; } ?>><? echo Place_for_code; ?></option>
							<option value="chaptersMenu" <? if ((isset($sitchapter['head'.$col]))AND($sitchapter['head'.$col]=='chaptersMenu')) { echo 'selected'; } ?>><? echo Chapters; ?></option>
							<option value="chapterMenuSub" <? if ((isset($sitchapter['head'.$col]))AND($sitchapter['head'.$col]=='chapterMenuSub')) { echo 'selected'; } ?>><? echo Chapters_subchapters; ?></option>
							<option value="search" <? if ((isset($sitchapter['head'.$col]))AND($sitchapter['head'.$col]=='search')) { echo 'selected'; } ?>><? echo Search; ?></option>
							<option value="orderCall" <? if ((isset($sitchapter['head'.$col]))AND($sitchapter['head'.$col]=='orderCall')) { echo 'selected'; } ?>><? echo Order_call; ?></option>
							<option value="loginButtons" <? if ((isset($sitchapter['head'.$col]))AND($sitchapter['head'.$col]=='loginButtons')) { echo 'selected'; } ?>><? echo Account_buttons; ?></option>
							<option value="loginFields" <? if ((isset($sitchapter['head'.$col]))AND($sitchapter['head'.$col]=='loginFields')) { echo 'selected'; } ?>><? echo Account_fields; ?></option>
							<option value="languages" <? if ((isset($sitchapter['head'.$col]))AND($sitchapter['head'.$col]=='languages')) { echo 'selected'; } ?>><? echo Languages; ?></option>
							<? foreach ($moduls as $one): if (($one!='.')AND($one!='..')AND(!is_dir(APPPATH.'Views/moduls/'.$one))) { $path_parts = pathinfo($one); ?>
							<option value="my_<? echo $path_parts['filename']; ?>" <? if ((isset($sitchapter['head'.$col]))AND($sitchapter['head'.$col]=='my_'.$path_parts['filename'])) { echo 'selected'; } ?>><? echo $path_parts['filename']; ?></option>
							<? } endforeach; ?>
						</select>
					</div>
					<? } ?>
				</div>
			</div>
			<div class="scheme_underhead">
				<? for ($col=1;$col<3;$col++) { ?>
				<div class="scheme_underhead_in">
					<select name="underhead<? echo $col; ?>" >
						<option value="" <? if ((isset($sitchapter['underhead'.$col]))AND($sitchapter['underhead'.$col]=='')) { echo 'selected'; } ?>><? echo Empty_; ?></option>
						<option value="chaptersMenu" <? if ((isset($sitchapter['underhead'.$col]))AND($sitchapter['underhead'.$col]=='chaptersMenu')) { echo 'selected'; } ?>><? echo Chapters; ?></option>
						<option value="chapterMenuSub" <? if ((isset($sitchapter['underhead'.$col]))AND($sitchapter['underhead'.$col]=='chapterMenuSub')) { echo 'selected'; } ?>><? echo Chapters_subchapters; ?></option>
						<option value="search" <? if ((isset($sitchapter['underhead'.$col]))AND($sitchapter['underhead'.$col]=='search')) { echo 'selected'; } ?>><? echo Search; ?></option>
						<option value="orderCall" <? if ((isset($sitchapter['underhead'.$col]))AND($sitchapter['underhead'.$col]=='orderCall')) { echo 'selected'; } ?>><? echo Order_call; ?></option>
						<option value="loginButtons" <? if ((isset($sitchapter['underhead'.$col]))AND($sitchapter['underhead'.$col]=='loginButtons')) { echo 'selected'; } ?>><? echo Account_buttons; ?></option>
						<option value="loginFields" <? if ((isset($sitchapter['underhead'.$col]))AND($sitchapter['underhead'.$col]=='loginFields')) { echo 'selected'; } ?>><? echo Account_fields; ?></option>
						<option value="languages" <? if ((isset($sitchapter['underhead'.$col]))AND($sitchapter['underhead'.$col]=='languages')) { echo 'selected'; } ?>><? echo Languages; ?></option>
						<? foreach ($moduls as $one): if (($one!='.')AND($one!='..')AND(!is_dir(APPPATH.'Views/moduls/'.$one))) { $path_parts = pathinfo($one); ?>
						<option value="my_<? echo $path_parts['filename']; ?>" <? if ((isset($sitchapter['underhead'.$col]))AND($sitchapter['underhead'.$col]=='my_'.$path_parts['filename'])) { echo 'selected'; } ?>><? echo $path_parts['filename']; ?></option>
						<? } endforeach; ?>
					</select>
				</div>
				<? } ?>
			</div>
		</div>
		<div class="scheme_arrows_back">
			<div class="scheme_columns_show">
				<div class="scheme_columns_show_in">
					<select name="leftcolumn">
						<option value="" <? if ((isset($sitchapter['leftcolumn']))AND($sitchapter['leftcolumn']=='')) { echo 'selected'; } ?>><? echo Turn_off_left_column; ?></option>
						<option value="yes" <? if ((isset($sitchapter['leftcolumn']))AND($sitchapter['leftcolumn']=='yes')) { echo 'selected'; } ?>><? echo Turn_on_left_column; ?></option>
					</select>
				</div>
				<div class="scheme_columns_show_in">
					<select name="rightcolumn">
						<option value="" <? if ((isset($sitchapter['rightcolumn']))AND($sitchapter['rightcolumn']=='')) { echo 'selected'; } ?>><? echo Turn_off_right_column; ?></option>
						<option value="yes" <? if ((isset($sitchapter['rightcolumn']))AND($sitchapter['rightcolumn']=='yes')) { echo 'selected'; } ?>><? echo Turn_on_right_column; ?></option>
					</select>
				</div>
			</div>
		</div>
		<div class="scheme_banner_back">
			<div class="scheme_banner_text">
				<textarea id="editBannerheader" <? if (session('adverbannerview')==1) { echo 'class="mceAdmin"'; } ?> rows="10"><? if (isset($banchapter['header'])) { echo $banchapter['header']; } ?></textarea>
			</div>
			<div class="scheme_banner_flex">
				<div class="scheme_banner_flex_in">
					<input type="checkbox" id="allBannerheader">
				</div>
				<div class="scheme_banner_flex_in">
					<? echo For_all; ?>
				</div>
				<div class="scheme_banner_flex_in">
					<button class="sheme js__edit--banner" data-info="header" type="button"><? echo Save; ?></button>
				</div>
			</div>
		</div>
		<div class="scheme_slider_line">
			<div class="scheme_slider_line_in1">
				<div class="scheme_banner_text">
					<textarea id="editBannersliderleft" <? if (session('adverbannerview')==1) { echo 'class="mceAdmin"'; } ?> rows="10"><? if (isset($banchapter['sliderleft'])) { echo $banchapter['sliderleft']; } ?></textarea>
				</div>
				<div class="scheme_banner_flex">
					<div class="scheme_banner_flex_in">
						<input type="checkbox" id="allBannersliderleft">
					</div>
					<div class="scheme_banner_flex_in">
						<? echo For_all; ?>
					</div>
					<div class="scheme_banner_flex_in">
						<button class="sheme js__edit--banner" data-info="sliderleft" type="button"><? echo Save; ?></button>
					</div>
				</div>
			</div>
			<div class="scheme_slider_line_in2">
				<div>
					<select name="overcenter" >
						<option value="" <? if ((isset($sitchapter['overcenter']))AND($sitchapter['overcenter']=='')) { echo 'selected'; } ?>><? echo Empty_; ?></option>
						<option value="slider" <? if ((isset($sitchapter['overcenter']))AND($sitchapter['overcenter']=='slider')) { echo 'selected'; } ?>><? echo Slider; ?></option>
						<? foreach ($moduls as $one): if (($one!='.')AND($one!='..')AND(!is_dir(APPPATH.'Views/moduls/'.$one))) { $path_parts = pathinfo($one); ?>
						<option value="my_<? echo $path_parts['filename']; ?>" <? if ((isset($sitchapter['overcenter']))AND($sitchapter['overcenter']=='my_'.$path_parts['filename'])) { echo 'selected'; } ?>><? echo $path_parts['filename']; ?></option>
						<? } endforeach; ?>
					</select>
				</div>
			</div>
			<div class="scheme_slider_line_in3">
				<div class="scheme_banner_text">
					<textarea id="editBannersliderright" <? if (session('adverbannerview')==1) { echo 'class="mceAdmin"'; } ?> rows="10"><? if (isset($banchapter['sliderright'])) { echo $banchapter['sliderright']; } ?></textarea>
				</div>
				<div class="scheme_banner_flex">
					<div class="scheme_banner_flex_in">
						<input type="checkbox" id="allBannersliderright">
					</div>
					<div class="scheme_banner_flex_in">
						<? echo For_all; ?>
					</div>
					<div class="scheme_banner_flex_in">
						<button class="sheme js__edit--banner" data-info="sliderright" type="button"><? echo Save; ?></button>
					</div>
				</div>
			</div>
		</div>
		<div>
			<div class="scheme_center_all">
				<? if ((isset($sitchapter['leftcolumn']))AND($sitchapter['leftcolumn']=='yes')) { ?>
				<div class="scheme_center_left">
					<? for ($col=1;$col<6;$col++) { ?>
					<div class="scheme_banner_back">
						<div class="scheme_banner_text">
							<textarea id="editBannerleft<? echo $col; ?>" <? if (session('adverbannerview')==1) { echo 'class="mceAdmin"'; } ?> rows="10"><? if (isset($banchapter['left'.$col])) { echo $banchapter['left'.$col]; } ?></textarea>
						</div>
						<div class="scheme_banner_flex">
							<div class="scheme_banner_flex_in">
								<input type="checkbox" id="allBannerleft<? echo $col; ?>">
							</div>
							<div class="scheme_banner_flex_in">
								<? echo For_all; ?>
							</div>
							<div class="scheme_banner_flex_in">
								<button class="sheme js__edit--banner" data-info="left<? echo $col; ?>" type="button"><? echo Save; ?></button>
							</div>
						</div>
					</div>
					<div class="scheme_select_back">
						<select name="left<? echo $col; ?>" >
							<option value="" <? if ((isset($sitchapter['left'.$col]))AND($sitchapter['left'.$col]=='')) { echo 'selected'; } ?>><? echo Empty_; ?></option>
							<option value="chapters" <? if ((isset($sitchapter['left'.$col]))AND($sitchapter['left'.$col]=='chapters')) { echo 'selected'; } ?>><? echo Chapters; ?></option>
							<option value="chaptersExtended" <? if ((isset($sitchapter['left'.$col]))AND($sitchapter['left'.$col]=='chaptersExtended')) { echo 'selected'; } ?>><? echo Chapters_ext; ?></option>
							<option value="chaptersSub" <? if ((isset($sitchapter['left'.$col]))AND($sitchapter['left'.$col]=='chaptersSub')) { echo 'selected'; } ?>><? echo Subchapters; ?></option>
							<? foreach ($list->artChapters as $one): ?>
							<option value="articlesColumn<? echo $one['chapterId']; ?>" <? if ((isset($sitchapter['left'.$col]))AND($sitchapter['left'.$col]=='articlesColumn'.$one['chapterId'])) { echo 'selected'; } ?>><? echo Feed; ?> (<? echo $one['name'.session('languageBase')]; ?>)</option>
							<? endforeach; ?>
							<? foreach ($list->galChapters as $one): ?>
							<option value="galleryColumn<? echo $one['chapterId']; ?>" <? if ((isset($sitchapter['left'.$col]))AND($sitchapter['left'.$col]=='galleryColumn'.$one['chapterId'])) { echo 'selected'; } ?>><? echo Gallery; ?> (<? echo $one['name'.session('languageBase')]; ?>)</option>
							<? endforeach; ?>
							<? foreach ($list->feedbacks as $one): ?>
							<option value="feedback<? echo $one['feedbackId']; ?>" <? if ((isset($sitchapter['left'.$col]))AND($sitchapter['left'.$col]=='feedback'.$one['feedbackId'])) { echo 'selected'; } ?>><? echo Communication_form; ?> (<? echo $one['name'.session('languageBase')]; ?>)</option>
							<? endforeach; ?>
							<? foreach ($list->polls as $one): ?>
							<option value="polls<? echo $one['pollId']; ?>" <? if ((isset($sitchapter['left'.$col]))AND($sitchapter['left'.$col]=='polls'.$one['pollId'])) { echo 'selected'; } ?>><? echo Poll; ?> (<? echo $one['name']; ?>)</option>
							<? endforeach; ?>
							<option value="commentsColumn" <? if ((isset($sitchapter['left'.$col]))AND($sitchapter['left'.$col]=='commentsColumn')) { echo 'selected'; } ?>><? echo Reviews; ?></option>
							<option value="search" <? if ((isset($sitchapter['left'.$col]))AND($sitchapter['left'.$col]=='search')) { echo 'selected'; } ?>><? echo Search; ?></option>
							<option value="orderCall" <? if ((isset($sitchapter['left'.$col]))AND($sitchapter['left'.$col]=='orderCall')) { echo 'selected'; } ?>><? echo Order_call; ?></option>
							<option value="loginButtons" <? if ((isset($sitchapter['left'.$col]))AND($sitchapter['left'.$col]=='loginButtons')) { echo 'selected'; } ?>><? echo Account_buttons; ?></option>
							<option value="loginFields" <? if ((isset($sitchapter['left'.$col]))AND($sitchapter['left'.$col]=='loginFields')) { echo 'selected'; } ?>><? echo Account_fields; ?></option>
							<? foreach ($moduls as $one): if (($one!='.')AND($one!='..')AND(!is_dir(APPPATH.'Views/moduls/'.$one))) { $path_parts = pathinfo($one); ?>
							<option value="my_<? echo $path_parts['filename']; ?>" <? if ((isset($sitchapter['left'.$col]))AND($sitchapter['left'.$col]=='my_'.$path_parts['filename'])) { echo 'selected'; } ?>><? echo $path_parts['filename']; ?></option>
							<? } endforeach; ?>
						</select>
					</div>
					<? } ?>
					<div class="scheme_banner_back">
						<div class="scheme_banner_text">
							<textarea id="editBannerleft6" <? if (session('adverbannerview')==1) { echo 'class="mceAdmin"'; } ?> rows="10"><? if (isset($banchapter['left6'])) { echo $banchapter['left6']; } ?></textarea>
						</div>
						<div class="scheme_banner_flex">
							<div class="scheme_banner_flex_in">
								<input type="checkbox" id="allBannerleft6">
							</div>
							<div class="scheme_banner_flex_in">
								<? echo For_all; ?>
							</div>
							<div class="scheme_banner_flex_in">
								<button class="sheme js__edit--banner" data-info="left6" type="button" type="button"><? echo Save; ?></button>
							</div>
						</div>
					</div>
				</div>
				<? } ?>
				<div class="scheme_center_center">
					<? for ($col=1;$col<9;$col=$col+2) { ?>
					<div class="scheme_center_center_in">
						<div class="scheme_center_center_in1">
							<div class="scheme_select_back">
								<select name="center<? echo $col; ?>">
									<option value="" <? if ((isset($sitchapter['center'.$col]))AND($sitchapter['center'.$col]=='')) { echo 'selected'; } ?>><? echo Empty_; ?></option>
									<option value="slider" <? if ((isset($sitchapter['center'.$col]))AND($sitchapter['center'.$col]=='slider')) { echo 'selected'; } ?>><? echo Slider; ?></option>
									<? foreach ($list->artChapters as $one): ?>
									<option value="articlesCenter<? echo $one['chapterId']; ?>" <? if ((isset($sitchapter['center'.$col]))AND($sitchapter['center'.$col]=='articlesCenter'.$one['chapterId'])) { echo 'selected'; } ?>><? echo Feed; ?> (<? echo $one['name'.session('languageBase')]; ?>)</option>
									<? endforeach; ?>
									<? foreach ($list->galChapters as $one): ?>
									<option value="galleryCenter<? echo $one['chapterId']; ?>" <? if ((isset($sitchapter['center'.$col]))AND($sitchapter['center'.$col]=='galleryCenter'.$one['chapterId'])) { echo 'selected'; } ?>><? echo Gallery; ?>(<? echo $one['name'.session('languageBase')]; ?>)</option>
									<? endforeach; ?>
									<? foreach ($list->feedbacks as $one): ?>
									<option value="feedback<? echo $one['feedbackId']; ?>" <? if ((isset($sitchapter['center'.$col]))AND($sitchapter['center'.$col]=='feedback'.$one['feedbackId'])) { echo 'selected'; } ?>><? echo Communication_form; ?> (<? echo $one['name'.session('languageBase')]; ?>)</option>
									<? endforeach; ?>
									<? foreach ($list->polls as $one): ?>
									<option value="polls<? echo $one['pollId']; ?>" <? if ((isset($sitchapter['center'.$col]))AND($sitchapter['center'.$col]=='polls'.$one['pollId'])) { echo 'selected'; } ?>><? echo Poll; ?> (<? echo $one['name']; ?>)</option>
									<? endforeach; ?>
									<option value="commentsCenter" <? if ((isset($sitchapter['center'.$col]))AND($sitchapter['center'.$col]=='commentsCenter')) { echo 'selected'; } ?>><? echo Reviews; ?></option>
									<option value="commentsSlide" <? if ((isset($sitchapter['center'.$col]))AND($sitchapter['center'.$col]=='commentsSlide')) { echo 'selected'; } ?>><? echo Reviews; ?> (<? echo Slider; ?>)</option>
									<? foreach ($moduls as $one): if (($one!='.')AND($one!='..')AND(!is_dir(APPPATH.'Views/moduls/'.$one))) { $path_parts = pathinfo($one); ?>
									<option value="my_<? echo $path_parts['filename']; ?>" <? if ((isset($sitchapter['center'.$col]))AND($sitchapter['center'.$col]=='my_'.$path_parts['filename'])) { echo 'selected'; } ?>><? echo $path_parts['filename']; ?></option>
									<? } endforeach; ?>
								</select>
							</div>
							<div class="scheme_banner_back">
								<div class="scheme_banner_text">
									<textarea id="editBannercenterin<? echo $col; ?>" <? if (session('adverbannerview')==1) { echo 'class="mceAdmin"'; } ?> rows="10"><? if (isset($banchapter['centerin'.$col])) { echo $banchapter['centerin'.$col]; } ?></textarea>
								</div>
								<div class="scheme_banner_flex">
									<div class="scheme_banner_flex_in">
										<input type="checkbox" id="allBannercenterin<? echo $col; ?>">
									</div>
									<div class="scheme_banner_flex_in">
										<? echo For_all; ?>
									</div>
									<div class="scheme_banner_flex_in">
										<button class="sheme js__edit--banner" data-info="centerin<? echo $col; ?>" type="button" type="button"><? echo Save; ?></button>
									</div>
								</div>
							</div>
						</div>
						<div class="scheme_center_center_in2">
							<div class="scheme_select_back">
								<select name="center<? echo $col+1; ?>">
									<option value="" <? if ((isset($sitchapter['center'.($col+1)]))AND($sitchapter['center'.($col+1)]=='')) { echo 'selected'; } ?>><? echo Empty_; ?></option>
									<option value="slider" <? if ((isset($sitchapter['center'.($col+1)]))AND($sitchapter['center'.($col+1)]=='slider')) { echo 'selected'; } ?>><? echo Slider; ?></option>
									<? foreach ($list->artChapters as $one): ?>
									<option value="articlesCenter<? echo $one['chapterId']; ?>" <? if ((isset($sitchapter['center'.($col+1)]))AND($sitchapter['center'.($col+1)]=='articlesCenter'.$one['chapterId'])) { echo 'selected'; } ?>><? echo Feed; ?> (<? echo $one['name'.session('languageBase')]; ?>)</option>
									<? endforeach; ?>
									<? foreach ($list->galChapters as $one): ?>
									<option value="galleryCenter<? echo $one['chapterId']; ?>" <? if ((isset($sitchapter['center'.($col+1)]))AND($sitchapter['center'.($col+1)]=='galleryCenter'.$one['chapterId'])) { echo 'selected'; } ?>><? echo Gallery; ?> (<? echo $one['name'.session('languageBase')]; ?>)</option>
									<? endforeach; ?>
									<? foreach ($list->feedbacks as $one): ?>
									<option value="feedback<? echo $one['feedbackId']; ?>" <? if ((isset($sitchapter['center'.($col+1)]))AND($sitchapter['center'.($col+1)]=='feedback'.$one['feedbackId'])) { echo 'selected'; } ?>><? echo Communication_form; ?> (<? echo $one['name'.session('languageBase')]; ?>)</option>
									<? endforeach; ?>
									<? foreach ($list->polls as $one): ?>
									<option value="polls<? echo $one['pollId']; ?>" <? if ((isset($sitchapter['center'.($col+1)]))AND($sitchapter['center'.($col+1)]=='polls'.$one['pollId'])) { echo 'selected'; } ?>><? echo Poll; ?> (<? echo $one['name']; ?>)</option>
									<? endforeach; ?>
									<option value="commentsCenter" <? if ((isset($sitchapter['center'.($col+1)]))AND($sitchapter['center'.($col+1)]=='commentsCenter')) { echo 'selected'; } ?>><? echo Reviews; ?></option>
									<option value="commentsSlide" <? if ((isset($sitchapter['center'.($col+1)]))AND($sitchapter['center'.($col+1)]=='commentsSlide')) { echo 'selected'; } ?>><? echo Reviews; ?> (<? echo Slider; ?>)</option>
									<? foreach ($moduls as $one): if (($one!='.')AND($one!='..')AND(!is_dir(APPPATH.'Views/moduls/'.$one))) { $path_parts = pathinfo($one); ?>
									<option value="my_<? echo $path_parts['filename']; ?>" <? if ((isset($sitchapter['center'.($col+1)]))AND($sitchapter['center'.($col+1)]=='my_'.$path_parts['filename'])) { echo 'selected'; } ?>><? echo $path_parts['filename']; ?></option>
									<? } endforeach; ?>
								</select>
							</div>
							<div class="scheme_banner_back">
								<div class="scheme_banner_text">
									<textarea id="editBannercenterin<? echo ($col+1); ?>" <? if (session('adverbannerview')==1) { echo 'class="mceAdmin"'; } ?> rows="10"><? if (isset($banchapter['centerin'.($col+1)])) { echo $banchapter['centerin'.($col+1)]; } ?></textarea>
								</div>
								<div class="scheme_banner_flex">
									<div class="scheme_banner_flex_in">
										<input type="checkbox" id="allBannercenterin<? echo ($col+1); ?>">
									</div>
									<div class="scheme_banner_flex_in">
										<? echo For_all; ?>
									</div>
									<div class="scheme_banner_flex_in">
										<button class="sheme js__edit--banner" data-info="centerin<? echo ($col+1); ?>" type="button"><? echo Save; ?></button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<? if (($col==1)OR($col==5)) { ?>
					<div class="scheme_banner_back">
						<div class="scheme_banner_text">
							<textarea id="editBannercenter<? if ($col==1) { echo '1'; } else { echo '2'; } ?>" <? if (session('adverbannerview')==1) { echo 'class="mceAdmin"'; } ?> rows="10"><? if ($col==1) { if (isset($banchapter['center1'])) { echo $banchapter['center1']; } } else { if (isset($banchapter['center2'])) { echo $banchapter['center2']; } } ?></textarea>
						</div>
						<div class="scheme_banner_flex">
							<div class="scheme_banner_flex_in">
								<input type="checkbox" id="allBannercenter<? if ($col==1) { echo '1'; } else { echo '2'; } ?>">
							</div>
							<div class="scheme_banner_flex_in">
								<? echo For_all; ?>
							</div>
							<div class="scheme_banner_flex_in">
								<button class="sheme js__edit--banner" data-info="center<? if ($col==1) { echo '1'; } else { echo '2'; } ?>" type="button"><? echo Save; ?></button>
							</div>
						</div>
					</div>
					<? } ?>
					<? if ($col==3) { ?>
					<div class="scheme_mainfo">
						<? echo Main_information; ?>
					</div>
					<? } ?>
					<? } ?>
				</div>
				<? if ((isset($sitchapter['rightcolumn']))AND($sitchapter['rightcolumn']=='yes')) { ?>
				<div class="scheme_center_right">
					<? for ($col=1;$col<6;$col++) { ?>
					<div class="scheme_banner_back">
						<div class="scheme_banner_text">
							<textarea id="editBannerright<? echo $col; ?>" <? if (session('adverbannerview')==1) { echo 'class="mceAdmin"'; } ?> rows="10"><? if (isset($banchapter['right'.$col])) { echo $banchapter['right'.$col]; } ?></textarea>
						</div>
						<div class="scheme_banner_flex">
							<div class="scheme_banner_flex_in">
								<input type="checkbox" id="allBannerright<? echo $col; ?>">
							</div>
							<div class="scheme_banner_flex_in">
								<? echo For_all; ?>
							</div>
							<div class="scheme_banner_flex_in">
								<button class="sheme js__edit--banner" data-info="right<? echo $col; ?>" type="button"><? echo Save; ?></button>
							</div>
						</div>
					</div>
					<div class="scheme_select_back">
						<select name="right<? echo $col; ?>" >
							<option value="" <? if ((isset($sitchapter['right'.$col]))AND($sitchapter['right'.$col]=='')) { echo 'selected'; } ?>><? echo Empty_; ?></option>
							<option value="chapters" <? if ((isset($sitchapter['right'.$col]))AND($sitchapter['right'.$col]=='chapters')) { echo 'selected'; } ?>><? echo Chapters; ?></option>
							<option value="chaptersExtended" <? if ((isset($sitchapter['right'.$col]))AND($sitchapter['right'.$col]=='chaptersExtended')) { echo 'selected'; } ?>><? echo Chapters_ext; ?></option>
							<option value="chaptersSub" <? if ((isset($sitchapter['right'.$col]))AND($sitchapter['right'.$col]=='chaptersSub')) { echo 'selected'; } ?>><? echo Subchapters; ?></option>
							<? foreach ($list->artChapters as $one): ?>
							<option value="articlesColumn<? echo $one['chapterId']; ?>" <? if ((isset($sitchapter['right'.$col]))AND($sitchapter['right'.$col]=='articlesColumn'.$one['chapterId'])) { echo 'selected'; } ?>><? echo Feed; ?> (<? echo $one['name'.session('languageBase')]; ?>)</option>
							<? endforeach; ?>
							<? foreach ($list->galChapters as $one): ?>
							<option value="galleryColumn<? echo $one['chapterId']; ?>" <? if ((isset($sitchapter['right'.$col]))AND($sitchapter['right'.$col]=='galleryColumn'.$one['chapterId'])) { echo 'selected'; } ?>><? echo Gallery; ?> (<? echo $one['name'.session('languageBase')]; ?>)</option>
							<? endforeach; ?>
							<? foreach ($list->feedbacks as $one): ?>
							<option value="feedback<? echo $one['feedbackId']; ?>" <? if ((isset($sitchapter['right'.$col]))AND($sitchapter['right'.$col]=='feedback'.$one['feedbackId'])) { echo 'selected'; } ?>><? echo Communication_form; ?> (<? echo $one['name'.session('languageBase')]; ?>)</option>
							<? endforeach; ?>
							<? foreach ($list->polls as $one): ?>
							<option value="polls<? echo $one['pollId']; ?>" <? if ((isset($sitchapter['right'.$col]))AND($sitchapter['right'.$col]=='polls'.$one['pollId'])) { echo 'selected'; } ?>><? echo Poll; ?> (<? echo $one['name']; ?>)</option>
							<? endforeach; ?>
							<option value="commentsColumn" <? if ((isset($sitchapter['right'.$col]))AND($sitchapter['right'.$col]=='commentsColumn')) { echo 'selected'; } ?>><? echo Reviews; ?></option>
							<option value="search" <? if ((isset($sitchapter['right'.$col]))AND($sitchapter['right'.$col]=='search')) { echo 'selected'; } ?>><? echo Search; ?></option>
							<option value="orderCall" <? if ((isset($sitchapter['right'.$col]))AND($sitchapter['right'.$col]=='orderCall')) { echo 'selected'; } ?>><? echo Order_call; ?></option>
							<option value="loginButtons" <? if ((isset($sitchapter['right'.$col]))AND($sitchapter['right'.$col]=='loginButtons')) { echo 'selected'; } ?>><? echo Account_buttons; ?></option>
							<option value="loginFields" <? if ((isset($sitchapter['right'.$col]))AND($sitchapter['right'.$col]=='loginFields')) { echo 'selected'; } ?>><? echo Account_fields; ?></option>
							<? foreach ($moduls as $one): if (($one!='.')AND($one!='..')AND(!is_dir(APPPATH.'Views/moduls/'.$one))) { $path_parts = pathinfo($one); ?>
							<option value="my_<? echo $path_parts['filename']; ?>" <? if ((isset($sitchapter['right'.$col]))AND($sitchapter['right'.$col]=='my_'.$path_parts['filename'])) { echo 'selected'; } ?>><? echo $path_parts['filename']; ?></option>
							<? } endforeach; ?>
						</select>
					</div>
					<? } ?>
					<div class="scheme_banner_back">
						<div class="scheme_banner_text">
							<textarea id="editBannerright6" <? if (session('adverbannerview')==1) { echo 'class="mceAdmin"'; } ?> rows="10"><? if (isset($banchapter['right6'])) { echo $banchapter['right6']; } ?></textarea>
						</div>
						<div class="scheme_banner_flex">
							<div class="scheme_banner_flex_in">
								<input type="checkbox" id="allBannerright6">
							</div>
							<div class="scheme_banner_flex_in">
								<? echo For_all; ?>
							</div>
							<div class="scheme_banner_flex_in">
								<button class="sheme js__edit--banner" data-info="right6" type="button"><? echo Save; ?></button>
							</div>
						</div>
					</div>
				<? } ?>
				</div>
			</div>
			<div>
				<div class="scheme_banner_back">
					<div class="scheme_banner_text">
						<textarea id="editBannerfooter" <? if (session('adverbannerview')==1) { echo 'class="mceAdmin"'; } ?> rows="10"><? if (isset($banchapter['footer'])) {  echo $banchapter['footer']; } ?></textarea>
					</div>
					<div class="scheme_banner_flex">
						<div class="scheme_banner_flex_in">
							<input type="checkbox" id="allBannerfooter">
						</div>
						<div class="scheme_banner_flex_in">
							<? echo For_all; ?>
						</div>
						<div class="scheme_banner_flex_in">
							<button class="sheme js__edit--banner" data-info="footer" type="button"><? echo Save; ?></button>
						</div>
					</div>
				</div>
			</div>
			<div class="scheme_basement">
				<? echo Site_basement; ?>
			</div>
		</div>
		<div class="table--all--no--border" style="background:#fff;">
			<div class="cell--full">
				<button type="button" data-info="" class="js__situation--button"><? echo Save; ?></button>
			</div>
			<div class="cell--button" style="border-left:0;">
				<? if ($list->actPage=='design') { ?>
					<button type="button" data-info="/sub" class="js__situation--button"><? echo Save_and_apply; ?></button>
				<? } else { ?>
				<? if ($list->actPage=='chapters') { ?><button type="button" data-info="/sub" class="js__situation--button"><? echo Save_for_chapter_and_subchapters; ?></button><? } ?>
				<? } ?>
			</div>
		</div>
		
		<div class="table--all--no--border" style="background:#fff;">
			<div class="cell--full fail" id="infoMessage">
				<? echo session('message'); $session = session(); $session->remove('message'); ?>
			</div>
		</div>
	</div>
	</form>