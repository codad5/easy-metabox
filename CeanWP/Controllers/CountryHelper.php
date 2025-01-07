<?php

namespace CeanWP\Controllers;

final class CountryHelper
{
    // A constant containing all countries with their ISO 3166-1-alpha-2 code as keys
    // and their details (country name and phone code) as values
    public const COUNTRIES = [
        'AF' => ['name' => 'Afghanistan', 'phone_code' => '+93'],
        'AL' => ['name' => 'Albania', 'phone_code' => '+355'],
        'DZ' => ['name' => 'Algeria', 'phone_code' => '+213'],
        'AS' => ['name' => 'American Samoa', 'phone_code' => '+1-684'],
        'AD' => ['name' => 'Andorra', 'phone_code' => '+376'],
        'AO' => ['name' => 'Angola', 'phone_code' => '+244'],
        'AI' => ['name' => 'Anguilla', 'phone_code' => '+1-264'],
        'AG' => ['name' => 'Antigua and Barbuda', 'phone_code' => '+1-268'],
        'AR' => ['name' => 'Argentina', 'phone_code' => '+54'],
        'AM' => ['name' => 'Armenia', 'phone_code' => '+374'],
        'AU' => ['name' => 'Australia', 'phone_code' => '+61'],
        'AT' => ['name' => 'Austria', 'phone_code' => '+43'],
        'AZ' => ['name' => 'Azerbaijan', 'phone_code' => '+994'],
        'BS' => ['name' => 'Bahamas', 'phone_code' => '+1-242'],
        'BH' => ['name' => 'Bahrain', 'phone_code' => '+973'],
        'BD' => ['name' => 'Bangladesh', 'phone_code' => '+880'],
        'BB' => ['name' => 'Barbados', 'phone_code' => '+1-246'],
        'BY' => ['name' => 'Belarus', 'phone_code' => '+375'],
        'BE' => ['name' => 'Belgium', 'phone_code' => '+32'],
        'BZ' => ['name' => 'Belize', 'phone_code' => '+501'],
        'BJ' => ['name' => 'Benin', 'phone_code' => '+229'],
        'BM' => ['name' => 'Bermuda', 'phone_code' => '+1-441'],
        'BT' => ['name' => 'Bhutan', 'phone_code' => '+975'],
        'BO' => ['name' => 'Bolivia', 'phone_code' => '+591'],
        'BA' => ['name' => 'Bosnia and Herzegovina', 'phone_code' => '+387'],
        'BW' => ['name' => 'Botswana', 'phone_code' => '+267'],
        'BR' => ['name' => 'Brazil', 'phone_code' => '+55'],
        'BN' => ['name' => 'Brunei', 'phone_code' => '+673'],
        'BG' => ['name' => 'Bulgaria', 'phone_code' => '+359'],
        'BF' => ['name' => 'Burkina Faso', 'phone_code' => '+226'],
        'BI' => ['name' => 'Burundi', 'phone_code' => '+257'],
        'KH' => ['name' => 'Cambodia', 'phone_code' => '+855'],
        'CM' => ['name' => 'Cameroon', 'phone_code' => '+237'],
        'CA' => ['name' => 'Canada', 'phone_code' => '+1'],
        'CV' => ['name' => 'Cape Verde', 'phone_code' => '+238'],
        'CF' => ['name' => 'Central African Republic', 'phone_code' => '+236'],
        'TD' => ['name' => 'Chad', 'phone_code' => '+235'],
        'CL' => ['name' => 'Chile', 'phone_code' => '+56'],
        'CN' => ['name' => 'China', 'phone_code' => '+86'],
        'CO' => ['name' => 'Colombia', 'phone_code' => '+57'],
        'KM' => ['name' => 'Comoros', 'phone_code' => '+269'],
        'CG' => ['name' => 'Congo', 'phone_code' => '+242'],
        'CD' => ['name' => 'Congo (Democratic Republic)', 'phone_code' => '+243'],
        'CR' => ['name' => 'Costa Rica', 'phone_code' => '+506'],
        'CI' => ['name' => 'Côte d\'Ivoire', 'phone_code' => '+225'],
        'HR' => ['name' => 'Croatia', 'phone_code' => '+385'],
        'CU' => ['name' => 'Cuba', 'phone_code' => '+53'],
        'CY' => ['name' => 'Cyprus', 'phone_code' => '+357'],
        'CZ' => ['name' => 'Czech Republic', 'phone_code' => '+420'],
        'DK' => ['name' => 'Denmark', 'phone_code' => '+45'],
        'DJ' => ['name' => 'Djibouti', 'phone_code' => '+253'],
        'DM' => ['name' => 'Dominica', 'phone_code' => '+1-767'],
        'DO' => ['name' => 'Dominican Republic', 'phone_code' => '+1-809'],
        'EC' => ['name' => 'Ecuador', 'phone_code' => '+593'],
        'EG' => ['name' => 'Egypt', 'phone_code' => '+20'],
        'SV' => ['name' => 'El Salvador', 'phone_code' => '+503'],
        'GQ' => ['name' => 'Equatorial Guinea', 'phone_code' => '+240'],
        'ER' => ['name' => 'Eritrea', 'phone_code' => '+291'],
        'EE' => ['name' => 'Estonia', 'phone_code' => '+372'],
        'SZ' => ['name' => 'Eswatini', 'phone_code' => '+268'],
        'ET' => ['name' => 'Ethiopia', 'phone_code' => '+251'],
        'FI' => ['name' => 'Finland', 'phone_code' => '+358'],
        'FR' => ['name' => 'France', 'phone_code' => '+33'],
        'GA' => ['name' => 'Gabon', 'phone_code' => '+241'],
        'GM' => ['name' => 'Gambia', 'phone_code' => '+220'],
        'GE' => ['name' => 'Georgia', 'phone_code' => '+995'],
        'DE' => ['name' => 'Germany', 'phone_code' => '+49'],
        'GH' => ['name' => 'Ghana', 'phone_code' => '+233'],
        'GR' => ['name' => 'Greece', 'phone_code' => '+30'],
        'GD' => ['name' => 'Grenada', 'phone_code' => '+1-473'],
        'GT' => ['name' => 'Guatemala', 'phone_code' => '+502'],
        'GN' => ['name' => 'Guinea', 'phone_code' => '+224'],
        'GW' => ['name' => 'Guinea-Bissau', 'phone_code' => '+245'],
        'GY' => ['name' => 'Guyana', 'phone_code' => '+592'],
        'HT' => ['name' => 'Haiti', 'phone_code' => '+509'],
        'HN' => ['name' => 'Honduras', 'phone_code' => '+504'],
        'HU' => ['name' => 'Hungary', 'phone_code' => '+36'],
        'IS' => ['name' => 'Iceland', 'phone_code' => '+354'],
        'IN' => ['name' => 'India', 'phone_code' => '+91'],
        'ID' => ['name' => 'Indonesia', 'phone_code' => '+62'],
        'IR' => ['name' => 'Iran', 'phone_code' => '+98'],
        'IQ' => ['name' => 'Iraq', 'phone_code' => '+964'],
        'IE' => ['name' => 'Ireland', 'phone_code' => '+353'],
        'IL' => ['name' => 'Israel', 'phone_code' => '+972'],
        'IT' => ['name' => 'Italy', 'phone_code' => '+39'],
        'JM' => ['name' => 'Jamaica', 'phone_code' => '+1-876'],
        'JP' => ['name' => 'Japan', 'phone_code' => '+81'],
        'JO' => ['name' => 'Jordan', 'phone_code' => '+962'],
        'KZ' => ['name' => 'Kazakhstan', 'phone_code' => '+7'],
        'KE' => ['name' => 'Kenya', 'phone_code' => '+254'],
        'KI' => ['name' => 'Kiribati', 'phone_code' => '+686'],
        'KP' => ['name' => 'North Korea', 'phone_code' => '+850'],
        'KR' => ['name' => 'South Korea', 'phone_code' => '+82'],
        'KW' => ['name' => 'Kuwait', 'phone_code' => '+965'],
        'KG' => ['name' => 'Kyrgyzstan', 'phone_code' => '+996'],
        'LA' => ['name' => 'Laos', 'phone_code' => '+856'],
        'LV' => ['name' => 'Latvia', 'phone_code' => '+371'],
        'LB' => ['name' => 'Lebanon', 'phone_code' => '+961'],
        'LS' => ['name' => 'Lesotho', 'phone_code' => '+266'],
        'LR' => ['name' => 'Liberia', 'phone_code' => '+231'],
        'LY' => ['name' => 'Libya', 'phone_code' => '+218'],
        'LI' => ['name' => 'Liechtenstein', 'phone_code' => '+423'],
        'LT' => ['name' => 'Lithuania', 'phone_code' => '+370'],
        'LU' => ['name' => 'Luxembourg', 'phone_code' => '+352'],
        'MG' => ['name' => 'Madagascar', 'phone_code' => '+261'],
        'MW' => ['name' => 'Malawi', 'phone_code' => '+265'],
        'MY' => ['name' => 'Malaysia', 'phone_code' => '+60'],
        'MV' => ['name' => 'Maldives', 'phone_code' => '+960'],
        'ML' => ['name' => 'Mali', 'phone_code' => '+223'],
        'MT' => ['name' => 'Malta', 'phone_code' => '+356'],
        'MH' => ['name' => 'Marshall Islands', 'phone_code' => '+692'],
        'MR' => ['name' => 'Mauritania', 'phone_code' => '+222'],
        'MU' => ['name' => 'Mauritius', 'phone_code' => '+230'],
        'MX' => ['name' => 'Mexico', 'phone_code' => '+52'],
        'FM' => ['name' => 'Micronesia', 'phone_code' => '+691'],
        'MD' => ['name' => 'Moldova', 'phone_code' => '+373'],
        'MC' => ['name' => 'Monaco', 'phone_code' => '+377'],
        'MN' => ['name' => 'Mongolia', 'phone_code' => '+976'],
        'ME' => ['name' => 'Montenegro', 'phone_code' => '+382'],
        'MA' => ['name' => 'Morocco', 'phone_code' => '+212'],
        'MZ' => ['name' => 'Mozambique', 'phone_code' => '+258'],
        'MM' => ['name' => 'Myanmar', 'phone_code' => '+95'],
        'NA' => ['name' => 'Namibia', 'phone_code' => '+264'],
        'NR' => ['name' => 'Nauru', 'phone_code' => '+674'],
        'NP' => ['name' => 'Nepal', 'phone_code' => '+977'],
        'NL' => ['name' => 'Netherlands', 'phone_code' => '+31'],
        'NZ' => ['name' => 'New Zealand', 'phone_code' => '+64'],
        'NI' => ['name' => 'Nicaragua', 'phone_code' => '+505'],
        'NE' => ['name' => 'Niger', 'phone_code' => '+227'],
        'NG' => ['name' => 'Nigeria', 'phone_code' => '+234'],
        'NO' => ['name' => 'Norway', 'phone_code' => '+47'],
        'OM' => ['name' => 'Oman', 'phone_code' => '+968'],
        'PK' => ['name' => 'Pakistan', 'phone_code' => '+92'],
        'PW' => ['name' => 'Palau', 'phone_code' => '+680'],
        'PS' => ['name' => 'Palestine', 'phone_code' => '+970'],
        'PA' => ['name' => 'Panama', 'phone_code' => '+507'],
        'PG' => ['name' => 'Papua New Guinea', 'phone_code' => '+675'],
        'PY' => ['name' => 'Paraguay', 'phone_code' => '+595'],
        'PE' => ['name' => 'Peru', 'phone_code' => '+51'],
        'PH' => ['name' => 'Philippines', 'phone_code' => '+63'],
        'PL' => ['name' => 'Poland', 'phone_code' => '+48'],
        'PT' => ['name' => 'Portugal', 'phone_code' => '+351'],
        'QA' => ['name' => 'Qatar', 'phone_code' => '+974'],
        'RO' => ['name' => 'Romania', 'phone_code' => '+40'],
        'RU' => ['name' => 'Russia', 'phone_code' => '+7'],
        'RW' => ['name' => 'Rwanda', 'phone_code' => '+250'],
        'WS' => ['name' => 'Samoa', 'phone_code' => '+685'],
        'SM' => ['name' => 'San Marino', 'phone_code' => '+378'],
        'ST' => ['name' => 'Sao Tome and Principe', 'phone_code' => '+239'],
        'SA' => ['name' => 'Saudi Arabia', 'phone_code' => '+966'],
        'SN' => ['name' => 'Senegal', 'phone_code' => '+221'],
        'RS' => ['name' => 'Serbia', 'phone_code' => '+381'],
        'SC' => ['name' => 'Seychelles', 'phone_code' => '+248'],
        'SL' => ['name' => 'Sierra Leone', 'phone_code' => '+232'],
        'SG' => ['name' => 'Singapore', 'phone_code' => '+65'],
        'SK' => ['name' => 'Slovakia', 'phone_code' => '+421'],
        'SI' => ['name' => 'Slovenia', 'phone_code' => '+386'],
        'SB' => ['name' => 'Solomon Islands', 'phone_code' => '+677'],
        'SO' => ['name' => 'Somalia', 'phone_code' => '+252'],
        'ZA' => ['name' => 'South Africa', 'phone_code' => '+27'],
        'ES' => ['name' => 'Spain', 'phone_code' => '+34'],
        'LK' => ['name' => 'Sri Lanka', 'phone_code' => '+94'],
        'SD' => ['name' => 'Sudan', 'phone_code' => '+249'],
        'SR' => ['name' => 'Suriname', 'phone_code' => '+597'],
        'SE' => ['name' => 'Sweden', 'phone_code' => '+46'],
        'CH' => ['name' => 'Switzerland', 'phone_code' => '+41'],
        'SY' => ['name' => 'Syria', 'phone_code' => '+963'],
        'TW' => ['name' => 'Taiwan', 'phone_code' => '+886'],
        'TJ' => ['name' => 'Tajikistan', 'phone_code' => '+992'],
        'TZ' => ['name' => 'Tanzania', 'phone_code' => '+255'],
        'TH' => ['name' => 'Thailand', 'phone_code' => '+66'],
        'TL' => ['name' => 'Timor-Leste', 'phone_code' => '+670'],
        'TG' => ['name' => 'Togo', 'phone_code' => '+228'],
        'TO' => ['name' => 'Tonga', 'phone_code' => '+676'],
        'TT' => ['name' => 'Trinidad and Tobago', 'phone_code' => '+1-868'],
        'TN' => ['name' => 'Tunisia', 'phone_code' => '+216'],
        'TR' => ['name' => 'Turkey', 'phone_code' => '+90'],
        'TM' => ['name' => 'Turkmenistan', 'phone_code' => '+993'],
        'TV' => ['name' => 'Tuvalu', 'phone_code' => '+688'],
        'UG' => ['name' => 'Uganda', 'phone_code' => '+256'],
        'UA' => ['name' => 'Ukraine', 'phone_code' => '+380'],
        'AE' => ['name' => 'United Arab Emirates', 'phone_code' => '+971'],
        'GB' => ['name' => 'United Kingdom', 'phone_code' => '+44'],
        'US' => ['name' => 'United States', 'phone_code' => '+1'],
        'UY' => ['name' => 'Uruguay', 'phone_code' => '+598'],
        'UZ' => ['name' => 'Uzbekistan', 'phone_code' => '+998'],
        'VU' => ['name' => 'Vanuatu', 'phone_code' => '+678'],
        'VA' => ['name' => 'Vatican City', 'phone_code' => '+39'],
        'VE' => ['name' => 'Venezuela', 'phone_code' => '+58'],
        'VN' => ['name' => 'Vietnam', 'phone_code' => '+84'],
        'YE' => ['name' => 'Yemen', 'phone_code' => '+967'],
        'ZM' => ['name' => 'Zambia', 'phone_code' => '+260'],
        'ZW' => ['name' => 'Zimbabwe', 'phone_code' => '+263'],
    ];


