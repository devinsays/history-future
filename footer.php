<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage History of the Future
 * @since Version 0.1
 */
?>

	</div><!-- #main -->

	<footer id="colophon" role="contentinfo">
		<div class="copyright">
	 		<p>&#169; Byron Reese <?php echo date('Y'); ?></p>
	 		<p id="about-site"><a href="<?php bloginfo( 'url' ); ?>/site">About the Site</a> | <a href="http://github.com/devinsays/history-future">Get the Source Code</a></p>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>