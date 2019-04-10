<?php
/**
 * Created by PhpStorm.
 * User: Raj
 * Date: 10-04-2019
 * Time: 17:53
 */
require_once('vendor/autoload.php');
\Stripe\Stripe::setApiKey("sk_test_00reSatqkvoV5Tvn0DiIDinZ00x50gQ1RX");

// Token is created using Checkout or Elements!
// Get the payment token ID submitted by the form:
$token = $_POST['stripeToken'];

$charge = \Stripe\Charge::create([
    'amount' => 999,
    'currency' => 'usd',
    'description' => 'Example charge',
    'source' => $token,
]);
?>