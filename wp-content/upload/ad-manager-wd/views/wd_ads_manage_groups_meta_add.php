<?php
/////
/* ADD custom fields to wd_ads_manage_groups taxonomy    */
/////
$posts = get_posts(array('numberposts'=>'-1'));
$pages = get_pages();
$categories = get_categories(array('type' => 'post'));


?>
<div class="manage_groups_fields form-field">
    <label for="<?php echo $this->tax ?>[group_mode]"><?php echo __('Mode'); ?></label>
    <select name="<?php echo $this->tax ?>[group_mode]" id="<?php echo $this->tax ?>[group_mode]" onchange="wd_ads_change_group_mode(this.value)">
        <option value='1'><?php echo __('Default') ?></option>
        <option value='2'><?php echo __('Dynamic Mode') ?></option>
        <option value='3'><?php echo __('Block Mode') ?></option>
    </select>
<p class="description">Select the mode of this group. If you choose Default, your adverts will refresh upon reloading the page. Whereas Dynamic will randomly change them without refreshing, and Block mode will let you place a grid of a few adverts.</p>
</div>

<div class="manage_groups_fields form-field wd_ads_gmod_block" style="display: none">

    <label for="<?php echo $this->tax ?>[rows]"><?php echo __('Block Parameters'); ?></label>
    <input type="text" value="2" size="2" name="<?php echo $this->tax ?>[rows]"
           id="<?php echo $this->tax ?>[rows]"/><label class='wd_ads_check_label' for="<?php echo $this->tax ?>[rows]">Rows</label>


    <input type="text" value="2" size="2" name="<?php echo $this->tax ?>[columns]"
           id="<?php echo $this->tax ?>[columns]"/><label class='wd_ads_check_label'
                                                          for="<?php echo $this->tax ?>[columns]">Columns</label>

    <p class="description">Set the number of rows and columns for your advertisement block.</p>
</div>

<div class="manage_groups_fields form-field wd_ads_gmod_block" style="display: none">
    <label><?php echo __('Advert size'); ?></label>
    <input type="text" value="125" size="5" name="<?php echo $this->tax ?>[width]"/> Width
    <input type="text" value="125" size="5" name="<?php echo $this->tax ?>[height]"/> Height
    <p class="description">Provide values for width and height of ads in this group.</p>
</div>

<div class="manage_groups_fields form-field wd_ads_gmod_dynamic" style="display: none">
    <label for="<?php echo $this->tax ?>[auto_refresh]"><?php echo __('Auto Refresh Interval'); ?></label>
    <input type="text" value="60" size="5" name="<?php echo $this->tax ?>[auto_refresh]"
           id="<?php echo $this->tax ?>[auto_refresh]"/> sec
    <p class="description">Set the amount of time (in seconds), which will be indicated as the interval for refreshing dynamic ads.</p>
</div>

<h2>Advanced</h2>


<div class="manage_groups_fields form-field">
    <label for="<?php echo $this->tax ?>[ad_margin]"><?php echo __('Advert Margin'); ?></label>
    <input type="text" value="0px" style="width: 150px;" name="<?php echo $this->tax ?>[ad_margin]"
           id="<?php echo $this->tax ?>[ad_margin]"/>
    <p class="description">Provide a value for margins of your advertisement. For example, you can set it to 10px 0px to have margins from top and the bottom only.</p>
</div>

<div class="manage_groups_fields form-field">
    <label for="<?php echo $this->tax ?>[group_align]"><?php echo __('Align the group'); ?></label>
    <select name="<?php echo $this->tax ?>[group_align]" id="<?php echo $this->tax ?>[group_align]">
        <option value='none'><?php echo __('None') ?></option>
        <option value='left'><?php echo __('Left') ?></option>
        <option value='right'><?php echo __('Right') ?></option>
        <option value='center'><?php echo __('Center') ?></option>
    </select>
<p class="description">Select the alignment of this advertisement group: Left, Right or Center.</p>
</div>


<h2>Publishing</h2>
<p class="description">Choose the section of your website posts or pages, where the adverts of this group will be injected.</p>

