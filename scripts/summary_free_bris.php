<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Twiz sheet</title>
    <!--To have DataTables styled in the same manner as other jQuery UI widgets, all you need to do, as well as including the DataTables core Javascript fileon your page, is include the DataTables / jQuery UI CSS and Javascript integration files.-->
    <link rel="stylesheet" media="screen" href="../assets/css/ui-theme/jquery-ui.min.css" /><!-- jquery theme -->
    <link rel="stylesheet" media="screen" href="../assets/css/dataTables.jqueryui.css" /><!-- datatables css integration file -->
    <style>
        body,
        html {
            font-size: 12px;
        }

        .clear {
            clear: both;
        }

        #card-header {
            background: #4f7c39 url(../img/card-bg.jpg) repeat-x top left;
            width: 100%;
            padding-bottom: 15px;
            overflow: auto;
        }

        #card-header img {
            float: left;
            position: relative;
            top: 12px;
            left: 15px;
        }

        #card-header h1 {
            color: #fff;
            float: left;
            position: relative;
            left: 15px;
        }

        table {
            border-collapse: collapse;
            border: 2px solid #000;
            font: normal 80%/140% arial, helvetica, sans-serif;
            color: #555;
            background: #fff;
        }

        td,
        th {
            border: 1px dotted #bbb;
            padding: .5em;
        }

        caption {
            padding: 0 0 .5em 0;
            text-align: left;
            font-size: 1.4em;
            font-weight: bold;
            text-transform: uppercase;
            color: #333;
            background: transparent;
        }

        /* =links----------------------------------------------- */
        table a {
            padding: 1px;
            text-decoration: none;
            font-weight: bold;
            background: transparent;
        }

        table a:link {
            border-bottom: 1px dashed #ddd;
            color: #000;
        }

        table a:visited {
            border-bottom: 1px dashed #ccc;
            text-decoration: line-through;
            color: #808080;
        }

        table a:hover {
            border-bottom: 1px dashed #bbb;
            color: #666;
        }

        /* =head =foot----------------------------------------------- */
        thead th,
        tfoot th {
            border: 2px solid #000;
            text-align: left;
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
            background: transparent;
        }

        tfoot td {
            border: 2px solid #000;
        }

        /* =body----------------------------------------------- */
        tbody th,
        tbody td {
            vertical-align: top;
            text-align: left;
        }

        tbody th {
            white-space: nowrap;
        }

        .odd {
            background: #fcfcfc;
        }

        tbody tr:hover {
            background: #fafafa;
        }
    </style>
</head>

