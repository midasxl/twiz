<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Scratch sheet</title>
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
    
if (empty($_POST["cardarchive"])) { // if cardarchive is empty (NOT posted), use the uploads directory as the source
        $source = '../../uploads/'.$_POST["card"];
}else{ // cardarchive is NOT empty, so use the archives folder as the source
        $source = '../../archives/'.$_POST["cardarchive"];
        echo '<h3>Archived Sheet</h3>';
}
    
$xmldata = simplexml_load_file($source);

// format date for header
$headerdate			= $xmldata->racedata[0]->race_date[0];
$headerdate1		= date_create($headerdate);
$headerdate2		= date_format($headerdate1,"M d, Y");

// get full track name from array; pass in abbreviation 
include("switch.php"); // return $trackloc variable with full track name as value
echo 'Filter: Pace=ITM Races= Within2F,All tracks,Todays surf';

/*echo '<div id="card-header"><img src="../assets/img/logo-twiz.png" /><h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$trackloc.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
'.$headerdate2.'</h1><a class="head-anchor equi" href="http://www.trackmaster.com/cgi-bin/axprodlist.cgi?tpp" target="_blank">Buy TRACKMASTER Printed PDF</a></div>';*/
echo '<div id="card-header"><img src="../assets/img/logo-twiz.png" /><h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$trackloc.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
'.$headerdate2.'</h1><a style="float:right;color:#fff;padding:8px;" href="" id="printMe">Print This Card</a></div>';

echo '<div id="legend" style="display:none;"><img src="../img/legend_summary.jpg" /></div>';
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


$todaysclass=$racedata->todays_cls;		

// Create each race header

	$aclr = $racedata->race_text;
if (preg_match('/MAIDENS/',$aclr))
    echo '<font color="red">';
if (preg_match('/turf/',$aclr) OR preg_match('/TURF/',$aclr) OR preg_match('/Turf/',$aclr))
    echo '<font color="GREEN">';
if (preg_match('/MAIDENS/',$aclr) AND preg_match('/turf/',$aclr))
	echo '<font color="ORANGE">';

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
<a  class="r-data" href= "http://www.bloodhorse.com/stallion-register/" target="_blank"> Stallion Search </a> :

	</p>';


  if (preg_match('/MAIDENS/',$aclr))
    echo '</font>';
if (preg_match('/turf/',$aclr) OR preg_match('/TURF/',$aclr) OR preg_match('/Turf/',$aclr))
  echo '</font>';
if (preg_match('/MAIDENS/',$aclr) AND preg_match('/turf/',$aclr))
	 echo '</font>';

	echo '<p>Jump to race:&nbsp;&nbsp;';
	
	for ($x = 1; $x <= $numOfraces; $x++) {
    	echo "<a href='#".$x."'>".$x."</a>&nbsp;&nbsp;";
	} 
	
	echo '</p></div>';
if($days=17270){
	$days="";
}
	// create table and thead tag and contents
echo '<hr /><a href="#" id="table'.$i.'" class="filters hideRows">Show only checked rows</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#" id="table'.$i.'" class="filters restoreRows">Restore hidden rows</a><table class="display table'.$i.'">';
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
$horsescount=0;
		$imp=0;
