<style>
  table,
  th,
  td {

    border: 1px solid black;

  }



  th,
  td {

    padding: 10px;

  }
</style>



<?php



if (($handle = fopen("../docs/brisnet.csv", "r")) !== FALSE) {



  $row = 1;

  echo '<table><tbody>';



  while (($data = fgetcsv($handle, 0, ',', '"', '"')) !== FALSE) {

    // $data represents a single row from the csv



    echo '<tr>';

    echo '<td>' . $row . '</td>';



    $num = count($data);



    for ($c = 0; $c < $num; $c++) {



      $value = $data[$c];



      echo '<td style=" border-bottom: 1px solid rgb(111,180,224);" sdval="9" sdnum="1040;" align="left" bgcolor="#ffffff" height="25"  valign="middle"><font color="#000000" size="2">&nbsp;&nbsp;' . $value . '&nbsp;&nbsp;</font></td>';
    }



    echo '</tr>';

    $row++;
  }



  echo '</tbody></table>';

  fclose($handle);
}



?>