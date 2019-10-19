<?php

class ad_wds_Cpt {
	const AD_POST_TYPE = 'wd_ads';
	protected static $instance = null;

	private function __construct() {
		$this->tax = WD_ADS_PLUGIN_PREFIX . '_manage_groups';

		add_action( 'init', array( $this, WD_ADS_PLUGIN_PREFIX . '_setup_cpt' ) );

		add_action( 'init', array( $this, WD_ADS_PLUGIN_PREFIX . '_groups' ), 0 );
		add_action( 'init', array( $this, WD_ADS_PLUGIN_PREFIX . '_add_capabilities' ) );
		add_action( WD_ADS_PLUGIN_PREFIX . '_manage_groups_edit_form_fields', array(
			$this,
			WD_ADS_PLUGIN_PREFIX . '_edit_meta_field'
		), 10, 2 );
		add_action( 'edited_' . WD_ADS_PLUGIN_PREFIX . '_manage_groups', array(
			$this,
			WD_ADS_PLUGIN_PREFIX . '_save_manage_group_taxonomy_custom_meta'
		), 10, 2 );
		add_action( 'create_' . WD_ADS_PLUGIN_PREFIX . '_manage_groups', array(
			$this,
			WD_ADS_PLUGIN_PREFIX . '_save_manage_group_taxonomy_custom_meta'
		), 10, 2 );
		add_action( WD_ADS_PLUGIN_PREFIX . '_manage_groups_add_form_fields', array(
			$this,
			WD_ADS_PLUGIN_PREFIX . '_add_new_meta_field'
		), 10, 2 );
		add_action( 'add_meta_boxes', array( $this, WD_ADS_PLUGIN_PREFIX . '_ads_meta' ) );
		add_action( 'post_updated', array( $this, WD_ADS_PLUGIN_PREFIX . '_save_ad' ) );
		add_filter( 'the_content', 'wd_ads_show_in_posts' );
		add_filter( 'the_content', 'wd_ads_show_in_pages' );
		add_filter( 'the_content', 'wd_ads_show_group_in_posts' );
		add_filter( 'the_content', 'wd_ads_show_group_in_pages' );
		add_filter( 'the_content', 'wd_ads_show_advert_in_category' );
		add_filter( 'the_content', 'wd_ads_show_group_in_category' );

		add_filter( 'manage_' . WD_ADS_PLUGIN_PREFIX . '_ads_posts_columns', array( $this, 'wd_ads_cpt_columns_headers' ) );
		add_filter( 'manage_' . WD_ADS_PLUGIN_PREFIX . '_ads_posts_custom_column', array(
			$this,
			'wd_ads_cpt_columns'
		), 10, 2 );

		add_filter( 'manage_' . WD_ADS_PLUGIN_PREFIX . '_schedules_posts_columns', array(
			$this,
			'wd_ads_schedules_cpt_columns_headers'
		) );
		add_filter( 'manage_' . WD_ADS_PLUGIN_PREFIX . '_schedules_posts_custom_column', array(
			$this,
			'wd_ads_schedules_cpt_columns'
		), 10, 3 );

		add_action( 'wp_ajax_wd_ads_count_impressions', array( $this, 'wd_ads_count_impressions' ) );
		add_action( 'wp_ajax_nopriv_wd_ads_count_impressions', array( $this, 'wd_ads_count_impressions' ) );

		add_action( 'wp_ajax_wd_ads_count_clicks', array( $this, 'wd_ads_count_clicks' ) );
		add_action( 'wp_ajax_nopriv_wd_ads_count_clicks', array( $this, 'wd_ads_count_clicks' ) );

		add_action( 'wp_ajax_wd_ads_change_advert', array( $this, 'wd_ads_change_advert' ) );
		add_action( 'wp_ajax_nopriv_wd_ads_change_advert', array( $this, 'wd_ads_change_advert' ) );

		//add_action('wp_head', array($this,'ad_block_detect'));
		add_action( 'wp_footer', array( $this, 'wd_ads_ad_block_detect' ) );

		add_action( 'transition_post_status', array( $this, 'wd_ads_push_notifications' ), 10, 3 );

		add_action( 'admin_footer-edit.php', array( $this, 'wd_ads_bulk_admin_footer' ) );
		add_action( 'load-edit.php', array( $this, 'wd_ads_bulk_action' ) );
		add_action( 'admin_notices', array( $this, 'wd_ads_bulk_admin_notices' ) );
		add_action( 'restrict_manage_posts', array( $this, 'wd_ads_post_filters' ) );
		add_filter( 'parse_query', array( $this, 'wd_ads_posts_filter' ) );
		add_filter( 'manage_edit-wd_ads_manage_groups_columns', array( $this, 'wd_ads_manage_my_category_columns' ) );
		add_action( 'manage_wd_ads_manage_groups_custom_column', array(
			$this,
			'wd_ads_manage_category_custom_fields'
		), 10, 3 );

	}


	function wd_ads_manage_my_category_columns( $columns ) {
		if ( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'wd_ads_manage_groups' ) {
			return $columns;
		}


		$columns['posts']           = 'Ads';
		$columns['group_shortcode'] = 'Shortcode';

		return $columns;
	}


	function wd_ads_manage_category_custom_fields( $deprecated, $column_name, $term_id ) {

		if ( $column_name == 'group_shortcode' ) {
			$t_id = $term_id;

			echo '<code>[wd_ads group=' . $term_id . ']</code>';

		}
	}


