<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

// Check for a form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require_once('scripts/stripe/stripe-config.php'); // this loads secret key to authenticate and associate Twiz account with Stripe and charge the card
	$token  	= $_POST['stripeToken'];
	$email 		= $_POST['stripeEmail'];
	
	if(isset($_POST['customer_id'])){ // if this is set, then the customer already exists...
		try {
			$charge = Stripe_Charge::create(array(
				'amount'   => 250,
				'currency' => 'usd',
				'customer' => $_POST['customer_id'],
				'description' => "Single Sheet purchase"
			));
		} catch (Stripe_CardError $e) {
				// Card was declined.
				$e_json = $e->getJsonBody();
				$err = $e_json['error'];
				$errors['stripe'] = $err['message'];
			} catch (Stripe_ApiConnectionError $e) {
				// Network problem, perhaps try again.
			} catch (Stripe_InvalidRequestError $e) {
				// You screwed up in your programming. Shouldn't happen!
			} catch (Stripe_ApiError $e) {
				// Stripe's servers are down!
			} catch (Stripe_CardError $e) {
				// Something else that's not the customer's fault.
			}
	} else {
		try {
			// create customer
			$customer = Stripe_Customer::create(array(
				'email' => $email,
				'card'  => $token
			));
			// charge the customer
			$charge = Stripe_Charge::create(array(
				'customer' => $customer->id,
				'amount'   => 250,
				'currency' => 'usd',
				'description' => 'Single Sheet Purchase'
			));
		} catch (Stripe_CardError $e) {
				// Card was declined.
				$e_json = $e->getJsonBody();
				$err = $e_json['error'];
				$errors['stripe'] = $err['message'];
			} catch (Stripe_ApiConnectionError $e) {
				// Network problem, perhaps try again.
			} catch (Stripe_InvalidRequestError $e) {
				// You screwed up in your programming. Shouldn't happen!
			} catch (Stripe_ApiError $e) {
				// Stripe's servers are down!
			} catch (Stripe_CardError $e) {
				// Something else that's not the customer's fault.
			}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Thoroughwiz | User Purchase Credit</title>
<!-- Meta Data -->
<?php include("meta.php"); ?>
<!-- CSS Import -->
<?php include("style_block.php"); ?>
<!-- CSS page specific -->
<link rel="stylesheet" href="assets/plugins/sky-forms/version-2.0.1/css/custom-sky-forms.css">
</head>
<body>
<div class="wrapper">
  <?php include("header.php"); ?>
  <!--=== Breadcrumbs ===-->
  <div class="breadcrumbs">
    <div class="container">
      <h1 class="pull-left">1 Credit Purchase</h1>
      <ul class="pull-right breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li class="active">1 Credit Purchase</li>
      </ul>
    </div>
  </div>
  <!--/breadcrumbs-->
  <!--=== End Breadcrumbs ===-->
  <!--=== Content Part ===-->
  <div class="container content">
  
	<?php include("assets/snippets/left-nav.php"); ?>

    <div class="row">
        <?php
            // Check that it was paid by accessing the charge object:
			if ($charge->paid == true) {
				$isStripeCustomer = fetchStripeId($loggedInUser->user_id); //get stripe id for this user if it exists
				foreach ($isStripeCustomer as $stripeid){
					if($stripeid['stripeid'] === '0'){ // if it equals 0 user is not a stripe customer yet
							// update member record with stripe customer id
							createCustomer($loggedInUser->user_id, $customer->id);
					}
				} 				
				// add user to quickie role unless it already exists
				if ($loggedInUser->checkPermission(array(4))){ // this is in class.user.php
					// return true;
				}else{
					addPermission(4, $loggedInUser->user_id);
				}
				// add one credit to this users credit tally, to be used at their discretion
					addCredit(1, $loggedInUser->user_id);
				// echo transaction details out to the user.  Prompt to email receipt if user desires
				$timestamp = date("Y-m-d", $charge->created);
				$amount = $charge->amount / 100;
				echo '
    				<div class="col-md-12">
        			<div class="panel panel-default" >
            		<div class="panel-heading">Purchase Details</div>
                	<div class="panel-body">
					<div class="headline">
						  <div class="col-md-7" style="margin-bottom:20px;">
							  <div style="margin-bottom:30px;">
							      <img style="float:left;" src="img/tick_48.png" class="img-responsive" alt="tick mark" />
								  <h4 style="color:#74c52c;position:relative;left:30px;">Receipt for your single credit purchase</h4>
							  </div>
							  <p>Hello '.$loggedInUser->email.',<br>
							  We have received your single credit purchase payment of $'.$amount.'0.  A single credit has been added to your account to be used at your discretion.</p>
							  <p>An email receipt has been sent to '.$loggedInUser->email.'.</p>
							  <p>Your transaction details are shown below.</p>
							  <p><strong>Transaction Summary</strong></p>
							  <hr style="border-color:#666;margin:5px 0px;">
							  <p>Transaction #:&nbsp;&nbsp;'.$charge->receipt_number.'<br>
							  Order Total:&nbsp;&nbsp;$'.$amount.'0&nbsp;USD<br>
							  Card:&nbsp;****&nbsp;'.$charge->source->last4.'<br>
							  Date:&nbsp;&nbsp;'.$timestamp.'<br>
							  Delivery: Electronic</p>
							  <p>Should you have any questions, please do not hesitate to contact us.</p>
							  <p>Sincerely,<br>
							  The Throughwiz Team</p>
						</div>
						
						<div class="col-md-4 col-md-offset-1">
						<img style="float:left;" src="img/statistics_32.png" class="img-responsive" alt="statistics icon" />	  						<h5 style="position:relative;left:20px;"><a href="single-access.php">Run your sheet</a></h5>
						<div style="clear:both;"></div>
					<p>If you do not want to run your sheet at this time, a credit has been added to your account.  You can use this credit at your discretion.  Credit tallies are available on your home page.</p>
							  
						</div>
						<div class="col-md-12">	  
							  <div style="text-align:center;margin:30px 0px;">
								  <p><strong>Thank you very much for choosing our service!</strong></p>
								  <p style="color:#74c52c">https://www.twizfigs.com/deny-password.php</p>
							  </div>
						</div>
				  </div>
				  </div>
				  </div>
				  </div>';
			} else { // Charge was not paid!	
				echo '<h2 class="text-center" style="color:#303030;">Payment System Error!</h2>
				<div class="text-center">
					<div style="color:#959595;font-size:16px;" class="col-md-8 col-md-offset-2">Your payment could NOT be processed (i.e., you have not been charged) because the payment system rejected the transaction. You can try again or use another card.</div>
				</div>';
				if (isset($errors) && !empty($errors) && is_array($errors)) {
					echo '<div class="col-md-8 col-md-offset-2 text-center" style="border:1px solid red;"><h3 class="text-center" style="color:#303030;">Error Log:</h2><ul>';
					foreach ($errors as $e) {
						echo "<li>$e</li>";
					}
					echo '</ul></div>';	
				}
			}
			?>
    </div>
    <!--/row-->
  </div>
  <!--/container-->
  <!--=== End Content Part ===-->
  <?php include("footer.php"); ?>
    <?php include("modals.php"); ?>
</div><!--/wrapper-->
</body>
</html>

<!---
<pre>
    <? /*php
        print_r($charge);
    */ ?>
</pre>
<? /*php die(); */?>
-->
