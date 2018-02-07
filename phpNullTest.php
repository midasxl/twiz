<?php

function printName($name = null) {
  $name = $name ?: 'default';

  echo $name."\n";
}

printName();// will result in default, because no value is being passed.  $name will take the value of null
printName('test');// will result in test, because the value 'test' is being passed.

/*

if( $start ) {
    $start = $start;
} else {
    $start = 1;
}

$start = $start ?: 1;

--or--

if( $valid ) {
    $x = 'yes';
} else {
    $x = 'no';
}

$x = $valid ? 'yes' : 'no';

*/