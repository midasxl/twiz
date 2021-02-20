<?php
require_once("models/config.php");

//Forms posted
if(!empty($_POST))
{
	$email = trim($_POST["email"]);

	if($email == "")
	{
		$errors[] = lang("ACCOUNT_SPECIFY_EMAIL");
	}
	//Check to ensure email is in the correct format
	if(!isValidEmail($email))
	{
		$errors[] = lang("ACCOUNT_INVALID_EMAIL");
	}
	//Check to ensure email is in the db
	if(!emailExists($email))
	{
		$errors[] = lang("ACCOUNT_EMAIL_NOT_IN_DB");
	}
	
	
	if(count($errors) == 0) // if there are any errors in the array, this block will be skipped
	{
		//Check that the username / email are associated to the same account
		/* if(!emailUsernameLinked($email,$username))
		{
			$errors[] =  "You have provided invalid data";
			echo json_encode($errors);
		}
		else
		{ */
			//Check if the user has any outstanding lost password requests
			$userdetails = fetchUserDetails($email);
			if($userdetails["lost_password_request"] == 1)
			{
				$errors[] = lang("FORGOTPASS_REQUEST_EXISTS");
				echo json_encode($errors);
			}
			else
			{
				//Email the user asking to confirm this change password request
				//We can use the template builder here
				//We use the activation token again for the url key it gets regenerated everytime it's used.
				$mail = new userCakeMail();
				$confirm_url = "Confirm \n".$websiteUrl."confirm-password.php?confirm=".$userdetails["activation_token"];
				$deny_url = "Deny \n".$websiteUrl."deny-password.php?deny=".$userdetails["activation_token"];
				//Setup our custom hooks
				$hooks = array(
					"searchStrs" => array("#CONFIRM-URL#","#DENY-URL#","#USERNAME#"),
					"subjectStrs" => array($confirm_url,$deny_url,$userdetails["email"])
					);
				if(!$mail->newTemplateMsg("lost-password-request.txt",$hooks))
				{
					$errors[] = lang("MAIL_TEMPLATE_BUILD_ERROR");
					echo json_encode($errors);
				}
				else
				{
					if(!$mail->sendMail($userdetails["email"],"Lost password request"))
					{
						$errors[] = lang("MAIL_ERROR");
						echo json_encode($errors);
					}
					else
					
					{
						//Update the DB (via the flagPasswordReset function) with a flag to prompt user to reset password when they log in with their temp password
						if(!flagPasswordReset($userdetails["id"],1))// this sets it to 1.  The ! means "if this fails"
						{
							$errors[] = lang("sql_ERROR");
							echo json_encode($errors);
						}
						else {
							//Update the DB (via the flagLostPasswordRequest function) with a flag to show this account has an outstanding password change request
							if(!flagLostPasswordRequest($userdetails["id"],1))// this sets it to 1.  The ! means "if this fails"
							{
								$errors[] = lang("SQL_ERROR");
								echo json_encode($errors);
							}
							else {
								$successes[] = "match";
								$successes[] = lang("FORGOTPASS_REQUEST_SUCCESS");
								echo json_encode($successes);
							}
						}
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