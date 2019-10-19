/*WD_ADS ADMIN MAIN JS*/

function wd_ads_check_all_items(id,element) {
    if(jQuery(element)[0].checked)
    {
        jQuery('[id^="'+id+'"]').attr('checked', 'checked');
    }
    else {

        jQuery('[id^="'+id+'"]').removeAttr('checked');

    }
}



function wd_ads_select_continent(continent) {
    if (jQuery('#' + continent)[0].checked) {
        jQuery('.' + continent).attr('checked', 'checked');
    }
    else {

        jQuery('.' + continent).removeAttr('checked');

    }
}


function wd_ads_select_continent_all() {
    var continents = ['EUROPE', 'SOUTHEASTASIA', 'NORTHAMERICA', 'SOUTHAMERICA', 'MISC'];
    if (jQuery('#all')[0].checked) {
        jQuery(continents).each(function () {
            jQuery('#' + this).attr('checked', 'checked');
            wd_ads_select_continent(this)
        })


    }
    else {


        jQuery(continents).each(function () {
            jQuery('#' + this).removeAttr('checked');
            wd_ads_select_continent(this)
        })

    }
}

function wd_ads_media_upload(input_id, e) {

    e.preventDefault();
    var image = wp.media({
        title: 'Upload Image',
        // mutiple: true if you want to upload multiple files at once
        multiple: false
    }).open()
        .on('select', function (e) {
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
            console.log(uploaded_image);
            var image_url = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
            jQuery(input_id).val(image_url);
            jQuery(input_id + "_preview").attr('src', image_url);
            jQuery(input_id + "_container").removeClass('wd_ads_hidden');

        });


}


function wd_asd_remove_img(id) {


    jQuery(id+"_preview").attr('src','');
    jQuery(id+"_container").addClass('wd_ads_hidden');
    jQuery(id).val('');
}


function wd_ads_toggle(check_id,toggle_id) {

    if (!jQuery(check_id).attr('checked')) {
        jQuery(toggle_id).addClass('wd_ads_hidden')

    }
    else{
        jQuery(toggle_id).removeClass('wd_ads_hidden')

    }

}





jQuery(document).ready(function () {

    jQuery('#enable_responsive').change(function () {
        if (!jQuery('#enable_responsive').attr('checked'))
            jQuery('.wd_ads_upload').addClass('wd_ads_hidden')
        else
            jQuery('.wd_ads_upload').removeClass('wd_ads_hidden')

    })


})


function wd_ads_change_group_mode(val) {
    jQuery('.wd_ads_gmod_dynamic').hide();
    jQuery('.wd_ads_gmod_block').hide();


    if(val==3)
    {
        jQuery('.wd_ads_gmod_block').show();

    }

    if(val==2)
    {
        jQuery('.wd_ads_gmod_dynamic').show();


    }

}

jQuery(document).on('change','#wd_ads_toggle_schedule',function(){
    if(!jQuery(this)[0].checked)
    {
        jQuery('.wd_ads_toggle_schedule').addClass('wd_ads_hidden');
    }
    else
    {
        jQuery('.wd_ads_toggle_schedule').removeClass('wd_ads_hidden');
    }
});

function wd_ads_select_all(class_name)
{
    if(jQuery('.wd_ads_all_'+class_name+' option')[0].selected)
    {
        jQuery('.wd_ads_all_'+class_name+' option').prop('selected',true)
    }
}