<?php

    //require '/home/sparky/cronhelper/cron.helper.delsheets.php';

	//if(($pid = cronDelHelper::lock()) !== FALSE) {
	
		//Database Information
		$db_host = "127.0.0.1"; //Host address (most likely localhost)
		$db_name = "sparky_cake"; //Name of Database
		$db_user = "sparky_admin"; //Name of database user
		$db_pass = "badhorsie5150"; //Password for database user
		$db_table_prefix = "twiz_";
			
		/* Create a new mysqli object with database connection parameters */
		$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
		GLOBAL $mysqli;
		
		// this file is tied to a cron job in cpanel;  it will run every '     ' and delete files with a create date greater than '     '.
		$files = glob('../uploads/{,.}*', GLOB_BRACE); // gets rid of hidden files as well
		//$files = glob('../uploads/*'); // get all file names
		$time = time();
		
		foreach($files as $file){ // iterate files
		  if(is_file($file))
				//if ($time - filemtime($file) >= 1*3600) // 1 hours
				if ($time - filemtime($file) >= 96*3600) // 96 hours or 4 days
				//if ($time - filemtime($file) >= 300) // 5 minute
					unlink($file); // delete file
		}
	
		//WHERE time < NOW() - INTERVAL 24 HOUR");
		// delete rows in uc_user_sheets table that are older than 24 hours from the time they were submitted
		$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_sheets 
			
			WHERE time < NOW() - INTERVAL 96 HOUR AND id != '1'");
	
		$stmt->execute();
	
		$stmt->close();

		//cronDelHelper::unlock();
    //}
?>