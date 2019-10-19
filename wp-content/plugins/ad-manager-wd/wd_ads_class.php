<?php

/*
WD_ADS
*/

class wd_ads {
	protected        $version     = '1.0.0';
	protected        $plugin_name = 'wd_ads';
	protected        $prefix      = 'wd_ads';
	protected static $instance    = null;
	public static    $device      = '';


	private function __construct() {
		$this->setup_constants();
		include_once( 'includes/wd_ads_shortcodes.php' );
		$this->includes();
		$cpt_instance = ad_wds_Cpt::get_instance();


		// $this->user_info();
		/* add_action('init', array($this, 'add_localization'), 1);
		 add_filter( 'body_class', array( $this, 'theme_body_class' ) );*/

		if ( ! is_admin() ) {
			add_action( 'init', array( $this, 'wd_ads_geo' ) );
			add_action( 'init', array( $this, 'wd_ads_check_device' ) );
		}
		add_action( 'wp_enqueue_scripts', array( $this, 'wd_ads_enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'wd_ads_enqueue_styles' ) );
	}


	public function wd_ads_check_device() {
		$detect = new Mobile_Detect;


		if ( $detect->isMobile() ) {
			self::$device = 'smartphone';
		} elseif ( $detect->isTablet() ) {
			self::$device = 'tablet';
		} else {
			self::$device = 'computer';
		}

	}

	public function wd_ads_geo() {

		$wd_ads_options = wd_ads_get_settings();
		//unset($_SESSION['wd-ads-geo']);

		if ( ! isset( $_SESSION['wd-ads-geo'] ) or ( empty( $_SESSION['wd-ads-geo'] ) and $wd_ads_options['geo_targeting'] != 1 ) ) {


			$geo_array = array();

			$_SESSION['wd-ads-geo'] = $geo_array;

		}


	}

	public function wd_ads_enqueue_scripts() {
		wp_enqueue_script( $this->prefix . '-ads', plugins_url( 'js/wd_ads.js', __FILE__ ), array( 'jquery' ), $this->version );
		wp_localize_script( $this->prefix . '-ads', 'wd_ads',
		                    array(
			                    'ajax_url'  => admin_url( 'admin-ajax.php' ),
			                    'ajaxnonce' => wp_create_nonce( WD_ADS_PLUGIN_PREFIX . '_ajax_nonce' )


		                    ) );
	}

	public function wd_ads_enqueue_styles() {
		wp_enqueue_style( $this->prefix . '-public', plugins_url( 'css/wd_ads_front.css', __FILE__ ), '', $this->version, 'all' );


	}


	/**
	 * Setup constants
	 */
	public function setup_constants() {
		if ( ! defined( 'WD_ADS_PLUGIN_DIR' ) ) {
			define( 'WD_ADS_PLUGIN_DIR', dirname( __FILE__ ) );
		}

		if ( ! defined( 'WD_ADS_PLUGIN_PREFIX' ) ) {
			define( 'WD_ADS_PLUGIN_PREFIX', $this->prefix );
		}
		if ( ! defined( 'WD_ADS_PLUGIN_NAME' ) ) {
			define( 'WD_ADS_PLUGIN_NAME', $this->plugin_name );
		}
		if ( ! defined( 'WD_ADS_URL' ) ) {
			define( 'WD_ADS_URL', plugins_url( plugin_basename( dirname( __FILE__ ) ) ) );
		}
		if ( ! defined( 'WD_ADS_VERSION' ) ) {
			define( 'WD_ADS_VERSION', plugins_url( $this->version ) );
		}
	}


	public static function includes() {
		global $wd_ads_options;
		include_once( 'includes/wd_ads_cpt_class.php' );
		include_once( 'includes/register-settings.php' );
		include_once( 'includes/mobile_detect.php' );
		$wd_ads_options = wd_ads_get_settings();

		include_once( 'includes/wd_ads_functions.php' );

		include_once( 'views/wd_ads_widgets.php' );

	}


	/**
	 * Return the plugin name.
	 */
	public function get_name() {
		return $this->plugin_name;
	}

	/**
	 * Return the plugin prefix.
	 */
	public function get_prefix() {
		return $this->prefix;
	}

	/**
	 * Return the plugin version.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Return an instance of this class.
	 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}


}





