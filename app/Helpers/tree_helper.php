<?php  

use \Config\Database as Database;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('chapterSelectCommentsctTree'))
{
	function chapterSelectCommentsctTree($list,$parent=0,$i=0,$active=0,$lang='') {
		$a=0; 
		foreach ($list as $one):
			if ($one['parent']==$parent) { $a=1; break; }
		endforeach;
		if ($a>0) {  $i++;
			foreach ($list as $one):
				if ($parent==0) { $i=0; }
				if ($one['parent']==$parent) { 
					$padding = 2*$i; $probel='';
					for ($j=0;$j<$padding;$j++) {
						$probel = $probel.'-';
					} 
					if ($active!=$one['chapterId']) { echo '<option '; if ($one['type']!='comments') { echo 'disabled'; } echo ' value="'.$one['chapterId'].'">'.$probel.' '.$one['name'.$lang].'</option>'; } 
					if ($active==$one['chapterId']) { echo '<option value="'.$one['chapterId'].'" selected>'.$probel.' '.$one['name'.$lang].'</option>'; } 
					chapterSelectCommentsctTree($list,$one['chapterId'],$i,$active,$lang);
				}
				
			endforeach;
		} 
	}
}

if ( ! function_exists('noteSelectCtTree'))
{
	function noteSelectCtTree($list,$parent=0,$i=0,$active=0,$noteCatId=0) {
		$a=0; 
		foreach ($list as $one):
			if ($one['parent']==$parent) { $a=1; break; }
		endforeach;
		if ($a>0) {  $i++;
			foreach ($list as $one): 
				if ($one['noteCatId']!=$noteCatId) {
				if ($parent==0) { $i=0; }
				if ($one['parent']==$parent) { 
					$padding = 2*$i; $probel='';
					for ($j=0;$j<$padding;$j++) {
						$probel = $probel.'-';
					} 
					if ($active!=$one['noteCatId']) { echo '<option value="'.$one['noteCatId'].'">'.$probel.' '.$one['name'].'</option>'; } 
					if ($active==$one['noteCatId']) { echo '<option value="'.$one['noteCatId'].'" selected>'.$probel.' '.$one['name'].'</option>'; } 
					noteSelectCtTree($list,$one['noteCatId'],$i,$active,$noteCatId);
				}
				}
			endforeach;
		} 
	}
}

if ( ! function_exists('notesCtTree'))
{
	function notesCtTree($list,$parent,$i,$active,$tree) {
		$a=0;
		foreach ($list as $one):
			if ($one['parent']==$parent) { $a=1; break; }
		endforeach;
		if ($a>0) {  $i++;
			foreach ($list as $one): 
				if ($parent==0) { $i=0; }
				if ($one['parent']==$parent) { 
					$padding = 10*$i;
					
						if ((strpos($tree,'|'.$parent.'|')!==FALSE)OR($parent==0)) {
							
								echo '
								<div onClick="location=\'/controler/notes/index/list/'.$one['noteCatId'].'\'" '; if (strpos($tree,'|'.$one['noteCatId'].'|')!==FALSE) { echo 'class="column--link--active"'; } else { echo 'class="column--link"';  } echo 'style="padding:7px 7px 7px '.(7+$padding).'px;">
									<a href="/controler/notes/index/list/'.$one['noteCatId'].'" '; if ($padding>0) { echo 'style="font-size:90%;"'; } echo '>'.$one['name'].'</a>
								</div>
								
								
								';
							
						}
					
					notesCtTree($list,$one['noteCatId'],$i,$active,$tree);
				}
			endforeach;
		} 
	}
}

if ( ! function_exists('chapterSelectFaqCtTree'))
{
	function chapterSelectFaqCtTree($list,$parent=0,$i=0,$active=0,$lang='') {
		$a=0; 
		foreach ($list as $one):
			if ($one['parent']==$parent) { $a=1; break;}
		endforeach;
		if ($a>0) {  $i++;
			foreach ($list as $one): 
				if ($parent==0) { $i=0; }
				if ($one['parent']==$parent) { 
					$padding = 2*$i; $probel='';
					for ($j=0;$j<$padding;$j++) {
						$probel = $probel.'-';
					} 
					if ($active!=$one['chapterId']) { echo '<option '; if ($one['type']!='faq') { echo 'disabled'; } echo ' value="'.$one['chapterId'].'">'.$probel.' '.$one['name'.$lang].'</option>'; } 
					if ($active==$one['chapterId']) { echo '<option value="'.$one['chapterId'].'" selected>'.$probel.' '.$one['name'.$lang].'</option>'; } 
					chapterSelectFaqCtTree($list,$one['chapterId'],$i,$active,$lang);
				}
				
			endforeach;
		} 
	}
}

