<?php


/*
*fonction DEV qui permet un affichage clair  des donneés(array, string,number...)

*/
function debug($value){
    echo "<pre>";
    print_r($value);
    echo "</pre>";

}


function isConnected():bool{
    return isset($_SESSION['membre']) ? TRUE : FALSE;
}
