<?php
require_once("models/config.php");

//Forms posted
if(!empty($_POST)){
	$password = trim($_POST["password"]);
	$confirm_pass = trim($_POST["passwordc"]);
	$email = trim($_POST["email"]);
	$captcha = md5($_POST["captcha"]);
	$agree = trim($_POST["agree"]);
	if($password == "")
	{
		$errors[] = "Password is missing";
	}
	if($confirm_pass == "")
	{
		$errors[] = "You must confirm your password";
	}
	if($email == "")
	{
		$errors[] = "Email is missing";
	}
	if($captcha == "")
	{
		$errors[] = "Please provide security code";
	}
	if($agree == "")
	{
		$errors[] = "You must agree to terms of use and privacy policy";
	}
	
	if ($captcha != $_SESSION['captcha'])
	{
		$errors[] = lang("CAPTCHA_FAIL");
	}
	if(minMaxRange(8,50,$password) && minMaxRange(8,50,$confirm_pass))
	{
		$errors[] = lang("ACCOUNT_PASS_CHAR_LIMIT",array(8,50));
	}
	else if($password != $confirm_pass)
	{
		$errors[] = lang("ACCOUNT_PASS_MISMATCH");
	}
	if(!isValidEmail($email))
	{
		$errors[] = lang("ACCOUNT_INVALID_EMAIL");
	}
	
	//End data validation
	if(count($errors) == 0){	
	
		/* Our constructor method is in class.newuser.php.  We can provide a values for the properties when we create the User object.
You ‘feed’ the constructor method by providing a list of arguments (like you do with a function) after the class name. */
		//$user = new User($firstname,$lastname,$username,$displayname,$password,$email);
		$user = new User($email,$password);
		
		//Checking this flag tells us whether there were any errors such as possible data duplication
		if(!$user->status) // is status != 'true'
		{
			if($user->email_taken){ 	  
				$errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));
				echo json_encode($errors);
			}
		}
		else // no problems during user creation
		{
			//Attempt to add the user to the database, carry out finishing tasks like emailing the user (if required)
			if(!$user->userCakeAddUser())
			{
				if($user->mail_failure) $errors[] = lang("MAIL_ERROR");
				if($user->sql_failure)  $errors[] = lang("SQL_ERROR");
			}
		}
		
	} else {
		echo json_encode($errors);
	}
	
	if(count($errors) == 0) {
		$successes[] = "match";
		$successes[] = $user->success;
		echo json_encode($successes);
	}
}else{
	header("Location: index.php"); die(); 
}
?>