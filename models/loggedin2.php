<?php
$db_host = "localhost"; //Host address (most likely localhost)

$db_name = "sparky_cake"; //Name of Database

$db_user = "sparky_admin"; //Name of database user

$db_pass = "badhorsie5150"; //Password for database user

$db_table_prefix = "uc_";

$servername = "localhost";
$username = "sparky_admin";
$password = "badhorsie5150";
$dbname = "sparky_cake";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO uc_user_permission_matches (id, permission_id)
		VALUES ('1', '2')";
		
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>