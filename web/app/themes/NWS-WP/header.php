<?php
/**
 * matties
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
	<link rel="image_src" href="<?=assetDir?>/img/logo.png" />
	<link rel="shortcut icon" href="<?=home_url()?>/favicon.ico" />

	<link rel="stylesheet" href="<?=bowerDir?>/materialize/dist/css/materialize.min.css" />
	<link rel="stylesheet" href="<?=assetDir?>/css/dist/main.css?v=<?=ASSET_VERSION?>" />

	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
	<script src="//s3.amazonaws.com/nwapi/nwmatcher/nwmatcher-1.2.5-min.js"></script>
	<script src="//html5base.googlecode.com/svn-history/r38/trunk/js/selectivizr-1.0.3b.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
	<![endif]-->

	<script src="//<?=$_SERVER['SERVER_NAME']?>:9091/livereload.js"></script>
	<?php wp_head() ?>
</head>
<body <?php body_class() ?>>

<!-- HEADER -->
<header id="header" class="clearfix" role="banner" itemscope itemtype="http://schema.org/WPHeader">
<div class="row wrapper">
	<a href="<?=home_url()?>" class="logo">
		<img src="<?=assetDir?>/img/logo.png" alt="<?php bloginfo('name') ?>" />
	</a>

	<div class="main-nav hide-for-small">
		<ul>
			<li><a href="#">Item 1</a></li>
			<li><a href="#">Item 2</a></li>
			<li><a href="#">Item 3</a></li>
			<li><a href="#">Item 4</a></li>
			<li><a href="#">Item 5</a></li>
		</ul>
	</div>

	<!-- Mobile nav -->
	<div class="hide-on-med-and-up mobile-link">
		<a href="javascript:;"><span></span></a>

		<div id="mobile-menu">
		<ul class="main-mobile-nav">
			<?=BackEnd::getMenu('header1')?>
		</ul>
		</div>
	</div>
</div>
</header>