$rr=0;
$r="<B> = </b>";
$r1="";	
$z="";
foreach($racedata->horsedata as $horsedata) { // gets <horsedata> node
$horsescount=$horsescount+1;
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
$horseperc=0;
$jockperc=0;
$raceprc=0;
$trainerperc=0;

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
			
			$tc1=$twins-$tshows;
			$tc2=$twins;
			if($tc1 <=0){
				$tc1=1;
			}
			if($tc2 <= 0){
				$tc2=1;
			}
			
		if($tc1 <= 0){
$apv=$tearnings/$tc2;	
		}else{			
		$apv=$tearnings/$tc1;	
		}
	
		
$apv=$apv/10000;
if($trainerstarts <=0){
	$trainerstarts=1;
}
if($jockstarts <=0){
	$jockstarts=1;
}
if($horsestarts <=0){
	$horsestarts=1;
}
			$jockperc			= ((($jockwins+$jockplaces)/2)/$jockstarts)*100;
			$trainerperc		= ((($trainerwins+$trainerplaces)/2)/$trainerstarts)*100;
            $horseperc			= ((($horsewins+$horseplaces)/2)/$horsestarts)*100;
			$connections		= ($jockperc+$trainerperc)/2;

		
			// get and calculate dollar amount instead of odds
					$mornodds 		= (explode("/",$horsedata->morn_odds,2));
		if($mornodds[1] <=0){
	$dollarvalue 	= $mornodds[0] ;
}else{
	$dollarvalue 	= $mornodds[0] / $mornodds[1];

}
			
			//http://www.equibase.com/premium/eqbPDFChartPlus.cfm?RACE=11&BorP=P&TID=AQU&CTRY=USA&DT=04/06/2013&DAY=D&STYLE=EQB
			
	$weighttoday=$horsedata->weight;
		
			// get and format last race data for equibase link

	
		// get and format last race data for equibase link
			$formatme2			= $horsedata->ppdata[0]->racedate[0];
			$date2				= date_create($formatme2);
			$equilinkracedate 	= date_format($date2,"m/d/y");
			if(isset($horsedata->ppdata[0])){
			$equilink = "<a href='http://www.equibase.com/premium/eqbPDFChartPlus.cfm?RACE=".$horsedata->ppdata[0]->racenumber[0]."&BorP=P&TID=".$horsedata->ppdata[0]->trackcode[0]."&CTRY=".$horsedata->ppdata[0]->country[0]."&DT=".$equilinkracedate."&DAY=D&STYLE=EQB' target='_blank'>".$equilinkracedate."</a>";
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
$rank1=$horsedata->workoutdata->rank_group[0];
if($rank1 <=0){
	$rank1=1;
}
$workperc=(100-( ($horsedata->workoutdata->ranking[0]/$rank1)*100))+($horsedata->workoutdata->rank_group[0]/10);
if($horsedata->workoutdata->ranking[0] == $horsedata->workoutdata->rank_group[0]){
$workperc=50;
}
if($horsedata->workoutdata->rank_group[0] == 1){
$workperc=50;
}
$raceperc=$horsedata->ppdata->speedfigur[0];
$raceperc=(int)($raceperc);


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

$todaysclass = $racedata->todays_cls;

$classrating_flag=0;
			$speedfigure_flag=0;
			$posttime_flag=0;
			$pacefigure_flag=0;
			$pacefigure2_flag=0;
			$total_a=0;
			$total_b=0;
			$total_c=0;
			$total_d=0;
			$total_e=0;
		$abyt3=0;
		$todaysdist			=($racedata->distance)/100;
		$lines2=0;
		$speedr=0;
			$quarter=0;
		$half=0;
		$stretch=0;
		$finish1=0;
		$q=0;
		$h=0;
		$s=0;
		$f=0;
		$qlb=0;
		$hlb=0;
		$slb=0;
		$flb=0;
		$fs=0;
		$s1=0;
		$cl1=0;
		$cl2=0;
		$s2=0;
		$s3=0;
		$s4=0;
		$p1=0;
		$pp1=0;
		$p2=0;
		$pp2=0;
		$p3=0;
		$pp3=0;
		$p4=0;
		$pp4=0;
		$lines=0;

foreach($horsedata->ppdata as $ppdata) { // gets <ppdata> node
$speedr=$ppdata->speedfigur;
$speedr=(int)$speedr;
 $foreign                = $ppdata->foreignspe;
if (($ppdata->foreignspe) > ($foreign = $ppdata->speedfigur)){
	$speedr=$foreign -10;
}
$finishcheck=$ppdata->positionfi;
$distof				=($ppdata->distance)/100;
$surface=$ppdata->courseid;
if ($surface<> "T" AND $surface<> "I" AND $surface<>"C" AND $surface<>"O"){
$surface="D";
} ELSE {
$surface="T";
}
if($ppdata->pulledofft <> 0){
$surface="D";
}
if ( $speedr<=0 OR $speedr >=900){
	goto b;
}
//begin filters

if ($lines >=3){

if ($ppdata->trackcondi <> "FM" and $ppdata->trackcondi <> "FT"){
	goto b;
}

if ($finish <0 OR $finish >((($ppdata->fieldsize)/2)+1)){
	goto b;
}

if($tsurf <> $surface){
	goto b;
}
if($distof < ($todaysdist-3) OR $distof > ($todaysdist+2)){
	goto b;
}
}
//end filters

$abyt=$ppdata->horsetime2-$ppdata->horsetime1;
$abyt2=$ppdata->horsetimes-$ppdata->horsetime2;
if($abyt2 <= $abyt And $abyt2 >=0){
	$abyt=$abyt2;
}
if ($abyt <=18){
	$abyt=$abyt+$abyt;
}
$abyt3=$abyt3+$abyt;


//Running Style
if($lines>1){
if ($ppdata->trackcondi <> "FM" and $ppdata->trackcondi <> "FT"){
	goto f;
}
if ($finish <0 OR $finish >((($ppdata->fieldsize)/2)+1)){
	goto f;
}
if($tsurf <> $surface){
	goto f;
}

}
if(($ppdata->pacefigure)<=0){
	goto f;
}
$qlb=($ppdata->lenback1)/100;
$hlb=($ppdata->lenback2)/100;
$slb=($ppdata->lenbackstr)/100;
$flb=($ppdata->lenbackfin)/100;
$q=$ppdata->position1;

$h=$ppdata->position2;
$s=$ppdata->positionst;
$f=$ppdata->positionfi;
$qlb=intval($qlb);
$hlb=intval($hlb);
$slb=intval($slb);
$flb=intval($flb);
$q=intval($q);
$s=intval($s);
$h=intval($h);
$f=intval($f);

$fs=$ppdata->positionfi;

// quarter
$quarter = $quarter+($qlb+$q);
$fs=$fs+$fs;
// half
$half = $half+($hlb+$h);

// stretch
$stretch =$stretch +($slb+$s);

// finish
$finish1 = $finish1+($flb+$f);

$lines2=$lines2+1;
f:




$posttimeoddsvalue 	=$ppdata->posttimeod;
		
			$classratingvalue 		= $ppdata->classratin; //ADDED
			$pacefigurevalue 		= $ppdata->pacefigure; //ADDED
			$pacefigure2value 		= $ppdata->pacefigur2; //ADDED
            $foreign                = $ppdata->foreignspe;
			$turffigurevalue 		= $ppdata->turffigure; //ADDED
            $speedfigurevalue 		= $ppdata->speedfigur;
			
 $foreign                = $ppdata->foreignspe;
if (($ppdata->foreignspe) > ($foreign = $ppdata->speedfigur)){
	$speedfigurevalue=$foreign -10;
}

if($comment <>"null" ){
$comment=$comment;
}ELSE{
$comment=$horsedata->ppdata->shortcomme;
}


//distance surface penalties


				$a = $classratingvalue ;
				$classrating_flag++;			
		
				$b = $pacefigurevalue;
				$pacefigure_flag++;
			
				$c = $pacefigure2value;	
				$pacefigure2_flag++;
							 
				$d = $speedfigurevalue;	
				$speedfigure_flag++;
				
				$e = $posttimeoddsvalue;	
				$posttime_flag++;
			
			$total_a += $a; // class rating
			$total_b += $b; // pace1
			$total_c += $c; // pace2
			$total_d += $d; // speed figure
			$total_e += $e;

if ($lines==0){
	$s1=(int)$d;
	$p1=(int)$b;
	$pp1=(int)$c;
	$tt1=$abyt;
	$cl1=(int)$a;
}
if ($lines==1){
$s2=(int)$d;
$p2=(int)$b;
	$pp2=(int)$c;
	$tt2=$abyt;
	$cl2=(int)$a;
}
if ($lines==2){
$s3=(int)$d;
$p3=(int)$b;
	$pp3=(int)$c;
}
if ($lines==3){
$s4=(int)$d;
$p4=(int)$b;
	$pp4=(int)$c;
}

$lines=$lines+1;

b:
} // end $horsedata as $ppdata loop



if($classrating_flag <=0){
	$classrating_flag=1;
}
if($posttime_flag <=0){
	$posttime_flag=1;
}
if($pacefigure_flag <=0){
	$pacefigure_flag=1;
}
if( $pacefigure2_flag <=0){
	 $pacefigure2_flag=1;
}
if($speedfigure_flag <=0){
	$speedfigure_flag=1;
}
if($lines<=0){
	$lines=1;
}

$classratingavg 	= ($total_a / $classrating_flag);


			$posttimeoddsavg    = ($total_e / $posttime_flag);
			$pacefigureavg	 	= ($total_b / $pacefigure_flag);
			$pacefigure2avg 	= ($total_c / $pacefigure2_flag);
			$speedfigureavg 	= ($total_d / $speedfigure_flag);
			$abytavg=$abyt3/$lines;
	
	$posttimeoddsavg +	$posttimeoddsavg *10;
$pacefigureavg3=(($pacefigureavg*2)+$pacefigure2avg)/3;
$pacefigure2avg4=(($pacefigure2avg*2)+$pacefigureavg)/3;


$averagepace = ($pacefigureavg+$pacefigure2avg)/2 ;
$printpace=max($pacefigureavg,$pacefigure2avg);


$classratingavg		= (($classratingavg/130)*100)+(130/4) ;
$speedfigureavg	= (($speedfigureavg/130)*100)+(130/4) ;
c:
$jockperc=($jockperc/2)+100;
$trainerperc=($trainerperc/2)+100;
$horseperc=($horseperc/2)+100;

if($equilink == "" ){
	$classratingavg=0;
	$speedfigureavg=0;

}

$never="";
if ($classratingavg <= 0){
	$never="<B>!</b>";
}

$form=$weighttoday-$dollarvalue;

if ($jockperc>112){
$form=$form+1;
}
if ($trainerperc>112){
$form=$form+1;
}
if ($jockperc<105){
$form=$form-1;
}
if ($trainerperc<105){
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


if($lines2 <=0){
	$lines2=1;
}
$qdisp=($pacefigureavg-(($quarter/2)/$lines2));
$qperc=($quarter/2)/$lines2;
$hdisp=$pacefigureavg-(($half/2)/$lines2);
$sdisp=$pacefigure2avg-(($stretch/2)/$lines2);
$fdisp=$pacefigure2avg-(($finish1/2)/$lines2);

$sty="n/a";
//$qperc=round($qperc);
$fs=$fs/$lines2;
if($qperc <= 1.25 ){
	$sty="E  ".round((((100-$qperc))-$fs)-90);
}

if($qperc >=1.255 and $qperc <=3.0 ){
	$sty="eP ".round((((100-$qperc))-$fs)-90);
}

if($qperc >=3.01 and $qperc <=6.0 ){
	$sty="P ".round((((100-$qperc))-$fs)-90);
}
if($qperc >=6.01 ){
	$sty="S    ".round((((100-$qperc))-$fs)-90);
}

if(($pacefigureavg)<=0 AND round(100-$qperc)==100){
	$sty="n/a";
}
if($equilink == ""){
	$sty="na";
	$qdisp=0;
	$hdisp=0;
	$sdisp=0;
	$fdisp=0;
}


$avgme=1;
if ($jockeyperc > 0){
	$avgme=$avgme+1;
}
if ($horseperc > 0){
	$avgme=$avgme+1;
}

if ($trainerperc > 0){
	$avgme=$avgme+1;
}

if ($workperc > 0){
	$avgme=$avgme+1;
}

if ($raceperc > 0){
	$avgme=$avgme+1;
}

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




//goto t;
$rr=0;
$r="";
$z="";
$r1="";
$avgme2=0;
if($p1 <=0){
	$p1=$todaysclass;
}
if($p2 <=0){
	$p2=$todaysclass;
}
if($p3 <=0){
	$p3=$todaysclass;
}
if($s1 <=0){
	$s1=$todaysclass;
}
if($s2 <=0){
	$s2=$todaysclass;
}
if($s3 <=0){
	$s3=$todaysclass;
}
if($pp1 <=0){
	$pp1=$todaysclass;
}
if($pp2 <=0){
	$pp2=$todaysclass;
}
if($pp3 <=0){
	$pp3=$todaysclass;
}
if($cl1 <=0){
	$cl1=$todaysclass;
}
if($cl2 <=0){
	$cl2=$todaysclass;
}



if($s1 >= $s2 AND $s2 >= $s3 ){
	$imp=$imp+100;
	$avgme2=$avgme2+2;
}



$mem=0;
$somefig1=$imp+$avgme2;
$somefig2=(($jockperc+$trainerperc+$horseperc+$raceperc+$workperc+$classratingavg+$speedfigureavg+$pacefigure2avg+$pacefigure2avg4+$pacefigureavg3+$pacefigureavg+$qdisp+$hdisp+$sdisp+$fdisp-$abytavg)/$avgme)-$dollarvalue;

$somefig2=$somefig2+((($trainerperc*20+$speedfigureavg*20)+($jockperc*8+$horseperc*8+$raceperc*8)+($workperc*12+$classratingavg*12+((($jockperc+$trainerperc+$horseperc+$raceperc+$workperc+$classratingavg+$speedfigureavg+$pacefigure2avg+$pacefigure2avg4+$pacefigureavg3+$pacefigureavg+$qdisp+$hdisp+$sdisp+$fdisp-$abytavg)/$avgme)*100)
)+($qdisp*4+$hdisp*4+$sdisp*4+$fdisp*4)-($dollarvalue*12)));
	$imp=0;
			if($rr==12){
			//$r="**";
		}
			if($rr ==24){
			//$r="***";
		}
	


$programnum=$horsedata->program;
$hname=$horsedata->horse_name;
//build some arrays with the colums


			$data[] = array('post' =>$programnum, 'horse' => $hname, 'twiza' => round($somefig1,1), 'rs' => $sty.$r.$r1.$z, 'odds' => $dollarvalue, 'jock' => $strj, 'trn' =>$strt);
            $data1[] = array('post1' =>$programnum, 'mloa' =>$dollarvalue);
		    $data2[] = array('post2' => $programnum, 'classa' => round($classratingavg,0));
			$data3[] = array('post3' => $programnum, 'speeda' => round($speedfigureavg,0));
			$data4[] = array('post4' => $programnum, 'hdispa' => round($hdisp,0));
			$data5[] = array('post5' => $programnum, 'fdispa' => round($fdisp,0));
			$data6[] = array('post6' => $programnum, 'sdispa' => round($sdisp,0));
			$data7[] = array('post7' => $programnum, 'trainera' => round($trainerperc,0));
			$data8[] = array('post8' => $programnum, 'jockeya' => round($jockperc,0));
			$data9[] = array('post9' => $programnum, 'qdispa' => round($qdisp,0));
			$data10[] = array('post10' => $programnum, 'horseperca' => round($horseperc,0));
			$data11[] = array('post11' => $programnum, 'workperca' => round($workperc,0));
			$data12[] = array('post12' => $programnum, 'raceperca' => round($raceperc,0));
			$data13[] = array('post13' =>$programnum, 'twizb' => round($somefig2,1));
			$countthem=$countthem+1;
		
	} // end $racedata as $horsedata loop
		
	//echo '</table>';

	//Fill the data
foreach ($data as $key => $row) {
    $twiza[$key]  = $row['twiza'];
    $post[$key] = $row['post'];
}
foreach ($data1 as $key1 => $row1) {
    $mloa[$key1]  = $row1['mloa'];
    $post1[$key1] = $row1['post1'];
}
foreach ($data2 as $key2 => $row2) {
    $classa[$key2]  = $row2['classa'];
    $post2[$key2] = $row2['post2'];
}
foreach ($data3 as $key3 => $row3) {
    $speeda[$key3]  = $row3['speeda'];
    $post3[$key3] = $row3['post3'];
}
foreach ($data4 as $key4 => $row4) {
    $hdispa[$key4]  = $row4['hdispa'];
    $post4[$key4] = $row4['post4'];
}
foreach ($data5 as $key5 => $row5) {
    $fdispa[$key5]  = $row5['fdispa'];
    $post5[$key5] = $row5['post5'];
}
foreach ($data6 as $key6 => $row6) {
    $sdispa[$key6]  = $row6['sdispa'];
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
    $qdispa[$key9]  = $row9['qdispa'];
    $post9[$key9] = $row9['post9'];
}
foreach ($data10 as $key10 => $row10) {
    $horseperca[$key10]  = $row10['horseperca'];
    $post10[$key10] = $row10['post10'];
}
foreach ($data11 as $key11 => $row11) {
    $workperca[$key11]  = $row11['workperca'];
    $post11[$key11] = $row11['post11'];
}
foreach ($data12 as $key12 => $row12) {
    $raceperca[$key12]  = $row12['raceperca'];
    $post12[$key12] = $row12['post12'];
}
foreach ($data13 as $key13 => $row13) {
    $twizb[$key13]  = $row13['twizb'];
    $post13[$key13] = $row13['post13'];
}

//sort the data Highest to lowest
array_multisort($twiza, SORT_DESC, $post, SORT_DESC, $data);
array_multisort($mloa, SORT_DESC, $post1, SORT_DESC, $data1);
array_multisort($classa, SORT_DESC, $post2, SORT_DESC, $data2);
array_multisort($speeda, SORT_DESC, $post3, SORT_DESC, $data3);
array_multisort($hdispa, SORT_DESC, $post4, SORT_DESC, $data4);
array_multisort($fdispa, SORT_DESC, $post5, SORT_DESC, $data5);
array_multisort($sdispa, SORT_DESC, $post6, SORT_DESC, $data6);
array_multisort($trainera, SORT_DESC, $post7, SORT_DESC, $data7);
array_multisort($jockeya, SORT_DESC, $post8, SORT_DESC, $data8);
array_multisort($qdispa, SORT_DESC, $post9, SORT_DESC, $data9);
array_multisort($horseperca, SORT_DESC, $post10, SORT_DESC, $data10);
array_multisort($workperca, SORT_DESC, $post11, SORT_DESC, $data11);
array_multisort($raceperca, SORT_DESC, $post12, SORT_DESC, $data12);
array_multisort($twizb, SORT_DESC, $post13, SORT_DESC, $data13);

//find and print
$howmany=$countthem;// How many Ranks deep do you want to go
$addy=0;
$a1=1;
$rowdata=0;
$rowdata2=0;
$rowpost=0;
//echo '<table>';
echo '<thead><th></th><th>Prg#</th><th>Horse</th><th>R-Style</th><th>Morning Line</th><th>Jockey</th><th>Trainer</th><th>Form</th><th>%Rank</th><th>twiz</th><th>TWiz+</th></thead>';
$rowcheck=0;
//this does th trickery;
foreach ( $data as $data ) {

	echo'<tr><td><input type="checkbox" class="check" /></td>';
  foreach ( $data as $key => $row ) {  
  if($a1==3){
   // echo '<td> value </td> '; //eventually remove this
	$rowdata=$row;//holds prog# of Twiz
}ELSE{
	if($a1==2){
		echo '<td><font size="3">';
	$link = '"https://www.google.com/?gws_rd=ssl#q=%22'.$row.'%22+horse+site:horseracingnation.com"'; // Link goes here!
echo	'<a href='.$link.' target="_blank">'.$row.'</a>';

	 echo '</font></td>';
	}ELSE{
    echo '<td><font size="3">'.$row.'</font></td>';
	}
	if($a1==1){
	 $rowpost=$row;
 }
 if($a1==5){
	 $dollarvalue=$row;
 }

	  }
	 
	$a1=$a1+1;
  }
    $a1=1;
		//find all the top post positions for each category asign post to $rowcheck
$avgme=0;
$letssee=0;
$addy=0;
$rowdata2=$todaysclass;
	for ($yz=0; $yz <= $howmany-1; $yz++) {
		$yy=($countthem-$yz);


$rowcheck=$post[$yz];//<<---find by looking for post of first value assign rowcheck
  if ($rowpost==$rowcheck){
	  $addy=$addy+$yy;
	  $avgme=$avgme+1;
	
  }

$rowcheck=$post1[$yz];
  if ($rowpost==$rowcheck){
	   $addy=$addy-$yy; //mlo minus
	     $avgme=$avgme+1;
 
  } 
    
 $rowcheck=$post2[$yz];
  if ($rowpost==$rowcheck){
	 $addy=$addy+$yy;
	 $avgme=$avgme+1;
  }

  $rowcheck=$post3[$yz];
  if ($rowpost==$rowcheck){
	   $addy=$addy+$yy;
	     $avgme=$avgme+1;
  }
  $rowcheck=$post4[$yz];
  if ($rowpost==$rowcheck){
	  $addy=$addy+$yy;
	    $avgme=$avgme+1;

  }
  $rowcheck=$post5[$yz];
  if ($rowpost==$rowcheck){
 $addy=$addy+$yy;
   $avgme=$avgme+1;

  }
  $rowcheck=$post6[$yz];
  if ($rowpost==$rowcheck){
	   $addy=$addy+$yy;
	     $avgme=$avgme+1;

  }
  $rowcheck=$post7[$yz];
  if ($rowpost==$rowcheck){
	   $addy=$addy+$yy;
	     $avgme=$avgme+1;

  }
  $rowcheck=$post8[$yz];
  if ($rowpost==$rowcheck){
	  $addy=$addy+$yy;
	    $avgme=$avgme+1;

  }
  $rowcheck=$post9[$yz];
  if ($rowpost==$rowcheck){
	  $addy=$addy+$yy;
	    $avgme=$avgme+1;

  }
  $rowcheck=$post10[$yz];
  if ($rowpost==$rowcheck){
	 $addy=$addy+$yy;
	   $avgme=$avgme+1;

  }
 $rowcheck=$post11[$yz];
  if ($rowpost==$rowcheck){

  $addy=$addy+$yy;
    $avgme=$avgme+1;
 }
$rowcheck=$post12[$yz];
if ($rowpost==$rowcheck){
	  $addy=$addy+$yy;
	    $avgme=$avgme+1;
  
 }

  if($yz==0 And $avgme<>0){
	 $rowdata2=$rowdata2+$yz+$avgme;
 }

$addy=0;
$avgme=0;	

}

//end loop



//($todaysclass*3.03);
//$rowdata2=$rowdata2/$howmany;
//$rowdata2=$rowdata2/(($todaysclass+$yy)+70);
$rowdata2=$rowdata2-100;
$rowdata=$rowdata-100;
$rowdata=$rowdata*10;
$rowdata=$rowdata+100;
$rowdata2=$rowdata2+100;
if($rowdata<=0){
	$rowdata=10;
}
if($rowdata>100){
	$rowdata=$rowdata-100;
}
$rowdata2=round($rowdata2);
if($rowdata2<=0){
	$rowdata2=0;
}
$rowdata=round($rowdata);
	for ($yt=0; $yt <= $howmany-1; $yt++) {
		if ($rowpost==$post13[$yt]){
			$subt=(($twizb[$yt])-10000)/100;
			$subt=$subt-10;
			$subt=$subt+100;
			if($subt<=0){
				$subt=0;
			}
	
			$subt2=ROUND(($rowdata+$rowdata2+$subt),0)+round((((100-$qperc))-$fs)-90);
			$subt2=round($subt2);
			$dollarvalue3=$dollarvalue;
			$dollarvalue=(100-$dollarvalue)/10;
			$subt2=(($subt2+$dollarvalue)/2)/($dollarvalue3)+$rowdata2*10+(($subt-100)/2);
			
		 echo '<td><font size="3">'.round($rowdata,0).'</font></td>';
		  echo '<td><font size="3">'.round($rowdata2,0).'</font></td>';
		   echo '<td><font size="3">'.round($subt,0).'</font></td>';
		 echo '<td><font size="3">'.round($subt2,0).'</font></td>';
		 $mem=$mem+1;
			}
		}		
$qperc=0;	  
$rowdata=0;
$rowdata2=0;
$mp=0;
$subt=0;
$subt2=0;
$rowcheck=0;
  $rowpost=0;
  $addy=0;
  $avgme=0;


}

echo'</tr></table>';


$xx = 0; 



//now unset everything for the next loop
do {
	
    
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

  
	
	unset ( $mloa);
	$mloa=array();
    unset ( $post1);
	$post1=array();
    unset ($key1);
	$key1=array();
	unset ($row1);
	$row1=array();
	unset ($data1);
    $data1=array();
	
	
	
	unset ( $classa);
	$classa=array();
    unset ( $post2);
	$post2=array();
    unset ($key2);
	$key2=array();
	unset ($row2);
	$row2=array();
	unset ($data2);
    $data2=array();
	
	

	unset ( $speeda);
	$speeda=array();
    unset ( $post3);
	$post3=array();
    unset ($key3);
	$key3=array();
	unset ($row3);
	$row3=array();
	unset ($data3);
    $data3=array();
	
	

	unset ( $hdispa);
	$hdispa=array();
    unset ( $post4);
	$post4=array();
    unset ($key4);
	$key4=array();
	unset ($row4);
	$row4=array();
	unset ($data4);
    $data4=array();
	
	

	unset ( $sdispa);
	$forma=array();
    unset ( $post6);
	$post6=array();
    unset ($key6);
	$key6=array();
	unset ($row6);
	$row6=array();
	unset ($data6);
    $data6=array();
	
	

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
	
	

	unset ( $qdispa);
	$qdispa=array();
    unset ( $post9);
	$post9=array();
    unset ($key9);
	$key9=array();
	unset ($row9);
	$row9=array();
	unset ($data9);
    $data9=array();
	
	

	unset ( $fdispa);
	$fdispa=array();
    unset ( $post5);
	$post5=array();
    unset ($key5);
	$key5=array();
	unset ($row5);
	$row5=array();
	unset ($data5);
    $data5=array();

	

	unset ( $horseperca);
	$horseperca=array();
    unset ( $post10);
	$post10=array();
    unset ($key10);
	$key10=array();
	unset ($row10);
	$row10=array();
	unset ($data10);
    $data10=array();

	

	unset ( $workperca);
	$workperca=array();
    unset ( $post11);
	$post11=array();
    unset ($key11);
	$key11=array();
	unset ($row11);
	$row11=array();
	unset ($data11);
    $data11=array();
	


	unset ( $raceperca);
	$raceperca=array();
    unset ( $post12);
	$post12=array();
    unset ($key12);
	$key12=array();
	unset ($row12);
	$row12=array();
	unset ($data12);
    $data12=array();
	
	unset ( $twizb);
	$twizb=array();
    unset ( $post13);
	$post13=array();
    unset ($key13);
	$key13=array();
	unset ($row13);
	$row13=array();
	unset ($data13);
    $data13=array();

	
    $xx++;
} while ($xx <= 500);
	
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
				"order": [[ 10, "des" ]],
				columnDefs: [
					{ type: 'natural', targets: 0 },
					{ type: 'natural', targets: 1 },
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
