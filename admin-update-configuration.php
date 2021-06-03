<?php
require_once("models/config.php");

//Forms posted
if(!empty($_POST)){

	$cfgId = array();
	$newSettings = $_POST['settings'];
	
	if ($newSettings[1] != $websiteName) {
	    $newWebsiteName = $newSettings[1];
		if(minMaxRange(1,150,$newWebsiteName)) {
			$errors[] = lang("CONFIG_NAME_CHAR_LIMIT",array(1,150));
		}
		else if (count($errors) == 0) {
		    $cfgId[] = 1;
			$cfgValue[1] = $newWebsiteName;
			$websiteName = $newWebsiteName;
		}
	}
	
	if ($newSettings[2] !== $websiteUrl) {
		$newWebsiteUrl = $newSettings[2];
		if(minMaxRange(1,150,$newWebsiteUrl)) {
			$errors[] = lang("CONFIG_URL_CHAR_LIMIT",array(1,150));
		}else if (substr($newWebsiteUrl, -1) != "/"){
			$errors[] = lang("CONFIG_INVALID_URL_END");
		}else if (count($errors) == 0) {
			$cfgId[] = 2;
			$cfgValue[2] = $newWebsiteUrl;
			$websiteUrl = $newWebsiteUrl;
		}
	}

	//Validate new site email address
	if ($newSettings[3] != $emailAddress) {
		$newEmail = $newSettings[3];
		if(minMaxRange(1,150,$newEmail)) {
			$errors[] = lang("CONFIG_EMAIL_CHAR_LIMIT",array(1,150));
		}elseif(!isValidEmail($newEmail)) {
			$errors[] = lang("CONFIG_EMAIL_INVALID");
		} else if (count($errors) == 0) {
			$cfgId[] = 3;
			$cfgValue[3] = $newEmail;
			$emailAddress = $newEmail;
		}
	}

	//Validate email activation selection
	if ($newSettings[4] != $emailActivation) {
		$newActivation = $newSettings[4];
		if($newActivation != "true" AND $newActivation != "false") {
			$errors[] = lang("CONFIG_ACTIVATION_TRUE_FALSE");
		}else if (count($errors) == 0) {
			$cfgId[] = 4;
			$cfgValue[4] = $newActivation;
			$emailActivation = $newActivation;
		}
	}

	//Validate new email activation resend threshold
	if ($newSettings[5] != $resend_activation_threshold) {
		$newResend_activation_threshold = $newSettings[5];
		if($newResend_activation_threshold > 72 OR $newResend_activation_threshold < 0) {
			$errors[] = lang("CONFIG_ACTIVATION_RESEND_RANGE",array(0,72));
		}else if (count($errors) == 0) {
			$cfgId[] = 5;
			$cfgValue[5] = $newResend_activation_threshold;
			$resend_activation_threshold = $newResend_activation_threshold;
		}
	}	

	//Validate new language selection
	if ($newSettings[6] != $language) {
		$newLanguage = $newSettings[6];
		if(minMaxRange(1,150,$language)) {
			$errors[] = lang("CONFIG_LANGUAGE_CHAR_LIMIT",array(1,150));
		}elseif (!file_exists($newLanguage)) {
			$errors[] = lang("CONFIG_LANGUAGE_INVALID",array($newLanguage));
		}else if (count($errors) == 0) {
			$cfgId[] = 6;
			$cfgValue[6] = $newLanguage;
			$language = $newLanguage;
		}
	}	

	//Validate new template selection
	if ($newSettings[7] != $template) {
		$newTemplate = $newSettings[7];
		if(minMaxRange(1,150,$template)) {
			$errors[] = lang("CONFIG_TEMPLATE_CHAR_LIMIT",array(1,150));
		}elseif (!file_exists($newTemplate)) {
			$errors[] = lang("CONFIG_TEMPLATE_INVALID",array($newTemplate));	
		}else if (count($errors) == 0) {
			$cfgId[] = 7;
			$cfgValue[7] = $newTemplate;
			$template = $newTemplate;
		}
	}	

	if (count($errors) == 0 AND count($cfgId) > 0) {
		updateConfig($cfgId, $cfgValue);
		$successes[] = "match";
		$successes[] = lang("CONFIG_UPDATE_SUCCESSFUL");
		echo json_encode($successes);
	}
}
?>