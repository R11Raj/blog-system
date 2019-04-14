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
var_dump($_POST['amount']);
try{
    $charge = \Stripe\Charge::create([
        'amount' => 100,
        'currency' => 'usd',
        'description' => 'Example charge',
        'source' => $token,
    ]);
}catch(Stripe_CardError $e) {
    $error1 = $e->getMessage();
} catch (Stripe_InvalidRequestError $e) {
    // Invalid parameters were supplied to Stripe's API
    $error2 = $e->getMessage();
} catch (Stripe_AuthenticationError $e) {
    // Authentication with Stripe's API failed
    $error3 = $e->getMessage();
} catch (Stripe_ApiConnectionError $e) {
    // Network communication with Stripe failed
    $error4 = $e->getMessage();
} catch (Stripe_Error $e) {
    // Display a very generic error to the user, and maybe send
    // yourself an email
    $error5 = $e->getMessage();
} catch (Exception $e) {
    // Something else happened, completely unrelated to Stripe
    $error6 = $e->getMessage();
}
echo '<h4 style="color:green;text-align: center;">Thank you for your Donation <a href="index.php"> click here to open timeline</a> </h4>';
?>