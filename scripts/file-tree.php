<!DOCTYPE html>
<html lang="en">
<head>

<title>Handicapping horse racing Thoroughwiz</title>
<link rel="stylesheet" href="../assets/css/custom.css"><!-- custom css -->
<script type="text/javascript" src="../assets/js/jquery-1.11.1.js"></script>
<script type="text/javascript" src="../assets/js/php_file_tree_jquery.js"></script>
</head>
<body>

<?php

// Main function file
include("../models/php_file_tree.php");

echo "<h4>Twiz File Tree</h4>";
echo php_file_tree("/home/sparky/uploads/", "javascript:alert('You clicked on [link]');");

?>
    
</body>
</html>