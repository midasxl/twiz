<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

// Check for a form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require_once('scripts/stripe/stripe-config.php'); // this loads secret key to authenticate and associate Twiz account with Stripe and charge the card
	try {
		if(isset($_POST['customer_id'])){ // if customer id is passed form previous page, then the user is a Stripe customer
				$customer = Stripe_Customer::retrieve($_POST['customer_id']);
				$customer -> description = "Plan Change";
				$customer -> updateSubscription(array('plan' => 'goldplan111'));
				$customer -> save();
		}else if (isset($_POST['stripeToken'])){
				$token  = $_POST['stripeToken'];
				$email = $_POST['stripeEmail'];
			  	// create customer and subscribe customer to monthly subscription
			  	$customer = Stripe_Customer::create(array(
				'source'  => $token,
				'plan' => 'goldplan111',
				'email' => $email
			  ));
		}
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Thoroughwiz | User Purchase Subscription</title>
<!-- Meta Data -->
<?php include("meta.php"); ?>
<!-- CSS Import -->
<?php include("style_block.php"); ?>
</head>
<body>
<div class="wrapper">
  <?php include("header.php"); ?>
  <!--=== Breadcrumbs ===-->
  <div class="breadcrumbs">
    <div class="container">
      <h1 class="pull-left">Subscription Purchase</h1>
      <ul class="pull-right breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li class="active">Subscription Purchase</li>
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
            // This is a customer object
			if ($customer->object == "customer") {
				$isStripeCustomer = fetchStripeId($loggedInUser->user_id); //get stripe id for this user if it exists
				foreach ($isStripeCustomer as $stripeid){
					if($stripeid['stripeid'] === '0'){ // if it equals 0 user is not a stripe customer yet
							// update member record with stripe customer id
							createCustomer($loggedInUser->user_id, $customer->id);
					}
				} 	
				// add subscription id to customer record
				addPlanId($loggedInUser->user_id, $customer->subscriptions->data[0]->id);
				if ($loggedInUser->checkPermission(array(4))){ // this is in class.user.php
					removePermission(4, $loggedInUser->user_id);
				}
				if ($loggedInUser->checkPermission(array(2))){ // this is in class.user.php
					removePermission(2, $loggedInUser->user_id);
				}
				// add subscription member role
				addPermission(3, $loggedInUser->user_id);
				// change role title
				updateTitle($loggedInUser->user_id, "Subscription Member");
				// collect object data
				$timestamp = date("Y-m-d", $customer->subscriptions->data[0]->plan->created);
				$amount = $customer->subscriptions->data[0]->plan->amount / 100;
				$transid = $customer->subscriptions->data[0]->id;
				$planid = $customer->subscriptions->data[0]->plan->id;
				$startdate = date("Y-m-d", $customer->subscriptions->data[0]->current_period_start);
				$enddate = date("Y-m-d", $customer->subscriptions->data[0]->current_period_end);
				
				echo '
    				<div class="col-md-12">
        			<div class="panel panel-default" >
            		<div class="panel-heading">Purchase Details</div>
                	<div class="panel-body">
					<div class="headline">
						  <div class="col-md-7" style="margin-bottom:20px;">
							  <div style="margin-bottom:30px;">
							      <img style="float:left;" src="img/tick_48.png" class="img-responsive" alt="tick mark" />
								  <h4 style="color:#74c52c;position:relative;left:30px;">Receipt for your subscription purchase</h4>
							  </div>
							  <p>Hello '.$loggedInUser->email.',<br>
							  Thank you for subscribing to our Gold Plan!  We have received your first monthly payment of $'.$amount.'.  You now have unlimited access to run your sheets.</p>
							  <p>An email receipt has been sent to '.$loggedInUser->email.'.</p>
							  <p>Your transaction details are shown below.</p>
							  <p><strong>Transaction Summary</strong></p>
							  <hr style="border-color:#666;margin:5px 0px;">
							  <p>Transaction #:&nbsp;&nbsp;'.$transid.'<br>
							  Order Total:&nbsp;&nbsp;$'.$amount.'&nbsp;USD<br>
							  Card:&nbsp;****&nbsp;'.$charge->source->last4.'<br>
							  Date:&nbsp;&nbsp;'.$timestamp.'<br>
							  Delivery: Electronic</p>
							  
							  <p><strong>Subscription Details</strong></p>
							  <hr style="border-color:#666;margin:5px 0px;">
							  <p>You subscription begins today.  We will charge you each month on the same day you were originally subscribed to the plan.</p> 
							  <p>Subscription Level:&nbsp;&nbsp;'.$transid.'<br>
							  Plan:&nbsp;&nbsp;'.$planid.'<br>
							  Start Date:&nbsp;'.$startdate.'<br>
							  Subscription Interval: Monthly</p>
							  
							  <p>Should you have any questions, please do not hesitate to contact us.</p>
							  <p>Sincerely,<br>
							  The Throughwiz Team</p>
						</div>
						
						<div class="col-md-4 col-md-offset-1">
						<img style="float:left;" src="img/statistics_32.png" class="img-responsive" alt="statistics icon" />	  						<h5 style="position:relative;left:20px;"><a href="access.php">Run your sheet</a></h5>
						<div style="clear:both;"></div>
					<p>If you do not want to run your sheet at this time, you can access our sheet processor at any time from your home page.</p>
							  
						</div>
						<div class="col-md-12">	  
							  <div style="text-align:center;margin:30px 0px;">
								  <p><strong>Thank you very much for choosing our service!</strong></p>
								  <p style="color:#74c52c">https://www.thoroughwiz.com</p>
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

<!--
Stripe\Customer JSON: {
  "id": "cus_8AmWB4lXfDQnyK",
  "object": "customer",
  "account_balance": 0,
  "created": 1459273745,
  "currency": "usd",
  "default_source": "card_17uQxcGZRBZULFGklIi7HCDL",
  "delinquent": false,
  "description": null,
  "discount": null,
  "email": "dwood@lcrhelp.com",
  "livemode": false,
  "metadata": {
  },
  "shipping": null,
  "sources": {
    "object": "list",
    "data": [
      {
        "id": "card_17uQxcGZRBZULFGklIi7HCDL",
        "object": "card",
        "address_city": null,
        "address_country": null,
        "address_line1": null,
        "address_line1_check": null,
        "address_line2": null,
        "address_state": null,
        "address_zip": null,
        "address_zip_check": null,
        "brand": "Visa",
        "country": "US",
        "customer": "cus_8AmWB4lXfDQnyK",
        "cvc_check": "pass",
        "dynamic_last4": null,
        "exp_month": 6,
        "exp_year": 2017,
        "funding": "credit",
        "last4": "4242",
        "metadata": {
        },
        "name": "dwood@lcrhelp.com",
        "tokenization_method": null
      }
    ],
    "has_more": false,
    "total_count": 1,
    "url": "/v1/customers/cus_8AmWB4lXfDQnyK/sources"
  },
  "subscriptions": {
    "object": "list",
    "data": [
      {
        "id": "sub_8AmWAlqeFBzKBM",
        "object": "subscription",
        "application_fee_percent": null,
        "cancel_at_period_end": false,
        "canceled_at": null,
        "current_period_end": 1461952145,
        "current_period_start": 1459273745,
        "customer": "cus_8AmWB4lXfDQnyK",
        "discount": null,
        "ended_at": null,
        "metadata": {
        },
        "plan": {
          "id": "goldplan111",
          "object": "plan",
          "amount": 8000,
          "created": 1459023951,
          "currency": "usd",
          "interval": "month",
          "interval_count": 1,
          "livemode": false,
          "metadata": {
          },
          "name": "Monthly Subscription",
          "statement_descriptor": "Twiz Subscription",
          "trial_period_days": null
        },
        "quantity": 1,
        "start": 1459273745,
        "status": "active",
        "tax_percent": null,
        "trial_end": null,
        "trial_start": null
      }
    ],
    "has_more": false,
    "total_count": 1,
    "url": "/v1/customers/cus_8AmWB4lXfDQnyK/subscriptions"
  }
}
-->