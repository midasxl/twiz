<!DOCTYPE html>

<html>

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Summary Twiz sheet</title>



        <link rel="stylesheet" media="screen" href="../assets/css/ui-theme/jquery-ui.min.css" /><!-- jquery theme -->

        <link rel="stylesheet" media="screen" href="../assets/css/dataTables.jqueryui.css" /><!-- datatables css integration file -->

        <link rel="stylesheet" media="screen" href="../assets/css/twiztooltip.css" /><!-- rulesets for tooltip on datatable columns -->

        <link rel="stylesheet" media="screen" href="../assets/css/summary.css" /><!-- rulesets for summary sheet -->



    </head>



<body>



<?php

$source = '../../uploads/'.$_POST["card"];

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

echo '<div id="card-header" style="position:relative;">
<img src="../assets/img/logo-twiz.png" />
<h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$trackloc.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$headerdate2.'</h1>
<a style="float:right;color:#fff;padding:8px;" href="" id="printMe">Print This Card</a>';

if (isset($_POST['maxRaces'])){
    echo '<select style="position:absolute;right:5px;bottom:5px;">';
    foreach ($_POST as $key => $value) {
        echo "<option>$key&nbsp;&nbsp;$value</option>";
    }
    echo '</select>';
}

echo '</div>';



echo '<div id="legend" style="display:none;"><img src="../img/legend_summary.jpg" /></div>';



$anchorNum = 0;



// count number of <racedata> nodes in the entire document to get number of races for the jump anchors

$xmlDoc = new DOMDocument();

$xmlDoc->load($source);

$raceNum = $xmlDoc->getElementsByTagName("racedata");

$numOfraces = $raceNum->length;

$i = 0; // generic counter



// loop time

