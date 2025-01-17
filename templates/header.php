<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wpbakery
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
	<?php 
		$wpb_header_footer_width = get_option( 'wpb_header_footer_width' );
		if($wpb_header_footer_width > 0): 
	?>
		<style type="text/css">
			:root{
				--wpb_header_footer_width: <?php echo $wpb_header_footer_width ?>px;
			}
		</style>
	<?php endif; ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">

	<header id="masthead" class="site-header">
		<?php do_action('wpbk_header_section') ?>
	</header><!-- #masthead -->
