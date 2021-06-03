<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Twiz sheet</title>
	<!--
To have DataTables styled in the same manner as other jQuery UI widgets, all you need to do, as well as including the DataTables core Javascript file
on your page, is include the DataTables / jQuery UI CSS and Javascript integration files.
-->
	<link rel="stylesheet" media="screen" href="../assets/css/ui-theme/jquery-ui.min.css" /><!-- jquery theme -->
	<link rel="stylesheet" media="screen" href="../assets/css/dataTables.jqueryui.css" /><!-- datatables css integration file -->
	<style>
		body,
		html {
			font-size: 12px;
		}

		.clear {
			clear: both;
		}

		#card-header {
			background: #4f7c39 url(../img/card-bg.jpg) repeat-x top left;
			width: 100%;
			padding-bottom: 15px;
			overflow: auto;
		}

		#card-header img {
			float: left;
			position: relative;
			top: 12px;
			left: 15px;
		}

		#card-header h1 {
			color: #fff;
			float: left;
			position: relative;
			left: 15px;
		}

		table {
			border-collapse: collapse;
			border: 2px solid #000;
			font: normal 80%/140% arial, helvetica, sans-serif;
			color: #555;
			background: #fff;
		}

		td,
		th {
			border: 1px dotted #bbb;
			padding: .5em;
		}

		caption {
			padding: 0 0 .5em 0;
			text-align: left;
			font-size: 1.4em;
			font-weight: bold;
			text-transform: uppercase;
			color: #333;
			background: transparent;
		}

		/* =links
----------------------------------------------- */

		table a {
			padding: 1px;
			text-decoration: none;
			font-weight: bold;
			background: transparent;
		}

		table a:link {
			border-bottom: 1px dashed #ddd;
			color: #000;
		}

		table a:visited {
			border-bottom: 1px dashed #ccc;
			text-decoration: line-through;
			color: #808080;
		}

		table a:hover {
			border-bottom: 1px dashed #bbb;
			color: #666;
		}

		/* =head =foot
----------------------------------------------- */

		thead th,
		tfoot th {
			border: 2px solid #000;
			text-align: left;
			font-size: 1.2em;
			font-weight: bold;
			color: #333;
			background: transparent;
		}

		tfoot td {
			border: 2px solid #000;
		}

		/* =body
----------------------------------------------- */

		tbody th,
		tbody td {
			vertical-align: top;
			text-align: left;
		}

		tbody th {
			white-space: nowrap;
		}

		.odd {
			background: #fcfcfc;
		}

		tbody tr:hover {
			background: #fafafa;
		}
	</style>
</head>

