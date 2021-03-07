<?php

//Database Information
$db_host = "localhost"; //Host address (most likely localhost)
$db_name = "twiz_gringotts"; //Name of Database
$db_user = "twiz_admin"; //Name of database user
$db_pass = "B@dhors1e"; //Password for database user
$db_table_prefix = "twiz_";

GLOBAL $errors;
GLOBAL $successes;

$errors = array();
$successes = array();

/* Create a new mysqli object with database connection parameters */
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
GLOBAL $mysqli;

if(mysqli_connect_errno()) {
	echo "Connection Failed: " . mysqli_connect_errno();
	exit();
}

//Direct to install directory, if it exists
if(is_dir("install/"))
{
	header("Location: install/");
	die();

}

?>