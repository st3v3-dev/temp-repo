<?php

/**
 * Register all settings needed for the Settings API.
 *
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( isset( $_GET[ WD_ADS_PLUGIN_PREFIX . '_clear_cache' ] ) && $_GET[ WD_ADS_PLUGIN_PREFIX . '_clear_cache' ] == 1 ) {
	$cpt     = wd_ads_Cpt::get_instance();
	$cleared = $cpt->delete_transient();
	if ( $cleared ) {
		try {
			echo '<div class= "updated" ><p> ' . __( 'Cache has been deleted.', 'wd_ads' ) . '</p></div>';
		} catch ( Exception $e ) {

		}
	}

}

/**
 *  Main function to register all of the plugin settings
 */
function wd_ads_register_settings() {

	global $wd_ads_settings;
	global $wd_ads_tabs;

	$wd_ads_tabs     = array(
		'general'        => 'General',
		'stats'          => 'Statistics',
		'geo'            => 'Geo targeting',
		'advert-roles'   => 'Advertisement Roles',
		'schedule-roles' => 'Schedule Roles',
	);
	$wd_ads_settings = array(/* General Settings */
	                         'general'      => array(

		                         'ad_block_detection' => array(
			                    'id'   => 'ad_block_detection',
			                    'name' => __( 'Ad Block Detection', 'wd_ads' ),
			                    'desc' => __( 'Enable this option to have a message in case Ad blocker extensions are enabled on user’s browser.', 'wd_ads' ),
			                    'type' => 'checkbox'
		                         ),
		                         'show_massage'       => array(
			                    'id'   => 'show_massage',
			                    'name' => __( 'Show message for', 'wd_ads' ),
			                    'desc' => __( 'Provide the message content for Adblock detection.”', 'wd_ads' ),
			                    'type' => 'show_message_select'
		                         ),
		                         'message_to_show'    => array(
			                    'id'   => 'message_to_show',
			                    'name' => __( 'Message to show', 'wd_ads' ),
			                    'desc' => __( 'Default: "Ad blocker detected! Please wait %time% seconds or disable your ad blocker!" No HTML/Javascript allowed. %time% will be replaced with a countdown in seconds.' ),
			                    'size' => 'large-text',
			                    'std'  => 'You have Adblock activated on your browser. Please wait %time% seconds or disable adblock.',
			                    'type' => 'text'
		                         ),
		                         'bot_filter'         => array(
			                         'id'      => 'bot_filter',
			                         'name'    => __( 'Bot Filter', 'wd_ads' ),
			                         'desc'    => __( 'This option lets you provide list of bots, which will otherwise interact with your adverts. We provide a predefined list, keep them for safe advertising!', 'wd_ads' ),
			                         'size'    => 'large-text',
			                         'std'     => '008, ABACHOBot, Accoona-AI-Agent, AddSugarSpiderBot, alexa, AnyApexBot, Arachmo, B-l-i-t-z-B-O-T, Baiduspider, BecomeBot, BeslistBot, BillyBobBot, Bimbot, Bingbot, BlitzBOT, boitho.com-dc, boitho.com-robot, btbot, CatchBot, Cerberian Drtrs, Charlotte, ConveraCrawler, cosmos, Covario IDS, DataparkSearch, DiamondBot, Discobot, Dotbot, EmeraldShield.com WebBot, envolk[ITS]spider, EsperanzaBot, Exabot, FAST Enterprise Crawler, FAST-WebCrawler, FDSE robot, FindLinks, FurlBot, FyberSpider, g2crawler, Gaisbot, GalaxyBot, genieBot, Gigabot, Girafabot, Googlebot, Googlebot-Image, GurujiBot, HappyFunBot, hl_ftien_spider, Holmes, htdig, iaskspider, ia_archiver, iCCrawler, ichiro, inktomi, igdeSpyder, IRLbot, IssueCrawler, Jaxified Bot, Jyxobot, KoepaBot, L.webis, LapozzBot, Larbin, LDSpider, LexxeBot, Linguee Bot, LinkWalker, lmspider, lwp-trivial, mabontland, magpie-crawler, Mediapartners-Google, MJ12bot, Mnogosearch, mogimogi, MojeekBot, Moreoverbot, Morning Paper, msnbot, MSRBot, MVAClient, mxbot, NetResearchServer, NetSeer Crawler, NewsGator, NG-Search, nicebot, noxtrumbot, Nusearch Spider, NutchCVS, Nymesis, obot, oegp, omgilibot, OmniExplorer_Bot, OOZBOT, Orbiter, PageBitesHyperBot, Peew, polybot, Pompos, PostPost, Psbot, PycURL, Qseero, Radian6, RAMPyBot, RufusBot, SandCrawler, SBIder, ScoutJet, Scrubby, SearchSight, Seekbot, semanticdiscovery, Sensis Web Crawler, SEOChat::Bot, SeznamBot, Shim-Crawler, ShopWiki, Shoula robot, silk, Sitebot, Snappy, sogou spider, Sosospider, Speedy Spider, Sqworm, StackRambler, suggybot, SurveyBot, SynooBot, Teoma, TerrawizBot, TheSuBot, Thumbnail.CZ robot, TinEye, truwoGPS, TurnitinBot, TweetedTimes Bot, TwengaBot, updated, Urlfilebot, Vagabondo, VoilaBot, Vortex, voyager, VYU2, webcollage, Websquash.com, wf84, WoFindeIch Robot, WomlpeFactory, Xaldon_WebSpider, yacy, Yahoo! Slurp, Yahoo! Slurp China, YahooSeeker, YahooSeeker-Testing, YandexBot, YandexImages, Yasaklibot, Yeti, YodaoBot, yoogliFetchAgent, YoudaoBot, Zao, Zealbot, zspider, ZyBorg, crawler, bot, froogle, looksmart, URL_Spider_SQL, Firefly, NationalDirectory, Ask Jeeves, TECNOSEEK, InfoSeek, WebFindBot, Googlebot, Scooter, appie, WebBug, Spade, rabaz, Feedfetcher-Google, TechnoratiSnoop, Rankivabot, Mediapartners-Google, Sogou web spider, WebAlta Crawler',
			                         'options' => array( 'height' => 300 ),
			                         'type'    => 'textarea'
		                         ),

		                         'send_notification' => array(
			                    'id'   => 'send_notification',
			                    'name' => __( 'Send Notification when', 'wd_ads' ),
			                    'desc' => __( 'Choose when to send email or Pushover notifications, when an advertisement is saved by any advertiser, or approved by site moderators.', 'wd_ads' ),
			                    'size' => '',
			                    'type' => 'notification_checkbox'
		                         ),

		                         'email_message' => array(
			                    'id'   => 'email_message',
			                    'desc' => __( 'Mark this option as checked to receive notifications to your email.', 'wd_ads' ),
			                    'name' => __( 'Email message', 'wd_ads' ),
			                    'type' => 'checkbox'
		                         ),
		                         'email_address' => array(
			                    'id'   => 'email_address',
			                    'name' => __( 'E-mail', 'wd_ads' ),
			                    'desc' => __( 'Provide the list of email addresses, separated by commas.', 'wd_ads' ),
			                    'size' => 'medium-text email_address',
			                    'type' => 'text'
		                         ),
		                         'pushover'      => array(
			                    'id'   => 'pushover',
			                    'name' => __( 'Push notifications to your smartphone', 'wd_ads' ),
			                    'desc' => __( 'Enable this option to receive notifications directly to your smartphone through Pushover.', 'wd_ads' ),

			                    'type' => 'checkbox'
		                         ),


		                         'pushover_section_text' => array(
			                    'id'   => 'pushover_section_text',
			                    'name' => __( 'Pushover Settings', 'wd_ads' ),
			                    'size' => 'pushover_notifications',
			                    'type' => 'section_text'
		                         ),
		                         'pushover_key'          => array(
			                    'id'   => 'pushover_key',
			                    'name' => __( 'User Key', 'wd_ads' ),
			                    'desc' => __( 'Provide User Key of your Pushover account to which you are going to receive notifications.', 'wd_ads' ),
			                    'size' => 'medium-text pushover_notifications',
			                    'type' => 'text'
		                         ),
		                         'pushover_token'        => array(
			                    'id'   => 'pushover_token',
			                    'name' => __( 'API Token', 'wd_ads' ),
			                    'desc' => __( 'Provide the API Token from your Pushover account.', 'wd_ads' ),
			                    'size' => 'medium-text pushover_notifications',
			                    'type' => 'text'
		                         ),


	                         ),
	                         'stats'        => array(
		                         'stats_track' => array(
			                    'id'   => 'stats_track',
			                    'name' => __( 'Stats Tracking', 'wd_ads' ),
			                    'desc' => __( 'You can check advertisement statistics with Internal Tracker, as well as integrate tracking with Piwik Analytics or Google Analytics.<br>Note, that in order to track with Piwik Analytics and Google Analytics, you need to include their tracking code to header.php or footer.php files of your website theme.', 'wd_ads' ),
			                    'type' => 'stats_track_select'
		                         ),

		                         'internal_tarack' => array(
			                    'id'   => 'internal_tarack',
			                    'name' => __( 'Internal Tracker Options', 'wd_ads' ),
			                    'type' => 'section_text'
		                         ),

		                         'logged_in_impressions' => array(
			                    'id'   => 'logged_in_impressions',
			                    'name' => __( 'Logged in impressions', 'wd_ads' ),
			                    'desc' => __( 'Enable this option to track impressions from logged in users.', 'wd_ads' ),
			                    'std'  => '1',
			                    'type' => 'checkbox'
		                         ),

		                         'logged_in_clicks' => array(
			                    'id'   => 'logged_in_clicks',
			                    'name' => __( 'Logged in clicks', 'wd_ads' ),
			                    'desc' => __( 'Enable this option to track clicks from logged in users.', 'wd_ads' ),
			                    'std'  => '1',
			                    'type' => 'checkbox'
		                         ),
		                         'impression_timer' => array(
			                    'id'   => 'impression_timer',
			                    'name' => __( 'Impression timer', 'wd_ads' ),
			                    'desc' => __( 'Set a timer for impressions. This setting will not count sequential impressions during this period.', 'wd_ads' ),
			                    'std'  => '60',
			                    'size' => 'small-text',
			                    'type' => 'text'
		                         ),

		                         'click_timer' => array(
			                    'id'   => 'click_timer',
			                    'name' => __( 'Click timer', 'wd_ads' ),
			                    'desc' => __( 'Set a timer for clicks. This setting will not count sequential clicks during this period.', 'wd_ads' ),
			                    'std'  => '60',
			                    'size' => 'small-text',
			                    'type' => 'text'
		                         )


	                         ),
	                         'geo'          => array(
		                         'buy_pro_text' => array(
			                    'id'      => 'buy_pro_text',
			                    'default' => 'Geo targeting is Available Only in PRO version',
			                    'name'    => __( '', 'wd_ads' ),
			                    'desc'    => __( '', 'wd_ads' ),
			                    'type'    => 'buy_pro_text'
		                         ),
		                         'geo_targeting' => array(
			                    'id'   => 'geo_targeting',
			                    'name' => __( 'Geo Service', 'wd_ads' ),
			                    'desc' => __( 'Select the service for Geo targeting, WD Adverts or MaxMind. WD Adverts is automatically connected to Advertisement WD plugin, whereas MaxMind requires username and password.', 'wd_ads' ),
			                    'type' => 'geo_targeting_select'
		                         ),

		                         'maxmind_section_text' => array(
			                    'id'   => 'maxmind_section_text',
			                    'name' => __( 'MaxMind Settings', 'wd_ads' ),
			                    'desc' => __( 'Provide username and password of your MaxMind account.', 'wd_ads' ),
			                    'size' => 'maxmind_notifications',
			                    'type' => 'section_text'
		                         ),

		                         'maxmind_username' => array(
			                    'id'   => 'maxmind_username',
			                    'name' => __( 'MaxMind Username', 'wd_ads' ),
			                    'size' => 'medium-text',
			                    'type' => 'text'
		                         ),

		                         'maxmind_password' => array(
			                    'id'   => 'maxmind_password',
			                    'name' => __( 'MaxMind Password', 'wd_ads' ),
			                    'size' => 'medium-text',
			                    'type' => 'text'
		                         ),

	                         ),
	                         'advert-roles' => array(
		                         'buy_pro_text' => array(
			                    'id'      => 'buy_pro_text',
			                    'default' => 'Advertisement Roles Available Only in PRO version',
			                    'name'    => __( '', 'wd_ads' ),
			                    'desc'    => __( '', 'wd_ads' ),
			                    'type'    => 'buy_pro_text'
		                         ),

		                         'edit_wd_ads_adverts'        => array(
			                    'id'   => 'edit_wd_ads_adverts',
			                    'name' => __( 'Edit own adverts', 'wd_ads' ),
			                    'desc' => __( 'Select user roles, which will be able to edit the adverts they created.', 'wd_ads' ),
			                    'std'  => 'array("administrator")',
			                    'type' => 'advertiser_roles_checkbox'
		                         ),
		                         'edit_others_wd_ads_adverts' => array(
			                    'id'   => 'edit_others_wd_ads_adverts',
			                    'name' => __( 'Edit Others adverts', 'wd_ads' ),
			                    'desc' => __( 'Mark to allow user roles to edit any adverts of your website.', 'wd_ads' ),
			                    'type' => 'advertiser_roles_checkbox'
		                         ),

		                         'publish_wd_ads_adverts' => array(
			                    'id'   => 'publish_wd_ads_adverts',
			                    'name' => __( 'Publish adverts', 'wd_ads' ),
			                    'desc' => __( 'Choose the roles, which can publish created adverts.', 'wd_ads' ),
			                    'type' => 'advertiser_roles_checkbox'
		                         ),

		                         'delete_wd_ads_adverts' => array(
			                    'id'   => 'delete_wd_ads_adverts',
			                    'name' => __( 'Delete adverts', 'wd_ads' ),
			                    'desc' => __( 'Select roles, which are permitted to delete their own advertisements from your website.', 'wd_ads' ),
			                    'type' => 'advertiser_roles_checkbox'
		                         ),

		                         'delete_others_wd_ads_adverts' => array(
			                    'id'   => 'delete_others_wd_ads_adverts',
			                    'name' => __( 'Delete Others adverts', 'wd_ads' ),
			                    'desc' => __( 'Choose roles to permit them to delete any advertisements from your website.', 'wd_ads' ),
			                    'type' => 'advertiser_roles_checkbox'
		                         ),

		                         'assign_wd_ads_adverts' => array(
			                    'id'   => 'assign_wd_ads_adverts',
			                    'name' => __( 'Assign groups', 'wd_ads' ),
			                    'desc' => __( 'Select roles to let them assign groups to adverts.', 'wd_ads' ),
			                    'type' => 'advertiser_roles_checkbox'
		                         ),

		                         'edit_stats_wd_ads_adverts' => array(
			                    'id'   => 'edit_stats_wd_ads_adverts',
			                    'name' => __( 'Statistics Access', 'wd_ads' ),
			                    'desc' => __( 'Select roles to let them access advert statistics.', 'wd_ads' ),
			                    'type' => 'advertiser_roles_checkbox'
		                         ),


	                         ),

	                         'schedule-roles' => array(
		                         'buy_pro_text'                   => array(
			                    'id'      => 'buy_pro_text',
			                    'default' => 'Schedule Roles Available Only in PRO version',
			                    'name'    => __( '', 'wd_ads' ),
			                    'desc'    => __( '', 'wd_ads' ),
			                    'type'    => 'buy_pro_text'
		                         )
		                         ,
		                         'edit_wd_ads_schedules'        => array(
			                    'id'   => 'edit_wd_ads_schedules',
			                    'name' => __( 'Edit own schedules', 'wd_ads' ),
			                    'desc' => __( 'Select user roles, which will be able to edit advert schedules that they created.', 'wd_ads' ),
			                    'type' => 'advertiser_roles_checkbox'
		                         ),
		                         'edit_others_wd_ads_schedules' => array(
			                    'id'   => 'edit_others_wd_ads_schedules',
			                    'name' => __( 'Edit Others schedules', 'wd_ads' ),
			                    'desc' => __( 'Mark to allow user roles to edit any advert schedules of your website.', 'wd_ads' ),
			                    'type' => 'advertiser_roles_checkbox'
		                         ),

		                         'publish_wd_ads_schedules' => array(
			                    'id'   => 'publish_wd_ads_schedules',
			                    'name' => __( 'Publish schedules', 'wd_ads' ),
			                    'desc' => __( 'Choose the roles, which can publish created schedules.', 'wd_ads' ),
			                    'type' => 'advertiser_roles_checkbox'
		                         ),

		                         'delete_wd_ads_schedules' => array(
			                    'id'   => 'delete_wd_ads_schedules',
			                    'name' => __( 'Delete schedules', 'wd_ads' ),
			                    'desc' => __( 'Select roles, which are permitted to delete their own schedules from your website.', 'wd_ads' ),
			                    'type' => 'advertiser_roles_checkbox'
		                         ),

		                         'delete_others_wd_ads_schedules' => array(
			                    'id'   => 'delete_others_wd_ads_schedules',
			                    'name' => __( 'Delete Others schedules', 'wd_ads' ),
			                    'desc' => __( 'Choose roles to permit them to delete any schedules from your website.', 'wd_ads' ),
			                    'type' => 'advertiser_roles_checkbox'
		                         ),

	                         ),
	);

	/* If the options do not exist then create them for each section */
	if ( false == get_option( WD_ADS_PLUGIN_PREFIX . '_settings' ) ) {
		add_option( WD_ADS_PLUGIN_PREFIX . '_settings' );
	}


	/* Add the  Settings sections */


	foreach ( $wd_ads_settings as $key => $settings ) {

		add_settings_section( WD_ADS_PLUGIN_PREFIX . '_settings_' . $key, __( $wd_ads_tabs[ $key ], 'wd_ads' ), '__return_false', WD_ADS_PLUGIN_PREFIX . '_settings_' . $key );


		foreach ( $settings as $option ) {
			add_settings_field( WD_ADS_PLUGIN_PREFIX . '_settings_' . $key . '[' . $option['id'] . ']', $option['name'], function_exists( WD_ADS_PLUGIN_PREFIX . '_' . $option['type'] . '_callback' ) ? WD_ADS_PLUGIN_PREFIX . '_' . $option['type'] . '_callback' : WD_ADS_PLUGIN_PREFIX . '_missing_callback', WD_ADS_PLUGIN_PREFIX . '_settings_' . $key, WD_ADS_PLUGIN_PREFIX . '_settings_' . $key, wd_ads_get_settings_field_args( $option, $key ) );
		}

		/* Register all settings or we will get an error when trying to save */
		register_setting( WD_ADS_PLUGIN_PREFIX . '_settings_' . $key, WD_ADS_PLUGIN_PREFIX . '_settings_' . $key, WD_ADS_PLUGIN_PREFIX . '_settings_sanitize' );
	}
}

