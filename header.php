<?php
/**
 * replaceMe
 *
 * Header
 */
?>
<!DOCTYPE html>
<head>
	<meta charset="<?php bloginfo('charset') ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="copyright" content="Copyright <?=date('Y'), ' ', bloginfo('name')?>. All Rights Reserved." />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimal-ui" />

	<?php FrontEnd::getTitle() ?>

	<link rel="profile" href="//gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
	<link rel="image_src" href="<?=assetDir?>/images/logo.png" />
	<link rel="shortcut icon" href="<?=home_url()?>/favicon.ico" />

	<link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons" />
	<link rel="stylesheet" href="<?=bowerDir?>/materialize/dist/css/materialize.min.css" />
	<link rel="stylesheet" href="<?=assetDir?>/css/core.css" />

	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
	<script src="//s3.amazonaws.com/nwapi/nwmatcher/nwmatcher-1.2.5-min.js"></script>
	<script src="//html5base.googlecode.com/svn-history/r38/trunk/js/selectivizr-1.0.3b.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
	<![endif]-->

	<?php wp_head() ?>
</head>
<body <?php body_class() ?> itemscope itemtype="http://schema.org/WebPage">

<!-- HEADER -->
<header id="header" class="clearfix" role="banner" itemscope itemtype="http://schema.org/WPHeader">
	<!-- Logo -->
	<a href="<?=home_url()?>" class="left logo">
		<img src="<?=assetDir?>/images/logo.png" alt="<?php bloginfo('name') ?>" />
	</a>

	<!-- Nav -->
	<nav class="right">
		<div class="hide-for-small">
			<ul>
				<li><a href="#">Item 1</a></li>
				<li><a href="#">Item 2</a></li>
				<li><a href="#">Item 3</a></li>
				<li><a href="#">Item 4</a></li>
				<li><a href="#">Item 5</a></li>
			</ul>
		</div>

		<div class="show-for-small">
			<a href="javascript:;" class="open-mobile-menu">
				<i class="material-icons">reorder</i>
			</a>
		</div>
	</nav>
</header>