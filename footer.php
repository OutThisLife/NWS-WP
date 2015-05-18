<?php
/**
 * replaceMe
 *
 * Footer
 */
?>

<footer id="footer" itemscope itemtype="http://schema.org/WPFooter">
</footer>

<?=BackEnd::getOption('extra-scripts')?>
<?php wp_footer() ?>

<script src="<?=assetDir?>/js/library/modernizr.min.js"></script>
<script src="<?=bowerDir?>/jquery/dist/jquery.min.js"></script>
<script src="<?=bowerDir?>/materialize/dist/js/materialize.min.js"></script>
<script src="<?=bowerDir?>/lodash/lodash.min.js"></script>

<!-- Angularjs framework -->
<script data-main="<?=assetDir?>/js/core" src="<?=bowerDir?>/requirejs/require.js"></script>

</body>
</html>