add_action( 'admin_init', WD_ADS_PLUGIN_PREFIX . '_register_settings' );

/*
 * Return generic add_settings_field $args parameter array.
 *
 * @param   string  $option   Single settings option key.
 * @param   string  $section  Section of settings apge.
 * @return  array             $args parameter to use with add_settings_field call.
 */


function wd_ads_buy_pro_text_callback( $args ) {
	echo '<label class="wd_ads_for_pro_only_section">' . $args['default'] . '</label>';
}


function wd_ads_advertiser_roles_checkbox_callback( $args ) {
	global $wd_ads_options;
	global $wp_roles;


	$roles = $wp_roles->get_names();
	//$checked = isset($wd_ads_options[$args['id']]) ? checked(1, $wd_ads_options[$args['id']], false) : '';

	$html = '';


	foreach ( $roles as $role_value => $role_name ) {

		$checked = isset( $wd_ads_options[ $args['id'] ] ) && in_array( $role_value, $wd_ads_options[ $args['id'] ] ) ? 'checked' : '';

		if ( $role_value == 'administrator' ) {
			$checked = 'checked disabled';
		}

		$html .= '<div class="checkbox-div">
    <input disabled type="checkbox" id="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']_' . $role_value . '" name="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . '][]" value="' . $role_value . '" ' . $checked . '/><label for="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']_' . $role_value . '">' . $role_name . '</label></div>';
	}


	// Render description text directly to the right in a label if it exists.
	if ( ! empty( $args['desc'] ) ) {
		$html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
	}

	echo $html;
}

