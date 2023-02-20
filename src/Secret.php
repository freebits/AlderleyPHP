<?php
namespace Secret;
class Secret
{

    protected array $configuration;

    function __construct(string $configuration)
    {
        $this->configuration = parse_ini_file($configuration);
    }

    public function get_database(): PDO
    {
        $connection = null;
        try {
            $connection = new PDO($this->configuration["DATABASE_CONNECTION_STRING"]);
        } catch (PDOException $e) {
            error_log($e);
        }
        return $connection;
    }

    public function mail_gun_send(string $to, string $from, string $subject, string $message): void
    {
        $ch = curl_init();
        if($ch === false)
        {
            error_log("Could not initialize curl");
        }

        $mailgun_secret_key = $this->configuration['MAILGUN_SECRET_KEY'];
        $mailgun_domain = $this->configuration['MAILGUN_DOMAIN'];

        if(!curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC))
        {
            error_log(curl_error($ch));
        }

        if(!curl_setopt($ch, CURLOPT_USERPWD, 'api:' . $mailgun_secret_key))
        {
            error_log(curl_error($ch));
        }

        if(!curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1))
        {
            error_log(curl_error($ch));
        }

        $plain = strip_tags(nl2br($message));

        if(!curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'))
        {
            error_log(curl_error($ch));
        }

        $mailgun_url = 'https://api.mailgun.net/v2/' . $mailgun_domain . '/messages';
        if(!curl_setopt($ch, CURLOPT_URL, $mailgun_url))
        {
            error_log(curl_error($ch));
        }

        $curl_post_fields = array(
            'from' => $from,
            'to' => $to,
            'subject' => $subject,
            'text' => $plain);

        if(!curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_post_fields))
        {
            error_log(curl_error($ch));
        }

        curl_exec($ch);
        curl_close($ch);
    }
}
