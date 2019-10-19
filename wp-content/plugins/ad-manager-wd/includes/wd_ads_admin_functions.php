<?php

/**
 *  Ad Manager WD Admin functions
 */


/*export statistics*/


/*filtering array for statistics	*/
function wd_ads_filter_array_by_date( $value ) {
	$year  = isset( $_POST['year'] ) ? $_POST['year'] : date( 'Y' );
	$month = isset( $_POST['month'] ) ? $_POST['month'] : date( 'n' );

	$wd_ads_stats_from = isset( $_POST['wd_ads_stats_from'] ) ? $_POST['wd_ads_stats_from'] : date( 'Y-m' ) . '-01';
	$wd_ads_stats_to   = isset( $_POST['wd_ads_stats_to'] ) ? $_POST['wd_ads_stats_to'] : date( 'Y-m-d' );


	if ( strtotime( $value ) >= strtotime( $wd_ads_stats_from ) and strtotime( $value ) <= strtotime( $wd_ads_stats_to ) ) {
		return $value;
	}

}

function wd_ads_countries() {
	return array(
		// Europe
		'EUROPE'        => "Europe",
		'AL'            => "Albania",
		'AM'            => "Armenia",
		'AD'            => "Andorra",
		'AT'            => "Austria",
		'AZ'            => "Azerbaijan",
		'BY'            => "Belarus",
		'BE'            => "Belgium",
		'BA'            => "Bosnia and Herzegovina",
		'BG'            => "Bulgaria",
		'HR'            => "Croatia",
		'CY'            => "Cyprus",
		'CZ'            => "Czech Republic",
		'DK'            => "Denmark",
		'EE'            => "Estonia",
		'FI'            => "Finland",
		'FR'            => "France",
		'GE'            => "Georgia",
		'DE'            => "Germany",
		'GR'            => "Greece",
		'HU'            => "Hungary",
		'IS'            => "Iceland",
		'IE'            => "Ireland",
		'IT'            => "Italy",
		'LV'            => "Latvia",
		'LI'            => "Liechtenstein",
		'LT'            => "Lithuania",
		'LU'            => "Luxembourg",
		'MK'            => "Macedonia",
		'MT'            => "Malta",
		'MD'            => "Moldova",
		'MC'            => "Monaco",
		'NL'            => "the Netherlands",
		'NO'            => "Norway",
		'PL'            => "Poland",
		'PT'            => "Portugal",
		'RO'            => "Romania",
		'SM'            => "San Marino",
		'RS'            => "Serbia and Montenegro",
		'ES'            => "Spain",
		'SK'            => "Slovakia",
		'SI'            => "Slovenia",
		'SE'            => "Sweden",
		'CH'            => "Switzerland",
		'VA'            => "Vatican City",
		'TR'            => "Turkey",
		'UA'            => "Ukraine",
		'GB'            => "United Kingdom",

		// South East Asia + Australia + New Zealand
		'SOUTHEASTASIA' => "Southeast Asia, Australia and New Zealand",
		'AU'            => "Australia",
		'BN'            => "Brunei",
		'KH'            => "Cambodia",
		'TL'            => "East Timor (Timor Timur)",
		'ID'            => "Indonesia",
		'LA'            => "Laos",
		'MY'            => "Malaysia",
		'MM'            => "Myanmar",
		'NZ'            => "New Zealand",
		'PH'            => "Philippines",
		'SG'            => "Singapore",
		'TH'            => "Thailand",
		'VN'            => "Vietnam",

		// North America
		'NORTHAMERICA'  => "North America",
		'AG'            => "Antigua and Barbuda",
		'BS'            => "Bahamas",
		'BB'            => "Barbados",
		'BZ'            => "Belize",
		'CA'            => "Canada",
		'CR'            => "Costa Rica",
		'CU'            => "Cuba",
		'DM'            => "Dominica",
		'DO'            => "Dominican Republic",
		'SV'            => "El Salvador",
		'GD'            => "Grenada",
		'GT'            => "Guatemala",
		'HT'            => "Haiti",
		'HN'            => "Honduras",
		'JM'            => "Jamaica",
		'MX'            => "Mexico",
		'NI'            => "Nicaragua",
		'PA'            => "Panama",
		'KN'            => "Saint Kitts and Nevis",
		'LC'            => "Saint Lucia",
		'VC'            => "Saint Vincent",
		'TT'            => "Trinidad and Tobago",
		'US'            => "United States",

		// South America
		'SOUTHAMERICA'  => "South America",
		'AR'            => "Argentina",
		'BO'            => "Bolivia",
		'BR'            => "Brazil",
		'CL'            => "Chile",
		'CO'            => "Colombia",
		'EC'            => "Ecuador",
		'GY'            => "Guyana",
		'PY'            => "Paraguay",
		'PE'            => "Peru",
		'SR'            => "Suriname",
		'UY'            => "Uruguay",
		'VE'            => "Venezuela",

		// Misc
		'MISC'          => "Rest of the world",
		'AF'            => "Afghanistan",
		'DZ'            => "Algeria",
		'AO'            => "Angola",
		'BH'            => "Bahrain",
		'BD'            => "Bangladesh",
		'BJ'            => "Benin",
		'BT'            => "Bhutan",
		'BF'            => "Burkina Faso",
		'BI'            => "Burundi",
		'CM'            => "Cameroon",
		'CV'            => "Cape Verde",
		'CF'            => "Central African Republic",
		'TD'            => "Chad",
		'CN'            => "China",
		'KM'            => "Comoros",
		'CG'            => "Congo (Brazzaville)",
		'CD'            => "Congo",
		'CI'            => "Cote d'Ivoire",
		'DJ'            => "Djibouti",
		'EG'            => "Egypt",
		'GQ'            => "Equatorial Guinea",
		'ER'            => "Eritrea",
		'ET'            => "Ethiopia",
		'FJ'            => "Fiji",
		'GA'            => "Gabon",
		'GM'            => "Gambia",
		'GH'            => "Ghana",
		'GN'            => "Guinea",
		'GW'            => "Guinea-Bissau",
		'IN'            => "India",
		'IR'            => "Iran",
		'IQ'            => "Iraq",
		'IS'            => "Israel",
		'JP'            => "Japan",
		'JO'            => "Jordan",
		'KZ'            => "Kazakhstan",
		'KE'            => "Kenya",
		'KI'            => "Kiribati",
		'KP'            => "north Korea",
		'KR'            => "south Korea",
		'KW'            => "Kuwait",
		'KG'            => "Kyrgyzstan",
		'LV'            => "Latvia",
		'LB'            => "Lebanon",
		'LS'            => "Lesotho",
		'LR'            => "Liberia",
		'LY'            => "Libya",
		'MG'            => "Madagascar",
		'MW'            => "Malawi",
		'MV'            => "Maldives",
		'MN'            => "Mongolia",
		'ML'            => "Mali",
		'MH'            => "Marshall Islands",
		'MR'            => "Mauritania",
		'MU'            => "Mauritius",
		'FM'            => "Micronesia",
		'MA'            => "Morocco",
		'MZ'            => "Mozambique",
		'NA'            => "Namibia",
		'NR'            => "Nauru",
		'NP'            => "Nepal",
		'NE'            => "Niger",
		'NG'            => "Nigeria",
		'OM'            => "Oman",
		'PK'            => "Pakistan",
		'PW'            => "Palau",
		'PG'            => "Papua New Guinea",
		'QA'            => "Qatar",
		'RU'            => "Russia",
		'RW'            => "Rwanda",
		'WS'            => "Samoa",
		'ST'            => "Sao Tome and Principe",
		'SA'            => "Saudi Arabia",
		'SN'            => "Senegal",
		'SC'            => "Seychelles",
		'SL'            => "Sierra Leone",
		'SB'            => "Solomon Islands",
		'SO'            => "Somalia",
		'ZA'            => "South Africa",
		'LK'            => "Sri Lanka",
		'SY'            => "Syria",
		'SD'            => "Sudan",
		'SZ'            => "Swaziland",
		'TW'            => "Taiwan",
		'TJ'            => "Tajikistan",
		'TO'            => "Tonga",
		'TM'            => "Turkmenistan",
		'TV'            => "Tuvalu",
		'TZ'            => "Tanzania",
		'TG'            => "Togo",
		'TN'            => "Tunisia",
		'UG'            => "Uganda",
		'AE'            => "United Arab Emirates",
		'UZ'            => "Uzbekistan",
		'VU'            => "Vanuatu",
		'YE'            => "Yemen",
		'ZM'            => "Zambia",
		'ZW'            => "Zimbabwe",
	);
}