<div class="manage_groups_fields form-field">
    <label for="<?php echo $this->tax ?>[placement]"><?php echo __('Placement'); ?></label>
    <div style="display:table-cell">
        <select name="<?php echo $this->tax ?>[placement]">
            <option value="before">Before Content</option>
            <option value="after">After Content</option>
            <option value="before_after">Before And After Content</option>
            <option value="inside">Inside The Content</option>
        </select>
    </div>
    <div style="display:table-cell">
        After <input type="text" size="1" value="" name="<?php echo $this->tax ?>[inside_content]"/> th paragraph

    </div>
<p class="description">Select the section of a post or page, where the advertisement will be displayed.</p>
</div>

<!-- CATEGORIES -->

<div class="manage_groups_fields form-field">
    <label for="<?php echo $this->tax ?>[show_in_cats]"><?php echo __('Show in categories'); ?></label>
    <input type="checkbox"  onchange="wd_ads_toggle('#show_in_cats','#wd_ads_categories')"  id="show_in_cats" name="<?php echo $this->tax ?>[show_in_cats]"
           value='1'/>
    <label class='wd_ads_check_label' for='show_in_cats'>Show Group in Categories</label>

</div>

<div id="wd_ads_categories" class="manage_groups_fields form-field wd_ads_hidden">
    <label for="<?php echo $this->tax ?>[categories]"><?php echo __('Categories'); ?></label>




    <select multiple name="<?php echo $this->tax ?>[categories][]" class="wd_ads_posts wd_ads_all_categories">
        <option onclick="wd_ads_select_all('categories')" value="all" >All Categories</option>

        <?php foreach ($categories as $item) { ?>
            <option value="<?php echo $item->term_id ?>" >

                <?php echo $item->name ?>
            </option>
        <?php } ?>
    </select>


    <p class="description">Select categories to display the ad in their pages.</p>
</div>


<!-- POSTS -->

<div class="manage_groups_fields form-field">
    <label for="<?php echo $this->tax ?>[show_in_posts]"><?php echo __('Show in posts'); ?></label>
    <input type="checkbox"  onchange="wd_ads_toggle('#show_in_posts','#wd_ads_posts')"   id="show_in_posts" name="<?php echo $this->tax ?>[show_in_posts]"
           value='1'/>
    <label class='wd_ads_check_label' for='show_in_posts'>Show Group in post</label>

</div>

<div id="wd_ads_posts" class="manage_groups_fields form-field wd_ads_hidden">
    <label for="<?php echo $this->tax ?>[posts]"><?php echo __('Posts'); ?></label>




    <select multiple name="<?php echo $this->tax ?>[posts][]" class="wd_ads_posts wd_ads_all_posts">
        <option onclick="wd_ads_select_all('posts')" value="all" >All Posts</option>

        <?php foreach($posts as $item) {?>
            <option value="<?php echo $item->ID ?>" >
                <?php echo $item->post_title ?>
            </option>
        <?php } ?>

    </select>



    <p class="description">Choose posts, where you wish to have this advertisement displayed.</p>
</div>

<div class="manage_groups_fields form-field">
    <label for="<?php echo $this->tax ?>[show_in_pages]"><?php echo __('Show in pages'); ?></label>
    <input type="checkbox"  onchange="wd_ads_toggle('#show_in_pages','#wd_ads_pages')"   id="show_in_pages" name="<?php echo $this->tax ?>[show_in_pages]"
           value='1'/>
    <label class='wd_ads_check_label' for='show_in_pages'>Show Group in Page</label>

</div>


<!-- PAGES -->


<div id="wd_ads_pages" class="manage_groups_fields form-field wd_ads_hidden">
    <label for="<?php echo $this->tax ?>[pages]"><?php echo __('Pages'); ?></label>




    <select multiple name="<?php echo $this->tax ?>[pages][]" class="wd_ads_posts wd_ads_all_pages">
        <option onclick="wd_ads_select_all('pages')" value="all" >All Pages</option>

        <?php foreach($pages as $page) {?>
            <option value="<?php echo $page->ID ?>" >
                <?php echo $page->post_title ?>
            </option>
        <?php } ?>

    </select>

    <p class="description">Select pages, where you wish to have this advertisement displayed.</p>

</div>


			

	
	