if ( ! function_exists('commentsArTree'))
{
	function commentsArTree($list,$parent,$i,$name,$comm,$send,$answer) {
		 $i++;
		foreach ($list as $one): 
			if ($parent==0) { $i=0; }
			if ($one['parentComment']==$parent) { 
				$padding = $i;
				echo '
					<div class="js__commeny--in--article'.$padding.'">
						<div class="fnc--comments--listitem">
							<div class="fnc--comments--listitem__main">
								<div class="fnc--comments--listitem__name">
									'.$one['firstName'].'
								</div>
								<div class="fnc--comments--listitem__date">
									'.date('H:i d.m.Y',$one['date']).'
								</div>
							</div>
							<div class="fnc--comments--listitem__text">
								'.$one['text'].'
							</div>
						</div>
						<span class="comment--quote pointerhand js__addcomment--addanswer--show" data-id="'.$one['commentId'].'">'.$answer.'</span>
						<div class="fnc--addcomment--container--none'.$one['commentId'].'" style="display:none;">
							<div class="fnc--addcomment--item">
								<input placeholder="'.$name.'" type="text" class="js__addcomment--inarticle--firstname'.$one['commentId'].'" value="">
							</div>
							<div class="fnc--addcomment--item">
								<textarea placeholder="'.$comm.'" rows="5" class="js__addcomment--inarticle--text'.$one['commentId'].'"></textarea>
							</div>
							<div class="fnc--addcomment--item"><div class="addcomment_button"><button type="button" class="js__addcomment--inarticle--button" data-left="'.$padding.'" data-id="'.$one['commentId'].'" data-parent="'.$one['articleId'].'">'.$answer.'</button></div></div>
							<div class="fnc--addcomment--item"><div class="addcomment_info js__addcomment--inarticle--info'.$one['commentId'].'"></div></div>
						</div>
					</div>';
					commentsArTree($list,$one['commentId'],$i,$name,$comm,$send,$answer);
				}
			endforeach;	
	}
}

if ( ! function_exists('chapterSelectCtTree'))
{
	function chapterSelectCtTree($list,$parent=0,$i=0,$visible=0,$chapterId=0,$lang='') {
		$a=0; echo $lang;
		foreach ($list as $one):
			if ($one['parent']==$parent) { $a=1; break; }
		endforeach;
		if ($a>0) {  $i++;
			foreach ($list as $one): 
				if ($one['chapterId']!=$chapterId) {
					if ($parent==0) { $i=0; }
					if ($one['parent']==$parent) { 
						$padding = 2*$i; $probel='';
						for ($j=0;$j<$padding;$j++) {
							$probel = $probel.'-';
						} 
						if ($visible!=$one['chapterId']) { echo '<option value="'.$one['chapterId'].'">'.$probel.' '.$one['name'.$lang].'</option>'; } 
						if ($visible==$one['chapterId']) { echo '<option value="'.$one['chapterId'].'" selected>'.$probel.' '.$one['name'.$lang].'</option>'; } 
						chapterSelectCtTree($list,$one['chapterId'],$i,$visible,$chapterId,$lang);
					}
				}
			endforeach;
		} 
	}
}