    /**
     * Get country details by ISO 3166-1-alpha-2 code.
     *
     * @param string $code The ISO code of the country.
     * @return array|null The country details or null if not found.
     */
    public static function getCountryByCode(string $code): ?array
    {
        return self::COUNTRIES[$code] ?? null;
    }

    /**
     * Get all countries.
     *
     * @return array An array of all countries with their details.
     */
    public static function getAllCountries(): array
    {
        return self::COUNTRIES;
    }

    static function getAllCountriesName(): array
    {
        $countryNames = [];
        foreach (self::COUNTRIES as $code => $details) {
            $countryNames[$code] = $details['name'];
        }
        return $countryNames;
    }

    static function getAllCountriesPhoneCode(): array
    {
        $countryPhoneCodes = [];
        foreach (self::COUNTRIES as $code => $details) {
            $countryPhoneCodes[$code] = $details['phone_code'];
        }
        return $countryPhoneCodes;
    }

    /**
     * Search for a country by name (case-insensitive).
     *
     * @param string $name The name of the country to search for.
     * @return array|null The country details or null if not found.
     */
    public static function searchCountryByName(string $name): ?array
    {
        foreach (self::COUNTRIES as $code => $details) {
            if (strcasecmp($details['name'], $name) === 0) {
                return $details;
            }
        }

        return null;
    }
}
