<?php

/**
 *  Ad Manager WD functions
 */


function wd_ads_show_group_in_category($content)
{
	$terms_ids = get_terms('wd_ads_manage_groups', array('fields' => 'ids'));
	$post_term = wp_get_post_categories($GLOBALS['post']->ID);

	$wd_ads_group = '';
	foreach ($terms_ids as $term_id) {
		$tax_options = get_option(WD_ADS_PLUGIN_PREFIX . '_manage_groups_' . $term_id);

		$categories_to_show_in = json_decode($tax_options['categories'], true);
		$posts_to_show_in = json_decode($tax_options['posts'], true);

		$placement = $tax_options['placement'];
		$inside_content = $tax_options['inside_content'];;


		if ($categories_to_show_in == 0)
			continue;


		if($posts_to_show_in!=0 && $tax_options['show_in_posts'] != 0) {
			$continue=0;
			foreach ($posts_to_show_in as $post_to_show_id => $value) {

				if ($post_to_show_id == $GLOBALS['post']->ID) {

					$continue=1;
				}

			}
			if($continue==1  or in_array('all',$posts_to_show_in))
				continue;
		}


		//$categories_to_show_in = array_keys($categories_to_show_in);


		$check_array = array_intersect($post_term, $categories_to_show_in);


		if ($tax_options['show_in_cats'] == 1 and $GLOBALS['post']->post_type == 'post' and count($check_array) > 0 or in_array('all',$categories_to_show_in)) {

			$wd_ads_html = do_shortcode('[wd_ads group=' . $term_id . ']');
			$content = wd_ads_show_in_content($content, $placement, $wd_ads_html, $inside_content);

		}


	}


	return $content;
}

function wd_ads_show_group_in_posts($content)
{
	$terms_ids = get_terms('wd_ads_manage_groups', array('fields' => 'ids'));

	$wd_ads_group = '';
	foreach ($terms_ids as $term_id) {
		$tax_options = get_option(WD_ADS_PLUGIN_PREFIX . '_manage_groups_' . $term_id);

		$posts_to_show_in = json_decode($tax_options['posts'], true);

		$placement = $tax_options['placement'];
		$inside_content = $tax_options['inside_content'];;


		if ($posts_to_show_in == 0)
			continue;
		// $posts_to_show_in = array_keys($posts_to_show_in);


		if ($tax_options['show_in_posts'] == 1 and $GLOBALS['post']->post_type == 'post' and in_array($GLOBALS['post']->ID, $posts_to_show_in)  or ($tax_options['show_in_posts'] == 1 and $GLOBALS['post']->post_type == 'post' and in_array('all', $posts_to_show_in))) {
			$wd_ads_html = do_shortcode('[wd_ads group=' . $term_id . ']');
			$content = wd_ads_show_in_content($content, $placement, $wd_ads_html, $inside_content);

		}


	}


	return $content;
}

function wd_ads_show_group_in_pages($content)
{
	$terms_ids = get_terms('wd_ads_manage_groups', array('fields' => 'ids'));

	$wd_ads_group = '';
	foreach ($terms_ids as $term_id) {
		$tax_options = get_option(WD_ADS_PLUGIN_PREFIX . '_manage_groups_' . $term_id);

		$pages_to_show_in = json_decode($tax_options['pages'], true);
		if ($pages_to_show_in == 0)
			continue;
		// $pages_to_show_in = array_keys($pages_to_show_in);

		$placement = $tax_options['placement'];
		$inside_content = $tax_options['inside_content'];;


		if ($tax_options['show_in_pages'] == 1 and $GLOBALS['post']->post_type == 'page' and in_array($GLOBALS['post']->ID, $pages_to_show_in)  or ($tax_options['show_in_pages'] == 1 and $GLOBALS['post']->post_type == 'page' and in_array('all', $pages_to_show_in)) ) {
			$wd_ads_html = do_shortcode('[wd_ads group=' . $term_id . ']');
			$content = wd_ads_show_in_content($content, $placement, $wd_ads_html, $inside_content);

		}


	}


	return $content;
}


