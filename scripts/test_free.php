<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
$source = '../sample/'.$_POST["card"];
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
echo '<hr /><a href="#" id="table'.$i.'" class="filters hideRows">Show only checked rows</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#" id="table'.$i.'" class="filters restoreRows">Restore hidden rows</a><table class="display table'.$i.'">';
	// Loop time

$countthem=0;
foreach($racedata->horsedata as $horsedata) { // gets <horsedata> node
$lines=0;
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
$workperc=(100-( ($horsedata->workoutdata->ranking[0]/$horsedata->workoutdata->rank_group[0])*100))+($horsedata->workoutdata->rank_group[0]/10);
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
		
foreach($horsedata->ppdata as $ppdata) { // gets <ppdata> node
if ($ppdata->speedfigur <=0 OR $ppdata->speedfigur >= 900){
	goto b;
}
$finish=$ppdata->positionfi[0];
$abyt=$ppdata->horsetime2-$ppdata->horsetime1;
$abyt2=$ppdata->horsetimes-$ppdata->horsetime2;
if($abyt2 >= $abyt){
	$abyt=$abyt2;
}
if($abyt <= 20){
	$abyt=$abyt*2;
}
$abyt3=$abyt3+$abyt;
if($abyt <=0){
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
$finishcheck=$ppdata->positionfi;


//Running Style

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


// quarter
$quarter = $quarter+($qlb+$q);

// half
$half = $half+($hlb+$h);

// stretch
$stretch =$stretch +($slb+$s);

// finish
$finish1 = $finish1+($flb+$f);

$lines2=$lines2+1;

$distof				=($ppdata->distance)/100;

if($finishcheck <=0 or $finishcheck >=5){
	goto b;
}


//if($lines <=6){
//	goto b;
//}

//if ($distof <= ($todaysdist-2) OR $distof >= ($todaysdist+1.5)  ){

//goto b;
//}

//if ($surface<>$tsurf){

//goto b;
//}
//if ($ppdata->trackcondi <> "FM" and $ppdata->trackcondi <> "FT" ){
	
//	goto b;
//}




$posttimeoddsvalue 	=$ppdata->posttimeod;
		
			$classratingvalue 		= $ppdata->classratin; //ADDED
			$pacefigurevalue 		= $ppdata->pacefigure; //ADDED
			$pacefigure2value 		= $ppdata->pacefigur2; //ADDED
            $foreign                = $ppdata->foreignspe;
			$turffigurevalue 		= $ppdata->turffigure; //ADDED
            $speedfigurevalue 		= $ppdata->speedfigur;
//added this line
$foreign = $foreign -10;

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



$lines=$lines+1;

b:
} // end $horsedata as $ppdata loop

$classratingavg 	= ($total_a / $classrating_flag);
$abytavg2=$abytavg;

			$posttimeoddsavg    = ($total_e / $posttime_flag);
			$pacefigureavg	 	= ($total_b / $pacefigure_flag);
			$pacefigure2avg 	= ($total_c / $pacefigure2_flag);
			$speedfigureavg 	= ($total_d / $speedfigure_flag);
			$abytavg=$abyt3/$lines;
	$abyt3=0;
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


$qdisp=125-($quarter/$lines2);
$hdisp=125-($half/$lines2);
$sdisp=125-($stretch/$lines2);
$fdisp=125-($finish1/$lines2);



$sty="E/P";
if($qdisp > $fdisp ){
	$sty="E ";
}
if($hdisp = $sdisp AND $sdisp < $fdisp){
	$sty="P ";
}

if($fdisp > $qdisp AND $fdisp > $sdisp+1 ){
	$sty="S ";
}




if($equilink == ""){
	$sty="na";
	$qdisp=0;
	$hdisp=0;
	$sdisp=0;
	$fdisp=0;
}

$cavg=11;
if ($classratingavg <=0 OR $equilink == ""){
	$cavg=4;
}
	


$somefig1=(((max($jockperc,$trainerperc,$horseperc)+max($raceperc,$workperc)+max($classratingavg,$speedfigureavg)+max(pacefigure2avg,pacefigureavg)+max($qdisp,$hdisp,$sdisp,$fdisp))/5)-$abytavg2);


$programnum=$horsedata->program;
$hname=$horsedata->horse_name;
//build some arrays with the colums


			$data[] = array('post' =>$programnum, 'horse' => $hname, 'twiza' => round($somefig1,1), 'rs' => $sty, 'odds' => $dollarvalue, 'jock' => $strj, 'trn' =>$strt);
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
    $workperca[$key12]  = $row12['raceperca'];
    $post12[$key12] = $row12['post12'];
}
//sort the data Highest to lowest
array_multisort($twiza, SORT_DESC, $post, SORT_DESC, $data);
array_multisort($mloa, SORT_ASC, $post1, SORT_ASC, $data1);
array_multisort($classa, SORT_DESC, $post2, SORT_DESC, $data2);
array_multisort($speeda, SORT_DESC, $post3, SORT_DESC, $data3);
array_multisort($hdispa, SORT_DESC, $post4, SORT_DESC, $data4);
array_multisort($fdispa, SORT_ASC, $post5, SORT_ASC, $data5);
array_multisort($sdispa, SORT_DESC, $post6, SORT_DESC, $data6);
array_multisort($trainera, SORT_DESC, $post7, SORT_DESC, $data7);
array_multisort($jockeya, SORT_DESC, $post8, SORT_DESC, $data8);
array_multisort($qdispa, SORT_DESC, $post9, SORT_DESC, $data9);
array_multisort($horseperca, SORT_DESC, $post10, SORT_DESC, $data10);
array_multisort($workperca, SORT_DESC, $post11, SORT_DESC, $data11);
array_multisort($raceperca, SORT_DESC, $post12, SORT_DESC, $data12);


//find and print
$howmany=countthem/2;// How many Ranks deep do you want to go
$bcount=$countthem; //<-award for being top
$addy=0;
$a1=1;
$rowdata=0;
$rowpost=0;
//echo '<table>';
echo '<thead><th></th><th>Prg#</th><th>Horse</th><th>R-Style</th><th>Morning Line</th><th>Jockey</th><th>Trainer</th><th>TWiz+</th></thead>';
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
    echo '<td><font size="3">'.$row.'</font></td> ';
	}
	if($a1==1){
	 $rowpost=$row;
 }
	  }
	$a1=$a1+1;
  }
    $a1=1;
		//find all the top post positions for each category asign post to $rowcheck
		$bonus=$countthem;
	for ($yz=0; $yz <= $howmany; $yz++) {
		$yy=$countthem-$yz;
	
$rowcheck=$post[$yz];//<<---find by looking for post of first value assign rowcheck
  if ($rowpost==$rowcheck){
	  $addy=$addy+$yy;
	 if($yz==0){
		 $addy=$addy+$twiza[$yz];
	 }
  }

$rowcheck=$post1[$yz];
  if ($rowpost==$rowcheck){
	   $addy=$addy-$yy;
	   	 if($yz==0){
		 $addy=$addy-$mloa[$yz];
	 }
  } 
    
 $rowcheck=$post2[$yz];
  if ($rowpost==$rowcheck){
	 $addy=$addy+$yy;
	 	 if($yz==0){
		 $addy=$addy+$classa[$yz];
	 }
  }

  $rowcheck=$post3[$yz];
  if ($rowpost==$rowcheck){
	   $addy=$addy+$yy;
	   	 if($yz==0){
		 $addy=$addy+$speeda[$yz];
	 }
  }
  $rowcheck=$post4[$yz];
  if ($rowpost==$rowcheck){
	  $addy=$addy+$yy;
	  	 if($yz==0){
		 $addy=$addy+$hdispa[$yz];
	 }
  }
  $rowcheck=$post5[$yz];
  if ($rowpost==$rowcheck){
 $addy=$addy+$yy;
 	 if($yz==0){
		 $addy=$addy+$fdispa[$yz];
	 }
  }
  $rowcheck=$post6[$yz];
  if ($rowpost==$rowcheck){
	   $addy=$addy+$yy;
	   	 if($yz==0){
		 $addy=$addy+$sdispa[$yz];
	 }
  }
  $rowcheck=$post7[$yz];
  if ($rowpost==$rowcheck){
	   $addy=$addy+$yy;
	   	 if($yz==0){
		 $addy=$addy+$trainera[$yz];
	 }
  }
  $rowcheck=$post8[$yz];
  if ($rowpost==$rowcheck){
	  $addy=$addy+$yy;
	  	 if($yz==0){
		 $addy=$addy+$jockeya[$yz];
	 }
  }
  $rowcheck=$post9[$yz];
  if ($rowpost==$rowcheck){
	  $addy=$addy+$yy;
	  	 if($yz==0){
		 $addy=$addy+$qdispa[$yz];
	 }
  }
  $rowcheck=$post10[$yz];
  if ($rowpost==$rowcheck){
	 $addy=$addy+$yy;
	 	 if($yz==0){
		 $addy=$addy+$horseperca[$yz];
	 }
  }
 $rowcheck=$post11[$yz];
  if ($rowpost==$rowcheck){
	  	 if($yz==0){
		 $addy=$addy+$workperca[$yz];
	 }
  $addy=$addy+$yy;
 }
$rowcheck=$post12[$yz];
if ($rowpost==$rowcheck){
	  $addy=$addy+$yy;
	  	 if($yz==0){
		 $addy=$addy+$raceperca[$yz];
	 }
 }
    //perform math to add to $row3 for tops matched
 
	}

  $rowdata=round(($rowdata+$addy)/3,1);
   
  echo '<td><font size="3">'.$rowdata.'</font></td>';
  $newtwiz=$rowdata;
  $rowpost=0;
  $addy=0;
}

