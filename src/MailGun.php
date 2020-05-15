<?php
declare(strict_types=1);
namespace AlderleyPHP;

class MailGun
{
    public static function sendMail($key, $to, $from, $subject, $text)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, 'api:'.$key);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v2/mail.coolteam.com.au/messages');
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'to' => $to,
            'from' => $from,
            'subject' => $subject,
            'text' => $text));
        curl_exec($ch);
        curl_close($ch);
        return;
    }
}
