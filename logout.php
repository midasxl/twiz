<?php
ob_start();
/* Think of ob_start() as saying "Start remembering everything that would normally be outputted, but don't quite do anything with it yet."  The PHP output buffering will save all the server outputs ( html and php prints) to a string variable */
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Log the user out
if(isUserLoggedIn())
{
	$loggedInUser->userLogOut();
}

if(!empty($websiteUrl)) 
{
	$add_http = ""; // why add http? If in the configuration admin adds website url simply as twizfigs.com this will add the protocol
	// strpos returns the position of first occurrence of a string inside another string or else false if string is not found
	if(strpos($websiteUrl,"https://") === false)// if not found
	{
		$add_http = "https://";
	}
	
	header("Location: ".$add_http.$websiteUrl);
	die();
}
else
{
	header("Location: https://".$_SERVER['HTTP_HOST']);
	die();
}	
ob_end_flush(); /* stops saving and outputs it all at once */
?>

<!--
    ob_start();
    print "Hello First!\n";
    ob_end_flush();

    ob_start();
    print "Hello Second!\n";
    ob_end_clean();

    ob_start();
    print "Hello Third!\n";

That script will output "Hello First" because the first text is placed into a buffer then flushed with ob_end_flush(). The "Hello Second" will not be printed out, though, because it is placed into a buffer which is cleaned using ob_end_clean() and not sent to output. Finally, the script will print out "Hello Third" because PHP automatically flushes open output buffers when it reaches the end of a script. -->