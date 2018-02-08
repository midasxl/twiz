<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>HORSE Details Twiz sheet</title>
<!--
To have DataTables styled in the same manner as other jQuery UI widgets, all you need to do, as well as including the DataTables core Javascript file on your page, is include the DataTables / jQuery UI CSS and Javascript integration files.
-->
<link rel="stylesheet" media="screen" href="../assets/css/ui-theme/jquery-ui.min.css" /><!-- jquery theme -->
<link rel="stylesheet" media="screen" href="../assets/css/dataTables.jqueryui.css" /><!-- datatables css integration file -->
<style>
body, html{font-size:12px;}
.clear{clear:both;}
#card-header{background:#4f7c39 url(../img/card-bg.jpg) repeat-x top left;width:100%;padding-bottom:15px;overflow:auto;}
#card-header img{float:left;position:relative;top:12px;left:15px;}
#card-header h1{color:#fff;float:left;position:relative;left:15px;}
/* Greyscale
Table Design by Scott Boyle, Two Plus Four
www.twoplusfour.co.uk
----------------------------------------------- */

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
$source = '../sample/latest.xml';
//Last modified on 1/28/2018
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
	$formatme1 			= $racedata->race_date;
	$date1				= date_create($formatme1);
	$race_date 			= date_format($date1,"m-d-y");
	$race_date_header 	= date_format($date1,"mdy");
   $equilinkracedate2 	= date_format($date1,"m/d/y");
	$anchorNum 			= $anchorNum + 1;

$tsurf=$racedata->surface;

