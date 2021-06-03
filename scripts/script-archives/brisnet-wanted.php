<style>
table, th, td {
  border: 1px solid black;
}

th, td {
  padding: 10px;
}
</style>

<?php

if (($handle = fopen("../docs/brisnet.csv", "r")) !== FALSE) {

    $wantedColumns = array(3,6,7,43,44,45,225,226,227,228,229,230,316,346,506,516,576,577,578,586,587,588,666,667,668,746,876,896,1036,1383);

    $row = 1;

    echo '<table><tbody>';    
    echo '<tr>';
    echo '<th>Field #</th>
        <th>Race #</th>
        <th>Distance</th>
        <th>Surface</th>
        <th>Program #</th>
        <th>MLO</th>
        <th>Horse Name</th>
        <th>CRC</th>
        <th>CRC</th>
        <th>CRC</th>
        <th>CRC</th>
        <th>CRC</th>
        <th>CRC</th>
        <th>Distance</th>
        <th># of entrants</th>
        <th>Weight</th>
        <th>Odds</th>
        <th>First Call Pos</th>
        <th>First Call Pos</th>
        <th>First Call Pos</th>
        <th>Second Call Pos</th>
        <th>Second Call Pos</th>
        <th>Second Call Pos</th>
        <th>1st Call BtnLngths only</th>
        <th>1st Call BtnLngths only</th>
        <th>1st Call BtnLngths only</th>
        <th>Finish BtnLngths only</th>
		<th>2f Fraction (if any)</th>
        <th>4f Fraction (if any)</th>
        <th>Final Time</th>
		<th>commnet</th>';
    echo '</tr>';

    while (($data = fgetcsv($handle, 0, ',', '"', '"')) !== FALSE) {
        // $data represents a single row from the csv

        echo '<tr>';
        echo '<td>' . $row . '</td>';

        $num = count($data);

        for ($c=0; $c < $num; $c++) {

            if (!in_array($c,$wantedColumns)) continue;

            $value = $data[$c-1];

            echo '<td style=" border-bottom: 1px solid rgb(111,180,224);" sdval="9" sdnum="1040;" align="left" bgcolor="#ffffff" height="25"  valign="middle"><font color="#000000" size="2">&nbsp;&nbsp;'.$value.'&nbsp;&nbsp;</font></td>';

		}

        echo '</tr>';
        $row++;
    }

    echo '</tbody></table>';

    fclose($handle);

}

?>