<?php

include("freader/reader.php");



$excel = new Spreadsheet_Excel_Reader();







if($_POST["submit"])

{

	if ($_FILES["file"])

	{

		$uploadpath = "../wp-content/plugins/baggage_shipping/upload/".time()."_".$_FILES["file"]["name"];

		move_uploaded_file($_FILES["file"]["tmp_name"],$uploadpath);

	

		$excel->read($uploadpath);

		

		$x=1;

		

		while($x<=$excel->sheets[0]['numRows']) {

		

		if($x>1)

		{

		

		  $y=1;



		  while($y<=$excel->sheets[0]['numCols']) {

			$cell = isset($excel->sheets[0]['cells'][$x][$y]) ? $excel->sheets[0]['cells'][$x][$y] : '';

			

			if($y==1)

			{

			   $sku = $cell;

			}

			else if($y==2)

			{

			   $length = $cell;

			}

			else if($y==3)

			{

			   $width = $cell;

			}

			else if($y==4)

			{

			   $height = $cell;

			}

			else if($y==5)

			{

			   $weight = $cell;

			}



			$y++;

		  } 

		  

		   $sqldel = "delete from baggage_excel where SKU='".$sku."'";

		   mysql_query($sqldel);

		  

		  $insert_sql = "insert into baggage_excel(SKU,Weight,Height,Width,Length)"; 

		  $insert_sql = $insert_sql." values('".$sku."','".$weight."','".$height."','".$width."','".$length."')"; 

		  mysql_query($insert_sql);

		 

		 } 

		  $x++;

	 }

	}

}



if($_POST["updatep"])

{

    global $wpdb;

	global $woocommerce;

    $pro_table_prefix=$wpdb->prefix;

   

   

   $cntArr = count($_POST["product_id"]);

   $arrPrdct = $_POST["product_id"];

   $woo_weightArr = $_POST["woo_weight"];

   $woo_widthArr = $_POST["woo_width"];

   $woo_lengthArr = $_POST["woo_length"];

   $woo_heightArr = $_POST["woo_height"];

   

   $WeightArr = $_POST["Weight"];

   $LengthArr = $_POST["Length"];

   $WidthArr  = $_POST["Width"];

   $HeightArr  = $_POST["Height"]; 

   

   for($lp=0;$lp<$cntArr;$lp++)

   {

      $p_id = $arrPrdct[$lp];

	  $p_weight = $woo_weightArr[$lp];

	  $p_width = $woo_widthArr[$lp];

	  $p_length = $woo_lengthArr[$lp];

	  $p_height = $woo_heightArr[$lp];

	  $SKU = get_post_meta($p_id,'_sku',true);

	  

	  $Weight = $WeightArr[$lp];

	  $Length = $LengthArr[$lp];

	  $Width  = $WidthArr[$lp];

	  $Height  = $HeightArr[$lp];

	  

	  //========Update Meta Value Start ========//

	  

	  $sql_update_w = "update ".$pro_table_prefix."postmeta set meta_value='$p_weight' where post_id=$p_id and meta_key = '_weight'";



	  

	  mysql_query($sql_update_w);

	  

	  

	  $sql_update_wi = "update ".$pro_table_prefix."postmeta set meta_value='$p_width' where post_id=$p_id and meta_key = '_width'";

	  mysql_query($sql_update_wi);

	  

	  

	  $sql_update_l = "update ".$pro_table_prefix."postmeta set meta_value='$p_length' where post_id=$p_id and meta_key = '_length'";

	  mysql_query($sql_update_l);

	  

	  

	  $sql_update_h = "update ".$pro_table_prefix."postmeta set meta_value='$p_height' where post_id=$p_id and meta_key = '_height'";

	  mysql_query($sql_update_h);

	  

	  //========Update Meta Value End ========//

	  

	  

	  //========Update Dimension Start========//

	  

	$sqldel = "delete from baggage_excel where SKU='".$SKU."'";

	mysql_query($sqldel);

	

	$insert_sql = "insert into baggage_excel(SKU,Weight,Height,Width,Length)"; 

	$insert_sql = $insert_sql." values('".$SKU."','".$Weight."','".$Height."','".$Width."','".$Length."')"; 

	

	mysql_query($insert_sql);

	  

	  //========Update Dimension End========//

	  

   }

   

   header("location:admin.php?page=upload_package");

   

}





function getPaging($cnt,$current)