function wd_ads_show_advert_in_category($content)
{
	$posts_ids = get_posts(array('post_type' => WD_ADS_PLUGIN_PREFIX . '_ads', 'fields' => 'ids', 'meta_key' => 'show_in_cats', 'meta_value' => '1'));
	$wd_ads = '';
	$post_term = wp_get_post_categories($GLOBALS['post']->ID);

	foreach ($posts_ids as $post_id) {

		$categories_to_show_in = get_post_meta($post_id, 'categories', true);
		$placement = get_post_meta($post_id, 'placement', true);
		$inside_content = get_post_meta($post_id, 'inside_content', true);
		$show_in_posts = get_post_meta($post_id, 'show_in_posts', true);

		$categories_to_show_in = json_decode($categories_to_show_in, true);
		$posts_to_show_in = get_post_meta($post_id, 'posts', true);
		$posts_to_show_in = json_decode($posts_to_show_in, true);


		if ($categories_to_show_in == 0)
			continue;
		if($posts_to_show_in!=0 && $show_in_posts!=0) {
			$continue=0;
			foreach ($posts_to_show_in as $post_to_show_id => $value) {

				if ($post_to_show_id == $GLOBALS['post']->ID) {

					$continue=1;
				}

			}
			if($continue==1 or in_array('all',$posts_to_show_in))
				continue;
		}

		// $categories_to_show_in = array_keys($categories_to_show_in);

		$check_array = array_intersect($post_term, $categories_to_show_in);


		if ($GLOBALS['post']->post_type == 'post' and count($check_array) > 0 ) {
			$wd_ads_html = do_shortcode('[wd_ads advert=' . $post_id . ']');
			$content = wd_ads_show_in_content($content, $placement, $wd_ads_html, $inside_content);

		}


	}


	return $content;
}


function wd_ads_show_in_posts($content)
{


	$posts_ids = get_posts(array('post_type' => WD_ADS_PLUGIN_PREFIX . '_ads', 'fields' => 'ids', 'meta_key' => 'show_in_posts', 'meta_value' => '1'));
	$wd_ads = '';

	foreach ($posts_ids as $post_id) {

		$posts_to_show_in = get_post_meta($post_id, 'posts', true);
		$placement = get_post_meta($post_id, 'placement', true);
		$inside_content = get_post_meta($post_id, 'inside_content', true);

		$posts_to_show_in = json_decode($posts_to_show_in, true);


		if ($posts_to_show_in == 0)
			continue;



		// $posts_to_show_in = $posts_to_show_in;

		if ($GLOBALS['post']->post_type == 'post' and in_array($GLOBALS['post']->ID, $posts_to_show_in) or ($GLOBALS['post']->post_type == 'post' and in_array('all',$posts_to_show_in))) {
			$wd_ads_html = do_shortcode('[wd_ads advert=' . $post_id . ']');
			$content = wd_ads_show_in_content($content, $placement, $wd_ads_html, $inside_content);

		}


	}


	return $content;
}


function wd_ads_show_in_pages($content)
{

	$pages_ids = get_posts(array('post_type' => WD_ADS_PLUGIN_PREFIX . '_ads', 'fields' => 'ids', 'meta_key' => 'show_in_pages', 'meta_value' => '1'));
	$wd_ads = '';

	foreach ($pages_ids as $page_id) {
		$pages_to_show_in = get_post_meta($page_id, 'pages', true);
		$placement = get_post_meta($page_id, 'placement', true);
		$inside_content = get_post_meta($page_id, 'inside_content', true);

		$pages_to_show_in = json_decode($pages_to_show_in, true);


		if ($pages_to_show_in == 0)
			continue;

		//$pages_to_show_in = array_keys($pages_to_show_in);


		if ($GLOBALS['post']->post_type == 'page' and in_array($GLOBALS['post']->ID, $pages_to_show_in) or ($GLOBALS['post']->post_type == 'page' and in_array('all', $pages_to_show_in)) ) {
			$wd_ads_html = do_shortcode('[wd_ads advert=' . $page_id . ']');
			$content = wd_ads_show_in_content($content, $placement, $wd_ads_html, $inside_content);
		}

	}


	return $content;
}


function wd_ads_show_in_content( $content, $placement, $html, $place = 0 ) {

	switch ( $placement ) {
		case 'before':
			return $html . $content;
			break;

		case 'after':
			return $content . $html;
			break;

		case 'before_after':
			return $html . $content . $html;
			break;

		case 'inside':
			$paragraphs = explode( '</p>', $content );
			$par_num    = count( $paragraphs ) - 1;

			$content_modified = '';

			if ( $par_num <= $place ) {
				return $content . $html;
			}


			foreach ( $paragraphs as $key => $paragraph ) {
				if ( $key == ( $place - 1 ) ) {
					$paragraph .= $html;

				}
				$content_modified .= $paragraph . '</p>';
			}


			return $content_modified;


			break;
	}


}


