<?php

$sql = "select * from baggage_storeowner";

$res = mysql_query($sql);

$cnt = mysql_num_rows($res);

$row = mysql_fetch_assoc($res);





$curlUrl = "http://www.baggagefreight.com.au/api/createStoreOwner.aspx";



$Email = $row["Email"];

$sUrl = $row["sUrl"]; 

$Password = $row["Password"];

$Company = $row["Company"];

$ContactName = $row["ContactName"];

$Address = $row["Address"];

$Address1 = $row["Address1"];

$CollectCountry = $row["CollectCountry"];

$CollectCity = $row["CollectCity"];

$CollectState = $row["CollectState"];

$CollectZip = $row["CollectZip"];

$CollectEmail = $row["CollectEmail"];

$CollectPhNo = $row["CollectPhNo"];

$HowManyShipments = $row["HowManyShipments"];



if($_REQUEST["editp"])

{

	$editp = $_REQUEST["editp"];

	

	if($editp!="")

	{

	  if($editp == md5($Email))

	  {

			$action = "u";

			

			$data = array(

			'Name' => $ContactName,  

			'Email' => $Email,      

			'Password' => $Password,  

			'Phone' => $CollectPhNo,

			'Address1' => $Address,   

			'CompanyName' => $Company,            

			'Website' => $sUrl,       

			'HowManyShipments' => $HowManyShipments,

			'action' => $action 

			); 

			

			$ch = curl_init($curlUrl);                                                             

			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 

			curl_setopt($ch, CURLOPT_POST, 1);                                                                    

			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                                                                  

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      

			$result = curl_exec($ch);

			$result = trim($result);

			

			if($result > 0)

			{

			   $updt_sql = "update baggage_storeowner set Status='1'";

			   mysql_query($updt_sql);

			   $msg = "Data saved successfully";

			}

			else

			{

			   $msg = "Some error occured! please try again later.";

			}

	  }

	  else

	  {

		header("Location:admin.php?page=store_owner");

	  }

	}

}











if($_POST['Email']!='')

{	



	 

$Email = $_POST["Email"];

$sUrl = $_POST["sUrl"];

$Password = $_POST["Password"];

$Password2 = $_POST["Password2"];

$Company = $_POST['Company'];

$ContactName = $_POST['ContactName'];

$Address = $_POST['Address'];

$Address1 = $_POST['Address1'];

$CollectCountry = $_POST['CollectCountry'];

$CollectCity = $_POST["CollectCity"];

$CollectState = $_POST["CollectState"];

$CollectZip = $_POST["CollectZip"];

$CollectEmail = $_POST["CollectEmail"];

$CollectPhNo = $_POST["CollectPhNo"];

$HowManyShipments = $_POST["HowManyShipments"];





$cntSql = "select count(*) cnt from baggage_storeowner where Status='1'";

$resCnt = mysql_query($cntSql);

$rowCnt = mysql_fetch_assoc($resCnt);



$action = "i";





$data = array(

			'Name' => $ContactName,  

			'Email' => $Email,      

			'Password' => $Password,  

			'Phone' => $CollectPhNo,

			'Address1' => $Address,   

			'CompanyName' => $Company,            

			'Website' => $sUrl,       

			'HowManyShipments' => $HowManyShipments,

			'action' => $action 

			);   

     



$ch = curl_init($curlUrl);

                                                                      

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 

curl_setopt($ch, CURLOPT_POST, 1);                                                                    

curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                                                                  

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      



$result = curl_exec($ch);

$result = trim($result);

//echo $result;





if($result>0)

{

  $Status = "1";

}

else

{

  $Status = "0";

}

	 

	 $del_sql = "delete from baggage_storeowner";

	 mysql_query($del_sql);

	 

	 

	 $insert_sql = "insert into `baggage_storeowner`(`BFUid`,`Email`,`sUrl`,`Password`,`Company`,`ContactName`,`Address`,`Address1`,`CollectCountry`,`CollectCity`,`CollectState`,`CollectZip`,`CollectEmail`,`CollectPhNo`,`HowManyShipments`,`Status`)"; 

	 $insert_sql = $insert_sql." values('1','".$Email."','".$sUrl."','".$Password."','".$Company."','".$ContactName."','".$Address."','".$Address1."','".$CollectCountry."','".$CollectCity."','".$CollectState."','".$CollectZip."','".$CollectEmail."','".$CollectPhNo."','".$HowManyShipments."','".$Status."')"; 

	 

	 

	 

	 mysql_query($insert_sql);



	 

	 if($result!="")

	 {

	 

		 if(strval($result) == "-1")

		 {

		 

		   if($rowCnt["cnt"]==0)

		   {

		     

			 $editp = md5($Email);

			 

			 $msg = "We already have the email <strong>".$Email."</strong> in our database. <br> Would you like to

use this account for your website ?   <a href='admin.php?page=store_owner&editp=$editp' class='button button-primary button-large'>Yes</a>  <a href='admin.php?page=store_owner' class='button button-primary button-large'>No</a>";

		   }

		   else

		   {

 

					$action = "u";

					

					$data = array(

					'Name' => $ContactName,  

					'Email' => $Email,      

					'Password' => $Password,  

					'Phone' => $CollectPhNo,

					'Address1' => $Address,   

					'CompanyName' => $Company,            

					'Website' => $sUrl,       

					'HowManyShipments' => $HowManyShipments,

					'action' => $action 

					);   

					

					

					$ch1 = curl_init($curlUrl);                                                                      

					curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, "POST"); 

					curl_setopt($ch1, CURLOPT_POST, 1);                                                                    

					curl_setopt($ch1, CURLOPT_POSTFIELDS, $data);                                                                  

					curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);                                                                      

					

					$result1 = curl_exec($ch1);

					

					$update_sql = "update baggage_storeowner set Status='1'";

					mysql_query($update_sql);

					

					$msg = "Data saved successfully";

		   

		   }

		 }

		 else if($result=="0")

		 {

		    $msg = "Some error occured! please try again later.";

		 }

		 else

		 { 

		   $msg = "Data saved successfully";

		 }

	 }

	 

}





