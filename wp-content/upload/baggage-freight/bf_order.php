
<div id="contenthome">
  <div id="box">
    <h3 align="left">Baggage Freight Order Details</h3>  
 		<form id="form" name="form1" action="" method="post" enctype="multipart/form-data">
			  <br />
			  <br />
			
			
			
			<?php
	
	
	$sql_st = "select Email,Password from baggage_storeowner";
	$res_st = mysql_query($sql_st);
	$row_st = mysql_fetch_assoc($res_st);
	
	$Email = $row_st["Email"];
	$Password = $row_st["Password"];
	$BFUid = file_get_contents("http://www.baggagefreight.com.au/api/loginSO.aspx?username=".$Email."&password=".$Password);
	
	
	
	$sql = "select * from baggage_order order by Id desc";
	$res = mysql_query($sql);
	$cnt = mysql_num_rows($res);
	
	?>
	
	
	<?php
	if($cnt>0)
	{

	?>
	
	<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr style="background:#999999">
    <th >Order Id</th>
    <th >Bf OrderId </th>
    <th >Freight Paid </th>
    <th >Transaction ID</th>
    <th >Freight Con Number </th>
    <th >Shipping Label </th>
  </tr>
  
  <?php
  $i=0;
  while($row=mysql_fetch_assoc($res))
  {
	 $Wp_Orderid = $row["Wp_Orderid"];
	 $BfOrderId = $row["BfOrderId"];
	 	 
	 $PaymentDone = file_get_contents("http://www.baggagefreight.com.au/api/getTransactionId.aspx?orderid=".$BfOrderId."&UserId=".$BFUid."&parameter=PaymentStatus");
	
	if($PaymentDone == "True")
	{
	   $PaymentDone = "YES";
	}
	else
	{
	   $PaymentDone = "NO";
	}
	
	
	$TransactionId = file_get_contents("http://www.baggagefreight.com.au/api/getTransactionId.aspx?orderid=".$BfOrderId."&UserId=".$BFUid."&parameter=TransactionID");
	
	$ConNo = file_get_contents("http://www.baggagefreight.com.au/api/getTransactionId.aspx?orderid=".$BfOrderId."&UserId=".$BFUid."&parameter=ConNoteNumber");
	
	 
	 if($i%2==0)
	 {
	   $cls = 'class="row0"';
	 }
	 else
	 {
	   $cls = 'class="row1"';
	 }
  ?>
  <tr <?=$cls?>>
    <td align="center"><?=$Wp_Orderid?></td>
	<td align="center"><?=$BfOrderId?></td>
	<td align="center"><?=$PaymentDone?></td>
	<td align="center"><?=$TransactionId?></td>
	<td align="center"><?=$ConNo?></td>
    <td align="center">
	
	<?php
	$strLabel = file_get_contents('http://www.baggagefreight.com.au/api/getLabel.aspx?orderid='.$BfOrderId);
	
	if($strLabel=="0")
	{
	  echo "NA";
	 }
	 else
	 {?>
	 <a href="http://baggagefreight.com.au/download-file.aspx?File=<?=$strLabel?>&amp;Folder=shipping-label" target="_blank">View Label</a>
	 <?php
	 }
	
	?>
	
	</td> 
  </tr>
  
  <?php
   
    $i++;
   
  }?>
</table>

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

</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

			
			
			
			
			
			
			
			
			
			
	</form>	
  </div>
</div>
  	