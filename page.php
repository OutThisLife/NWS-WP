<?php
/**
 * replaceMe
 *
 * Single page
 */

get_header();
the_post();
?>

<!-- MASTHEAD -->
<?php get_template_part('masthead') ?>

<!-- CONTENT -->
<section id="content">
	<div class="wrapper">
		<!-- Page -->
		<div id="page">
		</div>

		<!-- Sidebar -->
		<?php get_sidebar() ?>
	</div>
</section>

<?php get_footer() ?>