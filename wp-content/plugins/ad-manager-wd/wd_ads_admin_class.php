<?php

/*
WD_ADS admin
*/

class wd_ads_admin
{

    protected static $instance = null;
    protected $version = 'Alpha';
    protected $wd_ads_page = null;
    protected $update_path = 'http://api.web-dorado.com/v1/_id_/allversions';
    protected $plugin_slug = 'wd_ads';
    protected $plugin = 'wd_ads/wd_ads.php';
    protected $updates = array();
    protected $wd_ads_plugins = array();
    protected $plugin_url = '';
    protected $notices = null;
    public $mail_template = array();

    private function __construct()
    {
        $plugin = wd_ads::get_instance();
        $this->prefix = $plugin->get_prefix();

        $this->version = $plugin->get_version();
        //$this->overview();
        $this->includes();
        if (isset($_GET['export']) && $_GET['export'] == 'export_csv')
            $this->export_csv();
        //add_action( 'admin_menu', array( $this, 'wd_advertisement_sub' ) );
        add_action('admin_enqueue_scripts', array($this, 'wd_ads_enqueue_admin_styles'));
        add_action('admin_enqueue_scripts', array($this, 'wd_ads_enqueue_admin_scripts'));
        add_action('admin_notices', array($this, 'wd_ads_create_logo_to_head'));


        /*       add_filter('cron_schedules', array($this, 'add_new_intervals'));

                        add_action('wp', array($this, 'my_activation'));
                        add_action('my_hourly_event', array($this, 'do_this_hourly'));*/
    }


    function overview()
    {

    }

    function export_csv()
    {
        if (!isset($_GET['path'])) {
            $dates = json_decode($_POST['dates'], true);
            $impressions = json_decode($_POST['impressions_by_date'], true);
            $clicks = json_decode($_POST['clicks_by_date'], true);
            $filename = $_POST['title'];
            $date_range = $_POST['range'];

            if (!is_dir(WD_ADS_DIR . '/csv')) {
                mkdir(WD_ADS_DIR . '/csv');
            }

            $fp = fopen(WD_ADS_DIR . '/csv/' . $filename . '.csv', 'w');


            $export_array = array();
            $export_array[] = array('Date', 'impressions', 'clicks', 'CTR');
            $date_range_impressions = 0;
            $date_range_clicks = 0;
            foreach ($dates as $date) {
                $impression = isset($impressions[$date]) ? $impressions[$date] : 1;
                $click = isset($clicks[$date]) ? $clicks[$date] : 0;
                $ctr_daily = round(($click / $impression) * 100, 2) . '%';

                $date_range_impressions += $impression;
                $date_range_clicks += $click;

                $export_array[] = array('"' . $date . '"', $impression, $click, $ctr_daily);

            }
            if ($date_range_impressions != 0)
                $date_range_ctr = round(($date_range_clicks / $date_range_impressions) * 100, 2) . '%';
            else
                $date_range_ctr = 0;

            $export_array[] = array('"' . $date_range . '"', $date_range_impressions, $date_range_clicks, $date_range_ctr);

            foreach ($export_array as $fields) {
                fputcsv($fp, $fields);
            }


            $path = WD_ADS_DIR . '/csv/' . $filename . '.csv';
            echo $path;
            exit;
        } else {
            $path = $_GET['path'];
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=' . basename($path));

            readfile($path);
            unlink($path);
            exit;
        }
    }


