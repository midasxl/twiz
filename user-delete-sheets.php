<?php
require_once("models/config.php");
// from the account page to delete sheets that have finished race dates

if(!empty($_POST)){
	
	$sheetId = trim($_POST["sheetId"]);
	
	if ($sheetId == ""){ 
		$errors[] = "Sheet ID is empty";
		echo json_encode($errors);
	}else{
		if(count($errors) == 0){
				if(!destroySheet($sheetId)){
					$errors[] = "problem destroying sheets";
					echo json_encode($errors);
				}else{
					//$successes[0] = lang("ACCOUNT_PASSWORD_UPDATED");
					$successes[0] = "Sheet set successfully deleted!";
					echo json_encode($successes);
				}
		}else{
				echo json_encode($errors);	
		}	
	}	
}// close if post empty
?>