<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Summary Twiz sheet</title>
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

            thead th, tfoot th {border: 2px solid #000;
            text-align: left;
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
            background: transparent;}

            tfoot td {border: 2px solid #000;}

            tbody th, tbody td {vertical-align: top;
            text-align: left;}

            tbody th {white-space: nowrap;}

            .odd {background: #fcfcfc;}

            tbody tr:hover {background: #fafafa;}
        </style>

    </head>

<body>

<?php
    
    foreach ($_POST as $key => $value) {
        echo "<tr>";
        echo "<td>";
        echo $key;
        echo "</td>";
        echo "<td>";
        echo $value;
        echo "</td>";
        echo "</tr>";
    }
$source = '../sample/latest.xml';
$xmldata = simplexml_load_file($source);


// format date for header
$headerdate			= $xmldata->racedata[0]->race_date[0];
$headerdate1		= date_create($headerdate);
$headerdate2		= date_format($headerdate1,"M d, Y");

// get full track name from array; pass in abbreviation
include("switch.php"); // return $trackloc variable with full track name as value

/*echo '<div id="card-header"><img src="../assets/img/logo-twiz.png" /><h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$trackloc.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
'.$headerdate2.'</h1><a class="head-anchor equi" href="http://www.trackmaster.com/cgi-bin/axprodlist.cgi?tpp" target="_blank">Buy TRACKMASTER Printed PDF</a></div>';*/
//echo 'Filter: Pace=ITM Races= Within2F,All tracks,Todays surf';
echo '<div id="card-header"><img src="../assets/img/logo-twiz.png" /><h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$trackloc.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
'.$headerdate2.'</h1><a style="float:right;color:#fff;padding:8px;" href="" id="printMe">Print This Card</a><a href="" id="showlegend" style="float:right;color:#fff;padding:8px;">Show/Hide Legend</a></div>';

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
$formatme2			= $horsedata->$ppdata->racedate[0];
$days2 = (strtotime($formatme1) - strtotime($formatme2)) / (60 * 60 * 24);
    $date1				= date_create($formatme1);
    $race_date 			= date_format($date1,"m-d-y");
    $race_date_header 	= date_format($date1,"mdy");
    $equilinkracedate2 	= date_format($date1,"m/d/y");
    $anchorNum 			= $anchorNum + 1;
    $tsurf              = $racedata->surface;

    if ($tsurf<> "T" AND $tsurf<>  "I" AND $tsurf<> "C" AND $tsurf<> "O" ){
        $tsurf="D";
    } ELSE {
        $tsurf="T";
    }

    $todaysclass        = $racedata->todays_cls;
    $aclr               = $racedata->race_text;

    if (preg_match('/MAIDENS/',$aclr))
        echo '<font color="red">';
    if (preg_match('/turf/',$aclr) OR preg_match('/TURF/',$aclr) OR preg_match('/Turf/',$aclr))
        echo '<font color="GREEN">';
    if (preg_match('/MAIDENS/',$aclr) AND preg_match('/turf/',$aclr))
        echo '<font color="ORANGE">';

    // Create each race header
$raceinfotext=$racedata->race_text;
if (strpos($raceinfotext, 'SIMULCAST') !== false){

goto sc;
}
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

	// create table and thead tag and contents
	echo '<hr /><a href="#" id="table'.$i.'" class="filters hideRows">Show only checked rows</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#" id="table'.$i.'" class="filters restoreRows">Restore hidden rows</a><div id="spacer"></div><table class="display table'.$i.'"><thead><th>Pr</th><th>__</th><th>Name</th><th>m/e<b/th><th>Ml</th><th>J/T</th><th>Lw</th><th>Wk</th><th>Wf</th><th>Dys</th><th>Lr</th><th>Rf</th><th>Jk</th><th>Tr</th><th>Hr</th><th>Cl</th><th>Sp</th><th>Twiz</th><th>#</th><th>ap%</th><th>rs</th></thead>';

    $countthem          =0;
    $jockperc           =0;
    $trainerperc        =0;
    $horseperc          =0;
    $raceperc           =0;
    $workperc           =0;
    $classratingavg     =0;
    $speedfigureavg     =0;
    $pacefigure2avg     =0;
    $pacefigure2avg4    =0;
    $pacefigureavg3     =0;
    $pacefigureavg      =0;
    $qdisp              =0;
    $hdisp              =0;
    $sdisp              =0;
    $fdisp              =0;
    $abytavg            =0;
$fclass=$racedata->todays_cls;
    foreach($racedata->horsedata as $horsedata) { // gets <horsedata> node

        $lines          =0;
        $jockwins       =0;
        $jockplaces     =0;
        $jockstarts     =0;
        $trainerstarts  =0;
        $trainerwins    =0;
        $trainerplaces  =0;
        $horsestarts    =0;
        $horsewins      =0;
        $horseplaces    =0;
        $horseearnings  =0;
        $horseshows     =0;
        $apv            =0;
        $horseperc      =0;
        $jockperc       =0;
        $raceprc        =0;
        $trainerperc    =0;


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
        $mornodds 		    = (explode("/",$horsedata->morn_odds,2));

        if($mornodds[1] <=0){
            $dollarvalue 	= $mornodds[0] ;
        }else{
            $dollarvalue 	= $mornodds[0] / $mornodds[1];
        }

        //http://www.equibase.com/premium/eqbPDFChartPlus.cfm?RACE=11&BorP=P&TID=AQU&CTRY=USA&DT=04/06/2013&DAY=D&STYLE=EQB

        $weighttoday=$horsedata->weight;

        // get and format last race data for equibase link

        // get and format last race data for equibase link


        $strj = substr( $horsedata->jockey->jock_disp, 0, strpos($horsedata->jockey->jock_disp, ' ', 5) );
        $strt = substr( $horsedata->trainer->tran_disp, 0, strpos($horsedata->trainer->tran_disp, ' ', 5) );

        if ($strj==""){
            $strj =$horsedata->jockey->jock_disp;
        }
        if ($strt==""){
            $strt =$horsedata->trainer->tran_disp;
        }

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


        $wkdays=$horsedata->workoutdata->days_back[0];
        $cw="";
        if($wkdays=="" or $wkdays<=0){
            $wkdays=0;
        }

$bonus=0;
$wkfurlongs=$horsedata->workoutdata->worktext[0];
$wkrank=$horsedata->workoutdata->ranking[0];
$wkgroup=$horsedata->workoutdata->rank_group[0];
$wktext=$horsedata->workoutdata->worktext[0];

if($wkgroup==""){
$wktext="na";
$wkrank=0;
$wkgroup=0;
$wkfurlongs=0;
}


        echo '<tr><td>'.$horsedata->program.'</td><td><input type="checkbox" class="check" /></td><td>'.$horsedata->horse_name.' ('.$weighttoday.') '.'</td><td>'.$meds."|".$blinks."|".$aelg.'|'.$scr.'</td><td>'.money_format("$%i", $dollarvalue).'</td><td>'.$strj.'/'.$strt.'</td><td>'.$wkdays.'</td><td>'.$wktext.', '.$wkrank.'/'.$wkgroup.'</td><td>'.number_format($workperc, 0, '.', '').'</td>';
if ($blinks<>"" OR $meds<>"N"){
$bonus=$bonus+5;
}

        $todaysclass = $racedata->todays_cls;
        $todaysdist=($racedata->distance);

        // the following can be set like this: $first = $second = $third = $fourth = 0;
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
        $fs=0;
$combinedc=0;
$checklast=999;
$firstrow=0;
$finally=0;
$n1=0;
$n2=0;
$n3=0;
$n4=0;

if ($horsedata->ppdata->trackcode[0] <> ""){
goto g;
}
$finally=1;
goto f;
g:

 $add20=0;
 $countadd=0;
 
 foreach($horsedata->ppdata as $ppdata) { // gets <ppdata> node



$checkspeed=(int)$ppdata->speedfigur;

   $raceperc=$ppdata->speedfigur;
            $raceperc=(int)($raceperc);
        $formatme2			= $ppdata->racedate;

        $date2				= date_create($formatme2);
        $equilinkracedate 	= date_format($date2,"m/d/y");
 $days = (strtotime($formatme1) - strtotime($formatme2)) / (60 * 60 * 24);

		if ($firstrow==0){



            $equilink = "<a href='http://www.equibase.com/premium/eqbPDFChartPlus.cfm?RACE=".$ppdata->racenumber."&BorP=P&TID=".$ppdata->trackcode."&CTRY=".$ppdata->country."&DT=".$equilinkracedate."&DAY=D&STYLE=EQB' target='_blank'>".$equilinkracedate."</a>";


        $scr="";



        if($ppdata->positionfi <=0 or $ppdata->positionfi >=50 or $ppdata->positionfi ="" ){
            $scr="S";


        }




$days2=$days;
			echo '<td>'.round($days).$cw.'</td><td>'.$equilink.'</td><td>'.number_format($raceperc, 0, '.', '').'</td>';
$firstrow=999;
if( $checkspeed<= 1 OR $checkspeed >= 800 ){
	goto e;
}

		}



$formatme3			= $ppdata->racedate;
$daystoday = (strtotime($formatme1) - strtotime($formatme3)) / (60 * 60 * 24);
 if($daystoday>=1000){
            $daystoday=$wkdays;
        }
            $speedr=$ppdata->speedfigur;
			if ($checklast==999){
			 $speedfirst=$ppdata->speedfigur;
			 $classfirst=$ppdata->classratin;
			 $checklast=0;
			}
            $speedr=(int)$speedr;
            $foreign=$ppdata->foreignspe;

            if (($ppdata->foreignspe) > ($foreign=$ppdata->speedfigur)){
                $speedr=$foreign -20;
            }

            $finishcheck=$ppdata->positionfi;
			
			
            $distof=($ppdata->distance);
            $surface=$ppdata->courseid;

            if ($surface<> "T" AND $surface<> "I" AND $surface<>"C" AND $surface<>"O"){
                $surface="D";
            } ELSE {
                $surface="T";
            }

            if($ppdata->pulledofft <> 0){
                $surface="D";
            }

            if ( $speedr<=0 OR $speedr >=900){ //the horse was entered in the race but did not finish it
                $line=$lines-1; //race existed but not used
                goto b;
            }

            $trbl=0; // sets a value that increments if the comment is all caps meaning trouble was encountered

 $qlb=($ppdata->lenback1)/100;
            $hlb=($ppdata->lenback2)/100;
            $slb=($ppdata->lenbackstr)/100;
            $flb=($ppdata->lenbackfin)/100;

            $qlb=intval($qlb);
            $hlb=intval($hlb);
            $slb=intval($slb);
            $flb=intval($flb);

            $fs=$ppdata->fieldsize;

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
	goto c;
}
if ($quarter <=0){
$quarter=0;
}
if ($half <=0){
$half=0;
}
if ($stretch <=0){
$stretch=0;
}
if ($finish1 <=0){
$finish1=0;
}
$c1=$a-(($quarter/$fs)*100);
$c2=$a-(($half/$fs)*100);
$c3=$a-(($stretch/$fs)*100);
$c4=$a-(($finish1/$fs)*100);
if($finish<=3){
$n1=$n1+$c1;
$n2=$n2+$c2;
$n3=$n3+$c3;
$n4=$n4+$c4;

}


$numbers = array_unique(array($c1,$c2));
// rsort : sorts an array in reverse order (highest to lowest).

 rsort($numbers);

 //echo 'Highest is -'.$numbers[0].', Second highest is -'.$numbers[1];

//$combinedc=$combinedc+((max($c1,$c2)+max($c3+$c4))/2);



$numbers1 = array_unique(array($c3,$c4));
// rsort : sorts an array in reverse order (highest to lowest).

 rsort($numbers1);

 //echo 'Highest is -'.$numbers[0].', Second highest is -'.$numbers[1];

$finish=$ppdata->positionfi;
$countadd=$countadd+1;
 if($countadd==1){
 $odds1=intval($ppdata->posttimeod);
 }
 if($countadd==2){
 $odds2=intval($ppdata->posttimeod);
 }
 if($countadd==3){
 $odds3=intval($ppdata->posttimeod);
 }
            /*
            Only run the following block of code if the user posted to this page with filters
            if filterval1 exists then the user must have submitted filter post variables
            if not everything within this conditional block will be skipped
            The goto operator can be used to jump to another section in the program.
            The target point is specified by a label followed by a colon, and the instruction is given as goto followed by the desired target label*/

            if (isset($_POST['maxRaces'])){

                    //begin POST filters
                    $skip=$_POST['maxRaces'];// Max number of Races?

                    if ($speedfigure_flag>=$skip){ // $lines is how many times the horse ran and how far we have counted
                        $lines=$lines-1; // we skipped something
                        goto b;
                    }

                    $trbl=$_POST['remTrLines'];// Remove Trouble Lines?

                    if (ctype_upper($horsedata->ppdata->shortcomme)) {//if horse had trouble this will be all caps
                        $trbl=$trbl+1;
                    }
                    if ($trbl==2){//yes
                        $lines=$lines-1; //remove from the count of times the horse ran because we are not using the race
                        goto b;
                    }

                    $tcnd=$_POST['exlOffTracks'];// Exclude Off Tracks?

                    if ($ppdata->trackcondi <> "FM" and $ppdata->trackcondi <> "FT"){ // a non-off track "not rain" can only be FM if was running on turf or FT if on dirt.
                        $tcnd=$tcnd+1;
                    }
                    if ($tcnd==2){
                        $lines=$lines-1; //remove from the count of times the horse ran because we are not using the race
                        goto b;
                    }

                    $fsz=$_POST['finPos'];// Finish Position

                   
				   
					if ($finish == "" OR $finish > $fsz){ //did the horse not finish or is the finish farther back than we are willing to accept
                        $lines=$lines-1; //remove from the count of times the horse ran because we are not using the race
                        goto b;
                    }
					

					 $daycheck=$_POST['daysback'];// Finish Position

                    if ($daystoday >= $daycheck){ //was last race within parameters
                        $lines=$lines-1; //remove from the count of times the horse ran because we are not using the race
                        goto b;
                    }
	 $oddscheck=$_POST['oddstoday'];// Finish Position

                    if ($ppdata->posttimeod >= $oddscheck){ //was last race within parameters
                        $lines=$lines-1; //remove from the count of times the horse ran because we are not using the race
                        goto b;
                    }

                    $ssr=$_POST['sameSurToday'];//Same surface as today?

                    if ($tsurf <> $surface){  //Is surface the horse ran on the same as today
                        $ssr=$ssr+1;
                    }
                    if ($ssr==2){
                        $lines=$lines-1;  //remove from the count of times the horse ran because we are not using the race
                        goto b;
                    }

                    $dstminus=$_POST['distMinus'];// Distance minus
                    $dstplus=$_POST['distPlus'];// Distance plus


                    if($distof < ($todaysdist-$dstminus)){  // Checks to see if Today's distance is Equal to or between the minus & plus values and skips it if not.
                        $lines=$lines-1; //remove from the count of times the horse ran because we are not using the race
                        goto b;
                    }
                    if($distof > ($todaysdist+$dstplus)){  // Checks to see if Today's distance is Equal to or between the minus & plus values and skips it if not.
                        $lines=$lines-1; //remove from the count of times the horse ran because we are not using the race
                        goto b;
                    }


            }





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
            $fs=$ppdata->fieldsize;
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
            $posttimeoddsvalue 	    = $ppdata->posttimeod;
            $classratingvalue 		= $ppdata->classratin; //ADDED
            $pacefigurevalue 		= $ppdata->pacefigure; //ADDED
            $pacefigure2value 		= $ppdata->pacefigur2; //ADDED
            $foreign                = $ppdata->foreignspe;
            $turffigurevalue 		= $ppdata->turffigure; //ADDED
            $speedfigurevalue 		= $ppdata->speedfigur;
            //added this line
            $foreign = $foreign -20;

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
            $lines=$lines+1;// we processed a race so count it



c:
  b: //for whatever reason we skipped processing a time the horse ran

  $combinedc=$combinedc+$numbers[0];
$combinedc=$combinedc+$numbers1[0];

e:

        } // end $horsedata as $ppdata loop
//$combinedc=$combinedc+((max($c1,$c2)+max($c3+$c4))/2);
$rsty="";
$rstc=round(max($pacefigureavg+$n1,$pacefigure2avg+$n2,$pacefigureavg3+$n3,$pacefigure2avg4+$n4));
$n1=round($pacefigureavg+$n1);
$n2=round($pacefigure2avg+$n2);
$n3=round($pacefigureavg3+$n3);
$n4=round($pacefigure2avg4+$n4);
//echo $rstc.'='.$n1.'/'.$n3.'/'.' |';
if($rstc==$n1){
$rsty="E/P";
}
if($rstc==$n2){
$rsty="E__";
}
if($rstc==$n3){
$rsty="_P_";
}
if($rstc==$n4){
$rsty="__S";
}



if ($speedfigure_flag<=0){
$classrating_flag=1;
$speedfigure_flag=1;
$posttime_flag=1;
$pacefigure_flag=1;
$pacefigure2_flag=1;
$speedfigure_flag=1;
}
$combinedc=($combinedc/10)*($speedfigure_flag/10);
        $classratingavg 	= ($total_a / $classrating_flag);
		if($classratingavg <= 34){
			$classratingavg = $classfirst;
		}
        $combinedc			=($combinedc/$speedfigure_flag);
        $posttimeoddsavg    = ($total_e / $posttime_flag);
        $pacefigureavg	 	= ($total_b / $pacefigure_flag);
        $pacefigure2avg 	= ($total_c / $pacefigure2_flag);
        $speedfigureavg 	= ($total_d / $speedfigure_flag);
		if($speedfigureavg <= 34){
			$speedfigureavg = $speedfirst;
		}
        $abytavg            = $abyt3/$speedfigure_flag;
		$pacefigureavg3     = (($pacefigureavg*2)+$pacefigure2avg)/3;
        $pacefigure2avg4    = (($pacefigure2avg*2)+$pacefigureavg)/3;
		
d:
        $posttimeoddsavg+$posttimeoddsavg *10;
        
        $averagepace        = ($pacefigureavg+$pacefigure2avg)/2 ;
        $printpace          = max($pacefigureavg,$pacefigure2avg);

        $classratingavg		= (($classratingavg/130)*100)+(130/4) ;
        $speedfigureavg	    = (($speedfigureavg/130)*100)+(130/4) ;



        $jockperc           = ($jockperc/2)+100;
        $trainerperc        = ($trainerperc/2)+100;
        $horseperc          = ($horseperc/2)+100;

        if($equilink == "" ){
            $classratingavg=0;
            $speedfigureavg=0;

        }
        if ($wkdays <=0){
            $classratingavg=$classratingavg-20;
            $speedfigureavg=$speedfigureavg-20;
        }

        echo '<td>'.number_format($jockperc, 0, '.', '').'</td>';
        echo '<td>'.number_format($trainerperc, 0, '.', '').'</td>';
        echo '<td>'.number_format($horseperc, 0, '.', '').'</td>';
        echo '<td>'.round($classratingavg).'</td>';
        echo '<td>'.round($speedfigureavg).'</td>';
$pureclass=round($classratingavg);
        $somefig2= max($classratingavg,$speedfigureavg);
        $somefig2=($somefig2+ max($jockperc,$trainerperc,$horseperc))/2;
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

        $qdisp              = ($pacefigureavg-(($quarter/2)/$lines2));
        $qperc              = ((($quarter/2)/$lines2)/$lines2)*10;
        $hdisp              = $pacefigureavg-(($half/2)/$lines2);
        $sdisp              = $pacefigure2avg-(($stretch/2)/$lines2);
        $fdisp              = $pacefigure2avg-(($finish1/2)/$lines2);
        $sty                = "n/a";
        $qperc              = round($qperc);
        $fs                 = $fs/$lines2;

        if($qperc <= 1 ){
            $sty="E  ".round(((100-$qperc))-$fs);
        }
        if($qperc >=2 and $qperc <=3 ){
            $sty="eP ".round(((100-$qperc))-$fs);
        }
        if($qperc >=4 and $qperc <=5 ){
            $sty="P ".round(((100-$qperc))-$fs);
        }
        if($qperc >=6 ){
            $sty="S    ".round(((100-$qperc))-$fs);
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

        if ($raceperc <= $workperc){
            $raceperc=$workperc;
        }

        if ($days <= $wkdays){
            $days=$wkdays;
        }

        if ($jockperc <= $trainerperc){
            $jockperc=$trainerperc;
        }

        //if ($jockperc <= $horseperc){
        //$jockperc=$horseperc;
        //}

        if ($classratingavg <= $horseperc){
            $classratingavg=$horseperc;
        }

     //   $somefig1=  ($raceperc + $somefig2  + $weighttoday - min($cw,$wkdays));
        $somefig1=  ($raceperc + $somefig2  + $weighttoday - min($cw,$wkdays));
$somefig1=(($somefig1/10)+$combinedc+($speedfigureavg*10));
$somefig1=($somefig1/10)+($combinedc/10);
$somefig1=$somefig1-$dollarvalue+$bonus;

if($wkdays > $days2){
	$wkdays=$days2;
	$workperc=$raceperc;
}


if($rsty==""){
$rsty="na";
}
$minusb=0;
$plusb=0;
if ($wkdays < 8 AND $wkdays >0 ){
$minusb=0;
$plusb=7;
}
if ($wkdays >7 And $wkdays<22){
$minusb=0;
$plusb=5;
}
if ($wkdays >35 ){
$minusb=10;
$plusb=0;
}
if ($wkdays ==0 ){
$minusb=.5;
$plusb=0;
}
$combinedc2=$combinedc;

$combinedc=$combinedc+$plusb-$minusb+(($wkgroup/2)/10);
if($wkrank==1){
$combinedc=$combinedc+3;
}
if (mb_substr($wkfurlongs,0,1) == 5){
$combinedc=$combinedc+2;
}
$combinedc=$combinedc+(($pureclass-100)/10)+$bonus+$combinedc;

 if ($odds1==0){
	 $odds1=100;
 }
  if ($odds2==0){
	 $odds2=100;
 }
  if ($odds3==0){
	 $odds3=100;
 }
 $yes="";
 if($odds1 < $odds2 AND $odds2 < $odds3 ){
	 $add20=(($somefig1/10)*2)+(($somefig1/10)/2);
	 $yes="*";
 }
 $somefig1=$somefig1+((max(($jockperc+100),($trainerperc+100),($horseperc+100)))/20);
$somefig1=$somefig1+$add20;
$somefig1=(($somefig1-20)+$racedata->todays_cls)/2;
        echo '<td>'.number_format($somefig1, 1, '.', '').'</td><td>'.$yes.'</td><td>'.round($combinedc2).'</td><td>'.$rsty.'</td></tr>';

f:



if($finally == 1){
$days=0;
$equilink="fts";
$raceperc=0;
$classratingavg=0;
$speedfigureavg=0;
 //$somefig1=  ($raceperc + $somefig2  + $weighttoday - min($cw,$wkdays));
$somefig1=(((($jockperc+$horseperc+$trainerperc)/3)+$bonus+($fclass/2)+($fclass/3))+$workperc)/2;
$speedfigure_flag=0;
$minusb=0;
$plusb=0;
if ($wkdays < 8 AND $wkdays >0 ){
$minusb=0;
$plusb=7;
}
if ($wkdays >7 And $wkdays<22){
$minusb=0;
$plusb=5;
}
if ($wkdays >35 ){
$minusb=10;
$plusb=0;
}
if ($wkdays ==0 ){
$minusb=.5;
$plusb=0;
}
$combinedc2=$combinedc;

$combinedc=$combinedc+$plusb-$minusb+(($wkgroup/2)/10);
if($wkrank==1){
$combinedc=$combinedc+3;
}
if (mb_substr($wkfurlongs,0,1) == 5){
$combinedc=$combinedc+2;
}
$combinedc=$combinedc+(($pureclass-100)/10)+$bonus+$combinedc;
//$backin=$somefig1;
//$somefig1=$somefig1-($dollarvalue/10);
//$somefig1=($somefig1/10)+$combinedc+($workperc/10);
//$somefig1=$somefig1+$backin-30;
$rsty="";

echo '<td>'.round($days).$cw.'</td><td>'.$equilink.'</td><td>'.number_format($raceperc, 0, '.', '').'</td>';
echo '<td>'.number_format($jockperc+100, 0, '.', '').'</td>';
        echo '<td>'.number_format($trainerperc+100, 0, '.', '').'</td>';
        echo '<td>'.number_format($horseperc+100, 0, '.', '').'</td>';
        echo '<td>'.round($classratingavg).'</td>';
        echo '<td>'.round($speedfigureavg).'</td>';
if($rsty==""){
$rsty="na";
}
$somefig1=$somefig1+((max(($jockperc+100),($trainerperc+100),($horseperc+100)))/4);
if($speedfigure_flag==0){
	$combined2=0;
}
$somefig1=(($somefig1-20)+$racedata->todays_cls)/2;
 echo '<td>'.number_format($somefig1, 1, '.', '').'</td><td> </td><td>'.round($combinedc2).'</td><td>'.$rsty.'</td></tr>';

$firstrow=0;
}
	} // end $racedata as $horsedata loop


	echo '</table>';

	$i++; // increment our counter
sc:
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
				"order": [[ 17, "des" ]],
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
