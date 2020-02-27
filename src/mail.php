<?php
function contact_mail($mail_to, $mail_from, $subject, $fields)
{
    $body = '';
    foreach ($fields as $field) {
        list($label, $value) = $field;
        $body .= $label.': '.$value.PHP_EOL;
    }
    $headers = 'From: '.$mail_from;
    mail($mail_to, $subject, $body, $headers);
}
