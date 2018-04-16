<?php
/**
 * Postal Code helper
 * - validate postal codes around the world
 *
 * Inspired by https://github.com/sirprize/postal-code-validator/
 *
 * @package DatingVIP
 * @subpackage geo
 * @author Boris Momcilovic <boris@firstbeatmedia.com>
 * @copyright &copy; 2014 firstbeatmedia.com
 * @version 1.0
 */

namespace DatingVIP\geo;

class Postal_Code
{
    const MATCH_STRICT    = 0;
    const MATCH_RELAXED    = 1;
    const MATCH_CAPTURE = 2;

/*
 * Map of ISO 3166 2 country codes to postal code formats
 *
 * @var array
 * @access protected
 */
    protected $formats =
    [
        'AF' => ['####'],                              // Afghanistan
        'AL' => ['####'],                              // Albania
        'DZ' => ['#####'],                             // Algeria
        'AS' => ['#####', '#####-####'],               // American Samoa
        'AD' => ['#####', '@D###', 'AD#00'],           // Andorra
        'AO' => [],                                    // Angola
        'AI' => [],                                    // Anguilla (only AI-2640)
        'AQ' => [],                                    // Antarctica
        'AG' => [],                                    // Antigua and Barbuda
        'AR' => ['####', '@####@@@'],                  // Argentina
        'AM' => ['####'],                              // Armenia
        'AW' => [],                                    // Aruba
        'AU' => ['####', '###'],                       // Australia
        'AT' => ['####'],                              // Austria
        'AZ' => ['######', '####', 'AZ####'],          // Azerbaijan
        'AX' => [],                                    // Åland Islands
        'BS' => [],                                    // Bahamas
        'BH' => ['###', '####'],                       // Bahrain
        'BD' => ['####'],                              // Bangladesh
        'BB' => ['BB#####'],                           // Barbados
        'BY' => ['######'],                            // Belarus
        'BE' => ['####'],                              // Belgium
        'BZ' => [],                                    // Belize
        'BJ' => [],                                    // Benin
        'BM' => ['@@ ##'],                             // Bermuda
        'BT' => [],                                    // Bhutan
        'BO' => [],                                    // Bolivia
        'BA' => ['#####'],                             // Bosnia and Herzegowina
        'BW' => [],                                    // Botswana
        'BV' => [],                                    // Bouvet Island
        'BR' => ['#####-###', '#####'],                // Brazil
        'IO' => [],                                    // British Indian Ocean Territory
        'BN' => ['@@####'],                            // Brunei Darussalam
        'BG' => ['####'],                              // Bulgaria
        'BF' => [],                                    // Burkina Faso
        'BI' => [],                                    // Burundi
        'KH' => ['#####'],                             // Cambodia
        'CM' => [],                                    // Cameroon
        'CA' => ['@#@ #@#', '@#@ #@'],                 // Canada
        'CV' => ['####'],                              // Cape Verde
        'KY' => ['KY#-####'],                          // Cayman Islands
        'CF' => [],                                    // Central African Republic
        'TD' => [],                                    // Chad
        'CL' => ['#######'],                           // Chile
        'CN' => ['######'],                            // China
        'CX' => [],                                    // Christmas Island
        'CC' => [],                                    // Cocos (Keeling) Islands
        'CO' => ['######'],                            // Colombia
        'KM' => [],                                    // Comoros
        'CD' => [],                                    // Congo, Democratic Republic of (was Zaire)
        'CG' => [],                                    // Congo, People's Republic of
        'CK' => [],                                    // Cook Islands
        'CR' => ['#####'],                             // Costa Rica
        'CI' => [],                                    // Cote d'Ivoire
        'HR' => ['#####'],                             // Croatia
        'CU' => ['#####'],                             // Cuba
        'CY' => ['####', 'CY####'],                    // Cyprus
        'CZ' => ['### ##', '#####'],                   // Czech Republic
        'DK' => ['####', '###'],                       // Denmark
        'DJ' => [],                                    // Djibouti
        'DM' => [],                                    // Dominica
        'DO' => ['#####'],                             // Dominican Republic
        'TL' => [],                                    // East Timor
        'EC' => ['######', 'EC######'],                // Ecuador
        'EG' => ['#####'],                             // Egypt
        'SV' => ['####'],                              // El Salvador
        'GQ' => [],                                    // Equatorial Guinea
        'ER' => [],                                    // Eritrea
        'EE' => ['#####'],                             // Estonia
        'ET' => ['####'],                              // Ethiopia
        'FK' => ['FIQQ 1ZZ', 'FIQQ1ZZ'],               // Falkland Islands (Malvinas)
        'FO' => ['###'],                               // Faroe Islands
        'FJ' => [],                                    // Fiji
        'FI' => ['#####'],                             // Finland
        'FR' => ['#####'],                             // France
        'FX' => [],                                    // France, metropolitan
        'GF' => ['#####'],                             // French Guiana
        'PF' => ['#####'],                             // French Polynesia
        'TF' => [],                                    // French Southern Territories
        'GA' => [],                                    // Gabon
        'GM' => [],                                    // Gambia
        'GE' => ['####'],                              // Georgia
        'DE' => ['#####'],                             // Germany
        'GH' => [],                                    // Ghana
        'GI' => [],                                    // Gibraltar
        'GR' => ['#####', '### ##'],                   // Greece
        'GL' => ['####', '###'],                       // Greenland
        'GD' => [],                                    // Grenada
        'GP' => ['#####'],                             // Guadeloupe
        'GU' => ['#####'],                             // Guam
        'GT' => ['#####'],                             // Guatemala
        'GG' => [],                                    // Guernsey
        'GN' => [],                                    // Guinea
        'GW' => ['####'],                              // Guinea-Bissau
        'GY' => [],                                    // Guyana
        'HT' => ['####'],                              // Haiti
        'HM' => [],                                    // Heard and Mc Donald Islands
        'HN' => ['#####'],                             // Honduras
        'HK' => [],                                    // Hong Kong
        'HU' => ['######', '#####', '####'],           // Hungary
        'IS' => ['###'],                               // Iceland
        'IN' => ['######', '### ###'],                 // India
        'ID' => ['#####'],                             // Indonesia
        'IR' => ['#####', '##### #####'],              // Iran
        'IQ' => ['#####'],                             // Iraq
        'IE' => [],                                    // Ireland
        'IM' => [],                                    // Isle of Man
        'IL' => ['#######'],                           // Israel
        'IT' => ['#####'],                             // Italy
        'JM' => ['JM@@@##'],                           // Jamaica
        'JP' => ['###-####', '#######'],               // Japan
        'JE' => [],                                    // Jersey
        'JO' => ['#####'],                             // Jordan
        'KZ' => ['######'],                            // Kazakhstan
        'KE' => ['#####'],                             // Kenya
        'KI' => [],                                    // Kiribati
        'KW' => ['#####'],                             // Kuwait
        'KG' => ['######'],                            // Kyrgyzstan
        'LA' => ['#####'],                             // Lao People's Democratic Republic
        'LV' => ['####', 'LV-####', 'LV####'],         // Latvia
        'LB' => ['####'],                              // Lebanon
        'LS' => ['###'],                               // Lesotho
        'LR' => ['####'],                              // Liberia
        'LY' => ['#####'],                             // Libyan Arab Jamahiriya
        'LI' => ['####'],                              // Liechtenstein
        'LT' => ['#####'],                             // Lithuania
        'LU' => ['####', 'L-####', 'L####'],           // Luxembourg
        'MO' => [],                                    // Macau
        'MK' => ['####'],                              // Macedonia
        'MG' => ['###'],                               // Madagascar
        'MW' => [],                                    // Malawi
        'MY' => ['#####'],                             // Malaysia
        'MV' => ['####', '#####'],                     // Maldives
        'ML' => [],                                    // Mali
        'MT' => ['@@@ ####', '@@@####'],               // Malta
        'MH' => ['#####'],                             // Marshall Islands
        'MQ' => ['#####'],                             // Martinique
        'MR' => [],                                    // Mauritania
        'MU' => [],                                    // Mauritius
        'YT' => ['#####'],                             // Mayotte
        'MX' => ['#####', '####'],                     // Mexico
        'FM' => ['#####'],                             // Micronesia
        'MD' => ['####'],                              // Moldova
        'MC' => ['#8000', '#####'],                    // Monaco
        'MN' => ['#####', '######'],                   // Mongolia
        'ME' => ['#####'],                             // Montenegro
        'MS' => [],                                    // Montserrat
        'MA' => ['#####'],                             // Morocco
        'MZ' => ['#####'],                             // Mozambique
        'MM' => ['#####'],                             // Myanmar
        'NA' => [],                                    // Namibia
        'NR' => [],                                    // Nauru
        'NP' => ['#####'],                             // Nepal
        'NL' => ['#### @@', '####@@', '####'],         // Netherlands
        'AN' => [],                                    // Netherlands Antilles
        'NC' => ['#####'],                             // New Caledonia
        'NZ' => ['####'],                              // New Zealand
        'NI' => ['###-###-#'],                         // Nicaragua
        'NE' => ['####'],                              // Niger
        'NG' => ['######'],                            // Nigeria
        'NU' => [],                                    // Niue
        'NF' => [],                                    // Norfolk Island
        'KP' => ['###'],                               // North Korea
        'MP' => ['#####'],                             // Northern Mariana Islands
        'NO' => ['####'],                              // Norway
        'OM' => ['###'],                               // Oman
        'PK' => ['#####'],                             // Pakistan
        'PW' => ['#####'],                             // Palau
        'PS' => [],                                    // Palestinian Territory
        'PA' => [],                                    // Panama
        'PG' => ['###'],                               // Papua New Guinea
        'PY' => ['####'],                              // Paraguay
        'PE' => ['##'],                                // Peru
        'PH' => ['####'],                              // Philippines
        'PN' => [],                                    // Pitcairn
        'PL' => ['##-###', '#####'],                   // Poland
        'PT' => ['####-###', '####'],                  // Portugal
        'PR' => ['#####'],                             // Puerto Rico
        'QA' => [],                                    // Qatar
        'RE' => ['#####'],                             // Reunion
        'RO' => ['######'],                            // Romania
        'RU' => ['######'],                            // Russia
        'RW' => [],                                    // Rwanda
        'BL' => [],                                    // Saint Barthelemy
        'KN' => [],                                    // Saint Kitts and Nevis
        'LC' => [],                                    // Saint Lucia
        'VC' => [],                                    // Saint Vincent and the Grenadines
        'MF' => [],                                    // Saint Martin
        'WS' => ['#####'],                             // Samoa
        'SM' => ['#####'],                             // San Marino
        'ST' => [],                                    // Sao Tome and Principe
        'SA' => ['#####'],                             // Saudi Arabia
        'SN' => [],                                    // Senegal
        'RS' => ['#####'],                             // Serbia
        'SC' => [],                                    // Seychelles
        'SL' => [],                                    // Sierra Leone
        'SG' => ['######'],                            // Singapore
        'SK' => ['### ##', '#####'],                   // Slovakia
        'SI' => ['####'],                              // Slovenia
        'SB' => [],                                    // Solomon Islands
        'SO' => [],                                    // Somalia
        'ZA' => ['####'],                              // South Africa
        'GS' => [],                                    // South Georgia and the South Sandwich Islands
        'KR' => ['######', '###-###'],                 // South Korea
        'ES' => ['#####'],                             // Spain
        'LK' => ['#####'],                             // Sri Lanka
        'SH' => [],                                    // St. Helena
        'PM' => ['#####'],                             // St. Pierre and Miquelon
        'SD' => ['#####'],                             // Sudan
        'SR' => [],                                    // Suriname
        'SJ' => ['####'],                              // Svalbard and Jan Mayen Islands
        'SZ' => ['@###'],                              // Swaziland
        'SE' => ['### ##', '#####'],                   // Sweden
        'CH' => ['####', '@###'],                      // Switzerland
        'SY' => [],                                    // Syrian Arab Republic
        'TW' => ['#####', '###'],                      // Taiwan
        'TJ' => ['######'],                            // Tajikistan
        'TZ' => [],                                    // Tanzania
        'TH' => ['#####'],                             // Thailand
        'TG' => [],                                    // Togo
        'TK' => [],                                    // Tokelau
        'TO' => [],                                    // Tonga
        'TT' => [],                                    // Trinidad and Tobago
        'TN' => ['####'],                              // Tunisia
        'TR' => ['#####'],                             // Turkey
        'TM' => ['######'],                            // Turkmenistan
        'TC' => ['TKC@ 1ZZ'],                          // Turks and Caicos Islands
        'TV' => [],                                    // Tuvalu
        'UG' => [],                                    // Uganda
        'GB' => ['@# #@@', '@** #@@', '@@#* #@@'],     // UK
        'UA' => ['#####'],                             // Ukraine
        'AE' => [],                                    // United Arab Emirates
        'UM' => [],                                    // United States Minor Outlying Islands
        'UY' => ['#####'],                             // Uruguay
        'US' => ['#####', '#####-####'],               // USA
        'UZ' => ['######'],                            // Usbekistan
        'VU' => [],                                    // Vanuatu
        'VA' => ['00120'],                             // Vatican City State
        'VE' => ['####'],                              // Venezuela
        'VN' => ['######'],                            // Vietnam
        'VG' => ['VG11#0'],                            // Virgin Islands (British)
        'VI' => [],                                    // Virgin Islands (U.S.)
        'WF' => ['#####'],                             // Wallis and Futuna Islands
        'EH' => ['#####'],                             // Western Sahara
        'YE' => [],                                    // Yemen
        'ZM' => ['#####'],                             // Zambia
        'ZW' => [],                                    // Zimbabwe
    ];

/**
 * Map of format chars to regex
 *
 * @var array
 * @access protected
 */
    protected $regex_map =
    [
        '#' => '\d',
        '@' => '[a-zA-Z]',
        '*' => '[a-zA-Z0-9]',
    ];

/**
 * Try to validate given combination of country code and postal code
 * This validation is strict - meaning that postal code may contain only postal code itself, nothing else
 *
 * @param string $country_code
 * @param string $postal_code
 * @access public
 * @return bool
 * @throws Validation_Exception
 */
    public function isValid($country_code, $postal_code)
    {
        return $this->validate (self::MATCH_STRICT, $country_code, $postal_code);
    }

/**
 * Check if given string contains valid postal code for given country code
 *
 * @param string $country_code
 * @param string $string
 * @access public
 * @return bool
 * @throws Validation_Exception
 */
    public function contains($country_code, $string)
    {
        return $this->validate (self::MATCH_RELAXED, $country_code, $string);
    }

/**
 * Try to capture postal code for given country from given string and return
 * it if it's found. Otherwise, returns empty string
 *
 * @param string $country_code
 * @param string $string
 * @access public
 * @return string
 * @throws Validation_Exception
 */
    public function capture($country_code, $string)
    {
        if (!$this->coveringCountry ($country_code)) {
            throw new Validation_Exception (sprintf ('Invalid country code: "%s"', $country_code));
        }

        if (empty ($this->formats[$country_code]))        { return ''; }

        $match = null;
        foreach ($this->formats[$country_code] as $format) {
            if (preg_match ($this->getRegex ($format, self::MATCH_CAPTURE), $string, $match)) {
                return $match['code'];
            }
        }

        return '';
    }

/**
 * Validate given postal code and country code combination against specific
 * regex type
 *
 * @param int $type
 * @param string $country_code
 * @param string $postal_code
 * @return boolean
 * @throws Validation_Exception
 */
    protected function validate($type, $country_code, $postal_code)
    {
        if (!$this->coveringCountry ($country_code)) {
            throw new Validation_Exception (sprintf ('Invalid country code: "%s"', $country_code));
        }

        if (empty ($this->formats[$country_code]))        { return true; }

        foreach ($this->formats[$country_code] as $format) {
            if (preg_match ($this->getRegex ($format, $type), $postal_code)) {
                return true;
            }
        }

        return false;
    }

/**
 * Get array of (valid) postal code formats for given country
 *
 * @param string $country_code
 * @return array
 * @throws Validation_Exception
 */
    public function getFormats($country_code)
    {
        if (!$this->coveringCountry ($country_code)) {
            throw new Validation_Exception (sprintf ('Invalid country code: "%s"', $country_code));
        }

        return $this->formats[$country_code];
    }

/**
 * Are we covering given country code
 *
 * @param string $country_code
 * @access public
 * @return bool
 */
    public function coveringCountry($country_code)
    {
        return isset ($this->formats[$country_code]);
    }

/**
 * Get regex for given format and type
 *
 * @param string $format
 * @param int $type
 * @access protected
 * @return string
 */
    protected function getRegex($format, $type = self::MATCH_STRICT)
    {
        switch ($type) {
            case self::MATCH_RELAXED:    $result = '/%s/';          break;
            case self::MATCH_CAPTURE:    $result = '/(?<code>%s)/'; break;
            case self::MATCH_STRICT:                                // no break;
            default:                     $result = '/^%s$/';        break;
        }

        return sprintf ($result, str_replace (array_keys ($this->regex_map), array_values ($this->regex_map), $format));
    }

}
