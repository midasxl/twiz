<?php
ob_start ();
/*Think of ob_start() as saying 'Start remembering everything that would normally be outputted, but don't quite do anything with it yet.'

For example:

ob_start();
echo("Hello there!"); //would normally get printed to the screen/output to browser
$output = ob_get_contents();
ob_end_clean();
ob_flush();

ob_get_contents(), basically gives you whatever has been "saved" to the buffer since it was turned on with ob_start().
ob_end_clean() or ob_flush() stops saving things and discards whatever was saved, or stops saving and outputs it all at once, respectively.*/

//Functions that do not interact with DB

//------------------------------------------------------------------------------



//Retrieve a list of all .php files in models/languages

function getLanguageFiles()

{

	$directory = "models/languages/";

	$languages = glob($directory . "*.php");

	//print each file name

	return $languages;

}



//Retrieve a list of all .css files in models/site-templates 

function getTemplateFiles()

{

	$directory = "models/site-templates/";

	$languages = glob($directory . "*.css");

	//print each file name

	return $languages;

}



//Retrieve a list of all .php files in root files folder

function getPageFiles()

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

function destroySession($name)

{

	if(isset($_SESSION[$name]))

	{

		$_SESSION[$name] = NULL;

		unset($_SESSION[$name]);

	}

}



//Generate a unique code

function getUniqueCode($length = "")

{	

	$code = md5(uniqid(rand(), true));

	if ($length != "") return substr($code, 0, $length);

	else return $code;

}



//Generate an activation key

function generateActivationToken($gen = null)

{

	do

	{

		$gen = md5(uniqid(mt_rand(), false));

	}

	while(validateActivationToken($gen));

	return $gen;

}



// generate a salted hash

function generateHash($plainText, $salt = null)

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

function isValidEmail($email)

{

	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

		return true;

	}

	else {

		return false;

	}

}



//Inputs language strings from selected language.