<body>

	<?php



	//$source = '../../uploads/'.$_POST["card"];
	$source = '../sample/latest.xml';
	//Last modified on 4/29/17
	// load as file
	$xmldata = simplexml_load_file($source);

	// format date for header
	$headerdate			= $xmldata->racedata[0]->race_date[0];
	$headerdate1		= date_create($headerdate);
	$headerdate2		= date_format($headerdate1, "M d, Y");

	// get full track name from array; pass in abbreviation
	//include("switch.php"); // return $trackloc variable with full track name as value

	/*echo '<div id="card-header"><img src="../assets/img/logo-twiz.png" /><h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$trackloc.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
'.$headerdate2.'</h1><a class="head-anchor equi" href="http://www.trackmaster.com/cgi-bin/axprodlist.cgi?tpp" target="_blank">Buy TRACKMASTER Printed PDF</a></div>';*/

	echo '<div id="card-header"><img src="../assets/img/logo-twiz.png" /></div><br>';
	echo '<p>Key: A=Program Number, B=Horses Name, C=Last race surface, D=TWIZ figure, E=Date of last race, Comment and Jockey+Trainer ranking, F=1/4m position(lengths back), 1/2m position(lengths back) & lenghts back in stretch, G=Last race odds, H=Morning line odds.</p>';
	echo '<B><h2>' . $xmldata->racedata[0]->track[0] . ' | ' . $headerdate2 . '</h2></b>';

	//echo '<div id="legend" style="display:none;"><img src="../img/legend_full.jpg" /></div>';


	// count number of <racedata> nodes in the entire document to get number of races for the jump anchors
	$xmlDoc = new DOMDocument();
	$xmlDoc->load($source);
	$raceNum = $xmlDoc->getElementsByTagName("racedata");
	$numOfraces = $raceNum->length;

	// racedata loop
	foreach ($xmldata->children() as $racedata) { // gets all <racedata> children of the root element <data>

		// get and format date for each race header
		$formatme1 						= $racedata->race_date;
		$date1							= date_create($formatme1);
		$race_date 						= date_format($date1, "m-d-y");
		$race_date_header 				= date_format($date1, "mdy");
		$equilinkracedate2 				= date_format($date1, "m/d/y");


		$tsurf = $racedata->surface;

		if ($tsurf <> "T" and $tsurf <>  "I" and $tsurf <> "C" and $tsurf <> "O") {
			$tsurf = "D";
		} else {
			$tsurf = "T";
		}

		// Create each race header
		echo '

	

	<div>
	
	<p>Race: ' . $racedata->race . ' | ' . ($racedata->distance / 100) . 'f on ' . $racedata->surface . ': ' . $racedata->race_text . '</p>';

		//echo '<p>Jump to race:&nbsp;&nbsp;';

		//for ($x = 1; $x <= $numOfraces; $x++) {
		//	echo "<a href='#".$x."'>".$x."</a>&nbsp;&nbsp;";
		//}

		echo '</p></div>';


		echo '<table class="display table' . $i . '">
	<thead><th> A </th><th> B </th><th> C </th><th> D </th><th> E </th><th> F </th><th> G </th><th> H </th></thead>';


		foreach ($racedata->horsedata as $horsedata) { // gets each <horsedata> node

			foreach ($horsedata->ppdata as $ppdata) { // gets each <ppdata> node

				$formatme2			= $ppdata->racedate;
				$date2				= date_create($formatme2);
				$equilinkracedate   = date_format($date2, "m/d/y");



				//TWIZ
				$pace2 = 0.0;
				$pace2 = ($ppdata->leadertim2);

				$xxx = 0.0;
				if ($pace2  >= 59) {
					$pace2 = ($ppdata->leadertime);
				}


				if (($ppdata->distance) / 100 < 8) {
					$xxx = 11;
				}

				if (($ppdata->distance) / 100 >= 8) {
					$xxx = 12;
				}

				$winspeed = 0.0;
				$winspeed = 100 + (((($ppdata->distance) / 100) * $xxx) - ($ppdata->leadertim4));
				$hmspeed = 0.0;
				$hmspeed = 100 + (43.2 - $pace2);



				$speedfigureavg = $hmspeed + $winspeed + ((($ppdata->lenback2) / 100) - (($ppdata->lenbackstr) / 100)); //+$ppdata->speedfigur;
				//$speedfigureavg=$speedfigureavg+(($ppdata->classratin)/10);

				$jockstarts = 0;
				$jockwins = 0;
				$jockperc = 0;
				$trainerstarts = 0;
				$trainerwins = 0;
				$trainerperc = 0;

				foreach ($horsedata->jockey->stats_data->children() as $jockeydata) {
					$jockstarts = $jockstarts + $jockeydata->starts;
					$jockwins = $jockwins + $jockeydata->wins;
				}
				foreach ($horsedata->jockey->stats_data->children() as $stat) {
					if ((string) $stat['type'] == 'LAST30') {
						$jockstarts = $jockstarts + $stat->starts;
						$jockwins = $jockwins + $stat->wins;
					}
				}

				foreach ($horsedata->trainer->stats_data->children() as $trainerdata) {
					$trainerstarts = $trainerstarts + $trainerdata->starts;
					$trainerwins = $trainerwins + $trainerdata->wins;
				}
				foreach ($horsedata->trainer->stats_data->children() as $stat) {

					if ((string) $stat['type'] == 'LAST30') {
						$trainerstarts = $trainerstarts + $stat->starts;
						$trainerwins = $trainerwins + $stat->wins;
					}
				}
				if ($jockstarts > 0) {
					$jockperc			= (($jockwins / $jockstarts) * 100);
				}
				if ($trainerstarts > 0) {
					$trainerperc		= (($trainerwins / $trainerstarts) * 100);
				}

				$trainerperc = $jockperc + $trainerperc;
				$hmraw = $hmspeed - ($ppdata->positionfi);

				$hmspeed = $hmspeed;
				$speedfigureavg = ($speedfigureavg) + $hmspeed;
				$speedfigureavg = ($speedfigureavg - 200) - $horsedata->morn_odds + ($trainerperc / 10);

				$mlo = $horsedata->morn_odds;
				$str_arrmlo = explode("/", $mlo);


				$choose1 = $str_arrmlo[0];
				if (($ppdata->posttimeod) < ($str_arrmlo[0])) {
					$choose1 = ($ppdata->posttimeod);
				}
				$speedfigureavg = $hmspeed + $winspeed - $choose1;
				// horse program number and horse name
				if ($pace2 <= 0) {
					$speedfigureavg = 0;
				}
				if (!is_nan($speedfigureavg)) {
					$speedfigureavg = $speedfigureavg;
				} else {
					$speedfigureavg = 0;
				}
				echo '<tr><td>' . $horsedata->program . '</td><td><b>' . $horsedata->horse_name . '</b></td>';

				// date



				if (strcmp($ppdata->surface, $racedata->surface) !== 0) {
					echo '<td>' . $ppdata->surface . '</td>';
				} else {
					echo '<td><strong>' . $ppdata->surface . '</strong></td>';
				}


				if ($ppdata->position1 <= 0) {
					$speedfigureavg = 0;
				}

				if ($ppdata->longcommen == "") {
					$speedfigureavg = 0;
				}




				echo '<td>' . round($speedfigureavg, 0) . '</td><td>';



				echo $equilinkracedate . ' ' . $ppdata->longcommen . ' (' . round($trainerperc / 10, 0) . ')</td><td>' . $ppdata->position1 . ' (' . ($ppdata->lenback1 / 100) . ') ' . $ppdata->position2 . ' (' . ($ppdata->lenback2 / 100) . ') ,' . ($ppdata->lenbackstr / 100) . '</td><td>' . $ppdata->posttimeod . '</td><td>' . $str_arrmlo[0] . '</td></tr>';



				$countit++;
				if ($countit > 1) {
					goto a;
				}
			} // end $ppdata loop

			a:
			$countit = 0;
		} // end $horsedata loop

		echo '</table>';
	} // end $racedata loop

	?>
	<script src="../assets/js/jquery-1.11.1.js"></script>
	<script src="../assets/js/datatables/jquery.dataTables.min.js"></script>
	<script src="../assets/js/datatables/dataTables.jqueryui.js"></script>
	<script src="../assets/js/natural.js"></script>

	<script>
		$(document).ready(function() {
			$('table.display').dataTable({
				"retrieve": true,
				"paging": false,
				"ordering": true,
				"info": false,
				"bFilter": false,
				"order": [
					[3, "desc"]
				],
				columnDefs: [{
						type: 'natural',
						targets: 0
					},
					{
						type: 'natural',
						targets: 2
					},
				]
			});
			$('#printMe').click(function() {
				window.print();
				return false;
			});
			$('#showlegend').click(function(e) {
				e.preventDefault();
				$('#legend').slideToggle('slow');
			});
		});
	</script>
</body>

</html>