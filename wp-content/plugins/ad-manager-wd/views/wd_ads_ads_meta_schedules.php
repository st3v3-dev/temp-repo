<?php
global $post;

$schedule_id=0;
$use_schedule      = get_post_meta( $post->ID, 'use_schedule', true );
if($use_schedule=='')
{
	$use_schedule=0;
}

$schedule    = get_post_meta( $post->ID, 'schedule', true );

if($schedule!='') {

	$schedule_id = json_decode( $schedule, true );

	if(is_array($schedule_id)) {
		$schedule_id = array_keys( $schedule_id );
		$schedule_id = $schedule_id[0];
	}
}


$start_date      = get_post_meta( $schedule_id, 'start_date', true );
$end_date        = get_post_meta( $schedule_id, 'end_date', true );
$max_clicks      = get_post_meta( $schedule_id, 'max_clicks', true );
$max_impressions = get_post_meta( $schedule_id, 'max_impressions', true );


if ( $start_date == '' ) {
	$start_date = mktime( 0, 0, 0, date( 'n' ), date( 'd' ), date( 'Y' ) );
}

if ( $end_date == '' ) {
	$end_date = $start_date + ( 30 * 24 * 60 * 60 );
}

$start_date = date( 'Y-m-d H:i', $start_date );
$end_date   = date( 'Y-m-d H:i', $end_date );


if ( $max_clicks == '' ) {
	$max_clicks = 0;
}

if ( $max_impressions == '' ) {
	$max_impressions = 0;
}


?>
<table>
	<tr>
		<td>
			Use schedule for this advert
		</td>
		<td>


			<input id="wd_ads_toggle_schedule" type="checkbox" name="wd_ads[use_schedule]" size="1"
			       value="1" <?php checked($use_schedule,1) ?>/>

		</td>
		<td></td>

	</tr>
	<tr class="wd_ads_toggle_schedule <?php echo $use_schedule==0 ? 'wd_ads_hidden' : ''  ?>">
		<td>
			From
		</td>
		<td>
			<input title="Start date" type="text" id="wd_ads_schedules_from" name="wd_ads_schedules[start_date]"
			       value="<?php echo $start_date ?>"/>
		</td>


		<td>
			to
		</td>
		<td>
			<input title="End date" type="text" id="wd_ads_schedules_to" name="wd_ads_schedules[end_date]"
			       value="<?php echo $end_date ?>"/>

		</td>


	</tr>
	<tr  class="wd_ads_toggle_schedule <?php echo $use_schedule==0 ? 'wd_ads_hidden' : ''  ?>">
		<td>
			Maximum Clicks
		</td>
		<td>


			<input type="text" name="wd_ads_schedules[max_clicks]" size="1" value="<?php echo $max_clicks ?>"/>


		</td>
		<td></td>

	</tr>

	<tr  class="wd_ads_toggle_schedule <?php echo $use_schedule==0 ? 'wd_ads_hidden' : ''  ?>">
		<td>
			Maximum Impressions
		</td>
		<td>


			<input type="text" name="wd_ads_schedules[max_impressions]" size="1"
			       value="<?php echo $max_impressions ?>"/>

		</td>
		<td></td>

	</tr>


</table>
<p class="descritpion wd_ads_toggle_schedule <?php echo $use_schedule==0 ? 'wd_ads_hidden' : ''  ?>">You can have one schedule with limited options for each advert in the free version of the plugin. Upgrade to <b>Ad Manager WD Pro</b> to add unlimited number of schedules with more comprehensive settings.</p>
