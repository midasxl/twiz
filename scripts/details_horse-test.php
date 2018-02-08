<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
border: 2px solid #000;
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
$source = '../../uploads/'.$_POST["card"];
//Last modified on 4/29/17
// load as file
$xmldata = simplexml_load_file($source);

// format date for header
$headerdate			= $xmldata->racedata[0]->race_date[0];
$headerdate1		= date_create($headerdate);
$headerdate2		= date_format($headerdate1,"M d, Y");

// get full track name from array; pass in abbreviation
include("switch.php"); // return $trackloc variable with full track name as value

/*echo '<div id="card-header"><img src="../assets/img/logo-twiz.png" /><h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$trackloc.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
'.$headerdate2.'</h1><a class="head-anchor equi" href="http://www.trackmaster.com/cgi-bin/axprodlist.cgi?tpp" target="_blank">Buy TRACKMASTER Printed PDF</a></div>';*/

echo '<div id="card-header"><img src="../assets/img/logo-twiz.png" /><h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$trackloc.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
'.$headerdate2.'</h1><a style="float:right;color:#fff;padding:8px;" href="" id="printMe">Print This Card</a><a href="" id="showlegend" style="float:right;color:#fff;padding:8px;">Show/Hide Legend</a></div>';

echo '<div id="legend" style="display:none;"><img src="../img/legend_full.jpg" /></div>';

$anchorNum = 0;

// count number of <racedata> nodes in the entire document to get number of races for the jump anchors
$xmlDoc = new DOMDocument();
$xmlDoc->load($source);
$raceNum = $xmlDoc->getElementsByTagName("racedata");
$numOfraces = $raceNum->length;