echo'</tr></table>';


$xx = 0; 


//now unset everything for the next loop
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

    unset ( $mloa[$key1]);
	$mloa[$key1]=array();
    unset ( $post1[$key1]);
	$post1[$key1]=array();
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
	
	unset ( $classa[$key2]);
	$classa[$key2]=array();
    unset ( $post2[$key2]);
	$post2[$key2]=array();
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
	
	unset ( $speeda[$key3]);
	$speeda[$key3]=array();
    unset ( $post3[$key3]);
	$post3[$key3]=array();
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
	
	unset ( $hdispa[$key4]);
	$hdispa[$key4]=array();
    unset ( $post4[$key4]);
	$post4[$key4]=array();
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
	
	
	unset ( $fdispa[$key6]);
	$fdispa[$key6]=array();
    unset ( $post6[$key6]);
	$post6[$key6]=array();
	unset ( $fdispa);
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
	
	unset ( $qdispa[$key9]);
	$qdispa[$key9]=array();
    unset ( $post9[$key9]);
	$post9[$key9]=array();
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

	unset ( $horseperca[$key10]);
	$horseperca[$key10]=array();
    unset ( $post10[$key10]);
	$post10[$key10]=array();
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

	unset ( $workperca[$key11]);
	$workperca[$key11]=array();
    unset ( $post11[$key11]);
	$post11[$key11]=array();
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
	
unset ( $raceperca[$key12]);
	$raceperca[$key12]=array();
    unset ( $post12[$key12]);
	$post12[$key12]=array();
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
				"order": [[ 7, "des" ]],
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
