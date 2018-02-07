<?php
require_once("models/config.php");

//Forms posted
if(!empty($_POST)){
	
	$name = trim($_POST["name"]);
	$email = trim($_POST["email"]);
	$message = trim($_POST["message"]);
	$captcha = md5($_POST["captcha"]);
	
	if($name == "")
	{
		$errors[] = "Your name is missing";
	}
	if($email == "")
	{
		$errors[] = "You must provide a valid email address";
	}	
	if(!isValidEmail($email))
	{
		$errors[] = lang("ACCOUNT_INVALID_EMAIL");
	}
	if($message == "")
	{
		$errors[] = "What, no message?";
	}
	if ($captcha != $_SESSION['captcha'])
	{
		$errors[] = lang("CAPTCHA_FAIL");
	}
	
	  // detect & prevent header injections
	  /*$test = "/(content-type|bcc:|cc:|to:)/i";
	  foreach ( $_POST as $key => $val ) {
		if ( preg_match( $test, $val ) ) {
		  exit;
		}
	  }*/
	  
	//End data validation
	if(count($errors) == 0){	
		//declare our email variables
		$headers .= "Reply-To: ". $_POST['email'] ."\r\n"; 
		$headers .= "Return-Path: ". $_POST['email'] ."\r\n"; 
		$headers .= "From: ". $_POST['email'] ."\r\n"; 
		
		$headers .= "Organization: Sender Organization\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
		$headers .= "X-Priority: 3\r\n";
		$headers .= "X-Mailer: PHP". phpversion() ."\r\n";
		
		$name = trim($_POST['name']);
		$email = trim($_POST['email']);
		$message = trim($_POST['message']);
		
		$name = strip_tags($name);
		$email = strip_tags($email);
		$message = strip_tags($message);
		
		$todayis = date("l, F j, Y, g:i a") ;
		$subject = "Message from Thoroughwiz Contact Page";	
		$body = " From: $name  \r \n Email: $email \r \n Message: $message \r \n Date: $todayis";
		
		//put your email address here
		mail("sparkhw@gmail.com", $subject, $body, $headers);
		mail("support@thoroughwiz.com", $subject, $body, $headers);
	}else{
		echo json_encode($errors);
	}
	if(count($errors) == 0) {
		$successes[] = "match";
		$successes[] = "Thank you for your correspondence!";
		echo json_encode($successes);
	}
}else{
	header("Location: index.php"); die(); 
}
?>