<?php
/////
/* EDIT custom fields to wd_ads_manage_groups taxonomy    */
/////

// put the term ID into a variable
$t_id = $term->term_id;

// retrieve the existing value(s) for this meta field. This returns an array
$term_meta = get_option("{$this->tax}_$t_id");

$posts_meta = json_decode($term_meta['posts'], true);
$pages_meta = json_decode($term_meta['pages'], true);
$categories_meta = json_decode($term_meta['categories'], true);

$posts = get_posts(array('numberposts'=>'-1'));
$pages = get_pages();
$categories = get_categories(array('type' => 'post'));

?>


<tr class="form-field manage_groups_fields">
    <th scope="row" valign="top">
        <label for="<?php echo $this->tax ?>[group_mode]"><?php echo __('Mode'); ?></label>
    </th>
    <td>

        <select name="<?php echo $this->tax ?>[group_mode]" id="<?php echo $this->tax ?>[group_mode]" onchange="wd_ads_change_group_mode(this.value)">
            <option value='1' <?php selected($term_meta['group_mode'], 1) ?> ><?php echo __('Default') ?></option>
            <option value='2' <?php selected($term_meta['group_mode'], 2) ?> ><?php echo __('Dynamic Mode') ?></option>
            <option value='3' <?php selected($term_meta['group_mode'], 3) ?> ><?php echo __('Block Mode') ?></option>
        </select>

        <p class="description">Select the mode of this group. If you choose Default, your adverts will refresh upon reloading the page. Whereas Dynamic will randomly change them without refreshing, and Block mode will let you place a grid of a few adverts.</p>

    </td>
</tr>

<tr class="form-field manage_groups_fields wd_ads_gmod_block">
    <th scope="row" valign="top">
        <label for=""><?php echo __('Advert size'); ?></label>
    </th>
    <td>

        <input type="text" size="5" name="<?php echo $this->tax ?>[width]" value="<?php echo $term_meta['width'] ?>"/>
        Width
        <input type="text" size="5" name="<?php echo $this->tax ?>[height]" value="<?php echo $term_meta['height'] ?>"/>
        Height

        <p class="description">Provide values for width and height of ads in this group.</p>

    </td>
</tr>

<tr class="form-field manage_groups_fields wd_ads_gmod_block">
    <th scope="row" valign="top">
        <label for=""><?php echo __('Block Parameters'); ?></label>
    </th>
    <td>

        <input type="text" size="5" name="<?php echo $this->tax ?>[rows]" value="<?php echo $term_meta['rows'] ?>"/>
        rows
        <input type="text" size="5" name="<?php echo $this->tax ?>[columns]"
               value="<?php echo $term_meta['columns'] ?>"/> columns

        <p class="description">Set the number of rows and columns for your advertisement block.</p>

    </td>
</tr>


<tr class="form-field manage_groups_fields wd_ads_gmod_dynamic">
    <th scope="row" valign="top">
        <label for="<?php echo $this->tax ?>[auto_refresh]"><?php echo __('Auto Refresh Interval'); ?></label>
    </th>
    <td>

        <input type="text" value="<?php echo $term_meta['auto_refresh'] ?>" size="5"
               name="<?php echo $this->tax ?>[auto_refresh]" id="<?php echo $this->tax ?>[auto_refresh]"/> sec

        <p class="description">Set the amount of time (in seconds), which will be indicated as the interval for refreshing dynamic ads.</p>

    </td>
</tr>

<tr class="form-field manage_groups_fields">
    <th scope="row" valign="top">
        <label for="<?php echo $this->tax ?>[ad_margin]"><?php echo __('Advert Margin'); ?></label>
    </th>
    <td>

        <input type="text" value="<?php echo $term_meta['ad_margin'] ?>" style="width:150px;"
               name="<?php echo $this->tax ?>[ad_margin]" id="<?php echo $this->tax ?>[ad_margin]"/>

        <p class="description">Provide a value for margins of your advertisement. For example, you can set it to 10px 0px to have margins from top and the bottom only.</p>

    </td>
</tr>

<tr class="form-field manage_groups_fields">
    <th scope="row" valign="top">
        <label for="<?php echo $this->tax ?>[group_align]"><?php echo __('Align the group'); ?></label>
    </th>
    <td>

        <select name="<?php echo $this->tax ?>[group_align]" id="<?php echo $this->tax ?>[group_align]">
            <option value='none' <?php selected($term_meta['group_align'], 'none') ?> ><?php echo __('None') ?></option>
            <option value='left' <?php selected($term_meta['group_align'], 'left') ?> ><?php echo __('Left') ?></option>
            <option
                value='right' <?php selected($term_meta['group_align'], 'right') ?> ><?php echo __('Right') ?></option>
            <option
                value='center' <?php selected($term_meta['group_align'], 'center') ?> ><?php echo __('Center') ?></option>
        </select>
        <p class="description">Select the alignment of this advertisement group: Left, Right or Center.</p>


    </td>
</tr>


<tr class="form-field manage_groups_fields">
    <th scope="row" valign="top">
        <label for="<?php echo $this->tax ?>[placement]"><?php echo __('Placement'); ?></label>
    </th>
    <td>

        <div style="display:table-cell">
            <select name="<?php echo $this->tax ?>[placement]">
                <option value="before" <?php selected($term_meta['placement'], 'before') ?> >Before Content</option>
                <option value="after" <?php selected($term_meta['placement'], 'after') ?> >After Content</option>
                <option value="before_after" <?php selected($term_meta['placement'], 'before_after') ?>>Before And After
                    Content
                </option>
                <option value="inside" <?php selected($term_meta['placement'], 'inside') ?>>Inside The Content</option>
            </select>
        </div>
        <div style="display:table-cell">
            After <input type="text" size="1" value="<?php echo $term_meta['inside_content'] ?>"
                         name="<?php echo $this->tax ?>[inside_content]"/> th paragraph

        </div>
        <p class="description">Select the section of a post or page, where the advertisement will be displayed.</p>

    </td>
