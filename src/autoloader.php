<?php

function autoload() {
    include '../config/config.php';

    $dir    = '../include/';
    $includes = scandir($dir);

    for ($i=0; $i<count($includes); $i++) {
        if( $includes[$i] != '.' && $includes[$i] != '..' ) {
            include $dir.$includes[$i];
        }
    }
}

?>