function lang($key,$markers = NULL)
// key would be something like ACCOUNT_USER_OR_PASS_INVALID => Username or password is invalid
{ 

	global $lang;

	if($markers == NULL)

	{

		$str = $lang[$key];

	}

	else

	{

		//Replace any dynamic markers

		$str = $lang[$key];

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

function minMaxRange($min, $max, $what) // 8,50,$password_new

{

	if(strlen(trim($what)) < $min)

		return true;

	else if(strlen(trim($what)) > $max)

		return true;

	else

	return false;

}



//Replaces hooks with specified text

function replaceDefaultHook($str)

{

	global $default_hooks,$default_replace;	

	return (str_replace($default_hooks,$default_replace,$str));

}



function resultBlock($errors,$successes){

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



//Displays error and success messages

/*function resultBlock($errors,$successes){

	//Error block

	if(count($errors) > 0)

	{

		echo "<div id='error' style='padding:3px;

	text-align:center;

	color:#4d4948;

	background-color:#fffebe;

	border: 1px solid #cbcbcb;

	font-size:90%;

	font-weight:bold;'>

		<a style='float:right;position:relative;right:3px' href='#' onclick=\"showHide('error');\">[x]</a>

		<ul style='clear:both'>";

		foreach($errors as $error)

		{

			echo "<li>".$error."</li>";

		}

		echo "</ul>";

		echo "</div>";

	}

	//Success block

	if(count($successes) > 0)

	{

		echo "<div id='success' style='padding:3px;

	text-align:center;

	color:#4d4948;

	background-color:#bce9b5;

	border: 1px solid #7ace6c;

	font-size:90%;

	font-weight:bold;'>

		<a style='float:right;position:relative;right:3px' href='#' onclick=\"showHide('success');\">[x]</a>

		<ul style='clear:both'>";

		foreach($successes as $success)

		{

			echo "<li>".$success."</li>";

		}

		echo "</ul>";

		echo "</div>";

	}

}*/



//Completely sanitizes text

function sanitize($str)

{

	return strtolower(strip_tags(trim(($str))));

}



//Functions that interact mainly with uc_users table

//------------------------------------------------------------------------------



//Delete a defined array of users

function deleteUsers($users) {

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

function displayNameExists($displayname)

{

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

function emailExists($email)

{

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

function emailUsernameLinked($email,$username)

{

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

function fetchAllUsers()

{

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

function fetchUserDetails($email=NULL,$token=NULL, $id=NULL)

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

function flagLostPasswordRequest($id,$value)

{

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



function flagPasswordReset($id,$value)

{

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

function isUserLoggedIn()

{

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



//Change a user's display name

function updateDisplayName($id, $display)

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

}



//Update a user's email

function updateEmail($id, $email)

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

function updateLastActivationRequest($new_activation_token,$email)

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

function updatePasswordFromToken($pass,$token)

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



//Update a user's title

function updateTitle($id, $title)

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

function createCustomer($id, $stripeid)

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

function addPlanId($id, $planid)

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

function fetchStripeId($id)

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

function fetchPlanId($id)

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

function userIdExists($id)

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

function usernameExists($username)

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

}



//Check if activation token exists in DB; if calling function passes TRUE as second parameter, then $lostpass will be true not null
// this is used by activate-account, confirm-password, deny-password
function validateActivationToken($token,$lostpass=NULL)

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

function setUserActive($token)
    
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



//If user exists and is active update to paid status

function validatePayStatus($token)

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

}



//Functions that interact mainly with uc_permissions table

//------------------------------------------------------------------------------



//Create a permission level in DB

function createPermission($permission) {

	global $mysqli,$db_table_prefix; 

	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."permissions (

		name

		)

		VALUES (

		?

		)");

	$stmt->bind_param("s", $permission);

	$result = $stmt->execute();

	$stmt->close();	

	return $result;

}



//Delete a permission level from the DB

function deletePermission($permission) {

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



//Retrieve information for all permission levels

function fetchAllPermissions()

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



//Create sheet access

function createSheet($id, $sheet, $racetrack, $racedate) {

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

function destroySheet($sheetid) {

	global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_sheets

		WHERE id = ?");	

	$stmt->bind_param("i", $sheetid);

	$result = $stmt->execute();

	$stmt->close();
	
	return $result;

}



//Add credit to user account
//If user credit row does not exist for this user create it first, then UPDATE it

function addCredit($credit, $id) {

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

function removeCredit($credit, $id) {

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



//Retrieve saved sheet information for current user

function fetchAllSheets($id)

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



//Retrieve saved credit information for current user

function fetchAllCredits($id)

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



//Retrieve information for a single permission level

function fetchPermissionDetails($id)

{

	global $mysqli,$db_table_prefix; 

	$stmt = $mysqli->prepare("SELECT 

		id,

		name

		FROM ".$db_table_prefix."permissions

		WHERE

		id = ?

		LIMIT 1");

	$stmt->bind_param("i", $id);

	$stmt->execute();

	$stmt->bind_result($id, $name);

	while ($stmt->fetch()){

		$row = array('id' => $id, 'name' => $name);

	}

	$stmt->close();

	return ($row);

}



//Check if a permission level ID exists in the DB

function permissionIdExists($id)

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

function permissionNameExists($permission)

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



//Change a permission level's name

function updatePermissionName($id, $name)

{

	global $mysqli,$db_table_prefix;

	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."permissions

		SET name = ?

		WHERE

		id = ?

		LIMIT 1");

	$stmt->bind_param("si", $name, $id);

	$result = $stmt->execute();

	$stmt->close();	

	return $result;	

}



//Functions that interact mainly with uc_user_permission_matches table

//------------------------------------------------------------------------------



//Match permission level(s) with user(s)

function addPermission($permission, $user) {

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



//Retrieve information for all user/permission level matches

function fetchAllMatches()

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

}



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

function fetchPermissionUsers($permission_id)

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



//Unmatch permission level(s) from user(s)

function removePermission($permission, $user) {

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



//Functions that interact mainly with uc_configuration table

//------------------------------------------------------------------------------



//Update configuration table

function updateConfig($id, $value)

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



//Functions that interact mainly with uc_pages table

//------------------------------------------------------------------------------



//Add a page to the DB

function createPages($pages) {

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

function deletePages($pages) {

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

function fetchAllPages()

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

function fetchPageDetails($id)

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

function pageIdExists($id)

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

function updatePrivate($id, $private)

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



//Functions that interact mainly with uc_permission_page_matches table

//------------------------------------------------------------------------------



//Match permission level(s) with page(s)

function addPage($page, $permission) {

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

function fetchPagePermissions($page_id)

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

function fetchPermissionPages($permission_id)

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

function removePage($page, $permission) {

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

function securePage($uri){
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