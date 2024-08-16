<div class="breadcrumbs breads">
	<div class="breads__container">
		<? 
		echo '<div class="breads__inner" itemscope itemtype="http://schema.org/BreadcrumbList">';
		echo '<div itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breads--inner__item">
			<a itemprop="item" href="/'.Langlink.'">'.$list->confLang['home'].'<meta itemprop="name" content="'.$list->confLang['home'].'">
			<meta itemprop="position" content="1"></a>
		</div>';
		echo '<div class="class="breads--inner__separator"">►</div>';
		echo '<div class="breads--inner__item__active"><span>'.$options['pageName'].'</span></div>';
		echo '</div>';
		?>
	</div>
</div>