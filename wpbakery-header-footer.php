<?php
/**
 * Plugin Name: WPBakery Header Footer Builder
 * Description: Build custom header and footer using WPBakery Page Builder.
 * Version: 1.0
 * Text Domain: wpbk-header-footer
 * Author: Vietito
 * Author URI: https://vietito.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define('WPBK_HEADER_FOOTER_URL', plugin_dir_url(__FILE__));
define('WPBK_HEADER_FOOTER_DIR', plugin_dir_path(__FILE__));

// Hook to initialize the plugin.
add_action( 'init', 'wpbakery_header_footer_init' );

function wpbakery_header_footer_init() {
    // Register custom post type for Header/Footer templates.
    register_post_type( 'wpb_header_footer', array(
        'labels' => array(
            'name'          => __( 'Header & Footer', 'wpbk-header-footer' ),
            'singular_name' => __( 'Header & Footer', 'wpbk-header-footer' ),
        ),
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'supports'     => array( 'title', 'editor' ), // Enable WPBakery support in the editor.
    ) );
}

/*
    You can set the post type for which the editor should be
    available by adding the following code to functions.php:
*/
add_action( 'vc_before_init', 'Use_wpBakery' );
function Use_wpBakery() {
  $vc_list = array('page','capabilities','wpb_header_footer');
  vc_set_default_editor_post_types($vc_list);
  vc_editor_set_post_types($vc_list);
}

// Enqueue styles and scripts.
add_action( 'wp_enqueue_scripts', 'wpbakery_header_footer_enqueue' );
function wpbakery_header_footer_enqueue() {
    if ( ! is_admin() ) {
        wp_enqueue_style( 'wpbakery-header-footer-style', plugin_dir_url( __FILE__ ) . 'assets/style.css', [], filemtime(WPBK_HEADER_FOOTER_DIR.'/assets/style.css') );
    }
}

//Add Header/Footer display functionality.

add_action('get_header', 'wpbet_replace_theme_header');

function wpbet_replace_theme_header(){

    require plugin_dir_path( __FILE__ ) . 'templates/header.php';

    $templates   = [];
    $templates[] = 'header.php';
    remove_all_actions( 'wp_head' );
    ob_start();
    locate_template( $templates, true );
    ob_get_clean();

}

add_action('get_footer', 'wpbet_replace_theme_footer');

function wpbet_replace_theme_footer(){

    require plugin_dir_path( __FILE__ ) . 'templates/footer.php';

    $templates   = [];
    $templates[] = 'footer.php';
    remove_all_actions( 'wp_footer' );
    ob_start();
    locate_template( $templates, true );
    ob_get_clean();

}

// Add content to header.
add_action( 'wpbk_header_section', 'wpbakery_replace_header', 0 );
function wpbakery_replace_header() {
    $header_id = get_option( 'wpb_header_id' );
    // $args  = [
    //     'post_type' => 'wpb_header_footer',
    //     'posts_per_page' => 1,
    //     'post__in' => [$header_id],
    // ];
    // $the_query = new WP_Query($args);
    // if($the_query->have_posts()):
    //     while($the_query->have_posts()):
    //         $the_query->the_post();
    //         the_content();
    //     endwhile;
    // endif;wp_reset_postdata();
    if ( $header_id ) {

        //Render style inline
        $_wpb_shortcodes_custom_css = get_post_meta( $header_id, '_wpb_shortcodes_custom_css', true );
        $_wpb_post_custom_css = get_post_meta( $header_id, '_wpb_post_custom_css', true );
        $full_custom_css = $_wpb_post_custom_css.$_wpb_shortcodes_custom_css;
        if(!empty($full_custom_css))
            echo '<style type="text/css" data-type="wpbk-header-footer-header-css">'.$full_custom_css.'</style>';
        // Show header from WPBakery.
        echo '<div class="nt_wp_custom_header">';
            //echo get_post_field( 'post_content', $header_id );
            echo apply_filters( 'the_content', get_post_field( 'post_content', $header_id ) );
        echo '</div>';
    }
}