if ( ! function_exists('chaptersCtTree'))
{
	function chaptersCtTree($list,$parent,$i,$visible,$tree,$openchaptersct,$seenoactivechapters,$lang='') {
		$a=0;
		foreach ($list as $one):
			if ($one['parent']==$parent) { $a=1; break; }
		endforeach;
		if ($a>0) {  $i++;
			foreach ($list as $one): 
				if ($parent==0) { $i=0; }
				if ($one['parent']==$parent) { 
					$padding = 10*$i;
					if (($one['type']=='articles')OR($one['type']=='faq')OR($one['type']=='comments')OR($one['type']=='gallery')OR($one['type']=='files')) { $typepage='list'; } else { $typepage='text'; }
					if ($openchaptersct==1) {
						if ($seenoactivechapters==1) {
							echo '
							<div onClick="location=\'/controler/chapters/index/'.$typepage.'/'.$one['chapterId'].'\'" '; if (strpos($tree,'|'.$one['chapterId'].'|')!==FALSE) { echo 'class="column--link--active"'; } else { if ($one['visible']==1) { echo 'class="column--link"'; } else { echo 'class="column--link--not"'; } } echo 'style="padding:7px 7px 7px '.(7+$padding).'px;">
								<a href="/controler/chapters/index/'.$typepage.'/'.$one['chapterId'].'" '; if ($padding>0) { echo 'style="font-size:90%;"'; } echo '>'.$one['name'.$lang].'</a>
							</div>
							';
						} else {
							if ($one['visible']==1)	 {
								echo '
								<div onClick="location=\'/controler/chapters/index/'.$typepage.'/'.$one['chapterId'].'\'" '; if (strpos($tree,'|'.$one['chapterId'].'|')!==FALSE) { echo 'class="column--link--active"'; } else { if ($one['visible']==1) { echo 'class="column--link"'; } else { echo 'class="column--link--not"'; } } echo 'style="padding:7px 7px 7px '.(7+$padding).'px;">
									<a href="/controler/chapters/index/'.$typepage.'/'.$one['chapterId'].'" '; if ($padding>0) { echo 'style="font-size:90%;"'; } echo '>'.$one['name'.$lang].'</a>
								</div>
								';
							}
						}
					} else {
						if ((strpos($tree,'|'.$parent.'|')!==FALSE)OR($parent==0)) {
							if ($seenoactivechapters==1) {
								echo '
								<div onClick="location=\'/controler/chapters/index/'.$typepage.'/'.$one['chapterId'].'\'" '; if (strpos($tree,'|'.$one['chapterId'].'|')!==FALSE) { echo 'class="column--link--active"'; } else { if ($one['visible']==1) { echo 'class="column--link"'; } else { echo 'class="column--link--not"'; } } echo 'style="padding:7px 7px 7px '.(7+$padding).'px;">
									<a href="/controler/chapters/index/'.$typepage.'/'.$one['chapterId'].'" '; if ($padding>0) { echo 'style="font-size:90%;"'; } echo '>'.$one['name'.$lang].'</a>
								</div>
								';
							} else {
								if ($one['visible']==1)	 {
									echo '
									<div onClick="location=\'/controler/chapters/index/'.$typepage.'/'.$one['chapterId'].'\'" '; if (strpos($tree,'|'.$one['chapterId'].'|')!==FALSE) { echo 'class="column--link--active"'; } else { if ($one['visible']==1) { echo 'class="column--link"'; } else { echo 'class="column--link--not"'; } } echo 'style="padding:7px 7px 7px '.(7+$padding).'px;">
										<a href="/controler/chapters/index/'.$typepage.'/'.$one['chapterId'].'" '; if ($padding>0) { echo 'style="font-size:90%;"'; } echo '>'.$one['name'.$lang].'</a>
									</div>
									';
								}
							}
						}
					}
					chaptersCtTree($list,$one['chapterId'],$i,$visible,$tree,$openchaptersct,$seenoactivechapters,$lang);
				}
			endforeach;
		} 
	}
}

if ( ! function_exists('chapterSelectArticlesCtTree'))
{
	function chapterSelectArticlesCtTree($list,$parent=0,$i=0,$active=0,$lang='') {
		$a=0; 
		foreach ($list as $one):
			if ($one['parent']==$parent) { $a=1; break; }
		endforeach;
		if ($a>0) {  $i++;
			foreach ($list as $one): 
				if ($parent==0) { $i=0; }
				if ($one['parent']==$parent) { 
					$padding = 2*$i; $probel='';
					for ($j=0;$j<$padding;$j++) {
						$probel = $probel.'-';
					} 
					if ($active!=$one['chapterId']) { echo '<option '; if ($one['type']!='articles') { echo 'disabled'; } echo ' value="'.$one['chapterId'].'">'.$probel.' '.$one['name'.$lang].'</option>'; } 
					if ($active==$one['chapterId']) { echo '<option value="'.$one['chapterId'].'" selected>'.$probel.' '.$one['name'.$lang].'</option>'; } 
					chapterSelectArticlesCtTree($list,$one['chapterId'],$i,$active);
				}
			endforeach;
		} 
	}
}

