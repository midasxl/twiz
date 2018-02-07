<?php
require_once("models/config.php");

//Forms posted
if(!empty($_POST) && $emailActivation){// if form scope is not empty and emailActivation is TRUE
	
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
	
	if(count($errors) == 0)// if there are no error entries in the array
	{

		//Check that the username / email are associated to the same account
		/* if(!emailUsernameLinked($email,$username))
		{
			$errors[] = lang("ACCOUNT_USER_OR_EMAIL_INVALID");
			echo json_encode($errors);
		}
		else
		{ */
			$userdetails = fetchUserDetails($email);
			
			//See if the user's account is active
			if($userdetails["active"]==1)
			{
				$errors[] = lang("ACCOUNT_ALREADY_ACTIVE");
				echo json_encode($errors);
			}
			else
			{
				if ($resend_activation_threshold == 0) {
					$hours_diff = 0;
				}
				else {
					$last_request = $userdetails["last_activation_request"];
					$hours_diff = round((time()-$last_request) / (3600*$resend_activation_threshold),0);
				}
				if($resend_activation_threshold!=0 && $hours_diff <= $resend_activation_threshold)
				{
					$errors[] = lang("ACCOUNT_LINK_ALREADY_SENT",array($resend_activation_threshold));
					echo json_encode($errors);
				}
				else
				{
					//For security create a new activation url;
					$new_activation_token = generateActivationToken();
					if(!updateLastActivationRequest($new_activation_token,$email))
					{
						$errors[] = lang("SQL_ERROR");
						echo json_encode($errors);
					}
					else
					{
						$mail = new userCakeMail();
						$activation_url = $websiteUrl."activate-account.php?token=".$new_activation_token;
						//Setup our custom hooks
						$hooks = array(
							"searchStrs" => array("#ACTIVATION-URL","#USERNAME#"),
							"subjectStrs" => array($activation_url,$userdetails["email"])
							);
						if(!$mail->newTemplateMsg("resend-activation.txt",$hooks))
						{
							$errors[] = lang("MAIL_TEMPLATE_BUILD_ERROR");
							echo json_encode($errors);
						}
						else
						{
							if(!$mail->sendMail($userdetails["email"],"Activate your ".$websiteName." Account"))
							{
								$errors[] = lang("MAIL_ERROR");
								echo json_encode($errors);
							}
							else
							{
								//Success, user details have been updated in the db now mail this information out.
								$successes[] = "match";
								$successes[] = lang("ACCOUNT_NEW_ACTIVATION_SENT");
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