{

   $val_per_page = 20;

   $total_pages = round($cnt/$val_per_page);



   if($total_pages<1)

   {

     $total_pages = 1;

   }

   

   if($current=="" || $current==0)

   {

      $current = 1;

   }

   



   

   if($total_pages>1)

   {

     ?>

	 

	 

	 <script>

	 

	 function gotoPage(pagenum)

	 {

	    document.getElementById("paged").value = pagenum;

		document.frmPage.submit();

	 }

	 

	 </script>

	 

	

	 <div class="tablenav-pages"><span class="displaying-num"><?php echo $cnt?> items</span>

<span class="pagination-links">

<?php

if($current==1)

{

?>

 &lt;&lt;

<?php

}

else

{?>

<a href="javascript:gotoPage(1)" title="Go to the first page" class="first-page">&lt;&lt;</a>

<?php

}?>





<?php

if($current==1)

{

?>

 &lt;

<?php

}

else

{

  $prev = $current-1;

?>

<a href="javascript:gotoPage(<?php echo $prev?>)" title="Go to the previous page" class="prev-page">&lt;</a>

<?php

}?>





<span class="paging-input"><input type="text" size="2" value="<?php echo $current?>" name="paged" id="paged" title="Current page" class="current-page"> of <span class="total-pages"><?php echo $total_pages?></span></span>



<?php

if($current == $total_pages)

{

 ?>

 &gt;

 <?php

}

else

{

  $next = $current+1;

?>

<a href="javascript:gotoPage(<?php echo $next?>)" title="Go to the next page" class="next-page">&gt;</a>

<?php

}

?>





<?php

if($current == $total_pages)

{

 ?>

 &gt;&gt;

 <?php

}

else

{?>

<a href="javascript:gotoPage(<?php echo $total_pages?>)" title="Go to the last page" class="last-page">&gt;&gt;</a>

<?php

}?>



</span></div>

	 

	

	 <?php

   }



}





?>



<div id="contenthome">

  <div id="box">

    <h3 align="left">Product Freight Values</h3>  

 		<form id="form" name="form1" action="" method="post" enctype="multipart/form-data">

			  

			  <div align="center" class="postbox" style="width:90%;">

	  

	  <h3 class="hndle" style="height:35px; padding-top:20px;">

<span ><strong>Upload package file</strong></span>

</h3>



<div class="inside" id="dv1"> 

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

				  <tr>

					<td width="38%" align="right">Filename:</td>

					<td width="62%" align="left"><input type="file" name="file" id="file" /></td>

					</tr>

					<tr>

					<td width="38%" align="right">&nbsp;</td>

					<td width="62%" align="left">&nbsp;</td>

					</tr>

					<tr>

					<td width="38%" align="right">&nbsp;</td>

					<td width="62%" align="left"><input id="button1" type="submit" name="submit" value="Submit" class="button button-primary button-large" />&nbsp;<input id="button2" type="button" value="Cancel" class="button button-primary button-large" onclick="window.location='admin.php?page=baggage_shipping/baggage_shipping.php'"/></td>

					</tr>

			   </table>

</div>