if ( ! function_exists('chaptersTree'))
{
	function chaptersTree($list,$allparent,$parent,$i,$active,$tree,$openchap,$pos,$langname='',$langlink='',$lang='') {
		
		$a=0;
		foreach ($list as $one):
			if ($one['parent']==$parent) { $a=1; break; }
		endforeach;
		if ($a>0) {  $i++;
			foreach ($list as $one): 
				if ($parent==$allparent) { $i=0; }
				if ($one['parent']==$parent) {  
					$padding = 10*$i;
					if (($one['position']==$pos)OR(($one['position']=='all')AND($pos!='left1')AND($pos!='right1'))) { 
						if ($openchap==1) {
							echo '
							<div '; if ($one['link'.$langname]=='') { echo 'onClick="location=\'/'.$langlink.$one['url'].'\'" ';  } else { echo 'onClick="location=\''.$one['link'.$langname].'\'" '; }
								if (strpos($tree,'|'.$one['chapterId'].'|')!==FALSE) { echo 'class="fnc--column--chapter__active'.$i.' '.$one['addClass'].'"'; } else { echo 'class="fnc--column--chapter'.$i.' '.$one['addClass'].'"'; }
									echo '
									><a ';
									if ($one['link'.$langname]=='') { echo 'href="/'.$langlink.$one['url'].'">'.$one['name'.$langname].'</a>'; } else { echo 'href="'.$one['link'.$langname].'">'.$one['name'.$langname].'</a>'; }
							echo '
							</div>
							';
						} else {
							if ((strpos($tree,'|'.$parent.'|')!==FALSE)OR($parent==0)) {
								echo '
								<div '; if ($one['link'.$langname]=='') { echo 'onClick="location=\'/'.$langlink.$one['url'].'\'" ';  } else { echo 'onClick="location=\''.$one['link'.$langname].'\'" '; }
								if (strpos($tree,'|'.$one['chapterId'].'|')!==FALSE) { echo 'class="fnc--column--chapter__active'.$i.' '.$one['addClass'].'"'; } else { echo 'class="fnc--column--chapter'.$i.' '.$one['addClass'].'"'; }
									echo '
									><a ';
									if ($one['link'.$langname]=='') { echo 'href="/'.$langlink.$one['url'].'">'.$one['name'.$langname].'</a>'; } else { echo 'href="'.$one['link'.$langname].'">'.$one['name'.$langname].'</a>'; }
								echo '
								</div>
								';
							}
						}
					} 
					chaptersTree($list,$allparent,$one['chapterId'],$i,$active,$tree,$openchap,$pos,$langname,$langlink);
				}
			endforeach;
		} 
	}
}

if ( ! function_exists('chapterSecondCtTree'))
{
	function chapterSecondCtTree($list,$parent=0,$i=0,$id,$compmenu,$lang='') {
		$a=0; 
		foreach ($list as $one):
			if ($one['parent']==$parent) { $a=1; break; }
		endforeach;
		if ($a>0) {  $i++;
			foreach ($list as $one): 
				if ($parent==0) { $i=0; }
				if ($one['parent']==$parent) { 
					$padding = 2*$i; $probel='';
					for ($j=0;$j<$padding;$j++) {
						$probel = $probel.'-';
					} 
					$dis=0;
					foreach ($compmenu as $three):
						if ($three['menuId']==$one['chapterId']) {
							$dis=1;
						}
					endforeach;
					if (($id==$one['chapterId'])OR($dis==1)) { 
						echo '<option value="'.$one['chapterId'].'" disabled>'.$probel.' '.$one['name'.$lang].'</option>'; 
					} else {
						echo '<option value="'.$one['chapterId'].'">'.$probel.' '.$one['name'.$lang].'</option>'; 
					}
					chapterSecondCtTree($list,$one['chapterId'],$i,$id,$compmenu,$lang);
				}
			endforeach;
		} 
	}
}

