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
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="copyright" content="Copyright <?php echo date('Y'); bloginfo('name') ?>. All Rights Reserved.">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0" /> -->

	<?php FrontEnd::getTitle() ?>

	<link rel="profile" href="//gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
	<link rel="image_src" href="<?=assetDir?>/images/logo.png" />
	<link rel="shortcut icon" href="<?=assetDir?>/images/favicon.jpg" />

	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js"></script>

	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<?php wp_head() ?>
</head>
<body <?php body_class() ?>>

<!-- HEADER -->
<?=Template::get('header')?>