function wd_ads_notification_checkbox_callback( $args ) {
	global $wd_ads_options;

	if ( ! isset( $wd_ads_options[ $args['id'] ] ) ) {
		$wd_ads_options[ $args['id'] ] = array();
	}

	$checked1 = '';
	$checked2 = '';

	if ( in_array( 1, $wd_ads_options[ $args['id'] ] ) ) {
		$checked1 = 'checked="checked"';
	}

	if ( in_array( 2, $wd_ads_options[ $args['id'] ] ) ) {
		$checked2 = 'checked="checked"';
	}

	$html = '';
	$html .= '<div class="checkbox-div">
    <input type="checkbox" ' . $checked1 . '  id="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']_1" name="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . '][]" value="1" /><label for="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']_1">Any advertiser saving an advert in your moderation queue.</label></div>';

	$html .= '<div class="checkbox-div">
    <input type="checkbox" ' . $checked2 . '  id="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']_2" name="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . '][]" value="2" /><label for="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']_2">A moderator approved an advert from the moderation queue.</label></div>';


	// Render description text directly to the right in a label if it exists.
	if ( ! empty( $args['desc'] ) ) {
		$html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
	}

	echo $html;
}


function wd_ads_get_settings_field_args( $option, $section ) {
	$settings_args = array(
		'id'      => $option['id'],
		'desc'    => isset( $option['desc'] ) ? $option['desc'] : '',
		'name'    => $option['name'],
		'section' => $section,
		'size'    => isset( $option['size'] ) ? $option['size'] : null,
		'class'   => isset( $option['class'] ) ? $option['class'] : null,
		'options' => isset( $option['options'] ) ? $option['options'] : '',
		'std'     => isset( $option['std'] ) ? $option['std'] : '',
		'href'    => isset( $option['href'] ) ? $option['href'] : '',
		'default' => isset( $option['default'] ) ? $option['default'] : ''
	);


	// Link label to input using 'label_for' argument if text, textarea, password, select, or variations of.
	// Just add to existing settings args array if needed.
	if ( in_array( $option['type'], array( 'text', 'select', 'textarea', 'password', 'number' ) ) ) {
		$settings_args = array_merge( $settings_args, array( 'label_for' => WD_ADS_PLUGIN_PREFIX . '_settings_' . $section . '[' . $option['id'] . ']' ) );
	}

	return $settings_args;
}


