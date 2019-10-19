<?php
global $post;

$city_state = get_post_meta($post->ID, 'city_state', true);
$countries_meta = get_post_meta($post->ID, 'countries', true);





$countries = array(1 => 'United States', 2 => 'Australia', 3 => 'Germany', 4 => 'Brazil', 5 => 'Japan');






?>
<div class="wd_ads_for_pro_only_div">
	<label class="wd_ads_for_pro_only_section">Geo targeting is Available Only in PRO version</label>
</div>

<table>

    <tr>
        <td colspan="2">
            If you enable geo targeting by selecting a city, state or country below, make sure to choose a <b>Geo Service</b> from <b>Ad Manager WD > Settings > Geo targeting</b> tab.
        </td>

    </tr>
    <tr>
        <td>
            Cities/States:

        </td>
        <td>
            <textarea disabled name="wd_ads[city_state]" style="width:500px;height:50px"
                      placeholder="Amsterdam, Noord Holland, New York, California, Tokyo, London"><?php echo $city_state ?></textarea>
            <p class="description">Mention the list of cities (or the Metro ID) and states (or their ISO codes) to specify locations where this ad will display. Make sure to separate them by commas.</p>
        </td>

    </tr>

    <tr>
        <td>
            Countries:

        </td>
        <td>

            <?php echo wd_ads_countries_chechbox($countries_meta) ?>



        </td>

    </tr>

</table>

