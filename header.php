<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage History of the Future
 * @since Version 0.1
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title(''); ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<script type="text/javascript" src="http://use.typekit.com/lpm2ecz.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<script src="//platform.twitter.com/widgets.js" type="text/javascript"></script>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>

<!-- open graph tags -->

<meta property="og:image" content="<?php bloginfo('stylesheet_directory'); ?>/images/BR.jpg"/>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>



<div id="page" class="hfeed">
	<header id="branding" role="banner">
		<hgroup>
			<h1 id="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="ir"><?php bloginfo( 'name' ); ?><span></span></a></h1>
		</hgroup>

		<nav id="access" role="navigation">
			<h1 class="assistive-text section-heading"><?php _e( 'Main menu', 'historyfuture' ); ?></h1>
			<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'historyfuture' ); ?>"><?php _e( 'Skip to content', 'historyfuture' ); ?></a></div>

			<ul class="clearfix">
				<li><a class="about" href="<?php bloginfo( 'url' ); ?>/about">About</a></li>
				<li><a class="contact" href="<?php bloginfo( 'url' ); ?>/contact">Contact</a></li>
				<li><a class="twitter" href="http://twitter.com/byronreese" target="_blank">Twitter</a></li>
				<li><a class="facebook" href="http://www.facebook.com/byronreese" target="_blank">Facebook</a></li>
				<li><a class="rss" href="http://feeds.feedburner.com/byronreese" target="_blank">RSS</a></li>
			</ul>
		</nav><!-- #access -->
	</header><!-- #branding -->
	
	<?php if ( !is_page() && !is_search() && !is_attachment() )
		get_template_part('timeline','index');
	?>

	<div id="main">