<?php
require_once('configuration.php');

function contact_mail($name, $phone, $email, $postcode, $message) {
	$configuration = get_configuration();
	$to = configuration['EMAIL_TO'];
	$subject = 'Contact from: '. $name;
	$body =
	  'Domain Name: '.$configuration['DOMAIN_NAME'].PHP_EOL.
		'Name: '.$name.PHP_EOL.
		'Phone: '.$phone.PHP_EOL.
		'Email: '.$email.PHP_EOL.
		'Postcode: '.$postcode.PHP_EOL.
		'Message: '.PHP_EOL.wordwrap($message, 80, '\n', FALSE).PHP_EOL;

	$headers = 'From: '.$configuration['MAIL_FROM']; 
	mail($to, $subject, $body, $headers);
}
?>
