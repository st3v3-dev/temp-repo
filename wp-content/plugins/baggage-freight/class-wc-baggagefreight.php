<?php

 
 //add_action('plugins_loaded', 'init_baggage_shipping', 0);
 
 
 

function init_baggage_shipping() {

    if ( ! class_exists( 'WC_Shipping_Method' ) ) return;
class WC_BF_Shipping extends WC_Shipping_Method {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	function __construct() {
        $this->id 			= 'bf_shipping';
        $this->method_title = __('Baggage Freight Shipping', 'woocommerce');
		$this->init();
    }

    /**
     * init function.
     *
     * @access public
     * @return void
     */
    function init() {
		// Load the form fields.
		$this->init_form_fields();

		// Load the settings.
		$this->init_settings();

		// Define user set variables
       /* $this->enabled		= $this->settings['enabled'];
		$this->title 		= $this->settings['title'];
		$this->min_amount 	= $this->settings['min_amount'];
		$this->availability = $this->settings['availability'];
		$this->countries 	= $this->settings['countries'];
		$this->requires_coupon 	= $this->settings['requires_coupon'];
		*/
		
		$this->title		= $this->get_option( 'title' );
		$this->type 		= $this->get_option( 'type' );
		$this->fee			= $this->get_option( 'fee' );
		$this->type			= $this->get_option( 'type' );
		$this->codes		= $this->get_option( 'codes' );
		$this->availability	= $this->get_option( 'availability' );
		$this->countries	= $this->get_option( 'countries' );
		// Actions
		add_action('woocommerce_update_options_shipping_'.$this->id, array(&$this, 'process_admin_options'));
    }


    /**
     * Initialise Gateway Settings Form Fields
     *
     * @access public
     * @return void
     */
    function init_form_fields() {
    	global $woocommerce;

    	$this->form_fields = array(
			'enabled' => array(
							'title' 		=> __( 'Enable/Disable', 'woocommerce' ),
							'type' 			=> 'checkbox',
							'label' 		=> __( 'Enable Baggage Freight Shipping', 'woocommerce' ),
							'default' 		=> 'yes'
						),
			'title' => array(
							'title' 		=> __( 'Method Title', 'woocommerce' ),
							'type' 			=> 'text',
							'description' 	=> __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
							'default'		=> __( 'Baggage Freight Shipping', 'woocommerce' )
						),
			
			'availability' => array(
							'title' 		=> __( 'Method availability', 'woocommerce' ),
							'type' 			=> 'select',
							'default' 		=> 'all',
							'class'			=> 'availability',
							'options'		=> array(
								'all' 		=> __('All allowed countries', 'woocommerce'),
								'specific' 	=> __('Specific Countries', 'woocommerce')
							)
						),
			'countries' => array(
							'title' 		=> __( 'Specific Countries', 'woocommerce' ),
							'type' 			=> 'multiselect',
							'class'			=> 'chosen_select',
							'css'			=> 'width: 450px;',
							'default' 		=> '',
							'options'		=> $woocommerce->countries->countries
						)
			);

    }


	/**
	 * Admin Panel Options
	 * - Options for bits like 'title' and availability on a country-by-country basis
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_options() {

    	?>
    	<h3><?php _e('Baggage Freight Shipping', 'woocommerce'); ?></h3>
    	<p><?php _e('Baggage Freight Shipping ', 'woocommerce'); ?></p>
    	<table class="form-table">
    	<?php
    		$this->generate_settings_html();
    	?>
		</table>
    	<?php
		
    }


  
    function is_available( $package ) {
    	global $woocommerce;

    	if ( $this->enabled == "no" ) return false;

		$ship_to_countries = '';

		if ( $this->availability == 'specific' ) {
			$ship_to_countries = $this->countries;
		} else {
			if ( get_option('woocommerce_allowed_countries') == 'specific' )
				$ship_to_countries = get_option('woocommerce_specific_allowed_countries');
		}

		if ( is_array( $ship_to_countries ) )
			if ( ! in_array( $package['destination']['country'], $ship_to_countries ) )
				return false;

		// Enabled logic
		$is_available = true;

		if ( $this->requires_coupon == "yes" ) {

			if ( $woocommerce->cart->applied_coupons ) {
				foreach ($woocommerce->cart->applied_coupons as $code) {
					$coupon = new WC_Coupon( $code );

					if ( $coupon->enable_free_shipping() )
						return true;
				}
			}

			// No coupon found, as it stands, free shipping is disabled
			$is_available = false;

		}

		if ( isset( $woocommerce->cart->cart_contents_total ) && ! empty( $this->min_amount ) ) {

			if ( $woocommerce->cart->prices_include_tax )
				$total = $woocommerce->cart->tax_total + $woocommerce->cart->cart_contents_total;
			else
				$total = $woocommerce->cart->cart_contents_total;

			if ( $this->min_amount > $total )
				$is_available = false;
			else
				$is_available = true;

		}

		return apply_filters( 'woocommerce_shipping_' . $this->id . '_is_available', $is_available );
    }


    /**
     * calculate_shipping function.
     *
     * @access public
     * @return array
     */
    function calculate_shipping($package = array() ) 
	{

		global $woocommerce;
		global $wpdb;
		$prefix = $wpdb->prefix;
		$sql = "select * from baggage_storeowner";
		$res = mysql_query($sql);
		$row = mysql_fetch_assoc($res);
		
		
		
		$sql_setting = "select * from baggage_settings";
		$res_setting = mysql_query($sql_setting);
		
		if(mysql_num_rows($res_setting))
		{
			$row_setting = mysql_fetch_assoc($res_setting);
			$package_type = $row_setting["package_type"];
			$hfee = floatval($row_setting["hfee"]);
		}
		else
		{
			$package_type = "1";
			$hfee = "0.00";
		}
		
		$Email = trim($row["Email"]);
	    $Password = trim($row["Password"]);
		
		$sql_dimension = "select * from baggage_dimensions";
		$res_dimension = mysql_query($sql_dimension);
		if(mysql_num_rows($res_dimension))
		{
		  $row_dimension = mysql_fetch_assoc($res_dimension);
		  $d_height = $row_dimension["height"];
		  $d_width  = $row_dimension["width"];
		  $d_length = $row_dimension["length"];
		}
		else
		{
		  $d_height = "0";
		  $d_width = "0";
		  $d_length = "0";  
		}
	
		
	
		$CollectCountry = $row["CollectCountry"];
		$strUrl = "http://www.baggagefreight.com.au/api/getCountryName.aspx?countryid=".$CollectCountry;
		$cCountry = trim(file_get_contents($strUrl));
		$cCity = trim($row["CollectCity"]);
		$cState = trim($row["CollectState"]);
		$cPin = trim($row["CollectZip"]);
		
		$Weight = "";
		$Length = "";
		$Width  = "";
		$Height = "";
		$Unit = "";
		$Desc = "";
		
		
		$packedsku = '';
		$totweight = 0;
		$j=1;
		$k=0;
		$packeditem = NULL;
		
		
		$Amount =$woocommerce->cart->subtotal;
	
		
		$loop = 0;
		
		foreach ( $woocommerce->cart->get_cart() as $itms ) 
		{
		   $product_id = $itms["product_id"];
		   $quantity = $itms["quantity"];
	
		   
		   $post_data = get_post($product_id); 
		   $product_title = $post_data->post_title;
		   
		   $sql_SKU = "select meta_value from ".$prefix."postmeta where post_id=".$product_id." and meta_key='_sku'";
		   $res_Sku = mysql_query($sql_SKU);
		   $row_sku = mysql_fetch_assoc($res_Sku);
		   $sku = $row_sku["meta_value"];
		   
		   $strDestCountry = get_post_meta($product_id, '_shipping_country', true);
		   
		   
		   if($package_type=="1")
		   {
			  $W = trim(get_post_meta($product_id, '_weight', true));
			  $L = trim(get_post_meta($product_id, '_length', true));
			  $Wi = trim(get_post_meta($product_id, '_width', true));
			  $H = trim(get_post_meta($product_id, '_height', true));
		   }
		   else
		   {
			   $sql = "select * from baggage_excel where SKU='$sku'";
			   $res = mysql_query($sql);
			   $row = mysql_fetch_assoc($res);
			   
			   $W = $row["Weight"];
			   $L = $row["Length"];
			   $Wi = $row["Width"]; 
			   $H = $row["Height"]; 
		   } 
		   
		   
		   if($L == "")
		   {
			  $L = $d_length;  
		   }
		   
		   if($Wi == "")
		   {
			  $Wi = $d_width;  
		   }
		   
		   if($H == "")
		   {
			  $H = $d_height;  
		   }
		   if($W == "")
		   {
			   $W = 0;
		   }
		   
		   
		   
				for($i=1;$i<=$quantity;$i++)
				{
						 $Weight = $Weight.$W.",";
						 $Length = $Length.$L.",";
						 $Width  = $Width.$Wi.",";
						 $Height = $Height.$H.",";
						 $Unit   = $Unit."cm,";
						 $strDescription = $sku;
						 if(strlen($strDescription) > 30)
						 {
							$strDescription = substr($strDescription, 0, 29);
						 }
						 
						 $strDescription = str_replace(",","",$strDescription);
						 
						 $Desc   = $Desc.$strDescription.",";	
							 
				 }
		   
		
	
		}
		
		
		
		$Weight = substr($Weight, 0, -1);
		if($Weight[strlen($Weight)-1]==",")
		{
		   $Weight = substr($Weight, 0, -1);
		}
		$Length = substr($Length, 0, -1);
		if($Length[strlen($Length)-1]==",")
		{
		   $Length = substr($Length, 0, -1);
		}
		$Width  = substr($Width, 0, -1);
		if($Width[strlen($Width)-1]==",")
		{
		   $Width = substr($Width, 0, -1);
		}
		$Height = substr($Height, 0, -1);
		if($Height[strlen($Height)-1]==",")
		{
		   $Height = substr($Height, 0, -1);
		}
		$Unit   =  substr($Unit, 0, -1);
		if($Unit[strlen($Unit)-1]==",")
		{
		   $Unit = substr($Unit, 0, -1);
		}
		$Desc   =  substr($Desc, 0, -1);
		if($Desc[strlen($Desc)-1]==",")
		{
		   $Desc = substr($Desc, 0, -1);
		}
	
		
		$dCountry = trim($package["destination"]["country"]); 	
		$dState = trim($package["destination"]["state"]);
		$dPin = trim($package["destination"]["postcode"]);
		$dCity = trim($package["destination"]["city"]);
		
		$address = trim($package["destination"]["address"]);
		$address_2 = trim($package["destination"]["address_2"]);
		
		$objC = new WC_Countries();
		$dCountry = trim($objC->countries[$dCountry]);
		
		
		
		  if($dPin!="")
		  {
				$data = array(

					'Email' => $Email,
					
					'Password' => $Password,
					
					'Tech' => 'Wordpress',
					
					'cCountry' => $cCountry,  

					'cCity' => $cCity,      

					'cState' => $cState,          

					'cPin' => $cPin,

					'dCountry' => $dCountry,   

					'dState' => $dState,            

					'dCity' => $dCity,       

					'dPin' => $dPin,            

					'Weight' => $Weight,          

					'Length' => $Length,          

					'Width' => $Width,           

					'Height' => $Height,          

					'Unit' => $Unit,   
					
					'Server' => $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'],          

					'Amount' => $Amount  

				); 


				   


				
				$ch = curl_init('http://www.baggagefreight.com.au/api/apiminrate.aspx');                                                        
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
				curl_setopt($ch, CURLOPT_POST, 1);                                               
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                                                 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                         
				$result = curl_exec($ch);
				
	
				
		  
			   if($result)
			   {
			   
					$arrBFIShipping = explode(":",$result);
					$ship_cost = floatval($arrBFIShipping[0]);
					$_SESSION["bf_strBookingAmount"] = $ship_cost;
					$carrier = $arrBFIShipping[1];
					$_SESSION["bf_strCarrier"] = $carrier;
					$service = $arrBFIShipping[2];
					$_SESSION["bf_strService"] = $service;
					$transit = $arrBFIShipping[4];
					
					$warranty = floatval($arrBFIShipping[5]);
					
					$arrTransit = explode(" ",$transit);
					$transitTime = $arrTransit[0];
					$_SESSION["bf_strTransitTime"] = $transitTime;
					$_SESSION["bf_warranty"] = $warranty;
			   
	 
					if(floatval($ship_cost)>0)
					{
						
						$_SESSION["bf_Weight"] = $Weight;
						$_SESSION["bf_Length"] = $Length;
						$_SESSION["bf_Width"]  = $Width;
						$_SESSION["bf_Height"] = $Height;
						$_SESSION["bf_strDescription"]   = $Desc;
						$_SESSION["bf_Unit"]   = $Unit;
						
						$_SESSION["bf_booking"] = "1";
						$_SESSION["bf_strTotalBookingRate"] = $Amount;
						
						
						$args= array(
						'id' 	=> $this->id,
						'label' => $service." (Without Transit Warranty)",
						'cost' 	=> $ship_cost
						  );
						
						
						$this->add_rate( $args );
						
						
						if($warranty>0)
						{
						  $ship_cost = $ship_cost+$warranty;
						
						$args= array(
						'id' 	=> $this->id."1",
						'label' => $service." (With Transit Warranty)",
						'cost' 	=> $ship_cost
						  );
						  }
						
						
						$this->add_rate( $args );
					}
				}
			}
			
	
		
	}

 }

}

