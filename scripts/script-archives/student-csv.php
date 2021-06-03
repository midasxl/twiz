<?php
    $f_pointer=fopen("../docs/student.csv","r"); // file pointer

    //while (($csv_data = fgetcsv($f_pointer, 0, ',', '"', '"')) !== FALSE) {
        //print_r($csv_data);
    //}

    while(! feof($f_pointer)){

        $ar=fgetcsv($f_pointer, 0, ',', '"', '"');
        echo print_r($ar); // print the array 
        echo "<br>";

    }
?>