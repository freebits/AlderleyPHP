<?php
define('STRIPE_SECRET_KEY', "key-7a9bb86b317120698eecae4cf3e52143");

function create_customer()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, STRIPE_SECRET_KEY.':');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers');
    $json_result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($json_result);
    return $result["id"];
}

function subscribe_customer($customer_id, $prices)
{
}

function get_cards($customer_id)
{
}

function get_subscriptions($customer_id)
{
}

?>
