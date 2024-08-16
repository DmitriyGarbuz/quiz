<? foreach ($list->materials as $one): ?>
	<div class="search--list--item">
		<div class="search--list--item__name">
			<? if ($one['tbl_name']=='chapters') { ?>
			<a href="/<? echo session('Langlink'); ?><?echo $one['url']; ?>"><? echo $one['name'.session('Langtext')]; ?></a>
			<? } ?>
			<? if ($one['tbl_name']=='articles') { ?>
			<a href="/<? echo session('Langlink'); ?>article/<?echo $one['url']; ?>"><? echo $one['name'.session('Langtext')]; ?></a>
			<? } ?>
		</div>
		<div class="search--list--item__info">
			<? 
			$text = $one['text'.session('Langtext')]; $text = str_replace ('<p>','<br>',$text); $text = str_replace ('</p>','',$text); $text = strip_tags($text,'<br>'); $text = trim($text);
			$pos = mb_strpos ($text,session('searchWord')); $oldpos = $pos-200; if ($oldpos<0) { $oldpos=0; }
			$newpos = $pos+200; if ($newpos>mb_strlen($text)) { $newpos=mb_strlen($text); } $text = mb_substr($text,$oldpos,$newpos-$oldpos); $text = str_replace ('&nbsp;',' ',$text);
			$text = str_replace (session('searchWord'),'<b>'.session('searchWord').'</b>',$text);
			echo trim($text);
			?>
		</div>
	</div>
<? endforeach; ?>