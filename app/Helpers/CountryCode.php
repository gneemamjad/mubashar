<?php

namespace App\Helpers;

class CountryCode
{
    const COUNTRY_CODES =
    [
            [
                "name" => "Afghanistan",
                "flag" => "🇦🇫",
                "code" => "AF",
                "dialCode" => "93",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Åland Islands",
                "flag" => "🇦🇽",
                "code" => "AX",
                "dialCode" => "358",
                "minLength" => 15,
                "maxLength" => 15
            ],
            [
                "name" => "Albania",
                "flag" => "🇦🇱",
                "code" => "AL",
                "dialCode" => "355",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Algeria",
                "flag" => "🇩🇿",
                "code" => "DZ",
                "dialCode" => "213",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "American Samoa",
                "flag" => "🇦🇸",
                "code" => "AS",
                "dialCode" => "1684",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Andorra",
                "flag" => "🇦🇩",
                "code" => "AD",
                "dialCode" => "376",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Angola",
                "flag" => "🇦🇴",
                "code" => "AO",
                "dialCode" => "244",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Anguilla",
                "flag" => "🇦🇮",
                "code" => "AI",
                "dialCode" => "1264",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Antarctica",
                "flag" => "🇦🇶",
                "code" => "AQ",
                "dialCode" => "672",
                "minLength" => 6,
                "maxLength" => 6
            ],
            [
                "name" => "Antigua and Barbuda",
                "flag" => "🇦🇬",
                "code" => "AG",
                "dialCode" => "1268",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Argentina",
                "flag" => "🇦🇷",
                "code" => "AR",
                "dialCode" => "54",
                "minLength" => 12,
                "maxLength" => 12
            ],
            [
                "name" => "Armenia",
                "flag" => "🇦🇲",
                "code" => "AM",
                "dialCode" => "374",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Aruba",
                "flag" => "🇦🇼",
                "code" => "AW",
                "dialCode" => "297",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Australia",
                "flag" => "🇦🇺",
                "code" => "AU",
                "dialCode" => "61",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Austria",
                "flag" => "🇦🇹",
                "code" => "AT",
                "dialCode" => "43",
                "minLength" => 13,
                "maxLength" => 13
            ],
            [
                "name" => "Azerbaijan",
                "flag" => "🇦🇿",
                "code" => "AZ",
                "dialCode" => "994",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Bahamas",
                "flag" => "🇧🇸",
                "code" => "BS",
                "dialCode" => "1242",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Bahrain",
                "flag" => "🇧🇭",
                "code" => "BH",
                "dialCode" => "973",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Bangladesh",
                "flag" => "🇧🇩",
                "code" => "BD",
                "dialCode" => "880",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Barbados",
                "flag" => "🇧🇧",
                "code" => "BB",
                "dialCode" => "1246",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Belarus",
                "flag" => "🇧🇾",
                "code" => "BY",
                "dialCode" => "375",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Belgium",
                "flag" => "🇧🇪",
                "code" => "BE",
                "dialCode" => "32",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Belize",
                "flag" => "🇧🇿",
                "code" => "BZ",
                "dialCode" => "501",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Benin",
                "flag" => "🇧🇯",
                "code" => "BJ",
                "dialCode" => "229",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Bermuda",
                "flag" => "🇧🇲",
                "code" => "BM",
                "dialCode" => "1441",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Bhutan",
                "flag" => "🇧🇹",
                "code" => "BT",
                "dialCode" => "975",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Bolivia, Plurinational State of bolivia",
                "flag" => "🇧🇴",
                "code" => "BO",
                "dialCode" => "591",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Bosnia and Herzegovina",
                "flag" => "🇧🇦",
                "code" => "BA",
                "dialCode" => "387",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Botswana",
                "flag" => "🇧🇼",
                "code" => "BW",
                "dialCode" => "267",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Bouvet Island",
                "flag" => "🇧🇻",
                "code" => "BV",
                "dialCode" => "47",
                "minLength" => 15,
                "maxLength" => 15
            ],
            [
                "name" => "Brazil",
                "flag" => "🇧🇷",
                "code" => "BR",
                "dialCode" => "55",
                "minLength" => 11,
                "maxLength" => 11
            ],
            [
                "name" => "British Indian Ocean Territory",
                "flag" => "🇮🇴",
                "code" => "IO",
                "dialCode" => "246",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Brunei Darussalam",
                "flag" => "🇧🇳",
                "code" => "BN",
                "dialCode" => "673",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Bulgaria",
                "flag" => "🇧🇬",
                "code" => "BG",
                "dialCode" => "359",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Burkina Faso",
                "flag" => "🇧🇫",
                "code" => "BF",
                "dialCode" => "226",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Burundi",
                "flag" => "🇧🇮",
                "code" => "BI",
                "dialCode" => "257",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Cambodia",
                "flag" => "🇰🇭",
                "code" => "KH",
                "dialCode" => "855",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Cameroon",
                "flag" => "🇨🇲",
                "code" => "CM",
                "dialCode" => "237",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Canada",
                "flag" => "🇨🇦",
                "code" => "CA",
                "dialCode" => "1",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Cape Verde",
                "flag" => "🇨🇻",
                "code" => "CV",
                "dialCode" => "238",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Cayman Islands",
                "flag" => "🇰🇾",
                "code" => "KY",
                "dialCode" => "345",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Central African Republic",
                "flag" => "🇨🇫",
                "code" => "CF",
                "dialCode" => "236",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Chad",
                "flag" => "🇹🇩",
                "code" => "TD",
                "dialCode" => "235",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Chile",
                "flag" => "🇨🇱",
                "code" => "CL",
                "dialCode" => "56",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "China",
                "flag" => "🇨🇳",
                "code" => "CN",
                "dialCode" => "86",
                "minLength" => 12,
                "maxLength" => 12
            ],
            [
                "name" => "Christmas Island",
                "flag" => "🇨🇽",
                "code" => "CX",
                "dialCode" => "61",
                "minLength" => 15,
                "maxLength" => 15
            ],
            [
                "name" => "Cocos (Keeling) Islands",
                "flag" => "🇨🇨",
                "code" => "CC",
                "dialCode" => "61",
                "minLength" => 15,
                "maxLength" => 15
            ],
            [
                "name" => "Colombia",
                "flag" => "🇨🇴",
                "code" => "CO",
                "dialCode" => "57",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Comoros",
                "flag" => "🇰🇲",
                "code" => "KM",
                "dialCode" => "269",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Congo",
                "flag" => "🇨🇬",
                "code" => "CG",
                "dialCode" => "242",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Congo, The Democratic Republic of the Congo",
                "flag" => "🇨🇩",
                "code" => "CD",
                "dialCode" => "243",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Cook Islands",
                "flag" => "🇨🇰",
                "code" => "CK",
                "dialCode" => "682",
                "minLength" => 5,
                "maxLength" => 5
            ],
            [
                "name" => "Costa Rica",
                "flag" => "🇨🇷",
                "code" => "CR",
                "dialCode" => "506",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Côte d'Ivoire",
                "flag" => "🇨🇮",
                "code" => "CI",
                "dialCode" => "225",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Croatia",
                "flag" => "🇭🇷",
                "code" => "HR",
                "dialCode" => "385",
                "minLength" => 12,
                "maxLength" => 12
            ],
            [
                "name" => "Cuba",
                "flag" => "🇨🇺",
                "code" => "CU",
                "dialCode" => "53",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Cyprus",
                "flag" => "🇨🇾",
                "code" => "CY",
                "dialCode" => "357",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Czech Republic",
                "flag" => "🇨🇿",
                "code" => "CZ",
                "dialCode" => "420",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Denmark",
                "flag" => "🇩🇰",
                "code" => "DK",
                "dialCode" => "45",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Djibouti",
                "flag" => "🇩🇯",
                "code" => "DJ",
                "dialCode" => "253",
                "minLength" => 6,
                "maxLength" => 6
            ],
            [
                "name" => "Dominica",
                "flag" => "🇩🇲",
                "code" => "DM",
                "dialCode" => "1767",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Dominican Republic",
                "flag" => "🇩🇴",
                "code" => "DO",
                "dialCode" => "1849",
                "minLength" => 12,
                "maxLength" => 12
            ],
            [
                "name" => "Ecuador",
                "flag" => "🇪🇨",
                "code" => "EC",
                "dialCode" => "593",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Egypt",
                "flag" => "🇪🇬",
                "code" => "EG",
                "dialCode" => "20",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "El Salvador",
                "flag" => "🇸🇻",
                "code" => "SV",
                "dialCode" => "503",
                "minLength" => 11,
                "maxLength" => 11
            ],
            [
                "name" => "Equatorial Guinea",
                "flag" => "🇬🇶",
                "code" => "GQ",
                "dialCode" => "240",
                "minLength" => 6,
                "maxLength" => 6
            ],
            [
                "name" => "Eritrea",
                "flag" => "🇪🇷",
                "code" => "ER",
                "dialCode" => "291",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Estonia",
                "flag" => "🇪🇪",
                "code" => "EE",
                "dialCode" => "372",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Ethiopia",
                "flag" => "🇪🇹",
                "code" => "ET",
                "dialCode" => "251",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Falkland Islands (Malvinas)",
                "flag" => "🇫🇰",
                "code" => "FK",
                "dialCode" => "500",
                "minLength" => 5,
                "maxLength" => 5
            ],
            [
                "name" => "Faroe Islands",
                "flag" => "🇫🇴",
                "code" => "FO",
                "dialCode" => "298",
                "minLength" => 6,
                "maxLength" => 6
            ],
            [
                "name" => "Fiji",
                "flag" => "🇫🇯",
                "code" => "FJ",
                "dialCode" => "679",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Finland",
                "flag" => "🇫🇮",
                "code" => "FI",
                "dialCode" => "358",
                "minLength" => 12,
                "maxLength" => 12
            ],
            [
                "name" => "France",
                "flag" => "🇫🇷",
                "code" => "FR",
                "dialCode" => "33",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "French Guiana",
                "flag" => "🇬🇫",
                "code" => "GF",
                "dialCode" => "594",
                "minLength" => 15,
                "maxLength" => 15
            ],
            [
                "name" => "French Polynesia",
                "flag" => "🇵🇫",
                "code" => "PF",
                "dialCode" => "689",
                "minLength" => 6,
                "maxLength" => 6
            ],
            [
                "name" => "French Southern Territories",
                "flag" => "🇹🇫",
                "code" => "TF",
                "dialCode" => "262",
                "minLength" => 15,
                "maxLength" => 15
            ],
            [
                "name" => "Gabon",
                "flag" => "🇬🇦",
                "code" => "GA",
                "dialCode" => "241",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Gambia",
                "flag" => "🇬🇲",
                "code" => "GM",
                "dialCode" => "220",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Georgia",
                "flag" => "🇬🇪",
                "code" => "GE",
                "dialCode" => "995",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Germany",
                "flag" => "🇩🇪",
                "code" => "DE",
                "dialCode" => "49",
                "minLength" => 9,
                "maxLength" => 13
            ],
            [
                "name" => "Ghana",
                "flag" => "🇬🇭",
                "code" => "GH",
                "dialCode" => "233",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Gibraltar",
                "flag" => "🇬🇮",
                "code" => "GI",
                "dialCode" => "350",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Greece",
                "flag" => "🇬🇷",
                "code" => "GR",
                "dialCode" => "30",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Greenland",
                "flag" => "🇬🇱",
                "code" => "GL",
                "dialCode" => "299",
                "minLength" => 6,
                "maxLength" => 6
            ],
            [
                "name" => "Grenada",
                "flag" => "🇬🇩",
                "code" => "GD",
                "dialCode" => "1473",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Guadeloupe",
                "flag" => "🇬🇵",
                "code" => "GP",
                "dialCode" => "590",
                "minLength" => 15,
                "maxLength" => 15
            ],
            [
                "name" => "Guam",
                "flag" => "🇬🇺",
                "code" => "GU",
                "dialCode" => "1671",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Guatemala",
                "flag" => "🇬🇹",
                "code" => "GT",
                "dialCode" => "502",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Guernsey",
                "flag" => "🇬🇬",
                "code" => "GG",
                "dialCode" => "44",
                "minLength" => 6,
                "maxLength" => 6
            ],
            [
                "name" => "Guinea",
                "flag" => "🇬🇳",
                "code" => "GN",
                "dialCode" => "224",
                "minLength" => 8,
                "maxLength" => 9
            ],
            [
                "name" => "Guinea-Bissau",
                "flag" => "🇬🇼",
                "code" => "GW",
                "dialCode" => "245",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Guyana",
                "flag" => "🇬🇾",
                "code" => "GY",
                "dialCode" => "592",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Haiti",
                "flag" => "🇭🇹",
                "code" => "HT",
                "dialCode" => "509",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Heard Island and Mcdonald Islands",
                "flag" => "🇭🇲",
                "code" => "HM",
                "dialCode" => "672",
                "minLength" => 15,
                "maxLength" => 15
            ],
            [
                "name" => "Holy See (Vatican City State)",
                "flag" => "🇻🇦",
                "code" => "VA",
                "dialCode" => "379",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Honduras",
                "flag" => "🇭🇳",
                "code" => "HN",
                "dialCode" => "504",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Hong Kong",
                "flag" => "🇭🇰",
                "code" => "HK",
                "dialCode" => "852",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Hungary",
                "flag" => "🇭🇺",
                "code" => "HU",
                "dialCode" => "36",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Iceland",
                "flag" => "🇮🇸",
                "code" => "IS",
                "dialCode" => "354",
                "minLength" => 7,
                "maxLength" => 9
            ],
            [
                "name" => "India",
                "flag" => "🇮🇳",
                "code" => "IN",
                "dialCode" => "91",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Indonesia",
                "flag" => "🇮🇩",
                "code" => "ID",
                "dialCode" => "62",
                "minLength" => 13,
                "maxLength" => 13
            ],
            [
                "name" => "Iran, Islamic Republic of Persian Gulf",
                "flag" => "🇮🇷",
                "code" => "IR",
                "dialCode" => "98",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Iraq",
                "flag" => "🇮🇶",
                "code" => "IQ",
                "dialCode" => "964",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Ireland",
                "flag" => "🇮🇪",
                "code" => "IE",
                "dialCode" => "353",
                "minLength" => 7,
                "maxLength" => 9
            ],
            [
                "name" => "Isle of Man",
                "flag" => "🇮🇲",
                "code" => "IM",
                "dialCode" => "44",
                "minLength" => 6,
                "maxLength" => 6
            ],
            [
                "name" => "Israel",
                "flag" => "🇮🇱",
                "code" => "IL",
                "dialCode" => "972",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Italy",
                "flag" => "🇮🇹",
                "code" => "IT",
                "dialCode" => "39",
                "minLength" => 13,
                "maxLength" => 13
            ],
            [
                "name" => "Jamaica",
                "flag" => "🇯🇲",
                "code" => "JM",
                "dialCode" => "1876",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Japan",
                "flag" => "🇯🇵",
                "code" => "JP",
                "dialCode" => "81",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Jersey",
                "flag" => "🇯🇪",
                "code" => "JE",
                "dialCode" => "44",
                "minLength" => 6,
                "maxLength" => 6
            ],
            [
                "name" => "Jordan",
                "flag" => "🇯🇴",
                "code" => "JO",
                "dialCode" => "962",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Kazakhstan",
                "flag" => "🇰🇿",
                "code" => "KZ",
                "dialCode" => "7",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Kenya",
                "flag" => "🇰🇪",
                "code" => "KE",
                "dialCode" => "254",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Kiribati",
                "flag" => "🇰🇮",
                "code" => "KI",
                "dialCode" => "686",
                "minLength" => 5,
                "maxLength" => 5
            ],
            [
                "name" => "Korea, Democratic People's Republic of Korea",
                "flag" => "🇰🇵",
                "code" => "KP",
                "dialCode" => "850",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Korea, Republic of South Korea",
                "flag" => "🇰🇷",
                "code" => "KR",
                "dialCode" => "82",
                "minLength" => 11,
                "maxLength" => 11
            ],
            [
                "name" => "Kosovo",
                "flag" => "🇽🇰",
                "code" => "XK",
                "dialCode" => "383",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Kuwait",
                "flag" => "🇰🇼",
                "code" => "KW",
                "dialCode" => "965",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Kyrgyzstan",
                "flag" => "🇰🇬",
                "code" => "KG",
                "dialCode" => "996",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Laos",
                "flag" => "🇱🇦",
                "code" => "LA",
                "dialCode" => "856",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Latvia",
                "flag" => "🇱🇻",
                "code" => "LV",
                "dialCode" => "371",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Lebanon",
                "flag" => "🇱🇧",
                "code" => "LB",
                "dialCode" => "961",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Lesotho",
                "flag" => "🇱🇸",
                "code" => "LS",
                "dialCode" => "266",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Liberia",
                "flag" => "🇱🇷",
                "code" => "LR",
                "dialCode" => "231",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Libyan Arab Jamahiriya",
                "flag" => "🇱🇾",
                "code" => "LY",
                "dialCode" => "218",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Liechtenstein",
                "flag" => "🇱🇮",
                "code" => "LI",
                "dialCode" => "423",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Lithuania",
                "flag" => "🇱🇹",
                "code" => "LT",
                "dialCode" => "370",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Luxembourg",
                "flag" => "🇱🇺",
                "code" => "LU",
                "dialCode" => "352",
                "minLength" => 12,
                "maxLength" => 12
            ],
            [
                "name" => "Macao",
                "flag" => "🇲🇴",
                "code" => "MO",
                "dialCode" => "853",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Macedonia",
                "flag" => "🇲🇰",
                "code" => "MK",
                "dialCode" => "389",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Madagascar",
                "flag" => "🇲🇬",
                "code" => "MG",
                "dialCode" => "261",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Malawi",
                "flag" => "🇲🇼",
                "code" => "MW",
                "dialCode" => "265",
                "minLength" => 7,
                "maxLength" => 9
            ],
            [
                "name" => "Malaysia",
                "flag" => "🇲🇾",
                "code" => "MY",
                "dialCode" => "60",
                "minLength" => 11,
                "maxLength" => 11
            ],
            [
                "name" => "Maldives",
                "flag" => "🇲🇻",
                "code" => "MV",
                "dialCode" => "960",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Mali",
                "flag" => "🇲🇱",
                "code" => "ML",
                "dialCode" => "223",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Malta",
                "flag" => "🇲🇹",
                "code" => "MT",
                "dialCode" => "356",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Marshall Islands",
                "flag" => "🇲🇭",
                "code" => "MH",
                "dialCode" => "692",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Martinique",
                "flag" => "🇲🇶",
                "code" => "MQ",
                "dialCode" => "596",
                "minLength" => 15,
                "maxLength" => 15
            ],
            [
                "name" => "Mauritania",
                "flag" => "🇲🇷",
                "code" => "MR",
                "dialCode" => "222",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Mauritius",
                "flag" => "🇲🇺",
                "code" => "MU",
                "dialCode" => "230",
                "minLength" => 7,
                "maxLength" => 8
            ],
            [
                "name" => "Mayotte",
                "flag" => "🇾🇹",
                "code" => "YT",
                "dialCode" => "262",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Mexico",
                "flag" => "🇲🇽",
                "code" => "MX",
                "dialCode" => "52",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Micronesia, Federated States of Micronesia",
                "flag" => "🇫🇲",
                "code" => "FM",
                "dialCode" => "691",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Moldova",
                "flag" => "🇲🇩",
                "code" => "MD",
                "dialCode" => "373",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Monaco",
                "flag" => "🇲🇨",
                "code" => "MC",
                "dialCode" => "377",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Mongolia",
                "flag" => "🇲🇳",
                "code" => "MN",
                "dialCode" => "976",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Montenegro",
                "flag" => "🇲🇪",
                "code" => "ME",
                "dialCode" => "382",
                "minLength" => 12,
                "maxLength" => 12
            ],
            [
                "name" => "Montserrat",
                "flag" => "🇲🇸",
                "code" => "MS",
                "dialCode" => "1664",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Morocco",
                "flag" => "🇲🇦",
                "code" => "MA",
                "dialCode" => "212",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Mozambique",
                "flag" => "🇲🇿",
                "code" => "MZ",
                "dialCode" => "258",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Myanmar",
                "flag" => "🇲🇲",
                "code" => "MM",
                "dialCode" => "95",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Namibia",
                "flag" => "🇳🇦",
                "code" => "NA",
                "dialCode" => "264",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Nauru",
                "flag" => "🇳🇷",
                "code" => "NR",
                "dialCode" => "674",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Nepal",
                "flag" => "🇳🇵",
                "code" => "NP",
                "dialCode" => "977",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Netherlands",
                "flag" => "🇳🇱",
                "code" => "NL",
                "dialCode" => "31",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Netherlands Antilles",
                "flag" => "",
                "code" => "AN",
                "dialCode" => "599",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "New Caledonia",
                "flag" => "🇳🇨",
                "code" => "NC",
                "dialCode" => "687",
                "minLength" => 6,
                "maxLength" => 6
            ],
            [
                "name" => "New Zealand",
                "flag" => "🇳🇿",
                "code" => "NZ",
                "dialCode" => "64",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Nicaragua",
                "flag" => "🇳🇮",
                "code" => "NI",
                "dialCode" => "505",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Niger",
                "flag" => "🇳🇪",
                "code" => "NE",
                "dialCode" => "227",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Nigeria",
                "flag" => "🇳🇬",
                "code" => "NG",
                "dialCode" => "234",
                "minLength" => 10,
                "maxLength" => 11
            ],
            [
                "name" => "Niue",
                "flag" => "🇳🇺",
                "code" => "NU",
                "dialCode" => "683",
                "minLength" => 4,
                "maxLength" => 4
            ],
            [
                "name" => "Norfolk Island",
                "flag" => "🇳🇫",
                "code" => "NF",
                "dialCode" => "672",
                "minLength" => 15,
                "maxLength" => 15
            ],
            [
                "name" => "Northern Mariana Islands",
                "flag" => "🇲🇵",
                "code" => "MP",
                "dialCode" => "1670",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Norway",
                "flag" => "🇳🇴",
                "code" => "NO",
                "dialCode" => "47",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Oman",
                "flag" => "🇴🇲",
                "code" => "OM",
                "dialCode" => "968",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Pakistan",
                "flag" => "🇵🇰",
                "code" => "PK",
                "dialCode" => "92",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Palau",
                "flag" => "🇵🇼",
                "code" => "PW",
                "dialCode" => "680",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Palestinian Territory, Occupied",
                "flag" => "🇵🇸",
                "code" => "PS",
                "dialCode" => "970",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Panama",
                "flag" => "🇵🇦",
                "code" => "PA",
                "dialCode" => "507",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Papua New Guinea",
                "flag" => "🇵🇬",
                "code" => "PG",
                "dialCode" => "675",
                "minLength" => 11,
                "maxLength" => 11
            ],
            [
                "name" => "Paraguay",
                "flag" => "🇵🇾",
                "code" => "PY",
                "dialCode" => "595",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Peru",
                "flag" => "🇵🇪",
                "code" => "PE",
                "dialCode" => "51",
                "minLength" => 11,
                "maxLength" => 11
            ],
            [
                "name" => "Philippines",
                "flag" => "🇵🇭",
                "code" => "PH",
                "dialCode" => "63",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Pitcairn",
                "flag" => "🇵🇳",
                "code" => "PN",
                "dialCode" => "64",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Poland",
                "flag" => "🇵🇱",
                "code" => "PL",
                "dialCode" => "48",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Portugal",
                "flag" => "🇵🇹",
                "code" => "PT",
                "dialCode" => "351",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Puerto Rico",
                "flag" => "🇵🇷",
                "code" => "PR",
                "dialCode" => "1939",
                "minLength" => 15,
                "maxLength" => 15
            ],
            [
                "name" => "Qatar",
                "flag" => "🇶🇦",
                "code" => "QA",
                "dialCode" => "974",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Romania",
                "flag" => "🇷🇴",
                "code" => "RO",
                "dialCode" => "40",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Russia",
                "flag" => "🇷🇺",
                "code" => "RU",
                "dialCode" => "7",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Rwanda",
                "flag" => "🇷🇼",
                "code" => "RW",
                "dialCode" => "250",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Reunion",
                "flag" => "🇷🇪",
                "code" => "RE",
                "dialCode" => "262",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Saint Barthelemy",
                "flag" => "🇧🇱",
                "code" => "BL",
                "dialCode" => "590",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Saint Helena, Ascension and Tristan Da Cunha",
                "flag" => "🇸🇭",
                "code" => "SH",
                "dialCode" => "290",
                "minLength" => 4,
                "maxLength" => 4
            ],
            [
                "name" => "Saint Kitts and Nevis",
                "flag" => "🇰🇳",
                "code" => "KN",
                "dialCode" => "1869",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Saint Lucia",
                "flag" => "🇱🇨",
                "code" => "LC",
                "dialCode" => "1758",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Saint Martin",
                "flag" => "🇲🇫",
                "code" => "MF",
                "dialCode" => "590",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Saint Pierre and Miquelon",
                "flag" => "🇵🇲",
                "code" => "PM",
                "dialCode" => "508",
                "minLength" => 6,
                "maxLength" => 6
            ],
            [
                "name" => "Saint Vincent and the Grenadines",
                "flag" => "🇻🇨",
                "code" => "VC",
                "dialCode" => "1784",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Samoa",
                "flag" => "🇼🇸",
                "code" => "WS",
                "dialCode" => "685",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "San Marino",
                "flag" => "🇸🇲",
                "code" => "SM",
                "dialCode" => "378",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Sao Tome and Principe",
                "flag" => "🇸🇹",
                "code" => "ST",
                "dialCode" => "239",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Saudi Arabia",
                "flag" => "🇸🇦",
                "code" => "SA",
                "dialCode" => "966",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Senegal",
                "flag" => "🇸🇳",
                "code" => "SN",
                "dialCode" => "221",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Serbia",
                "flag" => "🇷🇸",
                "code" => "RS",
                "dialCode" => "381",
                "minLength" => 12,
                "maxLength" => 12
            ],
            [
                "name" => "Seychelles",
                "flag" => "🇸🇨",
                "code" => "SC",
                "dialCode" => "248",
                "minLength" => 6,
                "maxLength" => 6
            ],
            [
                "name" => "Sierra Leone",
                "flag" => "🇸🇱",
                "code" => "SL",
                "dialCode" => "232",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Singapore",
                "flag" => "🇸🇬",
                "code" => "SG",
                "dialCode" => "65",
                "minLength" => 12,
                "maxLength" => 12
            ],
            [
                "name" => "Slovakia",
                "flag" => "🇸🇰",
                "code" => "SK",
                "dialCode" => "421",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Slovenia",
                "flag" => "🇸🇮",
                "code" => "SI",
                "dialCode" => "386",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Solomon Islands",
                "flag" => "🇸🇧",
                "code" => "SB",
                "dialCode" => "677",
                "minLength" => 5,
                "maxLength" => 5
            ],
            [
                "name" => "Somalia",
                "flag" => "🇸🇴",
                "code" => "SO",
                "dialCode" => "252",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "South Africa",
                "flag" => "🇿🇦",
                "code" => "ZA",
                "dialCode" => "27",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "South Sudan",
                "flag" => "🇸🇸",
                "code" => "SS",
                "dialCode" => "211",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "South Georgia and the South Sandwich Islands",
                "flag" => "🇬🇸",
                "code" => "GS",
                "dialCode" => "500",
                "minLength" => 15,
                "maxLength" => 15
            ],
            [
                "name" => "Spain",
                "flag" => "🇪🇸",
                "code" => "ES",
                "dialCode" => "34",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Sri Lanka",
                "flag" => "🇱🇰",
                "code" => "LK",
                "dialCode" => "94",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Sudan",
                "flag" => "🇸🇩",
                "code" => "SD",
                "dialCode" => "249",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Suriname",
                "flag" => "🇸🇷",
                "code" => "SR",
                "dialCode" => "597",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Svalbard and Jan Mayen",
                "flag" => "🇸🇯",
                "code" => "SJ",
                "dialCode" => "47",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Eswatini",
                "flag" => "🇸🇿",
                "code" => "SZ",
                "dialCode" => "268",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Sweden",
                "flag" => "🇸🇪",
                "code" => "SE",
                "dialCode" => "46",
                "minLength" => 7,
                "maxLength" => 13
            ],
            [
                "name" => "Switzerland",
                "flag" => "🇨🇭",
                "code" => "CH",
                "dialCode" => "41",
                "minLength" => 12,
                "maxLength" => 12
            ],
            [
                "name" => "Syrian Arab Republic",
                "flag" => "🇸🇾",
                "code" => "SY",
                "dialCode" => "963",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Taiwan",
                "flag" => "🇹🇼",
                "code" => "TW",
                "dialCode" => "886",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Tajikistan",
                "flag" => "🇹🇯",
                "code" => "TJ",
                "dialCode" => "992",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Tanzania, United Republic of Tanzania",
                "flag" => "🇹🇿",
                "code" => "TZ",
                "dialCode" => "255",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Thailand",
                "flag" => "🇹🇭",
                "code" => "TH",
                "dialCode" => "66",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Timor-Leste",
                "flag" => "🇹🇱",
                "code" => "TL",
                "dialCode" => "670",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Togo",
                "flag" => "🇹🇬",
                "code" => "TG",
                "dialCode" => "228",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Tokelau",
                "flag" => "🇹🇰",
                "code" => "TK",
                "dialCode" => "690",
                "minLength" => 4,
                "maxLength" => 4
            ],
            [
                "name" => "Tonga",
                "flag" => "🇹🇴",
                "code" => "TO",
                "dialCode" => "676",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Trinidad and Tobago",
                "flag" => "🇹🇹",
                "code" => "TT",
                "dialCode" => "1868",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Tunisia",
                "flag" => "🇹🇳",
                "code" => "TN",
                "dialCode" => "216",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Turkey",
                "flag" => "🇹🇷",
                "code" => "TR",
                "dialCode" => "90",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Turkmenistan",
                "flag" => "🇹🇲",
                "code" => "TM",
                "dialCode" => "993",
                "minLength" => 8,
                "maxLength" => 8
            ],
            [
                "name" => "Turks and Caicos Islands",
                "flag" => "🇹🇨",
                "code" => "TC",
                "dialCode" => "1649",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Tuvalu",
                "flag" => "🇹🇻",
                "code" => "TV",
                "dialCode" => "688",
                "minLength" => 6,
                "maxLength" => 6
            ],
            [
                "name" => "Uganda",
                "flag" => "🇺🇬",
                "code" => "UG",
                "dialCode" => "256",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Ukraine",
                "flag" => "🇺🇦",
                "code" => "UA",
                "dialCode" => "380",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "United Arab Emirates",
                "flag" => "🇦🇪",
                "code" => "AE",
                "dialCode" => "971",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "United Kingdom",
                "flag" => "🇬🇧",
                "code" => "GB",
                "dialCode" => "44",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "United States",
                "flag" => "🇺🇸",
                "code" => "US",
                "dialCode" => "1",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Uruguay",
                "flag" => "🇺🇾",
                "code" => "UY",
                "dialCode" => "598",
                "minLength" => 11,
                "maxLength" => 11
            ],
            [
                "name" => "Uzbekistan",
                "flag" => "🇺🇿",
                "code" => "UZ",
                "dialCode" => "998",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Vanuatu",
                "flag" => "🇻🇺",
                "code" => "VU",
                "dialCode" => "678",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Venezuela, Bolivarian Republic of Venezuela",
                "flag" => "🇻🇪",
                "code" => "VE",
                "dialCode" => "58",
                "minLength" => 10,
                "maxLength" => 10
            ],
            [
                "name" => "Vietnam",
                "flag" => "🇻🇳",
                "code" => "VN",
                "dialCode" => "84",
                "minLength" => 11,
                "maxLength" => 11
            ],
            [
                "name" => "Virgin Islands, British",
                "flag" => "🇻🇬",
                "code" => "VG",
                "dialCode" => "1284",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Virgin Islands, U.S.",
                "flag" => "🇻🇮",
                "code" => "VI",
                "dialCode" => "1340",
                "minLength" => 7,
                "maxLength" => 7
            ],
            [
                "name" => "Wallis and Futuna",
                "flag" => "🇼🇫",
                "code" => "WF",
                "dialCode" => "681",
                "minLength" => 6,
                "maxLength" => 6
            ],
            [
                "name" => "Yemen",
                "flag" => "🇾🇪",
                "code" => "YE",
                "dialCode" => "967",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Zambia",
                "flag" => "🇿🇲",
                "code" => "ZM",
                "dialCode" => "260",
                "minLength" => 9,
                "maxLength" => 9
            ],
            [
                "name" => "Zimbabwe",
                "flag" => "🇿🇼",
                "code" => "ZW",
                "dialCode" => "263",
                "minLength" => 9,
                "maxLength" => 9
            ]
        ];


    /**
     * Get all country codes
     *
     * @return array
     */
    public static function all()
    {
        return self::COUNTRY_CODES;
    }

    /**
     * Get country by code
     *
     * @param string $code
     * @return array|null
     */
    public static function getByCode($code)
    {
        return collect(self::COUNTRY_CODES)->firstWhere('code', strtoupper($code));
    }

    /**
     * Get country by dial code
     *
     * @param string $dialCode
     * @return array|null
     */
    public static function getByDialCode($dialCode)
    {
        return collect(self::COUNTRY_CODES)->firstWhere('dialCode', $dialCode);
    }

    /**
     * Get dial code by country code
     *
     * @param string $countryCode
     * @return string|null
     */
    public static function getDialCode($countryCode)
    {
        foreach (self::COUNTRY_CODES as $country) {
            if ($country['code'] === strtoupper($countryCode)) {
                return $country['dialCode'];
            }
        }
        return null;
    }



}
