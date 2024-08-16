<!DOCTYPE html>
<? header('Content-Type: text/html; charset=utf-8'); ?>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="NespiCMS" />
<? $theme=$list->confSet['themecss']; ?>
<? if ($list->metaPage=='chapter') { ?>
<? if ($list->setup['chapterPage']>0) { ?>
<meta name="robots" content="noindex, follow">
<link rel="canonical" href="<? echo base_url().session('Langlink'); ?><? echo $list->chapter['url']; ?>" />
<? } ?>
<title><? echo $list->chapter['title'.session('Langtext')]; ?></title>
<meta name="description" content="<? echo $list->chapter['description'.session('Langtext')]; ?>">
<meta name="keywords" content="<? echo $list->chapter['keywords'.session('Langtext')]; ?>">
<meta property="og:type" content="article">
<meta property="og:title" content="<? echo $list->chapter['title'.session('Langtext')]; ?>">
<meta property="og:description" content="<? echo $list->chapter['description'.session('Langtext')]; ?>">
<meta property="og:image" content="<? echo base_url().$list->chapter['preview']; ?>">
<meta property="og:url" content="<? echo base_url().session('Langlink').$list->chapter['url']; ?>">
<meta name="twitter:title" content="<? echo $list->chapter['title'.session('Langtext')]; ?>">
<meta name="twitter:description" content="<? echo $list->chapter['description'.session('Langtext')]; ?>">
<meta name="twitter:image" content="<? echo base_url().$list->chapter['preview']; ?>" />
<? if ($list->chapter['theme']!='') { $theme='themes/'.strtolower($list->chapter['theme']).'.css'; } ?>
<? } ?>
<? if ($list->metaPage=='article') { ?>
<title><? echo $list->article['title'.session('Langtext')]; ?></title>
<meta name="description" content="<? echo $list->article['description'.session('Langtext')]; ?>">
<meta name="keywords" content="<? echo $list->article['keywords'.session('Langtext')]; ?>">
<meta property="og:type" content="article">
<meta property="og:title" content="<? echo $list->article['title'.session('Langtext')]; ?>">
<meta property="og:description" content="<? echo $list->article['description'.session('Langtext')]; ?>">
<meta property="og:image" content="<? echo base_url().$list->article['preview']; ?>">
<meta property="og:url" content="<? echo base_url().session('Langlink').'article/'.$list->article['url']; ?>">
<meta name="twitter:title" content="<? echo $list->article['title'.session('Langtext')]; ?>">
<meta name="twitter:description" content="<? echo $list->article['description'.session('Langtext')]; ?>">
<meta name="twitter:image" content="<? echo base_url().$list->article['preview']; ?>">
<? if ($list->chapter['theme']!='') { $theme='themes/'.strtolower($list->chapter['theme']).'.css'; } ?>
<? } ?>
<? if ($list->metaPage=='note') { ?>
<title><? echo $list->note['title']; ?></title>
<meta name="description" content="<? echo $list->note['description'.session('Langtext')]; ?>">
<meta name="keywords" content="<? echo $list->note['keywords'.session('Langtext')]; ?>">
<meta property="og:title" content="<? echo $list->note['title'.session('Langtext')]; ?>">
<meta property="og:url" content="<? echo base_url().session('Langlink').'note/'.$list->note['url']; ?>">
<meta property="og:image" content="<? echo base_url().$list->confSet['bglogo']; ?>">
<meta property="og:description" content="<? echo $list->note['description'.session('Langtext')]; ?>">
<? if ($list->note['theme']!='') { $theme='themes/'.strtolower($list->note['theme']).'.css'; } ?>
<? } ?>
<? if ($list->metaPage=='page404') { ?>
<title><? echo $list->confSet['metaTitlePage404'.session('Langtext')]; ?></title>
<meta name="description" content="<? echo $list->confSet['metaDescriptionPage404'.session('Langtext')]; ?>">
<meta property="og:title" content="<? echo $list->confSet['metaTitlePage404'.session('Langtext')]; ?>">
<meta property="og:image" content="<? echo base_url().$list->confSet['bglogo']; ?>">
<meta property="og:description" content="<? echo $list->confSet['metaDescriptionPage404'.session('Langtext')]; ?>">
<? } ?>
<? if ($list->metaPage=='search') { ?>
<title><? echo $list->confSet['metaTitleSearch'.session('Langtext')]; ?></title>
<meta name="description" content="<? echo $list->confSet['metaDescriptionSearch'.session('Langtext')]; ?>">
<meta property="og:title" content="<? echo $list->confSet['metaTitleSearch'.session('Langtext')]; ?>">
<meta property="og:url" content="<? echo base_url().session('Langlink').'search'; ?>">
<meta property="og:image" content="<? echo base_url().$list->confSet['bglogo']; ?>">
<meta property="og:description" content="<? echo $list->confSet['metaDescriptionSearch'.session('Langtext')]; ?>">
<? } ?>
<? if ($list->metaPage=='registration') { ?>
<title><? echo $list->confSet['metaTitleRegistration'.session('Langtext')]; ?></title>
<meta name="description" content="<? echo $list->confSet['metaDescriptionRegistration'.session('Langtext')]; ?>">
<meta property="og:title" content="<? echo $list->confSet['metaTitleRegistration'.session('Langtext')]; ?>">
<meta property="og:url" content="<? echo base_url().session('Langlink').'registration'; ?>">
<meta property="og:image" content="<? echo base_url().$list->confSet['bglogo']; ?>">
<meta property="og:description" content="<? echo $list->confSet['metaDescriptionRegistration'.session('Langtext')]; ?>">
<? } ?>
<? if ($list->metaPage=='account') { ?>
<title><? echo $list->confSet['metaTitleAccount'.session('Langtext')]; ?></title>
<meta name="description" content="<? echo $list->confSet['metaDescriptionAccount'.session('Langtext')]; ?>">
<meta property="og:title" content="<? echo $list->confSet['metaTitleAccount'.session('Langtext')]; ?>">
<meta property="og:url" content="<? echo base_url().session('Langlink').'account'; ?>">
<meta property="og:image" content="<? echo base_url().$list->confSet['bglogo']; ?>">
<meta property="og:description" content="<? echo $list->confSet['metaDescriptionAccount'.session('Langtext')]; ?>">
<? } ?>
<link rel="shortcut icon" href="/favicon.ico"/>
<link rel="stylesheet" type="text/css" href="/<? echo $theme; ?>" >
<link rel="stylesheet" type="text/css" href="/css/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="/css/fancybox.css">
<script src="/js/jquery.js"></script>
<script src="/js/jquery-ui.js"></script>
<script src="/js/jquery.inputmask.bundle.js"></script>
<script src="/js/phone.js"></script>
<script id="defaultLocale" data-text="<?= session('Langtext'); ?>" data-link="<?= session('Langlink'); ?>" src="/js/nespicms.js"></script>
<script src="/js/fancybox.js"></script>
<script src="/js/slider.js"></script>
<script src="/js/images.js"></script>
<script src="/js/jquery.form.js"></script>
<? if (($list->metaPage=='chapter')OR($list->metaPage=='article')) { echo $list->chapter['head']; } ?>
<? if ($list->metaPage=='note') { echo $list->note['head']; } ?>
<? echo $list->confSet['head']; ?>
</head>
<body>
<? echo $list->confSet['body'.session('Langtext')]; ?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "<? echo $list->confSet['from'.session('Langtext')]; ?>",
    "url": "<? echo base_url(); ?>"
}
</script>
<? if ((isset($list->chapter['chapterId']))AND($list->metaPage=='chapter')) { ?>
<script type="application/ld+json">
    {
      "@context": "http://schema.org/",
      "name": "<? echo $list->chapter['name'.session('Langtext')]; ?>",
      "@type": "WebPage",
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "<? echo $list->chapter['rating']; ?>",
        "bestRating": "5.00",
        "ratingCount": "<? echo $list->chapter['rating_votes']; ?>"
      }
    }
</script>
<? } ?>