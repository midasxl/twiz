<!-- This is summary_harness.php for admin use -->

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>TWIZ Summary sheet</title>
<link rel="stylesheet" media="screen" href="../assets/css/jquery-ui.css" />
<link rel="stylesheet" media="screen" href="../assets/css/dataTables.jqueryui.css" />
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
$source = '../sample/yrx20170211hppXML.xml';

/* parse integers from file name */
$int = intval(preg_replace('/[^0-9]+/', '', $source), 10);
/* create a date object from the integers */
$date=date_create($int);
/* format the date object */
$dateformatted = date_format($date,"M d, Y");

$xmldata = simplexml_load_file($source);

//print_r($xml);

// get full track name from array; pass in abbreviation 
include("switch_harness.php"); // return $trackloc variable with full track name as value
    
echo '<div id="card-header"><img src="../assets/img/logo-twiz.png" /><h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$trackloc.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
'.$dateformatted.'</h1><a style="float:right;color:#fff;padding:8px;" href="" id="printMe">Print This Card</a><a href="" id="showlegend" style="float:right;color:#fff;padding:8px;">Show/Hide Legend</a></div>';

echo '<div id="legend" style="display:none;"><img src="../img/legend_summary.jpg" /></div>';

// loop time
$i = 0; // set counter for table name
$anchorNum = 0;