    function wd_ads_create_logo_to_head()
    {
        $screen = get_current_screen();
        if ((isset($_GET['post_type']) && $_GET['post_type'] == 'wd_ads_ads') || $screen->id == 'wd_ads_ads') {
            ?>
            <div>
                <div class="wd_ads_upgrade wd_ads-clear">
                    <div class="wd_ads-right">
                        <div class="wd-table">
                            <div class="wd-cell wd-cell-valign-middle">
                                <a href="https://wordpress.org/support/plugin/ad-manager-wd" target="_blank">
                                    <img src="<?php echo WD_ADS_URL; ?>/images/i_support.png" >
                                    <?php _e("Support Forum", "gmwd"); ?>
                                </a>
                            </div>
                            <div class="wd-cell wd-cell-valign-middle">
                                <a href="https://web-dorado.com/files/fromAdManagerWd.php" target="_blank">
                                    <?php _e("UPGRADE TO PAID VERSION", "gmwd"); ?>
                                </a>
                            </div>
                        </div>
                    </div>

<?php
                        echo '<div class="wd_ads-left">';
                            switch ( $screen->id ) {
                            case 'edit-wd_ads_ads':
                            echo '
                            <div style="font-size: 14px; font-weight: bold;">
                                This section allows you to create, edit and delete Adverts.
                                <a style="color: #5CAEBD; text-decoration: none;border-bottom: 1px dotted;" target="_blank"
                                   href="https://web-dorado.com/ad-manager-wd/creating-advertisement.html">Read More in
                                    User Manual</a>
                            </div>
                            ';

                            break;

                            case 'wd_ads_ads':
                            echo '
                            <div style="font-size: 14px; font-weight: bold;">
                                This section allows you to add/edit Advert.
                                <a style="color: #5CAEBD; text-decoration: none;border-bottom: 1px dotted;" target="_blank"
                                   href="https://web-dorado.com/ad-manager-wd/creating-advertisement/new-advert.html">Read
                                    More in User Manual</a>
                            </div>
                            ';

                            break;
                            case 'edit-wd_ads_manage_groups':
                            echo '
                            <div style="font-size: 14px; font-weight: bold;">
                                This section allows you to add/edit Advert groups.
                                <a style="color: #5CAEBD; text-decoration: none;border-bottom: 1px dotted;" target="_blank"
                                   href="https://web-dorado.com/ad-manager-wd/groups.html">Read More in User Manual</a>
                            </div>
                            ';

                            break;
                            case 'wd_ads_ads_page_wd_ads_schedules':
                            echo '
                            <div style="font-size: 14px; font-weight: bold;">
                                This section allows you to create, edit and delete Schedules.
                                <a style="color: #5CAEBD; text-decoration: none;border-bottom: 1px dotted;" target="_blank"
                                   href="https://web-dorado.com/ad-manager-wd/schedules.html">Read More in User
                                    Manual</a>
                            </div>
                            ';

                            break;
                            case 'wd_ads_ads_page_wd_ads_settings':
                            echo '
                            <div style="font-size: 14px; font-weight: bold;">
                                This section allows you to change settings.
                                <a style="color: #5CAEBD; text-decoration: none;border-bottom: 1px dotted;" target="_blank"
                                   href="https://web-dorado.com/ad-manager-wd/settings.html">Read More in User
                                    Manual</a>
                            </div>
                            ';

                            break;
                            case 'wd_ads_ads_page_wd_ads_import':
                            echo '
                            <div style="font-size: 14px; font-weight: bold;">
                                This section allows you to import Adverts.
                                <a style="color: #5CAEBD; text-decoration: none;border-bottom: 1px dotted;" target="_blank"
                                   href="https://web-dorado.com/ad-manager-wd/import.html">Read More in User Manual</a>
                            </div>
                            ';

                            break;
                            }

                            echo '
                        </div>
                        ';
?>

                </div>
            </div>
            <?php
        }
    }

    /**
     * @param $image_url
     * @param $post_id
     * Create and Select featured image for default advert
     */
    public static function wd_ads_generate_featured_image($image_url, $post_id)
    {

        $upload_dir = wp_upload_dir();
        $image_data = file_get_contents($image_url);
        $filename = basename($image_url);
        if (wp_mkdir_p($upload_dir['path'])) {
            $file = $upload_dir['path'] . '/' . $filename;
        } else {
            $file = $upload_dir['basedir'] . '/' . $filename;
        }
        file_put_contents($file, $image_data);

        $wp_filetype = wp_check_filetype($filename, null);
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title'     => sanitize_file_name($filename),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );
        $attach_id = wp_insert_attachment($attachment, $file, $post_id);
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata($attach_id, $file);
        $res1 = wp_update_attachment_metadata($attach_id, $attach_data);
        $res2 = set_post_thumbnail($post_id, $attach_id);

    }

