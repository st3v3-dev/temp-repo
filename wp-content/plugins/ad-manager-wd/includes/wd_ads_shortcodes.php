<?php

/**
 *  [wd_ads] shortcode
 */

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
function wd_ads_shortcode( $attr ) {
	extract( shortcode_atts( array(

		                         'advert' => null,
		                         'group'  => null

	                         ), $attr ) );


	if ( $advert != null ) {
		return wd_ads_show_single_advert( $advert );
	}
	if ( $group != null ) {

		return wd_ads_show_advert_group( $group );

	}


}

add_shortcode( WD_ADS_PLUGIN_PREFIX, WD_ADS_PLUGIN_PREFIX . '_shortcode' );
