<?php
/*
 Plugin Name: Baggagefreight Shipping
 Author: Baggagefreight Team
 Author URI: http://www.baggagefreight.com.au
 Version: 0.1.0
*/
ob_start();
session_start();
error_reporting(0);


global $wpdb;
global $woocommerce;
$pro_table_prefix=$wpdb->prefix;
define('PRO_TABLE_PREFIX', $pro_table_prefix);



register_activation_hook(__FILE__,'bf_install');
register_deactivation_hook(__FILE__ , 'bf_uninstall' );

function bf_install()
{

    global $wpdb;
    $pro_table_prefix=$wpdb->prefix;
	
    $structure = "CREATE TABLE IF NOT EXISTS `baggage_excel` (
	  `Id` int(11) NOT NULL AUTO_INCREMENT,
	  `SKU` varchar(200) NOT NULL,
	  `Weight` varchar(200) NOT NULL,
	  `Height` varchar(200) NOT NULL,
	  `Width` varchar(200) NOT NULL,
	  `Length` varchar(200) NOT NULL,
	  PRIMARY KEY (`Id`)
	);";
    $wpdb->query($structure);
	 
	$structure1 = "CREATE TABLE IF NOT EXISTS `baggage_storeowner` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `BFUid` int(11) NOT NULL,
  `sUrl` varchar(200) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Company` varchar(200) NOT NULL,
  `ContactName` varchar(200) NOT NULL,
  `Address` varchar(500) NOT NULL,
  `Address1` varchar(500) NOT NULL,
  `CollectCountry` varchar(200) NOT NULL,
  `CollectCity` varchar(200) NOT NULL,
  `CollectState` varchar(200) NOT NULL,
  `CollectZip` varchar(200) NOT NULL,
  `CollectEmail` varchar(200) NOT NULL,
  `CollectPhNo` varchar(200) NOT NULL,
  `HowManyShipments` varchar(200) NULL,
  `Status` char(1) NULL,
  PRIMARY KEY (`Id`)
)";
    $wpdb->query($structure1);	
	
	
	$structure2 = "CREATE TABLE IF NOT EXISTS `baggage_order` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Wp_Orderid` int(11) NOT NULL,
  `BfOrderId` varchar(200) NOT NULL,
  PRIMARY KEY (`Id`)
)";
    $wpdb->query($structure2);	
	
	
	$structure3 = "CREATE TABLE IF NOT EXISTS `baggage_settings` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `package_type` char(1) NOT NULL,
  `hfee` varchar(200) NOT NULL,
  `use_link` char(1) NOT NULL,
  `link_type` char(1) NOT NULL,
  PRIMARY KEY (`Id`)
)";
    $wpdb->query($structure3);
	
	
	
	$structure4 = "CREATE TABLE IF NOT EXISTS `baggage_dimensions` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `height` varchar(200) NOT NULL,
  `width` varchar(200) NOT NULL,
  `length` varchar(200) NOT NULL,
  PRIMARY KEY (`Id`)
)";
    $wpdb->query($structure4);
		

	
}


function bf_uninstall()
{

    global $wpdb;
    $pro_table_prefix=$wpdb->prefix;
	
    $structure = "drop table if exists `baggage_excel`";
    $wpdb->query($structure);  
	
	$structure1 = "drop table if exists `baggage_storeowner`";
    $wpdb->query($structure1); 
	
	$structure2 = "drop table if exists `baggage_order`";
    $wpdb->query($structure2); 
	
	$structure3 = "drop table if exists `baggage_settings`";
    $wpdb->query($structure3); 
	
	$structure4 = "drop table if exists `baggage_dimensions`";
    $wpdb->query($structure4); 
	
	$sql_pages = "select * from ".$pro_table_prefix."posts where post_title in('Cart','Checkout','Order Received')";
	$res_pages =  $wpdb->get_results($sql_pages, OBJECT); 
    foreach ($res_pages as $row_pages):
	 
		$id = $row_pages->ID;
		$post_content = $row_pages->post_content;
		$post_content =  str_replace("[baggage_link]"," ",$post_content);
		$new_content =  str_replace("[baggage_postorder]"," ",$post_content);

		
		$update_sql = "update ".$pro_table_prefix."posts set post_content='".$new_content."' where ID =".$id ;
		$wpdb->query($update_sql);
		   
	endforeach;
	
}

 
 add_action('admin_menu','pro_admin_menu_bf');

