<!-- This is calcs.php for customer use -->

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ThoroughWIZ QUICK LIST</title>
<link rel="stylesheet" media="screen" href="../assets/css/ui-theme/jquery-ui.min.css" />
<link rel="stylesheet" media="screen" href="../assets/css/dataTables.jqueryui.css" />
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
//Last modified on 4/16/17
// load as file
$xmldata = simplexml_load_file($source);

// format date for header
$headerdate			= $xmldata->racedata[0]->race_date[0];
$headerdate1		= date_create($headerdate);
$headerdate2		= date_format($headerdate1,"M d, Y");

// get full track name from array; pass in abbreviation 
include("switch.php"); // return $trackloc variable with full track name as value

echo '<div id="card-header"><img src="../assets/img/logo-twiz.png" /><h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$trackloc.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
'.$headerdate2.'</h1><a style="float:right;color:#fff;padding:8px;" href="" id="printMe">Print This Card</a><a href="" id="showlegend" style="float:right;color:#fff;padding:8px;">Show/Hide Legend</a></div>';

echo '<div id="legend" style="display:none;"><img src="../img/legend_summary.jpg" /></div>';
// loop time
$i = 0; // set counter for table name
$anchorNum = 0;

// count number of <racedata> nodes in the entire document to get number of races for the jump anchors
$xmlDoc = new DOMDocument();
$xmlDoc->load($source);
$raceNum = $xmlDoc->getElementsByTagName("racedata");
$numOfraces = $raceNum->length;

