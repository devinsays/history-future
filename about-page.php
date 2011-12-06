<?php
/*
Template Name: About Page
*/


get_header(); ?>

		<div id="primary" class="clearfix">
			<div id="content" role="main">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

				<?php endwhile; // end of the loop. ?>
				
				<?php get_sidebar(); ?>

			</div><!-- #content -->
		</div><!-- #primary -->
<?php get_footer(); ?>