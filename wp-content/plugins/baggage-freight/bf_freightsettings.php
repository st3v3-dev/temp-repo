<?php
global $wpdb;
$sql = "select * from baggage_dimensions";
$row = $wpdb->get_row($sql, OBJECT); 


$height = $row->height;
$width = $row->width;
$length = $row->length;



if($_POST)
{
   $height = floatval($_REQUEST["height"]);
   $width = floatval($_REQUEST["width"]);
   $length = floatval($_REQUEST["length"]);
   
   
   $del_sql = "delete from baggage_dimensions";
   $wpdb->query($del_sql);
   
   $insert_sql = "insert into baggage_dimensions(height,width,length) values('$height','$width','$length')";
   $wpdb->query($insert_sql);
   
   $msg = "Data Saved Successfully!";
}



?>



<div id="contenthome">
  <div id="box">
    <h3 align="left">Freight Settings</h3>  
 		<form id="form" name="form1" action="" method="post" enctype="multipart/form-data">
		
		<fieldset class="error" style="border:none;"> </fieldset>
			
			<?php
			if($msg)
			{?>
			
			<div class="error"><?=$msg ?></div>
			
			<?php
			}?>
			
			 
			 <div align="center" class="postbox" style="width:90%;">
	  
	  <h3 class="hndle" style="height:35px; padding-top:20px;">
<span ><strong>Default Settings</strong></span>
</h3>

      <div class="inside" id="dv1"	>  
	  
	       <table width="100%" border="0" cellspacing="2" cellpadding="2">
				 
				  <tr>
				    <td align="right" valign="top">&nbsp;</td>
				    <td align="center" valign="top">&nbsp;</td>
				    <td align="left" valign="top">
					  Values to be used if an item is purchased which does not have freight values entered.					</td>
		     </tr>
				  <tr>
					<td width="29%" align="right" >
					Length				 </td>
					<td width="8%" align="center" >:</td>
					<td width="63%" align="left" >
					  <input type="text" name="length" id="length" value="<?=$length?>" size="10">
					</td>
				  </tr>
				  <tr>
				    <td align="right">Width</td>
				    <td align="center">:</td>
				    <td align="left"><input type="text" name="width" id="width" value="<?=$width?>" size="10"> </td>
		     </tr>
				  <tr>
				    <td align="right">Height</td>
				    <td align="center">:</td>
				    <td align="left"><input type="text" name="height" id="height" value="<?=$height?>" size="10"></td>
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