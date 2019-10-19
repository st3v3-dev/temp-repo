<?php
global $post;

// $responsive = get_post_meta($post->ID,'responsive',true);
$sortorder = get_post_meta($post->ID, 'sortorder', true);
$weight = get_post_meta($post->ID, 'weight', true);
$show_on = get_post_meta($post->ID, 'show_on', true);
$enable_responsive = get_post_meta($post->ID, 'enable_responsive', true);
print_r(json_decode('',TRUE));

$img_phone = get_post_meta($post->ID, 'img_phone', true);
$img_tablet = get_post_meta($post->ID, 'img_tablet', true);

$resp_class="";

if ($enable_responsive == '')
    $enable_responsive = 0;

if($enable_responsive==0)
    $resp_class="wd_ads_hidden";

if ($weight == '')
    $weight = 3;

if ($sortorder == '')
    $sortorder = 0;


if (!$show_on) {
    $show_on = array();
} else {
    $show_on = json_decode($show_on, true);
}


?>

<div class="wd_ads_for_pro_only_div">
	<label class="wd_ads_for_pro_only_section">This Section is Available Only in PRO version</label>
</div>
<table>

    <tr>
        <td>
            Show on:
        </td>
        <td>
            <input disabled type="checkbox" id="computer" value='computer'
                   name="" <?php if (in_array('computer', $show_on)) echo 'checked' ?> />
            <label for='computer'>Desktops</label>

            <input disabled type="checkbox" id="smartphone" value='smartphone'
                   name="" <?php if (in_array('smartphone', $show_on)) echo 'checked' ?> />
            <label for='smartphone'>Smartphones</label>

            <input disabled type="checkbox" id="tablet" value='tablet'
                   name="" <?php if (in_array('tablet', $show_on)) echo 'checked' ?> />
            <label for='tablet'>Tablet</label>
            <p class="description">Choose device types where this advertisement will display. Leave all options unchecked if you want it to show on all devices.</p>
           </td>
    </tr>

    <tr>
        <td>
            Responsive
        </td>

        <td>

            <input disabled type="checkbox" id="enable_responsive" value='1'
                   name="" <?php checked($enable_responsive, 1) ?> />
            <label for='enable_responsive'>Enable Responsivesupport for this advert</label>
            <p class="description">Check to enable mobile responsiveness for this advertisement.</p>
        </td>

    </tr>

    <tr class="wd_ads_upload <?php echo $resp_class  ?>">
        <td>
            Image For Smartphones
        </td>

        <td>
            <input type="hidden" id="img_phone" name="wd_ads[img_phone]" value="<?php echo $img_phone ?>">
            <input id="upload-btn"  onclick="wd_ads_media_upload('#img_phone',event)"  type="button" value="Set image for smartphones"
                                                            class="button button-primary button-large">
        <p class="description">Click to select an image for this advertisement, which will display on smartphones.</p>

        </td>

    </tr>


    <tr class="wd_ads_upload <?php echo $resp_class  ?>">
        <td>
            Image For Tablets
        </td>

        <td>
            <input type="hidden" id="img_tablet" name="wd_ads[img_tablet]"  value="<?php echo $img_tablet ?>">
            <input type="button" onclick="wd_ads_media_upload('#img_tablet',event)" id="upload-btn" value="Set image For tablets"
                                                            class="button button-primary button-large">
            <p class="description">Click to select an image for this advertisement, which will display on tablets.</p>

        </td>

    </tr>

    <tr  class="wd_ads_upload <?php echo $resp_class  ?>">

        <td colspan="2">
            <div id="img_phone_container" class="wd_ads_td <?php if($img_phone=='') echo 'wd_ads_hidden' ?> ">
                <div><strong>For Smartphones</strong></div>
            <img style="max-width: 200px;" id="img_phone_preview" src="<?php echo $img_phone ?>" />
                <div><a href="#" onclick="wd_asd_remove_img('#img_phone');return false;">Remove Image</a></div>
            </div>
            <diV id="img_tablet_container" class="wd_ads_td  <?php if($img_tablet=='') echo 'wd_ads_hidden' ?> ">
                <div><strong>For Tablets</strong></div>
            <img style="max-width: 200px;" id="img_tablet_preview" src="<?php echo $img_tablet ?>" />
                <div><a href="#" onclick="wd_asd_remove_img('#img_tablet');return false;">Remove Image</a></div>
            </diV>
        </td>
    </tr>


    <td>
        Weight:

    </td>
    <td>
        <div>
            <input disabled type="radio" id="low" value='1' name="" <?php checked($weight, 1) ?> />
            <label for='low'>Barely visible</label>
        </div>
        <div>
            <input disabled type="radio" id="less" value='2' name="" <?php checked($weight, 2) ?> />
            <label for='less'>Less than average</label>
        </div>
        <div>
            <input disabled type="radio" id="normal" value='3' name="" <?php checked($weight, 3) ?> />
            <label for='normal'>Normal visibility</label>
        </div>
        <div>
            <input disabled type="radio" id="more" value='4' name="" <?php checked($weight, 4) ?> />
            <label for='more'>More than average</label>
        </div>
        <div>
            <input disabled type="radio" id="best" value='5' name="" <?php checked($weight, 5) ?> />
            <label for='best'>Best visibility</label>
        </div>

        <p class="description">Choose the weight for this advertisement. If an advert has a larger weight than others in the same group, it will appear in your ad section more often.</p>
    </td>

    </tr>

    <tr>
        <td>
            Sortorder:

        </td>
        <td>
            <input disabled type="text" id="sortorder" size="4" name="wd_ads[sortorder]" value='<?php echo $sortorder ?>'/>
            <label for='sortorder'>For administrative purposes set a sortorder. Leave empty or 0 to skip this. Will
                default to ad id.</label>

            <p class="description">Define the sortorder of this advertisement. This option is used for ordering of adverts in the same group displayed with Block type as its Mode. </p>

        </td>

    </tr>

</table>

