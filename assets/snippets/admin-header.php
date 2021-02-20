<div class="col-md-12" style="border:1px solid #ccc;margin-bottom:10px;">
<?php
if ($loggedInUser->checkPermission(array(2))){
    echo "<h3>Administrator</h3>";
} else {
    echo "<h3>Twiz Member</h3>";
}

    echo "<div id='main'>Welcome, $loggedInUser->displayname. You registered this account on " . date("M d, Y", $loggedInUser->signupTimeStamp()) . ".</div><br>";            
?>
</div>