	function wd_ads_post_filters() {
		$type = 'post';
		if ( isset( $_GET['post_type'] ) ) {
			$type = $_GET['post_type'];
		}


		//only add filter to post type you want
		if ( 'wd_ads_ads' == $type ) {
			//change this to the list of values you want to show
			//in 'label' => 'value' format
			//$wd_ads_terms = get_terms( WD_ADS_PLUGIN_PREFIX . '_manage_groups'  , array('hide_empty' => false));
			$wd_ads_schedules = get_posts( array( 'post_type' => 'wd_ads_schedules', 'numberposts' => - 1, ) );

			$wd_ads_groups = get_terms( WD_ADS_PLUGIN_PREFIX . '_manage_groups', array( 'hide_empty' => false ) );

			?>

        <select name="wd_ads_group_filter">
            <option value=""><?php _e( 'All Groups ', '' ); ?></option>
					<?php
					$current_v = isset( $_GET['wd_ads_group_filter'] ) ? $_GET['wd_ads_group_filter'] : '';
					foreach ( $wd_ads_groups as $label => $wd_ads_group ) {
						printf( '<option value="%s"%s>%s</option>', $wd_ads_group->term_id, $wd_ads_group->term_id == $current_v ? ' selected="selected"' : '', $wd_ads_group->name );
					}
					?>
        </select>


        <select name="wd_ads_schedule_filter">
            <option value=""><?php _e( 'All Schedules ', '' ); ?></option>
					<?php
					$current_v = isset( $_GET['wd_ads_schedule_filter'] ) ? $_GET['wd_ads_schedule_filter'] : '';
					foreach ( $wd_ads_schedules as $label => $wd_ads_schedule ) {
						printf( '<option value="%s"%s>%s</option>', $wd_ads_schedule->ID, $wd_ads_schedule->ID == $current_v ? ' selected="selected"' : '', $wd_ads_schedule->post_title );
					}
					?>
        </select>

        <select name="wd_ads_expired">
            <option value=""><?php _e( 'All Ads ', '' ); ?></option>
					<?php
					$current_v = isset( $_GET['wd_ads_expired'] ) ? $_GET['wd_ads_expired'] : '';
					?>
            <option value="active" <?php if ( $current_v == 'active' )
							echo 'selected' ?>>Active
            </option>

            <option value="expired" <?php if ( $current_v == 'expired' )
							echo 'selected' ?> >Expired
            </option>
            <option value="soon_expired" <?php if ( $current_v == 'soon_expired' )
							echo 'selected' ?>>Soon to Expire
            </option>
        </select>


			<?php

		}

		if ( 'wd_ads_schedules' == $type ) {
			?>
        <select name="wd_ads_expired">
            <option value=""><?php _e( 'All Schedules ', '' ); ?></option>
					<?php
					$current_v = isset( $_GET['wd_ads_expired'] ) ? $_GET['wd_ads_expired'] : '';
					?>
            <option value="expired" <?php if ( $current_v == 'expired' )
							echo 'selected' ?> >Expired
            </option>
            <option value="soon_expired" <?php if ( $current_v == 'soon_expired' )
							echo 'selected' ?>>Soon Expired
            </option>
        </select>


			<?php

		}


	}


	function wd_ads_posts_filter( $query ) {


		global $pagenow;
		$type = 'post';
		if ( isset( $_GET['post_type'] ) ) {
			$type = $_GET['post_type'];
		}
		$modifications['meta_query'] = array();

		///////////*SCHEDULES FILTER-*
		if ( 'wd_ads_ads' == $type && is_admin() && $pagenow == 'edit.php' && isset( $_GET['wd_ads_schedule_filter'] ) && $_GET['wd_ads_schedule_filter'] != '' && $query->is_main_query() ) {
			$modifications['meta_query'][] = array(
				'key'     => 'schedule',
				'value'   => $_GET['wd_ads_schedule_filter'],
				'compare' => 'LIKE'
			);


			$query->query_vars = array_merge( $query->query_vars, $modifications );


		}
///////////*EXPIRED/EXPIRED_SOON FILTER */
		if ( 'wd_ads_ads' == $type && is_admin() && $pagenow == 'edit.php' && isset( $_GET['wd_ads_expired'] ) && $_GET['wd_ads_expired'] != '' && $query->is_main_query() ) {

			if ( $_GET['wd_ads_expired'] == 'expired' ) {
				$date = strtotime( date( 'Y-m-d H:i:s' ) );

				$meta_query = array( array( 'key' => 'end_date', 'value' => $date, 'compare' => '>', ) );

			} elseif ( $_GET['wd_ads_expired'] == 'soon_expired' ) {
				$date_now   = strtotime( date( 'Y-m-d H:i:s' ) );
				$date       = strtotime( date( 'Y-m-d H:i:s' ) ) + ( 24 * 60 * 60 * 7 );
				$meta_query = array(

					array( 'key' => 'end_date', 'value' => array( $date_now, $date ), 'compare' => 'NOT BETWEEN', ),


				);
			} elseif ( $_GET['wd_ads_expired'] == 'active' ) {

				$date       = strtotime( date( 'Y-m-d H:i:s' ) );
				$meta_query = array(

					array( 'key' => 'end_date', 'value' => $date, 'compare' => '<', ),


				);
			}
			$wd_ads_schedules_exp = get_posts( array(
				                                   'post_type'   => 'wd_ads_schedules',
				                                   'numberposts' => - 1,
				                                   'meta_query'  => $meta_query,

			                                   ) );


			$schedules_array = array();


			$schedules_array['relation'] = 'AND';

			foreach ( $wd_ads_schedules_exp as $wd_ads_schedule_exp ) {

				$schedules_array[] = array(
					'key'     => 'schedule',
					'value'   => $wd_ads_schedule_exp->ID,
					'compare' => 'NOT LIKE',
				);


			}

			$schedules_array[] = array( 'key' => 'schedule', 'value' => '0', 'compare' => '!=', );


			$modifications['meta_query'][] = $schedules_array;


			$query->query_vars = array_merge( $query->query_vars, $modifications );


		}


////////* GROUPS FILTER */
		if ( 'wd_ads_ads' == $type && is_admin() && $pagenow == 'edit.php' && isset( $_GET['wd_ads_group_filter'] ) && $_GET['wd_ads_group_filter'] != '' && $query->is_main_query() ) {
			$modifications['tax_query'][] = array(
				'taxonomy' => WD_ADS_PLUGIN_PREFIX . '_manage_groups',
				'field'    => 'term_id',
				'terms'    => $_GET['wd_ads_group_filter']
			);


			$query->query_vars = array_merge( $query->query_vars, $modifications );
		}


		////*SCHEDULES FILTERS */
		if ( 'wd_ads_schedules' == $type && is_admin() && $pagenow == 'edit.php' && isset( $_GET['wd_ads_expired'] ) && $_GET['wd_ads_expired'] != '' && $query->is_main_query() ) {

			if ( $_GET['wd_ads_expired'] == 'expired' ) {
				$date = strtotime( date( 'Y-m-d H:i:s' ) );

				$meta_query = array( array( 'key' => 'end_date', 'value' => $date, 'compare' => '<', ) );

			} else {
				$date_now   = strtotime( date( 'Y-m-d H:i:s' ) );
				$date       = strtotime( date( 'Y-m-d H:i:s' ) ) + ( 24 * 60 * 60 * 7 );
				$meta_query = array(

					array( 'key' => 'end_date', 'value' => array( $date_now, $date ), 'compare' => 'BETWEEN', ),


				);
			}

			$modifications['meta_query'] = $meta_query;


			$query->query_vars = array_merge( $query->query_vars, $modifications );


		}


	}