function add_bf_shipping_method( $methods ) {
	$methods[] = 'WC_BF_Shipping';
	return $methods;
}

function custom_woocommerce_billing_fields( $fields ) {


   /*$fields['billing_city']	= array(
      'label'          => __('Town/City', 'woocommerce'),
      'placeholder'    => _x('Town/City', 'placeholder', 'woocommerce'),
      'required'       => true,
      'class'          => array('form-row-first', 'update_totals_on_change')
   );*/
   
   $fields['billing_city']['class'] = array('form-row-first', 'update_totals_on_change');
   
  

 return $fields;
}

//add_filter( 'woocommerce_billing_fields', 'custom_woocommerce_billing_fields' );




function custom_woocommerce_shipping_fields( $fields ) {

   /*$fields['shipping_city']	= array(
     'label'          => __('Town/City', 'woocommerce'),
      'placeholder'    => __('Town/City', 'placeholder', 'woocommerce'),
      'required'       => true,
      'class'          => array('form-row-first', 'update_totals_on_change')
   );*/
   
   $fields['shipping_city']['class'] = array('form-row-first','update_totals_on_change');

 return $fields;
}

//add_filter( 'woocommerce_shipping_fields', 'custom_woocommerce_shipping_fields');



add_action( 'woocommerce_shipping_init', 'init_baggage_shipping',0 );

add_filter('woocommerce_shipping_methods', 'add_bf_shipping_method' );