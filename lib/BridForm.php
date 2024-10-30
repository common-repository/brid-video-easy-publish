<?php
class BridForm
{
	public static function getCountries()
	{
		return array(
			"AF" => "Afghanistan",
			"AX" => "Aland Islands",
			"AL" => "Albania",
			"DZ" => "Algeria",
			"AS" => "American Samoa",
			"AD" => "Andorra",
			"AO" => "Angola",
			"AI" => "Anguilla",
			"AQ" => "Antarctica",
			"AG" => "Antigua and Barbuda",
			"AR" => "Argentina",
			"AM" => "Armenia",
			"AW" => "Aruba",
			"AU" => "Australia",
			"AT" => "Austria",
			"AZ" => "Azerbaijan",
			"BS" => "Bahamas",
			"BH" => "Bahrain",
			"BD" => "Bangladesh",
			"BB" => "Barbados",
			"BY" => "Belarus",
			"BE" => "Belgium",
			"BZ" => "Belize",
			"BJ" => "Benin",
			"BM" => "Bermuda",
			"BT" => "Bhutan",
			"BO" => "Bolivia",
			"BA" => "Bosnia and Herzegovina",
			"BW" => "Botswana",
			"BV" => "Bouvet Island",
			"BR" => "Brazil",
			"IO" => "British Indian Ocean Territory",
			"BN" => "Brunei Darussalam",
			"BG" => "Bulgaria",
			"BF" => "Burkina Faso",
			"BI" => "Burundi",
			"KH" => "Cambodia",
			"CM" => "Cameroon",
			"CA" => "Canada",
			"CV" => "Cape Verde",
			"KY" => "Cayman Islands",
			"CF" => "Central African Republic",
			"TD" => "Chad",
			"CL" => "Chile",
			"CN" => "China",
			"CX" => "Christmas Island",
			"CC" => "Cocos (Keeling) Islands",
			"CO" => "Colombia",
			"KM" => "Comoros",
			"CG" => "Congo",
			"CD" => "Congo, The Democratic Republic of The",
			"CK" => "Cook Islands",
			"CR" => "Costa Rica",
			"CI" => "Cote D'ivoire",
			"HR" => "Croatia",
			"CU" => "Cuba",
			"CY" => "Cyprus",
			"CZ" => "Czech Republic",
			"DK" => "Denmark",
			"DJ" => "Djibouti",
			"DM" => "Dominica",
			"DO" => "Dominican Republic",
			"EC" => "Ecuador",
			"EG" => "Egypt",
			"SV" => "El Salvador",
			"GQ" => "Equatorial Guinea",
			"ER" => "Eritrea",
			"EE" => "Estonia",
			"ET" => "Ethiopia",
			"FK" => "Falkland Islands (Malvinas)",
			"FO" => "Faroe Islands",
			"FJ" => "Fiji",
			"FI" => "Finland",
			"FR" => "France",
			"GF" => "French Guiana",
			"PF" => "French Polynesia",
			"TF" => "French Southern Territories",
			"GA" => "Gabon",
			"GM" => "Gambia",
			"GE" => "Georgia",
			"DE" => "Germany",
			"GH" => "Ghana",
			"GI" => "Gibraltar",
			"GR" => "Greece",
			"GL" => "Greenland",
			"GD" => "Grenada",
			"GP" => "Guadeloupe",
			"GU" => "Guam",
			"GT" => "Guatemala",
			"GG" => "Guernsey",
			"GN" => "Guinea",
			"GW" => "Guinea-bissau",
			"GY" => "Guyana",
			"HT" => "Haiti",
			"HM" => "Heard Island and Mcdonald Islands",
			"VA" => "Holy See (Vatican City State)",
			"HN" => "Honduras",
			"HK" => "Hong Kong",
			"HU" => "Hungary",
			"IS" => "Iceland",
			"IN" => "India",
			"ID" => "Indonesia",
			"IR" => "Iran, Islamic Republic of",
			"IQ" => "Iraq",
			"IE" => "Ireland",
			"IM" => "Isle of Man",
			"IL" => "Israel",
			"IT" => "Italy",
			"JM" => "Jamaica",
			"JP" => "Japan",
			"JE" => "Jersey",
			"JO" => "Jordan",
			"KZ" => "Kazakhstan",
			"KE" => "Kenya",
			"KI" => "Kiribati",
			"KP" => "Korea, Democratic People's Republic of",
			"KR" => "Korea, Republic of",
			"KW" => "Kuwait",
			"KG" => "Kyrgyzstan",
			"LA" => "Lao People's Democratic Republic",
			"LV" => "Latvia",
			"LB" => "Lebanon",
			"LS" => "Lesotho",
			"LR" => "Liberia",
			"LY" => "Libyan Arab Jamahiriya",
			"LI" => "Liechtenstein",
			"LT" => "Lithuania",
			"LU" => "Luxembourg",
			"MO" => "Macao",
			"MK" => "Macedonia, The Former Yugoslav Republic of",
			"MG" => "Madagascar",
			"MW" => "Malawi",
			"MY" => "Malaysia",
			"MV" => "Maldives",
			"ML" => "Mali",
			"MT" => "Malta",
			"MH" => "Marshall Islands",
			"MQ" => "Martinique",
			"MR" => "Mauritania",
			"MU" => "Mauritius",
			"YT" => "Mayotte",
			"MX" => "Mexico",
			"FM" => "Micronesia, Federated States of",
			"MD" => "Moldova, Republic of",
			"MC" => "Monaco",
			"MN" => "Mongolia",
			"ME" => "Montenegro",
			"MS" => "Montserrat",
			"MA" => "Morocco",
			"MZ" => "Mozambique",
			"MM" => "Myanmar",
			"NA" => "Namibia",
			"NR" => "Nauru",
			"NP" => "Nepal",
			"NL" => "Netherlands",
			"AN" => "Netherlands Antilles",
			"NC" => "New Caledonia",
			"NZ" => "New Zealand",
			"NI" => "Nicaragua",
			"NE" => "Niger",
			"NG" => "Nigeria",
			"NU" => "Niue",
			"NF" => "Norfolk Island",
			"MP" => "Northern Mariana Islands",
			"NO" => "Norway",
			"OM" => "Oman",
			"PK" => "Pakistan",
			"PW" => "Palau",
			"PS" => "Palestinian Territory, Occupied",
			"PA" => "Panama",
			"PG" => "Papua New Guinea",
			"PY" => "Paraguay",
			"PE" => "Peru",
			"PH" => "Philippines",
			"PN" => "Pitcairn",
			"PL" => "Poland",
			"PT" => "Portugal",
			"PR" => "Puerto Rico",
			"QA" => "Qatar",
			"RE" => "Reunion",
			"RO" => "Romania",
			"RU" => "Russian Federation",
			"RW" => "Rwanda",
			"SH" => "Saint Helena",
			"KN" => "Saint Kitts and Nevis",
			"LC" => "Saint Lucia",
			"PM" => "Saint Pierre and Miquelon",
			"VC" => "Saint Vincent and The Grenadines",
			"WS" => "Samoa",
			"SM" => "San Marino",
			"ST" => "Sao Tome and Principe",
			"SA" => "Saudi Arabia",
			"SN" => "Senegal",
			"RS" => "Serbia",
			"SC" => "Seychelles",
			"SL" => "Sierra Leone",
			"SG" => "Singapore",
			"SK" => "Slovakia",
			"SI" => "Slovenia",
			"SB" => "Solomon Islands",
			"SO" => "Somalia",
			"ZA" => "South Africa",
			"GS" => "South Georgia and The South Sandwich Islands",
			"ES" => "Spain",
			"LK" => "Sri Lanka",
			"SD" => "Sudan",
			"SR" => "Suriname",
			"SJ" => "Svalbard and Jan Mayen",
			"SZ" => "Swaziland",
			"SE" => "Sweden",
			"CH" => "Switzerland",
			"SY" => "Syrian Arab Republic",
			"TW" => "Taiwan, Province of China",
			"TJ" => "Tajikistan",
			"TZ" => "Tanzania, United Republic of",
			"TH" => "Thailand",
			"TL" => "Timor-leste",
			"TG" => "Togo",
			"TK" => "Tokelau",
			"TO" => "Tonga",
			"TT" => "Trinidad and Tobago",
			"TN" => "Tunisia",
			"TR" => "Turkey",
			"TM" => "Turkmenistan",
			"TC" => "Turks and Caicos Islands",
			"TV" => "Tuvalu",
			"UG" => "Uganda",
			"UA" => "Ukraine",
			"AE" => "United Arab Emirates",
			"GB" => "United Kingdom",
			"US" => "United States",
			"UM" => "United States Minor Outlying Islands",
			"UY" => "Uruguay",
			"UZ" => "Uzbekistan",
			"VU" => "Vanuatu",
			"VE" => "Venezuela",
			"VN" => "Viet Nam",
			"VG" => "Virgin Islands, British",
			"VI" => "Virgin Islands, U.S.",
			"WF" => "Wallis and Futuna",
			"EH" => "Western Sahara",
			"YE" => "Yemen",
			"ZM" => "Zambia",
			"ZW" => "Zimbabwe",
			"CW" => "Curaçao",
			"SX" => "Sint Maarten",
			"BQ" => "Sint Eustatius and Saba",
			"MF" => "Saint Martin",
			"SS" => "South Sudan",
			"XK" => "Serbian Rebuplic Kosovo",
			"BL" => "Saint Barts",
			"None" => "Other Countries"
		);
	}
	public static function file_size($size, $precision = 2, $unit = true)
	{

		$size = $size * 1000 * 1000 * 1000;
		static $units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
		$step = 1000;
		$i = 0;
		while (($size / $step) > 0.9) {
			$size = $size / $step;
			$i++;
		}
		return round($size, $precision) . (($unit && isset($units[$i])) ? " " . $units[$i] : '');
	}