// Add content to fooer.
add_action( 'wpbk_footer_section', 'wpbakery_replace_footer', 0 );
function wpbakery_replace_footer() {
    $footer_id = get_option( 'wpb_footer_id' );
    if ( $footer_id ) {
        //Render style inline
        $_wpb_shortcodes_custom_css = get_post_meta( $footer_id, '_wpb_shortcodes_custom_css', true );
        $_wpb_post_custom_css = get_post_meta( $footer_id, '_wpb_post_custom_css', true );
        $full_custom_css = $_wpb_post_custom_css.$_wpb_shortcodes_custom_css;
        if(!empty($full_custom_css))
            echo '<style type="text/css" data-type="wpbk-header-footer-footer-css">'.$full_custom_css.'</style>';
        echo '<div class="nt_wp_custom_footer">';
            // Show footer from WPBakery.
            echo apply_filters( 'the_content', get_post_field( 'post_content', $footer_id ) );
        echo '</div>';
    }
}



//Add settings page to select Header/Footer.
add_action( 'admin_menu', 'wpbakery_header_footer_menu' );
function wpbakery_header_footer_menu() {
    add_submenu_page(
        'edit.php?post_type=wpb_header_footer',
        __( 'Header & Footer Settings', 'wpbk-header-footer' ),
        __( 'Settings', 'wpbk-header-footer' ),
        'manage_options',
        'wpbakery-header-footer-settings',
        'wpbakery_header_footer_settings_page'
    );
}

function wpbakery_header_footer_settings_page() {
    if ( isset( $_POST['wpb_header_footer_save'] ) ) {
        update_option( 'wpb_header_id', intval( $_POST['wpb_header_id'] ) );
        update_option( 'wpb_footer_id', intval( $_POST['wpb_footer_id'] ) );
        update_option( 'wpb_header_footer_width', intval( $_POST['wpb_header_footer_width'] ) );
        echo '<div class="updated"><p>Settings saved.</p></div>';
    }

    $header_id = get_option( 'wpb_header_id' );
    $footer_id = get_option( 'wpb_footer_id' );
    $wpb_header_footer_width = get_option( 'wpb_header_footer_width' );
    ?>
    <div class="wrap">
        <h1><?php _e( 'Header & Footer Settings', 'wpbakery-header-footer' ); ?></h1>
        <form method="post">
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="wpb_header_id"><?php _e( 'Select Header', 'wpbk-header-footer' ); ?></label></th>
                    <td>
                        <select name="wpb_header_id" id="wpb_header_id">
                            <option value=""><?php _e( 'None', 'wpbk-header-footer' ); ?></option>
                            <?php
                            $headers = get_posts( array( 'post_type' => 'wpb_header_footer', 'posts_per_page' => -1 ) );
                            foreach ( $headers as $header ) {
                                echo '<option value="' . esc_attr( $header->ID ) . '" ' . selected( $header->ID, $header_id, false ) . '>' . esc_html( $header->post_title ) . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="wpb_footer_id"><?php _e( 'Select Footer', 'wpbk-header-footer' ); ?></label></th>
                    <td>
                        <select name="wpb_footer_id" id="wpb_footer_id">
                            <option value=""><?php _e( 'None', 'wpbk-header-footer' ); ?></option>
                            <?php
                            $footers = get_posts( array( 'post_type' => 'wpb_header_footer', 'posts_per_page' => -1 ) );
                            foreach ( $footers as $footer ) {
                                echo '<option value="' . esc_attr( $footer->ID ) . '" ' . selected( $footer->ID, $footer_id, false ) . '>' . esc_html( $footer->post_title ) . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="wpb_header_footer_width"><?php _e( 'Header/Footer Container Width', 'wpbk-header-footer' ); ?></label></th>
                    <td>
                        <input type="number" name="wpb_header_footer_width" id="wpb_header_footer_width" value="<?php echo $wpb_header_footer_width ?>">
                    </td>
                </tr>
            </table>
            <p class="submit"><button type="submit" name="wpb_header_footer_save" class="button button-primary"><?php _e( 'Save Settings', 'wpbakery-header-footer' ); ?></button></p>
        </form>
        <p><i>*You can edit header.php, footer.php in tempates/ directory of this plugin.</i></p>
        <hr>
        <p><i>*If builder don't enable. Please enable wpbakery builder for header & footer posttype by yourself here.</i></p>
        <img style="max-width: 100%;height: auto;" src="<?php echo WPBK_HEADER_FOOTER_URL ?>/assets/note.png" />
    </div>
    <?php
}
