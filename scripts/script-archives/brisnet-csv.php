<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>HORSE Details Twiz sheet</title>
<!--
To have DataTables styled in the same manner as other jQuery UI widgets, all you need to do, as well as including the DataTables core Javascript file
on your page, is include the DataTables / jQuery UI CSS and Javascript integration files.
-->
<link rel="stylesheet" media="screen" href="../assets/css/ui-theme/jquery-ui.min.css" /><!-- jquery theme -->
<link rel="stylesheet" media="screen" href="../assets/css/dataTables.jqueryui.css" /><!-- datatables css integration file -->
<style>
body, html{font-size:12px;}
.clear{clear:both;}
#card-header{background:#4f7c39 url(../img/card-bg.jpg) repeat-x top left;width:100%;padding-bottom:15px;overflow:auto;}
#card-header img{float:left;position:relative;top:12px;left:15px;}
#card-header h1{color:#fff;float:left;position:relative;left:15px;}

table {border-collapse: collapse;
border: 1px solid #000;
font: normal 80%/140% arial, helvetica, sans-serif;
color: #555;
background: #fff;}

td, th {border: 1px dotted #bbb;
padding: .5em;}

caption {padding: 0 0 .5em 0;
text-align: left;
font-size: 1.4em;
font-weight: bold;
text-transform: uppercase;
color: #333;
background: transparent;}

/* =links
----------------------------------------------- */

table a {padding: 1px;
text-decoration: none;
font-weight: bold;
background: transparent;}

table a:link {border-bottom: 1px dashed #ddd;
color: #000;}

table a:visited {border-bottom: 1px dashed #ccc;
text-decoration: line-through;
color: #808080;}

table a:hover {border-bottom: 1px dashed #bbb;
color: #666;}

/* =head =foot
----------------------------------------------- */

thead th, tfoot th {border: 2px solid #000;
text-align: left;
font-size: 1.2em;
font-weight: bold;
color: #333;
background: transparent;}

tfoot td {border: 2px solid #000;}

/* =body
----------------------------------------------- */

tbody th, tbody td {vertical-align: top;
text-align: left;}

tbody th {white-space: nowrap;}

.odd {background: #fcfcfc;}

tbody tr:hover {background: #fafafa;}

</style>
</head>

<body>

<?php

$source = '../docs/brisnet.csv';

if (($handle = fopen($source, "r")) !== FALSE) {

    while (($headerdata = fgetcsv($handle, 0, ',', '"', '"')) !== FALSE) {
        // $data represents a single row from the csv
        $headerdate			= $headerdata[1];
        $headerdate1		= date_create($headerdate);
        $headerdate2		= date_format($headerdate1,"M d, Y");

        // get full track name from array; pass in abbreviation
        include("switch-csv.php"); // return $trackloc variable with full track name as value

        echo '<div id="card-header"><img src="../assets/img/logo-twiz.png" /><h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$trackloc.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
'.$headerdate2.'</h1><a style="float:right;color:#fff;padding:8px;" href="" id="printMe">Print This Card</a><a href="" id="showlegend" style="float:right;color:#fff;padding:8px;">Show/Hide Legend</a></div>';

        echo '<div id="legend" style="display:none;"><img src="../img/legend_full.jpg" /></div>';

        break;

	}

    fclose($handle);
}



if (($handle = fopen($source, "r")) !== FALSE) {

    $wantedColumns = array(3,6,7,43,44,45,225,226,227,228,229,230,316,346,506,516,576,577,578,586,587,588,666,667,668,746,876,896,1036,1383);

    echo '<table><tbody>';    
    echo '<tr>';
    echo '<th>Race #</th>
        <th>Distance</th>
        <th>Surface</th>
        <th>Program #</th>
        <th>MLO</th>
        <th>Horse Name</th>
        <th>CRC</th>
        <th>CRC</th>
        <th>CRC</th>
        <th>CRC</th>
        <th>CRC</th>
        <th>CRC</th>
        <th>Distance</th>
        <th># of entrants</th>
        <th>Weight</th>
        <th>Odds</th>
        <th>First Call Pos</th>
        <th>First Call Pos</th>
        <th>First Call Pos</th>
        <th>Second Call Pos</th>
        <th>Second Call Pos</th>
        <th>Second Call Pos</th>
        <th>1st Call BtnLngths only</th>
        <th>1st Call BtnLngths only</th>
        <th>1st Call BtnLngths only</th>
        <th>Finish BtnLngths only</th>
		<th>2f Fraction (if any)</th>
        <th>4f Fraction (if any)</th>
        <th>Final Time</th>
		<th>Comment</th>
        <th>TWIZ FIG</th>';
    echo '</tr>';

    while (($data = fgetcsv($handle, 0, ',', '"', '"')) !== FALSE) {
        // $data represents a single row from the csv

        echo '<tr>';

        $num = count($data);

        for ($c=0; $c < $num; $c++) {

            if (!in_array($c,$wantedColumns)) continue;

            $value = $data[$c-1];

            /*$pace2= $data[28];

            if ($pace2  >= 59) {
                $pace2=$data[27];
            }

            $lbf=$data[25];
            if ($lbf<=0) {
                $lbf=0;
            }

            if ($data[12]/100 < 8) {
                $xxx=11;
            }

            if ($data[12]/100 >= 8) {
                $xxx=12;
            }

            $winspeed=100 + ((($data[12]/100)*($xxx)) - ($data[28]));
            $myspeed = $winspeed - ($lbf/100);

            $speedfigureavg=($$data[14]);
            $speedfigureavg=$speedfigureavg+((100+(43.2-$pace2))*2);
            $speedfigureavg=$speedfigureavg+(($myspeed)/10);
            $speedfigureavg=$speedfigureavg+(($winspeed)/10);
            $speedfigureavg=$speedfigureavg+$data[13];
            $speedfigureavg=$speedfigureavg+(($data[16])-($lbf));
            $speedfigureavg=$speedfigureavg-$data[15];*/

            echo '<td>&nbsp;&nbsp;'.$value.'&nbsp;&nbsp;</td>';

		}

        //echo '<td>'.$speedfigureavg.'</td>';
        echo '<td></td>';
        echo '</tr>';
    }

    echo '</tbody></table>';

    fclose($handle);

}

?>

</body>
</html>
