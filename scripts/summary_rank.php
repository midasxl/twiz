<!-- This is calcs.php for customer use -->

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Thoroughwiz Sheet</title>
<!--
To have DataTables styled in the same manner as other jQuery UI widgets, all you need to do, as well as including the DataTables core Javascript file on your page, is include the DataTables / jQuery UI CSS and Javascript integration files.
-->
<link rel="stylesheet" media="screen" href="../assets/css/ui-theme/jquery-ui.min.css" /><!-- jquery theme -->
<link rel="stylesheet" media="screen" href="../assets/css/dataTables.jqueryui.css" /><!-- datatables css integration file -->
<link rel="stylesheet" media="screen" href="../assets/css/tabletools/tabletools.css" /><!-- datatools css integration file -->
<style>
body, html{font-size:12px;}
.clear{clear:both;}
#card-header{background:#4f7c39 url(../img/card-bg.jpg) repeat-x top left;width:100%;padding-bottom:15px;overflow:auto;}
#card-header img{float:left;position:relative;top:12px;left:15px;}
#card-header h1{color:#fff;float:left;position:relative;left:15px;}
a{color:#333}
a:hover{color:#999}
a.head-anchor{color:#fff;}
a.head-anchor:hover{color:#CCC;}
a.equi{float:right;position:relative;top:10px;right:15px;}
#spacer{
	height:8px;	
}
a.filters{padding:5px;}
.title{
	padding:8px 0px 8px 8px;
	width:99.5%;
	float:left;
	background-color:#666;
	color:white;
	margin:5px 0px;
	}
h3{margin:0;padding:0;}
h3.r-data{float:left;}
h3.p-time{float:right;position:relative;left:-8px;}
</style>
	<script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-54918221-1', 'auto');
      ga('send', 'pageview');
    </script>
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
	<a  class="r-data" href= "http://theturfclub.yolasite.com/the-lobby.php" target="_blank"> The TURF CLUB (Free Programs) </a> :

	
	</p>';
	
	echo '<p>Jump to race:&nbsp;&nbsp;';
	
	for ($x = 1; $x <= $numOfraces; $x++) {
    	echo "<a href='#".$x."'>".$x."</a>&nbsp;&nbsp;";
	} 
	
	echo '</p></div>';

// create table and thead tag and contents
	echo '<table border="2" style="background-color:#FFFFCC;border-collapse:collapse;border:2px solid #000000;color:#000000;width:100%" cellpadding="1" cellspacing="1">';
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
			
			foreach($horsedata->jockey->stats_data->stat as $jockeydata) {
				$jockstarts=$jockstarts+$jockeydata->starts;
				$jockwins=$jockwins+$jockeydata->wins;
                                $jockplaces=$jockplaces+$jockeydata->places;

			}
				
			foreach ($horsedata->trainer->stats_data->stat as $trainerdata) {
				$trainerstarts=$trainerstarts+$trainerdata->starts;
				$trainerwins=$trainerwins+$trainerdata->wins;
                                $trainerplaces=$trainerplaces+$trainerdata->places;

			}

			foreach ($horsedata->stats_data->stat as $newhorsedata) {
				$horsestarts=$horsestarts+$newhorsedata->starts;
				$horsewins=$horsewins+$newhorsedata->wins;
                                $horseplaces=$horseplaces+$newhorsedata->places;

			}
			

			$jockperc			= ((($jockwins+$jockplaces)/2)/$jockstarts)*100;
			$trainerperc		        = ((($trainerwins+$trainerplaces)/2)/$trainerstarts)*100;
                        $horseperc		        = ((($horsewins+$horseplaces)/2)/$horsestarts)*100;

                     
			

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
			$formatme2			= $horsedata->ppdata[0]->racedate[0];
			$date2				= date_create($formatme2);
			$equilinkracedate 	= date_format($date2,"m/d/y");
			if(isset($horsedata->ppdata[0])){
			$equilink = "<a href='http://www.equibase.com/premium/eqbPDFChartPlus.cfm?RACE=".$horsedata->ppdata[0]->racenumber[0]."&BorP=P&TID=".$horsedata->ppdata[0]->trackcode[0]."&CTRY=".$horsedata->ppdata[0]->country[0]."&DT=".$equilinkracedate."&DAY=D&STYLE=EQB' target='_blank'>".$equilinkracedate."</a>";
			}else{
			$equilink = "";	
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
$raceperc=(100-( ($horsedata->ppdata[0]->positionfi[0]/$horsedata->ppdata[0]->fieldsize[0])*100))+($horsedata->ppdata[0]->fieldsize[0]/10);	
if($raceperc == 100){
$raceperc=0;
}

			// create partial table rows; continued on line 189
$days = (strtotime($formatme1) - strtotime($formatme2)) / (60 * 60 * 24);

if($days == 17139){
$days=10000;
}

$days = round($days);

			//echo '<tr><td>'.$horsedata->program.'</td><td><input type="checkbox" class="check" /><td>'.$horsedata->horse_name.' ('.$weighttoday.') '.'</td><td>'.$meds."|".$blinks."|".$aelg.'</td><td>'.money_format("$%i", $dollarvalue).'</td><td>'.$days.'</td><td>'.$equilink.'</td><td>'.number_format($raceperc, 0, '.', '').'</td><td>'.$horsedata->workoutdata->days_back[0].'</td><td>'.$horsedata->workoutdata->worktext.', '.$horsedata->workoutdata->ranking.'/'.$horsedata->workoutdata->rank_group.'</td><td>'.number_format($workperc, 0, '.', '').'</td>';
			$todaysclass = $racedata->todays_cls;

// $bestrw=max($raceperc,$workperc);
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





$posttimeodds		= $posttimeodds+$ppdata->posttimeod;
	// get and calculate


//if($lines > 3 AND $lines<> 0) {
//goto b;
//}

$finish = $ppdata->positionfi; // Value will be a 0 or higher integer
if ($finish == 0){ // if position is equal to '0'
goto b;
}



			
			$classratingvalue 		= $ppdata->classratin; //ADDED
			$pacefigurevalue 		= $ppdata->pacefigure; //ADDED
			$pacefigure2value 		= $ppdata->pacefigur2; //ADDED
			$speedfigurevalue 		= $ppdata->speedfigur; //ADDED
                        $foreign                        = $ppdata->foreignspe;
			$surfacevalue 			= $ppdata->surface;
			$turffigurevalue 		= $ppdata->turffigure; //ADDED
			


//added this line
$foreign = $foreign -10;



if ($finish > 4 ){
$finish=$finish;
}ELSE{
$finish =$horsedata->ppdata->positionfi; 
}
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



if ($todaysdist < ($distof-1) or $todaysdist > ($distof+1)) {
$pacefigurevalue=$pacefigurevalue-1;
$pacefigure2value=$pacefigure2value-1;
$speedfigurevalue=$speedfigurevalue-1;
} 

if ($surface<>$tsurf){
$pacefigurevalue=$pacefigurevalue-1;
$pacefigure2value=$pacefigure2value-1;
$speedfigurevalue=$speedfigurevalue-1;
}

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
$qdisp=      $qdisp+($classratingvalue+10)-(($qlb+intval($ppdata->position1))/2);
// half
$half = $half+(($hlb+intval($ppdata->position2))/2);
$hdisp=$hdisp+($classratingvalue+10)-(($hlb+intval($ppdata->position2))/2);
// stretch
$stretch = $stretch +(($slb+intval($ppdata->positionst))/2);
$sdisp=$sdisp+($classratingvalue+10)-(($slb+intval($ppdata->positionst))/2);
// finish
$finish1 = $finish1+(($flb+intval($ppdata->positionfi))/2); 
$fdisp=$fdisp+($classratingvalue+10)-(($flb+intval($ppdata->positionfi))/2);



$lines=$lines+1;

b:
} // end $horsedata as $ppdata loop



		

			$posttimeoddsavg = (($posttimeodds/ $speedfigure_flag)/1)*1;

			$classratingavg 	= (($total_a / $classrating_flag)/1)*1;
			$pacefigureavg	 	= (($total_b / $pacefigure_flag)/1)*1;
			$pacefigure2avg 	= (($total_c / $pacefigure2_flag)/1)*1;
			$speedfigureavg 	= (($total_d / $speedfigure_flag)/1)*1;




$speedfigureavg = $speedfigureavg+($classratingavg-$todaysclass);
$averagepace = ($pacefigureavg+$pacefigure2avg)/2 ;
$printpace=max($pacefigureavg,$pacefigure2avg);


			$latep=$pacefigure2avg-$pacefigureavg;
if ($latep<0){
$latep=0;
}


$jockperc=100+$jockperc;
$trainerperc=100+$trainerperc;
$horseperc=100+$horseperc;
$jockperc=($jockperc+$classratingavg)/2;
$trainerperc=($trainerperc+$classratingavg)/2;
$horseperc=($horseperc+$classratingavg)/2;

//echo '<td>'.number_format($jockperc, 0, '.', '').'</td>';
//echo '<td>'.number_format($trainerperc, 0, '.', '').'</td>';
//echo '<td>'.number_format($horseperc, 0, '.', '').'</td>';
//echo '<td>'.round($classratingavg).'</td>';
 
                 
			if ($classratingavg <= 0){
				//echo '<td>0</td>';

			}else{
			if ($todaysclass <= $classratingavg){
					//echo '<td><strong>'.round($classratingavg).'</strong></td>';
					}else{
					//echo '<td>'.round($classratingavg).'</td>';
					}
			}
					
			if ($pacefigureavg <= 0){
				//echo '<td>0</td>';

			}else{
			if ($todaysclass <= $averagepace){		
					//echo '<td><strong>'.round($jockperc).'</strong></td>';
                                       
					}else{
					//echo '<td>'.round($jockperc).'</td>';
                                     
					}
			}
				
if ($pacefigure2avg <= 0){
				//echo '<td>0</td>';

			}else{
			if ($todaysclass <= $averagepace){		
					
                                        //echo '<td><strong>'.round($trainerperc).'</strong></td>';
					}else{
					
                                       // echo '<td>'.round($trainerperc).'</td>';
					}
			}
//echo '<td>'.round($classratingavg).'</td>';
			if ($speedfigureavg <= 0){
				//echo '<td>0</td>';

			}else{
			if ($todaysclass <= $speedfigureavg){	
					//echo '<td><strong>'.round($speedfigureavg).'</strong></td>';
					}else{
					//echo '<td>'.round($speedfigureavg).'</td>';
					}
			}
			
$todaysdist			=(int)($racedata->distance)/100;
$adds=10;
$addr=10;

if ($todaysdist<7){
$a = array($classratingavg, $pacefigureavg, $speedfigureavg);
$adds=0;
}

if ($todaysdist>=7){
$a = array($pacefigureavg,$pacefigure2avg, $speedfigureavg);
$addr=0;
}


//$a = array($classratingavg, $pacefigureavg,$pacefigure2avg, $speedfigureavg);
natsort($a);
$a=array_reverse($a);


//arsort($a);

$sorta=($a[0]+$a[1]);
$sorta=($sorta-$posttimeoddsavg)/2;
//if ($latep <=0){
//$latep=0;
//}

if ($todaysdist<8){
$somefig=(($todaysclass+$sorta)/2)+($horseperc+($horseperc/2))+$connections-($dollarvalue*2);
}

if ($todaysdist>=8){
$somefig=(($todaysclass+$sorta)/2)+$connections+($horseperc+($horseperc/2))+($latep*5)-($dollarvalue*2);
}
//$somefig=(($todaysclass+$sorta)/2)+$horseperc+$connections+$latep-($dollarvalue*2);

$form=$weighttoday-$dollarvalue;
if ($jockperc>25){
$form=$form+1;
}
if ($trainerperc>25){
$form=$form+1;
}
if ($jockperc<10){
$form=$form-1;
}
if ($trainerperc<10){
$form=$form-1;
}
$finish = intval($finish);


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
if($quarter==0){
	$quarter=$quarter+20;
}
if($half==0){
	$half=$half+20;
}
if($stretch==0){
	$stretch=$stretch+20;
}
if($finish1==0){
	$finish1=$finish1+20;
}

$early=(100-(((intval($quarter)/$lines)*10)));
if($early==100){
	$early=$jockperc;
}
$qdisp=$qdisp/$classrating_flag;
$middle=(100-(((intval($half)/$lines)*10)));
if($middle==100){
	$middle=$jockperc;
}
$hdisp=$hdisp/$classrating_flag;
//$hdisp=((($classratingavg+$horseperc)/2)-(($hdisp/$lines)*10))+$adds;
$end=(100-(((intval($stretch)/$lines)*10)));
if($end==100){
	$end=$jockperc;
}
$sdisp=$sdisp/$classrating_flag;
//$sdisp=((($classratingavg+$horseperc)/2)-(($sdisp/$lines)*10))+$adds;
$finish2=(100-(((intval($finish1)/$lines)*10)));
if($finish2==100){
	$finish2=$jockperc;
}
$fdisp=$fdisp/$classrating_flag;
//$fdisp=((($classratingavg+$horseperc)/2)-(($fdisp/$lines)*10))+$adds;
$qdisp1=(((150-$classratingavg)/10)+((($ppdata->position1*100)/$ppdata->fieldsize)+$ppdata->lenback1)/100)/2;
$hdisp1=(((150-$classratingavg)/10)+((($ppdata->position2*100)/$ppdata->fieldsize)+$ppdata->lenback2)/100)/2;
$sdisp1=(((150-$classratingavg)/10)+((($ppdata->positionst*100)/$ppdata->fieldsize)+$ppdata->lenbackstr)/100)/2;

if ($ppdata->positionfi==0){
$ppdata->lenbackfin=0;
}
$fdisp1=(((150-$classratingavg)/10)+((($ppdata->positionfi*100)/$ppdata->fieldsize)+$ppdata->lenbackfin)/100)/2;

$qdisp=$early;//$qdisp;//-$qdisp1;
$hdisp=$middle;//$hdisp;//-$hdisp1;
$sdisp=$end;//$sdisp;//-$sdisp1;
$fdisp=$finish2;//$fdisp;//-$fdisp1;

$maxperc=(max($jockperc,$trainerperc,$horseperc))*2;
$maxcon=max($jockperc,$trainerperc)+$connections;
$somefig=($somefig+max($early,$middle,$end,$finish2)+$maxcon-($dollarvalue/2));  /////PLAY WITH THIS IDEA
$somefig=($somefig)/5;
$somefig=(($somefig+(($qdisp+$hdisp+$sdisp+$fdisp)/4))/2)+$maxperc;
$somefig=$somefig/3;		

$con=max($trainerperc,$jockperc);
$clss=max($horseperc,$classratingavg);
$erly=max($qdisp,$hdisp);

$ltte=max($sdisp,$hdisp);
$pce=max($erly,$ltte);

$bon=max($somefig,$con,$clss,$pce,$fdisp);
$fit=0;
$somefig1=($erly+$ltte+$fdisp+$con+$horseperc+$classratingavg)/6;
if($horsedata->workoutdata->days_back[0] < $days){
$fit=$workperc;
}
if($horsedata->workoutdata->days_back[0] > $days){
$fit=$raceperc;
}
if ($workperc < $raceperc){
$fit=$raceperc;
}
if ($fit =50){
$fit=$raceperc;
}
if ($raceperc < $workperc){
$fit=$workperc;
}
//$somefig1=($somefig1+$fit)/2;
//$somefig1=(($somefig1*3)-$ppdata->posttimeod[0])/3;

$somefig1=($somefig+$con+$fdisp+$clss+$pce+$bon+$fit)/7;
$somefig1=((($somefig1+$racedata->todays_cls)/2)+7)-($dollarvalue/7);
//echo '<td>'.number_format($qdisp, 0, '.', '')."</td><td>".number_format($hdisp, 0, '.', '')."</td><td>".number_format($sdisp, 0, '.', '')."</td><td>".number_format($fdisp, 0, '.', '').'</td><td>'.number_format($somefig1, 1, '.', '').'</td></tr>';

		 $lines=0;


$programnum=$horsedata->program;
	$oddsline=$dollarvalue;
			$data[] = array('post' => '<B>'.$programnum.'</b>', 'twiza' => round($somefig1,1));
			$data1[] = array('post1' => '<B>'.$programnum.'</b>', 'classa' => round($classratingavg,0));
			$data2[] = array('post2' => '<B>'.$programnum.'</b>', 'speeda' => round($speedfigureavg,0));
			$data3[] = array('post3' => '<B>'.$programnum.'</b>', 'pacea' => round($hdisp,0));
			$data4[] = array('post4' => '<B>'.$programnum.'</b>', 'latea' => round($fdisp,0));
			$data5[] = array('post5' => '<B>'.$programnum.'</b>', 'mloddsa' => round($oddsline,1));
			$data6[] = array('post6' => '<B>'.$programnum.'</b>', 'forma' => round($sdisp,0));
			$data7[] = array('post7' => '<B>'.$programnum.'</b>', 'trainera' => round($trainerperc,0));
			$data8[] = array('post8' => '<B>'.$programnum.'</b>', 'jockeya' => round($jockperc,0));
			$data9[] = array('post9' => '<B>'.$programnum.'</b>', 'rawa' => round($qdisp,0));
			$data10[] = array('post10' => '<B>'.$programnum.'</b>', 'horsea' => round($horseperc,0));
			$data11[] = array('post11' => '<B>'.$programnum.'</b>', 'gaina' => round($workperc,0));
			
		
		
	} // end $racedata as $horsedata loop	


foreach ($data as $key => $row) {
    $twiza[$key]  = $row['twiza'];
    $post[$key] = $row['post'];
}
foreach ($data1 as $key1 => $row1) {
    $classa[$key1]  = $row1['classa'];
    $post1[$key1] = $row1['post1'];
}
foreach ($data2 as $key2 => $row2) {
    $speeda[$key2]  = $row2['speeda'];
    $post2[$key2] = $row2['post2'];
}
foreach ($data3 as $key3 => $row3) {
    $pacea[$key3]  = $row3['pacea'];
    $post3[$key3] = $row3['post3'];
}
foreach ($data4 as $key4 => $row4) {
    $latea[$key4]  = $row4['latea'];
    $post4[$key4] = $row4['post4'];
}
foreach ($data5 as $key5 => $row5) {
    $mloddsa[$key5]  = $row5['mloddsa'];
    $post5[$key5] = $row5['post5'];
}
foreach ($data6 as $key6 => $row6) {
    $forma[$key6]  = $row6['forma'];
    $post6[$key6] = $row6['post6'];
}
foreach ($data7 as $key7 => $row7) {
    $trainera[$key7]  = $row7['trainera'];
    $post7[$key7] = $row7['post7'];
}
foreach ($data8 as $key8 => $row8) {
    $jockeya[$key8]  = $row8['jockeya'];
    $post8[$key8] = $row8['post8'];
}
foreach ($data9 as $key9 => $row9) {
    $rawa[$key9]  = $row9['rawa'];
    $post9[$key9] = $row9['post9'];
}
foreach ($data10 as $key10 => $row10) {
    $horsea[$key10]  = $row10['horsea'];
    $post10[$key10] = $row10['post10'];
}
foreach ($data11 as $key11 => $row11) {
    $gaina[$key11]  = $row11['gaina'];
    $post11[$key11] = $row11['post11'];
}

array_multisort($twiza, SORT_DESC, $post, SORT_DESC, $data);
array_multisort($classa, SORT_DESC, $post1, SORT_DESC, $data1);
array_multisort($speeda, SORT_DESC, $post2, SORT_DESC, $data2);
array_multisort($pacea, SORT_DESC, $post3, SORT_DESC, $data3);
array_multisort($latea, SORT_DESC, $post4, SORT_DESC, $data4);
array_multisort($mloddsa, SORT_ASC, $post5, SORT_ASC, $data5);
array_multisort($forma, SORT_DESC, $post6, SORT_DESC, $data6);
array_multisort($trainera, SORT_DESC, $post7, SORT_DESC, $data7);
array_multisort($jockeya, SORT_DESC, $post8, SORT_DESC, $data8);
array_multisort($rawa, SORT_DESC, $post9, SORT_DESC, $data9);
array_multisort($horsea, SORT_DESC, $post10, SORT_DESC, $data10);
array_multisort($gaina, SORT_DESC, $post11, SORT_DESC, $data11);

echo '<tr><td> Mlo </td> ';
foreach ( $data5 as $data5 ) {
  foreach ( $data5 as $key5 => $row5 ) {
    echo '<td> '.$row5.' </td> ';
  // echo '<td> X </td> ';
  }  
}
echo '</tr><tr><td> Wrk </td> ';
foreach ( $data11 as $data11 ) {
  foreach ( $data11 as $key11 => $row11 ) {
    echo '<td> '.$row11.' </td> ';
  // echo '<td> X </td> ';
  }  
}
echo '</tr><tr><td> Jck </td> ';
foreach ( $data8 as $data8 ) {
  foreach ( $data8 as $key8 => $row8 ) {
    echo '<td> '.$row8.' </td> ';
  }  
}
echo '</tr><tr><td> Trn </td> ';
foreach ( $data7 as $data7 ) {
  foreach ( $data7 as $key7 => $row7 ) {
    echo '<td> '.$row7.' </td> ';
  }  
}

echo '</tr><tr><td> Hrs </td> ';
foreach ( $data10 as $data10 ) {
  foreach ( $data10 as $key10 => $row10 ) {
    echo '<td> '.$row10.' </td> ';
  // echo '<td> X </td> ';
  }  
}
echo '</tr><tr><td> Cls </td> ';
foreach ( $data1 as $data1 ) {
  foreach ( $data1 as $key1 => $row1 ) {
    echo '<td> '.$row1.' </td> ';
  }  
}
echo '</tr><tr><td> Spd </td> ';
foreach ( $data2 as $data2 ) {
  foreach ( $data2 as $key2 => $row2 ) {
    echo '<td> '.$row2.' </td> ';
  }  
}
echo '</tr><tr><td> Ear </td> ';
foreach ( $data9 as $data9 ) {
  foreach ( $data9 as $key9 => $row9 ) {
    echo '<td> '.$row9.' </td> ';
  // echo '<td> X </td> ';
  }  
}
echo '</tr><tr><td> EPr </td> ';
foreach ( $data3 as $data3 ) {
  foreach ( $data3 as $key3 => $row3 ) {
    echo '<td> '.$row3.' </td> ';
	//echo '<td> X </td> ';
  }  
}
echo '</tr><tr><td> Prs </td> ';
foreach ( $data6 as $data6 ) {
  foreach ( $data6 as $key6 => $row6 ) {
    echo '<td> '.$row6.' </td> ';
  }  
}
echo '</tr><tr><td> Lat </td> ';
foreach ( $data4 as $data4 ) {
  foreach ( $data4 as $key4 => $row4 ) {
   //if($todaysdist>7.5){
	  echo '<td> '.$row4.' </td> '; //iflong 
   //}else{
	//   echo '<td> X </td> '; //if short
  // }
  }  
}
echo '</tr><tr><td> TWIZ </td> ';
foreach ( $data as $data ) {
  foreach ( $data as $key => $row ) {
    echo '<td> '.$row.' </td> ';
  // echo '<td> X </td> ';
  }  
}







$xx = 0; 

do {
    unset ( $twiza[$key]);
	$twiza[$key]=array();
    unset ( $post[$key]);
	$post[$key]=array();
	unset ( $twiza);
	$twiza=array();
    unset ( $post);
	$post=array();
    unset ($key);
	$key=array();
	unset ($row);
	$row=array();
	unset ($data);
    $data=array();
	
	unset ( $classa[$key1]);
	$classa[$key1]=array();
    unset ( $post1[$key1]);
	$post1[$key1]=array();
	unset ( $classa);
	$classa=array();
    unset ( $post1);
	$post1=array();
    unset ($key1);
	$key1=array();
	unset ($row1);
	$row1=array();
	unset ($data1);
    $data1=array();
	
	unset ( $speeda[$key2]);
	$speeda[$key2]=array();
    unset ( $post2[$key2]);
	$post2[$key2]=array();
	unset ( $speeda);
	$speeda=array();
    unset ( $post2);
	$post2=array();
    unset ($key2);
	$key2=array();
	unset ($row2);
	$row2=array();
	unset ($data2);
    $data2=array();
	
	unset ( $pacea[$key3]);
	$pacea[$key3]=array();
    unset ( $post3[$key3]);
	$post3[$key3]=array();
	unset ( $pacea);
	$pacea=array();
    unset ( $post3);
	$post3=array();
    unset ($key3);
	$key3=array();
	unset ($row3);
	$row3=array();
	unset ($data3);
    $data3=array();
	
	unset ( $latea[$key4]);
	$latea[$key4]=array();
    unset ( $post4[$key4]);
	$post4[$key4]=array();
	unset ( $latea);
	$latea=array();
    unset ( $post4);
	$post4=array();
    unset ($key4);
	$key4=array();
	unset ($row4);
	$row4=array();
	unset ($data4);
    $data4=array();
	
	
	unset ( $forma[$key6]);
	$forma[$key6]=array();
    unset ( $post6[$key6]);
	$post6[$key6]=array();
	unset ( $forma);
	$forma=array();
    unset ( $post6);
	$post6=array();
    unset ($key6);
	$key6=array();
	unset ($row6);
	$row6=array();
	unset ($data6);
    $data6=array();
	
	unset ( $trainera[$key7]);
	$trainera[$key7]=array();
    unset ( $post7[$key7]);
	$post7[$key7]=array();
	unset ( $trainera);
	$trainera=array();
    unset ( $post7);
	$post7=array();
    unset ($key7);
	$key7=array();
	unset ($row7);
	$row7=array();
	unset ($data7);
    $data7=array();
	
	unset ( $jockeya[$key8]);
	$jockeya[$key8]=array();
    unset ( $post8[$key8]);
	$post8[$key8]=array();
	unset ( $jockeya);
	$jockeya=array();
    unset ( $post8);
	$post8=array();
    unset ($key8);
	$key8=array();
	unset ($row8);
	$row8=array();
	unset ($data8);
    $data8=array();
	
	unset ( $rawa[$key9]);
	$rawa[$key9]=array();
    unset ( $post9[$key9]);
	$post9[$key9]=array();
	unset ( $rawa);
	$hclassa=array();
    unset ( $post9);
	$post9=array();
    unset ($key9);
	$key9=array();
	unset ($row9);
	$row9=array();
	unset ($data9);
    $data9=array();
	
	unset ( $mloddsa[$key5]);
	$mloddsa[$key5]=array();
    unset ( $post5[$key5]);
	$post5[$key5]=array();
	unset ( $mloddsa);
	$mloddsa=array();
    unset ( $post5);
	$post5=array();
    unset ($key5);
	$key5=array();
	unset ($row5);
	$row5=array();
	unset ($data5);
    $data5=array();

	unset ( $horsea[$key10]);
	$horsea[$key10]=array();
    unset ( $post10[$key10]);
	$post10[$key10]=array();
	unset ( $horsea);
	$horsea=array();
    unset ( $post10);
	$post10=array();
    unset ($key10);
	$key10=array();
	unset ($row10);
	$row10=array();
	unset ($data10);
    $data10=array();

	unset ( $gaina[$key11]);
	$gaina[$key11]=array();
    unset ( $post11[$key11]);
	$post11[$key11]=array();
	unset ( $gaina);
	$gaina=array();
    unset ( $post11);
	$post11=array();
    unset ($key11);
	$key11=array();
	unset ($row11);
	$row11=array();
	unset ($data11);
    $data11=array();

	
	
    $xx++;
} while ($xx <= 100);

	

		
	echo '</tr></tbody></table><br><HL><br>';
	
	$i++; // increment our counter

    



} // end $xmldata as $racedata loop

?>
<script src="../assets/js/jquery-1.11.1.js"></script><!-- jquery core file -->
<script>
			
			$('#printMe').click(function() {  
				window.print();  
				return false;  
			}); 
	
</script>
</body>
</html>