</div>

		</form>	  

			

			

			<?php

	global $wpdb;

	global $woocommerce;

    $pro_table_prefix=$wpdb->prefix;

	$action_s = $_POST["action_s"];

	

	if($_REQUEST["action"]=="all")

	{

	  

	    

		$sqlpackage = "select * from ".$pro_table_prefix."posts where post_type='product' and post_status='publish' and ID in(SELECT post_id FROM ".$pro_table_prefix."postmeta WHERE (meta_key='_weight' and meta_value='') or (meta_key='_length' and meta_value='') or (meta_key='_width' and meta_value='') or (meta_key='_height' and meta_value=''))";

		

		$sqlpackage = $sqlpackage." UNION ";

		

		$sqlpackage = $sqlpackage."select * from ".$pro_table_prefix."posts where post_type='product' and post_status='publish' and ID in(SELECT post_id FROM ".$pro_table_prefix."postmeta WHERE meta_key='_sku' and meta_value=(select SKU from baggage_excel where (Weight='' or Height='' or Width='' or Length='')))";

		

		

		$res = mysql_query($sqlpackage);

		$cnt_total = mysql_num_rows($res);

		

		$sqlpackage1 = "select * from ".$pro_table_prefix."posts where post_type='product' and post_status='publish' and ID in(SELECT post_id FROM ".$pro_table_prefix."postmeta WHERE (meta_key='_weight' and meta_value='') or (meta_key='_length' and meta_value='') or (meta_key='_width' and meta_value='') or (meta_key='_height' and meta_value=''))";

		

		$sqlpackage1 = $sqlpackage1." UNION ";

		

		$sqlpackage1 = $sqlpackage1."select * from ".$pro_table_prefix."posts where post_type='product' and post_status='publish' and ID in(SELECT post_id FROM ".$pro_table_prefix."postmeta WHERE meta_key='_sku' and meta_value=(select SKU from baggage_excel where (Weight='' or Height='' or Width='' or Length='')))";



	  

	}

	else if($_REQUEST["action"]=="srch")

	{

	   $txtSearch = $_REQUEST["txtSearch"];

	   $txt_val = $txtSearch;

	   if($txtSearch=="")

	   {

	     $txt_val = "Search for a Product"; 

	   }

	   

	   if($txtSearch=="Search for a Product")

	   {

	     $txtSearch = "";

	   }

	   

	   $sqlpackage = "select * from ".$pro_table_prefix."posts where post_type='product' and (post_title like '".$txtSearch."%' or ID in(SELECT post_id FROM ".$pro_table_prefix."postmeta WHERE meta_key='_sku' and meta_value like '".$txtSearch."%' )) and post_status='publish'";

		$res = mysql_query($sqlpackage);

		$cnt_total = mysql_num_rows($res);

		

		$sqlpackage1 = "select * from ".$pro_table_prefix."posts where post_type='product' and (post_title like '".$txtSearch."%' or ID in(SELECT post_id FROM ".$pro_table_prefix."postmeta WHERE meta_key='_sku' and meta_value like '".$txtSearch."%' )) and post_status='publish'";

		

	   

	    

	   

	}

	else

	{

		$sqlpackage = "select * from ".$pro_table_prefix."posts where post_type='product' and post_status='publish'";

		$res = mysql_query($sqlpackage);

		$cnt_total = mysql_num_rows($res);

		

		$sqlpackage1 = "select * from ".$pro_table_prefix."posts where post_type='product' and post_status='publish'";

		

	}



    

	$paged = $_REQUEST["paged"];

	if($paged == "")

	{

	  $paged = 1;

	}

	$limit_start = ($paged-1)*20;

	$limit_end = 20;

	

	$sqlpackage = $sqlpackage." limit ".$limit_start.",".$limit_end;

	$res = mysql_query($sqlpackage);

	$cnt = mysql_num_rows($res);

	

	$sqlpackage1 = $sqlpackage1." limit ".$limit_start.",".$limit_end;

	$res1 = mysql_query($sqlpackage1);

	$cnt1 = mysql_num_rows($res1);

	

	

	

	?>

	

	

	<div align="center"  style="width:100%;">

	  

	  <h3 class="hndle" style="height:35px; padding-top:20px;">

<span ><strong>Freight Values</strong></span>

</h3>

<div class="inside" id="dv1"> 



  <div align="left">

    In order for us to ensure your freight is correctly calculated, we need to know the packed weight and volumes for your products.

Currently your setting are to use BAGGAGE FREIGHT VALUES for Freight. These must be completed freight to be calculated properly.

<br />

<br />

<table width="100%" cellpadding="0" cellspacing="0">

 <tr>

  <td> 

  



   

 <?php

 $strSrch= $txt_val;

 if($strSrch=="")

 {

    $strSrch = "Search for a Product";

 }

 ?>

  

  <table  border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td>

	<form action="admin.php?page=upload_package&amp;action=all" method="post">

	<input type="submit" value="Show all Products with incomplete values" id="searchA" name="searchA" class="button button-primary button-large"  >

	</form>

	</td>

    <td><input type="button" value="Show all Products" id="searchB" name="searchB" class="button button-primary button-large" onclick="window.location='admin.php?page=upload_package'"></td>

	<td>

	

	<script>

	

	  function searchBy()

	  {

	     var key = document.getElementById("txtSearch").value;

		 var searchUrl = "admin.php?page=upload_package&action=srch&txtSearch="+key;

		 window.location = searchUrl;

	  }

	

	</script>

	

	

	<table cellpadding="0" cellspacing="0">

	<tr>

	<td align="right">

	<input type="text" value="<?php echo $strSrch?>" id="txtSearch" name="txtSearch" onblur="if(this.value=='')this.value='Search for a Product'" onfocus="if(this.value=='Search for a Product')this.value=''"  >

	</td>

	<td align="left">

	<input type="button" value="Submit" id="searchC" name="searchC" class="button button-primary button-large" onclick="searchBy()" >

	</td>

	</tr>

	</table>

	

	</td>

  </tr>

</table>

 

  </td>

 </tr>

</table>



