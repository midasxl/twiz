<?php
require_once("models/config.php");

//Forms posted
if(!empty($_POST)){

	$email = trim($_POST["email"]);
	$password = trim($_POST["password"]);
  
	if($email == "")
	{
		$errors[] = lang("ACCOUNT_SPECIFY_EMAIL");
	}
	if($password == "")
	{
		$errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
	}
	
	if(count($errors) == 0)
	{
		//A security note here, NEVER tell the user which credential was incorrect
		if(!emailExists($email))
		{
			$errors[] = lang("ACCOUNT_INVALID_DATA");
			echo json_encode($errors);
		}
		else
		{
			$userdetails = fetchUserDetails($email);
			//See if the user's account is activated
			if($userdetails["active"]==0)
			{
				$errors[] = lang("ACCOUNT_INACTIVE");
				echo json_encode($errors);
			}
			else
			{
				//Hash the password and use the salt from the database to compare the password.
				$entered_pass = generateHash($password,$userdetails["password"]);
				
				if($entered_pass != $userdetails["password"])
				{
					$errors[] = lang("ACCOUNT_INVALID_DATA");
					echo json_encode($errors);
				}
				else
				{
					$loggedInUser = new loggedInUser();
					$loggedInUser->email = $userdetails["email"];
					$loggedInUser->user_id = $userdetails["id"];
					$loggedInUser->hash_pw = $userdetails["password"];
					$loggedInUser->title = $userdetails["title"];
					$loggedInUser->stripe_id = $userdetails["stripe_id"];
					$loggedInUser->plan_id = $userdetails["plan_id"];
					$loggedInUser->pass_change = $userdetails["pass_change"];
					
					//Update last sign in
					$loggedInUser->updateLastSignIn();
					$_SESSION["userCakeUser"] = $loggedInUser;
					
					$successes[] = "match"; // this is returned and checked in the Ajax call
					echo json_encode($successes);
				}
			}
		}
	}else{
		echo json_encode($errors);
	}
}else{
	header("Location: index.php"); die(); 
}
?>