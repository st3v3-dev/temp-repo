<?php 
if(!current_user_can('edit_stats_wd_ads_adverts'))
{
    wp_die('You dont have access');
}

$post_id=isset($_GET['post_id']) ? $_GET['post_id'] : wp_die('You dont have access');
$title = get_the_title($post_id);

////////////////
$year=isset($_POST['year']) ? $_POST['year'] : date('Y');
$month=isset($_POST['month']) ? $_POST['month'] : date('n');
////////////////////
$impressions=get_post_meta($post_id,'impressions',true);
$clicks=get_post_meta($post_id,'clicks',true);


$wd_ads_stats_from=isset($_POST['wd_ads_stats_from']) ? $_POST['wd_ads_stats_from'] : date('Y-m').'-01';
$wd_ads_stats_to=isset($_POST['wd_ads_stats_to']) ? $_POST['wd_ads_stats_to'] : date('Y-m-d');


$clicks_by_date=get_post_meta($post_id,'clicks_by_date',true);
$impressions_by_date=get_post_meta($post_id,'impressions_by_date',true);

$clicks_by_date=json_decode($clicks_by_date,true);
$impressions_by_date=json_decode($impressions_by_date,true);


if(!isset($clicks_by_date))
	$clicks_by_date=array();

if(!isset($impressions_by_date))
	$impressions_by_date=array();

$impression_dates=array_filter(array_keys($impressions_by_date),'wd_ads_filter_array_by_date');


$clicks_dates=array_filter(array_keys($clicks_by_date),'wd_ads_filter_array_by_date');



$this_month_impressions=array_filter(array_keys($impressions_by_date), function($value){
$year= date('Y');
$month=date('n');
if(substr($value,0,4)==$year AND (int)substr($value,5,2)==$month)
	return $value;
	
});

$this_month_clicks=array_filter(array_keys($clicks_by_date), function($value){
$year= date('Y');
$month=date('n');
if(substr($value,0,4)==$year AND (int)substr($value,5,2)==$month)
	return $value;
	
});



$last_month_impressions=array_filter(array_keys($impressions_by_date), function($value){
$year= date('Y');
$month=date('n')-1;
if(substr($value,0,4)==$year AND (int)substr($value,5,2)==$month)
	return $value;
	
});

$last_month_clicks=array_filter(array_keys($clicks_by_date), function($value){
$year= date('Y');
$month=date('n')-1;
if(substr($value,0,4)==$year AND (int)substr($value,5,2)==$month)
	return $value;
	
});



$this_month_impressions_sum=0;

foreach($this_month_impressions as $this_month_impression)
{
	
	$this_month_impressions_sum+=$impressions_by_date[$this_month_impression];
	

}
$this_month_clicks_sum=0;

foreach($this_month_clicks as $this_month_clicks)
{
	
	$this_month_clicks_sum+=$clicks_by_date[$this_month_clicks];
	

}

$last_month_impressions_sum=0;

foreach($last_month_impressions as $last_month_impression)
{
	
	$last_month_impressions_sum+=$impressions_by_date[$last_month_impression];
	

}

$last_month_clicks_sum=0;

foreach($last_month_clicks as $last_month_clicks)
{
	
	$last_month_clicks_sum+=$clicks_by_date[$last_month_clicks];
	

}




$dates=array_merge($impression_dates,$clicks_dates);

$dates=array_unique($dates);



$date_range_impressions=0;
$date_range_clicks=0;

foreach ($dates as $date)
{
	$date_range_impressions+=isset($impressions_by_date[$date]) ? $impressions_by_date[$date] : 0  ;
	$date_range_clicks+=isset($clicks_by_date[$date]) ? $clicks_by_date[$date] : 0  ;
	
}








?>

<form method="post" >



<div class="wd_ads_stats_nav">
From <input type="text" id="wd_ads_stats_from" name="wd_ads_stats_from" value="<?php echo $wd_ads_stats_from ?>"/> To
<input type="text" id="wd_ads_stats_to" name="wd_ads_stats_to" value="<?php echo $wd_ads_stats_to ?>"/>
<input onclick="" type="submit" value="submit" class='button button-primary button-large' />
</div>

