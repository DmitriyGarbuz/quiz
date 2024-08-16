<section class="center--block">
	<? if (($list->inPage!='situation')AND($list->inPage!='false')) { ?>
	<section class="center--block__left">
		<? echo view('/controler/newevents'); ?>
		<? if (($list->inPage!='situation')AND($list->inPage!='false')) { ?>
		<div>
			<div class="margin--top--20">
				<div class="add--item--main--block--left" onClick="location='/controler/notes/index/add'">
					<div class="add--item--main--block--left__in">
						<div>
							<img border="0" src="/admin/img/icons/add_group.svg">
						</div>
						<div>
							<a href="/controler/notes/index/add"><? echo Add_group; ?></a>
						</div>
					</div>
				</div>
				<div class="add--item--main--block--left" onClick="location='/controler/note/index/add'">
					<div class="add--item--main--block--left__in">
						<div>
							<img border="0" src="/admin/img/icons/order.svg">
						</div>
						<div>
							<a href="/controler/note/index/add"><? echo Add_note; ?></a>
						</div>
					</div>
				</div>
			</div>
			<div class="border--top--color">
				<div onClick="location='/controler/notes'" <? if ($list->setup['ctNotesTree']=='') { ?>class="column--link--active"<?} else { ?>class="column--link"<? } ?>>
					<a href="/controler/notes"><? echo All_notes; ?></a>
				</div>
				<? helper ('tree'); ?>
				<? notesCtTree($list->noteCats,0,0,0,$list->setup['ctNotesTree']); ?>
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
		
			<? if ($list->inPage=='add') { ?>
			<div >
				<div class="in--center--name">
					<? echo Add_note; ?>
				</div>
			</div>
			<? } ?>
			
			<? if (($list->inPage!='add')AND($list->inPage!='false')) { ?>
			<div class="top--link--for--name">
				<div class="in--center--name">
					<? 
					$tree = substr ($list->setup['ctNotesTree'],0,-1); $tree = substr ($tree,1);
					$array = explode('||',$tree); $i=0; 
					foreach ($array as $value):
						foreach ($list->noteCats as $one):
							if ($value==$one['noteCatId']) {
								echo $one['name'];
								echo ' > '; 
								break;
							}
						endforeach;
					endforeach;
					echo $list->note['name'];
					?>
				</div>
				<div class="in--center--button">
					<button class="delete js__delete--button" data-id="<? echo $list->note['noteId']; ?>" data-type="note" data-module="Note"><? echo Delete_; ?></button>
				</div>
			</div>
			<div class="in--center--tabs">
				<? if (isset($list->note['noteId'])) { ?>
				<div onClick="location='/controler/note/index/edit/<? echo $list->note['noteId']; ?>'" <? if ($list->inPage=='edit') { ?>class="tab--menu--active"<?} else { ?>class="tab--menu"<? } ?>>
					<a href="/controler/note/index/edit/<? echo $list->note['noteId']; ?>"><? echo Text_content; ?></a>
				</div>
				<div onClick="location='/controler/note/index/notetabs/<? echo $list->note['noteId']; ?>'" <? if ($list->inPage=='notetabs') { ?>class="tab--menu--active"<?} else { ?>class="tab--menu"<? } ?>>
					<a href="/controler/note/index/notetabs/<? echo $list->note['noteId']; ?>"><? echo Tabs; ?></a>
				</div>
				<div onClick="location='/controler/note/index/advanced/<? echo $list->note['noteId']; ?>'" <? if ($list->inPage=='advanced') { ?>class="tab--menu--active"<?} else { ?>class="tab--menu"<? } ?>>
					<a href="/controler/note/index/advanced/<? echo $list->note['noteId']; ?>"><? echo Advanced_settings; ?></a>
				</div>
				<? foreach ($list->noteTabs as $one): ?>
				<div onClick="location='/controler/note/index/editnotetab/<? echo $list->note['noteId']; ?>/<? echo $one['noteTabId']; ?>'" <? if (($list->inPage=='editnotetab')AND($list->noteTabId==$one['noteTabId'])) { ?>class="tab--menu--active"<?} else { ?>class="tab--menu"<? } ?>>
					<a href="/controler/note/index/editnotetab/<? echo $list->note['noteId']; ?>/<? echo $one['noteTabId']; ?>"><? echo $one['name']; ?></a>
				</div>
				<? endforeach; ?>
				<? foreach ($list->sitNotes as $one) { if ($one['param']=='slider') { ?>
				<div onClick="location='/controler/note/index/slider/<? echo $list->note['noteId']; ?>'" <? if ($list->inPage=='slider') { ?>class="tab--menu--active"<?} else { ?>class="tab--menu"<? } ?>>
					<a href="/controler/note/index/slider/<? echo $list->note['noteId']; ?>"><? echo Slider; ?></a>
				</div>
				<? break; } } ?>
				<div onClick="location='/controler/note/index/situation/<? echo $list->note['noteId']; ?>'" <? if ($list->inPage=='situation') { ?>class="tab--menu--active"<?} else { ?>class="tab--menu"<? } ?>>
					<a href="/controler/note/index/situation/<? echo $list->note['noteId']; ?>"><? echo Scheme; ?></a>
				</div>
				<? } ?>
			</div>
			<? } ?>
		</div>
	
		<div class="under--center--pole">
			<div class="in--shadow--block--11">
				<? if ($list->inPage=='notetabs') { ?>
				<div class="data--table">
					<form method="post" class="js__note--tab--form" action="/controler/note/addNoteTab">
					<input type="hidden" name="noteId" value="<? echo $list->note['noteId']; ?>">
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="name" class="js__note--tab--name">
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
							<button  type="button" class="js__note--tab--button"><? echo Add; ?></button>
						</div>
					</div>
					</form>
					<div class="table--all--no--border">
						<div class="cell--full fail js__info--message">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
							
				<? if (count($list->noteTabs)>0) { ?>
				<table class="all--width--list" >
					<tr class="table--title">
						<td style="width:50px;" align="center">
							<? echo Number; ?>
						</td>
						<td>
							<? echo Name_; ?>
						</td>
						<td align="center" style="width:1px;">
							x
						</td>
					</tr>
					<? $rownum=0; ?>
					<? foreach ($list->noteTabs as $one): ?>
					<tr class="tablerow<? echo $rownum; ?>">
						<td>
							<input style="text-align:center;" type="text" class="js__change--note--tab--number"  data-id="<? echo $one['noteTabId']; ?>" value="<? echo $one['number']; ?>">
						</td>
						<td>
							<input type="text" class="js__change--note--tab--name" data-id="<? echo $one['noteTabId']; ?>" value="<? echo $one['name'.session('languagebase')]; ?>">
						</td>
						<td align="center">
							<button class="deletesm js__delete--button" data-id="<? echo $one['noteTabId']; ?>" data-type="note" data-module="NoteTab"><? echo Delete_; ?></button>
						</td>
					</tr>
					<? $rownum++; if ($rownum==2) { $rownum=0; } ?>
					<? endforeach; ?>
				</table>
				<? } ?>
				<? } ?>
				
				<? if ($list->inPage=='editnotetab') { ?>
				<div class="data--table">
					<form method="post" action="/controler/note/editNoteTab">
					<input type="hidden" name="noteTabId" value="<? echo $list->noteTab['noteTabId']; ?>">
					<input type="hidden" name="noteId" value="<? echo $list->note['noteId']; ?>">
					<div>
						<div>
							<textarea name="text" class="mceAdmin" rows="55"><? echo $list->noteTab['text']; ?></textarea>
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
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
				</div>
				<? } ?>
	
				<? if ($list->inPage=='add') { ?>
				<div class="data--table">
					<form method="post" class="js__note--form" action="/controler/note/addNote">
					<input type="hidden" name="ctNoteCat" value="<? echo $list->setup['ctNoteCat']; ?>">
					<input type="hidden" name="noteId" class="js__note--id" value="0">
					<div class="table--all">
						<div class="cell--name">
							<? echo Parent_group; ?>
						</div>	
						<div class="cell--param">
							<select name="parent">
								<option value="0">------ <? echo Parent_group; ?> ------</option>
								<? helper ('tree'); ?>
								<? noteSelectCtTree($list->noteCats,0,0,0); ?>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Active_chapter; ?>
						</div>	
						<div class="cell--param">
							<select name="chapterId">
								<option value="0">------ <? echo not_chosen; ?> ------</option>
								<? helper ('tree'); ?>
								<? chapterSelectCtTree($list->chapters,0,0,0); ?>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>	
						<div class="cell--param">
							<input type="text" name="name" class="js__note--name">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Url
						</div>	
						<div class="cell--param">
							<input type="text" name="url" class="js__note--url">
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
					<div>
						<div class="sm--top">
							<? echo Full_text; ?>
						</div>
					</div>
					<div>
						<div>
							<textarea id="longtext" rows="40" class="mceAdmin" name="text"></textarea>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Title
						</div>	
						<div class="cell--param">
							<textarea rows="2" name="title"></textarea>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Description
						</div>	
						<div class="cell--param">
							<textarea rows="4" name="description"></textarea>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Keywords
						</div>	
						<div class="cell--param">
							<textarea id="keywords" rows="6" name="keywords"></textarea>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__note--button"><? echo Add; ?></button>
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
				
				<? if ($list->inPage=='edit') { ?>
				<div class="item--back">
					<button type="button" onClick="location='/controler/notes/index/list/<? echo $list->setup['ctNoteCat']; ?>/<? echo $list->setup['ctNotesPage']; ?>'"><? echo Back; ?></button>
				</div>
				<div class="data--table">
					<form enctype="multipart/form-data" method="post" class="js__note--form" action="/controler/note/editNote">
					<input type="hidden" name="noteId" class="js__note--id" value="<? echo $list->note['noteId']; ?>">
					<div class="table--all">
						<div class="cell--name">
							Url
						</div>
						<div class="cell--param">
							<div class="data--text">/note/<? echo $list->note['url']; ?></div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Parent_group; ?>
						</div>
						<div class="cell--param">
							<select name="parent">
								<option value="0" <? if ($list->note['parent']==0) { echo 'selected'; } ?>><? echo Parent_group; ?></option>
								<? helper ('tree'); ?>
								<? noteSelectCtTree($list->noteCats,0,0,$list->note['parent']); ?>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Active_chapter; ?>
						</div>
						<div class="cell--param">
							<select name="chapterId">
								<option value="0">------ <? echo not_chosen; ?> ------</option>
								<? helper ('tree'); ?>
								<? chapterSelectCtTree($list->chapters,0,0,$list->note['chapterId']); ?>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" name="name" class="js__note--name" value="<? echo $list->note['name'.session('languagebase')]; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Url
						</div>
						<div class="cell--param">
							<input type="text" class="js__note--url" name="url" value="<? echo $list->note['url']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Number; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="number" value="<? echo $list->note['number']; ?>">
						</div>
					</div>
					<div>
						<div class="sm--top">
							<? echo Full_text; ?>
						</div>
					</div>
					<div>
						<div>
							<textarea rows="40" id="longtext" class="mceAdmin" name="text"><? echo $list->note['text'.session('languagebase')]; ?></textarea>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Title
						</div>
						<div class="cell--param">
							<textarea rows="2" name="title"><? echo $list->note['title'.session('languagebase')]; ?></textarea>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Description
						</div>
						<div class="cell--param">
							<textarea rows="4" name="description"><? echo $list->note['description'.session('languagebase')]; ?></textarea>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							Keywords
						</div>
						<div class="cell--param">
							<textarea rows="6" id="keywords" name="keywords"><? echo $list->note['keywords'.session('languagebase')]; ?></textarea>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__note--button"><? echo Save; ?></button>
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
	
				<? if ($list->inPage=='situation') { ?>
				<? $data = array ('list' => $list); ?>
				<? echo view('/controler/scheme',$data); ?>
				<? } ?>
	
				<? if ($list->inPage=='slider') { ?>
				<div class="data--table">
					<form enctype="multipart/form-data" method="post" class="js__slider--form" action="/controler/note/addSlider">
					<input type="hidden" name="noteId" class="js__chapter--id" value="<? echo $list->note['noteId']; ?>">
					<div class="table--all">
						<div class="cell--name">
							<? echo Select_an_image; ?> (<? echo $list->note['sliderWidth'];?>x<? echo $list->note['sliderHeight']; ?>px)
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
						<form method="post" action="/controler/note/editSlider">
						<input type="hidden" name="id" value="<? echo $one['id']; ?>">
						<input type="hidden" name="noteId" value="<? echo $list->note['noteId']; ?>">
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
									<button type="button" class="delete js__delete--button" data-id="<? echo $one['id']; ?>" data-type="note" data-module="Slider"><? echo Delete_; ?></button>
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
				
				<? if ($list->inPage=='advanced') { ?>
				<div class="data--table">
					<form method="post" action="/controler/note/editAdvancedSettings" id="noteForm">
					<input type="hidden" id="noteId" name="noteId" value="<? echo $list->note['noteId']; ?>">
					<div class="table--all">
						<div class="cell--name">
							HEAD
						</div>
						<div class="cell--param">
							<textarea rows="10" name="head"><? echo $list->note['head']; ?></textarea>
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
								<option value="<? echo trim($one['1']); ?>" <? if (trim($list->note['theme'])==trim($one['1'])) { echo 'selected'; } ?>><? echo $one['1']; ?></option>
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
							<input type="checkbox" id="js__note--sitemap" name="sitemap" <? if ($list->note['sitemap']==1) { echo 'checked'; } ?> style="display:none;">
							<label for="js__note--sitemap"></label>
							</div>
						</div>
					</div>
					<? if ($list->note['sitemap']==1) { ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Change_freq; ?>
						</div>
						<div class="cell--param">
							<select name="changefreq">
								<option value="always" <? if ($list->note['changefreq']=='always') { echo 'selected'; } ?>>always</option>
								<option value="hourly" <? if ($list->note['changefreq']=='hourly') { echo 'selected'; } ?>>hourly</option>
								<option value="daily" <? if ($list->note['changefreq']=='daily') { echo 'selected'; } ?>>daily</option>
								<option value="weekly" <? if ($list->note['changefreq']=='weekly') { echo 'selected'; } ?>>weekly</option>
								<option value="monthly" <? if ($list->note['changefreq']=='monthly') { echo 'selected'; } ?>>monthly</option>
								<option value="yearly" <? if ($list->note['changefreq']=='yearly') { echo 'selected'; } ?>>yearly</option>
								<option value="never" <? if ($list->note['changefreq']=='never') { echo 'selected'; } ?>>never</option>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Priority; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="priority" value="<? echo $list->note['priority']; ?>">
						</div>
					</div>
					<? } ?>
					<? if ($list->note['chapterId']!=0) { ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Bread_crumbs; ?>
						</div>
						<div class="cell--param">
							<select name="breed">
								<option value="0" <? if ($list->note['breed']==0) { echo 'selected'; } ?>><? echo No; ?></option>
								<option value="1" <? if ($list->note['breed']==1) { echo 'selected'; } ?>><? echo Yes; ?></option>
							</select>
						</div>
					</div>
					<? } ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Secondary_output; ?>
						</div>
						<div class="cell--param">
							<select name="atView">
								<option value="0" <? if ($list->note['atView']==0) { echo 'selected'; } ?>><? echo Nothing; ?></option>
								<option value="1" <? if ($list->note['atView']==1) { echo 'selected'; } ?>><? echo Chapters; ?></option>
								<? if ($list->note['chapterId']!=0) { ?>
								<option value="2" <? if ($list->note['atView']==2) { echo 'selected'; } ?>><? echo Subchapters; ?></option>
								<? } ?>
								<option value="3" <? if ($list->note['atView']==3) { echo 'selected'; } ?>><? echo Composite_menu; ?></option>
							</select>
						</div>
					</div>
					<? foreach ($list->sitNotes as $one) { if ($one['param']=='slider') { ?>
					<div class="table--all">
						<div class="cell--name">
							<? echo Slider_width; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="sliderWidth" value="<? echo $list->note['sliderWidth']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Slider_height; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="sliderHeight" value="<? echo $list->note['sliderHeight']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Fixed_height_width; ?>
						</div>
						<div class="cell--param">
							<div class="data--text--check">
							<input type="checkbox" id="sliderFix" name="sliderfix" <? if ($list->note['sliderFix']==1) { echo 'checked'; } ?> style="display:none;">
							<label for="sliderfix"></label>
							</div>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo The_frequency_of_changing_the_slider_images; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="sliderFreq" value="<? echo $list->note['sliderFreq']; ?>">
						</div>
					</div>
					<? break; } } ?>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button><? echo Save; ?></button>
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full fail" id="infoMessage">
							<? echo session('message'); $session = session(); $session->remove('message'); ?>
						</div>
					</div>
					</form>
				</div>
				<? } ?>
			</div>
			
	
		</div>
		<? } ?>
	</section>
</section>