	function wd_ads_bulk_admin_footer() {

		global $post_type;

		if ( $post_type == 'wd_ads_ads' ) {
			?>
        <script type="text/javascript">
          jQuery(document).ready(function () {
            jQuery('<option>').val('duplicate').text('<?php _e( 'Duplicate' )?>').appendTo("select[name='action']");
            jQuery('<option>').val('deactivate').text('<?php _e( 'Deactivate' )?>').appendTo("select[name='action']");
            jQuery('<option>').val('reset_stats').text('<?php _e( 'Reset stats' )?>').appendTo("select[name='action']");
            jQuery('<option>').val('export').text('<?php _e( 'Export to JSON' )?>').appendTo("select[name='action']");
            jQuery('<option>').val('').text('<?php _e( '--Renew--' )?>').attr('disabled', 'disabled').appendTo("select[name='action']");
            jQuery('<option>').val('renew_year').text('<?php _e( 'For 1 year' )?>').appendTo("select[name='action']");
            jQuery('<option>').val('renew_180').text('<?php _e( 'For 180 days' )?>').appendTo("select[name='action']");
            jQuery('<option>').val('renew_30').text('<?php _e( 'For 30 days' )?>').appendTo("select[name='action']");
            jQuery('<option>').val('renew_7').text('<?php _e( 'For 7 days' )?>').appendTo("select[name='action']");
          });
        </script>
			<?php
		}
	}


	function wd_ads_bulk_action() {
		global $wpdb;
		$wp_list_table = _get_list_table( 'WP_Posts_List_Table' );
		$action        = $wp_list_table->current_action();

		if ( isset( $_GET['post'] ) ) {
			$post_ids = $_GET['post'];
		} else {
			$post_ids = array();
		}


		switch ( $action ) {

			case 'duplicate':
				foreach ( $post_ids as $post_id ) {
					$post = get_post( $post_id );

					$current_user    = wp_get_current_user();
					$new_post_author = $current_user->ID;
					$args            = array(
						'comment_status' => $post->comment_status,
						'ping_status'    => $post->ping_status,
						'post_author'    => $new_post_author,
						'post_content'   => $post->post_content,
						'post_excerpt'   => $post->post_excerpt,
						'post_name'      => $post->post_name,
						'post_parent'    => $post->post_parent,
						'post_password'  => $post->post_password,
						'post_status'    => 'draft',
						'post_title'     => $post->post_title . ' duplicate',
						'post_type'      => $post->post_type,
						'to_ping'        => $post->to_ping,
						'menu_order'     => $post->menu_order,
						'post_type'      => $post->post_type
					);

					/*
					 * insert the post by wp_insert_post() function
					 */
					$new_post_id = wp_insert_post( $args );


					$taxonomies = get_object_taxonomies( $post->post_type );
					foreach ( $taxonomies as $taxonomy ) {
						$post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'slugs' ) );
						wp_set_object_terms( $new_post_id, $post_terms, $taxonomy, false );
					}


					$post_meta_infos = $wpdb->get_results( "SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id" );
					if ( count( $post_meta_infos ) != 0 ) {
						$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
						foreach ( $post_meta_infos as $meta_info ) {
							$meta_key        = $meta_info->meta_key;
							$meta_value      = addslashes( $meta_info->meta_value );
							$sql_query_sel[] = "SELECT $new_post_id, '$meta_key', '$meta_value'";
						}
						$sql_query .= implode( " UNION ALL ", $sql_query_sel );
						$wpdb->query( $sql_query );
					}

					wp_redirect( admin_url( 'edit.php?post_type=wd_ads_ads' ) );
				}

				break;


			case 'renew_year':
			case 'renew_180':
			case 'renew_30':
			case 'renew_7':

				if ( $action == 'renew_year' ) {
					$days = 366;
				}

				if ( $action == 'renew_180' ) {
					$days = 180;
				}

				if ( $action == 'renew_30' ) {
					$days = 30;
				}

				if ( $action == 'renew_7' ) {
					$days = 7;
				}
				$current_user    = wp_get_current_user();
				$new_post_author = $current_user->ID;

				foreach ( $post_ids as $post_id ) {
					$post = get_post( $post_id );

					$args = array(
						'comment_status' => 'closed ',
						'ping_status'    => 'closed ',
						'post_author'    => $new_post_author,
						'post_content'   => '',
						'post_excerpt'   => '',
						'post_name'      => 'Schedule for ' . $post->post_title,
						'post_parent'    => 0,
						'post_password'  => '',
						'post_status'    => 'publish ',
						'post_title'     => 'Schedule for ' . $post->post_title,
						'post_type'      => 'wd_ads_schedules',
						'to_ping'        => '',
						'menu_order'     => 0

					);

					/*
					 * insert the post by wp_insert_post() function
					 */
					$new_post_id = wp_insert_post( $args );

					$start_date = strtotime( date( 'Y-m-d H:i:s' ) );
					$end_date   = strtotime( date( 'Y-m-d H:i:s' ) ) + 86400 * $days;
					update_post_meta( $new_post_id, 'start_date', $start_date );
					update_post_meta( $new_post_id, 'end_date', $end_date );
					update_post_meta( $new_post_id, 'weekdays', '{"1":"1","2":"1","3":"1","4":"1","5":"1","6":"1","7":"1"}' );

					$schedules_array = array();
					$schedules       = get_post_meta( $post_id, 'schedule', true );
					if ( $schedules != 0 ) {
						$schedules_array                 = json_decode( $schedules, true );
						$schedules_array[ $new_post_id ] = 1;
					} else {
						$schedules_array[ $new_post_id ] = 1;
					}

					update_post_meta( $post_id, 'schedule', json_encode( $schedules_array ) );


				}
				break;

			case 'reset_stats':

				foreach ( $post_ids as $post_id ) {

					update_post_meta( $post_id, 'impressions', 0 );
					update_post_meta( $post_id, 'clicks', 0 );
					update_post_meta( $post_id, 'impressions_by_date', '{}' );
					update_post_meta( $post_id, 'clicks_by_date', '{}' );
				}
				break;


			case 'export':
				$export_array = array();

				foreach ( $post_ids as $post_id ) {
					$post            = get_post( $post_id );
					$exporting_data  = new stdClass();
					$post_meta_infos = $wpdb->get_results( "SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id" );
					if ( count( $post_meta_infos ) != 0 ) {

						foreach ( $post_meta_infos as $meta_info ) {
							$meta_key   = $meta_info->meta_key;
							$meta_value = addslashes( $meta_info->meta_value );

							$exporting_data->$meta_key = $meta_value;
						}

					}

					$exporting_data->post_title = $post->post_title;
					$exporting_data->post_type  = $post->post_type;
					$export_array[]             = $exporting_data;

				}

				$fp = fopen( 'wd_ads_export_' . date( 'Y-m-d H:i' ) . '.json', 'w' );
				fwrite( $fp, wp_json_encode( $export_array ) );
				fclose( $fp );

				$file = 'wd_ads_export_' . date( 'Y-m-d H:i' ) . '.json';