function wd_ads_show_single_advert( $id, $from_group = 0, $margin = 0 ) {


	$area_code = get_post_meta( $id, 'area_code', TRUE );


	$statistics     = get_post_meta( $id, 'statistics', TRUE );
	$published      = get_post_meta( $id, 'published', TRUE );
	$responsive     = get_post_meta( $id, 'responsive', TRUE );
	$sortorder      = get_post_meta( $id, 'sortorder', TRUE );
	$city_state     = get_post_meta( $id, 'city_state', TRUE );
	$countries_meta = get_post_meta( $id, 'countries', TRUE );
	$wrapper_before = get_post_meta( $id, 'wrapper_before', TRUE );
	$wrapper_after  = get_post_meta( $id, 'wrapper_after', TRUE );

	$clicks            = get_post_meta( $id, 'clicks', TRUE );
	$impressions       = get_post_meta( $id, 'impressions', TRUE );
	$enable_responsive = get_post_meta( $id, 'enable_responsive', TRUE );


	$schedules = get_post_meta( $id, 'schedule', TRUE );
	$schedules = json_decode( $schedules, TRUE );
	if ( $schedules != 0 ) {
		$schedules = array_keys( $schedules );
	} else {
		$schedules = array();
	}



	$now = time();

	$wd_ads_validate = FALSE;


	$wd_ads_options = wd_ads_get_settings();


	foreach ( $schedules as $schedule ) {

		$schedule_start_date_meta = get_post_meta( $schedule, 'start_date', TRUE );
		$schedule_end_date_meta   = get_post_meta( $schedule, 'end_date', TRUE );
		$schedule_weekdays        = get_post_meta( $schedule, 'weekdays', TRUE );
		$schedule_weekdays        = json_decode( $schedule_weekdays, TRUE );
		if ( $schedule_weekdays != 0 ) {
			$schedule_weekdays = array_keys( $schedule_weekdays );
		}

		$daily_start_hour = get_post_meta( $schedule, 'daily_start_hour', TRUE );
		$daily_start_min  = get_post_meta( $schedule, 'daily_start_min', TRUE );

		$daily_end_hour = get_post_meta( $schedule, 'daily_end_hour', TRUE );
		$daily_end_min  = get_post_meta( $schedule, 'daily_end_min', TRUE );


		$max_clicks = get_post_meta( $schedule, 'max_clicks', TRUE );
		if ( $max_clicks == 0 ) {
			$max_clicks = $clicks + 1;
		}
		$max_impressions = get_post_meta( $schedule, 'max_impressions', TRUE );
		if ( $max_impressions == 0 ) {
			$max_impressions = $impressions + 1;
		}


		$daily_start_time = mktime( (int) $daily_start_hour, (int) $daily_start_min, 0, date( 'n' ), date( 'd' ), date( 'Y' ) );
		$daily_end_time   = mktime( (int) $daily_end_hour, (int) $daily_end_min, 0, date( 'n' ), date( 'd' ), date( 'Y' ) );

		if ( (int) $daily_end_min == 0 AND (int) $daily_end_hour == 0 AND (int) $daily_start_min == 0 AND (int) $daily_start_hour == 0 ) {
			$daily_start_time = $now - 1;
			$daily_end_time   = $now + 1;
		}


		if ( $schedule_start_date_meta <= $now and $schedule_end_date_meta >= $now AND in_array( date( 'N', $now ), $schedule_weekdays ) and $daily_start_time < $now and $daily_end_time > $now and $max_clicks > $clicks and $max_impressions > $impressions ) {
			$wd_ads_validate = TRUE;
			break;
		}


	}

	if ( $from_group == 0 ) {
		if ( ! wd_ads_filter_device( $id ) ) {
			return FALSE;
		}
	}


	/*if ( $from_group == 0 AND $wd_ads_options['geo_targeting'] > 1 ) {
		if ( ! wd_ads_filter_post_ids_geo( $id, 'single' ) ) {
			return FALSE;
		}
	}*/


	if ( ! $wd_ads_validate and count( $schedules ) != 0 ) {

		/* if ($from_group == 1)
				 return show_advert_group($group_id);
		 else*/
		return FALSE;
	}


	$banner_asset = wp_get_attachment_url( get_post_thumbnail_id( $id ) );


	if ( $enable_responsive == 1 ) {
		$banner_phone  = get_post_meta( $id, 'img_phone', TRUE );
		$banner_tablet = get_post_meta( $id, 'img_tablet', TRUE );
		if ( wd_ads::$device == "smartphone" && $banner_phone != '' ) {
			$banner_asset = $banner_phone;
		}

		if ( wd_ads::$device == "tablet" && $banner_tablet != '' ) {
			$banner_asset = $banner_tablet;
		}
	}

	$advert_title = get_the_title( $id );

	$area_code = str_replace( '%featured_image%', $banner_asset, $area_code );
	$area_code = str_replace( '%title%', $advert_title, $area_code );
	$tracking  = '';
	if ( $statistics == 1 ) {

		///////////////INTERNAL TRACKER
		if ( $wd_ads_options['stats_track'] == 1 ) {

			$tracking = "wd_ads_tracking=" . $id . " ";
		}
		///////////////Google Analytics
		if ( $wd_ads_options['stats_track'] == 3 ) {
			$tracking = "wd_ads_tracking_analytics=" . $advert_title . " ";

		}
		///////////////Piwik Analytics
		if ( $wd_ads_options['stats_track'] == 2 ) {
			$tracking = "wd_ads_tracking_piwik=" . $advert_title . " ";

		}


	}


	$result = $wrapper_before;
	$result .= '<div id="wd_ads" style="margin: ' . $margin . '">';
	$result .= '<div class="wd_ads" ' . $tracking . '>';
	$result .= $area_code;
	$result .= '</div></div>';
	$result .= $wrapper_after;


	return $result;

}


