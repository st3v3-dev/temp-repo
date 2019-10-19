<h1>Import Adverts</h1>

<form action="" method="post"  enctype="multipart/form-data">
    <input type="file" name="wd_ads_import" >
    <input type="submit" name="submit" value="Import" class="button button-primary button-large">
<p class="description">
    You can export your adverts from a website and import them to another.<br>


    Exporting can be done from <b>All Adverts</b> page. Select the adverts you wish to export, choose <b>Export JSON</b> from <b>Bulk Actions</b> and click <b>Export.</b><br>


    Afterwards choose the exported JSON file with these adverts and click <b>Import.</b><br>
</p>
</form>

<?php
include_once(WD_ADS_DIR . '/includes/wd_ads_json_import.php');
if(isset($_POST['submit'])) {
    $json = new wd_ads_import($_FILES['wd_ads_import'], 'json');

    $json->wd_ads_importToAds();

}
