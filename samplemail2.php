<?php
require_once("models/config.php");

if(isset($_POST['submit'])){

    $mail = new twizMail();

    // public function sendMail($email,$subject,$msg = NULL)

    if(!$mail->sendMail("sparkhw@gmail.com","This is the subject","This is the message: Lost password request")){
        $msg = "Error sending email!";
    }else{
        $msg = "Mail sent OK";
    }

}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
<head>
	<title>Test form to email</title>
</head>

<body>
<?php echo $msg ?>
<p>
<form action='<?php echo htmlentities($_SERVER['PHP_SELF']); ?>' method='post'>
<input type='submit' name='submit' value='Submit'>
</form>
</p>

<!--<?php phpinfo(); ?>-->

</body>
</html>