/*
 * Text select callback function
 */

function wd_ads_section_text_callback( $args ) {
	$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : '';
	$html = '<input type="hidden" class="' . $size . '" />';
	echo $html;

}


/*
 * Show Message select callback function
 */


function wd_ads_show_message_select_callback( $args ) {
	global $wd_ads_options;
	$html = "\n" . '<select  id="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" name="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" >';
	for ( $i = 1; $i <= 9; $i ++ ) {
		$html .= '<option value="' . $i . '" ' . selected( $i, isset( $wd_ads_options[ $args['id'] ] ) ? $wd_ads_options[ $args['id'] ] : '', false ) . '>' . $i . '</option>';
	}
	$html .= '<option value="10" ' . selected( 10, isset( $wd_ads_options[ $args['id'] ] ) ? $wd_ads_options[ $args['id'] ] : '', false ) . '>10</option>
	   <option value="15" ' . selected( 15, isset( $wd_ads_options[ $args['id'] ] ) ? $wd_ads_options[ $args['id'] ] : '', false ) . '>15</option>
	   <option value="20" ' . selected( 20, isset( $wd_ads_options[ $args['id'] ] ) ? $wd_ads_options[ $args['id'] ] : '', false ) . '>20</option>';

	$html .= '</select>' . "\n";

	// Render description text directly to the right in a label if it exists.
	if ( ! empty( $args['desc'] ) ) {
		$html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
	}

	echo $html;
}

