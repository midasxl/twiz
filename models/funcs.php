<?php
ob_start ();
/*
Think of ob_start() as saying 'Start remembering everything that would normally be outputted, but don't quite do anything with it yet.'

For example:

ob_start();
echo("Hello there!"); //would normally get printed to the screen/output to browser, but in this case it is stored for later output
$output = ob_get_contents(); // give me what has been saved to the buffer since it was turned on with ob_start();
ob_end_clean(); // stops saving things and discards whatever was saved, or stops saving and outputs it all at once, respectively
ob_flush();
*/

// --------------------------------------------------------------------------

//Functions that DO NOT interact with database

//Retrieve a list of all .php files in models/languages

function getLanguageFiles() // used in admin_configuration.php

{

	$directory = "models/languages/";

	$languages = glob($directory . "*.php");

	//print each file name

	return $languages;

}



//Retrieve a list of all .css files in models/site-templates 

function getTemplateFiles() // used in admin_configuration.php

{

	$directory = "models/site-templates/";

	$languages = glob($directory . "*.css");

	//print each file name

	return $languages;

}



//Retrieve a list of all .php files in root files folder

function getPageFiles() // used in admin_pages.php

{

	$directory = "";

	$pages = glob($directory . "*.php");

	//print each file name

	foreach ($pages as $page){

		$row[$page] = $page;

	}

	return $row;

}



//Destroys a session as part of logout

function destroySession($name) // used in class.user.php, also called from isUserLogggedIn function around 900

{

	if(isset($_SESSION[$name]))

	{

		$_SESSION[$name] = NULL;

		unset($_SESSION[$name]);

	}

}



//Generate a unique code

function getUniqueCode($length = "") // used in confirm-password.php

{	

	$code = md5(uniqid(rand(), true));

	if ($length != "") return substr($code, 0, $length);

	else return $code;

}



//Generate an activation key

function generateActivationToken($gen = null) // used in: class.newuser.php, user-resend-activation.php

{

	do

	{

		$gen = md5(uniqid(mt_rand(), false));

	}

	while(validateActivationToken($gen)); // this function is on line 1310, or close

	return $gen;

}



// generate a salted hash

function generateHash($plainText, $salt = null) // used in confirm-password.php, class.newuser.php, class.user.php, user-login.php, user-update-account.php

{

	if ($salt === null)

	{

		$salt = substr(md5(uniqid(rand(), true)), 0, 25);

	}

	else

	{

		$salt = substr($salt, 0, 25);

	}

	

	return $salt . sha1($salt . $plainText);

}



//Checks if an email is valid

function isValidEmail($email) // used in admin_configuration.php, contact-submit.php, user-forgot-password.php, user-register.php, user-resend-activation.php

{

	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

		return true;

	}

	else {

		return false;

	}

}



//Inputs language strings from selected language.

function lang($key,$markers = NULL) // this is everywhere
// key would be something like ACCOUNT_USER_OR_PASS_INVALID => Username or password is invalid
{ 

	global $lang;

	if($markers == NULL)

	{

		$str = $lang[$key]; // this would be something like "Permission level name changed to `%m1%`"

	}

	else // markers is not NULL

	{

		//Replace any dynamic markers

		$str = $lang[$key]; // this would be something like "Permission level name changed to `%m1%`"

		$iteration = 1;

		foreach($markers as $marker)

		{

			$str = str_replace("%m".$iteration."%",$marker,$str);

			$iteration++;

		}

	}

	//Ensure we have something to return

	if($str == "")

	{

		return ("No language key found");

	}

	else

	{

		return $str;

	}

}



//Checks if a string is within a min and max length

function minMaxRange($min, $max, $what) // used in admin_configuration.php, admin_permission.php, admin_permissions.php, user-register.php, user-update-account.php

{

	if(strlen(trim($what)) < $min)

		return true;

	else if(strlen(trim($what)) > $max)

		return true;

	else

	return false;

}



//Replaces hooks with specified text

function replaceDefaultHook($str) // used in class.mail.php

{

	global $default_hooks,$default_replace;	

	return (str_replace($default_hooks,$default_replace,$str));

}



function resultBlock($errors,$successes){ // used in assets/snippets/left-nav.php, register.php

	//Error block

	if(count($errors) > 0)

	{

		foreach($errors as $error)

		{

			echo "<script>alert('".$error."')</script>";

		}

	}

	//Success block

	if(count($successes) > 0)

	{

		foreach($successes as $success)

		{

			echo "<script>alert('".$success."')</script>";

		}

	}

}


//Completely sanitizes text

function sanitize($str) // used in class.newuser.php

{

	return strtolower(strip_tags(trim(($str))));

}

// ****************** Function that interact with the database ************************

//Functions that interact mainly with twiz_users table

//------------------------------------------------------------------------------



