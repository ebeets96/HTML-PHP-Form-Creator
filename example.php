<?php
	ini_set('display_errors',1);
	spl_autoload_register(function ($class) {
		require_once 'includes/' . $class . '.class.php';
	});
		
	// Make an example form
	$form = new Form("Example Form");
	
	// Create a required First Name Field
	$nameField = new TextField("name","Name:");
	$nameField->setRequired();
	$nameField->setHint("(This is a hint)");
	$nameField->addAttr("maxlength",35);
	
	// Create a required Text Field that checks for valid phone number
	$phoneField = new TextField("phone","Phone Number:");
	$phoneField->setRequired();
	$phoneField->phoneFormat();
	
	// Create a required Text Field that checks for valid email address
	$emailField = new TextField("email","Email:");
	$emailField->setRequired();
	$emailField->emailFormat();
	
	// Create a required Text Field that checks for valid email address
	$passwordField = new Password("password","Password:");
	$passwordField->setRequired();
	
	// Create an array of all countries
	$countryLabels = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
	
	// Create a dropdown that contains all countries
	$countries = new Dropdown("country","Country:");
	$countries->setRequired();
	foreach($countryLabels as $label){
		$countries->addOption($label, preg_replace('/\s+/', '', $label));	
	}
	
	// Create a section of radio buttons
	$source = new Radio("source","How did you hear about us?");
	$source->setRequired();
	$source->addOption("Google");
	$source->addOption("Yahoo");
	$source->addOption("Friend");
	$source->addOption("Newsletter");
	$source->addOption("Other");
	
	// Create an HTML snippet in the middle of the form
	// we will also use the Alert class which returns the HTML
	// of a Bootstrap alert
	$htmlAlert = new HTML(new Alert("This is an example alert box"));
	
	// Upload attatchments
	$attachment = new File("file","Photo:");
	$attachments = new MultipleFiles("file","Attachments:");
	
	// Text Area
	$message = new TextArea("message","Message: ");
	$message->setRequired();
	
	// ReCaptcha field
	$recaptcha = new Captcha("sitekey","secret");
	
	// Add all form items
	$form->addFormItems(
		$nameField,
		$passwordField,
		$phoneField,
		$emailField,
		$countries,
		$source,
		$htmlAlert,
		$attachment,
		$attachments,
		$message,
		$recaptcha,
		new Submit()
	);
	
	if($form->process()){
		// Here the programmer can do their post submit processing
		// and assume that everything has been validated correctly
		// each field can be accessed by the getValue() function:
		$form->setSuccess("Thank you " . $nameField->getValue() . " for submitting this form.  Absolutely nothing is going to happen, but with a little bit more programming, it could!");
	}
		
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Form Classes Example</title>
<link href="bootstrap/bootstrap.min.css" rel="stylesheet" />
<link href="style.css" rel="stylesheet" />
</head>
<body>
	<div class="container">
		<div class="jumbotron">
        <h1>PHP Form Classes Example</h1>
        <p>This page is an example implementation of the PHP form classes written by Eric Beets.</p>
      </div>
		<h1>Example Form</h1>
		<?php
			echo $form->getFormHTML();
		?>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
<script src="js/bootstrap.min.js"></script>
</body>
</html>