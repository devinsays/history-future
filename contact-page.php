<?php
/*
Template Name: Contact Page
*/


get_header(); ?>

		<div id="primary">
			<div id="content" role="main">
				<div id="contact-wrap" class="clearfix">
					<div id="envelope" class="ir">Envelope</div>
				</div>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>