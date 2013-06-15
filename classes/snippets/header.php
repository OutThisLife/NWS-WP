<header id="header">
	<!-- Logo -->
	<a href="<?=home_url()?>" id="logo">
		<img src="<?=assetDir?>/images/logo.png" alt="<?php bloginfo('name') ?>" />
	</a>

	<!-- Nav -->
	<nav id="nav">
		<?=Template::get('list')?>
	</nav>
</header>