<body>
    <?php
    $count = 0;
    if (($handle = fopen("../docs/brisnet.csv", "r")) !== FALSE) {

        while (($data = fgetcsv($handle, 0, ',', '"', '"')) !== FALSE) { // $data represents a single row from the csv

            for ($b = 0; $b < 2; $b++) {
                
                if ($count == 0) { // this will be true only once, and print the card header, key and date
                    $headerdate         = $data[1];
                    $headerdate1        = date_create($headerdate);
                    $headerdate2        = date_format($headerdate1, "M d, Y");
                    echo '<div id="card-header"><img src="../assets/img/logo-twiz.png" /></div><br>';
                    echo '<p>Key: A=Program Number, B=Horses Name, C=Last race surface, D=TWIZ figure, E=Date of last race, Comment and Jockey+Trainer ranking, F=1/4m position(lengths back), 1/2m position(lengths back) & lenghts back in stretch), G=Last race odds, H=Morning line odds.</p>';
                    echo '<B><h2>' . $data[0] . ' | ' . $headerdate2 . '</h2></b>';
                }
                if ($data[2] <> $count) { // data[2] is the race number, <> is inequality
                    echo '<table class="display table"><thead><th> A </th><th> B </th><th> C </th><th> D </th><th> E </th><th> F </th><th> G </th><th> H </th></thead>';
                    echo '<div><p>Race: ' . $data[2] . ' | ' . round(($data[5] / 220), 1) . 'f on ' . $data[6] . ' : ' . $data[224] . $data[225] . $data[226] . $data[227] . $data[228] . $data[229] . '</p></div>';
                    $count = $data[2];
                }
                $xxx = 0;
                if (($data[315 + $b] / 220) < 8) {
                    $xxx = 11;
                }
                if (($data[315 + $b] / 220)  >= 8) {
                    $xxx = 12;
                }
                $finaltime = $data[1035 + $b];
                $distance = $data[315 + $b] / 220;
                $myspeedw = 100 + (($distance * $xxx) - $finaltime);
                $pace2 = 0.0;
                $pace2 = $data[895 + $b];
                if ($pace2  >= 59) {
                    $pace2 = $data[875 + $b];
                }
                $hmile = 100 + (43.2 - $pace2);
                $p1 = $data[565 + $b];
                $p2 = $data[655 + $b];
                if ($data[575 + $b] == 1) {
                    $p2 = $p2 - ($p2 * 2);
                }
                $p3 = $data[675 + $b];
                if ($data[585 + $b] == 1) {
                    $p3 = $p3 - ($p3 * 2);
                }
                $p4 = $data[715 + $b];
                if ($data[605 + $b] == 1) {
                    $p4 = $p4 - ($p4 * 2);
                }
                $pacetime = $hmile + $myspeedw + (($p3 - $p4) / 2);
                $hmileraw = 0.0;
                $hmileraw = $hmile - ($ppdata->positionfi);
                $hmile = $hmile;
                $rss = $data[575 + $b] . ' (' . $p2 . ') ' . $data[585 + $b] . ' (' . $p3 . ') , ' . $p4;
                $jkpercw = 0;
                if ($data[1146 + $b] > 0) {
                    $jkpercw = ($data[1147 + $b] / $data[1146 + $b]) * 100;
                }
                if ($data[1151 + $b] > 0) {
                    $jkpercw = $jkpercw + ($data[1152 + $b] / $data[1151 + $b]) * 100;
                }
                if ($data[1156 + $b] > 0) {
                    $jkpercw = $jkpercw + ($data[1157 + $b] / $data[1156 + $b]) * 100;
                }
                if ($data[1161 + $b] > 0) {
                    $jkpercw = $jkpercw + ($data[1162 + $b] / $data[1161 + $b]) * 100;
                }
                $pacetime = $pacetime + $hmile;
                $pacetime = ($pacetime - 300) - $data[43 + $b] + ($jkpercw / 10);
                $pacetime = round($pacetime, 0);
                $choose1 = $data[43 + $b];
                if ($data[515 + $b] < $data[43 + $b]) {
                    $choose1 = $data[515 + $b];
                }
                $pacetime = $hmile + $myspeedw - $choose1;
                echo '<tr>';
                echo '<td>' . $data[42] . '</td>';
                echo '<td>' . $data[44] . '</td>';
                echo '<td>' . $data[325 + $b] . '</td>';
                echo '<td>' . $pacetime . '</td>';
                echo '<td>' . $data[1382 + $b] . ' (' . round($jkpercw / 10, 0) . ')</td>';
                echo '<td>' . $rss . '</td>';
                echo '<td>' . $data[515 + $b] . '</td>';
                echo '<td>' . $data[43] . '</td>';
                echo '</tr>';
            }
        }
        echo '</tbody></table>';
    }

    fclose($handle);

    ?>
    
    <script src="../assets/js/jquery-1.11.1.js"></script>
    <script src="../assets/js/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/js/datatables/dataTables.jqueryui.js"></script>
    <script src="../assets/js/natural.js"></script>
    <script>
        $(document).ready(function() {
            $('table.display').dataTable({
                "retrieve": true,
                "paging": false,
                "ordering": true,
                "info": false,
                "bFilter": false,
                "order": [
                    [3, "desc"]
                ],
                columnDefs: [{
                    type: 'natural',
                    targets: 0
                }, {
                    type: 'natural',
                    targets: 2
                }, ]
            });
            $('#printMe').click(function() {
                window.print();
                return false;
            });
            $('#showlegend').click(function(e) {
                e.preventDefault();
                $('#legend').slideToggle('slow');
            });
        });
    </script>
</body>

</html>