function pro_admin_menu_bf() { 
	add_menu_page(
		"Baggagefreight Shipping",
		"Baggagefreight Shipping",
		8,
		__FILE__,
		"pro_admin_dashboard"
		
	); 
	add_submenu_page(__FILE__,'Registration','Registration','8','store_owner','pro_admin_store_owner');
	
	add_submenu_page(__FILE__,'Settings','Settings','8','store_settings','pro_admin_bf_settings');
	
	add_submenu_page(__FILE__,'Default Freight Settings','Default Freight Settings','8','freight_settings','pro_admin_bf_freightsettings');
	
	add_submenu_page(__FILE__,'Product Freight Values','Product Freight Values','8','upload_package','pro_admin_upload_package');
	
	add_submenu_page(__FILE__,'Payment Options','Payment Options','8','payment_option','pro_payment_option');
	
	add_submenu_page(__FILE__,'Shipping Label','Shipping Label','8','bf_label','pro_admin_bf_label');
}


function pro_admin_dashboard()
{
   include 'dashboard.php';
}


 function pro_admin_store_owner()
{
	include 'store-owner.php';
}


function pro_admin_upload_package()
{
    
	include 'upload-package.php';
}

function pro_admin_bf_order()
{
    include 'bf_order.php';
}

function pro_admin_bf_label()
{
    include 'bf_label.php';
}


function pro_admin_bf_settings()
{
    include 'bf_settings.php';
}

function pro_admin_bf_freightsettings()
{
    include 'bf_freightsettings.php';
}

function pro_payment_option()
{
  include("bf_payment.php");
}
 

