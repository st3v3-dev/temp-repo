<?php
if($_POST["updatep"])
{
    global $wpdb;
	global $woocommerce;
    $pro_table_prefix=$wpdb->prefix;
   
   
   $cntArr = count($_POST["product_id"]);
   $arrPrdct = $_POST["product_id"]; 
   $packtypeArr = $_POST["packtype"];
   
   for($lp=0;$lp<$cntArr;$lp++)
   {
      $p_id = $arrPrdct[$lp];
	  $p_packtype = $woo_packtypeArr[$lp];
	  $SKU = get_post_meta($p_id,'_sku',true);
	  
	  $Packtype = $packtypeArr[$lp];
	 
	  //========Update Dimension Start========//
	  
	$sqldel = "delete from baggage_product_pack where SKU='".$SKU."'"; 
   $wpdb->query($sqldel);
	
	$insert_sql = "insert into baggage_product_pack(pid,SKU,packType)"; 
	$insert_sql = $insert_sql." values('".$p_id."','".$SKU."','".$Packtype."')"; 
	$wpdb->query($insert_sql); 
	  
	  //========Update Dimension End========//
	  
   }
   
   header("location:admin.php?page=packed_items");
   
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
	 
 	
	 <div class="tablenav-pages"><span class="displaying-num"><?=$cnt?> items</span>
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
<a href="javascript:gotoPage(<?=$prev?>)" title="Go to the previous page" class="prev-page">&lt;</a>
<?php
}?>


<span class="paging-input"><input type="text" size="2" value="<?=$current?>" name="paged" id="paged" title="Current page" class="current-page"> of <span class="total-pages"><?=$total_pages?></span></span>

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
<a href="javascript:gotoPage(<?=$next?>)" title="Go to the next page" class="next-page">&gt;</a>
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
<a href="javascript:gotoPage(<?=$total_pages?>)" title="Go to the last page" class="last-page">&gt;&gt;</a>
<?php
}?>

</span></div>
	 
	
	 <?php
   }

}


?>

<div id="contenthome">
  <div id="box">
    <h3 align="left">Consolidate Products List</h3>  
 		 	  
			
			
			<?php
	global $wpdb;
	global $woocommerce;
    $pro_table_prefix=$wpdb->prefix;
	$action_s = $_POST["action_s"];
	
	if($_REQUEST["action"]=="all")
	{
	  
	    
		$sqlpackage = "select * from ".$pro_table_prefix."posts where post_type='product' and post_status='publish' and ID in(SELECT post_id FROM ".$pro_table_prefix."postmeta WHERE (meta_key='_packtype' and meta_value=''))";
		
		$sqlpackage = $sqlpackage." UNION ";
		
		$sqlpackage = $sqlpackage."select * from ".$pro_table_prefix."posts where post_type='product' and post_status='publish' and ID in(SELECT post_id FROM ".$pro_table_prefix."postmeta WHERE meta_key='_sku' and meta_value=(select SKU from  baggage_product_pack where (packType='')))";
		
		$cnt_total = $wpdb->get_row($sqlpackage, OBJECT); 
		//$res = mysql_query($sqlpackage);
		//$cnt_total = mysql_num_rows($res);
		
		$sqlpackage1 = "select * from ".$pro_table_prefix."posts where post_type='product' and post_status='publish' and ID in(SELECT post_id FROM ".$pro_table_prefix."postmeta WHERE (meta_key='_packtype' and meta_value='') )";
		
		$sqlpackage1 = $sqlpackage1." UNION ";
		
		$sqlpackage1 = $sqlpackage1."select * from ".$pro_table_prefix."posts where post_type='product' and post_status='publish' and ID in(SELECT post_id FROM ".$pro_table_prefix."postmeta WHERE meta_key='_sku' and meta_value=(select SKU from baggage_product_pack where (packType='')))";
 
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
		$cnt_total = $wpdb->get_row($sqlpackage, OBJECT); 
		
		$sqlpackage1 = "select * from ".$pro_table_prefix."posts where post_type='product' and (post_title like '".$txtSearch."%' or ID in(SELECT post_id FROM ".$pro_table_prefix."postmeta WHERE meta_key='_sku' and meta_value like '".$txtSearch."%' )) and post_status='publish'";
	 
	}
	else
	{
		$sqlpackage = "select * from ".$pro_table_prefix."posts where post_type='product' and post_status='publish'";
		$cnt_total = $wpdb->get_row($sqlpackage, OBJECT); 
		
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
	$cnt = $wpdb->get_row($sqlpackage, OBJECT); 
	
	$sqlpackage1 = $sqlpackage1." limit ".$limit_start.",".$limit_end;
	$cnt1 = $wpdb->get_row($sqlpackage1, OBJECT); 
 
	?>
 
	<div align="center"  style="width:100%;">
	 
<div class="inside" id="dv1"> 

  <div align="left">
    
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
  
  
 
  </td>
 </tr>
</table>

<br />
  </div>
	<form id="frmPage" name="frmPage" action="" method="post">
	<?php
	if(count($cnt_total)>0)
	{

	?>
	<div class="tablenav" style="text-align:right;padding-right:30px;">
	<?php
	    echo getPaging(count($cnt_total),$paged);
		?>
	</div>
	
	
	<table  cellpadding="0" cellspacing="0" width="100%" >
	 
	  <tr>
	    <td  valign="top" style="padding-right:2px;">
		  <table  border="0" cellspacing="2" cellpadding="2" style="border:1px solid #ccc;" width="100%" >
             
              <tr style="background:#ECECEC">
                <th width="110" >SKU</th>
                <th width="206" >Product </th>
                <th width="177" >Type</th>
              </tr>
              
              <?php
              $i=0;
             foreach($cnt1 as $row1)
              {
              
                $product = get_product($row1->ID);
                $product_id = $product->id;
                $SKU = get_post_meta($product_id,'_sku',true);
                $Title = $product->post->post_title;
                $sql_dimension = "select * from  baggage_product_pack where SKU='$SKU'";  
				$row_dimension = $wpdb->get_row($sql_dimension, OBJECT); 
                 
                $packType = $row_dimension->packType;
                 
                 
                 
                 if($i%2==0)
                 {
                 
                   $cls = 'style="background:#fff"';
                 }
                 else
                 {
                   $cls = 'style="background:#F8F7F8"';
                 }
              ?>
              <tr <?=$cls?>>
               
              <input type="hidden" name="product_id[]" value="<?=$product_id?>"  />
               
                <td align="center"><?=$SKU?> </td>
                <td align="center" title="<?=$Title?>" style="width:80px;"><?php  echo $Title?></td>
                 <td align="center"> 
                   <select name="packtype[]">
                      <option value="0" <?php if($packType==0) echo "selected";  ?>> Individual</option> 
                      <option value="1" <?php if($packType==1) echo "selected";  ?>> Consolidate / Combined</option> 
                   </select>
                
                
                </td> 
              </tr>
              
              <?php
               
                $i++;
               
              }?>
            </table>
		</td>
	  </tr>
	  <tr>
	    <td valign="top" style="padding-right:10px;">&nbsp;</td>
	    <td valign="top">&nbsp;</td>
	  </tr>
	  <tr>
	    <td colspan="2" valign="top"  align="left">
		
		   <input type="submit" value="Save" id="updatep" name="updatep" class="button button-primary button-large">
		
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
  	