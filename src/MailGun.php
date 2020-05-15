<?php
declare(strict_types=1);
namespace AlderleyPHP;

class MailGun
{
    public static function sendMail(
        string $mgKey,
        string $mgUrl,
        string $to,
        string $from,
        string $subject,
        string $text): void
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, 'api:'.$mgKey);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_URL, $mgUrl);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'to' => $to,
            'from' => $from,
            'subject' => $subject,
            'text' => $text));
        $json_result = curl_exec($ch);
        curl_close($ch);
        return;
    }
}
