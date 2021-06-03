<!-- This is calcs.php for customer use -->

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Thoroughwiz Calc Test</title>
<!--
To have DataTables styled in the same manner as other jQuery UI widgets, all you need to do, as well as including the DataTables core Javascript file on your page, is include the DataTables / jQuery UI CSS and Javascript integration files.
-->
<link rel="stylesheet" media="screen" href="../assets/css/ui-theme/jquery-ui.min.css" /><!-- jquery theme -->
<link rel="stylesheet" media="screen" href="../assets/css/dataTables.jqueryui.css" /><!-- datatables css integration file -->
<link rel="stylesheet" media="screen" href="../assets/css/tabletools/tabletools.css" /><!-- datatools css integration file -->
</head>

<body>

<?php

$x = 47.6;

$ppdata = $x + 5;

echo $ppdata;

?>
			
</body>
</html>
