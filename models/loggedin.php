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

$sql = "SELECT

		id,

		permission_id

		FROM ".$db_table_prefix."user_permission_matches

		";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. "<br>";
		echo "perm id: " . $row["permission_id"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>