<input type="hidden" id="export_scv" name="export_scv" />
    

<button onclick="wd_ads_export()" type="button" class='button button-primary button-large'> Export SCV </button>
</form>

<div class="wd_ads_stats_div">
<div class="wd_ads_table_div">
<h4>Selected Date Range Impressions</h4>
<span class="wd_ads_stats_click_impress"><?php echo $date_range_impressions ?></span>
</div>


<div  class="wd_ads_table_div">
<h4>Selected Date Range Clicks</h4>
<span  class="wd_ads_stats_click_impress"><?php echo $date_range_clicks ?></span>
</div>


<div  class="wd_ads_table_div">
<h4>Selected Date Range CTR</h4>
<span  class="wd_ads_stats_click_impress"><?php echo ($date_range_impressions!=0) ? round(($date_range_clicks/$date_range_impressions)*100,2) .'%' : 0; ?></span>
</div>
</div>



<div class="wd_ads_stats_div">

<div class="wd_ads_table_div">
<h4>Impressions (All)</h4>
<span class="wd_ads_stats_click_impress"><?php echo $impressions; ?></span>
</div>


<div  class="wd_ads_table_div">
<h4>Clicks (All)</h4>
<span  class="wd_ads_stats_click_impress"><?php echo $clicks; ?></span>
</div>

<div  class="wd_ads_table_div">
<h4>CTR (All)</h4>
<span  class="wd_ads_stats_click_impress"><?php echo $impressions!=0 ? round(($clicks/$impressions)*100,2) .'%' : 0;  ?></span>
</div>




</div>


<div class="wd_ads_stats_div">
<div class="wd_ads_table_div">
<h4>This Month Impressions</h4>
<span class="wd_ads_stats_click_impress"><?php echo $this_month_impressions_sum ?></span>
</div>


<div  class="wd_ads_table_div">
<h4>This Month Clicks</h4>
<span  class="wd_ads_stats_click_impress"><?php echo $this_month_clicks_sum ?></span>
</div>


<div  class="wd_ads_table_div">
<h4>This Month CTR</h4>
<span  class="wd_ads_stats_click_impress"><?php echo ($this_month_impressions_sum!=0) ? round(($this_month_clicks_sum/$this_month_impressions_sum)*100,2) .'%' : 0; ?></span>
</div>
</div>

<div class="wd_ads_stats_div">
<div class="wd_ads_table_div">
<h4>Last Month Impressions</h4>
<span class="wd_ads_stats_click_impress"><?php echo $last_month_impressions_sum ?></span>
</div>


<div  class="wd_ads_table_div">
<h4>Last Month Clicks</h4>
<span  class="wd_ads_stats_click_impress"><?php echo $last_month_clicks_sum ?></span>
</div>


<div  class="wd_ads_table_div">
<h4>Last Month CTR</h4>
<span  class="wd_ads_stats_click_impress"><?php echo ($last_month_impressions_sum!=0) ? round(($last_month_clicks_sum/$last_month_impressions_sum)*100,2) .'%' : 0; ?></span>
</div>
</div>




<script>
function wd_ads_export()
{
	var data={};
	data['dates']='<?php echo json_encode($dates) ?>';
	data['impressions_by_date']='<?php echo json_encode($impressions_by_date) ?>';
	data['clicks_by_date']='<?php echo json_encode($clicks_by_date) ?>';
	data['title']='<?php echo $title.'_stat' ?>';
	data['range']='<?php echo $wd_ads_stats_from.' to '.$wd_ads_stats_to ?>';
	jQuery.post(
		"edit.php?post_type=wd_ads_ads&export=export_csv",
		data
	).done(function(response){
		window.location.href="edit.php?post_type=wd_ads_ads&export=export_csv&path="+response;
	});

	return false;


}
</script>

    <?php
	