/*
 * Statistics Tracking select callback function
 */


function wd_ads_stats_track_select_callback( $args ) {
	global $wd_ads_options;
	$html = "\n" . '<select  id="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" name="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" >';

	$html .= '<option value="1" ' . selected( 1, isset( $wd_ads_options[ $args['id'] ] ) ? $wd_ads_options[ $args['id'] ] : '', false ) . '>Internal Tracker</option>
	   <option value="2" disabled>Piwik Analytics</option>
	   <option value="3" disabled>Google Analytics</option>';

	$html .= '</select>' . "\n";

	// Render description text directly to the right in a label if it exists.
	if ( ! empty( $args['desc'] ) ) {
		$html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
	}

	$html .= '<label class="wd_ads_for_pro_only">Google and Piwik Analytics Available Only in PRO version</label>';

	echo $html;
}

/*
 * GEO targeting select callback function
 */


function wd_ads_geo_targeting_select_callback( $args ) {
	global $wd_ads_options;
	$html = "\n" . '<select  id="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" name="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" >';

	$html .= '<option value="1" ' . selected( 1, isset( $wd_ads_options[ $args['id'] ] ) ? $wd_ads_options[ $args['id'] ] : '', false ) . '>Disabled</option>
	   <option value="2" disabled>Max Mind free</option>
	   <option value="3" disabled>MaxMind</option>';

	$html .= '</select>' . "\n";

	// Render description text directly to the right in a label if it exists.
	if ( ! empty( $args['desc'] ) ) {
		$html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
	}

	echo $html;
}

/*
 * Advertiser Roles select callback function
 */


function wd_ads_advertiser_roles_select_callback( $args ) {
	global $wd_ads_options;
	echo '<select  id="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" name="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" >';

	wp_dropdown_roles( isset( $wd_ads_options[ $args['id'] ] ) ? $wd_ads_options[ $args['id'] ] : 'administrator' );

	echo '</select>';


	// Render description text directly to the right in a label if it exists.
	if ( ! empty( $args['desc'] ) ) {
		echo '<p class="description">' . $args['desc'] . '</p>' . "\n";
	}

}


/*
* Time type select callback function
 */


function wd_ads_time_type_select_callback( $args ) {
	global $wd_ads_options;
	$html = "\n" . '<select  id="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" name="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" >
        <option value="" ' . selected( "", isset( $wd_ads_options[ $args['id'] ] ) ? $wd_ads_options[ $args['id'] ] : '', false ) . '>Use 24-hour format</option>
        <option value="a" ' . selected( "a", isset( $wd_ads_options[ $args['id'] ] ) ? $wd_ads_options[ $args['id'] ] : '', false ) . '>Use am/pm</option>
        <option value="A" ' . selected( "A", isset( $wd_ads_options[ $args['id'] ] ) ? $wd_ads_options[ $args['id'] ] : '', false ) . '>Use AM/PM</option>
    </select>' . "\n";

	// Render description text directly to the right in a label if it exists.
	if ( ! empty( $args['desc'] ) ) {
		$html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
	}

	echo $html;
}

/*
 * Order select callback function
 */

function wd_ads_order_select_callback( $args ) {
	global $wd_ads_options;
	$html = "\n" . '<select  id="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" name="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" >
        <option value="post_name" ' . selected( 'post_name', isset( $wd_ads_options[ $args['id'] ] ) ? $wd_ads_options[ $args['id'] ] : '', false ) . '>Name</option>
        <option value="ID" ' . selected( 'ID', isset( $wd_ads_options[ $args['id'] ] ) ? $wd_ads_options[ $args['id'] ] : '', false ) . '>ID</option>
        <option value="post_date" ' . selected( 'post_date', isset( $wd_ads_options[ $args['id'] ] ) ? $wd_ads_options[ $args['id'] ] : '', false ) . '>Date</option>
    </select>' . "\n";

	// Render description text directly to the right in a label if it exists.
	if ( ! empty( $args['desc'] ) ) {
		$html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
	}

	echo $html;
}

