#!/usr/bin/php
<?php

//Email information
$admin_email = "sparkhw@gmail.com";
$email = "nobody@nobody.com";
$subject = "Test Cron Job";
$comment = "This is the test comment";

//send email
mail($admin_email, "$subject", $comment, "From:" . $email);

?>