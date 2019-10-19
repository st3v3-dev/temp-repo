<?php
 global $post;

    $wrapper_before = get_post_meta($post->ID,'wrapper_before',true);
    $wrapper_after = get_post_meta($post->ID,'wrapper_after',true);
    
	


?>

<table>



	<tr>
		<td>
		Before Advert:

		</td>
		<td>
		
<textarea name="wd_ads[wrapper_before]"><?php echo $wrapper_before ?></textarea>
<p class="description">This code will be added just before advertisement block. You can have HTML content or custom Javascript code written here.</p>
		
		
			
		</td>

	</tr>
	<tr>
		<td>
		After Advert:

		</td>
		<td>
		
<textarea name="wd_ads[wrapper_after]"><?php echo $wrapper_after ?></textarea>
<p class="description">This code will be added after advertisement block. You can have HTML content or custom Javascript code written here.</p>
		
			
		</td>

	</tr>
	
	

</table>

