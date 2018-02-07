<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Detailed HORSE Twiz sheet</title>
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
$source = '../../uploads/'.$_POST["card"];

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
$anchorNum 			= $anchorNum + 1;

// get and calculate dollar amount instead of odds
$mornodds 		= (explode("/",$horsedata->morn_odds,2));
$dollarvalue 	= $mornodds[0] / $mornodds[1];

$todaysclass=$racedata->todays_cls;		

// Create each race header
echo '<div class="title"><h3 class="r-data"><a name="'.$anchorNum.'" class="head-anchor" href="http://www.equibase.com/static/entry/'.$racedata->track.$race_date_header.'USA-EQB.html#RACE'.$racedata->race.'" target="_blank">Race '.$racedata->race.', Class of '.$racedata->todays_cls.' @ '.$racedata->track.' on '.$race_date.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Going '.$racedata->dist_disp.' over the '.$racedata->surface.'</a></h3><h3 class="p-time">Post Time: '.$racedata->post_time.'</h3></div><div class="clear"></div><div style="padding:5px;margin-bottom:3px"><p>Bet Opt: '.$racedata->bet_opt.'</p><p><strong>Race Information:</strong><br>'.$racedata->race_text.'</p></div>';


	echo '<p>Jump to race:&nbsp;&nbsp;';
	
	for ($x = 1; $x <= $numOfraces; $x++) {
    	echo "<a href='#".$x."'>".$x."</a>&nbsp;&nbsp;";
	} 
	
	echo '</p>';