				if ( file_exists( $file ) ) {
					header( 'Content-Description: File Transfer' );
					header( 'Content-Type: application/octet-stream' );
					header( 'Content-Disposition: attachment; filename="' . basename( $file ) . '"' );
					header( 'Expires: 0' );
					header( 'Cache-Control: must-revalidate' );
					header( 'Pragma: public' );
					header( 'Content-Length: ' . filesize( $file ) );
					readfile( $file );
					unlink( $file );
					exit;
				}


				break;

			default:
				return;
		}


	}


	function wd_ads_bulk_admin_notices() {

		global $post_type, $pagenow;

		if ( $pagenow == 'edit.php' && $post_type == 'wd_ads_ads' && isset( $_REQUEST['exported'] ) && (int) $_REQUEST['exported'] ) {
			$message = sprintf( _n( 'Post exported.', '%s posts exported.', $_REQUEST['exported'] ), number_format_i18n( $_REQUEST['exported'] ) );
			echo "<div class='updated'><p>{$message}</p></div>";
		}
	}

	function wd_ads_push_notifications( $new_status, $old_status, $post ) {
		$wd_ads_options = wd_ads_get_settings();


		if ( ! isset( $wd_ads_options['send_notification'] ) ) {
			$wd_ads_options['send_notification'] = array();
		}


		if ( ( 'publish' == $new_status && 'publish' !== $old_status ) && 'wd_ads_ads' == $post->post_type && ! is_super_admin() ) {
			$message = 'published post_id=' . $post->ID;
			if ( in_array( 2, $wd_ads_options['send_notification'] ) ) {
				if ( isset( $wd_ads_options['email_message'] ) ) {
					wd_ads_send_email_notification( $wd_ads_options['email_address'], $message );
				}

				if ( isset( $wd_ads_options['pushover'] ) ) {
					wd_ads_send_pushover_notification( $wd_ads_options['pushover_key'], $wd_ads_options['pushover_token'], $message );
				}


			}
		}

		if ( ( 'pending' == $new_status && 'pending' !== $old_status ) && 'wd_ads_ads' == $post->post_type && ! is_super_admin() ) {

			$message = 'post_id=' . $post->ID;
			if ( in_array( 1, $wd_ads_options['send_notification'] ) ) {


				if ( isset( $wd_ads_options['email_message'] ) ) {
					wd_ads_send_email_notification( $wd_ads_options['email_address'], $message );
				}

				if ( isset( $wd_ads_options['pushover'] ) ) {
					wd_ads_send_pushover_notification( $wd_ads_options['pushover_key'], $wd_ads_options['pushover_token'], $message );
				}


			}

		}
	}


	function wd_ads_add_capabilities() {
		global $wp_roles;
		$wd_ads_options = wd_ads_get_settings();

		$roles = array_keys( $wp_roles->get_names() );


		if ( isset( $_GET['settings-updated'] ) ) {
			$caps = array( 'edit_', 'edit_others_', 'publish_', 'delete_', 'delete_others_' );


			/*capabilities for adverts*/
			foreach ( $roles as $the_role ) {
				$role = get_role( $the_role );
				if ( $the_role == 'administrator' ) {
					$role->add_cap( 'edit_stats_wd_ads_adverts' );
					continue;
				}

				$role->remove_cap( 'edit_stats_wd_ads_adverts' );

			}

			if ( isset( $wd_ads_options['edit_stats_wd_ads_adverts'] ) ) {
				foreach ( $wd_ads_options['edit_stats_wd_ads_adverts'] as $role_can_change ) {
					$role = get_role( $role_can_change );


					$role->add_cap( 'edit_stats_wd_ads_adverts' );


				}
			}

			foreach ( $caps as $cap ) {

				foreach ( $roles as $the_role ) {
					if ( $the_role == 'administrator' ) {
						continue;
					}

					$role = get_role( $the_role );


					if ( $cap == 'edit_' || $cap == 'delete_' ) {
						$role->remove_cap( $cap . 'wd_ads_advert' );
					}

					$role->remove_cap( $cap . 'wd_ads_adverts' );

				}


				if ( ! isset( $wd_ads_options[ $cap . 'wd_ads_adverts' ] ) ) {
					continue;
				}


				$roles_can_change = $wd_ads_options[ $cap . 'wd_ads_adverts' ];
				foreach ( $roles_can_change as $role_can_change ) {
					$role = get_role( $role_can_change );


					if ( $cap == 'edit_' || $cap == 'delete_' ) {
						$role->add_cap( $cap . 'wd_ads_advert' );
					}

					$role->add_cap( $cap . 'wd_ads_adverts' );


				}

			}
			/*capabilities for schedules*/
			foreach ( $caps as $cap ) {

				foreach ( $roles as $the_role ) {
					if ( $the_role == 'administrator' ) {
						continue;
					}

					$role = get_role( $the_role );


					if ( $cap == 'edit_' || $cap == 'delete_' ) {
						$role->remove_cap( $cap . 'wd_ads_schedule' );
					}

					$role->remove_cap( $cap . 'wd_ads_schedules' );

				}


				if ( ! isset( $wd_ads_options[ $cap . 'wd_ads_schedules' ] ) ) {
					continue;
				}


				$roles_can_change = $wd_ads_options[ $cap . 'wd_ads_schedules' ];
				foreach ( $roles_can_change as $role_can_change ) {
					$role = get_role( $role_can_change );


					if ( $cap == 'edit_' || $cap == 'delete_' ) {
						$role->add_cap( $cap . 'wd_ads_schedule' );
					}

					$role->add_cap( $cap . 'wd_ads_schedules' );


				}

			}

			/*capabilities for groups*/
			$caps_for_groups = array( 'manage_', 'edit_', 'delete_', 'assign_' );

			foreach ( $caps_for_groups as $cap ) {

				foreach ( $roles as $the_role ) {
					if ( $the_role == 'administrator' ) {
						continue;
					}

					$role = get_role( $the_role );


					$role->remove_cap( $cap . 'wd_ads_groups' );

				}

				if ( $cap == 'manage_' ) {
					$cap_group = 'edit_';
				} else {
					$cap_group = $cap;
				}


				if ( ! isset( $wd_ads_options[ $cap_group . 'wd_ads_adverts' ] ) ) {
					continue;
				}


				$roles_can_change = $wd_ads_options[ $cap_group . 'wd_ads_adverts' ];

				foreach ( $roles_can_change as $role_can_change ) {
					$role = get_role( $role_can_change );


					$role->add_cap( $cap . 'wd_ads_groups' );


				}

			}


		}


	}

	function wd_ads_ad_block_detect() {
		$wd_ads_options = wd_ads_get_settings();


		if ( $wd_ads_options['ad_block_detection'] == 1 ) {
			$time             = $wd_ads_options['show_massage'];
			$ad_block_message = str_replace( '%time%', '<span class="wd_ads_message_time">' . $time . '</span>', $wd_ads_options['message_to_show'] );


			?>
        <script>
          isAdblock = true;
        </script>

        <script src="<?php echo WD_ADS_URL . '/js/ads_detect.js' ?>"></script>

        <script>
          if (isAdblock) {
            var time = <?php echo $time * 1000 ?>;
            jQuery('<div class="wd_ads_adblock_messge" style="position: fixed;top: 50%;z-index: 100000;left: 50%;color:white">').html('<?php echo $ad_block_message ?>').appendTo('body');
            jQuery('<div class="wd_ads_overlay" style="display: block;background-color: #000000;opacity: 0.7;filter: Alpha(opacity=70);cursor: pointer;height: 100%;left: 0;position: fixed;top: 0;width: 100%;z-index: 10100;">').appendTo('body')

            margin_left = '-' + (jQuery('.wd_ads_adblock_messge').width() / 2) + 'px';
            margin_top = '-' + (jQuery('.wd_ads_adblock_messge').height() / 2) + 'px';

            jQuery('.wd_ads_adblock_messge').css('margin-left', margin_left)
            jQuery('.wd_ads_adblock_messge').css('margin-top', margin_top)

            var wd_ads_seconds_i = (time / 1000)
            var wd_ads_seconds_counter = setInterval(function () {
              wd_ads_seconds_i--;
              jQuery('.wd_ads_message_time').html(wd_ads_seconds_i);

            }, 1000)

            setTimeout(function () {
              jQuery('.wd_ads_adblock_messge').remove();
              jQuery('.wd_ads_overlay').remove();
              clearInterval(wd_ads_seconds_counter);

            }, time)
          }

        </script>


			<?php


		}
	}


	function wd_ads_change_advert() {
		$group_id = $_POST['group_id'];

		echo wd_ads_show_advert_group( $group_id );
		wp_die();

	}


	function wd_ads_is_bot( $user_agent ) {

		$wd_ads_options = wd_ads_get_settings();
		$bot_filter     = $wd_ads_options['bot_filter'];


		$bot_filter = str_replace( '.', '\.', $bot_filter );
		$bot_filter = str_replace( ',', '|', $bot_filter );

		$match = preg_match( '/' . $bot_filter . '/i', $user_agent );


		if ( $match ) {
			return true;
		}

		return false;
	}

	function wd_ads_count_impressions() {

		check_ajax_referer( WD_ADS_PLUGIN_PREFIX . '_ajax_nonce', 'wd_ads_nonce' );

		$wd_ads_options = wd_ads_get_settings();

		if ( ! isset( $wd_ads_options['logged_in_impressions'] ) and is_user_logged_in() ) {
			return false;
		}


		$post_id = 0;
		if ( isset( $_POST['post_id'] ) ) {
			$post_id = $_POST['post_id'];
		}

		$enable_statistics = get_post_meta( $post_id, 'statistics', true );

		if ( ! $enable_statistics ) {
			return false;
		}

		$date = date( 'Y-m-d' );

		$user_ip             = $this->wd_ads_get_ip();
		$time_for_impression = $wd_ads_options['impression_timer'];

		$impressions = get_post_meta( $post_id, 'impressions', true );

		$impressions_by_date = get_post_meta( $post_id, 'impressions_by_date', true );

		$impressions_by_date = json_decode( $impressions_by_date, true );

		$time_meta_for_user = get_post_meta( $post_id, 'time_' . $user_ip, true );

		$time_passed = time() - (int) $time_meta_for_user;

		if ( $impressions == '' ) {
			$impressions = 0;
		}

		if ( ! isset( $impressions_by_date[ $date ] ) ) {
			$impressions_by_date[ $date ] = 0;
		}


		if ( $time_passed > $time_for_impression && ! $this->wd_ads_is_bot( $_SERVER['HTTP_USER_AGENT'] ) ) {
			$impressions += 1;
			$impressions_by_date[ $date ] += 1;

			update_post_meta( $post_id, 'impressions', $impressions );
			update_post_meta( $post_id, 'impressions_by_date', json_encode( $impressions_by_date ) );

			update_post_meta( $post_id, 'time_' . $user_ip, time() );
		}

		wp_die();
	}


	function wd_ads_count_clicks() {

		check_ajax_referer( WD_ADS_PLUGIN_PREFIX . '_ajax_nonce', 'wd_ads_nonce' );

		$wd_ads_options = wd_ads_get_settings();
		if ( ! isset( $wd_ads_options['logged_in_clicks'] ) and is_user_logged_in() ) {
			return false;
		}


		$post_id = 0;
		if ( isset( $_POST['post_id'] ) ) {
			$post_id = $_POST['post_id'];
		}

		$enable_statistics = get_post_meta( $post_id, 'statistics', true );

		if ( ! $enable_statistics ) {
			return false;
		}


		$date = date( 'Y-m-d' );

		$user_ip         = $this->wd_ads_get_ip();
		$time_for_clicks = $wd_ads_options['click_timer'];

		$clicks = get_post_meta( $post_id, 'clicks', true );
		/////////////////

		$clicks_by_date = get_post_meta( $post_id, 'clicks_by_date', true );

		$clicks_by_date = json_decode( $clicks_by_date, true );
		////////////////////////

		$time_meta_for_user = get_post_meta( $post_id, 'time_click_' . $user_ip, true );

		$time_passed = time() - (int) $time_meta_for_user;

		if ( $clicks == '' ) {
			$clicks = 0;
		}


		if ( ! isset( $clicks_by_date[ $date ] ) ) {
			$clicks_by_date[ $date ] = 0;
		}


		if ( $time_passed > $time_for_clicks && ! $this->wd_ads_is_bot( $_SERVER['HTTP_USER_AGENT'] ) ) {
			$clicks += 1;
			$clicks_by_date[ $date ] += 1;


			update_post_meta( $post_id, 'clicks', $clicks );

			update_post_meta( $post_id, 'clicks_by_date', json_encode( $clicks_by_date ) );

			update_post_meta( $post_id, 'time_click_' . $user_ip, time() );
		}

		wp_die();
	}


	public function wd_ads_cpt_columns( $column_name, $post_id ) {


		$date                = date( 'Y-m-d' );
		$impressions         = get_post_meta( $post_id, 'impressions', true );
		$clicks              = get_post_meta( $post_id, 'clicks', true );
		$impressions_by_date = get_post_meta( $post_id, 'impressions_by_date', true );
		$impressions_by_date = json_decode( $impressions_by_date, true );
		/////////////////
		$clicks_by_date = get_post_meta( $post_id, 'clicks_by_date', true );

		$clicks_by_date = json_decode( $clicks_by_date, true );

		$weight = get_post_meta( $post_id, 'weight', true );


		switch ( $column_name ) {


			case 'advert-sc':
				echo '<code>[wd_ads advert="' . $post_id . '"]</code>';
				break;

			case 'advert-impressions':
				echo $impressions;
				break;

			case 'advert-clicks':
				echo $clicks;
				break;

			case 'advert-today-impressions':
				echo isset( $impressions_by_date[ $date ] ) ? $impressions_by_date[ $date ] : 0;
				break;

			case 'advert-today-clicks':
				echo isset( $clicks_by_date[ $date ] ) ? $clicks_by_date[ $date ] : 0;
				break;

			case 'advert-weight':
				echo $weight;
				break;

			case 'advert-ctr':
				if ( $impressions == 0 ) {
					$impressions = 1;
				}

				if(!$clicks) {
                    $clicks=0;
                }

				$ctr = round( ( $clicks / $impressions ) * 100, 2 ) . '%';
				echo $ctr;
				break;

			case 'advert-today-stats':
				echo '<a href="edit.php?post_type=wd_ads_ads&page=wd_ads_stats&post_id=' . $post_id . '">Statistics</a>';
				break;

		}
	}

	public function wd_ads_schedules_cpt_columns( $column_name, $post_id ) {


		$start_date = get_post_meta( $post_id, 'start_date', true );
		$end_date   = get_post_meta( $post_id, 'end_date', true );


		switch ( $column_name ) {


			case 'wd_ads_start_end':
				echo "<div class='wd_ads_schedule_start'>
					 " . date( 'F d, Y H:i', $start_date ) . "
					</div>
					<div class='wd_ads_schedule_end'>
					 " . date( 'F d, Y H:i', $end_date ) . "
					</div>

					";
				break;


		}
	}


	public function wd_ads_cpt_columns_headers( $defaults ) {

		$wd_ads_options = wd_ads_get_settings();

		$new_columns = array(
			'advert-sc'     => __( 'Shortcode' ),
			'advert-weight' => __( 'Weight' ),

		);

		if ( $wd_ads_options['stats_track'] == 1 ) {

			$new_columns['advert-impressions']       = __( 'Impressions' );
			$new_columns['advert-clicks']            = __( 'Clicks' );
			$new_columns['advert-today-impressions'] = __( 'Today Impressions' );
			$new_columns['advert-today-clicks']      = __( 'Today Clicks' );
			$new_columns['advert-ctr']               = __( 'CTR' );
			if ( current_user_can( 'edit_stats_wd_ads_adverts' ) ) {
				$new_columns['advert-today-stats'] = __( 'Statistics' );
			}
		}


		return array_merge( $defaults, $new_columns );
	}


	public function wd_ads_schedules_cpt_columns_headers( $defaults ) {


		$new_columns = array(
			'wd_ads_start_end' => __( 'Start/End Date' ),

		);


		return array_merge( $defaults, $new_columns );
	}


