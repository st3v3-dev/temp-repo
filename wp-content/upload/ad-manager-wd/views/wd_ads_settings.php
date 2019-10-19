<?php

/**
 * Admin page
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

global $wd_ads_settings;
global $wd_ads_tabs;

?>

<div class="wrap">
    <?php settings_errors(); ?>
    <div id="wd_ads-settings">
        <div id="wd_ads-settings-content">
            <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
            <h2 class="nav-tab-wrapper">
                <?php
                $current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general';
                foreach ($wd_ads_settings as $key => $wd_ads_setting) {
                    $active = $current_tab == $key ? 'nav-tab-active' : '';
                    echo '<a class="nav-tab ' . $active . '" href="?post_type=wd_ads_ads&page=wd_ads_settings&tab=' . $key . '">' . $wd_ads_tabs[$key] . '</a>';
                }
                ?>
            </h2>
            <form method="post" action="options.php">

                <?php
                settings_fields(WD_ADS_PLUGIN_PREFIX . '_settings_' . $current_tab);
                do_settings_sections(WD_ADS_PLUGIN_PREFIX . '_settings_' . $current_tab);

                ?>

                <?php submit_button(); ?>

                <script>

                    function wd_ads_show_hide_notifications(element, type) {

                        if (type == 'email') {
                            if (jQuery(element).attr('checked') == 'checked') {
                                jQuery('.email_address').parent().parent().css('display', '');
                            }
                            else {
                                jQuery('.email_address').parent().parent().css('display', 'none');
                            }
                        }

                        if (type == 'pushover') {
                            if (jQuery(element).attr('checked') == 'checked') {
                                jQuery('.pushover_notifications').parent().parent().css('display', '');
                            }
                            else {
                                jQuery('.pushover_notifications').parent().parent().css('display', 'none');
                            }
                        }


                    }



                    jQuery(window).ready(function () {
                        email = jQuery('input[id="wd_ads_settings_general[email_message]"]');
                        pushover = jQuery('input[id="wd_ads_settings_general[pushover]"]');
                        wd_ads_show_hide_notifications(email, 'email');
                        wd_ads_show_hide_notifications(pushover, 'pushover');

                    })
                </script>
            </form>
        </div>
        <!-- #wd_ads-settings-content -->
    </div>
    <!-- #wd_ads-settings -->
</div><!-- .wrap -->