	public static function numberFormat($number)
	{
		if ($number < 1000) {
			return $number;
		} elseif ($number < 1000 * 1000) {
			return round($number / 1000, 1) . 'K';
		} elseif ($number < 1000 * 1000 * 1000) {
			return round($number / (1000 * 1000), 1) . 'M';
		} elseif ($number < 1000 * 1000 * 1000 * 1000) {
			return round($number / (1000 * 1000 * 1000), 1) . 'B';
		}
	}

	public static function drawForm($model, $descriptors)
	{
		if (empty($descriptors[$model])) return '';
		if (!empty($descriptors)) {
			foreach ($descriptors[$model] as $k => $section) {
				$kStripped = str_replace(' ', '_', $k);
?>

				<div class="brid-section" id="brid-section-<?php echo strtolower(trim(strip_tags($kStripped))); ?>">
					<h3 class="brid-section-title"><?php echo $k ?></h3>
					<?php
					self::drawSection($section, $model);
					?>
				</div>
			<?php
			}
		}
	}

	public static function drawSection($section, $model)
	{
		foreach ($section as $j => $val) {

			if ($j == 'fields') {
			?>
				<div class="brid-section-content">
					<?php
					self::drawFields($val, $model);
					?>
				</div>
			<?php
			} else {
				$jStripped = str_replace(' ', '', $j);
			?>
				<div class="brid-sub-section" id="brid-subsection-<?php echo strtolower(trim(strip_tags($jStripped))); ?>">
					<h4 class="brid-sub-section-title"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <?php echo $j ?></h4>
					<?php
					self::drawSubsection($val, $model);
					?>
				</div>
<?php
			}
		}
	}

