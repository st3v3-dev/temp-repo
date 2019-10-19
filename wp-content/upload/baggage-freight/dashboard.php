<?php

$sql_st = "select Email,Password from baggage_storeowner";

	$res_st = mysql_query($sql_st);

	$row_st = mysql_fetch_assoc($res_st);

	

	$email = $row_st["Email"];

	$pass = $row_st["Password"];

	

?>	





	



<table align="center" width="840" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td align="center">&nbsp;</td>

    <td align="center">

	<a href="http://www.baggagefreight.com.au/api/authloginstore.aspx?username=<?php echo $email?>&password=<?php echo urlencode($pass)?>" target="_blank"><img src="../wp-content/plugins/baggage_shipping/images/logo_bf.png" border="0" /></a>

	   <br>

	<a href="http://www.baggagefreight.com.au/api/authloginstore.aspx?username=<?php echo $email?>&password=<?php echo urlencode($pass)?>" target="_blank"><strong>Go To B.F Dashboard</strong></a>

	

	</td>

    <td align="center">&nbsp;</td>

  </tr>

  <tr>

    <td align="center" width="280">&nbsp;</td>

    <td align="center" width="280">&nbsp;</td>

    <td align="center" width="280">&nbsp;</td>

  </tr>

  <tr>

    <td align="center">

	

	   <p><a href="admin.php?page=store_owner"><img src="../wp-content/plugins/baggage_shipping/images/registration.png" width="160px" border="0" /></a>	</p>

	   <p><a href="admin.php?page=store_owner">Registration</a></p></td>

    <td align="center">

	  <p><a href="admin.php?page=store_settings"><img src="../wp-content/plugins/baggage_shipping/images/Settings.png" width="130px" border="0" /></a>	</p>

    <p style="padding-top:25px;"><a href="admin.php?page=store_settings">Settings</a></p></td>

    <td align="center">

	  <p><a href="admin.php?page=freight_settings"><img src="../wp-content/plugins/baggage_shipping/images/Settings1.png" border="0" width="130px" /></a>	</p>

    <p style="padding-top:25px;"><a href="admin.php?page=freight_settings">Default Freight Settings</a></p></td>

  </tr>

  <tr>

    <td colspan="3" align="center">&nbsp;</td>

  </tr>

  <tr>

    <td align="center">

	  <p>

	  <a href="admin.php?page=upload_package"><img src="../wp-content/plugins/baggage_shipping/images/dimensions.jpg" width="130px" border="0" /></a>	</p>

    <p style="padding-top:25px;">

	<a href="admin.php?page=upload_package">Package Details</a>

	</p></td>

    <td align="center">

	  <p><a href="admin.php?page=payment_option"><img src="../wp-content/plugins/baggage_shipping/images/payment.png" width="160px"  border="0" /></a>	</p>

    <p><a href="admin.php?page=payment_option">Payment Options</a></p></td>

    <td align="center">

	<p>

	  <a href="admin.php?page=bf_label"><img src="../wp-content/plugins/baggage_shipping/images/order.jpg" width="130px" border="0" /></a>	</p>

    <p style="padding-top:25px;">

	<a href="admin.php?page=bf_label">Shipping Labels</a>

	

	</td>

  </tr>

</table>

