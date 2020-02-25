<?php
function contact_mail($mail_to, $mail_from, $subject, $fields) {
	$body = '';
	foreach ($fields as $field) {
		$body .= $field[0].$field[1].PHP_EOL;
	}
	$headers = 'From: '.$mail_from;
	mail($mail_to, $subject, $body, $headers);
}
?>
