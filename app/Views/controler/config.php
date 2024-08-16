<section class="center--block">
	<? if (($list->inPage!='situation')AND($list->inPage!='false')) { ?>
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
			</div>
			<div class="bordertopcolor">
				<div onClick="location='/controler/config/index/default'" <? if ($list->inPage=='default') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/config/index/default"><? echo Chapters_settings; ?></a>
				</div>
				<div onClick="location='/controler/config/index/protocol'" <? if ($list->inPage=='protocol') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/config/index/protocol"><? echo Protokol; ?></a>
				</div>
				<div onClick="location='/controler/config/index/template'" <? if ($list->inPage=='template') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/config/index/template"><? echo Available_templates; ?></a>
				</div>
				<div onClick="location='/controler/config/index/close'" <? if ($list->inPage=='close') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/config/index/close"><? echo Close_site; ?></a>
				</div>
				<div onClick="location='/controler/config/index/language'" <? if ($list->inPage=='language') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/config/index/language"><? echo Control_panel_language; ?></a>
				</div>
				<div onClick="location='/controler/config/index/moduls'" <? if (($list->inPage=='moduls')OR($list->inPage=='editmodul')) { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/config/index/moduls"><? echo My_moduls; ?></a>
				</div>
				<div onClick="location='/controler/config/index/nespicms'" <? if ($list->inPage=='nespicms') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/config/index/nespicms"><? echo About_nespi; ?></a>
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
			<div >
				<div class="in--center--name">
					<? if ($list->inPage=='default') { echo Chapters_settings; } ?>
					<? if ($list->inPage=='moduls') { echo My_moduls; } ?>
					<? if ($list->inPage=='language') { echo Control_panel_language; } ?>
					<? if ($list->inPage=='editmodul') { echo My_moduls; echo ' > ';  echo $list->modul; } ?>
					<? if ($list->inPage=='template') { echo Main_template; } ?>
					<? if ($list->inPage=='nespicms') { echo About_nespi; } ?>
					<? if ($list->inPage=='close') { echo Close_site; } ?>
					<? if ($list->inPage=='protocol') { echo Protokol; } ?>
				</div>
			</div>
		</div>
		
		<div class="under--center--pole">
			<div class="in--shadow--block--11">
	
				<? if ($list->inPage=='default') { ?>
				<div class="data--table" >
					<div class="table--all">
						<div class="sm--top" align="center" class="sm--top">
							<? echo Chapters_settings; ?>
						</div>
					</div>
					<form method="post" action="/controler/config/editDefaultAtView">
					<div class="table--all">
						<div class="cell--name">
							<? echo Secondary_output; ?>
						</div>
						<div class="cell--param">
							<select name="defaultAtView">
								<option value="0" <? if ($list->confSet['defaultAtView']==0) { echo 'selected'; } ?>><? echo Nothing; ?></option>
								<option value="1" <? if ($list->confSet['defaultAtView']==1) { echo 'selected'; } ?>><? echo Chapters; ?></option>
								<option value="2" <? if ($list->confSet['defaultAtView']==2) { echo 'selected'; } ?>><? echo Subchapters; ?></option>
							</select>
						</div>
						<div class="cell--button">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<form method="post" action="/controler/config/editDefaultBreed">
					<div class="table--all">
						<div class="cell--name">
							<? echo Bread_crumbs; ?>
						</div>
						<div class="cell--param">
							<select name="defaultBreed">
								<option value="0" <? if ($list->confSet['defaultBreed']==0) { echo 'selected'; } ?>><? echo No; ?></option>
								<option value="1" <? if ($list->confSet['defaultBreed']==1) { echo 'selected'; } ?>><? echo Yes; ?></option>
							</select>
						</div>
						<div class="cell--button">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<form method="post" action="/controler/config/editDefaultSubChapters">
					<div class="table--all">
						<div class="cell--name">
							<? echo Subchapters_tree; ?>
						</div>
						<div class="cell--param">
							<select name="subChapters">
								<option value="0" <? if ($list->confSet['subChapters']==0) { echo 'selected'; } ?>><? echo From_main; ?></option>
								<option value="1" <? if ($list->confSet['subChapters']==1) { echo 'selected'; } ?>><? echo From_current; ?></option>
								<option value="2" <? if ($list->confSet['subChapters']==2) { echo 'selected'; } ?>><? echo From_parent; ?></option>
							</select>
						</div>
						<div class="cell--button">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail" id="infotd">
							<? echo session('message3'); $session = session(); $session->remove('message3'); ?>
						</div>
					</div>
					<div class="table--all">
						<div class="sm--top" align="center" class="sm--top">
							<? echo Settings; ?> sitemap.xml
						</div>
					</div>
					<form method="post" action="/controler/config/editDefaultChangeFreqChapters">
					<div class="table--all">
						<div class="cell--name">
							<? echo Change_freq_chapters; ?>
						</div>
						<div class="cell--param">
							<select name="changefreqChapters">
								<option value="always" <? if ($list->confSet['changefreqChapters']=='always') { echo 'selected'; } ?>>always</option>
								<option value="hourly" <? if ($list->confSet['changefreqChapters']=='hourly') { echo 'selected'; } ?>>hourly</option>
								<option value="daily" <? if ($list->confSet['changefreqChapters']=='daily') { echo 'selected'; } ?>>daily</option>
								<option value="weekly" <? if ($list->confSet['changefreqChapters']=='weekly') { echo 'selected'; } ?>>weekly</option>
								<option value="monthly" <? if ($list->confSet['changefreqChapters']=='monthly') { echo 'selected'; } ?>>monthly</option>
								<option value="yearly" <? if ($list->confSet['changefreqChapters']=='yearly') { echo 'selected'; } ?>>yearly</option>
								<option value="never" <? if ($list->confSet['changefreqChapters']=='never') { echo 'selected'; } ?>>never</option>
							</select>
						</div>
						<div class="cell--button">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<form method="post" action="/controler/config/editDefaultPriorityChapters">
					<div class="table--all">
						<div class="cell--name">
							<? echo Change_priority_chapters; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="priorityChapters" value="<? echo $list->confSet['priorityChapters']; ?>">
						</div>
						<div class="cell--button">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<form method="post" action="/controler/config/editDefaultChangeFreqArticles">
					<div class="table--all">
						<div class="cell--name">
							<? echo Change_freq_articles; ?>
						</div>
						<div class="cell--param">
							<select name="changefreqArticles">
								<option value="always" <? if ($list->confSet['changefreqArticles']=='always') { echo 'selected'; } ?>>always</option>
								<option value="hourly" <? if ($list->confSet['changefreqArticles']=='hourly') { echo 'selected'; } ?>>hourly</option>
								<option value="daily" <? if ($list->confSet['changefreqArticles']=='daily') { echo 'selected'; } ?>>daily</option>
								<option value="weekly" <? if ($list->confSet['changefreqArticles']=='weekly') { echo 'selected'; } ?>>weekly</option>
								<option value="monthly" <? if ($list->confSet['changefreqArticles']=='monthly') { echo 'selected'; } ?>>monthly</option>
								<option value="yearly" <? if ($list->confSet['changefreqArticles']=='yearly') { echo 'selected'; } ?>>yearly</option>
								<option value="never" <? if ($list->confSet['changefreqArticles']=='never') { echo 'selected'; } ?>>never</option>
							</select>
						</div>
						<div class="cell--button">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<form method="post" action="/controler/config/editDefaultPriorityArticles">
					<div class="table--all">
						<div class="cell--name">
							<? echo Change_priority_articles; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="priorityArticles" value="<? echo $list->confSet['priorityArticles']; ?>">
						</div>
						<div class="cell--button">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail" id="infotd">
							<? echo session('message4'); $session = session(); $session->remove('message4'); ?>
						</div>
					</div>
					<div class="table--all">
						<div class="sm--top" align="center" class="sm--top">
							<? echo Slider; ?>
						</div>
					</div>
					<form method="post" action="/controler/config/editDefaultSlider">
					<div class="table--all">
						<div class="cell--name">
							<? echo Slider_width; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="defaultSliderWidth" value="<? echo $list->confSet['defaultSliderWidth']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Slider_height; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="defaultSliderHeight" value="<? echo $list->confSet['defaultSliderHeight']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Fixed_height_width; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check"><input type="checkbox" id="defaultSliderFix" name="defaultSliderFix" <? if ($list->confSet['defaultSliderFix']==1) { echo 'checked'; } ?> style="display:none;"><label for="defaultSliderFix"></label></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo The_frequency_of_changing_the_slider_images; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="defaultSliderFreq" value="<? echo $list->confSet['defaultSliderFreq']; ?>">
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail" id="infotd">
							<? echo session('message6'); $session = session(); $session->remove('message6'); ?>
						</div>
					</div>
					<div class="table--all">
						<div class="sm--top" align="center" class="sm--top">
							<? echo General_settings; ?>
						</div>
					</div>
					<form method="post" action="/controler/config/editDefaultChapters">
					<div class="table--all">
						<div class="cell--name">
							<? echo Open_subchapters; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check"><input type="checkbox" id="openChapters" name="openChapters" <? if ($list->confSet['openChapters']==1) { echo 'checked'; } ?> style="display:none;"><label for="openChapters"></label></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Open_subchapters; ?> <? echo admin; ?> 
						</div>
						<div class="cell--param">
							<div class="data--text--check"><input type="checkbox" id="openChaptersCt" name="openChaptersCt" <? if ($list->confSet['openChaptersCt']==1) { echo 'checked'; } ?> style="display:none;"><label for="openChaptersCt"></label></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Show_inactive; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check"><input type="checkbox" id="seeNoActiveChapters" name="seeNoActiveChapters" <? if ($list->confSet['seeNoActiveChapters']==1) { echo 'checked'; } ?> style="display:none;"><label for="seeNoActiveChapters"></label></div>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail" id="infotd">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
					<div class="table--all">
						<div class="sm--top" align="center" class="sm--top">
							<? echo Chapters_images_settings; ?>
						</div>
					</div>
					<form enctype="multipart/form-data" method="post" action="/controler/config/editImageChapters">
					<div class="table--all">
						<div class="cell--name">
							<? echo No_image_available; ?>
						</div>
						<div class="cell--param">
							<div class="data--text">
							<? if ($list->confSet['noImage']!='') { ?><img style="max-width:150px; max-height:150px;" border="0" src="/<? echo $list->confSet['noImage']; ?>">
							<br><? } ?>
							<input type="file" name="userfile"> 
							</div>
						</div>
						<? if ($list->confSet['noImage']!='') { ?>
						<div class="cell--button">
							<button type="button" class="delete js__delete--button" data-id="0" data-type="config" data-module="NoImage"><? echo Delete_; ?></button>
						</div>
						<? } ?>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Cropping_photos_in_the_gallery_the_width_in_pixels; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="gallerySmWidth" value="<? echo $list->confSet['gallerySmWidth']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Cropping_photos_in_the_gallery_the_height_in_pixels; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="gallerySmHeight" value="<? echo $list->confSet['gallerySmHeight']; ?>">
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail" id="infoMessage">
							<? echo session('message1'); $session = session(); $session->remove('message1'); ?>
						</div>
					</div>
				</div>
				<? } ?>
				
				<? if ($list->inPage=='moduls') { ?>
				<div class="data--table">
					<form class="js__modul--form" method="post" action="/controler/config/addModul">
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input name="name" type="text" class="js__modul--name">
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__modul--button"><? echo Add; ?></button>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full fail js__info--message">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				<?
				$dir    = APPPATH.'/Views/moduls';
				$moduls = scandir($dir);
				?>
				<table class="all--width--list">
					<tr class="table--title">
						<td>
							<? echo Name_; ?>
						</td>
						<td align="center" style="width:1px;">
									
						</td>
					</tr>
					<? $rownum=0; ?>
					<? foreach ($moduls as $one): ?>
					<? if (($one!='.')AND($one!='..')AND(!is_dir(APPPATH.'Views/moduls/'.$one))) { ?>
					<? $path_parts = pathinfo($one); ?>
					<tr class="table--row<? echo $rownum; ?>">
						<td>
							<a class="table--link" href="/controler/config/index/editmodul/<? echo $path_parts['filename']; ?>"><? echo $path_parts['filename']; ?></a>
						</td>
						<td align="center">
							<button type="button" class="deletesm js__delete--button" data-id="<? echo $path_parts['filename']; ?>" data-type="config" data-module="Modul"><? echo Delete_; ?></button>
						</td>
					</tr>
					<? $rownum++; if ($rownum==2) { $rownum=0; } ?>
					<? } ?>
					<? endforeach; ?>
				</table>
				<? } ?>
						
				<? if ($list->inPage=='editmodul') { ?>
				<div class="flex--back--bet">
					<div class="item--back">
						<button type="button" onClick="location='/controler/config/index/moduls'"><? echo Back; ?></button>
					</div>
					<div class="item--back">
						<select id="myModulView" style="width:200px; border:1px solid #eee;">
							<option value="0" <? if (session('myModulView')==0) { echo 'selected'; } ?>>textarea</option>
							<option value="1" <? if (session('myModulView')==1) { echo 'selected'; } ?>>tinymce</option>
						</select>
					</div>
				</div>
				<div class="data--table">
					<form class="js__modul--form" method="post" action="/controler/config/editModul">
					<input type="hidden" name="id" value="<? echo $list->modul; ?>">
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" name="name" class="js__modul--name" value="<? echo $list->modul; ?>">
						</div>
					</div>
					<div class="table--all">
						<?
						$language = str_replace ('_','',session('languageBase'));
						if ($language!='') { $dirname=$language; $language = $language.'/'; }
						if (file_exists(APPPATH.'Views/moduls/'.$language.$list->modul.'.php')) {
							$content = file_get_contents(APPPATH.'Views/moduls/'.$language.$list->modul.'.php');
						} else {
							if ($dirname!='') { if (!is_dir(APPPATH.'Views/moduls/'.$dirname)) { mkdir(APPPATH.'Views/moduls/'.$dirname); } }
							$file = APPPATH.'Views/moduls/'.$language.$list->modul.'.php';
							$fp = fopen($file, "w"); 
							fwrite($fp, '<?=\''.$list->modul.'\'?>');
							fclose($fp);
						}
						?>
						<textarea name="text" <? if (session('myModulView')==1) { echo 'class="mceAdmin"'; } ?> rows="50"><? echo $content; ?></textarea>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__modul--button"><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail js__info--message">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				<? } ?>
	
				<? if ($list->inPage=='nespicms') { ?>
				<div class="data--table">
					<div class="table--all">
						<div class="cell--name">
							Type
						</div>
						<div class="cell--param">
							<div class="data--text">Business</div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Version
						</div>
						<div class="cell--param">
							<div class="data--text">2.0</div>
						</div>
					</div>
					
					<div class="table--all">
						<div class="cell--name">
							Site ID
						</div>
						<div class="cell--param">
							<div class="data--text"><? echo $list->confSet['idsite']; ?></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Serial Number
						</div>
						<div class="cell--param">
							<div class="data--text"><? echo $list->confSet['serial']; ?></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Author
						</div>
						<div class="cell--param">
							<div class="data--text"><a target="_blank" href="https://www.nespicms.com">www.nespicms.com</a></div>
						</div>
					</div>
				</div>
				<? } ?>
	
				<? if ($list->inPage=='language') { ?>
				<div class="data--table" >
					<form method="post" action="/controler/config/editLanguage">
					<div class="table--all">
						<div class="cell--name">
							<? echo Select_language; ?>
						</div>
						<div class="cell--param">
							<select name="language">
								<? $languages = file_get_contents(APPPATH."Language/ctlang.json"); $languages = json_decode($languages);    
								foreach ($languages as $one) { ?>
								<? $one = (array)$one; ?>
								<option value="<? echo $one['nick']; ?>" <? if ($one['selected']==1) { echo 'selected'; } ?>>
									<? if (isset($one['name'.defaultLocalePrefix])) { ?>
										<? echo $one['name'.defaultLocalePrefix]; ?>
									<? } else { ?>
										<? echo $one['name_en']; ?>
									<? } ?>
								</option>
								<? } ?>
							</select>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail" >
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				<? } ?>
	
				<? if ($list->inPage=='protocol') { ?>
				<div class="data--table" >
					<form method="post" action="/controler/config/editProtokol">
					<div class="table--all">
						<div class="cell--name">
							<? echo Select_protokol; ?>
						</div>
						<div class="cell--param">
							<select name="protokol">
								<option value="http" <? if ($list->confSet['protokol']=='http') { echo 'selected'; } ?>>http</option>
								<option value="https" <? if ($list->confSet['protokol']=='https') { echo 'selected'; } ?>>https</option>
							</select>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail" >
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				<? } ?>
	
				<? if ($list->inPage=='template') { ?>
				<div class="data--table" >
					<form method="post" action="/controler/config/editTemplate">
					<div class="table--all">
						<div class="cell--param">
							<?
							$sdir = array();
							if (false!==($files = scandir('admin/css/themes'))) {  
							foreach ($files as $entry):
								if ((strpos($entry,'.css'))AND($entry!='.')AND($entry!='..')) {
									$sdir[] = $entry;
								}
							endforeach;
							}
							$i=0;
							foreach ($sdir as $one):
								$list_themes[$i][0] = 'admin/css/themes/'.$one;
								$list_themes[$i][1] = $one;
								$i++;
							endforeach;
							?>
							<select name="admincss">
								<? foreach ($list_themes as $one): ?>
								<option value="<? echo $one[0]; ?>" <? if ($list->confSet['admincss']==$one[0]) { echo 'selected'; } ?>><? echo $one[1]; ?></option>
								<? endforeach; ?>
							</select>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Save; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail" >
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				<? } ?>
	
				<? if ($list->inPage=='close') { ?>
				<div class="data--table" >
					<form method="post" action="/controler/config/editClose">
					<div class="table--all">
						<div class="cell--name">
							<? echo Close_site; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check">
							<input type="checkbox" id="close" name="close" <? if ($list->confSet['close']==1) { echo 'checked'; } ?> style="display:none;">
							<label for="close"></label>
							</div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Login; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="closelogin" value="<? echo $list->confSet['closelogin']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Password; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="closepassword" value="<? echo $list->confSet['closepassword']; ?>">
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