<br />

  </div>

	<form id="frmPage" name="frmPage" action="" method="post">

	<?php

	if($cnt_total>0)

	{



	?>

	<div class="tablenav" style="text-align:right;padding-right:30px;">

	<?php

	    echo getPaging($cnt_total,$paged);

		?>

	</div>

	

	

	<table  cellpadding="0" cellspacing="0" >

	

	

	



	  <tr>

	    <td  valign="top" style="padding-right:2px;">

		   

		  <table  border="0" cellspacing="2" cellpadding="2" style="border:1px solid #ccc;">

  <tr style="background:#ECECEC">

    <th colspan="6"  style="text-align:center;" >Woocommerce Settings </th>

    </tr>

  <tr style="background:#ECECEC">

    <th >SKU</th>

    <th >Product </th>

	<th>Weight (KG) </th>

    <th >Length (CM) </th>

    <th >Width (CM) </th>

    <th >Height (CM) </th>

  </tr>

  

  <?php

  $i=0;

  while($row=mysql_fetch_assoc($res))

  {

  

    $product = get_product($row["ID"]);

	 

    $product_id = $product->id;

	$SKU = get_post_meta($product_id,'_sku',true);

	$Title = $product->post->post_title;

	

	$woo_weight = get_post_meta($product_id,'_weight',true);

	$woo_width  = get_post_meta($product_id,'_width',true);

	$woo_height = get_post_meta($product_id,'_height',true);

	$woo_length = get_post_meta($product_id,'_length',true);



	 

	 if($i%2==0)

	 {

	   $cls = 'class="row0"';

	 }

	 else

	 {

	   $cls = 'class="row1"';

	 }

  ?>

  

  <input type="hidden" name="product_id[]" value="<?php echo $product_id?>"  />

  

  <tr <?php echo $cls?> >

    <td align="center"><?php echo $SKU?> </td>

	<td align="center" title="<?php echo $Title?>" style="width:80px;"><?php 

	

	  $strTitle = substr($Title,0,8);

	

	echo $strTitle?></td>

	<td align="center"> <input type="text" name="woo_weight[]" value="<?php echo $woo_weight?>" style="width:60px;"  /></td>

	<td align="center"> <input type="text" name="woo_length[]" value="<?php echo $woo_length?>" style="width:60px;"  /></td>

	<td align="center"> <input type="text" name="woo_width[]" value="<?php echo $woo_width?>" style="width:60px;"  /></td>

    <td align="center"> <input type="text" name="woo_height[]" value="<?php echo $woo_height?>" style="width:60px;"  /></td> 

  </tr>

  

  <?php

   

    $i++;

   

  }?>

</table>		</td>

		<td  valign="top">

		  

		    <table border="0" cellspacing="2" cellpadding="2" style="border:1px solid #ccc;">

  <tr style="background:#ECECEC">

    <th colspan="4" style="text-align:center;">

	Baggage Freight Settings	</th>

    </tr>

  <tr style="background:#ECECEC">

    <th >Weight (KG) </th>

    <th >Length (CM) </th>

    <th >Width (CM) </th>

    <th >Height (CM) </th>

  </tr>

  

  <?php

  $i=0;

  while($row1=mysql_fetch_assoc($res1))

  {

  

    $product = get_product($row1["ID"]);

	$product_id = $product->id;

	$SKU = get_post_meta($product_id,'_sku',true);

  

     $sql_dimension = "select * from baggage_excel where SKU='$SKU'"; 

	 $res_dimension = mysql_query($sql_dimension);

	 $row_dimension = mysql_fetch_assoc($res_dimension);

	 

	 $Weight = $row_dimension["Weight"];

	 $Height = $row_dimension["Height"];

	 $Width  = $row_dimension["Width"];

	 $Length = $row_dimension["Length"];

	 

	 if($i%2==0)

	 {

	   $cls = 'class="row0"';

	 }

	 else

	 {

	   $cls = 'class="row1"';

	 }

  ?>

  <tr <?php echo $cls?>>

    <td align="center"><input type="text" name="Weight[]" value="<?php echo $Weight?>" style="width:60px;"  /></td>

    <td align="center"><input type="text" name="Length[]" value="<?php echo $Length?>" style="width:60px;"  /></td>

	<td align="center"><input type="text" name="Width[]" value="<?php echo $Width?>"  style="width:60px;" /></td>

	<td align="center"><input type="text" name="Height[]" value="<?php echo $Height?>" style="width:60px;"  /></td>

  </tr>

  

  <?php

   

    $i++;

   

  }?>

</table>		</td>

	 </tr>

	  <tr>

	    <td valign="top" style="padding-right:10px;">&nbsp;</td>

	    <td valign="top">&nbsp;</td>

	    </tr>

	  <tr>

	    <td colspan="2" valign="top"  align="center">

		

		   <input type="submit" value="Update Product Weights and Dimensions" id="updatep" name="updatep" class="button button-primary button-large">

		

		</td>

	    </tr>

	</table>

	</form>

	

	

	



<?php

}

else

{?>



<table cellpadding="1" width="100%">

<tr>

<td align="left">

<?php

  echo "No Records Found";

  ?>

  </td>

  </tr>

</table>  

  <?php

  }

?>

</div>

</div>		

	

		

	

  </div>

</div>

  	