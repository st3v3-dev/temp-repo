<?php
/**
 * Plugin Name:     Ad Manager WD
 * Plugin URI:		https://web-dorado.com/products/wordpress-ad-manager-wd.html
 * Description:      Ad Manager WD plugin is the easiest way to place banner ads on your WordPress website.
 * Version:         1.0.11
 * Author:          WebDorado
 * Author URI:      https://web-dorado.com/wordpress-plugins-bundle.html
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

require_once( 'wd_ads_class.php' );

if ( ! defined( 'WD_ADS_MAIN_FILE' ) ) {
	define( 'WD_ADS_MAIN_FILE', plugin_basename( __FILE__ ) );

}
if ( ! defined( 'WD_ADS_DIR' ) ) {
	define( 'WD_ADS_DIR', dirname( __FILE__ ) );

}
if ( ! defined( 'WD_ADS_URL' ) ) {
	define( 'WD_ADS_URL', plugins_url( plugin_basename( dirname( __FILE__ ) ) ) );
}


add_action( 'plugins_loaded', array( 'WD_ADS', 'get_instance' ) );

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
	require_once( 'wd_ads_admin_class.php' );
	add_action( 'plugins_loaded', array( 'wd_ads_admin', 'get_instance' ) );

	add_action( 'admin_menu', array( 'wd_ads_admin', 'wd_advertisement_sub' ) );

	register_activation_hook( __FILE__, array( 'wd_ads_admin', 'wd_ads_activate' ) );

}


if(!isset($_REQUEST['ajax'])) {
	if ( ! class_exists( "DoradoWeb" ) ) {
		require_once( WD_ADS_DIR . '/wd/start.php' );

	}

	dorado_web_init( array(
		                 "prefix"                   => "wd_ads",
		                 "wd_plugin_id"             => 167,
		                 "plugin_wd_zip_name"       => "ad-manager-wd.zip",
		                 // to do
		                 "plugin_title"             => "Ad Manager Wd",
		                 "plugin_wordpress_slug"    => "ad-manager-wd",
		                 "plugin_dir"               => WD_ADS_DIR,
		                 "plugin_url"               => WD_ADS_URL,
		                 "plugin_main_file"         => __FILE__,
		                 "wd_plugin_name_personal"  => "Ad Manager WD Personal (WordPress)",
		                 "wd_plugin_name_business"  => "Ad Manager WD Business (WordPress)",
		                 "wd_plugin_name_developer" => "Ad Manager WD Developer (WordPress)",
		                 "description"              => __( 'Thinking of ways to monetize your WordPress website with ads? Now you can do it without any difficulty. Ad Manager WD plugin is the easiest way to place banner ads on your WordPress website.', 'wd_ads' ),
		                 "addons"                   => '',
		                 "plugin_features"          => array(
			                 0 => array(
				                 "title" => __( "Simple Set-up & Management", "wd_ads" ),
				                 "description" => __( "Ad Manager WD is easy to install and manage. Create ads by simply adding advertisement codes in HTML, CSS, Javascript or advertisement code, such as Google AdSense. Display ads on your website sidebar with the help of the widget.", "wd_ads" ),
			                 ),

			                 1 => array(
				                 "title" => __( "Ad Groups", "wd_ads" ),
				                 "description" => __( "Easily manage all your ads by creating ad groups. Set margins, alignment and placement for each ad group. Choose to display ads in groups in Dynamic or Block modes.", "wd_ads" ),
			                 ),

			                 2 => array(
				                 "title" => __( "Geo Targeting", "wd_ads" ),
				                 "description" => __( "Control what ads site visitors from different locations see. The wordpress ad manager allows to selecting a city, state or country to display ads based on geo location.", "wd_ads" ),
			                 ),

			                 3 => array(
				                 "title" => __( "Placement Device Targeting", "wd_ads" ),
				                 "description" => __( "Choose what device types you want each ad to be displayed on. You can choose to show ads on just desktops, smartphones or tablets and all devices. Enable responsive support for ads shown on mobile devices.", "wd_ads" ),
			                 ),

			                 4 => array(
				                 "title" => __( "Ad Scheduling", "wd_ads" ),
				                 "description" => __( "The plugin comes with Ad Scheduling options that allow you to set-up ad rotation and display ads in specific time frames. Set start and end dates, show ads on certain days of week and at certain times, define maximum click and impression number per ad.", "wd_ads" ),
			                 ),

			                 5 => array(
				                 "title" => __( "Statistics Tracking", "wd_ads" ),
				                 "description" => __( "Track ad performance and measure ad effectiveness with Internal Tracker or integrate tracking with Piwik Analytics or Google Analytics. Keep track of clicks, impressions and more.", "wd_ads" ),
			                 ),

			                 6 => array(
				                 "title" => __( "User Role Management", "wd_ads" ),
				                 "description" => __( "Ad Manager WD WordPress plugin allows to set-up publish, edit, delete, schedule and other permissions based on user roles.", "wd_ads" ),
			                 ),

			                 7 => array(
				                 "title" => __( "User Role Management", "wd_ads" ),
				                 "description" => __( "Ad Manager WD plugin allows you to export ads from one website and easily import them to another one. Export and import all your ads with a few clicks and avoid the hassle of setting up the same ads for several websites.", "wd_ads" ),
			                 ),

		                 ),
		                 "user_guide"               => array(
			                 0 => array(
				                 "main_title" => __( "Installation", "wd_ads" ),
				                 "url"        => "https://web-dorado.com/ad-manager-wd/installation.html",
				                 "titles"     => array()
			                 ),
			                 1 => array(
				                 "main_title" => __( "Introduction", "wd_ads" ),
				                 "url"        => "https://web-dorado.com/ad-manager-wd/introduction.html",
				                 "titles"     => array()
			                 ),
			                 2 => array(
				                 "main_title" => __( "Creating an advertisement", "wd_ads" ),
				                 "url"        => "https://web-dorado.com/ad-manager-wd/creating-advertisement.html",
				                 "titles"     => array(
					                 array(
						                 "title" => __( "New Advert", "wd_ads" ),
						                 "url"   => "https://web-dorado.com/ad-manager-wd/creating-advertisement/new-advert.html",
					                 ),
					                 array(
						                 "title" => __( "Advanced", "wd_ads" ),
						                 "url"   => "https://web-dorado.com/ad-manager-wd/creating-advertisement/advanced.html",
					                 ),
					                 array(
						                 "title" => __( "Geo Targeting", "wd_ads" ),
						                 "url"   => "https://web-dorado.com/ad-manager-wd/creating-advertisement/geo-targeting.html",
					                 ),
					                 array(
						                 "title" => __( "Publishing", "wd_ads" ),
						                 "url"   => "https://web-dorado.com/ad-manager-wd/creating-advertisement/publishing.html",
					                 ),
					                 array(
						                 "title" => __( "Choose Schedules", "wd_ads" ),
						                 "url"   => "https://web-dorado.com/ad-manager-wd/creating-advertisement/choose-schedules.html",
					                 ),
					                 array(
						                 "title" => __( "Wrapper Code", "wd_ads" ),
						                 "url"   => "https://web-dorado.com/ad-manager-wd/creating-advertisement/wrapper-code.html",
					                 ),
					                 array(
						                 "title" => __( "Advertiser", "wd_ads" ),
						                 "url"   => "https://web-dorado.com/ad-manager-wd/creating-advertisement/advertiser.html",
					                 ),
				                 )
			                 ),
			                 3 => array(
				                 "main_title" => __( "Managing All Adverts", "wd_ads" ),
				                 "url"        => "https://web-dorado.com/ad-manager-wd/managing-adverts.html",
				                 "titles"     => array(),
			                 ),
			                 4 => array(
				                 "main_title" => __( "Groups", "wd_ads" ),
				                 "url"        => "https://web-dorado.com/ad-manager-wd/groups.html",
				                 "titles"     => array()
			                 ),
			                 5 => array(
				                 "main_title" => __( "Schedules", "wd_ads" ),
				                 "url"        => "https://web-dorado.com/ad-manager-wd/schedules.html",
				                 "titles"     => array()
			                 ),
			                 6 => array(
				                 "main_title" => __( "Settings", "wd_ads" ),
				                 "url"        => "https://web-dorado.com/ad-manager-wd/settings.html",
				                 "titles"     => array(
					                 array(
						                 "title" => __( "General", "wd_ads" ),
						                 "url"   => "https://web-dorado.com/ad-manager-wd/settings/general.html",
					                 ),
					                 array(
						                 "title" => __( "Statistics", "wd_ads" ),
						                 "url"   => "https://web-dorado.com/ad-manager-wd/settings/statistics.html",
					                 ),
					                 array(
						                 "title" => __( "Geo targeting", "wd_ads" ),
						                 "url"   => "https://web-dorado.com/ad-manager-wd/settings/geo-targeting.html",
					                 ),
					                 array(
						                 "title" => __( "Advertisement and Schedule Roles", "wd_ads" ),
						                 "url"   => "https://web-dorado.com/ad-manager-wd/settings/advert-schedule-roles.html",
					                 ),
				                 )
			                 ),
			                 7 => array(
				                 "main_title" => __( "Import", "wd_ads" ),
				                 "url"        => "https://web-dorado.com/ad-manager-wd/import.html",
				                 "titles"     => array()
			                 ),

			                 8 => array(
				                 "main_title" => __( "Publishing as a Widget", "wd_ads" ),
				                 "url"        => "https://web-dorado.com/ad-manager-wd/publishing.html",
				                 "titles"     => array()
			                 ),
		                 ),
		                 "plugin_wd_url"            => "https://web-dorado.com/products/wordpress-ad-manager-wd.html",
		                 "plugin_wd_forum_link"     => "https://wordpress.org/support/plugin/ad-manager-wd",
		                 "after_subscribe"          => "overview_wd_ads",
		                 "after_subscribe" => "edit.php?post_type=wd_ads_ads&page=overview_wd_ads", // this can be plagin overview page or set up page
		                 "plugin_wizard_link" => null,
		                 "plugin_menu_title" => "Ad Manager WD",
		                 "plugin_menu_icon" => WD_ADS_URL . '/images/icons/Ad-manager-icon.png',
		                 "deactivate" => true,
		                 "subscribe" => true,
		                 "custom_post" => 'edit.php?post_type=wd_ads_ads',  // if true => edit.php?post_type=contact
		                 "menu_position" => '27,11',
	                 ) );

}

function wd_ads_bp_install_notice() {

    // Remove old notice.
    if ( get_option('wds_bk_notice_status') !== FALSE ) {
        update_option('wds_bk_notice_status', '1', 'no');
    }

    // Show notice only on plugin pages.
    if ( !isset($_GET['post_type']) || strpos(esc_html($_GET['post_type']), 'wd_ads') === FALSE ) {
        return '';
    }

    $meta_value = get_option('wd_bk_notice_status');
    if ( $meta_value === '' || $meta_value === FALSE ) {
        ob_start();
        $prefix = 'wd_ads';
        $nicename = 'Ad Manager WD';
        $url = WD_ADS_URL;
        $dismiss_url = add_query_arg(array( 'action' => 'wd_bp_dismiss' ), admin_url('admin-ajax.php'));
        $install_url = esc_url(wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=backup-wd'), 'install-plugin_backup-wd'));
        ?>
        <div class="notice notice-info" id="wd_bp_notice_cont">
            <p>
                <img id="wd_bp_logo_notice" src="<?php echo $url . '/images/logo.png'; ?>" />
                <?php echo sprintf(__("%s advises: Install brand new FREE %s plugin to keep your images and website safe.", $prefix), $nicename, '<a href="https://wordpress.org/plugins/backup-wd/" title="' . __("More details", $prefix) . '" target="_blank">' .  __("Backup WD", $prefix) . '</a>'); ?>
                <a class="button button-primary" href="<?php echo $install_url; ?>">
                    <span onclick="jQuery.post('<?php echo $dismiss_url; ?>');"><?php _e("Install", $prefix); ?></span>
                </a>
            </p>
            <button type="button" class="wd_bp_notice_dissmiss notice-dismiss" onclick="jQuery('#wd_bp_notice_cont').hide(); jQuery.post('<?php echo $dismiss_url; ?>');"><span class="screen-reader-text"></span></button>
        </div>
        <style>
            @media only screen and (max-width: 500px) {
                body #wd_backup_logo {
                    max-width: 100%;
                }
                body #wd_bp_notice_cont p {
                    padding-right: 25px !important;
                }
            }
            #wd_bp_logo_notice {
                width: 40px;
                float: left;
                margin-right: 10px;
            }
            #wd_bp_notice_cont {
                position: relative;
            }
            #wd_bp_notice_cont a {
                margin: 0 5px;
            }
            #wd_bp_notice_cont .dashicons-dismiss:before {
                content: "\f153";
                background: 0 0;
                color: #72777c;
                display: block;
                font: 400 16px/20px dashicons;
                speak: none;
                height: 20px;
                text-align: center;
                width: 20px;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            .wd_bp_notice_dissmiss {
                margin-top: 5px;
            }
        </style>
        <?php
        echo ob_get_clean();
    }
}

if ( !is_dir(plugin_dir_path(__DIR__) . 'backup-wd')) {
    add_action('admin_notices', 'wd_ads_bp_install_notice');
}

if ( !function_exists('wd_bps_install_notice_status') ) {
    // Add usermeta to db.
    function wd_bps_install_notice_status() {
        update_option('wd_bk_notice_status', '1', 'no');
    }
    add_action('wp_ajax_wd_bp_dismiss', 'wd_bps_install_notice_status');
}

function wd_ads_add_plugin_meta_links($meta_fields, $file) {
    if ( plugin_basename(__FILE__) == $file ) {
        $plugin_url = "https://wordpress.org/support/plugin/ad-manager-wd";
        $prefix = 'wd_ads';
        $meta_fields[] = "<a href='" . $plugin_url . "' target='_blank'>" . __('Support Forum', $prefix) . "</a>";
        $meta_fields[] = "<a href='" . $plugin_url . "/reviews#new-post' target='_blank' title='" . __('Rate', $prefix) . "'>
            <i class='wdi-rate-stars'>"
            . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
            . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
            . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
            . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
            . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
            . "</i></a>";

        $stars_color = "#ffb900";

        echo "<style>"
            . ".wdi-rate-stars{display:inline-block;color:" . $stars_color . ";position:relative;top:3px;}"
            . ".wdi-rate-stars svg{fill:" . $stars_color . ";}"
            . ".wdi-rate-stars svg:hover{fill:" . $stars_color . "}"
            . ".wdi-rate-stars svg:hover ~ svg{fill:none;}"
            . "</style>";
    }

    return $meta_fields;
}
add_filter("plugin_row_meta", 'wd_ads_add_plugin_meta_links', 10, 2);