    /**
     * Ad manager activation
     */
    public static function wd_ads_activate()
    {


        if (get_option('wd_ads_def_advert') === false) {
            $post_id = wp_insert_post(array(
                'post_type'   => 'wd_ads_ads',
                'post_title'  => 'Advert 1',
                'post_status' => 'publish',

            ));
            if ($post_id) {

                $area_code = '<a href="https://web-dorado.com/wordpress-plugins-bundle.html"><img src="%featured_image%"></a>';
                $countries = '{"ALL":"1","EUROPE":"1","AL":"1","AM":"1","AD":"1","AT":"1","AZ":"1","BY":"1","BE":"1","BA":"1","BG":"1","HR":"1","CY":"1","CZ":"1","DK":"1","EE":"1","FI":"1","FR":"1","GE":"1","DE":"1","GR":"1","HU":"1","IS":"1","IE":"1","IT":"1","LV":"1","LI":"1","LT":"1","LU":"1","MK":"1","MT":"1","MD":"1","MC":"1","NL":"1","NO":"1","PL":"1","PT":"1","RO":"1","SM":"1","RS":"1","ES":"1","SK":"1","SI":"1","SE":"1","CH":"1","VA":"1","TR":"1","UA":"1","GB":"1","SOUTHEASTASIA":"1","AU":"1","BN":"1","KH":"1","TL":"1","ID":"1","LA":"1","MY":"1","MM":"1","NZ":"1","PH":"1","SG":"1","TH":"1","VN":"1","NORTHAMERICA":"1","AG":"1","BS":"1","BB":"1","BZ":"1","CA":"1","CR":"1","CU":"1","DM":"1","DO":"1","SV":"1","GD":"1","GT":"1","HT":"1","HN":"1","JM":"1","MX":"1","NI":"1","PA":"1","KN":"1","LC":"1","VC":"1","TT":"1","US":"1","SOUTHAMERICA":"1","AR":"1","BO":"1","BR":"1","CL":"1","CO":"1","EC":"1","GY":"1","PY":"1","PE":"1","SR":"1","UY":"1","VE":"1","MISC":"1","AF":"1","DZ":"1","AO":"1","BH":"1","BD":"1","BJ":"1","BT":"1","BF":"1","BI":"1","CM":"1","CV":"1","CF":"1","TD":"1","CN":"1","KM":"1","CG":"1","CD":"1","CI":"1","DJ":"1","EG":"1","GQ":"1","ER":"1","ET":"1","FJ":"1","GA":"1","GM":"1","GH":"1","GN":"1","GW":"1","IN":"1","IR":"1","IQ":"1","JP":"1","JO":"1","KZ":"1","KE":"1","KI":"1","KP":"1","KR":"1","KW":"1","KG":"1","LB":"1","LS":"1","LR":"1","LY":"1","MG":"1","MW":"1","MV":"1","MN":"1","ML":"1","MH":"1","MR":"1","MU":"1","FM":"1","MA":"1","MZ":"1","NA":"1","NR":"1","NP":"1","NE":"1","NG":"1","OM":"1","PK":"1","PW":"1","PG":"1","QA":"1","RU":"1","RW":"1","WS":"1","ST":"1","SA":"1","SN":"1","SC":"1","SL":"1","SB":"1","SO":"1","ZA":"1","LK":"1","SY":"1","SD":"1","SZ":"1","TW":"1","TJ":"1","TO":"1","TM":"1","TV":"1","TZ":"1","TG":"1","TN":"1","UG":"1","AE":"1","UZ":"1","VU":"1","YE":"1","ZM":"1","ZW":"1"}';
                $statistics = 1;
                add_post_meta($post_id, 'area_code', $area_code);
                add_post_meta($post_id, 'countries', $countries);
                add_post_meta($post_id, 'statistics', $statistics);


                self::wd_ads_generate_featured_image(plugins_url('images/banners/WP_Plugin_Deals_336-280.png', __FILE__), $post_id);

            }

            add_option('wd_ads_def_advert');
        }


        $caps = array('edit_', 'edit_others_', 'publish_', 'delete_', 'delete_others_');

        $role = get_role('administrator');
        $role->add_cap('edit_stats_wd_ads_adverts');
        /*capabilities for adverts*/
        foreach ($caps as $cap) {


            $role = get_role('administrator');


            if ($cap == 'edit_' || $cap == 'delete_') {
                $role->add_cap($cap . 'wd_ads_advert');
            }

            $role->add_cap($cap . 'wd_ads_adverts');


        }
        /*capabilities for schedules*/
        foreach ($caps as $cap) {


            $role = get_role('administrator');


            if ($cap == 'edit_' || $cap == 'delete_') {
                $role->add_cap($cap . 'wd_ads_schedule');
            }

            $role->add_cap($cap . 'wd_ads_schedules');


        }

        /*capabilities for groups*/
        $caps_for_groups = array('manage_', 'edit_', 'delete_', 'assign_');

        foreach ($caps_for_groups as $cap) {


            $role = get_role('administrator');


            $role->add_cap($cap . 'wd_ads_groups');


        }


    }