if ($tsurf<> "T" AND $tsurf<>  "I" AND $tsurf<> "C" AND $tsurf<> "O" ){
$tsurf="D";
} ELSE {
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
	// Loop time
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
	foreach($racedata->horsedata as $horsedata) { // gets each <horsedata> node
	echo '<table class="display"><thead><th>Pr#</th><th>Horse</th><th>Date</th><th>Track</th><th>Dist</th><th>Surf</th><th>Cond</th><th>Class</th><th>EP</th><th>LP</th><th><img src="../img/e.jpg"/></th><th>Odds</th><th>1c</th><th>2c</th><th>3c</th><th>4c</th><th>Fin</th><th>Comment</th></thead>';	
	foreach($horsedata->ppdata as $ppdata) { // gets each <ppdata> node

	    $formatme2			= $ppdata->racedate;
        $date2				= date_create($formatme2);
	    $equilinkracedate   = date_format($date2,"m/d/y");
		$posttimeodds		= $ppdata->posttimeod;
	
		if(isset($horsedata->ppdata)){
			$equilink = "<a href='http://www.equibase.com/premium/eqbPDFChartPlus.cfm?RACE=".$ppdata->racenumber."&BorP=P&TID=".$ppdata->trackcode."&CTRY=".$ppdata->country."&DT=".$equilinkracedate."&DAY=D&STYLE=EQB' target='_blank'>".$equilinkracedate."</a>";
		}else{
			$equilink = "";	
		}
	
		// get and calculate to determine $averagepace value
		$pacefigureavg		= $ppdata->pacefigure;
		$pacefigure2avg 	= $ppdata->pacefigur2;
		$foreign  = $ppdata->foreignspe;

//added this line
$foreign = $foreign -10;
		// get and calculate to determine $sort value
$speedfigureavg 	= $ppdata->speedfigur; // 0
if ($foreign > 0){
$speedfigurevalue=$foreign-20;
}
		$classratingavg		= $ppdata->classratin; // 95
 $pacefigureavg3=(($pacefigureavg*2)+$pacefigure2avg)/3;
$pacefigure2avg4=(($pacefigure2avg*2)+$pacefigureavg)/3;


$averagepace = ($pacefigureavg+$pacefigure2avg)/2 ;
$printpace=max($pacefigureavg,$pacefigure2avg);

		

		$sort				= max($averagepace,$speedfigureavg,$classratingavg); // 95

		// get and calculate dollar amount instead of odds
		$oddsd=$odds1[1];
if($oddsd<=0){
	$oddsd=1;
}
		// get and calculate dollar amount instead of odds
		$odds1 				= (explode("/",$ppdata->posttimeod,2));
		$dollarvalue1 		= $odds1[0] / $oddsd;
		$dollarvalue2 		= $ppdata->posttimeod;
 


//$twiz_num 			= $sort - $dollarvalue2;
//$twiz_num			= abs($twiz_num);

//if ($speedfigureavg <=0){   // Added in for scratched horse
	//$twiz_num='scr';
//}

// horse program number and horse name
echo '<tr><td>'.$horsedata->program.'</td>
<td>'.$ppdata->medication.' | <b>'.$horsedata->horse_name.'</b> '.$ppdata->equipment.' ('.$ppdata->weightcarr.')'.'</td>';

// date
echo '<td>'.$equilink.'</td>';

// track code
if (strcmp($ppdata->trackcode, $racedata->track) !== 0)  {
	echo '<td>'.$ppdata->trackcode.'</td>';
} else {
	echo '<td><strong>'.$ppdata->trackcode.'</strong></td>';
}

$distof				=($ppdata->distance);

// distance

$todaysdist			=(int)($racedata->distance);
$distof				=(int)$distof;
$dst=$distof;
if ($todaysdist < ($distof-1) or $todaysdist > ($distof+1)) {
	echo '<td>'.$dst.'</td>';
} else {
	echo '<td><strong>'.$dst.'</strong></td>';
}

// surface add in pulled off turf $ppdata->pulledofft.


if (strcmp($ppdata->surface, $racedata->surface) !== 0)  {
	echo '<td>'.$ppdata->surface.'</td>';
} else {
	echo '<td><strong>'.$ppdata->surface.'</strong></td>';
}


// track condition
if ($ppdata->trackcondi <> "FM" and $ppdata->trackcondi <> "FT"){
	echo '<td>'.$ppdata->trackcondi.'</td>';
}else{
	echo '<td><i>'.$ppdata->trackcondi.'</i></td>';
}

// class 
$classratingavg 		= (int)($classratingavg/1)*1 ;
$todaysclass 			= (int)($todaysclass/1)*1;

if ($classratingavg == "-97"){
	echo '<td>na</td>';
} else if ($classratingavg >= $todaysclass) {
	echo '<td><strong>'.$classratingavg.'</strong></td>';
} else {
	echo '<td>'.$classratingavg.'</td>';
}

// finish
$finish = $ppdata->positionfi; // Value will be a 0 or higher integer
if ($finish == 0){ // if position is equal to '0'
	$finish = "99";
}


// pace and speed
if ($averagepace <= 0 and $finish = "99") { // this means we have a foreign track; no pace, but a finish position
	$pacefigureavg = '0';
$pacefigure2avg = '0';
}	

//Running Style
//$fs=$ppdata->fieldsize;
//$c1=100-(($ppdata->position1)/$fs)*100;
//$c2=100-(($ppdata->position2)/$fs)*100;
//$c3=100-(($ppdata->positionst)/$fs)*100;
//$c4=100-(($ppdata->positionfi)/$fs)*100;
//$finish2=($ppdata->positionfi);


	
	//speed
	
	$printpace=max($pacefigureavg,$pacefigure2avg);
if ($speedfigureavg == 0){

	$speedfigureavg=0;
	goto c;
}

$classratingavg		= (($classratingavg/130)*100)+(130/4) ;
$speedfigureavg	= (($speedfigureavg/130)*100)+(130/4) ;
c:

	//pace
	
		echo '<td>'.round($pacefigureavg).'</td>';
	
	
		echo '<td>'.round($pacefigure2avg).'</td>';
	echo '<td>'.round($speedfigureavg).'</td>';
$qlb=($ppdata->lenback1)/100;

$hlb=($ppdata->lenback2)/100;

$slb=($ppdata->lenbackstr)/100;

$flb=($ppdata->lenbackfin)/100;


$abyt=$ppdata->horsetime2-$ppdata->horsetime1;
$abyt2=$ppdata->horsetimes-$ppdata->horsetime2;
if($abyt2 <= $abyt And $abyt2 >=0){
	$abyt=$abyt2;
}
if ($abyt <=18){
	$abyt=$abyt+$abyt;
}
// quarter
$quarter = ($qlb+$ppdata->position1)/2;

// half
$half = ($hlb+$ppdata->position2)/2;

// stretch
$stretch =($slb+$ppdata->positionst)/2;

// finish
$finish1 = ($flb+$ppdata->positionfi)/2; 
$fs=$ppdata->fieldsize;
if($fs<=0){
	goto g;
}
$c1=100-(($quarter)/$fs)*100;
$c2=100-(($half)/$fs)*100;
$c3=100-(($stretch)/$fs)*100;
$c4=100-(($finish1)/$fs)*100;
$finish2=($ppdata->positionfi);
if($lines2<=0){
	goto g;
}
$qdisp=($pacefigureavg-(($quarter/2)/$lines2));
$qperc=($quarter/2)*10;
$hdisp=$pacefigureavg-(($half/2)/$lines2);
$sdisp=$pacefigure2avg-(($stretch/2)/$lines2);
$fdisp=$pacefigure2avg-(($finish1/2)/$lines2);



g:
if($lines2<=0){
	$lines2=1;
}
if($fs<=0){
	$fs=1;
}

if($speedfigureavg == 0 ){
	$qdisp=0;
	$hdisp=0;
	$sdisp=0;
	$fdisp=0;
	$c1=0;
$c2=0;
$c3=0;
$c4=0;
$finish2=0;
}

$sty="n/a";
$qperc=round($qperc);

if($qperc <= 2 ){
	$sty="E".round(100-$qperc);
}

if($qperc >=3 and $qperc <=6 ){
	$sty="eP ".round(100-$qperc);
}

if($qperc >=7 and $qperc <=9 ){
	$sty="P".round(100-$qperc);
}
if($qperc >=10 ){
	$sty="S".round(100-$qperc);
}


if($speedfigureavg == 0){
	$sty="na";
}

echo '<td>'.$posttimeodds.'</td>';
$cavg=6;
$c1=(($c1)+(($speedfigureavg+$finish2)/10))/2;
$c2=(($c2)+(($speedfigureavg+$finish2)/10))/2;
$c3=(($c3)+(($speedfigureavg+$finish2)/10))/2;
$c4=(($c4)+(($speedfigureavg+$finish2)/10))/2;

 echo '<td>'.number_format($c1, 0, '.', '').'</td>';
 echo '<td>'.number_format($c2, 0, '.', '').'</td>';
 echo '<td>'.number_format($c3, 0, '.', '').'</td>';
 echo '<td>'.number_format($c4, 0, '.', '').'</td>';
 echo '<td>'.$finish2.'</td>';
	
$avgme=1;
$adjust=((($fdisp)+(($hdisp-$qdisp)+($sdisp-$hdisp)+($fdisp-$sdisp)))+$speedfigureavg)/2;

if ($qdisp > 0){
	$avgme=$avgme+1;
}

if ($hdisp > 0){
	$avgme=$avgme+1;
}

if ($sdisp > 0){
	$avgme=$avgme+1;
}

if ($fdisp > 0){
	$avgme=$avgme+1;
}

if ($speedfigureavg > 0){
	$avgme=$avgme+1;
}

if ($classratingavg  > 0){
	$avgme=$avgme+1;
}

if ($pacefigure2avg > 0){
	$avgme=$avgme+1;
}

if ($pacefigure2avg4 > 0){
	$avgme=$avgme+1;
}

if ($pacefigureavg > 0){
	$avgme=$avgme+1;
}

if ($pacefigureavg3 > 0){
	$avgme=$avgme+1;
}





$somefig1=(($classratingavg+$speedfigureavg+$pacefigure2avg+$pacefigure2avg4+$pacefigureavg3+$pacefigureavg+$qdisp+$hdisp+$sdisp+$fdisp-$abytavg)/$avgme)-$dollarvalue1;


if ($speedfigureavg == 0){

	$somefig1=0;

}
$somefigadj=$adjust;

if($abyt<=0){
	$somefigadj=0;
}

		  // echo '<td>'.number_format($somefigadj, 1, '.', '').'</td>';

echo '<td>'.$ppdata->shortcomme.'</td>';

// from excel =100+(R15-(P15*10)-(Q15*2)))



	}

	} // end $racedata as $horsedata loop
echo '</table>';	


} // end $xmldata as $racedata loop

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