wp_enqueue_script( 'jQv',site_url().'/wp-content/plugins/baggage_shipping/js/validate.js', array(), '1.0.0', true );



?>





<script>



jQuery().ready(function() {

	

	// validate signup form on keyup and submit



	jQuery("#frmso").validate({

		rules: {

			Email: {

				required: true,

				email: true

			},

			sUrl: {

			  required: true,

			},

			Password: {

				required: true,

				minlength: 5

			},

			Password2: {

				required: true,

				minlength: 5,

				equalTo: "#Password"

			},

			ContactName: {

				required: true,

			},

			Company: {

				required: true,

			},

			CollectEmail: {

				required: true,

			},

			Address: {

				required: true,

			},

			CollectCountry: {

				required: true,

			},

			CollectState: {

				required: true,

			},

			CollectZip: {

				required: true,

			},

			CollectPhNo: {

				required: true,

			},

			HowManyShipments: {

				required: true,

			},

			agree: "required"

		},

		messages: {

			Email: "Please enter valid email",

			sUrl: "Please enter your url",

			ContactName: "Please enter contact name",

			Company: "Please enter company name",

			CollectEmail: "Please enter collection Email Address",

			Address: "Please enter street address",

			CollectCountry: "Please enter collection country",

			CollectState: "Please enter collection state",

			CollectZip: "Please enter collection zip",

			CollectPhNo: "Please enter collection phone number",

			HowManyShipments: "Please enter estimated no of monthly Shipments",

			Password: {

				required: "Please provide a password",

				minlength: "Your password must be at least 5 characters long"

			},

			Password2: {

				required: "Please provide a password",

				minlength: "Your password must be at least 5 characters long",

				equalTo: "Please enter the same password as above"

			},

			agree: " Please accept terms and conditions"

		}

	});

	});

	

	



	

	</script>



<style>

.error

{

 color:#FF0000;

 }

</style>





<div id="contenthome" style="margin-left:20px;">

  <div id="box">

    <h3 align="left">Store Owner Setup</h3> 

	<br />



      <form id="frmso" name="form1" action="admin.php?page=store_owner" method="post" >

      <fieldset class="error" style="border:none;"> </fieldset>

			

			<?php

			if($msg)

			{?>

			

			<div class="error"><?php echo $msg ?></div>

			

			<?php

			}?>

			

      <div align="center" class="postbox" style="width:90%;">

	  

	  <h3 class="hndle" style="height:35px; padding-top:20px;">