function wd_ads_countries_chechbox( $countries_meta = '' ) {
	$countries_list = wd_ads_countries();
	$countries_meta = json_decode( $countries_meta, true );
	$action         = get_current_screen()->action;
	$check          = '';
	if ( $action == 'add' ) {
		$check = 'checked';
	}


	echo '<div disabled class="wd_ads_countries">';
	echo '<div><input disabled type="checkbox" id="all"';
	isset( $countries_meta['ALL'] ) ? checked( $countries_meta['ALL'], 1 ) : '';
	echo ' name="wd_ads[countries][ALL]" ' . $check . ' value="1" onchange="wd_ads_select_continent_all()"><b><label for="all"> Select All </label></b></div>';
	foreach ( $countries_list as $iso => $name ) {


		if ( strlen( $iso ) > 2 ) {
			$classname = $iso;
			echo '<div><input type="checkbox"';
			isset( $countries_meta[ $iso ] ) ? checked( $countries_meta[ $iso ], 1 ) : '';
			echo 'name="wd_ads[countries][' . $iso . ']" ' . $check . ' value="1" id="' . $iso . '" disabled onchange="wd_ads_select_continent(\'' . $iso . '\')" /> <b><label for="' . $iso . '">' . $name . '</label></b></div>';
		} else {

			echo '<div> --- ';
			echo '<input type="checkbox" disabled class="' . $classname . '" ' . $check . ' id="country_' . $iso . '" ';

			isset( $countries_meta[ $iso ] ) ? checked( $countries_meta[ $iso ], 1 ) : '';

			echo 'name="wd_ads[countries][' . $iso . ']"
                           value="1"  />
                           
                    <label for="country_' . $iso . '">' . $name . '</label>';
			echo '</div>';
		}
	}
	echo '</div>';
	echo '<p class="description">Use these checkboxes to choose countries where this advertisement will display.</p>';


}


function wd_ads_send_email_notification( $emails, $message ) {
	$emails_array = explode( ',', $emails );

	foreach ( $emails_array as $email ) {

		wp_mail( $email, $message, $message );

	}

}

function wd_ads_send_pushover_notification( $key, $token, $message ) {


	curl_setopt_array( $ch = curl_init(), array(
		CURLOPT_URL        => "https://api.pushover.net/1/messages.json",
		CURLOPT_POSTFIELDS => array(
			"token"   => $token,
			"user"    => $key,
			"message" => $message,
		),
		//CURLOPT_SAFE_UPLOAD => true,
	) );


	curl_exec( $ch );
	curl_close( $ch );
}


function wd_ads_check_hidden( $value, $equal ) {
	if ( $value == $equal ) {
		return 'wd_ads_hidden';
	}

	return false;
}

	
	
