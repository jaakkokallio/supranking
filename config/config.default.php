<?php
  date_default_timezone_set("Europe/Stockholm");
  setlocale(LC_ALL, 'sv_SE');

  if ($environment == "dev") { 
    error_reporting(E_ALL & ~E_DEPRECATED);

    define("DATABASE_HOST",	"localhost");
    define("DATABASE_USERNAME",	"root");
    define("DATABASE_PASSWORD",	"batman");
    define("DATABASE_DATABASE",	"supranking");
  } else {
    define("DATABASE_HOST",	"eu-cdbr-west-01.cleardb.com");
    define("DATABASE_USERNAME",	"bbd8cc0fd7d467");
    define("DATABASE_PASSWORD",	"e17d5f16");
    define("DATABASE_DATABASE",	"heroku_5a1dacb1604089d");
  }

	define("COUNTRIES", serialize(array(
		'AFG' => 'Afghanistan',
		'ALB' => 'Albania',
		'DZA' => 'Algeria',
		'ASM' => 'American Samoa',
		'AND' => 'Andorra',
		'AGO' => 'Angola',
		'AIA' => 'Anguilla',
		'ATA' => 'Antarctica',
		'ATG' => 'Antigua And Barbuda',
		'ARG' => 'Argentina',
		'ARM' => 'Armenia',
		'ABW' => 'Aruba',
		'AUS' => 'Australia',
		'AUT' => 'Austria',
		'AZE' => 'Azerbaijan',
		'BHS' => 'Bahamas',
		'BHR' => 'Bahrain',
		'BGD' => 'Bangladesh',
		'BRB' => 'Barbados',
		'BLR' => 'Belarus',
		'BEL' => 'Belgium',
		'BLZ' => 'Belize',
		'BEN' => 'Benin',
		'BMU' => 'Bermuda',
		'BTN' => 'Bhutan',
		'BOL' => 'Bolivia',
		'BIH' => 'Bosnia and Herzegowina',
		'BWA' => 'Botswana',
		'BVT' => 'Bouvet Island',
		'BRA' => 'Brazil',
		'IOT' => 'British Indian Ocean Territory',
		'BRN' => 'Brunei Darussalam',
		'BGR' => 'Bulgaria',
		'BFA' => 'Burkina Faso',
		'BDI' => 'Burundi',
		'KHM' => 'Cambodia',
		'CMR' => 'Cameroon',
		'CAN' => 'Canada',
		'CPV' => 'Cape Verde',
		'CYM' => 'Cayman Islands',
		'CAF' => 'Central African Republic',
		'TCD' => 'Chad',
		'CHL' => 'Chile',
		'CHN' => 'China',
		'CXR' => 'Christmas Island',
		'CCK' => 'Cocos Islands',
		'COL' => 'Colombia',
		'COM' => 'Comoros',
		'COG' => 'Congo',
		'COD' => 'Congo, The Drc',
		'COK' => 'Cook Islands',
		'CRI' => 'Costa Rica',
		'CIV' => 'Cote D Ivoire',
		'HRV' => 'Croatia',
		'CUB' => 'Cuba',
		'CYP' => 'Cyprus',
		'CZE' => 'Czech Republic',
		'DNK' => 'Denmark',
		'DJI' => 'Djibouti',
		'DMA' => 'Dominica',
		'DOM' => 'Dominican Republic',
		'TMP' => 'East Timor',
		'ECU' => 'Ecuador',
		'EGY' => 'Egypt',
		'SLV' => 'El Salvador',
		'GNQ' => 'Equatorial Guinea',
		'ERI' => 'Eritrea',
		'EST' => 'Estonia',
		'ETH' => 'Ethiopia',
		'FLK' => 'Falkland Islands',
		'FRO' => 'Faroe Islands',
		'FJI' => 'Fiji',
		'FIN' => 'Finland',
		'FRA' => 'France',
		'FXX' => 'France, Metropolitan',
		'GUF' => 'French Guiana',
		'PYF' => 'French Polynesia',
		'ATF' => 'French Southern Territories',
		'GAB' => 'Gabon',
		'GMB' => 'Gambia',
		'GEO' => 'Georgia',
		'DEU' => 'Germany',
		'GHA' => 'Ghana',
		'GIB' => 'Gibraltar',
		'GRC' => 'Greece',
		'GRL' => 'Greenland',
		'GRD' => 'Grenada',
		'GLP' => 'Guadeloupe',
		'GUM' => 'Guam',
		'GTM' => 'Guatemala',
		'GIN' => 'Guinea',
		'GNB' => 'Guinea-bissau',
		'GUY' => 'Guyana',
		'HTI' => 'Haiti',
		'HMD' => 'Heard and Mc Donald Islands',
		'VAT' => 'Holy See (Vatican City State)',
		'HND' => 'Honduras',
		'HKG' => 'Hong Kong',
		'HUN' => 'Hungary',
		'ISL' => 'Iceland',
		'IND' => 'India',
		'IDN' => 'Indonesia',
		'IRN' => 'Iran',
		'IRQ' => 'Iraq',
		'IRL' => 'Ireland',
		'ISR' => 'Israel',
		'ITA' => 'Italy',
		'JAM' => 'Jamaica',
		'JPN' => 'Japan',
		'JOR' => 'Jordan',
		'KAZ' => 'Kazakhstan',
		'KEN' => 'Kenya',
		'KIR' => 'Kiribati',
		'PRK' => 'D.P.R.O. Korea',
		'KOR' => 'Republic Of Korea',
		'KWT' => 'Kuwait',
		'KGZ' => 'Kyrgyzstan',
		'LAO' => 'Laos',
		'LVA' => 'Latvia',
		'LBN' => 'Lebanon',
		'LSO' => 'Lesotho',
		'LBR' => 'Liberia',
		'LBY' => 'Libyan Arab Jamahiriya',
		'LIE' => 'Liechtenstein',
		'LTU' => 'Lithuania',
		'LUX' => 'Luxembourg',
		'MAC' => 'Macau',
		'MKD' => 'Macedonia',
		'MDG' => 'Madagascar',
		'MWI' => 'Malawi',
		'MYS' => 'Malaysia',
		'MDV' => 'Maldives',
		'MLI' => 'Mali',
		'MLT' => 'Malta',
		'MHL' => 'Marshall Islands',
		'MTQ' => 'Martinique',
		'MRT' => 'Mauritania',
		'MUS' => 'Mauritius',
		'MYT' => 'Mayotte',
		'MEX' => 'Mexico',
		'FSM' => 'Federated States of Micronesia',
		'MDA' => 'Republic of Moldova',
		'MCO' => 'Monaco',
		'MNG' => 'Mongolia',
		'MSR' => 'Montserrat',
		'MAR' => 'Morocco',
		'MOZ' => 'Mozambique',
		'MMR' => 'Myanmar',
		'NAM' => 'Namibia',
		'NRU' => 'Nauru',
		'NPL' => 'Nepal',
		'NLD' => 'Netherlands',
		'ANT' => 'Netherlands Antilles',
		'NCL' => 'New Caledonia',
		'NZL' => 'New Zealand',
		'NIC' => 'Nicaragua',
		'NER' => 'Niger',
		'NGA' => 'Nigeria',
		'NIU' => 'Niue',
		'NFK' => 'Norfolk Island',
		'MNP' => 'Northern Mariana Islands',
		'NOR' => 'Norway',
		'OMN' => 'Oman',
		'PAK' => 'Pakistan',
		'PLW' => 'Palau',
		'PAN' => 'Panama',
		'PNG' => 'Papua New Guinea',
		'PRY' => 'Paraguay',
		'PER' => 'Peru',
		'PHL' => 'Philippines',
		'PCN' => 'Pitcairn',
		'POL' => 'Poland',
		'PRT' => 'Portugal',
		'PRI' => 'Puerto Rico',
		'QAT' => 'Qatar',
		'REU' => 'Reunion',
		'ROM' => 'Romania',
		'RUS' => 'Russian Federation',
		'RWA' => 'Rwanda',
		'KNA' => 'Saint Kitts And Nevis',
		'LCA' => 'Saint Lucia',
		'VCT' => 'Saint Vincent and The Grenadines',
		'WSM' => 'Samoa',
		'SMR' => 'San Marino',
		'STP' => 'Sao Tome and Principe',
		'SAU' => 'Saudi Arabia',
		'SEN' => 'Senegal',
		'SYC' => 'Seychelles',
		'SLE' => 'Sierra Leone',
		'SGP' => 'Singapore',
		'SVK' => 'Slovakia',
		'SVN' => 'Slovenia',
		'SLB' => 'Solomon Islands',
		'SOM' => 'Somalia',
		'ZAF' => 'South Africa',
		'SGS' => 'South Georgia and South S.S.',
		'ESP' => 'Spain',
		'LKA' => 'Sri Lanka',
		'SHN' => 'St. Helena',
		'SPM' => 'St. Pierre and Miquelon',
		'SDN' => 'Sudan',
		'SUR' => 'Suriname',
		'SJM' => 'Svalbard and Jan Mayen Islands',
		'SWZ' => 'Swaziland',
		'SWE' => 'Sweden',
		'CHE' => 'Switzerland',
		'SYR' => 'Syrian Arab Republic',
		'TWN' => 'Taiwan, Province of China',
		'TJK' => 'Tajikistan',
		'TZA' => 'United Republic of Tanzania',
		'THA' => 'Thailand',
		'TGO' => 'Togo',
		'TKL' => 'Tokelau',
		'TON' => 'Tonga',
		'TTO' => 'Trinidad and Tobago',
		'TUN' => 'Tunisia',
		'TUR' => 'Turkey',
		'TKM' => 'Turkmenistan',
		'TCA' => 'Turks and Caicos Islands',
		'TUV' => 'Tuvalu',
		'UGA' => 'Uganda',
		'UKR' => 'Ukraine',
		'ARE' => 'United Arab Emirates',
		'GBR' => 'United Kingdom',
		'USA' => 'United States',
		'UMI' => 'U.S. Minor Islands',
		'URY' => 'Uruguay',
		'UZB' => 'Uzbekistan',
		'VUT' => 'Vanuatu',
		'VEN' => 'Venezuela',
		'VNM' => 'Viet Nam',
		'VGB' => 'Virgin Islands (British)',
		'VIR' => 'Virgin Islands (U.S.)',
		'WLF' => 'Wallis and Futuna Islands',
		'ESH' => 'Western Sahara',
		'YEM' => 'Yemen',
		'YUG' => 'Yugoslavia',
		'ZMB' => 'Zambia',
		'ZWE' => 'Zimbabwe',
	)));
?>