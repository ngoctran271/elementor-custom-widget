<?php
/**
 * Plugin Name: Elementor Custom Widget
 * Description: Auto embed any embbedable content from external URLs into Elementor.
 * Plugin URI:  https://www.vietito.com/
 * Version:     1.0.0
 * Author:      Vietito
 * Author URI:  https://www.vietito.com/
 * Text Domain: ecw
 * Elementor tested up to: 3.7.0
 * Elementor Pro tested up to: 3.7.0
 */
if (!defined('ABSPATH')) {
    exit;
}
define('CUSTOM_WIDGET_URL', plugin_dir_url(__FILE__));
define('CUSTOM_WIDGET_DIR', plugin_dir_path(__FILE__));
function register_custom_widget($widgets_manager)
{
    //Add custom CSS
    // require_once(__DIR__ . '/widgets/custom-css.php');

    require_once(__DIR__ . '/widgets/sm_custom_gallery.php');
    $widgets_manager->register(new \Elementor_SM_Custom_Gallery_Box_Widget());
}
add_action('elementor/widgets/register', 'register_custom_widget');
//add category widgets
function add_elementor_widget_categories($elements_manager)
{
    $elements_manager->add_category(
        'custom',
        [
            'title' => esc_html__('Elementor Custom', 'ecw'),
            'icon' => 'fa fa-plug',
        ]
    );
}
add_action('elementor/elements/categories_registered', 'add_elementor_widget_categories');

add_action( 'wp_enqueue_scripts', 'custom_widget_enqueue_scripts', 10000 );
function custom_widget_enqueue_scripts(){
	wp_enqueue_style( 'custom_widget_main', CUSTOM_WIDGET_URL . 'css/main.css', array(),  filemtime(CUSTOM_WIDGET_DIR.'/css/main.css'));
// 	wp_enqueue_script( 'custom_mega_menu_main', CUSTOM_MEGA_URL . 'js/custom_mega_menu.js', array(), filemtime(CUSTOM_MEGA_DIR.'/js/custom_mega_menu.js'), true );
// 	wp_localize_script( 'custom_mega_menu_main', 'load_ajax', array(
// 	    'ajaxurl' => admin_url( 'admin-ajax.php' ),
// 	));
}