function wd_ads_update_select_callback( $args ) {
	global $wd_ads_options;
	$html = "\n" . '<select  id="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" name="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" >
        <option value="1" ' . selected( 1, isset( $wd_ads_options[ $args['id'] ] ) ? $wd_ads_options[ $args['id'] ] : '', false ) . '>1 hour</option>
        <option value="2" ' . selected( 2, isset( $wd_ads_options[ $args['id'] ] ) ? $wd_ads_options[ $args['id'] ] : '', false ) . '>2 hours</option>
        <option value="3" ' . selected( 3, isset( $wd_ads_options[ $args['id'] ] ) ? $wd_ads_options[ $args['id'] ] : '', false ) . '>3 hours</option>
        <option value="5" ' . selected( 5, isset( $wd_ads_options[ $args['id'] ] ) ? $wd_ads_options[ $args['id'] ] : '', false ) . '>5 hours</option>
        <option value="12" ' . selected( 12, isset( $wd_ads_options[ $args['id'] ] ) ? $wd_ads_options[ $args['id'] ] : '', false ) . '>12 hours</option>
    </select>' . "\n";

	// Render description text directly to the right in a label if it exists.
	if ( ! empty( $args['desc'] ) ) {
		$html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
	}

	echo $html;
}

function wd_ads_status_select_callback( $args ) {
	global $wd_ads_options;
	$html = "\n" . '<select  id="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" name="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" >
        <option value="draft" ' . selected( 'draft', isset( $wd_ads_options[ $args['id'] ] ) ? $wd_ads_options[ $args['id'] ] : '', false ) . '>Draft</option>
        <option value="publish" ' . selected( 'publish', isset( $wd_ads_options[ $args['id'] ] ) ? $wd_ads_options[ $args['id'] ] : '', false ) . '>Published</option>
        <option value="pending" ' . selected( 'pending', isset( $wd_ads_options[ $args['id'] ] ) ? $wd_ads_options[ $args['id'] ] : '', false ) . '>Pending review</option>
    </select>' . "\n";

	// Render description text directly to the right in a label if it exists.
	if ( ! empty( $args['desc'] ) ) {
		$html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
	}

	echo $html;
}

/*
 * Radio callback function
 */

function wd_ads_radio_callback( $args ) {
	global $wd_ads_options;

	$checked_no = isset( $wd_ads_options[ $args['id'] ] ) ? checked( 0, $wd_ads_options[ $args['id'] ], false ) : ( isset( $args['default'] ) ? checked( 0, $args['default'], false ) : '' );

	$checked_yes = isset( $wd_ads_options[ $args['id'] ] ) ? checked( 1, $wd_ads_options[ $args['id'] ], false ) : ( isset( $args['default'] ) ? checked( 1, $args['default'], false ) : '' );


	$html = "\n" . ' <div class="checkbox-div"><input type="radio" id="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']_yes" name="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" value="1" ' . $checked_yes . '/><label for="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']_yes"></label></div> <label for="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']_yes">Yes</label>' . "\n";
	$html .= '<div class="checkbox-div"> <input type="radio" id="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']_no" name="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" value="0" ' . $checked_no . '/><label for="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']_no"></label></div> <label for="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']_no">No</label>' . "\n";
	// Render description text directly to the right in a label if it exists.
	if ( ! empty( $args['desc'] ) ) {
		$html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
	}

	echo $html;
}

/*
 * Single checkbox callback function
 */

function wd_ads_checkbox_callback( $args ) {
	global $wd_ads_options;

	$checked           = isset( $wd_ads_options[ $args['id'] ] ) ? checked( 1, $wd_ads_options[ $args['id'] ], false ) : '';
	$onChange_function = '';
	if ( $args['id'] == 'email_message' ) {
		$onChange_function = 'onchange="wd_ads_show_hide_notifications(this,\'email\')"';
	}
	$disabled = '';

	if ( $args['id'] == 'pushover' ) {
		$onChange_function = 'onchange="wd_ads_show_hide_notifications(this,\'pushover\')"';
		$disabled          = 'disabled';
	}

	$html = "\n" . '<div class="checkbox-div"><input type="checkbox" ' . $onChange_function . ' id="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" ' . $disabled . ' name="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']"  value="1" ' . $checked . '/><label for="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']"></label></div>' . "\n";
	// Render description text directly to the right in a label if it exists.
	if ( ! empty( $args['desc'] ) ) {
		$html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
	}
	if ( $args['id'] == 'pushover' ) {
		$html .= '<label class="wd_ads_for_pro_only">This Feature is Available Only in PRO version</label>';
	}


	echo $html;
}

/*
 * Multiple checkboxs callback function
 */
function wd_ads_cats_checkbox_callback( $args ) {
	global $wd_ads_options;
	$categories = get_terms( 'wd_ads_event_category', array( 'hide_empty' => false ) );
	$html       = '';
	if ( ! empty( $categories ) ) {
		foreach ( $categories as $cat ) {
			$checked = ( isset( $wd_ads_options[ $args['id'] ] ) && in_array( $cat->term_id, $wd_ads_options[ $args['id'] ] ) ) ? 'checked="checked"' : '';
			$html .= "\n" . '<div class="checkbox-div"><input type="checkbox" id="wd_ads_settings_' . $args['section'] . '_' . $args['id'] . '[' . $cat->term_id . ']" name="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . '][]" value="' . $cat->term_id . '" ' . $checked . '/><label for="wd_ads_settings_' . $args['section'] . '_' . $args['id'] . '[' . $cat->term_id . ']"></label></div><label for="wd_ads_settings_' . $args['section'] . '_' . $args['id'] . '[' . $cat->term_id . ']">' . $cat->name . '</label>' . "\n";
		}
	}
	//$html = "\n" . '<input type="checkbox" id="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" name="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" value="1" ' . $checked . '/>' . "\n";

	// Render description text directly to the right in a label if it exists.
	if ( ! empty( $args['desc'] ) ) {
		$html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
	}

	echo $html;
}

/**
 * Textbox callback function
 * Valid built-in size CSS class values:
 * small-text, regular-text, large-text
 *
 */
