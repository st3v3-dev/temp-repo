<?php

/**
 * Created by PhpStorm.
 * User: araqe
 * Date: 08/23/2016
 * Time: 5:14 PM
 */
class wd_ads_import {
	private $tmp_path;
	private $file_name;
	private $can_import;
	private $post_custom_fields = array(
		'_edit_lock',
		'_edit_last',
		'_thumbnail_id',
		'area_code',
		'img_phone',
		'img_tablet',
		'weight',
		'sortorder',
		'city_state',
		'placement',
		'inside_content',
		'wrapper_before',
		'wrapper_after',
		'statistics',
		'enable_responsive',
		'show_in_posts',
		'show_in_pages',
		'show_in_cats',
		'countries',
		'posts',
		'categories',
		'pages',
		'schedule',
		'show_on',
		'post_title',
	);

	function __construct( $file, $extensions ) {


		$this->file_name  = $file['name'];
		$this->tmp_path   = $file['tmp_name'];
		$this->can_import = $this->wd_ads_validate( $extensions );


	}

	private function wd_ads_validate( $extensions ) {
		$file_extension = explode( '.', $this->file_name );
		$file_extension = end( $file_extension );

		$allowed_extensions = explode( ',', $extensions );

		if ( ! in_array( $file_extension, $allowed_extensions ) ) {
			echo '<span class="wd_ads_warning">Allowed Only ' . implode( ",", $allowed_extensions ) . '</span>';

			return FALSE;
		}

		return TRUE;
	}

	public function wd_ads_importToAds() {
		if ( ! $this->can_import ) {
			return FALSE;
		}


		$file_contents = file_get_contents( $this->tmp_path );

		$file_data = json_decode( $file_contents );


		$current_user    = wp_get_current_user();
		$new_post_author = $current_user->ID;


		/*
		 * insert the post by wp_insert_post() function
		 */

		try {
			foreach ( $file_data as $advert ) {


				$args = array(

					'post_author' => $new_post_author,
					'post_title'  => $advert->post_title,
					'post_type'   => $advert->post_type,
					'post_status' => 'publish ',

				);

				$new_post_id = wp_insert_post( $args );

				foreach ( $this->post_custom_fields as $post_custom_field ) {

					if ( isset( $advert->$post_custom_field ) ) {
						update_post_meta( $new_post_id, $post_custom_field, $advert->$post_custom_field );
					}

				}


			}

			echo '<span class="wd_ads_success">Advertisements successfully imported</span>';

			return FALSE;
		} catch ( Exception  $err ) {
			echo '<span class="wd_ads_warning">Error occurred during advertisement import</span>';

		}


	}
}