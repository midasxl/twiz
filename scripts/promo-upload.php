<?php
session_start();
$output_dir = "../../uploads/";
$allowedExts = array("zip","xml");
$temp = explode(".", $_FILES["myfile"]["name"]);
$extension = end($temp);
if(isset($_FILES["myfile"])){
	
	//validate file size
	if ($_FILES['myfile']['size'] > 6000000) 
	{
		echo "File exceeds max limitations of 6 MB";
		exit;
	}
	
	//validate file type based on extension
	if ( ! in_array($extension, $allowedExts))
	{
		echo "Wrong file type!";
		exit;
	}
	
	// is there a way to validate we have the correct XML file???
	
	//move the uploaded file to uploads folder;
	move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir. $_FILES["myfile"]["name"]);
	
	// if zip file
	if ( $extension == 'zip'){
		//echo "We have a zip";
		// assuming file.zip is in the same directory as the executing script.
		$file = $output_dir. $_FILES["myfile"]["name"];
		
		// get the absolute path to $file
		$path = pathinfo(realpath($file), PATHINFO_DIRNAME);
	
		$zip = new ZipArchive;
		$res = $zip->open($file); // returns 0 or 1
		if ($res === TRUE) {
		  // extract it to the path we determined above
		  $zip->extractTo($path);
		  //$contents = $zip->getNameIndex($i);
		  $_SESSION['data'] = $zip->getNameIndex($i);
		  $zip->close();
		  unlink($file); // this will delete the zip file after its contents have been extracted
		  
		  //$source = $output_dir. $_FILES["myfile"]["name"];
		  $xmldata = simplexml_load_file($output_dir. $_SESSION['data']);
		  $_SESSION['racedate'] = (string)$xmldata->racedata[0]->race_date[0];
		  $_SESSION['racetrack'] = (string)$xmldata->racedata[0]->track[0];
		  
		  header( 'Location: https://www.thoroughwiz.com/promo-product.php' ) ; 
		} else {
		  echo "Our apologies! Our logic couldn't extract $file.  Please contact Thoroughwiz support for further assistance.";
		}
	}
	
	// $_SERVER['DOCUMENT_ROOT'].'/../uploads/'
	
	// if xml file
	if ( $extension == 'xml'){
		$source = $output_dir. $_FILES["myfile"]["name"];
		$xmldata = simplexml_load_file($source);
		$_SESSION['racedate'] = (string)$xmldata->racedata[0]->race_date[0];
		$_SESSION['racetrack'] = (string)$xmldata->racedata[0]->track[0];
		$_SESSION['data'] = $_FILES["myfile"]["name"];
		  	header('Location:https://www.thoroughwiz.com/promo-product.php'); 
	}
}else{
    echo '<h3>What are you doing?  Go home.</h3>';
}
?>