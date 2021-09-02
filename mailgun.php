<?php
define('MAILGUN_SECRET_KEY', "key-7a9bb86b317120698eecae4cf3e52143");

function contact_mail($name, $phone, $email, $postcode, $message) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, 'api:'.MAILGUN_SECRET_KEY);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $plain = strip_tags(nl2br($message));

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v2/mail.coolteam.com.au/messages');

    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
        'from' => 'noreply@mail.coolteam.com.au',
        'to' => 'onlinemedia02@gmail.com',
        'subject' => 'CONTACT: '. $name,
        'text' => 'Name: '. $name.PHP_EOL.
				  'Phone: '. $phone.PHP_EOL.
				  'Email: '. $email.PHP_EOL.
				  'Postcode: '. $postcode.PHP_EOL.
                  'Message: '. $plain));
    
    $json_result = curl_exec($ch);
    file_put_contents('mail_log.txt', date('Y-m-d H:i:s').$json_result.PHP_EOL, FILE_APPEND);
    curl_close($ch);
}
?>
