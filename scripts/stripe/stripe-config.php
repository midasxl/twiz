<?php
require_once('lib/Stripe.php'); // Stripe’s PHP library, which will need to be unpacked and available relative to this configuration file.

// test keys
/*$stripe = array(
  "secret_key"      => "sk_test_DtYyClqspTnXEcG9rnBFE1fl", // authenticates and associates Twiz account with Stripe to charge cards
  "publishable_key" => "pk_test_XScqRDVsicCOY62auqLKMKEI" // identifies twiz website when communicating with Stripe
);*/

// live keys
$stripe = array(
		"secret_key"      => "sk_live_l94BrTtKnX8PZ3FlY2mAPhFv", // authenticates and associates Twiz account with Stripe to charge cards
		"publishable_key" => "pk_live_Sw0cBqGIOmM7jojuBqJfvSSj" // identifies twiz website when communicating with Stripe
);

Stripe::setApiKey($stripe['secret_key']); // require for charge page
?>