</tr>


<tr class="form-field manage_groups_fields">
    <th scope="row" valign="top">
        <label for="<?php echo $this->tax ?>[show_in_cats]"><?php echo __('Show in Categories'); ?></label>
    </th>
    <td>

        <input type="checkbox" name="<?php echo $this->tax ?>[show_in_cats]" onchange="wd_ads_toggle('#show_in_cats','#wd_ads_categories')"    id="show_in_cats"
               value='1' <?php checked($term_meta['show_in_cats'], 1) ?> />
        <label class='wd_ads_check_label' for="show_in_cats">Show Group in category</label>


    </td>
</tr>


<tr id="wd_ads_categories" class="form-field manage_groups_fields <?php echo wd_ads_check_hidden($term_meta['show_in_cats'],0) ?>">
    <th scope="row" valign="top">
        <label for="<?php echo $this->tax ?>[categories]"><?php echo __('Categories'); ?></label>
    </th>
    <td>


        <select multiple name="<?php echo $this->tax ?>[categories][]" class="wd_ads_posts wd_ads_all_categories">
            <option onclick="wd_ads_select_all('categories')" value="all" <?php if(is_array($categories_meta) && in_array('all',$categories_meta)) echo 'selected' ?>>All Categories</option>

            <?php foreach ($categories as $item) { ?>
            <option value="<?php echo $item->term_id ?>" <?php if(is_array($categories_meta) && in_array($item->term_id,$categories_meta)) echo 'selected' ?>>

                <?php echo $item->name ?>
            </option>
        <?php } ?>
</select>
        <p class="description">Select categories to display the ad in their pages.</p>

    </td>
</tr>


<tr class="form-field manage_groups_fields">
    <th scope="row" valign="top">
        <label for="<?php echo $this->tax ?>[show_in_posts]"><?php echo __('Show in posts'); ?></label>
    </th>
    <td>

        <input type="checkbox" onchange="wd_ads_toggle('#show_in_posts','#wd_ads_posts')"   name="<?php echo $this->tax ?>[show_in_posts]"
               id="show_in_posts"
               value='1' <?php if (isset($term_meta['show_in_posts'])) checked($term_meta['show_in_posts'], 1) ?> />
        <label class='wd_ads_check_label' for="show_in_posts">Show Group in post</label>


    </td>
</tr>

<tr id="wd_ads_posts" class="form-field manage_groups_fields <?php echo wd_ads_check_hidden($term_meta['show_in_posts'],0) ?>">
    <th scope="row" valign="top">
        <label for="<?php echo $this->tax ?>[posts]"><?php echo __('Posts'); ?></label>
    </th>
    <td>




        <select multiple name="<?php echo $this->tax ?>[posts][]" class="wd_ads_posts wd_ads_all_posts">
            <option onclick="wd_ads_select_all('posts')" value="all" <?php if(is_array($posts_meta) && in_array('all',$posts_meta)) echo 'selected' ?>>All Posts</option>

            <?php foreach($posts as $item) {?>
                <option value="<?php echo $item->ID ?>" <?php if(is_array($posts_meta) && in_array($item->ID,$posts_meta)) echo 'selected' ?>>
                    <?php echo $item->post_title ?>
                </option>
            <?php } ?>

        </select>



        <p class="description">Choose posts, where you wish to have this advertisement displayed.</p>


    </td>
</tr>

<tr class="form-field manage_groups_fields">
    <th scope="row" valign="top">
        <label for="<?php echo $this->tax ?>[show_in_pages]"><?php echo __('Show in pages'); ?></label>
    </th>
    <td>

        <input type="checkbox"  onchange="wd_ads_toggle('#show_in_pages','#wd_ads_pages')" name="<?php echo $this->tax ?>[show_in_pages]"
               id="show_in_pages"
               value='1' <?php if (isset($term_meta['show_in_pages'])) checked($term_meta['show_in_pages'], 1) ?> />
        <label class='wd_ads_check_label' for="show_in_pages">Show Group in Page</label>


    </td>
</tr>


<tr id="wd_ads_pages" class="form-field manage_groups_fields  <?php echo wd_ads_check_hidden($term_meta['show_in_pages'],0) ?>">
    <th scope="row" valign="top">
        <label for="<?php echo $this->tax ?>[pages]"><?php echo __('Pages'); ?></label>
    </th>
    <td>



        <select multiple name="<?php echo $this->tax ?>[pages][]" class="wd_ads_posts wd_ads_all_pages">
            <option onclick="wd_ads_select_all('pages')" value="all" <?php if(is_array($pages_meta) && in_array('all',$pages_meta)) echo 'selected' ?>>All Pages</option>

            <?php foreach($pages as $page) {?>
                <option value="<?php echo $page->ID ?>" <?php if(is_array($pages_meta) && in_array($page->ID,$pages_meta)) echo 'selected' ?>>
                    <?php echo $page->post_title ?>
                </option>
            <?php } ?>

        </select>


        <p class="description">Select pages, where you wish to have this advertisement displayed.</p>

    </td>
</tr>
<script>
    wd_ads_change_group_mode('<?php echo $term_meta['group_mode']  ?>')

</script>