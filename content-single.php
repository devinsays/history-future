<?php
/**
 * @package WordPress
 * @subpackage History of the Future
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="social-links">
				<div id="tweet"><a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="byronreese" data-url="http://byronreece.com">Tweet</a></div>
				<div id="like" class="fb-like" data-href="<?php the_permalink() ?>" data-send="true" data-layout="button_count" data-width="240" data-show-faces="true"></div>
				<div id="plusone"><g:plusone class="g-plus" href="<?php the_permalink() ?>" size="medium"></g:plusone></div>
		</div> <!-- .social-links -->
		<div class="meta-banner"><?php historyfuture_posted_on(); ?> </div>
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'historyfuture' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<div class="entry-meta">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', ', ' );

			if ( '' != $tag_list ) {
				$meta_text = __( 'This entry was tagged in %1$.  Bookmark the <a href="%2$s" title="Permalink to %3$s" rel="bookmark">permalink</a>.', 'historyfuture' );
			} else {
				$meta_text = __( 'Posted on %4$s | Bookmark the <a href="%2$s" title="Permalink to %3$s" rel="bookmark">Permalink</a> |', 'historyfuture' );
			}

			printf(
				$meta_text,
				$tag_list,
				get_permalink(),
				the_title_attribute( 'echo=0' ),
				get_the_date()
			);
		?>

		<?php edit_post_link( __( 'Edit', 'historyfuture' ), '<span class="edit-link">', '</span>' ); ?>
	</div><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
