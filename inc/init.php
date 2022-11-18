<?php
try {

    $type_bdd = "mysql";

    $host = "localhost";

    $dbname ="php_compte";

    $username = "root";

    $password = "";

    $option = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC //ici je definie que le mode d récupération des données par défautsera sous forme associative
    ];

    $bdd = new PDO("$type_bdd:host=$host;dbname=$dbname", $username, $password, $option);
    
    



} catch (Exception $e) {
    
    die("ERREUR CONNEXION : ".$e->getMessage());
}


// appel de mes fonctions
require_once "functions.php";


// déclaration deux variables "global"
$errorMessage = "";

$successMessage = "";