<?php
/**
 * replaceMe
 *
 * Footer
 */
?>

<footer id="footer" itemscope itemtype="http://schema.org/WPFooter">
</footer>

</div> <!-- END #container -->

<?=BackEnd::getOption('extra-scripts')?>
<?php wp_footer() ?>

<script data-main="<?=assetDir?>/js/core" src="//cdnjs.cloudflare.com/ajax/libs/require.js/2.1.9/require.min.js"></script>
<script src="<?=assetDir?>/js/library/modernizr.js"></script>
<script src="//cdn.jsdelivr.net/rem/0.1/rem.min.js"></script>
</body>
</html>