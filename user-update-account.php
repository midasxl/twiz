<?php
require_once("models/config.php");
// from the account page to update user password
//Forms posted

if(!empty($_POST)){
	
	$password = trim($_POST["password"]);
	$password_new = trim($_POST["passwordc"]);
	$password_confirm = trim($_POST["passwordcheck"]);
	// create md5 hash
	$entered_pass = generateHash($password,$loggedInUser->hash_pw);

	if ($password == ""){ 
		$errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
		echo json_encode($errors);
	}else if($entered_pass != $loggedInUser->hash_pw){
		$errors[] = lang("ACCOUNT_INVALID_DATA");
		echo json_encode($errors);
	}else if ($password_new == ""){	
		$errors[] = lang("ACCOUNT_SPECIFY_NEW_PASSWORD");
		echo json_encode($errors);
	}else if($password_confirm == ""){
		$errors[] = lang("ACCOUNT_SPECIFY_CONFIRM_PASSWORD");
		echo json_encode($errors);
	}else if($password_new != "" AND $password_confirm != ""){	
	
		if(minMaxRange(8,50,$password_new)){
			$errors[] = lang("ACCOUNT_NEW_PASSWORD_LENGTH",array(8,50));
			echo json_encode($errors);
		}else if($password_new != $password_confirm){
			$errors[] = lang("ACCOUNT_PASS_MISMATCH");
			echo json_encode($errors);
		}else{
			if(count($errors) == 0)
			{
				//Also prevent updating if someone attempts to update with the same password
				$entered_pass_new = generateHash($password_new,$loggedInUser->hash_pw);
				if($entered_pass_new == $loggedInUser->hash_pw)
				{
					//Don't update, this fool is trying to update with the same password
					$errors[] = lang("ACCOUNT_PASSWORD_NOTHING_TO_UPDATE");
					echo json_encode($errors);
				}
				else
				{
					if(!flagPasswordReset($loggedInUser->user_id,0))// this sets it back to 0.  The ! means "if this fails"
						{
							$errors[] = lang("SQL_ERROR");
							echo json_encode($errors);
						}
						else
						{
						//This function will create the new hash and update the hash_pw property.
						$loggedInUser->updatePassword($password_new);
						$successes[0] = lang("ACCOUNT_PASSWORD_UPDATED");
						$successes[1] = "match";
						echo json_encode($successes);
					}
				}
			}else{
					echo json_encode($errors);	
			}	
		}
	}else{
		if(count($errors) == 0 AND count($successes) == 0){
			$errors[] = lang("NOTHING_TO_UPDATE");
			echo json_encode($errors);
		}
	}
		
}// close if post empty
?>