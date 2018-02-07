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

		user_name,

		display_name,

		password,

		email,

		activation_token,

		last_activation_request,

		lost_password_request,

		active,

		title,

		sign_up_stamp,

		last_sign_in_stamp

		FROM ".$db_table_prefix."users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. "<br>";
		echo "user name: " . $row["user_name"]. "<br>";
		echo "display name: " . $row["display_name"]. "<br>";
        echo "password: " . $row["password"]. "<br>";
		echo "email: " . $row["email"]. "<br>";
		echo "activation token: " . $row["activation_token"]. "<br>";
        echo "last activation request: " . $row["last_activation_request"]. "<br>";
		echo "lost password request: " . $row["lost_password_request"]. "<br>";
		echo "active: " . $row["active"]. "<br>";
        echo "title: " . $row["title"]. "<br>";
		echo "sign up stamp: " . $row["sign_up_stamp"]. "<br>";
		echo "last sign in stamp: " . $row["last_sign_in_stamp"]. "<br><br>";
    }
} else {
    echo "0 results";
}
$conn->close();
destroySession("userCakeUser");
?>