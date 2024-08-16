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
					<? echo Add_group; ?>
				</div>
			</div>
			<? } ?>
			
			<? if ($list->setup['ctNotesTree']!='') { ?>
			<div class="top--link--for--name">
				<div class="in--center--name">
					<? 
					$tree = substr ($list->setup['ctNotesTree'],0,-1); $tree = substr ($tree,1);
					$array = explode('||',$tree); $i=0; 
					foreach ($array as $value):
						foreach ($list->noteCats as $one):
							if ($value==$one['noteCatId']) {
								if ($i!=0) { echo ' > '; } $i++; echo $one['name']; break;
							}
						endforeach;
					endforeach;
					?>
				</div>
				<div class="in--center--button">
					<button class="delete js__delete--button" data-id="<? echo $list->noteCat['noteCatId']; ?>" data-type="notes" data-module="NoteCat"><? echo Delete_; ?></button>
				</div>
			</div>
			<? } ?>
			
			<? if ($list->setup['ctNotesTree']!='') { ?>
			<div class="in--center--tabs">
				<div onClick="location='/controler/notes/index/edit/<? echo $list->noteCat['noteCatId']; ?>'" <? if ($list->inPage=='edit') { ?>class="tab--menu--active"<?} else { ?>class="tab--menu"<? } ?>>
					<a href="/controler/notes/index/edit/<? echo $list->noteCat['noteCatId']; ?>"><? echo Settings; ?></a>
				</div>
			</div>
			<? } ?>
			<? if ($list->inPage=='list') { ?>
			<div class="in--search--tabs">
				<form class="js__search--form" method="post" action="/controler/notes/search">
				<div class="search--line">
					<div>
						<input type="text" class="searchpole js__search--pole" name="search" placeholder="<? echo Search; ?>" value="<? if (session('ctNoteSearch')!='') { echo session('ctNoteSearch'); } ?>">
					</div>
					<div>
						<button type="button" class="js__search--button"><? echo Search; ?></button>
					</div>
					<div>
						<button type="button" class="delete js__unsearch--button" data-page="notes"><? echo Cancel; ?></button>
					</div>
				</div>
				</form>
			</div>
			<? } ?>
		</div>
		
		<div class="under--center--pole">
			<div class="in--shadow--block--11">
				<? if ($list->inPage=='add') { ?>
				<div class="data--table">
					<form method="post" class="js__note--cat--form" action="/controler/notes/addNoteCat">
					<div class="table--all">
						<div class="cell--name">
							<? echo Parent_group; ?>
						</div>
						<div class="cell--param">
							<script type="text/javascript">jQuery(document).ready(function($) {$(".js__note--cat--parent").chosen({width: '100%',allow_single_deselect: true}).trigger("chosen:updated");});</script>
							<select class="js__note--cat--parent" name="parent">
								<option value="0">------ <? echo Parent_group; ?> ------</option>
								<? noteSelectCtTree($list->noteCats,0,0,0); ?>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" name="name" class="js__note--cat--name">
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
							<button type="button" class="js__note--cat--button"><? echo Add; ?></button>
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
				
				<? if ($list->inPage=='list') { ?>
				<? if (count($list->notes)>0) { ?>
				<table class="all--width--list" >
					<tr class="table--title">
						<td style="width:1px;" align="center">
							<? echo Number; ?>
						</td>
						<td>
							<? echo Name_; ?>
						</td>
						<td style="width:250px">
							<? echo Group; ?>
						</td>
						<td align="center" style="width:1px;">
							
						</td>
					</tr>
					<? $rownum=0; ?>
					<? foreach ($list->notes as $one): ?>
					<tr class="table--row<? echo $rownum; ?>">
						<td align="center">
							<input style="text-align:center;" type="text" class="js__change--note--number" value="<? echo $one['number']; ?>" data-id="<? echo $one['noteId']; ?>">
						</td>
						<td >
							<a class="table--link" href="/controler/note/index/edit/<? echo $one['noteId']; ?>"><? echo $one['name'.session('languagebase')]; ?></a>
						</td>
						<td>
							<script type="text/javascript">jQuery(document).ready(function($) {$(".js__change--note--parent<? echo $one['noteId']; ?>").chosen({width: '100%',allow_single_deselect: true}).trigger("chosen:updated");});</script>
							<select class="js__change--note--parent<? echo $one['noteId']; ?>" style="width:100%;" data-id="<? echo $one['noteId']; ?>">
								<option value="0" <? if ($one['parent']==0) { echo 'selected'; } ?>><? echo Parent_group; ?></option>
								<? helper ('tree'); ?>
								<? noteSelectCtTree($list->noteCats,0,0,$one['parent']); ?>
							</select>
						</td>
						<td align="center">
							<button class="deletesm js__delete--button" data-id="<? echo $one['noteId']; ?>" data-type="note" data-module="Note"><? echo Delete_; ?></button>
						</td>
					</tr>
					<? $rownum++; if ($rownum==2) { $rownum=0; } ?>
					<? endforeach; ?>
				</table>
				<? if ($list->coun>$list->confSet['notesPerCt']) { ?>
				<div class="pagination">
					<? 
					$aaa = $list->coun%$list->confSet['notesPerCt']; $list->inPages = $list->coun/$list->confSet['notesPerCt']; $list->inPages = $list->inPages+1; 
					$j = ($list->setup['ctNotesPage']/$list->confSet['notesPerCt'])+1;
					$i = $j-6; $prim = $i; $max = $j+6;
					if ($max>$list->inPages) { $max=$list->inPages; }
					if ($i<1) { $i=1; }
					$rightctNotesPage = $j*$list->confSet['notesPerCt']; $leftctNotesPage = ($j-2)*$list->confSet['notesPerCt'];
					if ($list->setup['ctNotesPage']!=0) { ?><div onClick="location='/controler/notes/index/list/<? echo $list->setup['ctnotecat']; ?>/<? echo $leftctNotesPage; ?>'" ><a  href="/controler/notes/index/list/<? echo $list->setup['ctnotecat']; ?>/<? echo $leftctNotesPage; ?>"><<</a></div><? }
						for ($i;$i<=$max;$i++) {
							$ctNotesPage = ($i-1)*$list->confSet['notesPerCt'];
							$j = ($list->setup['ctNotesPage']/$list->confSet['notesPerCt'])+1;
							if ($j==$i) { echo '<div class="pagenow">'.$i.'</td>'; } else {
							if (($i!=$max)AND($i!=$prim)) { ?> <div onClick="location='/controler/notes/index/list/<? echo $list->setup['ctnotecat']; ?>/<? echo $ctNotesPage; ?>'" class="pagenotnow"><a href="/controler/notes/index/list/<? echo $list->setup['ctnotecat']; ?>/<? echo $ctNotesPage; ?>"><? echo $i; ?></a></div> <?  } }
						}	
					if ($list->setup['ctNotesPage']/$list->confSet['notesPerCt']+2<$list->inPages) { ?><div onClick="location='/controler/notes/index/list/<? echo $list->setup['ctnotecat']; ?>/<? echo $rightctNotesPage; ?>'" ><a  href="/controler/notes/index/list/<? echo $list->setup['ctnotecat']; ?>/<? echo $rightctNotesPage; ?>">>></a></div><? } ?>
				</div>
				<? } ?>
				<? } ?>
				<? } ?>
				
				<? if ($list->inPage=='edit') { ?>
				<div class="data--table">
					<form method="post" class="js__note--cat--form" action="/controler/notes/editNoteCat">
					<input type="hidden" name="noteCatId" class="js__note--cat--id" value="<? echo $list->noteCat['noteCatId']; ?>">
					<div class="table--all">
						<div class="cell--name">
							<? echo Parent_group; ?>
						</div>
						<div class="cell--param">
							<script type="text/javascript">jQuery(document).ready(function($) {$(".js__note--cat--parent").chosen({width: '100%',allow_single_deselect: true}).trigger("chosen:updated");});</script>
							<select class="js__note--cat--parent" name="parent">
								<option value="0">------ <? echo Parent_group; ?> ------</option>
								<? helper ('tree'); ?>
								<? noteSelectCtTree($list->noteCats,0,0,$list->noteCat['parent'],$list->noteCat['noteCatId']); ?>
							</select>
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Name_; ?> <span class="star">*</span>
						</div>
						<div class="cell--param">
							<input type="text" name="name" class="js__note--cat--name" value="<? echo $list->noteCat['name']; ?>">
						</div>
					</div>
					<div class="table--all">
						<div class="cell--name">
							<? echo Number; ?>
						</div>
						<div class="cell--param">
							<input type="text" name="number" value="<? echo $list->noteCat['number']; ?>">
						</div>
					</div>
					<div class="table--all--no--border">
						<div class="cell--full">
							<button type="button" class="js__note--cat--button"><? echo Save; ?></button>
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
			</div>
			
	
		</div>
		<? } ?>
	</section>
</section>