	public static function drawSubsection($fields, $model)
	{
		self::drawSection($fields, $model);
	}

	public static function drawFields($fields, $model)
	{
		foreach ($fields as $name => $field) {
			$stripped = str_replace(' ', '_', $name);
			self::drawField($stripped, $field, $model);
		}
	}

	public static function drawField($name, $field, $model = null)
	{
		$label = isset($field['label']) ? $field['label'] : ucfirst($name);
		$class = isset($field['class']) ? $field['class'] : 'brid-' . $name;
		$id = isset($field['id']) ? $field['id'] : 'brid-id-' . $name;
		$inputName = isset($field['inputName']) ? $field['inputName'] : $model . '[' . $name . ']';
		$multiple = isset($field['multiple']) ? 'multiple' : '';

		//Special wrapper div
		if ($field['type'] == 'wrapper') self::drawWrpper($field);

		//Simple div
		if ($field['type'] == 'div') self::drawDiv($field);

		$brid_event_class = '';
		$brid_event_options = '';

		if (isset($field['event'])) {
			$brid_event_class = 'brid-event';
			$brid_event_options = "data-options='" . $field['event'] . "'";
		}

		if ($field['type'] !== 'custom') {
			echo '<div class="brid-input-item brid-input-item-' . $field['type'] . '  brid-input-item-' . $name . ' ' . $brid_event_class . '" ' . $brid_event_options;
			if ($field['type'] === 'text') echo 'style="height: 80px"';
			echo '>';
		}

		//Print before
		if (isset($field['before'])) {
			echo '<div class="brid-input-div-before">' . $field['before'] . '</div>';
		}

		if ($label != 'off') {
			$tooltip = '';
			if (isset($field['tooltip'])) {
				$tooltip = ' <i class="fa fa-question-circle brid-tooltip-click" id="checkbox-' . $name . '" aria-hidden="true" data-tooltip="' . $field['tooltip'] . '"></i>';
			}

			echo '<label class="brid-label brid-' . $field['type'] . ' brid-label-' . $name . '">' . $label . $tooltip . '</label>';
		}
		if ($field['type'] !== 'custom') echo '<div class="brid-input-div">';
		if ($field['type'] == 'input') self::drawInput($id, $field, $class, $inputName);
		if ($field['type'] == 'text') self::drawTextInput($id, $field, $class, $inputName);
		if ($field['type'] == 'hidden') self::drawHidden($id, $field, $class, $inputName);
		if ($field['type'] == 'radio') self::drawRadio($id, $field, $class, $inputName);
		if ($field['type'] == 'select') self::drawSelect($id, $field, $class, $inputName, $multiple);
		if ($field['type'] == 'datetime') self::drawDatetime($id, $field, $class, $inputName);
		if ($field['type'] == 'upload') self::drawUpload($id, $field, $class, $inputName);
		if ($field['type'] == 'checkbox') self::drawCheckbox($id, $field, $class, $inputName);
		if ($field['type'] == 'custom') self::drawCustom($field);
		if ($field['type'] !== 'custom') echo '</div>';

		//Print after
		if (isset($field['after'])) {
			echo '<div class="brid-input-div-after">' . $field['after'] . '</div>';
		}

		if ($field['type'] !== 'custom') echo '</div>';

		self::drawJs($field);
	}

