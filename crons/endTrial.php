<?php

//require '/home/sparky/cronhelper/cron.helper.php';

	//if(($pid = cronHelper::lock()) !== FALSE) {
	
		//Database Information
		$db_host = "localhost"; //Host address (most likely localhost)
		$db_name = "sparky_cake"; //Name of Database
		$db_user = "sparky_admin"; //Name of database user
		$db_pass = "badhorsie5150"; //Password for database user
		$db_table_prefix = "uc_";
			
		$db = @mysqli_connect ($db_host, $db_user, $db_pass, $db_name) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
				
		// WHERE time < NOW() - INTERVAL 76 HOUR
		// modify users whose sign_up_stamps are older than 3 days
		$query =  "SELECT * FROM ".$db_table_prefix."users 
				
				WHERE sign_up_stamp < NOW() - INTERVAL 5 MINUTE
				
				AND trial = 1";
					
		$result = mysqli_query($db, $query);
		
		while($row = mysqli_fetch_array($result))
		{
			$query2 = "UPDATE ".$db_table_prefix."user_permission_matches 
					
					SET permission_id = '2'
					
					WHERE user_id = '".$row['id']."'";	
			
					$result2 = mysqli_query($db, $query2);
			
			$query3 = "UPDATE ".$db_table_prefix."users
			
					SET trial = '0'
			
					WHERE id = '".$row['id']."'";
						
					$result3 = mysqli_query($db, $query3);					
					
		}
	
		mysqli_close($db);	
		
		// }
?>