    /* function add_new_intervals($schedules)
     {
             // add weekly and monthly intervals
             $schedules['weekly'] = array(
                     'interval' => 604800,
                     'display' => __('Once Weekly')
             );

             $schedules['monthly'] = array(
                     'interval' => 2635200,
                     'display' => __('Once a month')
             );

             $schedules['seconds'] = array(
                     'interval' => 1,
                     'display' => __('seconds')
             );

             return $schedules;
     }


     function my_activation()
     {

             if (!wp_next_scheduled('my_hourly_event')) {

                     wp_schedule_event(time(), 'seconds', 'my_hourly_event');


             }
     }

     function do_this_hourly()
     {
             wp_mail('araqelaraqelyan@gmail.com', 'The subject', 'The message');
     }

*/

    /**
     * inclide scripts for admin section
     */
    public function wd_ads_enqueue_admin_scripts()
    {
        wp_enqueue_script($this->prefix . '-admi-js', plugins_url('js/wd_ads_admin.js', __FILE__), array('jquery'), $this->version);
        wp_enqueue_script($this->prefix . '-exporting', plugins_url('js/exporting.js', __FILE__), array('jquery'), $this->version);

        wp_enqueue_script($this->prefix . '-admin-datetimepicker', plugins_url('js/jquery.datetimepicker.js', __FILE__), array(
            'jquery',
            'jquery-ui-widget'
        ), $this->version, true);

        wp_enqueue_script($this->prefix . '-admin-datetimepicker-scripts', plugins_url('js/datepicker.js', __FILE__), array('jquery'), $this->version, true);


    }

    /**
     * include styles for admin section
     */
    function wd_ads_enqueue_admin_styles()
    {
        wp_enqueue_style($this->prefix . '-admin_style', plugins_url('css/admin.css', __FILE__), array(), $this->version, 'all');
        wp_enqueue_style($this->prefix . '-admin-datetimepicker-css', plugins_url('css/jquery.datetimepicker.css', __FILE__), array(), $this->version, 'all');


    }


    public function includes()
    {
        include_once('includes/wd_ads_admin_functions.php');


    }

    /**
     * create submenus
     */
    public static function wd_advertisement_sub()
    {

        add_submenu_page(
            'edit.php?post_type=wd_ads_ads',
            'Schedules',
            'Schedules',
            'manage_options',
            'wd_ads_schedules',
            array('wd_ads_admin', 'wd_ads_schedules')
        );
        add_submenu_page(
            'edit.php?post_type=wd_ads_ads',
            'Settings',
            'Settings',
            'manage_options',

            'wd_ads_settings',
            array('wd_ads_admin', 'wd_ads_settings')
        );

        add_submenu_page(
            null,
            'Stats',
            'Stats',
            'edit_stats_wd_ads_adverts',
            'wd_ads_stats',
            array('wd_ads_admin', 'wd_ads_stats')
        );

        add_submenu_page(
            'edit.php?post_type=wd_ads_ads',
            'Import',
            'Import',
            'manage_options',
            'wd_ads_import',
            array('wd_ads_admin', 'wd_ads_import')
        );


    }


    public static function wd_ads_schedules()
    {

        include_once('views/wd_ads_schedules.php');

    }

    public static function wd_ads_settings()
    {

        include_once('views/wd_ads_settings.php');

    }


    public static function wd_ads_import()
    {

        include_once('views/wd_ads_import.php');

    }


    public static function wd_ads_stats()
    {

        include_once('views/wd_ads_stats.php');


    }


    public static function get_instance()
    {
        if (null == self::$instance) {
            self::$instance = new self;
        }


        return self::$instance;
    }


}