<span ><strong>Please fill in the registration form below to gain permission to use and access our best shipping rates.  Our shipping module will not display rates or allow you to generate shipping labels without Baggage Freight's prior approval.</strong></span>

</h3>



<div class="inside" id="dv1"	>  

	  

	       <table width="100%" border="0" cellspacing="2" cellpadding="2">

				 

				  <tr>

					<td align="right">Store Owner Email </td>

					<td align="center">:</td>

					<td align="left"><input type="text" name="Email" id="Email" value="<?php echo $Email?>" size="47"  /></td>

				  </tr>

				  <tr>

				    <td align="right">Your URL</td>

				    <td align="center">:</td>

				    <td align="left"><input type="text" name="sUrl" id="sUrl" value="<?php echo $sUrl?>" size="47"></td>

		     </tr>

				  <tr>

					<td align="right">Create a Password </td>

					<td align="center">:</td>

					<td align="left"><input type="password" name="Password" id="Password" value="<?php echo $Password?>" size="47" /></td>

				  </tr>

				  <tr>

				    <td align="right">Confirm Password </td>

				    <td align="center">:</td>

				    <td align="left"><input type="password" name="Password2" id="Password2" value="<?php echo $Password2?>" size="47" /></td>

		     </tr>

				  <tr>

					<td width="29%" align="right">Full Name</td>

					<td width="8%" align="center">:</td>

					<td width="63%" align="left">

				    <input type="text" name="ContactName" id="ContactName" value="<?php echo $ContactName?>" size="47" />   </td>

				  </tr>

				  

				

				  <tr>

					<td align="right"> Company Name </td>

					<td align="center">:</td>

					<td align="left"><input type="text" name="Company" id="Company" value="<?php echo $Company?>" size="47" /></td>

				  </tr>

				  <tr>

					<td align="right">Collection Email Address </td>

					<td align="center">:</td>

					<td align="left"><input type="text" name="CollectEmail" id="CollectEmail" value="<?php echo $CollectEmail?>" size="47" /></td>

				  </tr>

				  <tr>

					<td align="right">Collection Street Address </td>

					<td align="center">:</td>

					<td align="left"><textarea name="Address" id="Address" cols="43" rows="5"><?php echo $Address?></textarea></td>

				  </tr>

				  <tr>

					<td align="right"> Address1 </td>

					<td align="center">:</td>

					<td align="left"><textarea name="Address1" id="Address1" cols="43" rows="5"><?php echo $Address1?></textarea></td>

				  </tr>

				  <tr>

					<td align="right">Collection Country </td>

					<td align="center">:</td>

					<td align="left">

					

					<select name="CollectCountry" id="CollectCountry" tabindex="1"   >

					<option value="1">Afghanistan</option>

					<option value="2">Albania</option>

					<option value="3">Algeria</option>

					<option value="219">American Samoa</option>

					<option value="4">Andorra</option>

					<option value="5">Angola</option>

					<option value="6">Anguilla</option>

					<option value="246">ANTIGUA</option>

					<option value="7">Antigua and Barbuda</option>

					<option value="8">Argentina</option>

					<option value="9">Armenia</option>

					<option value="10">Aruba</option>

					<option value="11">Australia</option>

					<option value="12">Austria</option>

					<option value="13">Azerbaijan</option>

					<option value="14">Bahamas</option>

					<option value="15">Bahrain</option>

					<option value="16">Bangladesh</option>

					<option value="17">Barbados</option>

					<option value="18">Belarus</option>

					<option value="19">Belgium</option>

					<option value="20">Belize</option>

					<option value="21">Benin</option>

					<option value="22">Bermuda</option>

					<option value="23">Bhutan</option>

					<option value="24">Bolivia</option>

					<option value="236">Bonaire</option>

					<option value="247">BOSNIA AND HERZEGOVINA</option>

					<option value="25">Bosnia-Herzegovina</option>

					<option value="26">Botswana</option>

					<option value="27">Brazil</option>

					<option value="28">British Virgin Islands</option>

					<option value="248">BRUNEI</option>

					<option value="29">Brunei Darussalam</option>

					<option value="30">Bulgaria</option>

					<option value="31">Burkina Faso</option>

					<option value="32">Burma</option>

					<option value="33">Burundi</option>

					<option value="34">Cambodia</option>

					<option value="35">Cameroon</option>

					<option value="36">Canada</option>

					<option value="225">Canary Islands, The</option>

					<option value="37">Cape Verde</option>

					<option value="38">Cayman Islands</option>

					<option value="39">Central African Republic</option>

					<option value="40">Chad</option>

					<option value="41">Chile</option>

					<option value="245">CHINA, PEOPLE'S REPUBLIC</option>

					<option value="43">Christmas Island (Australia)</option>

					<option value="44">Cocos Island (Australia)</option>

					<option value="45">Colombia</option>

					<option value="46">Comoros</option>

					<option value="243">CONGO</option>

					<option value="47">Congo (Brazzaville),Republic of the</option>

					<option value="48">Congo, Democratic Republic of the</option>

					<option value="220">Congo, The Democratic Republic of</option>

					<option value="244">COOK ISLANDS</option>

					<option value="49">Cook Islands (New Zealand)</option>

					<option value="50">Costa Rica</option>

					<option value="221">Cote d'Ivoire</option>

					<option value="51">Croatia</option>

					<option value="52">Cuba</option>

					<option value="237">Curacao</option>

					<option value="53">Cyprus</option>

					<option value="54">Czech Republic</option>

					<option value="250">CZECH REPUBLIC, THE</option>

					<option value="55">Denmark</option>

					<option value="56">Djibouti</option>

					<option value="57">Dominica</option>

					<option value="58">Dominican Republic</option>

					<option value="276">EAST TIMOR</option>

					<option value="59">East Timor (Indonesia)</option>

					<option value="60">Ecuador</option>

					<option value="61">Egypt</option>

					<option value="62">El Salvador</option>

					<option value="63">Equatorial Guinea</option>

					<option value="64">Eritrea</option>

					<option value="65">Estonia</option>

					<option value="66">Ethiopia</option>

					<option value="67">Falkland Islands</option>

					<option value="68">Faroe Islands</option>

					<option value="69">Fiji</option>

					<option value="70">Finland</option>

					<option value="71">France</option>

					<option value="72">French Guiana</option>

					<option value="267">FRENCH GUYANA</option>

					<option value="73">French Polynesia</option>

					<option value="74">Gabon</option>

					<option value="75">Gambia</option>

					<option value="266">GEORGIA</option>

					<option value="76">Georgia, Republic of</option>

					<option value="77">Germany</option>

					<option value="79">Gibraltar</option>

					<option value="81">Greece</option>

					<option value="82">Greenland</option>

					<option value="83">Grenada</option>

					<option value="84">Guadeloupe</option>

					<option value="224">Guam</option>

					<option value="85">Guatemala</option>

					<option value="223">Guernsey</option>

					<option value="86">Guinea</option>

					<option value="268">GUINEA REPUBLIC</option>

					<option value="87">Guinea-Bissau</option>

					<option value="269">GUINEA-EQUATORIAL</option>

					<option value="88">Guyana</option>

					<option value="270">GUYANA (BRITISH)</option>

					<option value="89">Haiti</option>

					<option value="90">Honduras</option>

					<option value="91">Hong Kong</option>

					<option value="92">Hungary</option>

					<option value="93">Iceland</option>

					<option value="94">India</option>

					<option value="95">Indonesia</option>

					<option value="96">Iran</option>

					<option value="254">IRAN (ISLAMIC REPUBLIC OF)</option>

					<option value="97">Iraq</option>

					<option value="98">Ireland</option>

					<option value="253">IRELAND, REPUBLIC OF</option>

					<option value="99">Israel</option>

					<option value="100">Italy</option>

					<option value="101">Jamaica</option>

					<option value="102">Japan</option>

					<option value="255">JERSEY</option>

					<option value="103">Jordan</option>

					<option value="104">Kazakhstan</option>

					<option value="105">Kenya</option>

					<option value="106">Kiribati</option>

					<option value="257">KOREA, REPUBLIC OF</option>

					<option value="226">Korea, The D.P.R of</option>

					<option value="227">Kosovo </option>

					<option value="107">Kuwait</option>

					<option value="108">Kyrgyzstan</option>

					<option value="258">LAO PEOPLE'S DEMOCRATIC REPUBLIC</option>

					<option value="109">Laos</option>

					<option value="110">Latvia</option>

					<option value="111">Lebanon</option>

					<option value="112">Lesotho</option>

					<option value="113">Liberia</option>

					<option value="114">Libya</option>

					<option value="115">Liechtenstein</option>

					<option value="116">Lithuania</option>

					<option value="117">Luxembourg</option>

					<option value="118">Macao</option>

					<option value="263">MACAU</option>

					<option value="119">Macedonia, Republic of</option>

					<option value="120">Madagascar</option>

					<option value="121">Malawi</option>

					<option value="122">Malaysia</option>

					<option value="123">Maldives</option>

					<option value="124">Mali</option>

					<option value="125">Malta</option>

					<option value="229">Marshall Islands</option>

					<option value="126">Martinique</option>

					<option value="127">Mauritania</option>

					<option value="128">Mauritius</option>

					<option value="281">MAYOTTE</option>

					<option value="129">Mayotte (France)</option>

					<option value="130">Mexico</option>

					<option value="222">MICRONESIA, FEDERATED STATES OF </option>

					<option value="131">Moldova</option>

					<option value="261">MOLDOVA, REPUBLIC OF</option>

					<option value="132">Monaco (France)</option>

					<option value="133">Mongolia</option>

					<option value="228">Montenegro, Republic of</option>

					<option value="134">Montserrat</option>

					<option value="135">Morocco</option>

					<option value="136">Mozambique</option>

					<option value="262">MYANMAR</option>

					<option value="137">Namibia</option>

					<option value="138">Nauru</option>

					<option value="265">NAURU, REPUBLIC OF</option>

					<option value="139">Nepal</option>

					<option value="140">Netherlands</option>

					<option value="141">Netherlands Antilles</option>

					<option value="264">NETHERLANDS, THE</option>

					<option value="240">Nevis</option>

					<option value="142">New Caledonia</option>

					<option value="143">New Zealand</option>

					<option value="144">Nicaragua</option>

					<option value="145">Niger</option>

					<option value="146">Nigeria</option>

					<option value="231">Niue</option>

					<option value="147">Norway</option>

					<option value="148">Oman</option>

					<option value="149">Pakistan</option>

					<option value="233">Palau</option>

					<option value="150">Panama</option>

					<option value="151">Papua New Guinea</option>

					<option value="152">Paraguay</option>

					<option value="153">Peru</option>

					<option value="154">Philippines</option>

					<option value="272">PHILIPPINES, THE</option>

					<option value="155">Pitcairn Island</option>

					<option value="156">Poland</option>

					<option value="157">Portugal</option>

					<option value="232">Puerto Rico</option>

					<option value="158">Qatar</option>

					<option value="159">Reunion</option>

					<option value="251">REUNION, ISLAND OF</option>

					<option value="160">Romania</option>

					<option value="161">Russia</option>

					<option value="252">RUSSIAN FEDERATION, THE</option>

					<option value="162">Rwanda</option>

					<option value="163">Saint Helena</option>

					<option value="164">Saint Kitts (St. Christopher and Nevis)</option>

					<option value="165">Saint Lucia</option>

					<option value="166">Saint Pierre and Miquelon</option>

					<option value="167">Saint Vincent and the Grenadines</option>

					<option value="230">Saipan</option>

					<option value="279">SAMOA</option>

					<option value="168">San Marino</option>

					<option value="169">Sao Tome and Principe</option>

					<option value="170">Saudi Arabia</option>

					<option value="171">Senegal</option>

					<option value="234">Serbia, Republic of </option>

					<option value="172">Serbia-Montenegro</option>

					<option value="173">Seychelles</option>

					<option value="174">Sierra Leone</option>

					<option value="175">Singapore</option>

					<option value="176">Slovak Republic</option>

					<option value="274">SLOVAKIA</option>

					<option value="177">Slovenia</option>

					<option value="178">Solomon Islands</option>

					<option value="179">Somalia</option>

					<option value="241">Somaliland, Rep of (North Somalia)</option>

					<option value="180">South Africa</option>

					<option value="181">South Georgia (Falkland Islands)</option>

					<option value="182">South Korea (Korea, Republic of)</option>

					<option value="183">Spain</option>

					<option value="184">Sri Lanka</option>

					<option value="242">St. Barthelemy</option>

					<option value="238">St. Eustatius</option>

					<option value="256">ST. KITTS</option>

					<option value="259">ST. LUCIA</option>

					<option value="239">St. Maarten</option>

					<option value="277">ST. VINCENT</option>

					<option value="185">Sudan</option>

					<option value="186">Suriname</option>

					<option value="187">Swaziland</option>

					<option value="188">Sweden</option>

					<option value="189">Switzerland</option>

					<option value="275">SYRIA</option>

					<option value="190">Syrian Arab Republic</option>

					<option value="271">TAHITI</option>

					<option value="191">Taiwan</option>

					<option value="192">Tajikistan</option>

					<option value="193">Tanzania</option>

					<option value="194">Thailand</option>

					<option value="195">Togo</option>

					<option value="196">Tokelau (Union) Group (Western Samoa)</option>

					<option value="197">Tonga</option>

					<option value="198">Trinidad and Tobago</option>

					<option value="199">Tunisia</option>

					<option value="200">Turkey</option>

					<option value="201">Turkmenistan</option>

					<option value="202">Turks and Caicos Islands</option>

					<option value="203">Tuvalu</option>

					<option value="204">Uganda</option>

					<option value="205">Ukraine</option>

					<option value="206">United Arab Emirates</option>

					<option value="80">United Kingdom</option>

					<option value="273">UNITED STATES OF AMERICA</option>

					<option value="207">Uruguay</option>

					<option value="208">Uzbekistan</option>

					<option value="209">Vanuatu</option>

					<option value="210">Vatican City</option>

					<option value="211">Venezuela</option>

					<option value="212">Vietnam</option>

					<option value="278">VIRGIN ISLANDS (BRITISH)</option>

					<option value="235">Virgin Islands (US)</option>

					<option value="213">Wallis and Futuna Islands</option>

					<option value="214">Western Samoa</option>

					<option value="215">Yemen</option>

					<option value="280">YEMEN, REPUBLIC OF</option>

					<option value="216">Zambia</option>

					<option value="217">Zimbabwe</option>

				</select>	

				

				<script>

				

				document.getElementById("CollectCountry").value = "<?php echo $CollectCountry?>";

				

				</script></td>

				  </tr>

				  <tr>

					<td align="right">Collection City </td>

					<td align="center">:</td>

					<td align="left"><input type="text" name="CollectCity" id="CollectCity" value="<?php echo $CollectCity?>" size="47" /></td>

				  </tr>

				  <tr>

					<td align="right">Collection State </td>

					<td align="center">:</td>

					<td align="left"><input type="text" name="CollectState" id="CollectState" value="<?php echo $CollectState?>" size="47" /></td>

				  </tr>

				  <tr>

					<td align="right">Collection Zip </td>

					<td align="center">:</td>

					<td align="left"><input type="text" name="CollectZip" id="CollectZip" value="<?php echo $CollectZip?>" size="47" /></td>

				  </tr>

				  

				  <tr>

					<td align="right">Collection Phone </td>

					<td align="center">:</td>

					<td align="left"><input type="text" name="CollectPhNo" id="CollectPhNo" value="<?php echo $CollectPhNo?>" size="47" /></td>

				  </tr>

				  <tr>

				    <td align="right">Estimated no of monthly Shipments</td>

				    <td align="center">:</td>

				    <td align="left"><input type="text" name="HowManyShipments" id="HowManyShipments" value="<?php echo $HowManyShipments?>" size="47" /></td>

		     </tr>

				  <tr>

					<td align="right">&nbsp;</td>

					<td align="center">&nbsp;</td>

					<td align="left">

					

					<input id="agree" name="agree" type="checkbox" <?php if($cnt>0){?> checked="checked" <?php }?> >

I have read the

<a target="_blank" href="http://www.baggagefreight.com.au/terms-condition.aspx">terms and conditions </a>					</td>

				  </tr>

				   <tr>

				     <td align="right">&nbsp;</td>

				     <td align="center"></td>

				     <td align="left">&nbsp;</td>

		     </tr>

				   <tr>

					<td align="right">&nbsp; </td>

					<td align="center"> </td>

					<td align="left"> <input id="button1" type="submit" name="submit" value="Submit" class="button button-primary button-large" /> </td>

				  </tr>

               </table>

	  

</div>	



      </div>

    </form>

  </div>

</div>