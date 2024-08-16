<div class="breadcrumbs breads">
	<div class="breads__conteiner">
		<? $col = count($list->breedchapters);
		echo '<div class="breads__inner" itemscope itemtype="http://schema.org/BreadcrumbList">';
		if ($_SERVER['REQUEST_URI']!='/') { 
			echo '<div itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breads--inner__item">
				<a itemprop="item" href="/'.Langlink.'">'.$list->confLang['home'].'<meta itemprop="name" content="'.$list->confLang['home'].'"><meta itemprop="position" content="1"></a>
			</div>';
			echo '<div class="breads--inner__item__separator">►</div>'; 
		}
		$o=0;
		foreach ($list->breedchapters as $one):
			if ($o!=0) { echo '<div class="breads--inner__item__separator">►</div>'; }
			if (($o+1)<$col) {
				echo '<div itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" '; if ($list->chapter['chapterId']==$one['chapterId']) { echo 'class="breads--inner__item__active"'; } else { echo 'class="breads--inner__item"'; } echo '>
					<a itemprop="item" '; if ($one['link'.Langtext]=='') { echo ' href="/'.Langlink.$one['url'].'" '; } else { echo ' href="'.$one['link'.Langtext].'" '; } echo '">'.$one['name'.Langtext].'<meta itemprop="name" content="'.$one['name'.Langtext].'"><meta itemprop="position" content="'.($o+2).'"></a>
				</div>';
			} else{
				echo '<div class="breads--inner__item"><span>'.$one['name'.Langtext].'</span></div>';
			}
			$o++;
		endforeach; 
		echo '</div>';
		?>
	</div>
</div>