// count number of <racedata> nodes in the entire document to get number of races for the jump anchors
$xmlDoc = new DOMDocument();
$xmlDoc->load($source);
$raceNum = $xmlDoc->getElementsByTagName("racedata");
$numOfRaces = $raceNum->length;   
    
    
    

    
foreach($xmldata->trackdata->racedata as $racedata) { // gets all <racedata> children of the <trackdata> element
    
    
    
    

//get and format date for each race header
 //no race_date node in racedata
$formatme1 			= $dateformatted;
$date1				= date_create($formatme1);
$race_date 			= date_format($date1,"m-d-y");
$race_date_header 	= date_format($date1,"mdy");
$equilinkracedate2 	= date_format($date1,"m/d/y");
$anchorNum 			= $anchorNum + 1;
    
// for reference:     http://www.equibase.com/static/entry/BEL090614USA-EQB.html#RACE4 (TRACK TODAYSRACEDATE & RACENUMBER)	
	
// no surface node in racedata, or dist_disp
/*$tsurf=$racedata->surface;

if ($tsurf<> "T" AND $tsurf<>  "I" AND $tsurf<> "C" AND $tsurf<> "O" ){
$tsurf="D";
} ELSE {
$tsurf="T";
}*/
    
// Create each race header
echo '<div class="title">
<h3 class="r-data">

<a name="'.$anchorNum.'" class="head-anchor" href="http://www.equibase.com/static/entry/'.$racedata->track.$race_date_header.'USA-EQB.html#RACE'.$racedata->race.'" target="_blank">Race '.$racedata->race.', Class of '.$racedata->todays_cls.' @ '.$racedata->track.' on '.$dateformatted.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Going '.$racedata->dist_disp.' over the '.$tsurf.'</a>
</h3>

<h3 class="p-time">Post Time: '.$racedata[$anchorNum]->posttime.'</h3>
</div>

<div class="clear"></div>

<div>
<p><strong>Race Information:</strong><br>'.$racedata[$anchorNum]->racetext1.'</p>
<p>

<a  class="r-data" href= " https://racing.ustrotting.com/default.aspx" target="_blank">Results</a>:
<a  class="r-data" href= " https://racing.ustrotting.com/default.aspx" target="_blank">Charts</a>:
<a  class="r-data" href= "http://www.trackmaster.com/free/biasReports" target="_blank"> BIAS Reports </a>:
<a  class="r-data" href= "http://theturfclub.yolasite.com/the-lobby.php" target="_blank"> The TURF CLUB (Free Programs)</a></p>';
	
echo '<p>Jump to race:&nbsp;&nbsp;';
	
for ($x = 1; $x <= $numOfRaces; $x++) {
    	echo "<a href='#".$x."'>".$x."</a>&nbsp;&nbsp;";
} 
	
echo '</p></div>';

// create table and thead tag and contents
echo '<hr /><a href="#" id="table'.$i.'" class="filters hideRows">Show only checked rows</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#" id="table'.$i.'" class="filters restoreRows">Restore hidden rows</a><div id="spacer"></div><table class="display table'.$i.'"><thead><th>Pr#</th><th>__</th><th>Horse</th><th>m/eq/ae<b/th><th>MLO</th><th>Days</th><th>Last</th><th>Rfig</th><th>Jk</th><th>Tr</th><th>Hr</th><th>Cl</th><th>E</th><th>E/P</th><th>P</th><th>L</th><th>Twiz</th></thead>';
	
$lines=0;
    
    
    
    
    

// This is a nested loop inside the trackdata loop
// gets each <horsedata> node inside the <trackdata><racedata> node
foreach($racedata->horsedata as $horsedata) { 
    
    
    
    
    

/*  Everything that follows is the parse logic for a normal sheet.  NOT harness
I figure we could maybe use some of the logic here and apply it to the harness format */


$t=0;
if($horsedata->trainer->trr_l30_wp > 0){
	$t=$t+1;
}
if($horsedata->trainer->trs_1st_wp > 0){
	$t=$t+1;
}
if($horsedata->trainer->trs_2yo_wp > 0){
	$t=$t+1;
}
if($horsedata->trainer->trs_l31_wp > 0){
	$t=$t+1;
}
if($horsedata->trainer->trs_clm_wp > 0){
	$t=$t+1;
}
$h=0;
if($horsedata->era91al_wp >0){
	$h=$h+1;
}
if($horsedata->era91of_wp >0){
	$h=$h+1;
}
if($horsedata->eratyal_wp >0){
	$h=$h+1;
}
if($horsedata->eralyal_wp >0){
	$h=$h+1;
}
if($horsedata->era06al_wp >0){
	$h=$h+1;
}

$jockperc               =  $horsedata->driver->drs_udr;
$trainerperc			= ($horsedata->trainer->trr_l30_wp+$horsedata->trainer->trs_1st_wp+$horsedata->trainer->trs_2yo_wp+$horsedata->trainer->trs_l31_wp+$horsedata->trainer->trs_clm_wp)/$t;
$horseperc		    	= ($horsedata->era91al_wp+$horsedata->era91of_wp+$horsedata->eratyal_wp+$horsedata->eralyal_wp+$horsedata->era06al_wp)/$h;
$connections			= ($jockperc+$trainerperc)/2;

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
			
$weighttoday=$horsedata->driver->driverwght;
	
// get and format last race data for equibase link
$formatme2			= $horsedata->ppdata[0]->date[0];
$date2				= date_create($formatme2);
$equilinkracedate 	= date_format($date2,"m/d/y");
//if(isset($horsedata->ppdata[0])){
//$equilink = "<a href='http://www.equibase.com/premium/eqbPDFChartPlus.cfm?RACE=".$horsedata->ppdata[0]->racenumber[0]."&BorP=P&TID=".$horsedata->ppdata[0]->trackcode[0]."&CTRY=".$horsedata->ppdata[0]->country[0]."&DT=".$equilinkracedate."&DAY=D&STYLE=EQB' target='_blank'>".$equilinkracedate."</a>";
//}else{
//$equilink = "";	
//}

$posttimeodds = $ppdata->odds;
$strj = $horsedata->driver->driver;
$strt = $horsedata->trainer->trainname;
$meds = $horsedata->horse->me_lasixto;
$blinks = $horsedata->horse->me_hopfree;
//$tsire=$horsedata->sire->tmmark;
$aelg = "";
$workperc = 0;
$raceperc = 0;
$raceperc = (100-( ($horsedata->ppdata[0]->finish_off[0]/$horsedata->ppdata[0]->fieldsize[0])*100))+($horsedata->ppdata[0]->fieldsize[0]/10);	
if($raceperc == 100){
$raceperc = 0;
}
			// create partial table rows; continued on line 189
$days = (strtotime($formatme1) - strtotime($formatme2)) / (60 * 60 * 24);

if($days == 17139){
$days=10000;
}

echo '<tr><td>'.$horsedata->program.'</td><td><input type="checkbox" class="check" /><td>'.$horsedata->horse_name.' ('.$weighttoday.') '.'</td><td>'.$meds."|".$blinks."|".$aelg.'</td><td>'.money_format("$%i", $dollarvalue).'</td><td>'.$days.'</td><td>'.$equilinkracedate.'</td><td>'.number_format($raceperc, 0, '.', '').'</td>';

$todaysclass = $racedata->todays_cr;
$bestrw = $raceperc;
$early 		= 0;
$quarter 	= 0;
$half 		= 0;
$middle 	= 0;
$stretch 	= 0;
$end 		= 0;
$finish1 	= 0;
$fdisp 		= 0;
$qdisp 		= 0;
$hdisp 		= 0;
$mdisp 		= 0;
$sdisp 		= 0;
$finish 	= 0;
$comment	= "null";
$lastclass	= 900;	
    
    
    

		
foreach($horsedata->ppdata as $ppdata) { // gets <ppdata> node
    
    
    
    

// get and calculate

//if($lines > 3 AND $lines<> 0) {
//goto b;
//}

$finish = $ppdata->finish_off; // Value will be a 0 or higher integer
if ($finish == 0){ // if position is equal to '0'
goto b;
}
			
$classratingvalue 		= $ppdata->cr; //ADDED
$pacefigurevalue 		= ($ppdata->lead_tm_1q+$ppdata->lead_tm_2q)/2; //ADDED
$pacefigure2value 		= ($ppdata->lead_tm_3q+$ppdata->lead_tm_fn)/2; //ADDED
$speedfigurevalue 		= $ppdata->sr; //ADDED
$foreign                = 0;
$surfacevalue 			= $ppdata->cond;
$turffigurevalue 		= 0; //ADDED


if ($finish > 4 ){
$finish=$finish;
}ELSE{
$finish =$horsedata->ppdata->finish_off; 
}

if($comment <>"null" ){
$comment=$comment;
}ELSE{
$comment=$horsedata->ppdata->comment;
}

//distance surface penalties

$todaysdist = (int)($racedata->distance)/100;
$distof = ($ppdata->dist)/100;
$surface = $ppdata->cond;



$todaysdist		=(int)($racedata->distance)/100;
$distof			=(int)$distof;


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
$qlb=intval($ppdata->call_1q_lb)/100;
if ($qlb <=0){
$qlb=0;
}
$hlb=intval($ppdata->call_2q_lb)/100;
if ($hlb <=0){
$hlb=0;
}
$slb=intval($ppdata->call_3q_lb)/100;
if ($slb <=0){
$slb=0;
}
$flb=intval($ppdata->call_fn_lb)/100;
if ($flb <=0){
$flb=0;
}

// quarter
$quarter 	= $quarter+(($qlb+intval($ppdata->call_1q_po))/2);
$qdisp		= $qdisp+($classratingvalue+10)-(($qlb+intval($ppdata->call_1q_po))/2);
// half
$half 		= $half+(($hlb+intval($ppdata->call_2q_po))/2);
$hdisp		= $hdisp+($classratingvalue+10)-(($hlb+intval($ppdata->call_2q_po))/2);
// stretch
$stretch 	= $stretch +(($slb+intval($ppdata->call_3q_po))/2);
$sdisp		= $sdisp+($classratingvalue+10)-(($slb+intval($ppdata->call_3q_po))/2);
// finish
$finish1 	= $finish1+(($flb+intval($ppdata->call_st_po))/2); 
$fdisp		= $fdisp+($classratingvalue+10)-(($flb+intval($ppdata->call_st_po))/2);

$lines = $lines+1;

b:
    
    
    
    
} // end $horsedata as $ppdata loop
    
    
 

$posttimeoddsavg    = (($posttimeodds/ $speedfigure_flag)/1)*1;

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

echo '<td>'.number_format($jockperc, 0, '.', '').'</td>';
echo '<td>'.number_format($trainerperc, 0, '.', '').'</td>';
echo '<td>'.number_format($horseperc, 0, '.', '').'</td>';
echo '<td>'.round($classratingavg).'</td>';
 
                 
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
$somefig=(($todaysclass+$sorta)/2)+$horseperc+$connections+$latep-($dollarvalue*2);

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
//$finish = intval($finish);


if ($finish >0 AND $finish<3){
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
$qdisp1=(((150-$classratingavg)/10)+((($ppdata->call_1q_po*100)/$ppdata->fieldsize)+$ppdata->call_1q_lb)/100)/2;
$hdisp1=(((150-$classratingavg)/10)+((($ppdata->call_2q_po*100)/$ppdata->fieldsize)+$ppdata->call_2q_lb)/100)/2;
$sdisp1=(((150-$classratingavg)/10)+((($ppdata->call_3q_po*100)/$ppdata->fieldsize)+$ppdata->call_3q_lb)/100)/2;

if ($ppdata->finish_off==0){
$ppdata->call_fn_lb=0;
}
$fdisp1=(((150-$classratingavg)/10)+((($ppdata->finish_off*100)/$ppdata->fieldsize)+$ppdata->call_fn_lb)/100)/2;

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
$somefig1=(($con+$horseperc+$classratingavg)/3)/2;

$fit=$raceperc;


$somefig1=($con+$clss-$pce)/3;

echo '<td>'.number_format($qdisp, 1, '.', '')."</td><td>".number_format($hdisp, 1, '.', '')."</td><td>".number_format($sdisp, 1, '.', '')."</td><td>".number_format($fdisp, 1, '.', '').'</td><td>'.number_format($somefig1, 1, '.', '').'</td></tr>';

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
				"order": [[ 16, "des" ]],
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
