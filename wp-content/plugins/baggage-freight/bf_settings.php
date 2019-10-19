<?php



$sql = "select * from baggage_settings";

$res = mysql_query($sql);

$row = mysql_fetch_assoc($res);



$package_type = $row["package_type"];

$hfee = $row["hfee"];

 

if($_POST)

{

   $package_type = $_REQUEST["package_type"];

   $hfee = floatval($_REQUEST["hfee"]);

   

   

   $del_sql = "delete from baggage_settings";

   mysql_query($del_sql);

   

  

   $insert_sql = "insert into baggage_settings(package_type,hfee) values('$package_type','$hfee')";

   mysql_query($insert_sql);

   

   $msg = "Data Saved Successfully!";

   

   

	global $wpdb;

	$pro_table_prefix=$wpdb->prefix;

	$sql_pages = "select * from ".$pro_table_prefix."posts where post_title in('Cart','Checkout','Order Received')";

	$res_pages = mysql_query($sql_pages);

   

   

   

}







?>







<div id="contenthome">

  <div id="box">

    <h3 align="left">Settings</h3>  

 		<form id="form" name="form1" action="" method="post" enctype="multipart/form-data">

		

		<fieldset class="error" style="border:none;"> </fieldset>

			

			<?php

			if($msg)

			{?>

			

			<div class="error"><?php echo $msg ?></div>

			

			<?php

			}?>

			

			 

			 <div align="center" class="postbox" style="width:90%;">

	  

	  <h3 class="hndle" style="height:35px; padding-top:20px;">

<span ><strong>Settings</strong></span>

</h3>



<div class="inside" id="dv1"	>  

	  

	       <table width="100%" border="0" cellspacing="2" cellpadding="2">

				 

				  <tr>

					<td width="29%" align="right" valign="top">

					<p>

					  Use WooCommerce weight and volume settings for freight calculation?					  </p>					 </td>

					<td width="8%" align="center" valign="top"><p>:</p></td>

					<td width="63%" align="left" valign="top"><p>

					  

					  <?php

					  if($package_type=="")

					  {

					     $package_type = "1";

					  }?>

					  

					  <select id="package_type" name="package_type">

            <option value="1" <?php if($package_type=="1"){?> selected="selected" <?php }?>>Yes, I use woocommerce values for packed weight and size</option>

            <option value="2" <?php if($package_type=="2"){?> selected="selected" <?php }?>>No, I need separate values entered for freight</option>

          </select>

					  

					</p>

				    <p>WooCommerce allows you to enter values for weight, length, volume and   width.              Some business use these values to show the unpacked dimensions   of their products... for example, a garden gazebo might weigh 15   kilograms, and be 3 x 3 x 3m unpacked, but be 17k and 1 x .75 x.3m when   packed.<br>

                      <br>

We need to know your product's PACKED weights and dimensions.</p>

				    <p>If they are different to their unpacked weights and dimensions - then we need to tell us both values.</p>

				    <p>&nbsp; </p></td>

				  </tr>

				  <tr>

				    <td align="right">Handling Fee</td>

				    <td align="center">:</td>

				    <td align="left"><input type="text" name="hfee" id="hfee" value="<?php echo $hfee?>" size="10">  (Optional, this is payable to your company, covers the cost of packing as opposed to shipping. Most companies include this in the product pricing)</td>

		     </tr>

				   <tr>

				     <td height="20" colspan="3"></td>

		     </tr>

				 

				   <tr>

					<td align="right">&nbsp; </td>

					<td align="center"> </td>

					<td align="left"> <input id="button1" type="submit" name="submit" value="Submit" class="button button-primary button-large" />  </td>

				  </tr>

               </table>

	  

</div>	



      </div>

		

			

			

	</form>	

  </div>

</div>