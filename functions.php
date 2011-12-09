<?php
/**
 * "History of the Future" functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage History of the Future
 * @since Version 0.1
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'historyfuture_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override historyfuture_setup() in a child theme, add your own historyfuture_setup to your child theme's
 * functions.php file.
 */
function historyfuture_setup() {
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 */
	load_theme_textdomain( 'historyfuture', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );
	
	/**
	 * Include support for the timeline meta fields
	 */	
	require_once( dirname( __FILE__ ) . '/inc/timeline-meta.php' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Add support for the Aside and Gallery Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'gallery' ) );
	
	/**
	 * Add support for post thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'timeline-thumb', 308, 258, false ); // Used for timeline posts
	
}
endif; // historyfuture_setup

/**
 * Tell WordPress to run historyfuture_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'historyfuture_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function toolbox_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar 1', 'historyfuture' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'init', 'toolbox_widgets_init' );

if ( ! function_exists( 'historyfuture_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since Version 1.0
 */
function historyfuture_content_nav( $nav_id ) {
	global $wp_query;

	?>
	<nav id="<?php echo $nav_id; ?>">
		<h1 class="assistive-text section-heading"><?php _e( 'Post navigation', 'historyfuture' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'historyfuture' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'historyfuture' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'historyfuture' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'historyfuture' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // historyfuture_content_nav

if ( ! function_exists( 'historyfuture_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own historyfuture_posted_on to override in a child theme
 *
 * @since Version 1.0
 */
function historyfuture_posted_on() {
	if ( in_category( 'Timeline' ) ) {
		global $post;
		$year = get_post_meta($post->ID, '_year', true);
		if ( $year < 0 ) {
			$year = str_replace('-','',$year);
			$suffix = 'BC';
			$prepend = '';
		}
		else {
			$prepend = 'AD';
			$suffix = '';
		}
		?>
		<div class="year-meta">
			<span class="prepend"><?php echo  $prepend; ?></span>
			<span class="year"><?php echo  $year; ?></span>
			<span class="suffix"><?php echo $suffix; ?></span>
		</div>
	<?php }
	printf( __( '', 'historyfuture' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'historyfuture' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
}
endif;

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Version 1.0
 */
function historyfuture_body_classes( $classes ) {
	// Adds a class of single-author to blogs with only 1 published author
	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	return $classes;
}
add_filter( 'body_class', 'historyfuture_body_classes' );

/**
 * Enqueue the timeline script
 *
 * @since Version 1.0
 */
 
 function historyfuture_enqueue_scripts() {
 	wp_register_script( 'timelinr',  get_template_directory_uri() . '/js/jquery.timelinr.js', array('jquery'),null,true );
 	wp_register_script( 'byron_custom',  get_template_directory_uri() . '/js/historyfuture_custom.js', array('jquery','timelinr'),null,true );
    wp_register_script( 'historyjs',  get_template_directory_uri() . '/js/jquery.history.js', array('jquery'),null,true );
    wp_register_script( 'clock',  get_template_directory_uri() . '/js/clock.js', array('jquery'),null,true );
	wp_register_script( 'scrollto',  get_template_directory_uri() . '/js/jquery.scrollTo-min.js', array('jquery'),null,true );
 	if ( !is_page() && !is_search() && !is_attachment() ) {
	    wp_enqueue_script('jquery-ui-core');
	    wp_enqueue_script('jquery-ui-slider');  
		wp_enqueue_script( 'timelinr' );
	    wp_enqueue_script( 'historyjs' );
	    wp_enqueue_script( 'clock' );
	    wp_enqueue_script( 'byron_custom' );
	    wp_enqueue_script( 'scrollto' );  
		
    }
}    
 
add_action('wp_enqueue_scripts', 'historyfuture_enqueue_scripts');