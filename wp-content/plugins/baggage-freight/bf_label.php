<?php 
global $wpdb;
?>
<div id="contenthome">
  <div id="box">
    <h3 align="left">Shipping Label</h3>  
 		<form id="form" name="form1" action="" method="post" enctype="multipart/form-data">
			  <br />
			  <br />
			
			
			
			<?php
	
	
	$sql_st = "select Email,Password from baggage_storeowner";
	$row_st = $wpdb->get_row($sql_st, OBJECT); 
	//$res_st = mysql_query($sql_st);
	//$row_st = mysql_fetch_assoc($res_st);
	
	$email = $row_st->Email;
	$pass = $row_st->Password;
	
	?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">
	
	   <a href="http://www.baggagefreight.com.au/api/authloginstore.aspx?username=<?=$email?>&password=<?=urlencode($pass)?>" target="_blank">
       <img src="<?php echo plugins_url( 'images/logo_bf.png', __FILE__ ) ?>" border="0" /></a>
	   <br>
	<a href="http://www.baggagefreight.com.au/api/authloginstore.aspx?username=<?=$email?>&password=<?=urlencode($pass)?>" target="_blank"><strong>Go To Store Owner Dashboard</strong></a>
	
	</td>
  </tr>
</table>

	</form>	
  </div>
</div>
  	