//Delete a defined array of users

function deleteUsers($users) { // used in admin_user.php

	global $mysqli,$db_table_prefix; 

	$i = 0;

	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."users 

		WHERE id = ?");

	$stmt2 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_permission_matches 

		WHERE user_id = ?");
		
	$stmt3 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_credits 

		WHERE user_id = ?");
	
	$stmt4 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_sheets
	
		WHERE user_id = ?");
	
	foreach($users as $id){

		$stmt->bind_param("i", $id);

		$stmt->execute();

		$stmt2->bind_param("i", $id);

		$stmt2->execute();
		
		$stmt3->bind_param("i", $id);

		$stmt3->execute();
		
		$stmt4->bind_param("i", $id);
		
		$stmt4->execute();

		$i++;

	}

	$stmt->close();

	$stmt2->close();
	
	$stmt3->close();
	
	$stmt4->close();

	return $i;

}



//Check if a display name exists in the DB

function displayNameExists($displayname) { // used in class.newuser.php

	global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("SELECT active

		FROM ".$db_table_prefix."users

		WHERE

		display_name = ?

		LIMIT 1");

	$stmt->bind_param("s", $displayname);	

	$stmt->execute();

	$stmt->store_result();

	$num_returns = $stmt->num_rows;

	$stmt->close();

	

	if ($num_returns > 0)

	{

		return true;

	}

	else

	{

		return false;	

	}

}



//Check if an email exists in the DB

function emailExists($email) { // used in class.newuser.php, user-forgot-password.php, user-login.php, user-resend-activation.php

	global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("SELECT active

		FROM ".$db_table_prefix."users

		WHERE

		email = ?

		LIMIT 1");

	$stmt->bind_param("s", $email);	

	$stmt->execute();

	$stmt->store_result();

	$num_returns = $stmt->num_rows;

	$stmt->close();

	

	if ($num_returns > 0)

	{

		return true;

	}

	else

	{

		return false;	

	}

}



//Check if a user name and email belong to the same user

function emailUsernameLinked($email,$username) { // used in user-forgot-password.php, user-resend-activation.php

	global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("SELECT active

		FROM ".$db_table_prefix."users

		WHERE user_name = ?

		AND

		email = ?

		LIMIT 1

		");

	$stmt->bind_param("ss", $username, $email);	

	$stmt->execute();

	$stmt->store_result();

	$num_returns = $stmt->num_rows;

	$stmt->close();

	

	if ($num_returns > 0)

	{

		return true;

	}

	else

	{

		return false;	

	}

}



//Retrieve information for all users

function fetchAllUsers() { // used in admin_permission.php, admin_users.php

	global $mysqli,$db_table_prefix; 

	$stmt = $mysqli->prepare("SELECT 

		id,

		password,

		email,

		activation_token,

		last_activation_request,

		lost_password_request,

		active,

		title,

		sign_up_stamp,

		last_sign_in_stamp

		FROM ".$db_table_prefix."users");

	$stmt->execute();

	$stmt->bind_result($id, $password, $email, $token, $activationRequest, $passwordRequest, $active, $title, $signUp, $signIn);

	

	while ($stmt->fetch()){

		$row[] = array('id' => $id, 'password' => $password, 'email' => $email, 'activation_token' => $token, 'last_activation_request' => $activationRequest, 'lost_password_request' => $passwordRequest, 'active' => $active, 'title' => $title, 'sign_up_stamp' => $signUp, 'last_sign_in_stamp' => $signIn);

	}

	$stmt->close();

	return ($row);

}


//Retrieve complete user information by username, token or ID

function fetchUserDetails($email=NULL,$token=NULL, $id=NULL) // used in many files
/* account.php, admin_user.php, confirm-password.php, deny-password.php, user-forgot-password.php, user-login.php, user-profile.php, user-resend-activation.php */

{

	if($email!=NULL) {

		$column = "email";

		$data = $email;

	}

	elseif($token!=NULL) {

		$column = "activation_token";

		$data = $token;

	}

	elseif($id!=NULL) {

		$column = "id";

		$data = $id;

	}

	global $mysqli,$db_table_prefix; 

	$stmt = $mysqli->prepare("SELECT 

		id,

		password,

		email,

		activation_token,

		last_activation_request,

		lost_password_request,

		active,

		title,

		sign_up_stamp,

		last_sign_in_stamp,
			
		stripe_id,
		
		plan_id,
		
		pass_change

		FROM ".$db_table_prefix."users

		WHERE

		$column = ?

		LIMIT 1");

		$stmt->bind_param("s", $data);

	

	$stmt->execute();

	$stmt->bind_result($id, $password, $email, $token, $activationRequest, $passwordRequest, $active, $title, $signUp, $signIn, $stripeId, $planId, $passChange);

	while ($stmt->fetch()){

		$row = array('id' => $id, 'password' => $password, 'email' => $email, 'activation_token' => $token, 'last_activation_request' => $activationRequest, 'lost_password_request' => $passwordRequest, 'active' => $active, 'title' => $title, 'sign_up_stamp' => $signUp, 'last_sign_in_stamp' => $signIn, 'stripe_id' => $stripeId, 'plan_id' => $planId, 'pass_change' => $passChange);

	}

	$stmt->close();

	return ($row);

}



//Toggle if lost password request flag on or off

function flagLostPasswordRequest($id,$value) { // confirm-password.php, deny-password.php, user-forgot-password.php

	global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users

		SET lost_password_request = ?

		WHERE

		id = ?

		LIMIT 1

		");

	$stmt->bind_param("ss", $value, $id);

	$result = $stmt->execute();

	$stmt->close();

	return $result;

}



function flagPasswordReset($id,$value) { // deny-password.php, user-forgot-password.php, user-update-account.php

	global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users

		SET pass_change = ?

		WHERE

		id = ?

		LIMIT 1

		");

	$stmt->bind_param("ss", $value, $id);

	$result = $stmt->execute();

	$stmt->close();

	return $result;

}



//Check if a user is logged in

function isUserLoggedIn() { // use in many files
/* account.php, activate-account.php, assets/snippets/left-nav.php, confirm-password.php, deny-password.php, forgot-password.php, login.php, logout.php, register.php, resend-activation.php */

	global $loggedInUser,$mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("SELECT 

		id,

		password

		FROM ".$db_table_prefix."users

		WHERE

		id = ?

		AND 

		password = ? 

		AND

		active = 1

		LIMIT 1");

	$stmt->bind_param("is", $loggedInUser->user_id, $loggedInUser->hash_pw);	

	$stmt->execute();

	$stmt->store_result();

	$num_returns = $stmt->num_rows;

	$stmt->close();

	

	if($loggedInUser == NULL)

	{

		return false;

	}

	else

	{

		if ($num_returns > 0)

		{

			return true;

		}

		else

		{

			destroySession("userCakeUser");

			return false;	

		}

	}

}



//Change a user's display name (I don't currently use this because we don't offer the user the option to create a display name)

/*function updateDisplayName($id, $display)

{

	global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users

		SET display_name = ?

		WHERE

		id = ?

		LIMIT 1");

	$stmt->bind_param("si", $display, $id);

	$result = $stmt->execute();

	$stmt->close();

	return $result;

}*/



//Update a user's email

function updateEmail($id, $email) // class.user.php

{

	global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users

		SET 

		email = ?

		WHERE

		id = ?");

	$stmt->bind_param("si", $email, $id);

	$result = $stmt->execute();

	$stmt->close();	

	return $result;

}



//Input new activation token, and update the time of the most recent activation request

function updateLastActivationRequest($new_activation_token,$email) // user-resend-activation.php

{

	global $mysqli,$db_table_prefix; 	

	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users

		SET activation_token = ?,

		last_activation_request = ?

		WHERE email = ?");

	$stmt->bind_param("sss", $new_activation_token, time(), $email);

	$result = $stmt->execute();

	$stmt->close();	

	return $result;

}



//Generate a random password, and new token

function updatePasswordFromToken($pass,$token) // confirm-password.php

{

	global $mysqli,$db_table_prefix;

	$new_activation_token = generateActivationToken();

	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users

		SET password = ?,

		activation_token = ?

		WHERE

		activation_token = ?");

	$stmt->bind_param("sss", $pass, $new_activation_token, $token);

	$result = $stmt->execute();

	$stmt->close();	

	return $result;

}



//Update a user's title when starting/stopping subscription

function updateTitle($id, $title) // user_cancel_subscription.php, user_charge_subscription.php

{

	global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users

		SET 

		title = ?

		WHERE

		id = ?");

	$stmt->bind_param("si", $title, $id);

	$result = $stmt->execute();

	$stmt->close();	

	return $result;	

}



//Add customer id to tie in with Stripe

function createCustomer($id, $stripeid) // user_charge.php, user_charge_package_10.php, user_charge_subscription.php

{

	global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users

		SET

		stripe_id = ?

		WHERE

		id = ?");

	$stmt->bind_param("si", $stripeid, $id);

	$result = $stmt->execute();

	$stmt->close();

	return $result;

}



//Add plan id to tie in with Stripe

function addPlanId($id, $planid) // user_cancel_subscription.php, user_charge_subscription.php

{

	global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users

		SET

		plan_id = ?

		WHERE

		id = ?");

	$stmt->bind_param("si", $planid, $id);

	$result = $stmt->execute();

	$stmt->close();

	return $result;

}



// see if the user has a stripe id

function fetchStripeId($id) // account.php, user_charge.php, user_charge_package_10.php, user_charge_subscription.php

{

	global $mysqli,$db_table_prefix; 

	$stmt = $mysqli->prepare("SELECT 

		stripe_id

		FROM ".$db_table_prefix."users
		
		WHERE
		
		id = ?");

	$stmt->bind_param("i", $id);
	
	$stmt->execute();

	$stmt->bind_result($stripeid);
	
	while ($stmt->fetch()){

		$row[] = array('stripeid' => $stripeid);

	}

	$stmt->close();
	
	return ($row);

}



// see if the user has a plan id

function fetchPlanId($id) // user-profile.php

{

	global $mysqli,$db_table_prefix; 

	$stmt = $mysqli->prepare("SELECT 

		plan_id

		FROM ".$db_table_prefix."users
		
		WHERE
		
		id = ?");

	$stmt->bind_param("i", $id);
	
	$stmt->execute();

	$stmt->bind_result($planid);
	
	while ($stmt->fetch()){

		$row[] = array('planid' => $planid);

	}

	$stmt->close();
	
	return ($row);

}



//Check if a user ID exists in the DB

function userIdExists($id) // admin_user.php

{

	global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("SELECT active

		FROM ".$db_table_prefix."users

		WHERE

		id = ?

		LIMIT 1");

	$stmt->bind_param("i", $id);	

	$stmt->execute();

	$stmt->store_result();

	$num_returns = $stmt->num_rows;

	$stmt->close();

	if ($num_returns > 0)

	{

		return true;

	}

	else

	{

		return false;	

	}

}



//Checks if a username exists in the DB

/*function usernameExists($username) // class.newuser.php

{

	global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("SELECT active

		FROM ".$db_table_prefix."users

		WHERE

		user_name = ?

		LIMIT 1");

	$stmt->bind_param("s", $username);	

	$stmt->execute();

	$stmt->store_result();

	$num_returns = $stmt->num_rows;

	$stmt->close();

	

	if ($num_returns > 0)

	{

		return true;

	}

	else

	{

		return false;	

	}

}*/



//Check if activation token exists in DB; if calling function passes TRUE as second parameter, then $lostpass will be true not null
// this is used by activate-account, confirm-password, deny-password
function validateActivationToken($token,$lostpass=NULL) // activate-account.php, confirm-password.php, deny-password.php

{

	global $mysqli,$db_table_prefix;

	if($lostpass == NULL) // this is not the case when the calling code passes TRUE as the second parameter. activate-account will use this section

	{	

		$stmt = $mysqli->prepare("SELECT active

			FROM ".$db_table_prefix."users

			WHERE active = 0

			AND

			activation_token = ?

			LIMIT 1");

	}

	else // confirm-password and deny-password change request will use this section

	{

		$stmt = $mysqli->prepare("SELECT active

			FROM ".$db_table_prefix."users

			WHERE active = 1

			AND

			activation_token = ?

			AND

			lost_password_request = 1 

			LIMIT 1");

	}

	$stmt->bind_param("s", $token);

	$stmt->execute();

	$stmt->store_result();

		$num_returns = $stmt->num_rows;

	$stmt->close();

	

	if ($num_returns > 0)

	{

		return true;

	}

	else

	{

		return false;	

	}

}


//Change a user from inactive to active after verifying their email via the account activation link

function setUserActive($token) // activate-account.php, admin_user.php
    
{
    global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users

		SET active = 1

		WHERE

		activation_token = ?

		LIMIT 1");

	$stmt->bind_param("s", $token);

	$result = $stmt->execute();

	$stmt->close();	

	return $result;
	
}

function setUserInActive($token) // admin_user.php
    
{
    global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users

		SET active = 0

		WHERE

		activation_token = ?

		LIMIT 1");

	$stmt->bind_param("s", $token);

	$result = $stmt->execute();

	$stmt->close();	

	return $result;
	
}



//If user exists and is active update to paid status - future feature

/*function validatePayStatus($token)

{

	global $mysqli,$db_table_prefix;

	$paystat = 1;

	{	

		$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users

			SET

			pay_status = ?

			WHERE

			activation_token = ?");

	}

	$stmt->bind_param("is", $paystat, $token);

	$stmt->execute();

	$stmt->store_result();

		$num_returns = $stmt->num_rows;

	$stmt->close();

	

	if ($num_returns > 0)

	{

		return true;

	}

	else

	{

		return false;	

	}

}*/



//------------------------------------------------------------------------------

//Functions that interact mainly with twiz_user_sheets table

//------------------------------------------------------------------------------



//Create sheet access

function createSheet($id, $sheet, $racetrack, $racedate) { // product.php, product_admin.php, product_admin_harness.php, promo-product.php, single-product.php

	global $mysqli,$db_table_prefix; 

	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."user_sheets (

		user_id,

		sheet,
		
		race_track,
		
		race_date

		)

		VALUES (

		?,

		?,
		
		?,
		
		?

		)");

	$stmt->bind_param("isss", $id, $sheet, $racetrack, $racedate);

	$result = $stmt->execute();

	$stmt->close();	

	return $result;

}



// delete sheet from uc_usersheets

function destroySheet($sheetid) { // user-delete-sheets.php

	global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_sheets

		WHERE id = ?");	

	$stmt->bind_param("i", $sheetid);

	$result = $stmt->execute();

	$stmt->close();
	
	return $result;

}


//Retrieve saved sheet information for current user

function fetchAllSheets($id) // account.php

{

	global $mysqli,$db_table_prefix; 

	$stmt = $mysqli->prepare("SELECT 

		id,

		user_id,
		
		sheet,
		
		race_track,
		
		race_date,
		
		time

		FROM ".$db_table_prefix."user_sheets
		
		WHERE
		
		user_id = ?");

	$stmt->bind_param("i", $id);
	
	$stmt->execute();

	$stmt->bind_result($id, $user, $sheet, $race_track, $race_date, $time);

	while ($stmt->fetch()){

		$row[] = array('id' => $id, 'user' => $user, 'sheet' => $sheet, 'racetrack' => $race_track, 'racedate' => $race_date, 'time' => $time);

	}

	$stmt->close();

	return ($row);

}




//------------------------------------------------------------------------------

//Functions that interact mainly with twiz_user_credits table

//------------------------------------------------------------------------------



//Add credit to user account

//If user credit row does not exist for this user create it first, then UPDATE it

function addCredit($credit, $id) { // user_charge.php, user_charge_package_10.php

	global $mysqli,$db_table_prefix; 

		$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."user_credits

			SET

			credits = credits + ?

			WHERE

			user_id = ?
			
			AND credits >= 0");

	$stmt->bind_param("ii", $credit, $id);

	$result = $stmt->execute();

	$stmt->close();	

	return $result;

}



// remove credit from user account

function removeCredit($credit, $id) { // promo-product.php, single-product.php

	global $mysqli,$db_table_prefix; 

		$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."user_credits

			SET

			credits = credits - ?

			WHERE

			user_id = ?
			
			AND credits > 0");

	$stmt->bind_param("ii", $credit, $id);

	$result = $stmt->execute();

	$stmt->close();	

	return $result;

}



//Retrieve saved credit information for current user

function fetchAllCredits($id) // account.php, admin_user.php, user-profile.php

{

	global $mysqli,$db_table_prefix; 

	$stmt = $mysqli->prepare("SELECT 

		credits

		FROM ".$db_table_prefix."user_credits
		
		WHERE
		
		user_id = ?");

	$stmt->bind_param("i", $id);
	
	$stmt->execute();

	$stmt->bind_result($credits);
	
	while ($stmt->fetch()){

		$row[] = array('credits' => $credits);

	}

	$stmt->close();
	
	return ($row);

}


//------------------------------------------------------------------------------

//Functions that interact mainly with twiz_permissions table

//------------------------------------------------------------------------------



//Create a permission level in DB

function createPermission($permission, $level, $descr) { // admin_permissions.php

	global $mysqli,$db_table_prefix; 

	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."permissions (

		name,
		
		access_level,
		
		description

		)

		VALUES (

		?,
		
		?,
		
		?

		)");

	$stmt->bind_param("sss", $permission, $level, $descr);

	$result = $stmt->execute();

	$stmt->close();	

	return $result;

}



//Delete a permission level from the DB

function deletePermission($permission) { // admin_permission.php

	global $mysqli,$db_table_prefix,$errors; 

	$i = 0;

	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permissions 

		WHERE id = ?");

	$stmt2 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_permission_matches 

		WHERE permission_id = ?");

	$stmt3 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permission_page_matches 

		WHERE permission_id = ?");

	foreach($permission as $id){

		if ($id == 1){

			$errors[] = lang("CANNOT_DELETE_NEWUSERS");

		}

		elseif ($id == 2){

			$errors[] = lang("CANNOT_DELETE_ADMIN");

		}

		else{

			$stmt->bind_param("i", $id);

			$stmt->execute();

			$stmt2->bind_param("i", $id);

			$stmt2->execute();

			$stmt3->bind_param("i", $id);

			$stmt3->execute();

			$i++;

		}

	}

	$stmt->close();

	$stmt2->close();

	$stmt3->close();

	return $i;

}

//Change a permission level's name

function updatePermissionGroup($id, $name, $level, $descr) // admin_permission.php

{

	global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."permissions

		SET name = ?, 
		
		access_level = ?, 
		
		description = ?

		WHERE

		id = ?

		LIMIT 1");

	$stmt->bind_param("sssi", $name, $level, $descr, $id);

	$result = $stmt->execute();

	$stmt->close();	

	return $result;	

}

//Retrieve information for all permission levels

function fetchAllPermissions() // admin_configuration.php, admin_page.php, admin_permissions.php, admin_user.php, user-profile.php

{

	global $mysqli,$db_table_prefix; 

	$stmt = $mysqli->prepare("SELECT 

		id,

		name, 
		
		access_level, 
		
		description

		FROM ".$db_table_prefix."permissions");

	$stmt->execute();

	$stmt->bind_result($id, $name, $access_level, $description);

	while ($stmt->fetch()){

		$row[] = array('id' => $id, 'name' => $name, 'access_level' => $access_level, 'description' => $description);

	}

	$stmt->close();

	return ($row);

}

//Retrieve information for a single permission level

function fetchPermissionDetails($id) // admin_permission.php

{

	global $mysqli,$db_table_prefix; 

	$stmt = $mysqli->prepare("SELECT 

		id,

		name,
		
		access_level,
		
		description

		FROM ".$db_table_prefix."permissions

		WHERE

		id = ?

		LIMIT 1");

	$stmt->bind_param("i", $id);

	$stmt->execute();

	$stmt->bind_result($id, $name, $access_level, $description);

	while ($stmt->fetch()){

		$row = array('id' => $id, 'name' => $name, 'access_level' => $access_level, 'description' => $description);

	}

	$stmt->close();

	return ($row);

}



//Check if a permission level ID exists in the DB

function permissionIdExists($id) // admin_permission.php

{

	global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("SELECT id

		FROM ".$db_table_prefix."permissions

		WHERE

		id = ?

		LIMIT 1");

	$stmt->bind_param("i", $id);	

	$stmt->execute();

	$stmt->store_result();

	$num_returns = $stmt->num_rows;

	$stmt->close();

	

	if ($num_returns > 0)

	{

		return true;

	}

	else

	{

		return false;	

	}

}



//Check if a permission level name exists in the DB

function permissionNameExists($permission) // admin_permissions.php

{

	global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("SELECT id

		FROM ".$db_table_prefix."permissions

		WHERE

		name = ?

		LIMIT 1");

	$stmt->bind_param("s", $permission);	

	$stmt->execute();

	$stmt->store_result();

	$num_returns = $stmt->num_rows;

	$stmt->close();

	

	if ($num_returns > 0)

	{

		return true;

	}

	else

	{

		return false;	

	}

}


//------------------------------------------------------------------------------

//Functions that interact mainly with twiz_user_permission_matches table

//------------------------------------------------------------------------------



//Match permission level(s) with user(s)

function addPermission($permission, $user) { // admin_page.php, admin_permission.php, admin_user.php, user_cancel_subscription.php, user_charge.php, user_charge_package_10.php, user_charge_subscription.php

	global $mysqli,$db_table_prefix; 

	$i = 0;

	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."user_permission_matches (

		permission_id,

		user_id

		)

		VALUES (

		?,

		?

		)");

	if (is_array($permission)){

		foreach($permission as $id){

			$stmt->bind_param("ii", $id, $user);

			$stmt->execute();

			$i++;

		}

	}

	elseif (is_array($user)){

		foreach($user as $id){

			$stmt->bind_param("ii", $permission, $id);

			$stmt->execute();

			$i++;

		}

	}

	else {

		$stmt->bind_param("ii", $permission, $user);

		$stmt->execute();

		$i++;

	}

	$stmt->close();

	return $i;

}

//Unmatch permission level(s) from user(s)

function removePermission($permission, $user) { // admin_page.php, admin_permission.php, admin_user.php, single-access.php, single-product.php, user_cancel_subscription.php, user_charge_subscription.php, 

	global $mysqli,$db_table_prefix; 

	$i = 0;

	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_permission_matches 

		WHERE permission_id = ?

		AND user_id =?");

	if (is_array($permission)){

		foreach($permission as $id){

			$stmt->bind_param("ii", $id, $user);

			$stmt->execute();

			$i++;

		}

	}

	elseif (is_array($user)){

		foreach($user as $id){

			$stmt->bind_param("ii", $permission, $id);

			$stmt->execute();

			$i++;

		}

	}

	else {

		$stmt->bind_param("ii", $permission, $user);

		$stmt->execute();

		$i++;

	}

	$stmt->close();

	return $i;

}

//Retrieve information for all user/permission level matches

/*function fetchAllMatches()

{

	global $mysqli,$db_table_prefix; 

	$stmt = $mysqli->prepare("SELECT 

		id,

		user_id,

		permission_id

		FROM ".$db_table_prefix."user_permission_matches");

	$stmt->execute();

	$stmt->bind_result($id, $user, $permission);

	while ($stmt->fetch()){

		$row[] = array('id' => $id, 'user_id' => $user, 'permission_id' => $permission);

	}

	$stmt->close();

	return ($row);	

}*/



//Retrieve list of permission levels a user has

function fetchUserPermissions($user_id)

{

	global $mysqli,$db_table_prefix; 

	$stmt = $mysqli->prepare("SELECT

		id,

		permission_id

		FROM ".$db_table_prefix."user_permission_matches

		WHERE user_id = ?

		");

	$stmt->bind_param("i", $user_id);	

	$stmt->execute();

	$stmt->bind_result($id, $permission);

	while ($stmt->fetch()){

		$row[$permission] = array('id' => $id, 'permission_id' => $permission);

	}

	$stmt->close();

	if (isset($row)){

		return ($row);

	}

}



//Retrieve list of users who have a permission level

function fetchPermissionUsers($permission_id) // admin_permission.php

{

	global $mysqli,$db_table_prefix; 

	$stmt = $mysqli->prepare("SELECT id, user_id

		FROM ".$db_table_prefix."user_permission_matches

		WHERE permission_id = ?

		");

	$stmt->bind_param("i", $permission_id);	

	$stmt->execute();

	$stmt->bind_result($id, $user);

	while ($stmt->fetch()){

		$row[$user] = array('id' => $id, 'user_id' => $user);

	}

	$stmt->close();

	if (isset($row)){

		return ($row);

	}

}


//------------------------------------------------------------------------------

//Functions that interact mainly with twiz_configuration table

//------------------------------------------------------------------------------



//Update configuration table

function updateConfig($id, $value) // admin_configuration.php

{

	global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."configuration

		SET 

		value = ?

		WHERE

		id = ?");

	foreach ($id as $cfg){

		$stmt->bind_param("si", $value[$cfg], $cfg);

		$stmt->execute();

	}

	$stmt->close();	

}


//------------------------------------------------------------------------------

//Functions that interact mainly with twiz_pages table

//------------------------------------------------------------------------------



//Add a page to the DB

function createPages($pages) { // admin_pages.php

	global $mysqli,$db_table_prefix; 

	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."pages (

		page

		)

		VALUES (

		?

		)");

	foreach($pages as $page){

		$stmt->bind_param("s", $page);

		$stmt->execute();

	}

	$stmt->close();

}



//Delete a page from the DB

function deletePages($pages) { // admin_pages.php

	global $mysqli,$db_table_prefix; 

	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."pages 

		WHERE id = ?");

	$stmt2 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permission_page_matches 

		WHERE page_id = ?");

	foreach($pages as $id){

		$stmt->bind_param("i", $id);

		$stmt->execute();

		$stmt2->bind_param("i", $id);

		$stmt2->execute();

	}

	$stmt->close();

	$stmt2->close();

}



//Fetch information on all pages

function fetchAllPages() // admin_pages.php, admin_permission.php

{

	global $mysqli,$db_table_prefix; 

	$stmt = $mysqli->prepare("SELECT 

		id,

		page,

		private

		FROM ".$db_table_prefix."pages");

	$stmt->execute();

	$stmt->bind_result($id, $page, $private);

	while ($stmt->fetch()){

		$row[$page] = array('id' => $id, 'page' => $page, 'private' => $private);

	}

	$stmt->close();

	if (isset($row)){

		return ($row);

	}

}



//Fetch information for a specific page

function fetchPageDetails($id) // admin_page.php

{

	global $mysqli,$db_table_prefix; 

	$stmt = $mysqli->prepare("SELECT 

		id,

		page,

		private

		FROM ".$db_table_prefix."pages

		WHERE

		id = ?

		LIMIT 1");

	$stmt->bind_param("i", $id);

	$stmt->execute();

	$stmt->bind_result($id, $page, $private);

	while ($stmt->fetch()){

		$row = array('id' => $id, 'page' => $page, 'private' => $private);

	}

	$stmt->close();

	return ($row);

}



//Check if a page ID exists

function pageIdExists($id) // admin_page.php

{

	global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("SELECT private

		FROM ".$db_table_prefix."pages

		WHERE

		id = ?

		LIMIT 1");

	$stmt->bind_param("i", $id);	

	$stmt->execute();

	$stmt->store_result();	

	$num_returns = $stmt->num_rows;

	$stmt->close();

	

	if ($num_returns > 0)

	{

		return true;

	}

	else

	{

		return false;	

	}

}



//Toggle private/public setting of a page

function updatePrivate($id, $private) // admin_page.php

{

	global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."pages

		SET 

		private = ?

		WHERE

		id = ?");

	$stmt->bind_param("ii", $private, $id);

	$result = $stmt->execute();

	$stmt->close();	

	return $result;	

}


//------------------------------------------------------------------------------

//Functions that interact mainly with twiz_permission_page_matches table

//------------------------------------------------------------------------------



//Match permission level(s) with page(s)

function addPage($page, $permission) { // add_page.php, admin_permission.php

	global $mysqli,$db_table_prefix; 

	$i = 0;

	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."permission_page_matches (

		permission_id,

		page_id

		)

		VALUES (

		?,

		?

		)");

	if (is_array($permission)){

		foreach($permission as $id){

			$stmt->bind_param("ii", $id, $page);

			$stmt->execute();

			$i++;

		}

	}

	elseif (is_array($page)){

		foreach($page as $id){

			$stmt->bind_param("ii", $permission, $id);

			$stmt->execute();

			$i++;

		}

	}

	else {

		$stmt->bind_param("ii", $permission, $page);

		$stmt->execute();

		$i++;

	}

	$stmt->close();

	return $i;

}



//Retrieve list of permission levels that can access a page

function fetchPagePermissions($page_id) // admin_page.php

{

	global $mysqli,$db_table_prefix; 

	$stmt = $mysqli->prepare("SELECT

		id,

		permission_id

		FROM ".$db_table_prefix."permission_page_matches

		WHERE page_id = ?

		");

	$stmt->bind_param("i", $page_id);	

	$stmt->execute();

	$stmt->bind_result($id, $permission);

	while ($stmt->fetch()){

		$row[$permission] = array('id' => $id, 'permission_id' => $permission);

	}

	$stmt->close();

	if (isset($row)){

		return ($row);

	}

}



//Retrieve list of pages that a permission level can access

function fetchPermissionPages($permission_id) // admin_permission.php

{

	global $mysqli,$db_table_prefix; 

	$stmt = $mysqli->prepare("SELECT

		id,

		page_id

		FROM ".$db_table_prefix."permission_page_matches

		WHERE permission_id = ?

		");

	$stmt->bind_param("i", $permission_id);	

	$stmt->execute();

	$stmt->bind_result($id, $page);

	while ($stmt->fetch()){

		$row[$page] = array('id' => $id, 'permission_id' => $page);

	}

	$stmt->close();

	if (isset($row)){

		return ($row);

	}

}



//Unmatched permission and page

function removePage($page, $permission) { // admin_page.php, admin_permission.php

	global $mysqli,$db_table_prefix; 

	$i = 0;

	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permission_page_matches 

		WHERE page_id = ?

		AND permission_id =?");

	if (is_array($page)){

		foreach($page as $id){

			$stmt->bind_param("ii", $id, $permission);

			$stmt->execute();

			$i++;

		}

	}

	elseif (is_array($permission)){

		foreach($permission as $id){

			$stmt->bind_param("ii", $page, $id);

			$stmt->execute();

			$i++;

		}

	}

	else {

		$stmt->bind_param("ii", $permission, $user);

		$stmt->execute();

		$i++;

	}

	$stmt->close();

	return $i;

}



//Check if a user has access to a page

function securePage($uri){ // every file in the framework uses this
	//Separate document name from uri

	$tokens = explode('/', $uri);

	$page = $tokens[sizeof($tokens)-1];

	global $mysqli,$db_table_prefix,$loggedInUser;

	//retrieve page details

	$stmt = $mysqli->prepare("SELECT 

		id,

		page,

		private

		FROM ".$db_table_prefix."pages

		WHERE

		page = ?

		LIMIT 1");

	$stmt->bind_param("s", $page);

	$stmt->execute();

	$stmt->bind_result($id, $page, $private);

	while ($stmt->fetch()){

		$pageDetails = array('id' => $id, 'page' => $page, 'private' => $private);

	}

	$stmt->close();

	//If page does not exist in DB, allow access

	if (empty($pageDetails)){

		return true;

	}

	//If page is public, allow access

	elseif ($pageDetails['private'] == 0) {

		return true;

	}

	//If user is not logged in, deny access and prompt them to log in

	elseif(!isUserLoggedIn()) 

	{	
		header("Location: login.php"); exit();
		
	}

	else {

		// The page exists, it is private, and user is logged in, so...
		//Retrieve list of permission levels with access to page

		$stmt = $mysqli->prepare("SELECT

			permission_id

			FROM ".$db_table_prefix."permission_page_matches

			WHERE page_id = ?

			");

		$stmt->bind_param("i", $pageDetails['id']);	

		$stmt->execute();

		$stmt->bind_result($permission);

		while ($stmt->fetch()){

			$pagePermissions[] = $permission;

		}

		$stmt->close();

		//Check if user's permission levels allow access to page

		if ($loggedInUser->checkPermission($pagePermissions)){ 

			return true;

		}

		//Grant access if master user

		elseif ($loggedInUser->user_id == $master_account){

			return true;

		}

		else {

			header("Location: account.php"); // why here?  User is logged in, but can't get to the requested page.  Dump them to account

			return false;	

		}

	}

}


ob_flush();
?>