function wd_ads_show_advert_group( $id ) {

	$wd_ads_options = wd_ads_get_settings();
	//get all posts IDS in taxonomy
	$posts_ids = wd_ads_get_post_ids_in_taxonomy( $id );

	/*if ( $wd_ads_options['geo_targeting'] > 1 ) {
		$posts_ids = wd_ads_filter_post_ids_geo( $posts_ids );
	}*/


	$posts_ids     = wd_ads_filter_device( $posts_ids );
	$group_options = get_option( WD_ADS_PLUGIN_PREFIX . '_manage_groups_' . $id );

	/*
	Group_Mode
	1=default;
	2=dynamic;
	3=block
	*/
	$group_mode         = $group_options['group_mode'];
	$group_block_width  = $group_options['width'];
	$group_block_height = $group_options['height'];
	$group_refresh_time = $group_options['auto_refresh'];
	$group_ad_margin    = $group_options['ad_margin'];
	$group_align        = $group_options['group_align'];
	$group_rows         = $group_options['rows'];
	$group_columns      = $group_options['columns'];


	$posts_count = count( $posts_ids ) - 1;

	$result = '<div class="wd_ads_group" wd_ads_group="' . $id . '">';


	if ( $group_mode == 3 ) {
		$result .= wd_ads_show_advert_group_block( $posts_ids, $group_rows, $group_columns, $group_block_width, $group_block_height, $group_ad_margin );
	}

	if ( $group_mode == 2 ) {
		$result .= wd_ads_show_advert_group_dynamic( $posts_ids, $group_refresh_time, $id, $group_ad_margin );
	}

	if ( $group_mode == 1 ) {
		$result .= wd_ads_show_advert_group_default( $posts_ids, $group_ad_margin );
	}


	$result .= "</div>";

	return $result;

}

function wd_ads_show_advert_group_dynamic( $ids, $group_refresh_time, $group_id, $group_ad_margin ) {
	$random_advert_key = wd_ads_get_advert_by_weight( $ids );
	if ( ! isset( $ids[ $random_advert_key ] ) ) {
		return FALSE;
	}
	$dynamic_group = '<div wd_ads_dynamic="' . $group_id . ',' . $group_refresh_time . '" >';
	$dynamic_group .= wd_ads_show_single_advert( $ids[ $random_advert_key ], 1, $group_ad_margin );
	$dynamic_group .= '</div>';

	return $dynamic_group;

}

function wd_ads_show_advert_group_default( $ids, $group_ad_margin ) {

	$random_advert_key = wd_ads_get_advert_by_weight( $ids );
	if ( ! isset( $ids[ $random_advert_key ] ) ) {
		return FALSE;
	}
	$def_group = wd_ads_show_single_advert( $ids[ $random_advert_key ], 1, $group_ad_margin );

	return $def_group;

}


