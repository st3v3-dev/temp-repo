/*WD_ADS MAIN JS*/


jQuery(window).ready(function () {
    call_after_ajax_response()


    jQuery('[wd_ads_dynamic]').each(function () {

        var wd_ads_dynamic = jQuery(this).attr('wd_ads_dynamic').split(',');

        var refresh_time = wd_ads_dynamic[1];
        var group_id = wd_ads_dynamic[0];
        console.log(refresh_time);

        setInterval(function () {
            wd_ads_dynamic_group(group_id)
        }, refresh_time * 1000);

    })


})


function wd_ads_dynamic_group(group_id) {
    jQuery.ajax({
        url: wd_ads.ajax_url,
        data: {
            'action': 'wd_ads_change_advert',
            'group_id': group_id,
        },
        type: 'post',
        success: function (data) {

            /*jQuery('[wd_ads_group='+group_id+']').find('#wd_ads').html(jQuery(response).html());*/

            var vazgen = jQuery(data).find('#wd_ads').html();
            jQuery('[wd_ads_group=' + group_id + ']').find('#wd_ads').html(vazgen)

            call_after_ajax_response();
        }

    })
}


function call_after_ajax_response() {

    //////////////////Piwik Analytics Impression
    jQuery('[wd_ads_tracking_piwik]').each(function () {

        _paq.push(['trackEvent', 'Ad Manager WD', 'Impressions', jQuery(this).attr('wd_ads_tracking_piwik'), 1]);
    })


    //////////////////Google Analytics Impression
    jQuery('[wd_ads_tracking_analytics]').each(function () {

        ga('send', 'event', 'Ad Manager WD', 'Impressions', jQuery(this).attr('wd_ads_tracking_analytics'), 2, {'nonInteraction': 1});
    })

    /////////////////////internal tracker Impression
    jQuery('[wd_ads_tracking]').each(function () {

        jQuery.ajax({
            url: wd_ads.ajax_url,
            data: {
                'action': 'wd_ads_count_impressions',
                'post_id': jQuery(this).attr('wd_ads_tracking'),
                'wd_ads_nonce': wd_ads.ajaxnonce,
            },
            type: 'post',
            success: function (response) {
                console.log(response);
            }

        })

    })

    //////////////////Piwik Analytics Click
    jQuery('[wd_ads_tracking_piwik]').click(function () {

        _paq.push(['trackEvent', 'Ad Manager WD', 'Clicks', jQuery(this).attr('wd_ads_tracking_piwik'), 1]);
    })

    //////////////////Google Analytics Click
    jQuery('[wd_ads_tracking_analytics]').click(function () {


        ga('send', 'event', 'Ad Manager WD', 'Clicks', jQuery(this).attr('wd_ads_tracking_analytics'), 2, {'nonInteraction': 1});

    })


    /////////////////////internal tracker Click
    jQuery('[wd_ads_tracking]').click(function () {

        jQuery.ajax({
            url: wd_ads.ajax_url,
            data: {
                'action': 'wd_ads_count_clicks',
                'post_id': jQuery(this).attr('wd_ads_tracking'),
                'wd_ads_nonce': wd_ads.ajaxnonce,
            },
            type: 'post',
            success: function (response) {
                console.log(response);
            }

        })

    })

}



	
	
	
	