function wd_ads_text_callback( $args ) {
	global $wd_ads_options;

	if ( isset( $wd_ads_options[ $args['id'] ] ) ) {
		$value = $wd_ads_options[ $args['id'] ];
	} else {
		$value = isset( $args['std'] ) ? $args['std'] : '';
	}
	$disabled='';
	if($args['id']=='maxmind_username' || $args['id']=='maxmind_password')
	{
		$disabled='disabled';
	}


	$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : '';
	$html = "\n" . '<input type="text" '.$disabled.' class="' . $size . '" id="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" name="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" value="' . esc_attr( $value ) . '"/>' . "\n";

	// Render and style description text underneath if it exists.
	if ( ! empty( $args['desc'] ) ) {
		$html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
	}

	echo $html;
}

/**
 * Textarea callback function
 * Valid built-in size CSS class values:
 * small-text, regular-text, large-text
 *
 */
function wd_ads_textarea_callback( $args ) {
	global $wd_ads_options;

	if ( isset( $wd_ads_options[ $args['id'] ] ) ) {
		$value = $wd_ads_options[ $args['id'] ];
	} else {
		$value = isset( $args['std'] ) ? $args['std'] : '';
	}

	$size   = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : '';
	$height = ( isset( $args['options']['height'] ) && ! is_null( $args['options']['height'] ) ) ? $args['options']['height'] : '';

	$html = "\n" . '<textarea type="text" style="height:' . $height . 'px" class="' . $size . '" id="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" name="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']" > ' . esc_attr( $value ) . '  </textarea>' . "\n";

	// Render and style description text underneath if it exists.
	if ( ! empty( $args['desc'] ) ) {
		$html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
	}

	echo $html;
}

/**
 * Additional fields textbox callback function
 * Valid built-in size CSS class values:
 * small-text, regular-text, large-text
 *
 */
function wd_ads_af_text_callback( $args ) {
	global $wd_ads_options;
	$value = isset( $wd_ads_options[ $args['id'] ] ) ? $wd_ads_options[ $args['id'] ] : array( '' );
	$size  = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : '';
	$class = ( isset( $args['class'] ) && ! is_null( $args['class'] ) ) ? $args['class'] : '';
	$html  = '';
	foreach ( $value as $item ) {
		$html .= "\n" . '<input type="text" class="' . $size . " " . $class . '"  name="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . '][]" value="' . esc_attr( $item ) . '"/><div class="af_del">X</div>' . "<br>";
	}

	// Render and style description text underneath if it exists.
	if ( ! empty( $args['desc'] ) ) {
		$html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
	}
	$html .= '<div class="af_plus">+</div>';
	echo $html;
}

/**
 * Button callback function
 * Valid built-in size CSS class values:
 * small-text, regular-text, large-text
 *
 */
function wd_ads_link_callback( $args ) {
	global $wd_ads_options;

	$value = isset( $args['name'] ) ? $args['name'] : '';
	$href  = isset( $args['href'] ) ? $args['href'] : '#';
	$html  = "\n" . '<a class="button" href="' . $href . '" id="wd_ads_settings_' . $args['section'] . '[' . $args['id'] . ']"  >' . esc_attr( $value ) . '</a>' . "\n";
	// Render and style description text underneath if it exists.
	if ( ! empty( $args['desc'] ) ) {
		$html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
	}

	echo $html;
}

/*
 * Function we can use to sanitize the input data and return it when saving options
 * 
 */

function wd_ads_settings_sanitize( $input ) {
	//add_settings_error( 'wd_ads-notices', '', '', '' );
	return $input;
}

/*
 *  Default callback function if correct one does not exist
 * 
 */

function wd_ads_missing_callback( $args ) {
	printf( __( 'The callback function used for the <strong>%s</strong> setting is missing.', 'wd_ads' ), $args['id'] );
}

/*
 * Function used to return an array of all of the plugin settings
 * 
 */

