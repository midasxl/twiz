<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

// Check for a form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require_once('scripts/stripe/stripe-config.php'); // this loads secret key to authenticate and associate Twiz account with Stripe
	$customerId  	= $_POST['customer_id'];
	$planId 		= $_POST['plan_id'];
	$customer 		= Stripe_Customer::retrieve($_POST['customer_id']);
	$subscription   = $customer->subscriptions->retrieve($_POST['plan_id']); // dig into the customer object and grab the subscription id
	$subscription->cancel(); // and cancel the subscription
	//$customer->subscriptions->retrieve($_POST['plan_id'])->cancel(array('at_period_end' => true)); // This will keep the subscription active until the end of the current billing cycle
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Thoroughwiz | User Cancel Subscription</title>
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
      <h1 class="pull-left">Cancel Subscription</h1>
      <ul class="pull-right breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li class="active">Cancel Subscription</li>
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
    
            // Check that it was cancelled by checking the subscription object:
			if ($subscription->status == "canceled") {
				// reset subscription id to 0 on this customers record
				addPlanId($loggedInUser->user_id, 0);
				if ($loggedInUser->checkPermission(array(3))){ // this is in class.user.php
					removePermission(3, $loggedInUser->user_id);
				}
				// add base member role
				addPermission(2, $loggedInUser->user_id);
				// must check if user has any credits from when they were a base member.  If so, give them the quickie role here as well.
				// For now we can just add it.  If user visits the sheet access page and there are no credits it will remove the perm.
				addPermission(4, $loggedInUser->user_id);
				// change role title
				updateTitle($loggedInUser->user_id, "Base Member");
				echo '
    				<div class="col-md-12">
        			<div class="panel panel-default" >
            		<div class="panel-heading">Subscription Cancellation Details</div>
                	<div class="panel-body">
					<div class="headline">
					<h2>We are sorry to see you go!</h2><br><br>
						<p>Here are your cancellation details:</p><br>';
					echo 'Status of your subscription: '.$subscription->status;
					echo '</div>
						</div>
						</div>
						</div>';
						
			} else { // Charge was not paid!	
				echo '<h2 class="text-center" style="color:#303030;">Stripe System Error!</h2>
				<div class="text-center">
					<div style="color:#959595;font-size:16px;" class="col-md-8 col-md-offset-2">Your cancellation could NOT be processed (i.e., your subscription is still active) because the system rejected the request. You can try again in a little while.</div>
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
  <?php include("modals.php"); ?>
  <?php include("footer.php"); ?>
</div><!--/wrapper-->

</body>
</html>

<!--
$customer = Stripe_Customer::retrieve($_POST['customer_id']);

In the above assignment, $customer will represent:

Stripe\Customer JSON: {
  "id": "cus_85ySZjTM5bv1Xa",
  "object": "customer",
  "account_balance": 0,
  "created": 1458164918,
  "currency": "usd",
  "default_source": "card_17pmVKGZRBZULFGkzOMsLibg",
  "delinquent": false,
  "description": "Plan Change",
  "discount": null,
  "email": "docstyles69@gmail.com",
  "livemode": false,
  "metadata": {
  },
  "shipping": null,
  "sources": {
    "object": "list",
    "data": [
      {
        "id": "card_17pmVKGZRBZULFGkzOMsLibg",
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
        "customer": "cus_85ySZjTM5bv1Xa",
        "cvc_check": "pass",
        "dynamic_last4": null,
        "exp_month": 4,
        "exp_year": 2016,
        "funding": "credit",
        "last4": "4242",
        "metadata": {
        },
        "name": "docstyles69@gmail.com",
        "tokenization_method": null
      }
    ],
    "has_more": false,
    "total_count": 1,
    "url": "/v1/customers/cus_85ySZjTM5bv1Xa/sources"
  },
  "subscriptions": {
    "object": "list",
    "data": [
		"status": "canceled"
    ],
    "has_more": false,
    "total_count": 0,
    "url": "/v1/customers/cus_85ySZjTM5bv1Xa/subscriptions"
  }
}

So, 

$customer->object = customer
$customer->subscriptions->object = list
$customer->subscriptions->data[0]->status = canceled

		<pre>
		<?php /*
		echo 'Type of object returned: '.$subscription->status;
		var_dump($subscription);		
		?>
		</pre>
		<?php die();  */?>

-->