<?php
 global $post;

    $show_in_posts = get_post_meta($post->ID,'show_in_posts',true);
    $show_in_pages = get_post_meta($post->ID,'show_in_pages',true);
    $show_in_cats = get_post_meta($post->ID,'show_in_cats',true);
    $posts_meta = get_post_meta($post->ID,'posts',true);
    $pages_meta = get_post_meta($post->ID,'pages',true);

	$categories_meta = get_post_meta($post->ID,'categories',true);


	$inside_content = get_post_meta($post->ID,'inside_content',true);
    $placement = get_post_meta($post->ID,'placement',true);

$posts_meta=json_decode($posts_meta, true) ;
$pages_meta=json_decode($pages_meta, true) ;
$categories_meta=json_decode($categories_meta, true) ;

$posts=get_posts(array('numberposts'=>'-1'));
$pages=get_pages();
$categories = get_categories(array('type'=>'post'));



?>

<table>



	<tr>
		<td>
		Placement:

		</td>
		<td>


		<div style="display:table-cell">
		<select name="wd_ads[placement]">
		<option value="before" <?php selected($placement,'before') ?>>Before Content</option>
		<option value="after" <?php selected($placement,'after') ?>>After Content</option>
		<option value="before_after" <?php selected($placement,'before_after') ?>>Before And After Content</option>
		<option value="inside" <?php selected($placement,'inside') ?>>Inside The Content</option>
		</select>

		</div>
		<div style="display:table-cell">
		After <input type="text" size="1" value="<?php echo $inside_content ?>" name="wd_ads[inside_content]" /> th paragraph

		</div>

			<p class="description">Select the section of a post or page, where the advertisement will be displayed.</p>

		</td>

	</tr>

	<tr>
		<td>
		Show Advert in categories:

		</td>
		<td>


		<div>
		<input type="checkbox" onchange="wd_ads_toggle('#show_in_cats','#wd_ads_categories')" id="show_in_cats" name="wd_ads[show_in_cats]" value='1' <?php checked($show_in_cats, '1') ?> />
		<label for='show_in_cats'>Show Advert in category</label>
		</div>




		</td>

	</tr>

	<tr id="wd_ads_categories" class="<?php echo wd_ads_check_hidden($show_in_cats,0) ?>">
		<td>
		Categories:

		</td>
		<td>


		<div class="wd_ads_posts">



            <select multiple name="wd_ads[categories][]" class="wd_ads_posts wd_ads_all_categories">
	            <option onclick="wd_ads_select_all('categories')" value="all" <?php if(is_array($categories_meta) && in_array('all',$categories_meta)) echo 'selected' ?>>All Categories</option>
                <?php foreach($categories as $item) {?>
                    <option value="<?php echo $item->term_id ?>" <?php if(is_array($categories_meta) && in_array($item->term_id,$categories_meta)) echo 'selected' ?>>
                        <?php echo $item->name ?>
                    </option>
                <?php } ?>

            </select>


        </div>






		<p class="description">Select categories to display the ad in their pages.</p>

		</td>

	</tr>



<tr>
		<td>
		Show Advert in posts:

		</td>
		<td>


		<div>
		<input type="checkbox"  onchange="wd_ads_toggle('#show_in_posts','#wd_ads_posts')"  id="show_in_posts" name="wd_ads[show_in_posts]" value='1' <?php checked($show_in_posts, '1') ?> />
		<label for='show_in_posts'>Show Advert in post</label>
		</div>




		</td>

	</tr>


	<tr id="wd_ads_posts"  class="<?php echo wd_ads_check_hidden($show_in_posts,0) ?>">
		<td>
		Posts:

		</td>
		<td>


		<div class="">


<select multiple name="wd_ads[posts][]" class="wd_ads_posts wd_ads_all_posts">
	<option onclick="wd_ads_select_all('posts')" value="all" <?php if(is_array($posts_meta) && in_array('all',$posts_meta)) echo 'selected' ?>>All Posts</option>
			<?php foreach($posts as $item) {?>
				<option value="<?php echo $item->ID ?>" <?php if(is_array($posts_meta) && in_array($item->ID,$posts_meta)) echo 'selected' ?>>
					<?php echo $item->post_title ?>
				</option>
			<?php } ?>

</select>
		</div>


		<p class="description">Choose posts, where you wish to have this advertisement displayed.</p>

		</td>

	</tr>

	<tr>
		<td>
		Show Advert in pages:

		</td>
		<td>


		<div>
		<input type="checkbox" id="show_in_pages"  onchange="wd_ads_toggle('#show_in_pages','#wd_ads_pages')"  name="wd_ads[show_in_pages]" value='1' <?php checked($show_in_pages, '1') ?> />
		<label for='show_in_pages'>Show Advert in pages</label>
		</div>




		</td>

	</tr>

	<tr  id="wd_ads_pages"  class="<?php echo wd_ads_check_hidden($show_in_pages,0) ?>">
		<td>
		Pages:

		</td>
		<td>


			<div>




		<select multiple name="wd_ads[pages][]" class="wd_ads_posts wd_ads_all_pages">
			<option onclick="wd_ads_select_all('pages')" value="all" <?php if(is_array($pages_meta) && in_array('all',$pages_meta)) echo 'selected' ?>>All Pages</option>

			<?php foreach($pages as $page) {?>
			<option value="<?php echo $page->ID ?>" <?php if(is_array($pages_meta) && in_array($page->ID,$pages_meta)) echo 'selected' ?>>
				<?php echo $page->post_title ?>
			</option>
		<?php } ?>

</select>


			</div>


		<p class="description">Choose pages, where you wish to have this advertisement displayed.</p>

		</td>

	</tr>

</table>

<script>


	jQuery(window).ready(function () {
		wd_ads_select_all('posts')
		wd_ads_select_all('pages')
		wd_ads_select_all('categories')
	})
</script>