	private static function value($prop)
	{
		if (empty($prop)) return '';
		return $prop;
	}

	private static function htmlIdDecorator($id)
	{
		if (empty($id)) return '';
		return ' id="' . $$id . '" ';
	}

	private static function drawJs($field)
	{
		if (empty($field['javascript'])) return;
		echo "<script>" . $field['javascript'] . "</script>";
	}

	private static function drawWrpper($field)
	{
		if ($field['mode'] == 'start') {
			$field['divClass'] = empty($field['divClass']) ? '' : $field['divClass'];
			$field['divId'] = empty($field['divId']) ? '' : $field['divId'];
			echo '<div class="brid-input-wrapper ' . self::value($field['divClass']) . '" ' . self::htmlIdDecorator($field['divId']) . '>';
		} else {
			echo '</div>';
		}

		self::drawJs($field);

		return;
	}

	private static function drawDiv($field)
	{
		//Simple div
		if ($field['mode'] == 'content') {
			$field['divClass'] = empty($field['divClass']) ? '' : $field['divClass'];
			$field['divId'] = empty($field['divId']) ? '' : $field['divId'];
			echo '<div class="brid-input-wrapper-column ' . self::value($field['divClass']) . '" ' . self::htmlIdDecorator($field['divId']) . '>' . self::value($field['content']) . '</div>';
		} else if ($field['mode'] == 'start') { //Open/Close div tag
			$field['divId'] = empty($field['divId']) ? '' : $field['divId'];

			echo '<div class="' . self::value($field['divClass']) . '" ' . self::htmlIdDecorator($field['divId']) . '>';
		} else {
			echo '</div>';
		}

		self::drawJs($field);

		return;
	}