function wd_ads_show_advert_group_block( $ids, $group_rows, $group_columns, $group_block_width, $group_block_height, $group_ad_margin ) {
	$block = '';
	$key   = 0;

	for ( $i = 0; $i < $group_rows; $i ++ ) {
		if ( ! isset( $ids[ $key ] ) ) {
			break;
		}
		$block .= "<div class='wd_ads_row' >";

		for ( $j = 0; $j < $group_columns; $j ++ ) {
			if ( ! isset( $ids[ $key ] ) ) {
				break;
			}
			$block .= '<div class="wd_ads_col" style="width:' . $group_block_width . 'px; height:' . $group_block_height . 'px; ">';
			$block .= wd_ads_show_single_advert( $ids[ $key ], 1, $group_ad_margin );
			$block .= '</div>';
			$key ++;
		}

		$block .= "</div>";

	}

	return $block;
}


function wd_ads_get_advert_by_weight( $ads ) {
	$weight_array = array();
	foreach ( $ads as $ad ) {
		$weight_array[] = get_post_meta( $ad, 'weight', TRUE );

	}

	$sum_of_weight = array_sum( $weight_array ) - 1;

	if ( $sum_of_weight < 0 ) {
		$sum_of_weight = 0;
	}

	$rand = mt_rand( 0, $sum_of_weight );

	foreach ( $weight_array as $key => $weight ) {
		if ( $rand < $weight ) {

			return $key;

		}
		$rand -= $weight;
	}

}

function wd_ads_get_post_ids_in_taxonomy( $tax_id ) {
	$posts_ids = get_posts( array(
		                        'post_type'   => WD_ADS_PLUGIN_PREFIX . '_ads',
		                        'numberposts' => - 1, // get all posts.
		                        'tax_query'   => array(
			                        array(
				                        'taxonomy' => WD_ADS_PLUGIN_PREFIX . '_manage_groups',
				                        'field'    => 'id',
				                        'terms'    => $tax_id,
			                        ),
		                        ),
		                        'fields'      => 'ids', // Only get post IDs
		                        'meta_key'    => 'sortorder',
		                        'orderby'     => 'meta_value_num',


	                        ) );


	return $posts_ids;

}


function wd_ads_filter_post_ids_geo( $ids, $type = "group" ) {


	$geo_array = $_SESSION['wd-ads-geo'];

	if ( $type == 'group' ) {
		$filtered_ids = array();


		foreach ( $ids as $key => $id ) {
			$geoLocations = get_post_meta( $id, 'countries', TRUE );
			$city_state   = get_post_meta( $id, 'city_state', TRUE );
			$city_state   = explode( ',', $city_state );

			$geoLocations = json_decode( $geoLocations, TRUE );
			if ( $geoLocations == 0 ) {
				$geoLocations = array();
			}

			$geoLocations = array_keys( $geoLocations );

			if ( count( array_intersect( $city_state, $geo_array ) ) == 0 ) {
				unset( $ids[ $key ] );
			}

			if ( ! in_array( $geo_array['isoCode'], $geoLocations ) ) {
				unset( $ids[ $key ] );
			}

		}

		return array_values( $ids );
	}
	if ( $type == 'single' ) {
		$id           = $ids;
		$geoLocations = get_post_meta( $id, 'countries', TRUE );
		$geoLocations = json_decode( $geoLocations, TRUE );
		if ( $geoLocations == 0 ) {
			$geoLocations = array();
		}

		$geoLocations = array_keys( $geoLocations );


		if ( in_array( $geo_array['isoCode'], $geoLocations ) ) {
			return TRUE;
		}

		return FALSE;

	}

}


function wd_ads_isMobile() {
	return preg_match( "/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"] );
}


function wd_ads_filter_device( $ids ) {


	if ( is_array( $ids ) ) {
		foreach ( $ids as $key => $id ) {

			$show_on = get_post_meta( $id, 'show_on', TRUE );
			$show_on = json_decode( $show_on, TRUE );


			if ( $show_on ) {

				if ( ! in_array( wd_ads::$device, $show_on ) ) {
					unset( $ids[ $key ] );
				}
			}

		}

		return array_values( $ids );
	} else {

		$id      = $ids;
		$show_on = get_post_meta( $id, 'show_on', TRUE );
		$show_on = json_decode( $show_on, TRUE );

		if ( $show_on ) {

			if ( ! in_array( wd_ads::$device, $show_on ) ) {

				return FALSE;
			}

		}

		return TRUE;
	}


}
 
 

 