///Create Custom Post Types
	function wd_ads_setup_cpt() {

		$show_in_menu = false;
		if ( get_option( WD_ADS_PLUGIN_PREFIX . "_subscribe_done" ) == 1 ) {
			$show_in_menu = true;
		}
		register_post_type( WD_ADS_PLUGIN_PREFIX . '_ads', array(
			'labels'             => array(
				'name'          => __( 'Ad Manager WD' ),
				'singular_name' => __( 'Ad Manager WD' ),
				'all_items'     => __( 'All Adverts' ),
				'add_new'       => __( 'Add new advert' ),
				'add_new_item'  => __( 'Add new advert' ),
				'edit_item'     => __( 'Edit advert' ),


			),
			'taxonomies'         => array( WD_ADS_PLUGIN_PREFIX . '_manage_groups' ),
			'menu_icon'          => WD_ADS_URL . '/images/icons/Ad-manager-icon.png',
			'public'             => false,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => $show_in_menu,
			'menu_position'      => '27,11',
			'query_var'          => true,
			'capability_type'    => '_wd_ads_advert',
			'capabilities'       => array(
				'publish_posts'       => 'publish_wd_ads_adverts',
				'edit_posts'          => 'edit_wd_ads_adverts',
				'edit_others_posts'   => 'edit_others_wd_ads_adverts',
				'delete_posts'        => 'delete_wd_ads_adverts',
				'delete_others_posts' => 'delete_others_wd_ads_adverts',
				'read_private_posts'  => 'read_private_wd_ads_adverts',
				'edit_post'           => 'edit_wd_ads_advert',
				'delete_post'         => 'delete_wd_ads_advert',
				'read_post'           => 'read_wd_ads_advert',
				'create_posts'        => 'edit_wd_ads_advert',
			),
			'has_archive'        => false,
			'hierarchical'       => false,
			'supports'           => array( 'title', 'thumbnail',/*'author' ,'editor'*/ )
		) );


		/*		  register_post_type(WD_ADS_PLUGIN_PREFIX . '_schedules',
										array(
												'labels' => array(
														'name' => __('Ad Manager WD schedules'),
														'singular_name' => __('Ad Manager WD schedules'),
														'all_items' => __('Schedules'),
														'add_new' => __('Add new schedule'),
														'add_new_item' => __('Add new schedule'),
														'edit_item' => __('Edit schedule'),


												),
												'public' => false,
												'menu_icon'          => WD_ADS_URL . '/images/icons/Ad-manager-icon.png',

												'publicly_queryable' => true,
												'show_ui' => true,
												'show_in_menu' => true,
												'menu_position' => '27,11',
												'query_var' => true,
												'capability_type' => '_wd_ads_schedule',
												'capabilities' => array(
														'publish_posts' => 'publish_wd_ads_schedules',
														'edit_posts' => 'edit_wd_ads_schedules',
														'edit_others_posts' => 'edit_others_wd_ads_schedules',
														'delete_posts' => 'delete_wd_ads_schedules',
														'delete_others_posts' => 'delete_others_wd_ads_schedules',
														'read_private_posts' => 'read_private_wd_ads_schedules',
														'edit_post' => 'edit_wd_ads_schedule',
														'delete_post' => 'delete_wd_ads_schedule',
														'read_post' => 'read_wd_ads_schedule',
														'create_posts' => 'edit_wd_ads_schedule',
												),
												'has_archive' => false,
												'hierarchical' => false,
												'show_in_menu' => 'edit.php?post_type=wd_ads_ads',
												'supports' => array('title', 'thumbnail' )
										)
								);*/


	}


	function wd_ads_ads_meta() {
		///////////////////////adverts
		add_meta_box( WD_ADS_PLUGIN_PREFIX . '_ads_meta', __( 'New Advert' ), array(
			$this,
			'display_wd_ads_meta_new'
		), WD_ADS_PLUGIN_PREFIX . '_ads', 'normal' );


		add_meta_box( WD_ADS_PLUGIN_PREFIX . '_ads_meta_post', __( 'Publishing' ), array(
			$this,
			'display_wd_ads_meta_post'
		), WD_ADS_PLUGIN_PREFIX . '_ads', 'normal' );


		add_meta_box( WD_ADS_PLUGIN_PREFIX . '_ads_meta_schedules', __( 'Create Schedules' ), array(
			$this,
			'display_wd_ads_meta_schedules'
		), WD_ADS_PLUGIN_PREFIX . '_ads', 'normal' );


		add_meta_box( WD_ADS_PLUGIN_PREFIX . '_ads_meta_wrapper', __( 'Wrapper code' ), array(
			$this,
			'display_wd_ads_meta_wrapper'
		), WD_ADS_PLUGIN_PREFIX . '_ads', 'normal' );

		add_meta_box( WD_ADS_PLUGIN_PREFIX . '_ads_meta_advanced', __( 'Advanced' ), array(
			$this,
			'display_wd_ads_meta_advanced'
		), WD_ADS_PLUGIN_PREFIX . '_ads', 'normal' );

		add_meta_box( WD_ADS_PLUGIN_PREFIX . '_ads_meta_geo', __( 'Geo Targeting' ), array(
			$this,
			'display_wd_ads_meta_geo'
		), WD_ADS_PLUGIN_PREFIX . '_ads', 'normal' );


//////////////schedules


	}


	function display_wd_ads_meta_wrapper() {
		include_once( WD_ADS_DIR . '/views/wd_ads_ads_meta_wrapper.php' );


	}


	function display_wd_ads_meta_schedules() {


		include_once( WD_ADS_DIR . '/views/wd_ads_ads_meta_schedules.php' );


	}


	function display_wd_ads_meta_new() {
		include_once( WD_ADS_DIR . '/views/wd_ads_ads_meta_new.php' );


	}

	function display_wd_ads_meta_advanced() {
		include_once( WD_ADS_DIR . '/views/wd_ads_ads_meta_advanced.php' );


	}

	function display_wd_ads_meta_geo() {
		include_once( WD_ADS_DIR . '/views/wd_ads_ads_meta_geo.php' );


	}

	function display_wd_ads_meta_post() {
		include_once( WD_ADS_DIR . '/views/wd_ads_ads_meta_post.php' );


	}

	/**
	 * save advertisement and schedule
	 *
	 * @param $post_id
	 *
	 * @return mixed
	 */
	function wd_ads_save_ad( $post_id ) {


		// check autosave

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

			return $post_id;

		}

		// check permissions

		if ( isset( $_POST['post_type'] ) AND WD_ADS_PLUGIN_PREFIX . '_ads' == $_POST['post_type'] && current_user_can( 'edit_post', $post_id ) ) {

			/* Save Adverts */


			if ( ! isset( $_POST['wd_ads']['statistics'] ) ) {
				$_POST['wd_ads']['statistics'] = 0;
			}


			$_POST['wd_ads']['enable_responsive'] = 0;
			$_POST['wd_ads']['show_on']           = array();
			$_POST['wd_ads']['weight']            = 3;
			$_POST['wd_ads']['sortorder']         = 0;

			if ( ! isset( $_POST['wd_ads']['show_in_posts'] ) ) {
				$_POST['wd_ads']['show_in_posts'] = 0;
			}

			if ( ! isset( $_POST['wd_ads']['show_in_pages'] ) ) {
				$_POST['wd_ads']['show_in_pages'] = 0;
			}

			if ( ! isset( $_POST['wd_ads']['show_in_cats'] ) ) {
				$_POST['wd_ads']['show_in_cats'] = 0;
			}

			$countries = '{"ALL":"1","EUROPE":"1","AZ":"1","AL":"1","AM":"1","AD":"1","AT":"1","BY":"1","BE":"1","BA":"1","BG":"1","HR":"1","CY":"1","CZ":"1","DK":"1","EE":"1","FI":"1","FR":"1","GE":"1","DE":"1","GR":"1","HU":"1","IS":"1","IE":"1","IT":"1","LV":"1","LI":"1","LT":"1","LU":"1","MK":"1","MT":"1","MD":"1","MC":"1","NL":"1","NO":"1","PL":"1","PT":"1","RO":"1","SM":"1","RS":"1","ES":"1","SK":"1","SI":"1","SE":"1","CH":"1","VA":"1","TR":"1","UA":"1","GB":"1","SOUTHEASTASIA":"1","AU":"1","BN":"1","KH":"1","TL":"1","ID":"1","LA":"1","MY":"1","MM":"1","NZ":"1","PH":"1","SG":"1","TH":"1","VN":"1","NORTHAMERICA":"1","AG":"1","BS":"1","BB":"1","BZ":"1","CA":"1","CR":"1","CU":"1","DM":"1","DO":"1","SV":"1","GD":"1","GT":"1","HT":"1","HN":"1","JM":"1","MX":"1","NI":"1","PA":"1","KN":"1","LC":"1","VC":"1","TT":"1","US":"1","SOUTHAMERICA":"1","AR":"1","BO":"1","BR":"1","CL":"1","CO":"1","EC":"1","GY":"1","PY":"1","PE":"1","SR":"1","UY":"1","VE":"1","MISC":"1","AF":"1","DZ":"1","AO":"1","BH":"1","BD":"1","BJ":"1","BT":"1","BF":"1","BI":"1","CM":"1","CV":"1","CF":"1","TD":"1","CN":"1","KM":"1","CG":"1","CD":"1","CI":"1","DJ":"1","EG":"1","GQ":"1","ER":"1","ET":"1","FJ":"1","GA":"1","GM":"1","GH":"1","GN":"1","GW":"1","IN":"1","IR":"1","IQ":"1","JP":"1","JO":"1","KZ":"1","KE":"1","KI":"1","KP":"1","KR":"1","KW":"1","KG":"1","LB":"1","LS":"1","LR":"1","LY":"1","MG":"1","MW":"1","MV":"1","MN":"1","ML":"1","MH":"1","MR":"1","MU":"1","FM":"1","MA":"1","MZ":"1","NA":"1","NR":"1","NP":"1","NE":"1","NG":"1","OM":"1","PK":"1","PW":"1","PG":"1","QA":"1","RU":"1","RW":"1","WS":"1","ST":"1","SA":"1","SN":"1","SC":"1","SL":"1","SB":"1","SO":"1","ZA":"1","LK":"1","SY":"1","SD":"1","SZ":"1","TW":"1","TJ":"1","TO":"1","TM":"1","TV":"1","TZ":"1","TG":"1","TN":"1","UG":"1","AE":"1","UZ":"1","VU":"1","YE":"1","ZM":"1","ZW":"1"}';

			$_POST['wd_ads']['countries'] = json_decode( $countries, true );

			if ( ! isset( $_POST['wd_ads']['posts'] ) ) {
				$_POST['wd_ads']['posts'] = 0;
			}
			if ( ! isset( $_POST['wd_ads']['use_schedule'] ) ) {
				$_POST['wd_ads']['use_schedule'] = 0;
			}

			if ( ! isset( $_POST['wd_ads']['categories'] ) ) {
				$_POST['wd_ads']['categories'] = 0;
			}

			if ( ! isset( $_POST['wd_ads']['pages'] ) ) {
				$_POST['wd_ads']['pages'] = 0;
			}


			$schedule = get_post_meta( $post_id, 'schedule', true );
			$schedule = json_decode( $schedule, true );

			if ( $_POST['wd_ads']['use_schedule'] != 0 ) {
				if ( ! is_array( $schedule ) ) {
					$post        = get_post( $post_id );
					$schedule_id = wp_insert_post( array(
						                               'post_type'   => 'wd_ads_schedules',
						                               'post_title'  => 'Schedule for ' . $post->post_title,
						                               'post_status' => 'publish',

					                               ) );

				} else {

					$schedule_id = array_keys( $schedule );
					$schedule_id = $schedule_id[0];
				}


				if ( $schedule_id ) {
					$wd_ads_schedule = $_POST['wd_ads_schedules'];

					$start_date      = strtotime( $wd_ads_schedule['start_date'] );
					$end_date        = strtotime( $wd_ads_schedule['end_date'] );
					$max_clicks      = $wd_ads_schedule['max_clicks'];
					$max_impressions = $wd_ads_schedule['max_impressions'];
					$weekdays        = '{"1":"1","2":"1","3":"1","4":"1","5":"1","6":"1","7":"1"}';

					update_post_meta( $schedule_id, 'start_date', $start_date );
					update_post_meta( $schedule_id, 'end_date', $end_date );

					update_post_meta( $schedule_id, 'max_clicks', $max_clicks );
					update_post_meta( $schedule_id, 'max_impressions', $max_impressions );
					update_post_meta( $schedule_id, 'weekdays', $weekdays );
					$_POST['wd_ads']['schedule'] = array( $schedule_id => '1' );


				}
			} else {
				$_POST['wd_ads']['schedule'] = 0;
			}


			if ( $_POST['wd_ads']['schedule'] == 0 && is_array( $schedule ) ) {

				$schedule_id = array_keys( $schedule );
				$schedule_id = $schedule_id[0];
				wp_delete_post( $schedule_id, true );
				delete_post_meta( $schedule_id, 'start_date' );
				delete_post_meta( $schedule_id, 'end_date' );

				delete_post_meta( $schedule_id, 'max_clicks' );
				delete_post_meta( $schedule_id, 'max_impressions' );
				delete_post_meta( $schedule_id, 'weekdays' );
			}

			$wd_ads = ( isset( $_POST['wd_ads'] ) ? $_POST['wd_ads'] : '' );

			if ( ! current_user_can( 'publish_wd_ads_adverts' ) ) {
				$wd_ads['advertiser'] = get_current_user_id();
			}


			/*$arg = [ 'ID' => $post_id, 'post_author' => $wd_ads['advertiser'], ];


			remove_action( 'post_updated', [ $this, WD_ADS_PLUGIN_PREFIX . '_save_ad' ] );
			wp_update_post( $arg );
			add_action( 'post_updated', [ $this, WD_ADS_PLUGIN_PREFIX . '_save_ad' ] );*/


			foreach ( $wd_ads as $key => $wd_ad ) {
				if ( $key == 'countries' or $key == 'posts' or $key == 'pages' or $key == 'schedule' or $key == 'categories' or $key == 'show_on' ) {
					$wd_ad = strip_tags( json_encode( $wd_ads[ $key ] ) );


				}


				update_post_meta( $post_id, $key, $wd_ad );

			}


		} else {

			return $post_id;

		}

	}


	function wd_ads_groups() {
		register_taxonomy( WD_ADS_PLUGIN_PREFIX . '_manage_groups', 'manage_groups', array(
			'labels' => array( 'name' => 'Groups', 'add_new_item' => 'Add New Group', 'new_item_name' => "New Group" ),

			'capabilities'  => array(
				'manage_terms' => 'manage_wd_ads_groups',
				'edit_terms'   => 'edit_wd_ads_groups',
				'delete_terms' => 'delete_wd_ads_groups',
				'assign_terms' => 'assign_wd_ads_groups'
			),
			'show_ui'       => true,
			'show_tagcloud' => false,
			'hierarchical'  => true
		) );
	}

	function wd_ads_add_new_meta_field() {
		// this will add the custom meta field to the add new term page

		include_once( WD_ADS_DIR . '/views/wd_ads_manage_groups_meta_add.php' );


	}


	function wd_ads_edit_meta_field( $term ) {


		include_once( WD_ADS_DIR . '/views/wd_ads_manage_groups_meta_edit.php' );


	}


	function wd_ads_save_manage_group_taxonomy_custom_meta( $term_id ) {
		if ( isset( $_POST[ $this->tax ] ) ) {


			if ( ! isset( $_POST[ $this->tax ]['show_in_posts'] ) ) {
				$_POST[ $this->tax ]['show_in_posts'] = 0;
			}

			if ( ! isset( $_POST[ $this->tax ]['show_in_pages'] ) ) {
				$_POST[ $this->tax ]['show_in_pages'] = 0;
			}

			if ( ! isset( $_POST[ $this->tax ]['show_in_cats'] ) ) {
				$_POST[ $this->tax ]['show_in_cats'] = 0;
			}


			if ( isset( $_POST[ $this->tax ]['posts'] ) ) {
				$_POST[ $this->tax ]['posts'] = strip_tags( json_encode( $_POST[ $this->tax ]['posts'] ) );
			} else {
				$_POST[ $this->tax ]['posts'] = 0;
			}


			if ( isset( $_POST[ $this->tax ]['pages'] ) ) {
				$_POST[ $this->tax ]['pages'] = strip_tags( json_encode( $_POST[ $this->tax ]['pages'] ) );
			} else {
				$_POST[ $this->tax ]['pages'] = 0;
			}

			if ( isset( $_POST[ $this->tax ]['categories'] ) ) {
				$_POST[ $this->tax ]['categories'] = strip_tags( json_encode( $_POST[ $this->tax ]['categories'] ) );
			} else {
				$_POST[ $this->tax ]['categories'] = 0;
			}


			$t_id      = $term_id;
			$term_meta = get_option( "{$this->tax}_$t_id" );
			$cat_keys  = array_keys( $_POST[ $this->tax ] );
			foreach ( $cat_keys as $key ) {


				if ( isset ( $_POST[ $this->tax ][ $key ] ) ) {
					$term_meta[ $key ] = $_POST[ $this->tax ][ $key ];
				}


			}


			// Save the option array.
			update_option( "{$this->tax}_$t_id", $term_meta );
		}
	}


	function wd_ads_get_ip() {
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;

	}


	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}


}






