<?php
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	spl_autoload_register(function ($class) {
		require_once 'includes/' . $class . '.class.php';
	});
		
	//Make an example form
	$form = new Form("Example Form");
	
	$firstNameField = new TextField("firstName","First Name:");
	$firstNameField->setRequired();
	$firstNameField->setHint("(This is a hint)");
	$firstNameField->addAttr("maxlength",35);
	
	$lastNameField = new TextField("lastName","Last Name:");
	$lastNameField->setRequired();
	$lastNameField->addAttr("maxlength",35);
	
	$phoneField = new TextField("phone","Phone Number:");
	$phoneField->setRequired();
	$phoneField->phoneFormat();
	$phoneField->addAttr("maxlength",35);
	
	
	
	$form->addFormItem($firstNameField); 
		
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
		<h1>Test</h1>
		<?php
			echo $form->getFormHTML();
		?>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
<script src="js/bootstrap.min.js"></script>
</body>
</html>