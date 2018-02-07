<?php
session_start();
$output_dir = "../../uploads/";
$allowedExts = array("zip","xml");
$temp = explode(".", $_FILES["myfile"]["name"]);
$extension = end($temp);

/*if( empty( $_SESSION[adminsheets] ) )
{
$_SESSION[adminsheets]=array();
}*/
 
if(isset($_FILES["myfile"])){
	
	//validate file size
	if ($_FILES['myfile']['size'] > 6000000) 
	{
		echo "File exceeds max limitations of 6 MB!";
		exit;
	}
	
	//validate file type based on extension
	if ( ! in_array($extension, $allowedExts))
	{
		echo "Wrong file type! Only .zip and .xml files are allowed!";
		exit;
	}
	
	// is there a way to validate we have the correct XML file???
	
	//move the uploaded file to uploads folder;
	move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir. $_FILES["myfile"]["name"]);
	
	// can we extract information from the xml file here?  Yep!
	
	$source = $output_dir. $_FILES["myfile"]["name"];
	$xmldata = simplexml_load_file($source);	
	$_SESSION['track'] = (string)$xmldata->trackdata[0]->track[0];
	//$_SESSION['racetrack'] = (string)$xmldata->trackdata[0]->track[0];
	
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
		  array_push($_SESSION[adminsheets],$zip->getNameIndex($i));
		  $_SESSION['data'] = $zip->getNameIndex($i);
		  $zip->close();
		  unlink($file); // this will delete the zip file after its contents have been extracted
		  
		  //$source = $output_dir. $_FILES["myfile"]["name"];
		  $xmldata = simplexml_load_file($output_dir. $_SESSION['data']);
		  $_SESSION['track'] = (string)$xmldata->trackdata[0]->track[0];
		  //$_SESSION['racetrack'] = (string)$xmldata->racedata[0]->track[0];
		  
		  	//email notification that admin was used
		  	//$todayis = date("l, F j, Y, g:i a") ;
			//$subject = "Message from Thoroughwiz Admin Page";	
			//$body = " The admin area was accessed and data was submitted. \r \n Date: $todayis";
			//put your email address here
			//mail("sparkhw@gmail.com", $subject, $body, $headers);
			//mail("dwood@thoroughwiz.com", $subject, $body, $headers);

		  header( 'Location: https://www.thoroughwiz.com/product_admin_harness.php' ) ; 
		} else {
		  echo "Doh! I couldn't extract $file";
		}
	}
	
	// $_SERVER['DOCUMENT_ROOT'].'/../uploads/'
	
	// if xml file
	if ( $extension == 'xml'){
			array_push($_SESSION[adminsheets],$_FILES["myfile"]["name"]);
			$source = $output_dir. $_FILES["myfile"]["name"];
			$xmldata = simplexml_load_file($source);
			//$_SESSION['racedate'] = (string)$xmldata->racedata[0]->race_date[0];
			$_SESSION['track'] = (string)$xmldata->trackdata[0]->track[0];
			$_SESSION['data'] = $_FILES["myfile"]["name"];
		  	//email notification that admin was used
		  	//$todayis = date("l, F j, Y, g:i a") ;
			//$subject = "Message from Thoroughwiz Admin Page";	
			//$body = " The admin area was accessed and data was submitted. \r \n Date: $todayis";
			//put your email address here
			//mail("sparkhw@gmail.com", $subject, $body, $headers);
			//mail("dwood@thoroughwiz.com", $subject, $body, $headers);

		  	header('Location:https://www.thoroughwiz.com/product_admin_harness.php'); 
	}
}else{
    echo '<h3>What are you doing?  Go home.</h3>';
}
?>