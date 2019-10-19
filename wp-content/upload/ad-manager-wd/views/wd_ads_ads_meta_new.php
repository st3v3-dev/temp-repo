<?php
 global $post;

    $area_code = get_post_meta($post->ID,'area_code',true);
    $Statistics = get_post_meta($post->ID,'statistics',true);
    //$published = get_post_meta($post->ID,'published',true);
	
	
	$banner_asset=wp_get_attachment_url(get_post_thumbnail_id($post->ID));
	$advert_title=get_the_title( $post->ID );
	
	$preview=str_replace('%featured_image%',$banner_asset,$area_code) ;
	$preview=str_replace('%title%',$advert_title,$preview) ;
	


?>

<table>

	<tr>
		<td>
		Ad Code:

		</td>
		<td>
			<textarea name='wd_ads[area_code]' id="area_code" style="width:300px;height:100px"><?php echo $area_code   ?></textarea>
			<p class="description">Provide any code for the advertisement, e.g. AdSense code. The following example contains an image in the ad:<br>
				<?php echo htmlspecialchars('<img src="https://example.com/full_image_url">') ?></p>
		</td>
		
	</tr>

	<tr>
		<td>
		Useful tags: 

		</td>
		<td>
		<span class="wd_ads_tags" onclick ="wd_ads_insert_tag('area_code',this.innerHTML)">%featured_image%</span>,
		<span class="wd_ads_tags" onclick ="wd_ads_insert_tag('area_code',this.innerHTML)">%title%</span>,
		<span class="wd_ads_tags" onclick ="wd_ads_insert_tag('area_code',this.innerHTML)">target="_blank"</span>,
		<span class="wd_ads_tags" onclick ="wd_ads_insert_tag('area_code',this.innerHTML)">rel="nofollow"</span>,
			<p class="description">Click on on a tag to add them to your advertisement code. Place target="_blank" attribute to your link, or use %featured_image% as the value of src attribute in <?php echo htmlspecialchars('<img>') ?> tag.</p>
		</td>
	</tr>
	<tr>

		<td>
		Preview:

		</td>
		<td>
			<?php echo $preview  ?>

		</td>
	</tr>
	<tr>

		<td>
		Statistics:

		</td>
		<td>
			<input type="checkbox" id="statistics" name="wd_ads[statistics]" value='1' <?php checked($Statistics, '1') ?> />
			<label for='statistics'>Enable click and impression tracking for this advert. </label>
	<p class="description">Enable tracking of impressions and clicks for this advertisement.</p>
		</td>
	</tr>
	
</table>

<script>
function wd_ads_insert_tag(myField, myValue) {
myField=document.getElementById(myField);
//IE support
if (document.selection) {
myField.focus();
sel = document.selection.createRange();
sel.text = myValue;
}
//MOZILLA/NETSCAPE support
else 
if (myField.selectionStart || myField.selectionStart == '0') {

var startPos = myField.selectionStart;
var endPos = myField.selectionEnd;
myField.value = myField.value.substring(0, startPos)
+ myValue
+ myField.value.substring(endPos, myField.value.length);
} else {
myField.value += myValue;
}
}
</script>