if ( ! function_exists('chapterSelectGalleryCtTree'))
{
	function chapterSelectGalleryCtTree($list,$parent=0,$i=0,$active=0,$lang='') {
		$a=0; 
		foreach ($list as $one):
			if ($one['parent']==$parent) { $a=1; break; }
		endforeach;
		if ($a>0) {  $i++;
			foreach ($list as $one): 
				if ($parent==0) { $i=0; }
				if ($one['parent']==$parent) { 
					$padding = 2*$i; $probel='';
					for ($j=0;$j<$padding;$j++) {
						$probel = $probel.'-';
					} 
					if ($active!=$one['chapterId']) { echo '<option '; if ($one['type']!='gallery') { echo 'disabled'; } echo ' value="'.$one['chapterId'].'">'.$probel.' '.$one['name'.$lang].'</option>'; } 
					if ($active==$one['chapterId']) { echo '<option value="'.$one['chapterId'].'" selected>'.$probel.' '.$one['name'.$lang].'</option>'; } 
					chapterSelectGalleryCtTree($list,$one['chapterId'],$i,$active,$lang);
				}
			endforeach;
		} 
	}
}

if ( ! function_exists('chapterSelectFileCtTree'))
{
	function chapterSelectFileCtTree($list,$parent=0,$i=0,$active=0,$lang='') {
		$a=0; 
		foreach ($list as $one):
			if ($one['parent']==$parent) { $a=1; break; }
		endforeach;
		if ($a>0) {  $i++;
			foreach ($list as $one): 
				if ($parent==0) { $i=0; }
				if ($one['parent']==$parent) { 
					$padding = 2*$i; $probel='';
					for ($j=0;$j<$padding;$j++) {
						$probel = $probel.'-';
					} 
					if ($active!=$one['chapterId']) { echo '<option '; if ($one['type']!='files') { echo 'disabled'; } echo ' value="'.$one['chapterId'].'">'.$probel.' '.$one['name'.$lang].'</option>'; } 
					if ($active==$one['chapterId']) { echo '<option value="'.$one['chapterId'].'" selected>'.$probel.' '.$one['name'.$lang].'</option>'; } 
					chapterSelectFileCtTree($list,$one['chapterId'],$i,$active,$lang);
				}
			endforeach;
		} 
	}
}

if ( ! function_exists('usersCtTree'))
{
	function usersCtTree($list,$parent,$i,$active,$tree) {
		$a=0;
		foreach ($list as $one):
			if ($one['parent']==$parent) { $a=1; break; }
		endforeach;
		if ($a>0) {  $i++;
			foreach ($list as $one): 
				if ($parent==0) { $i=0; }
				if ($one['parent']==$parent) { 
					$padding = 10*$i;
					
						if ((strpos($tree,'|'.$parent.'|')!==FALSE)OR($parent==0)) {
								
								$userCatId = $one['userCatId'];
								echo '
								<div onClick="location=\'/controler/users/index/list/'.$one['userCatId'].'\'" '; if (strpos($tree,'|'.$one['userCatId'].'|')!==FALSE) { echo 'class="column--link--active"'; } else { echo 'class="column--link"'; } echo 'style="padding:7px 7px 7px '.(7+$padding).'px;">
									<a href="/controler/users/index/list/'.$one['userCatId'].'" '; if ($padding>0) { echo 'style="font-size:90%;"'; } echo '>'.$one['name'].' <span class="js__see--count--users" data-id="'.$one['userCatId'].'"></span></a>
								</div>
								';
							
						}
					
					usersCtTree($list,$one['userCatId'],$i,$active,$tree);
				}
			endforeach;
		} 
	}
}

if ( ! function_exists('userSelectCtTree'))
{
	function userSelectCtTree($list,$parent=0,$i=0,$active=0,$userCatId=0) {
		$a=0; 
		foreach ($list as $one):
			if ($one['parent']==$parent) { $a=1; break; }
		endforeach;
		if ($a>0) {  $i++;
			foreach ($list as $one): 
				if ($one['userCatId']!=$userCatId) {
					if ($parent==0) { $i=0; }
					if ($one['parent']==$parent) { 
						$padding = 2*$i; $probel='';
						for ($j=0;$j<$padding;$j++) {
							$probel = $probel.'-';
						} 
						if ($active!=$one['userCatId']) { echo '<option value="'.$one['userCatId'].'">'.$probel.' '.$one['name'].'</option>'; } 
						if ($active==$one['userCatId']) { echo '<option value="'.$one['userCatId'].'" selected>'.$probel.' '.$one['name'].'</option>'; } 
						userSelectCtTree($list,$one['userCatId'],$i,$active,$userCatId);
					}
				}
			endforeach;
		} 
	}
}
