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
    
<!--

Looking to target the stat node with a type attribute equal to 'LAST_YEAR':

<racedata>
	<horsedata>
		<stats_data>                                                                                               
			<stat type="LAST_YEAR">
				<starts>13</starts>
				<wins>3</wins>
				<places>1</places>
				<shows>1</shows>
				<earnings>93673.00</earnings>
				<paid>16.70</paid>
				<roi>52</roi>
			</stat> 

foreach ($xml->poster as $poster) {
    if ((string) $poster['id'] == 'minwage') {
        echo (string) $poster->full_image['url'];
    }
}
-->

<?php
$source = '../sample/latest.xml';

// load as file
$xmldata = simplexml_load_file($source);
    
    echo '<h1>The following data is pulled from the stat type="LAST_YEAR" node for the named horse.</h1>';

foreach($xmldata->children() as $racedata) { // gets all <racedata> children of the root element <data>
    
    echo '<h2>Race: '.$racedata->race.'</h2>';

foreach($racedata->horsedata as $horsedata) { // gets <horsedata> node
    
    echo '<h3>Horse: '.$horsedata->horse_name.'</h3>';
    			
			echo '<table><thead><th>Starts</th><th>Wins</th><th>Places</th><th>Shows</th><th>Earnings</th><th>Paid</th><th>ROI</th><thead><tbody>';
    
            foreach($horsedata->stats_data->stat as $stat) {
                if((string) $stat['type'] == 'LAST_YEAR'){
                   echo '<tr><td>'.$stat->starts.'</td><td>'.$stat->wins.'</td><td>'.$stat->places.'</td><td>'.$stat->shows.'</td><td>'.$stat->earnings.'</td><td>'.$stat->paid.'</td><td>'.$stat->roi.'</td></tr>';                    
                }
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
