<?php

/*plugin name: Shortcode Elementor
 * Plugin URI:  https://wordpress.org/plugins/shortcode-elementor/
 * Description: Insert your elementor pages and sections templates anywhere using shortcode
 * Version:     1.0.4
 * Author:      RSTheme
 * Author URI:  https://rstheme.com/
 * Text Domain: rs-shortcode
 * Author URI: 	http://rstheme.com
 * Plugin URI: 	https://wordpress.org/plugins/shortcode-elementor/
 * License: 	GPL v2 or later
 * License URI:	http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 * Requires PHP: 7.0.0
 * Requires at least: 5.5
 */

define( 'RS_Elements__FILE__', __FILE__ );
define( 'RS_Elements_PLUGIN_BASE', plugin_basename( RS_Elements__FILE__ ) );
define( 'RS_Elements_URL', plugins_url( '/', RS_Elements__FILE__ ) );
define( 'RS_Elements_PATH', plugin_dir_path( RS_Elements__FILE__ ) );

require_once( RS_Elements_PATH . 'includes/post-type.php' );
require_once( RS_Elements_PATH . 'includes/settings.php' );
require_once( RS_Elements_PATH . 'includes/plugin-settings.php' );

// Get Ready Plugin Translation
function rselements_load_textdomain_lite() {
    load_plugin_textdomain('rs-shortcode', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'rselements_load_textdomain_lite');

// Admin Notice for Black Friday Deal
function rselements_admin_notice_lite() {
    if ( !current_user_can( 'manage_options' ) ) {
        return;
    }

    $screen = get_current_screen();
    if ( $screen->base !== 'dashboard' ) {
        return;
    }

    ?>
    <div class="notice notice-success is-dismissible" style="background: url('<?php echo esc_url(RS_Elements_URL . 'includes/img/admin-notice.png'); ?>') no-repeat center center / cover; color: #fff; padding: 20px; display: flex; align-items: center; justify-content: space-between;">
        <p style="margin: 0; font-size: 26px; line-height: 1.4; letter-spacing: 1px; font-weight: 700;">
            <?php esc_html_e( 'Get Up To', 'ultimate-team-showcase' ); ?>
            <span style="color: #FF0000; font-weight: bold; padding-left: 5px; padding-right: 5px;"><?php esc_html_e( '50% OFF', 'ultimate-team-showcase' ); ?></span>
            <?php esc_html_e( 'on The Premium WordPress Themes Collection on', 'ultimate-team-showcase' ); ?>
            <span style="color: #FF0000; font-weight: bold; padding-left: 5px;"><?php esc_html_e( 'Black Friday & Cyber Monday Deal!', 'ultimate-team-showcase' ); ?></span>
        </p>

        <a href="https://rstheme.com/offers/" class="button rselements-button" style="text-decoration: none; margin-right: 50px; background-color: #fff; color: #000; border-radius: 15px; font-weight: 600; font-size: 20px;">
            <?php esc_html_e( 'Snag The Deals!', 'ultimate-team-showcase' ); ?>
        </a>

        <style>
            .rselements-button:hover {
                background-color: #ffffff !important;
                color: #ff0000 !important;
            }
        </style>
    </div>
    <?php
}
add_action( 'admin_notices', 'rselements_admin_notice_lite' );

class RSElements_Elementor_Shortcode{

	function __construct(){
		add_action( 'manage_rs_elements_posts_custom_column' , array( $this, 'rselements_rs_global_templates_columns' ), 10, 2);
		add_filter( 'manage_rs_elements_posts_columns', array($this,'rselements_custom_edit_global_templates_posts_columns' ));
	}

	function rselements_custom_edit_global_templates_posts_columns($columns) {
		
		$columns['rs_shortcode_column'] = __( 'Shortcode', 'rs_elements_lite' );
		return $columns;
	}


	function rselements_rs_global_templates_columns( $column, $post_id ) {

		switch ( $column ) {

			case 'rs_shortcode_column' :
				echo '<input type=\'text\' class=\'widefat\' value=\'[SHORTCODE_ELEMENTOR id="'.$post_id.'"]\' readonly="">';
				break;
		}
	}	
}
new RSElements_Elementor_Shortcode();

