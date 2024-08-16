<div class="breadcrumbs breads">
	<div class="breads__container">
		<? $col = count($list->breedchapters);
		echo '<div class="breads__inner" itemscope itemtype="http://schema.org/BreadcrumbList">';
		if ($_SERVER['REQUEST_URI']!='/') { 
			echo '<div itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breads--inner__item">
				<a itemprop="item" href="/'.session('Langlink').'">'.$list->confLang['home'].'<meta itemprop="name" content="'.$list->confLang['home'].'"><meta itemprop="position" content="1"></a>
			</div>';
			echo '<div class="breads--inner__item__separator">►</div>'; 
		}
		$o=0;
		foreach ($list->breedchapters as $one):
			if ($o!=0) { echo '<div class="breads--inner__item__separator">►</div>';  }
			echo '<div itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breads--inner__item">
			<a itemprop="item" '; if ($one['link'.session('Langtext')]=='') { echo ' href="/'.session('Langlink').$one['url'].'" '; } else { echo ' href="'.$one['link'.session('Langtext')].'" '; } echo '">'.$one['name'.session('Langtext')].'
				<meta itemprop="name" content="'.$one['name'.session('Langtext')].'">
				<meta itemprop="position" content="'.($o+2).'">
			</a></div>';
			$o++;
		endforeach; 
		echo '<div class="breads--inner__item__separator">►</div>'; 
		echo '<div class="breads--inner__item__active"><span>'.$list->article['name'.session('Langtext')].'</span></div>';
		echo '</div>';
		?>
	</div>
</div>