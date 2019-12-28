<?php
function contact_mail($name, $phone, $email, $postcode, $message) {
	$to = 'freebits1@gmail.com';
	$subject = 'Contact from: '. $name;
	$body = 
		'Name: '. $name.PHP_EOL.
		'Phone: '. $phone.PHP_EOL.
		'Email: '. $email.PHP_EOL.
		'Postcode: '. $postcode.PHP_EOL.
		'Message: '.PHP_EOL.$message.PHP_EOL;

	$headers = 'From: noreply@test.com.au'; 
	mail($to, $subject, $body, $headers);
}
?>