// create table and thead tag and contents
	
	// Loop time

	foreach($racedata->horsedata as $horsedata) { // gets each <horsedata> node
	echo '<table class="display"><thead><th>Pr#</th><th>Horse</th><th>Date</th><th>Track</th><th>Dist</th><th>Surf</th><th>Cond</th><th>Class</th><th>EP</th><th>LP</th><th><img src="../img/e.jpg"/></th><th>1/4</th><th>1/2</th><th>Str</th><th>Fin</th><th>Odds</th><th>raw</th><th>Comment</th></thead>';	
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
 
if($pacefigureavg < $speedfigureavg/2){
$pacefigureavg=$speedfigureavg;
}

if($pacefigure2avg < $speedfigureavg/2){
$pacefigure2avg=$speedfigureavg;
}
		$averagepace 		= max($pacefigureavg,$pacefigure2avg); // 0
		

		

		$sort				= max($averagepace,$speedfigureavg,$classratingavg); // 95

		// get and calculate dollar amount instead of odds
		$odds1 				= (explode("/",$ppdata->posttimeod,2));
		$dollarvalue1 		= $odds1[0] / $odds1[1];
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

$distof				=($ppdata->distance)/100;

// distance
if ($ppdata->distance <= 600){
$dst="Sprt";
}
if ($ppdata->distance> 600 and $ppdata->distance < 800){
$dst="Midl";
}
if ($ppdata->distance >= 800 and $ppdata->distance < 1000){
$dst="Rout";
}
if ($ppdata->distance >= 1000 ){
$dst="Mara";
}

$todaysdist			=(int)($racedata->distance)/100;
$distof				=(int)$distof;

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
$qlb=intval($ppdata->lenback1)/100;
if ($qlb <=0){
$qlb=0;
}
$hlb=intval($ppdata->lenback2)/100;
if ($hlb <=0){
$hlb=0;
}
$slb=intval($ppdata->lenbackstr)/100;
if ($slb <=0){
$slb=0;
}
$flb=intval($ppdata->lenbackfin)/100;
if ($flb <=0){
$flb=0;
}

$classratingavg=$classratingavg+10;
// quarter
$quarter = (($qlb+intval($ppdata->position1))/2);
$qdisp=$classratingavg-((($qlb+intval($ppdata->position1))/2));

// half
$half = (($hlb+intval($ppdata->position2))/2);
$hdisp=$classratingavg-((($hlb+intval($ppdata->position2))/2));

// stretch
$stretch = (($slb+intval($ppdata->positionst))/2);
$sdisp=$classratingavg-((($slb+intval($ppdata->positionst))/2));

// finish
$finish1 = (($flb+intval($ppdata->positionfi))/2); 
$fdisp=$classratingavg-((($flb+intval($ppdata->positionfi))/2));






	



// stretch
$stretch = $ppdata->lenbackstr;

if ($stretch <> "0"){
	$stretch = ($ppdata->lenbackstr)/100;
}else{
	$stretch = "99";
}

if ($stretch == "99.99"){
	$stretch = "99";
}

if ($stretch == "-0.99"){
	$stretch = "99";
}

// half
$half = $ppdata->lenback2;

if ($half <> "0"){
	$half = ($ppdata->lenback2)/100;
}else{
	$half = "99";
}

if ($half == "99.99"){
	$half = "99";
}

if ($half == "-0.99"){
	$half = "99";
}

// quarter
$quarter = $ppdata->lenback1;

if ($quarter <> "0"){
	$quarter = ($ppdata->lenback1)/100;
}else{
	$quarter = "99";
}

if ($quarter == "99.99"){
	$quarter = "99";
}

if ($quarter == "-0.99"){
	$quarter = "99";
}


//$quarter;$half;$stretch;$finish;


if ($qdisp >= $classratingavg){
$qdisp = 0;
}
if ($hdisp >= $classratingavg){
$hdisp = 0;
}
if ($sdisp >= $classratingavg){
$sdisp = 0;
}
if ($fdisp >= $classratingavg){
$fdisp = 0;
}

if($ppdata->fieldsize<=0){
	$ppdata->fieldsize=1;
}
$qdisp1=(((150-$classratingavg)/10)+((($ppdata->position1*100)/$ppdata->fieldsize)+$ppdata->lenback1)/100)/2;
$hdisp1=(((150-$classratingavg)/10)+((($ppdata->position2*100)/$ppdata->fieldsize)+$ppdata->lenback2)/100)/2;
$sdisp1=(((150-$classratingavg)/10)+((($ppdata->positionst*100)/$ppdata->fieldsize)+$ppdata->lenbackstr)/100)/2;

if ($ppdata->positionfi==0){
$ppdata->lenbackfin=0;
}

$fdisp1=(((150-$classratingavg)/10)+((($ppdata->positionfi*100)/$ppdata->fieldsize)+$ppdata->lenbackfin)/100)/2;
if ($speedfigureavg <= 0){
	$qdisp1=0;
	$hdisp1=0;
	$sdisp1=0;
	$fdisp1=0;
	$qdisp=0;
	$hdisp=0;
	$sdisp=0;
	$fdisp=0;
}
$qdisp=$qdisp-$qdisp1;
$hdisp=$hdisp-$hdisp1;
$sdisp=$sdisp-$sdisp1;
$fdisp=$fdisp-$fdisp1;

$speedfigureavg=$fdisp;
$pacefigureavg=$qdisp;
if($qdisp<=$hdisp){
	$pacefigureavg=$hdisp;
}
$pacefigure2avg=$hdisp;
if($hdisp<=$sdisp){
	$pacefigure2avg=$sdisp;
}
if($pacefigureavg <=0){
	$pacefigureavg=0;
	$pacefigure2avg=0;
}

$pacefigureavg=(($pacefigureavg*2)+$pacefigure2avg)/3;
$pacefigure2avg=(($pacefigure2avg*2)+$pacefigureavg)/3;
	//pace
	
		echo '<td>'.round($pacefigureavg).'</td>';
	
	
		echo '<td>'.round($pacefigure2avg).'</td>';
	
	//speed
	echo '<td>'.round($speedfigureavg).'</td>';
	$base=20;
	if ($speedfigureavg==0){
		$qdisp1=0;
		$hdisp1=0;
		$sdisp1=0;
		$fdisp1=0;
		$posttimeodds=99;
		$base=0;
	}

$clss=$classratingavg-10;
$erly=$pacefigureavg;
$ltte=$pacefigure2avg;
$pce=max($erly,$ltte);
$raceperc=50;
$raceperc=(100-( ($horsedata->ppdata[0]->positionfi[0]/$horsedata->ppdata[0]->fieldsize[0])*100))+($horsedata->ppdata[0]->fieldsize[0]/10);	
if($raceperc == 100){
$raceperc=0;
}
$fit=$raceperc;


$qdisp1=$base-$qdisp1;
$hdisp1=$base-$hdisp1;
$sdisp1=$base-$sdisp1;
$fdisp1=$base-$fdisp1;

$hdisp1=$hdisp1+($hdisp1-$qdisp1);
$sdisp1=$sdisp1+($sdisp1-$hdisp1);
$fdisp1=$fdisp1+($fdisp1-$sdisp1);

if($pacefigureavg <=0){
	$pacefigureavg=0;
	$pacefigure2avg=0;
	$qdisp1=0;
		$hdisp1=0;
		$sdisp1=0;
		$pce=50;
}
	
if ($finish > 0 and $finish < 5) { // this is only to determine if the font is bold or not
  echo '<td><strong>'.round($qdisp1,1).'</strong></td><td><strong>'.round($hdisp1,1).'</strong></td><td><strong>'.round($sdisp1,1).'</strong></td><td><strong>'.round($fdisp1,1).'</strong></td>';
} else {
  echo '<td>'.round($qdisp1,1).'</td><td>'.round($hdisp1,1).'</td><td>'.round($sdisp1,1).'</td><td>'.round($fdisp1,1).'</td>';
}

echo '<td>'.$posttimeodds.'</td>';
//$somefig1=($clss+$pce+$fit)/3;
$somefig1=((($clss+$pce+$fit)/3)-$posttimeodds+(max($clss+$pce+$fit)*2));
//$razzledazzle=$somefig1+(round($fdisp1,1)*1)-($posttimeodds*2);
$razzledazzle=$somefig1;
if ($speedfigureavg ==0){
	 $razzledazzle=0;
}
		   echo '<td>'.round($razzledazzle).'</td>';

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
				//"ordering": false,
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