// loop time
foreach($xmldata->children() as $racedata) { // gets all <racedata> children of the root element <data>

// get and format date for each race header
	$formatme1 					= $racedata->race_date;
	$date1							= date_create($formatme1);
	$race_date 					= date_format($date1,"m-d-y");
	$race_date_header 	= date_format($date1,"mdy");
  $equilinkracedate2 	= date_format($date1,"m/d/y");
	$anchorNum 					= $anchorNum + 1;

	$tsurf=$racedata->surface;

if ($tsurf<> "T" AND $tsurf<>  "I" AND $tsurf<> "C" AND $tsurf<> "O" ){
	$tsurf="D";
}else{
	$tsurf="T";
}

// get and calculate dollar amount instead of odds
$mornoddsd=$mornodds[1];
if ($mornoddsd<=0){
	$mornoddsd=1;
}
if($mornodds[1] <>0){
	$dollarvalue 	= $mornodds[0] / $mornodds[1];
}else{
	$dollarvalue 	= $mornodds[0] ;
}

$todaysclass=$racedata->todays_cls;

// Create each race header
echo '<div class="title">
	<h3 class="r-data">

	<a name="'.$anchorNum.'" class="head-anchor" href="http://www.equibase.com/static/entry/'.$racedata->track.$race_date_header.'USA-EQB.html#RACE'.$racedata->race.'" target="_blank">Race '.$racedata->race.', Class of '.$racedata->todays_cls.' @ '.$racedata->track.' on '.$race_date.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Going '.$racedata->dist_disp.' over the '.$tsurf.'</a>
	</h3>

	<h3 class="p-time">Post Time: '.$racedata->post_time.'</h3>
	</div>

	<div class="clear"></div>

	<div>
	<p>Bet Opt: '.$racedata->bet_opt.'</p>
	<p><strong>Race Information:</strong><br>'.$racedata->race_text.'</p>
	<p>

	<a  class="r-data" href= "http://www.equibase.com/static/chart/summary/'.$racedata->track.$race_date_header.'USA'.$racedata->race.'-EQB.html " target="_blank">Results</a>:
	<a  class="r-data" href= "http://www.equibase.com/premium/eqbPDFChartPlus.cfm?RACE='.$racedata->race.'&BorP=P&TID='.$racedata->track.'&CTRY=USA&DT='.$equilinkracedate2.'&DAY=D&STYLE=EQB" target="_blank">Charts</a>:
	<a  class="r-data" href= "http://www.trackmaster.com/free/biasReports" target="_blank"> BIAS Reports </a> :

	</p>';

	echo '<p>Jump to race:&nbsp;&nbsp;';

	for ($x = 1; $x <= $numOfraces; $x++) {
    	echo "<a href='#".$x."'>".$x."</a>&nbsp;&nbsp;";
	}

	echo '</p></div>';

	$countthem=0;
	$countthem=0;
	$jockperc=0;
	$trainerperc=0;
	$horseperc=0;
	$raceperc=0;
	$workperc=0;
	$classratingavg=0;
	$speedfigureavg=0;
	$pacefigure2avg=0;
	$pacefigure2avg4=0;
	$pacefigureavg3=0;
	$pacefigureavg=0;
	$qdisp=0;
	$hdisp=0;
	$sdisp=0;
	$fdisp=0;
	$abytavg=0;
	$count=0;

	// loop time
	foreach($racedata->horsedata as $horsedata) { // gets each <horsedata> node
				echo '<hr /><a href="#" id="table'.$count.'" class="filters hideRows">Show only checked rows</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#" id="table'.$count.'" class="filters restoreRows">Restore hidden rows</a><div id="spacer"></div>
				<table class="display table'.$count.'">
				<thead><th>Pr#</th><th>__</th><th>Horse</th><th>Date</th><th>Track</th><th>Dist</th><th>Surf</th><th>Cond</th><th>Class</th><th>EP</th><th>LP</th><th><img src="../img/e.jpg"/></th><th>Odds</th><th>1c</th><th>2c</th><th>3c</th><th>4c</th><th>Fin</th><th>Comment</th></thead>';

				foreach($horsedata->ppdata as $ppdata) { // gets each <ppdata> node

					echo '<tr><td>'.$count.'</td><td><input type="checkbox" class="check" /></td><td>col</td><td>col</td><td>col</td><td>col</td><td>col</td><td>col</td><td>col</td><td>col</td><td>col</td><td>col</td><td>col</td><td>col</td><td>col</td><td>col</td><td>col</td><td>col</td><td>col</td></tr>';
					$count = $count + 1;
				} // end $ppdata loop

				echo '</table>';

	} // end $horsedata loop

} // end $racedata loop

?>
<script src="../assets/js/jquery-1.11.1.js"></script>
<script src="../assets/js/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/js/datatables/dataTables.jqueryui.js"></script>
<script src="../assets/js/natural.js"></script>
<script>
$(document).ready(function(){
		  $('table.display').dataTable({
				"retrieve": true,
				"paging": false,
				"ordering": false,
				"info": false,
				"bFilter": false,
				"order": [[ 0, "asc" ]],
				columnDefs: [
					{ type: 'natural', targets: 0 },
					{ type: 'natural', targets: 2 },
				]
			});
			$(".hideRows").click(function(e){e.preventDefault();
				//alert("hello");
				var target = $(this).prop('id'); // i.e. table0
				target = '.' + target; // i.e. .table0
				$(target).find('input[type="checkbox"]').each(function () { // go through each checkbox in the table
				   if ($(this).prop('checked')!=true) { // if it's not checked hide it
					 $(this).parent().parent().hide(); // parent of parent would be the <tr> tag
				   };
				});
			});
			$(".restoreRows").click(function(e){e.preventDefault();
				//alert("goodbye");
				var target = $(this).prop('id');
				target = '.' + target;
				$(target).find('input[type="checkbox"]').each(function () {
				   if ($(this).prop('checked')!=true) {
					 $(this).parent().parent().show();
				   };
				});
			});
			$('#printMe').click(function() {
				window.print();
				return false;
			});
			$('#showlegend').click(function(e){
				e.preventDefault();
				$('#legend').slideToggle('slow');
			});
});
</script>
</body>
</html>