foreach($xmldata->children() as $racedata) { // gets all <racedata> children of the root element <data>



    // get and format date for each race header

    $formatme1 			    = $racedata->race_date;

    $formatme2			    = $horsedata->$ppdata->racedate[0];

    $days2              = (strtotime($formatme1) - strtotime($formatme2)) / (60 * 60 * 24);

    $date1				      = date_create($formatme1);

    $race_date 			    = date_format($date1,"m-d-y");

    $race_date_header 	= date_format($date1,"mdy");

    $equilinkracedate2 	= date_format($date1,"m/d/y");

    $anchorNum 			    = $anchorNum + 1;

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



    // Create race header

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

  <span style="display:none;" id="classNum'.$i.'">'.$racedata->todays_cls.'</span>

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

    echo '<hr />

    <a href="#" id="table'.$i.'" class="filters hideRows">Show only checked rows</a>&nbsp;&nbsp;|&nbsp;&nbsp;

    <a href="#" id="table'.$i.'" class="filters restoreRows">Restore hidden rows</a>

    <div id="spacer"></div>

    <table class="display table'.$i.'">

    <thead><tr>

        <th class="tooltip tooltip-top" data-tooltip="Program Number">Pr</th>

        <th class="tooltip tooltip-top" data-tooltip="Select rows to be shown/hidden">__</th>

        <th class="tooltip tooltip-top" data-tooltip="Name of Horse">Name</th>

        <th class="tooltip tooltip-top" data-tooltip="m/e">m/e<b/th>

        <th class="tooltip tooltip-top" data-tooltip="Ml">Ml</th>

        <th class="tooltip tooltip-top" data-tooltip="Jockey and Trainer">J/T</th>

        <th class="tooltip tooltip-top" data-tooltip="Lw">Lw</th>

        <th class="tooltip tooltip-top" data-tooltip="Wk">Wk</th>

        <th class="tooltip tooltip-top" data-tooltip="Wf">Wf</th>

        <th class="tooltip tooltip-top" data-tooltip="Dys">Dys</th>

        <th class="tooltip tooltip-top" data-tooltip="Last race date and link to chart">Lr</th>

        <th class="tooltip tooltip-top" data-tooltip="Rf">Rf</th>

        <th class="tooltip tooltip-top" data-tooltip="Jockey Figure">Jk</th>

        <th class="tooltip tooltip-top" data-tooltip="Trainer Figure">Tr</th>

        <th class="tooltip tooltip-top" data-tooltip="Horse Figure">Hr</th>

        <th class="tooltip tooltip-top" data-tooltip="Class Figure">Cl</th>

        <th class="tooltip tooltip-top" data-tooltip="Sp">Sp</th>

        <th class="tooltip tooltip-top" data-tooltip="Twiz Figures with Predictability">Twiz</th>

        <th class="tooltip tooltip-top" data-tooltip="#">#</th>

        <th class="tooltip tooltip-top" data-tooltip="ap%">ap%</th>

        <th class="tooltip tooltip-top-left" data-tooltip="rs">rs</th>

    </tr></thead>

    <tbody>';



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

// this gets skipped if the above condition is true

$finally=1;

goto f;

g:



 $add20=0;

 $countadd=0;



 foreach($horsedata->ppdata as $ppdata) { // gets <ppdata> node







$checkspeed=(int)$ppdata->speedfigur;

$checkep=(int)$ppdata->pacefigure;

$checklp=(int)$ppdata->pacefigur2;



if( $checkspeed<= 0 AND $checkep <=0 AND $checklp <=0){

	goto e;

}

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



            /*

            Only run the following block of code if the user posted to this page with filters

            if filterval1 exists then the user must have submitted filter post variables

            if not everything within this conditional block will be skipped

            The goto operator can be used to jump to another section in the program.

            The target point is specified by a label followed by a colon, and the instruction is given as goto followed by the desired target label*/

$l=0;

            if (isset($_POST['maxRaces'])){

$l=$speedfigureavg;

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

 b: //for whatever reason we skipped processing a time the horse ran

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

 if ($odds1==0){

	 $odds1=100;

 }

  if ($odds2==0){

	 $odds2=100;

 }

  if ($odds3==0){

	 $odds3=100;

 }



c:







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



 $yes="";



 if($odds1 < $odds2 AND $odds2 < $odds3 ){

	 $add20= 10;

	 $yes="*";

 }


$somefig1=$add20;

$somefig1=$somefig1+max($horseperc+100,$trainerperc+100,$jockperc+100);

$somefig1=$somefig1+max($workperc,$raceperc);

$somefig1=$somefig1+max($classratingavg,$speedfigureavg)*10;

$somefig1=$somefig1/4;

$somefig1=$somefig1-$dollarvalue;

$somefig1=$somefig1+$combinedc2;
$somefig1=(($somefig1*10)-3000)/10;
$somefig1=($somefig1+$racedata->todays_cls);
        echo '<td><B>'.number_format($somefig1, 1, '.', '').'</b></td><td>'.$yes.'</td><td>'.round($combinedc2).'</td><td>'.$rsty.'</td></tr>';

$yes="";

f:

$yes="";





if($finally == 1){

$days=0;

$equilink="fts";

$raceperc=0;

$classratingavg=0;

$speedfigureavg=0;





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



if($speedfigure_flag==0){

	$combined2=0;

}

$somefig1=0;

$somefig1=$somefig1+max($horseperc+100,$trainerperc+100,$jockperc+100);

$somefig1=$somefig1+$workperc;

$somefig1=$somefig1/3;

$somefig1=$somefig1-$dollarvalue+25;

$somefig1=(($somefig1*10)-3000)/10;
$somefig1=($somefig1+$racedata->todays_cls);

 echo '<td><B>'.number_format($somefig1, 1, '.', '').'</b></td><td> </td><td>'.round($combinedc2).'</td><td>'.$rsty.'</td></tr>';



$firstrow=0;

}

	} // end $racedata as $horsedata loop





	echo '</tbody>

  <tfoot>

    <tr>

      <th id="twizStdDev" colspan="17">Predictability :</th>

      <td id="stdDevTotal'.$i.'"></td>

    </tr>

   </tfoot>

   </table>';

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

  	$(".hideRows").click(function(e){

      e.preventDefault();

  		var target = $(this).prop('id');

  		target = '.' + target;

  		$(target).find('input[type="checkbox"]').each(function(){

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



    // IIFE to calculate standard deviation on all twiz figures per race

    /* first get a count on the number of races, this will tell us how many tables there are.

      then create a loop with the number of races as the count maximum

    */



    (function (){

      // get number of Races from a php variable that already holds this information

      var raceTally='<?php echo $numOfraces; ?>';

      // start loop based on that number starting at 0

      for(var i = 0; i < raceTally; i++) {

          var TableData;

          TableData = storeTblValues(i);

          //convert array of strings to an array of integers

          var arrayOfNumbers = TableData.map(Number);

          //alert(arrayOfNumbers);

          var stdDev;

          stdDev = standardDeviation(arrayOfNumbers);//send array to standardDeviation function

          //alert("Standard Deviation: " + stdDev);

          var classNum = $('#classNum' + i).html();

          //alert("Class Number: " + classNum);

          var totalStdDev = parseFloat(stdDev) + parseFloat(classNum);

          //alert("Total SD: " + totalStdDev);

          fixedStdDev = totalStdDev.toFixed(2);

          //alert("Total SD fixed 2: " + fixedStdDev);

          roundedStdDev = Math.round(fixedStdDev);

          //alert("Rounded SD: " + roundedStdDev);

          $("#stdDevTotal" + i).text(roundedStdDev);//output sd to div on page

      }

    })();



    function storeTblValues(i){

        var TableData = new Array();

        $('#DataTables_Table_' + i + ' tr').each(function(row, tr){

            TableData[row]=$(tr).find('td:eq(17)').text();

        });

        TableData.shift();  // first row will be empty - so remove

        TableData.pop(); // last element will be 0 - so remove

        return TableData;

    }



    // standard deviation logic for legacy purposes

    /*$(function(){

      var stdDev = standardDeviation([1, 2, 3, 4, 5, 6, 7, 8, 9, 25]);

      $("#stdDev").text(avg);

    });*/



    function standardDeviation(values){

        // get the average of the data set

        var avg = average(values); // call average function

        // calculate difference between each array value and the average value

        // map function will iterate over array items and return a new array of these values

        var squareDiffs = values.map(function(value){

          var diff = value - avg;

          // square the differences of each value in this step as well

          var sqrDiff = diff * diff;

          return sqrDiff;

        });

        // get the average of the squared differences

        var avgSquareDiff = average(squareDiffs); // call average function

        // calculate the square root of the average squared differences

        // final result is the standard deviation for the data set

        var stdDev = Math.sqrt(avgSquareDiff);

        return stdDev;

    }



    function average(data){

      // reduce iterates over every array value and produces a single result

      // produces a sum of all the item in the array

      var sum = data.reduce(function(sum, value){

        return sum + value;

      }, 0);

      // divide the sum by the number of items in the array to get average

      var avg = sum / data.length;

      return avg;

    }

});

</script>

</body>

</html>