function wd_ads_get_settings() {
	$wd_ads_tabs = array(
		'general'        => 'General',
		'stats'          => 'Statistics',
		'geo'            => 'Geo targeting',
		'advert-roles'   => 'Advertisement Roles',
		'schedule-roles' => 'Schedule Roles',

	);
	// Set default settings
	// If this is the first time running we need to set the defaults
	if ( ! get_option( WD_ADS_PLUGIN_PREFIX . '_settings_general' ) ) {

		$general        = get_option( WD_ADS_PLUGIN_PREFIX . '_settings_general' );
		$stats          = get_option( WD_ADS_PLUGIN_PREFIX . '_settings_stats' );
		$geo            = get_option( WD_ADS_PLUGIN_PREFIX . '_settings_geo' );
		$roles          = get_option( WD_ADS_PLUGIN_PREFIX . '_settings_roles' );
		$advert_roles   = get_option( WD_ADS_PLUGIN_PREFIX . '_settings_advert-roles' );
		$schedule_roles = get_option( WD_ADS_PLUGIN_PREFIX . '_settings_schedule-roles' );
		/*GENERAL DEFAULT SETTINGS*/
		$general['save_settings']      = 1;
		$general['ad_block_detection'] = 0;
		$general['show_massage']       = 3;
		$general['message_to_show']    = 'You have Adblock activated on your browser. Please wait %time% seconds or disable adblock.';
		$general['bot_filter']         = ' 008, ABACHOBot, Accoona-AI-Agent, AddSugarSpiderBot, alexa, AnyApexBot, Arachmo, B-l-i-t-z-B-O-T, Baiduspider, BecomeBot, BeslistBot, BillyBobBot, Bimbot, Bingbot, BlitzBOT, boitho.com-dc, boitho.com-robot, btbot, CatchBot, Cerberian Drtrs, Charlotte, ConveraCrawler, cosmos, Covario IDS, DataparkSearch, DiamondBot, Discobot, Dotbot, EmeraldShield.com WebBot, envolk[ITS]spider, EsperanzaBot, Exabot, FAST Enterprise Crawler, FAST-WebCrawler, FDSE robot, FindLinks, FurlBot, FyberSpider, g2crawler, Gaisbot, GalaxyBot, genieBot, Gigabot, Girafabot, Googlebot, Googlebot-Image, GurujiBot, HappyFunBot, hl_ftien_spider, Holmes, htdig, iaskspider, ia_archiver, iCCrawler, ichiro, inktomi, igdeSpyder, IRLbot, IssueCrawler, Jaxified Bot, Jyxobot, KoepaBot, L.webis, LapozzBot, Larbin, LDSpider, LexxeBot, Linguee Bot, LinkWalker, lmspider, lwp-trivial, mabontland, magpie-crawler, Mediapartners-Google, MJ12bot, Mnogosearch, mogimogi, MojeekBot, Moreoverbot, Morning Paper, msnbot, MSRBot, MVAClient, mxbot, NetResearchServer, NetSeer Crawler, NewsGator, NG-Search, nicebot, noxtrumbot, Nusearch Spider, NutchCVS, Nymesis, obot, oegp, omgilibot, OmniExplorer_Bot, OOZBOT, Orbiter, PageBitesHyperBot, Peew, polybot, Pompos, PostPost, Psbot, PycURL, Qseero, Radian6, RAMPyBot, RufusBot, SandCrawler, SBIder, ScoutJet, Scrubby, SearchSight, Seekbot, semanticdiscovery, Sensis Web Crawler, SEOChat::Bot, SeznamBot, Shim-Crawler, ShopWiki, Shoula robot, silk, Sitebot, Snappy, sogou spider, Sosospider, Speedy Spider, Sqworm, StackRambler, suggybot, SurveyBot, SynooBot, Teoma, TerrawizBot, TheSuBot, Thumbnail.CZ robot, TinEye, truwoGPS, TurnitinBot, TweetedTimes Bot, TwengaBot, updated, Urlfilebot, Vagabondo, VoilaBot, Vortex, voyager, VYU2, webcollage, Websquash.com, wf84, WoFindeIch Robot, WomlpeFactory, Xaldon_WebSpider, yacy, Yahoo! Slurp, Yahoo! Slurp China, YahooSeeker, YahooSeeker-Testing, YandexBot, YandexImages, Yasaklibot, Yeti, YodaoBot, yoogliFetchAgent, YoudaoBot, Zao, Zealbot, zspider, ZyBorg, crawler, bot, froogle, looksmart, URL_Spider_SQL, Firefly, NationalDirectory, Ask Jeeves, TECNOSEEK, InfoSeek, WebFindBot, Googlebot, Scooter, appie, WebBug, Spade, rabaz, Feedfetcher-Google, TechnoratiSnoop, Rankivabot, Mediapartners-Google, Sogou web spider, WebAlta Crawler  ';
		$general['email_message']      = 0;
		$general['pushover']           = 0;
		$general['pushover_key']       = '';
		$general['send_notification']  = array( 0, 0 );

		/*STATS DEFAULT SETTINGS*/
		$stats['save_settings']         = 1;
		$stats['stats_track']           = 1;
		$stats['logged_in_impressions'] = 1;
		$stats['logged_in_clicks']      = 1;
		$stats['impression_timer']      = 60;
		$stats['click_timer']           = 60;


		/*GEO DEFAULT SETTINGS*/
		$geo['geo_targeting']    = 2;
		$geo['maxmind_username'] = '';
		$geo['maxmind_password'] = '';


		/*ROLES DEFAULT SETTINGS*/
		$roles['save_settings']                       = 1;
		$advert_roles['edit_wd_ads_adverts']          = array( 'administrator' );
		$advert_roles['edit_others_wd_ads_adverts']   = array( 'administrator' );
		$advert_roles['edit_others_wd_ads_adverts']   = array( 'administrator' );
		$advert_roles['publish_wd_ads_adverts']       = array( 'administrator' );
		$advert_roles['delete_wd_ads_adverts']        = array( 'administrator' );
		$advert_roles['delete_others_wd_ads_adverts'] = array( 'administrator' );

		$advert_roles['assign_wd_ads_adverts']     = array( 'administrator' );
		$advert_roles['edit_stats_wd_ads_adverts'] = array( 'administrator' );


		$schedule_roles['edit_wd_ads_schedules']          = array( 'administrator' );
		$schedule_roles['edit_others_wd_ads_schedules']   = array( 'administrator' );
		$schedule_roles['edit_others_wd_ads_schedules']   = array( 'administrator' );
		$schedule_roles['publish_wd_ads_schedules']       = array( 'administrator' );
		$schedule_roles['delete_wd_ads_schedules']        = array( 'administrator' );
		$schedule_roles['delete_others_wd_ads_schedules'] = array( 'administrator' );


		update_option( WD_ADS_PLUGIN_PREFIX . '_settings_general', $general );
		update_option( WD_ADS_PLUGIN_PREFIX . '_settings_stats', $stats );
		update_option( WD_ADS_PLUGIN_PREFIX . '_settings_geo', $geo );
		update_option( WD_ADS_PLUGIN_PREFIX . '_settings_advert-roles', $advert_roles );
		update_option( WD_ADS_PLUGIN_PREFIX . '_settings_schedule-roles', $schedule_roles );

	}

	$general_settings = array();
	foreach ( $wd_ads_tabs as $key => $settings ) {
		$general_settings += is_array( get_option( WD_ADS_PLUGIN_PREFIX . '_settings_' . $key ) ) ? get_option( WD_ADS_PLUGIN_PREFIX . '_settings_' . $key ) : array();
	}


	return $general_settings;
}
