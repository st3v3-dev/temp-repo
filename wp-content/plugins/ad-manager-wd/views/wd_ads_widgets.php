<?php
/**
 * Widget functions / views
 *
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 *  Class functions for the SC widgets
 */
class WD_ADS_Widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
            false, $name = __('Ad Manager WD', 'wd_ads'), array('description' => __('Descr', 'ecwd'))
        );
    }

    function widget($args, $instance)
    {

        extract($args);
        //Output before widget stuff
        echo $before_widget;

        //Output title stuff
        $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
        $id = $instance['id'];

        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }

        echo do_shortcode('[wd_ads '.$id.']');

        //Output after widget stuff
        echo $after_widget;

    }

    function form($instance)
    {

        $type = WD_ADS_PLUGIN_PREFIX . '_ads';
        $args = array(
            'post_type' => $type,
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'ignore_sticky_posts' => 1,
            'numberposts'=>'-1'
        );
        $ads_posts = get_posts($args);

        $groups=$terms = get_terms('wd_ads_manage_groups') ;

        $title = (isset($instance['title'])) ? $instance['title'] : '';
        $ids = (isset($instance['id'])) ? $instance['id'] : '';




        ?>
        <style>
            .wd_ads_advert_option {
                font-weight:bold;
                color: black;
            }
        </style>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wd_ads'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('id'); ?>">
                <?php _e('Select Advert/Group', 'wd_ads'); ?>
            </label>
            <?php
            if ($ads_posts) { ?>
                <select id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>"
                        class="widefat">
                    <option class="wd_ads_advert_option" disabled>Groups</option>

                    <?php foreach ($groups as $group) {
                        ?>
                        <option
                            value="group=<?php echo $group->term_id; ?>" <?php selected($ids, 'group='.$group->term_id); ?>>--<?php echo $group->name; ?></option>
                    <?php } ?>
                    <option class="wd_ads_advert_option" disabled>Adverts</option>
                    <?php foreach ($ads_posts as $ad_post) {
                        ?>
                        <option
                            value="advert=<?php echo $ad_post->ID; ?>" <?php selected($ids, 'advert='.$ad_post->ID); ?>>--<?php echo $ad_post->post_title; ?></option>
                    <?php } ?>
                </select>
            <?php } ?>
        </p>

        <?php
    }


}


if (defined('WD_ADS_MAIN_FILE') && is_plugin_active(WD_ADS_MAIN_FILE)) {

    add_action('widgets_init', create_function('', 'register_widget("WD_ADS_Widget");'));
}