	private static function drawInput($id, $field, $class, $inputName)
	{
		$field['placeholder'] = empty($field['placeholder']) ? '' : $field['placeholder'];
		echo '<input id="' . $id . '" ' . self::value($field['placeholder']) . ' type="input" class="brid-input brid-input-' . $field['type'] . ' ' . $class . '" name="' . $inputName . '" />';
	}

	private static function drawTextInput($id, $field, $class, $inputName)
	{
		$field['placeholder'] = empty($field['placeholder']) ? '' : $field['placeholder'];
		echo '<textarea id="' . $id . '" ' . self::value($field['placeholder']) . ' class="brid-input brid-input-' . $field['type'] . ' ' . $class . '" name="' . $inputName . '" rows="4" cols="150" style="height: 80px"></textarea>';
	}

	private static function drawHidden($id, $field, $class, $inputName)
	{
		echo '<input id="' . $id . '" type="hidden" class="brid-input brid-input-' . $field['type'] . ' ' . $class . '" name="' . $inputName . '" />';
	}

	private static function drawRadio($id, $field, $class, $inputName)
	{
		$options = isset($field['options']) ? $field['options'] : [0 => 'No', 1 => 'Yes'];
		$newline = isset($field['newline']) ? '<br/>' : '';
		foreach ($options as $k => $v) {
			echo '<input class="brid-input brid-input-radio ' . $class . ' ' . $class . $k . '" id="' . $id . $k . '" type="radio" name="' . $inputName . '" value="' . $k . '"> ' . $v . ' &nbsp;' . $newline;
		}
	}

	private static function drawSelect($id, $field, $class, $inputName, $multiple)
	{
		echo '<select id="' . $id . '" ' . $multiple . ' class="brid-input brid-input-' . $field['type'] . ' ' . $class . '" name="' . $inputName . '">';
		foreach ($field['options'] as $k => $v) {
			echo '<option value="' . $k . '">' . $v . '</option>';
		}
		echo '</select>';
	}

	private static function drawDatetime($id, $field, $class, $inputName)
	{
		echo '<input name="publish" readonly="readonly" value="' . date('d-m-Y') . '" class="datepicker inputField" data-info="Publish on a date." type="text" id="' . $id . '">';
	}

	private static function drawUpload($id, $field, $class, $inputName)
	{
		echo $field['html'];
	}

	private static function drawCheckbox($id, $field, $class, $inputName)
	{
		$name = $field['name'];
		$checkbox = <<<HEREDOC
<div class="bridCheckboxTwo">
	<input type="checkbox" name="$name" id="$id" value="None">
	<label for="bridCheckboxTwo" onclick="(function(){jQuery('#$id').attr('checked', !jQuery('#$id').is(':checked'))}())"></label>
</div>
HEREDOC;
		echo $checkbox;
	}

	private static function drawCustom($field)
	{
		echo $field['html'];
	}
} ?>