function post_order($order_id) 
{
	global $woocommerce;
    global $wpdb;
	$prefix = $wpdb->prefix;
       
	$order_obj = new WC_Order( $order_id );
	$special_instruction =  $order_obj->customer_note;
	
	$shipping_method = get_post_meta($order_id, '_shipping_method', true);
	

	
	if(trim($shipping_method)=="")
	{
		$shipping_method = $woocommerce->session->chosen_shipping_methods[0]; 
	}
	
	
	
	$shipping_method = trim($shipping_method);
	
		
	
	
 	if($shipping_method=="bf_shipping" || $shipping_method=="bf_shipping1")
		{
			
			 
			$sql_setting = "select * from baggage_settings";
			$res_setting = $wpdb->get_row($wpdb->prepare($sql_setting));
			 
			 if(count($res_setting)>0)
			{
				$hfee = floatval($res_setting->hfee); 
			}
			else
			{
				$hfee = "0.00";
			}
			
			
			
			$Weight = $_SESSION["bf_Weight"] ;
			$Length = $_SESSION["bf_Length"];
			$Width = $_SESSION["bf_Width"] ;
			$Height = $_SESSION["bf_Height"];
			$Unit = $_SESSION["bf_Unit"] ;
			$strDescription = $_SESSION["bf_strDescription"] ;
			
			$strCarrier = $_SESSION["bf_strCarrier"];
			$strService = $_SESSION["bf_strService"];
			
			if($shipping_method=="bf_shipping1")
			{
			  $coverCost = floatval($_SESSION["bf_warranty"]);
			}
			else
			{
			  $coverCost = 0;
			}
			
			$strTransitTime = $_SESSION["bf_strTransitTime"];
			
			$strBookingAmount = floatval($_SESSION["bf_strBookingAmount"]);
			$strBookingAmount = $strBookingAmount-$hfee;
			
			$strTotalBookingRate = floatval($_SESSION["bf_strTotalBookingRate"]);
			
			//============== Collection Data  Start==========//
			$sql_St = "select * from baggage_storeowner";
			$row_St = $wpdb->get_row($sql_St,OBJECT);
			
			
			
			$CollectCountry = $row_St->CollectCountry;
			$strUrl = "http://www.baggagefreight.com.au/api/getCountryName.aspx?countryid=".$CollectCountry;
			$strCollectCountry = file_get_contents($strUrl);
			$strCollectCity = $row_St->CollectCity;
			$strCollectState = $row_St->CollectState;
			$strCollectZip = $row_St->CollectZip;
			$strCollectCompany = $row_St->Company;
			$strCollContactName = $row_St->ContactName;
			$strCollectAddress = $row_St->Address;
			$strCollectAddress1 = $row_St->Address1;
			$strCollectCity = $row_St->CollectCity;
			$strCollectState = $row_St->CollectState;
			$strCollectZip = $row_St->CollectZip;
			$strCollectState = $row_St->CollectState;
			$strCollectEmail = $row_St->CollectEmail;
			$strCollectPhNo = $row_St->CollectPhNo;
			$strEmail = $row_St->Email;
			$strPassword = $row_St->Password;
			
			//============== Collection Data End=============//
			
			

			
			//============== Destinatio Data Start===========//
			$strDestCountry = get_post_meta($order_id, '_shipping_country', true);
			$objC = new WC_Countries();
			$strDestCountry = $objC->countries[$strDestCountry];
			$strDestCity = get_post_meta($order_id, '_shipping_city', true);
			$strDestState = get_post_meta($order_id, '_shipping_state', true);
			$strDestZip = get_post_meta($order_id, '_shipping_postcode', true);
			$strDestEmail = get_post_meta($order_id, '_billing_email', true);
			$strDestPhNo = get_post_meta($order_id, '_billing_phone', true);
			$strDestContactName = get_post_meta($order_id, '_shipping_first_name', true)." ".get_post_meta($order_id, '_shipping_last_name', true);
			$strDestCompany = get_post_meta($order_id, '_billing_company', true);
			$strDestAddress = get_post_meta($order_id, '_shipping_address_1', true);
			$strDestAddress1 = get_post_meta($order_id, '_shipping_address_2', true);
			
			//============== Destination Data End============//

			
			$data = array(
			'strInvoiceNumber' => $order_id,
			'strCarrier' => $strCarrier,
			'strService' => $strService,
			'strTotalBookingRate' => $strTotalBookingRate,
			'strBookingAmount' => $strBookingAmount,
			'strCollectCompany' => $strCollectCompany,
			'strCollContactName' => $strCollContactName,
			'strCollectAddress' => $strCollectAddress,
			'strCollectAddress1' => $strCollectAddress1,
			'strCollectCity' => $strCollectCity,
			'strCollectState' => $strCollectState,
			'strCollectZip' => $strCollectZip,
			'strCollectCountry' => $strCollectCountry,
			'strCollectEmail' => $strCollectEmail,
			'strCollectPhNo' => $strCollectPhNo,
			'strDestContactName' => $strDestContactName,
			'strDestEmail' => $strDestEmail,
			'strDestPhNo' => $strDestPhNo,
			'strDestCompany' => $strDestCompany,
			'strDestAddress' => $strDestAddress,
			'strDestAddress1' => $strDestAddress1,
			'strDestCity' => $strDestCity,
			'strDestState' => $strDestState,
			'strDestZip' => $strDestZip,
			'strDestCountry' => $strDestCountry,
			'strEmail' => $strEmail,
			'strPassword' => $strPassword,
			'coverCost' => $coverCost,
			'strTransitTime' => $strTransitTime,
			'strDescription' => $strDescription,
			'arrWeight' => $Weight,
			'arrLength' => $Length,
			'arrWidth' => $Width,
			'arrHeight' => $Height,
			'arrUnit' => $Unit,
			'special_instruction' => $special_instruction,
			'strUrl' => $_SERVER['SERVER_NAME']
			);
			
		
      
			
			$ch = curl_init('http://www.baggagefreight.com.au/api/doBooking.aspx');                                                                      
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
			curl_setopt($ch, CURLOPT_POST, 1);                                                                    
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                                                                  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      																					   
			
			$result = curl_exec($ch);
			
			
		
	  } 
	 
  
  
}


function post_link()
{
ob_start();

$use_link = "0";
$link_type = "0";

$strLnk = "";

$sql_lnk = "select * from baggage_settings";
$res_lnk = $wpdb->get_row($sql_lnk, OBJECT);

if(count($res_lnk)>0)
{
   $row_lnk = $wpdb->get_row($sql_lnk, OBJECT);
   $use_link = $row_lnk->use_link;
   $link_type = $row_lnk->link_type;
 
}



//echo "<br><br><p>$strLnk</p>";

$result = ob_get_contents();
ob_end_clean();
return $result;
   


} 
 

add_action('woocommerce_checkout_update_order_meta', 'post_order');



add_shortcode('baggage_link', 'post_link');


include("class-wc-baggagefreight.php"); 



 