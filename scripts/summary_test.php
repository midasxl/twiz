<!-- This is calcs.php for customer use -->

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>TWIZ FREE SUMMARY DEMO</title>
<style>
table {border-collapse: collapse;
border: 2px solid #000;
font: normal 80%/140% arial, helvetica, sans-serif;
color: #555;
background: #fff;}

td, th {border: 1px dotted #bbb;
padding: .5em;}
    
    h2{
        background-color:antiquewhite;
    }
</style>
</head>

<body>

<?php
$source = '../sample/latest.xml';

// load as file
$xmldata = simplexml_load_file($source);

foreach($xmldata->children() as $racedata) { // gets all <racedata> children of the root element <data>
    
    echo '<h2>Race: '.$racedata->race.'</h2>';

foreach($racedata->horsedata as $horsedata) { // gets <horsedata> node
    
    echo '<h3>Horse: '.$horsedata->horse_name.'</h3>';

$jockwins	= 0;
$jockplaces	= 0;
$jockstarts	= 0;
$trainerstarts	= 0;
$trainerwins	= 0;
$trainerplaces	= 0;
$horsestarts	= 0;
$horsewins	= 0;
$horseplaces	= 0;	
    
    // stat is a reserved function name in PHP
			
			echo '<table><thead><th>Jockey Starts</th><th>Jockey Wins</th><th>Jockey Places</th><thead><tbody>';
    
            foreach($horsedata->jockey->stats_data->children() as $jockeydata) {
				$jockstarts=$jockstarts+$jockeydata->starts;
				$jockwins=$jockwins+$jockeydata->wins;
                $jockplaces=$jockplaces+$jockeydata->places;
                
                echo '<tr><td>'.$jockstarts.'</td><td>'.$jockwins.'</td><td>'.$jockplaces.'</td></tr>';

			}
    
            echo '</tbody></table>';
				
			/*foreach ($horsedata->trainer->stats_data->children() as $trainerdata) {
				$trainerstarts=$trainerstarts+$trainerdata->starts;
				$trainerwins=$trainerwins+$trainerdata->wins;
                $trainerplaces=$trainerplaces+$trainerdata->places;

			}

			foreach ($horsedata->stats_data->children() as $newhorsedata) {
				$horsestarts=$horsestarts+$newhorsedata->starts;
				$horsewins=$horsewins+$newhorsedata->wins;
                $horseplaces=$horseplaces+$newhorsedata->places;

			}		

			$jockperc			= ((($jockwins+$jockplaces)/2)/$jockstarts)*100;
			$trainerperc		= ((($trainerwins+$trainerplaces)/2)/$trainerstarts)*100;
            $horseperc		    = ((($horsewins+$horseplaces)/2)/$horsestarts)*100;
			$connections		= ($jockperc+$trainerperc)/2;  */  
			
	} // end $racedata as $horsedata loop

} // end $xmldata as $racedata loop

?>
</body>
</html>