foreach($xmldata->children() as $racedata) { // gets all <racedata> children of the root element <data>

	// get and format date for each race header
	$formatme1 			= $racedata->race_date;
	$date1				= date_create($formatme1);
	$race_date 			= date_format($date1,"m-d-y");
	$race_date_header 	= date_format($date1,"mdy");
   $equilinkracedate2 	= date_format($date1,"m/d/y");
	$anchorNum 			= $anchorNum + 1;
	
	// for reference:     http://www.equibase.com/static/entry/BEL090614USA-EQB.html#RACE4 (TRACK TODAYSRACEDATE & RACENUMBER)

$tsurf=$racedata->surface;

if ($tsurf<> "T" AND $tsurf<>  "I" AND $tsurf<> "C" AND $tsurf<> "O" ){
$tsurf="D";
} ELSE {
$tsurf="T";
}
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
if($days=17270){
	$days="";
}
	// create table and thead tag and contents
	echo '<hr /><a href="#" id="table'.$i.'" class="filters hideRows">Show only checked rows</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#" id="table'.$i.'" class="filters restoreRows">Restore hidden rows</a><div id="spacer"></div><table class="display table'.$i.'"><thead><th>Pr#</th><th>__</th><th>Name</th><th>m/e</th><th>MLO</th><th>Dys</th><th>Lr</th><th>Jk</th><th>Tr</th><th>Twiz</th></thead>';
	$lines=0;

	// Loop time


foreach($racedata->horsedata as $horsedata) { // gets <horsedata> node

$jockwins	= 0;
$jockplaces	= 0;
$jockstarts	= 0;
$trainerstarts	= 0;
$trainerwins	= 0;
$trainerplaces	= 0;
$horsestarts	= 0;
$horsewins	= 0;
$horseplaces	= 0;
$horseearnings=0;
$horseshows=0;
$apv=0;	
	
			foreach($horsedata->jockey->stats_data->children() as $jockeydata) {
				$jockstarts=$jockstarts+$jockeydata->starts;
				$jockwins=$jockwins+$jockeydata->wins;
                $jockplaces=$jockplaces+$jockeydata->places;

			}
				foreach($horsedata->jockey->stats_data->children() as $stat) {
                if((string) $stat['type'] == 'LAST30'){
                   $jockstarts=$jockstarts+$stat->starts;
				   $jockplaces=$jockplaces+$stat->places;
				   $jockwins=$jockwins+$stat->wins;                  
                }
			}
			foreach ($horsedata->trainer->stats_data->children() as $trainerdata) {
				$trainerstarts=$trainerstarts+$trainerdata->starts;
				$trainerwins=$trainerwins+$trainerdata->wins;
                $trainerplaces=$trainerplaces+$trainerdata->places;

			}
			foreach($horsedata->trainer->stats_data->children() as $stat) {
                if((string) $stat['type'] == 'LAST30'){
                   $trainerstarts=$trainerstarts+$stat->starts;
				   $trainerplaces=$trainerplaces+$stat->places;
				   $trainerwins=$trainerwins+$stat->wins;                  
                }
			}

			foreach ($horsedata->stats_data->children() as $newhorsedata) {
				$horsestarts=$horsestarts+$newhorsedata->starts;
				$horsewins=$horsewins+$newhorsedata->wins;
                $horseplaces=$horseplaces+$newhorsedata->places;
				$horseshows=$horseshows+$newhorsedata->shows;
				$horseearnings=$horseearnings+$newhorsedata->earnings;

			}
			
			foreach($horsedata->stats_data->stat as $stat) {
                if((string) $stat['type'] == 'THIS_YEAR'){
                   $tystarts=$tystarts+$stat->starts;
				   $tyshows=$tyshows+$stat->shows;
				   $tywins=$tywins+$stat->wins;
				   $tyearnings=$tyearnings+$stat->earnings;                  
                }
			}
				foreach($horsedata->stats_data->stat as $stat) {
                if((string) $stat['type'] == 'LAST_YEAR'){
                 $lystarts=$lystarts+$stat->starts;
				   $lyshows=$lyshows+$stat->shows;
				   $lywins=$lywins+$stat->wins;
				   $lyearnings=$lyearnings+$stat->earnings; 
				   }
			}
			
			$tstarts=$tystarts;
			$tshows=$tyshows;
			$tearnings=$tyearnings;
			$twins=$tywins;
			
			if ($tystarts <6){
				$tstarts=$tystarts+$lystarts;
				$tshows=$tyshows+$lyshows;
				$tearnings=$tyearnings+$lyearnings;
				$twins=$tywins+$lywins;
			}
	if(($twins-$tshows)<=0)	{
$twins=2;
$tshows=1;
	}		
		$apv=$tearnings/($twins-$tshows);	
		
		
$apv=$apv/10000;
if($jockstarts<=0){
	$jockstarts=1;
}
if($trainerstarts<=0){
	$trainerstarts=1;
}
if($horsestarts<=0){
	$horsestarts=1;
}

			$jockperc			= ((($jockwins+$jockplaces)/2)/$jockstarts)*100;
			$trainerperc		= ((($trainerwins+$trainerplaces)/2)/$trainerstarts)*100;
            $horseperc			= ((($horsewins+$horseplaces)/2)/$horsestarts)*100;
			$connections		= ($jockperc+$trainerperc)/2;

			$classratingvalue 		= 0;
			$pacefigurevalue 		= 0;
			$pacefigure2value 		= 0;
			$speedfigurevalue 		= 0;

			$classrating_flag 		= 0;
			$pacefigure_flag	 	= 0;
			$pacefigure2_flag 		= 0;
			$speedfigure_flag 		= 0;
	
			$total_a 				= 0;
			$total_b 				= 0;
			$total_c 				= 0;
			$total_d 				= 0;
			$total_e				= 0;
		
			// get and calculate dollar amount instead of odds
			$mornodds 		= (explode("/",$horsedata->morn_odds,2));
			$dollarvalue 	= $mornodds[0] / $mornodds[1];
			
			//http://www.equibase.com/premium/eqbPDFChartPlus.cfm?RACE=11&BorP=P&TID=AQU&CTRY=USA&DT=04/06/2013&DAY=D&STYLE=EQB
			
	$weighttoday=$horsedata->weight;
		
			// get and format last race data for equibase link

	
		// get and format last race data for equibase link
			$formatme2			= $horsedata->ppdata[0]->racedate[0];
			$date2				= date_create($formatme2);
			$equilinkracedate 	= date_format($date2,"m/d/y");
			if(isset($horsedata->ppdata[0])){
			$equilink = "<a href='http://www.equibase.com/premium/eqbPDFChartPlus.cfm?RACE=".$horsedata->ppdata[0]->racenumber[0]."&BorP=P&TID=".$horsedata->ppdata[$uu]->trackcode[0]."&CTRY=".$horsedata->ppdata[$uu]->country[0]."&DT=".$equilinkracedate."&DAY=D&STYLE=EQB' target='_blank'>".$equilinkracedate."</a>";
			}else{
			$equilink = "";	
			}
	$scr="";
if($horsedata->ppdata->positionfi[0] <=0 or $horsedata->ppdata->positionfi[0] >=50 or $horsedata->ppdata->positionfi[0] ="" ){
	$scr="S";
}
if ($equilink==""){
	$scr="";
}
		$strj = $horsedata->jockey->jock_disp;
			$strt = $horsedata->trainer->tran_disp;
$meds=$horsedata->med;
$blinks=$horsedata->equip;
//$tsire=$horsedata->sire->tmmark;
$aelg=$horsedata->ae_flag;
$workperc=50;
$raceperc=50;
$workperc=(100-( ($horsedata->workoutdata->ranking[0]/$horsedata->workoutdata->rank_group[0])*100))+($horsedata->workoutdata->rank_group[0]/10);
if($horsedata->workoutdata->ranking[0] == $horsedata->workoutdata->rank_group[0]){
$workperc=50;
}
if($horsedata->workoutdata->rank_group[0] == 1){
$workperc=50;
}
$norace=$horsedata->ppdata[0]->fieldsize[0];
if($norace<=0){
	$norace=1;
}
$raceperc=(100-( ($horsedata->ppdata[0]->positionfi[0]/$norace)*100))+($horsedata->ppdata[0]->fieldsize[0]/10);	
if($raceperc == 100){
$raceperc=0;
}

			// create partial table rows; continued on line 189
$days = (strtotime($formatme1) - strtotime($formatme2)) / (60 * 60 * 24);

$wkdays=$horsedata->workoutdata->days_back[0];
$cw="";
if($wkdays=="" or $wkdays<=0){
	$wkdays=0;
}
if($days>=1000){
	$days=$wkdays;
	$cw="w";
}
$days = round($days);
			echo '<tr><td>'.$horsedata->program.'</td><td><input type="checkbox" class="check" /><td>'.$horsedata->horse_name.' ('.$weighttoday.') '.'</td><td>'.$meds.'|'.$blinks.'|'.$aelg.'|'.$scr.'</td><td>'.money_format("$%i", $dollarvalue).'</td><td>'.$days.$cw.'</td><td>'.$equilink.'</td><td>'.$strj.'</td><td>'.$strt.'</td>';
			$todaysclass = $racedata->todays_cls;

$early=0;
$quarter=0;
$half=0;
$middle=0;
$stretch=0;
$end=0;
$finish1=0;
$fdisp=0;
$qdisp=0;
$hdisp=0;
$mdisp=0;
$sdisp=0;
$posttimeodds=0;
$finish =0;
$comment="null";
$lastclass=900;	
		
foreach($horsedata->ppdata as $ppdata) { // gets <ppdata> node

$posttimeodds		= (int)($posttimeodds+$ppdata->posttimeod);
if($posttimeodds <=0 OR ""){
	goto b;
}

	// get and calculate

$finish = (int)($ppdata->positionfi); // Value will be a 0 or higher integer
if ($finish <= 0 OR $finish >= 99){ // if position is equal to '0'
goto b;
}

$distof				=($ppdata->distance)/100;
$todaysdist			=($racedata->distance)/100;
settype($distof, "integer");
settype($todaysdist, "integer");
if ($distof < ($todaysdist-2) AND $distof > ($todaysdist+1.5)  ){
goto b;
}

$surface=$ppdata->courseid;
if ($surface<> "T" AND $surface<> "I" AND $surface<>"C" AND $surface<>"O"){
$surface="D";
} ELSE {
$surface="T";
}
if($ppdata->pulledofft <> 0){
$surface="D";
}

if ($surface<>$tsurf){
goto b;
}

if ($ppdata->trackcondi <> "FM" and $ppdata->trackcondi <> "FT" ){
	goto b;
}

$speedfigurevalue 		= $ppdata->speedfigur;
if ($speedfigurevalue <=0 OR $speedfigurevalue >=200){
	goto b;
}
if ($lines <0 OR $lines >=5 ){
	goto b;
}			
			$classratingvalue 		= $ppdata->classratin; //ADDED
			$pacefigurevalue 		= $ppdata->pacefigure; //ADDED
			$pacefigure2value 		= $ppdata->pacefigur2; //ADDED
            $foreign                = $ppdata->foreignspe;
			$surfacevalue 			= $ppdata->surface;
			$turffigurevalue 		= $ppdata->turffigure; //ADDED

//added this line
$foreign = $foreign -10;

if($comment <>"null" ){
$comment=$comment;
}ELSE{
$comment=$horsedata->ppdata->shortcomme;
}

if ($foreign > 0){
$speedfigurevalue=$foreign-20;
}

if ($pacefigurevalue < 1){
$pacefigurevalue =$speedfigurevalue;
}
if ($pacefigure2value < 1){
$pacefigure2value =$speedfigurevalue;
}

if($pacefigureavg < $speedfigureavg/2){
$pacefigureavg=$speedfigureavg;
}

if($pacefigure2avg < $speedfigureavg/2){
$pacefigure2avg=$speedfigureavg;
}

//distance surface penalties

$todaysdist			=(int)($racedata->distance)/100;

$distof				=($ppdata->distance)/100;
$surface=$ppdata->courseid;
if ($surface<> "T" AND $surface<> "I" AND $surface<>"C" AND $surface<>"O" ){
$surface="D";
} ELSE {
$surface="T";
}
if($ppdata->pulledofft <> 0){
$surface="D";
}
$todaysdist			=(int)($racedata->distance)/100;
$distof				=(int)$distof;


				$a = $classratingvalue ;
				$classrating_flag++;			
		
				$b = $pacefigurevalue;
				$pacefigure_flag++;
			
				$c = $pacefigure2value;	
				$pacefigure2_flag++;
							 
				$d = $speedfigurevalue;	
				$speedfigure_flag++;
			
			$total_a += $a; // class rating
			$total_b += $b; // pace1
			$total_c += $c; // pace2
			$total_d += $d; // speed figure

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



// quarter
$quarter = $quarter+(($qlb+intval($ppdata->position1))/2);
$qdisp=      $qdisp-(($qlb+intval($ppdata->position1))/2);
// half
$half = $half+(($hlb+intval($ppdata->position2))/2);
$hdisp=$hdisp-(($hlb+intval($ppdata->position2))/2);
// stretch
$stretch = $stretch +(($slb+intval($ppdata->positionst))/2);
$sdisp=$sdisp-(($slb+intval($ppdata->positionst))/2);
// finish
$finish1 = $finish1+(($flb+intval($ppdata->positionfi))/2); 
$fdisp=$fdisp-(($flb+intval($ppdata->positionfi))/2);

$lines=$lines+1;

b:
} // end $horsedata as $ppdata loop

if ($speedfigure_flag<=0){
	$speedfigure_flag=1;
}
if ($classrating_flag<=0){
	$classrating_flag=1;
}
if ($pacefigure_flag<=0){
	$pacefigure_flag=1;
}
if ($pacefigure2_flag<=0){
	$pacefigure2_flag=1;
}

			$posttimeoddsavg = (($posttimeodds/ $speedfigure_flag)/1)*1;

			$classratingavg 	= (($total_a / $classrating_flag)/1)*1;
			$pacefigureavg	 	= (($total_b / $pacefigure_flag)/1)*1;
			$pacefigure2avg 	= (($total_c / $pacefigure2_flag)/1)*1;
			$speedfigureavg 	= (($total_d / $speedfigure_flag)/1)*1;

$pacefigureavg=(($pacefigureavg*2)+$pacefigure2avg)/3;
$pacefigure2avg=(($pacefigure2avg*2)+$pacefigureavg)/3;

$speedfigureavg = $speedfigureavg+($classratingavg-$todaysclass);
$averagepace = ($pacefigureavg+$pacefigure2avg)/2 ;
$printpace=max($pacefigureavg,$pacefigure2avg);


			$latep=$pacefigure2avg-$pacefigureavg;
if ($latep<0){
$latep=0;
}

$jockperc=90+$jockperc;
$trainerperc=90+$trainerperc;
$horseperc=90+$horseperc;

$never="";
if ($classratingavg <= 0){
	$never="<B>!</b>";
}
 if($pacefigureavg <=0){
	$pacefigureavg=0;
	$pacefigure2avg=0;
}             

$form=$weighttoday-$dollarvalue;
if ($jockperc>125){
$form=$form+1;
}
if ($trainerperc>125){
$form=$form+1;
}
if ($jockperc<110){
$form=$form-1;
}
if ($trainerperc<110){
$form=$form-1;
}

if ($finish >0 AND $finish<3){
	$form=$form+1;
}

if (($horsedata->workoutdata->days_back[0] < 14) AND ($horsedata->workoutdata->ranking[0] <3)){
$form=$form+1;
}
if (($horsedata->workoutdata->days_back[0] < 7) AND ($horsedata->workoutdata->ranking[0] <2)){
$form=$form+1;
}
if ($horsedata->med <>'N'){
	$form=$form+1;
}
if($horsedata->equip <> ''){
	$form=$form+1;
}
if($quarter<=0){
	$quarter=$quarter+20;
}
if($half<=0){
	$half=$half+20;
}
if($stretch<=0){
	$stretch=$stretch+20;
}
if($finish1<=0){
	$finish1=$finish1+20;
}

$early=(100-(((intval($quarter)/$speedfigure_flag)*10)));
if($early==100){
	$early=0;
}
$qdisp=$qdisp/$speedfigure_flag;
$middle=(100-(((intval($half)/$speedfigure_flag)*10)));
if($middle==100){
	$middle=0;
}
$hdisp=$hdisp/$speedfigure_flag;

$end=(100-(((intval($stretch)/$speedfigure_flag)*10)));
if($end==100){
	$end=0;
}


$finish2=(100-(((intval($finish1)/$speedfigure_flag)*10)));
if($finish2==100){
	$finish2=0;
}


$qdisp=$early;
$hdisp=$middle;
$sdisp=$end;
$fdisp=$finish2;

$hdisp=$hdisp+($hdisp-$qdisp);
$sdisp=$sdisp+($sdisp-$hdisp);
$fdisp=$fdisp+($fdisp-$sdisp);

$maxperc=(max($jockperc,$trainerperc,$horseperc))*2;
$maxcon=max($jockperc,$trainerperc)+$connections;
$horseperc=$horseperc+$form;
$con=max($trainerperc,$jockperc);
$clss=max($horseperc,$classratingavg);



if($fdisp<=0){
	$fdisp=$sdisp;
}
if($sdisp<=0){
	$sdisp=$hdisp;
	$fdisp=$hdisp;
}
if($hdisp<=0){
	$hdisp=$qdisp;
	$sdisp=$qdisp;
	$fdisp=$qdisp;
}

if($qdisp<=0){
	$qdisp=0;
	$hdisp=0;
	$sdisp=0;
	$fdisp=0;
}


$erly=max($qdisp,$hdisp);
$ltte=max($sdisp,$fdisp);
$pce=max($erly,$ltte);

$fit=0;

if($wkdays <= $days){
$fit=$workperc;
}
if($wkdays >= $days){
$fit=$raceperc;
}
if($fit<=0){
	$fit=$pce;
}
if ($raceperc < $fit){
	$fit=$raceperc;
}
if($qdisp<=0 AND $speedfigureavg<=0){
	$pacefigureavg=0;
	$pacefigure2avg=0;
	$qdisp=0;
		$hdisp=0;
		$sdisp=0;
		$fdisp=$fit;
	$pce=50;
}

$speed=max($fit,$speedfigureavg);

if ($days<=$wkdays){
	$daysperc=$days/4;
}
if ($wkdays<=$days){
	$daysperc=$wkdays;
}

$mod=($raceperc+$workperc+$trainerperc+$jockperc+$horseperc+$classratingavg+$qdisp+$hdisp+$sdisp+$fdisp)/10;
$mod=($mod+max($raceperc,$workperc,$trainerperc,$jockperc,$horseperc,$classratingavg,$qdisp,$hdisp,$sdisp,$fdisp))/2;
$somefig1=((max($con,$clss)+($apv+$pce+$fit)-($daysperc/2)-($posttimeoddsavg/10))*2.5)/9;
$somefig1=($somefig1+($mod))/2;
$bon=($con+$clss+$pce+$speed)-($daysperc+$posttimeoddsavg+$dollarvalue);
$somefig1=($somefig1+$bon)/2;
$somefig1=$somefig1/1;
echo '<td>'.number_format($somefig1, 2, '.', '').' '.$never.'</td></tr>';

		 $lines=0;



	} // end $racedata as $horsedata loop
		
	echo '</table>';


	$i++; // increment our counter

} // end $xmldata as $racedata loop

?>

<script src="../assets/js/jquery-1.11.1.js"></script>
<script src="../assets/js/jquery.dataTables.min.js"></script>
<script src="../assets/js/dataTables.jqueryui.js"></script>
<script src="../assets/js/natural.js"></script>

<script>
$(document).ready(function(){
		  $('table.display').dataTable({
				"retrieve": true,
				"paging": false,
				//"ordering": false,
				"info": false,
				"bFilter": false,
				"order": [[ 9, "des" ]],
				columnDefs: [
					{ type: 'natural', targets: 0 },
					{ type: 'natural', targets: 2 },
				]
			});
});
</script>

<script>
$(document).ready(function(){
	$(".hideRows").click(function(e){e.preventDefault();
		var target = $(this).prop('id');
		target = '.' + target;
		$(target).find('input[type="checkbox"]').each(function () {
		   if ($(this).prop('checked')!=true) {
			 $(this).parent().parent().hide();  
		   };
		});
	});
	$(".restoreRows").click(function(e){e.preventDefault();
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
