<?php
require_once('utils/user-utils.php');
require_once('vendor/autoload.php');
\Stripe\Stripe::setApiKey("sk_test_00reSatqkvoV5Tvn0DiIDinZ00x50gQ1RX");
if(isset($_POST['amount'])){
   // Token is created using Checkout or Elements!
// Get the payment token ID submitted by the form:
    $token = $_POST['stripeToken'];
    $amount= $_POST['amount'];
    try{
        $charge = \Stripe\Charge::create([
            'amount' => $amount,
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
    OutputUtils::set_page_mode('donated');
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Stripe</title>
    <meta charset="utf-8">
    <script src="jquery-3.3.1.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>
    <script src="http://js.stripe.com/v3/"></script>
</head>

<style>
    .nav-bar{
        border: 2px solid black;
        background: blueviolet;
        color: white;
    }
    .StripeElement {
        box-sizing: border-box;

        height: 40px;
        width: 600px;
        padding: 10px 12px;

        border: 1px solid transparent;
        border-radius: 4px;
        background-color: white;

        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }

    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .StripeElement--invalid {
        border-color: #fa755a;
    }
    form{
        margin-left: 40%;
    }
    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;

    }
</style>
<body>
    <nav class="nav-bar text-center">
        <h1 class="title">Timeline</h1>
        <div class="user-function">
            <?php
            $user_info=SessionUtils::check_user_login_status();
            if($user_info){
                echo '<h3 style="text-align: center;">Welcome '.$user_info['display_name'].'</h3>&nbsp&nbsp';
                echo '<a id="logout" class="btn btn-default like" href="logout.php">Logout</a>';
            }else{
                echo '<h3 style="text-align: center;">Welcome</h3>';
            }?>
        </div>
    </nav>
    <?php if(OutputUtils::get_page_mode()=='donated'){
        echo '<h4 style="color:green;text-align: center;">Thank you for your Donation <a href="index.php"> click here to open timeline</a> </h4>';
    }
    else{?>
    <div >
        <h3 class="text-center">Make a Donation $$</h3>
        <form action="#" method="post" id="payment-form">
            <div class="form-row">
             <table>
                <tr>
                    <label>Amount (in USD) :</label>
                    <input type="number" min="0" id="amount" name="amount" required>
                </tr>
                <tr><br>
                <label for="card-element">
                    Credit or debit card:
                </label>
                <div id="card-element">
                    <!-- A Stripe Element will be inserted here. -->
                </div>
                </tr>
                <!-- Used to display Element errors. -->
                <div id="card-errors" role="alert"></div>
             </table>
            </div>
            <br>
            <button class="btn btn-default btn-success" type="submit">Submit Payment</button>
        </form>
    </div>
    <?php } ?>
    <script>
        var amount=0;
        $(function() {
            $("#amount").change(function () {
               amount=$("#amount").val();
                if(amount<=0){
                    alert('Amount should be greater than Zero!!');
                    $('button').attr('disabled',true);
                }
                else{
                    $('button').attr('disabled',false);
                }
            });
        });
        var stripe = Stripe('pk_test_oVqEzgaPgrDBrCaekDDINTwS00MW8uDPxu');
        var elements = stripe.elements();

        var style = {
            base: {
                // Add your base input styles here. For example:
                fontSize: '16px',
                color: "#32325d",
            }
        };

        // Create an instance of the card Element.
        var card = elements.create('card', {style: style});

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');
        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    // Inform the customer that there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            hiddenInput.setAttribute('amount','10.00');
            form.appendChild(hiddenInput);
            console.log(token.id);
            console.log(form);
            // Submit the form
            form.submit();
        }
    </script>
</body>