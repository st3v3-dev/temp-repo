<?php



$sql = "select * from baggage_storeowner";

$res = mysql_query($sql);

$row = mysql_fetch_assoc($res);



$Email = $row["Email"];

$Password = $row["Password"];



$cc_no = file_get_contents("http://www.baggagefreight.com.au/api/getCCdetail.aspx?Email=".$Email);

$arrCCNo = explode(",",$cc_no);



$cardType = $arrCCNo[0];

$cardNo = $arrCCNo[1];

$cardNo_Mask = substr($cardNo, -4);



$cc_Url = "http://www.baggagefreight.com.au/api/authloginstore_pay.aspx?username=".$Email."&password=".urlencode($Password);





?>



<div id="contenthome">

  <div id="box">

    <h3 align="left">Payment Options</h3>  

 		<form id="form" name="form1" action="" method="post" enctype="multipart/form-data">

			  

			  <div align="center" class="postbox" style="width:90%;">

	  

	  <h3 class="hndle" style="height:35px; padding-top:20px;">

<span ><strong>Payment Options</strong></span>

</h3>



<div class="inside" id="dv1"> 

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

				  <tr>

				    <td colspan="3" height="10"></td>

		    </tr>

				  <tr>

				    <td align="right">&nbsp;</td>

				    <td align="left">&nbsp;</td>

				    <td align="left">

					

					Presently, payment for freight must be done via Credit Card. We will shortly be rolling out payment by Paypal, but for now, please enter your credit card details on our site					</td>

		    </tr>

				  <tr>

				    <td colspan="3" align="right" height="20"></td>

		    </tr>

				  <tr>

					<td width="37%" align="right"><strong>Credit Card Details :</strong></td>

					<td width="1%" align="left">&nbsp;</td>

					<td width="62%" align="left">

					

					<?php

					if($cc_no=="")

					{

					   echo "No Card Added";

					}

					else

					{?>

					   Currently using <strong><?php echo $cardType?></strong> **** **** **** <strong><?php echo $cardNo_Mask?></strong>  <a href="<?php echo $cc_Url?>" target="_blank">Update</a>

					   

					   <?php

					   }?>					   </td>

					</tr>

					<tr>

					<td colspan="3" align="right" height="15"></td>

					</tr>

					<tr>

					<td width="37%" align="right">&nbsp;</td>

					<td width="1%" align="left">&nbsp;</td>

					<td width="62%" align="left"><a href="<?php echo $cc_Url?>" target="_blank">Add New</a> </td>

					</tr>

			   </table>

</div>

</div>

			  

			

			

				

			

	</form>	

  </div>

</div>

  	