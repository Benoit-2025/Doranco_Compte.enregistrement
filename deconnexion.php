<?php

// je fais appel à init car j'ai besoin de session_start();
require_once "inc/init.php";


if(isConnected()){
    // j'enleve le membre de la session
    unset($_SESSION['membre']);
}

//je redirige vers la page souhaitée.
header("location:connexion.php");

exit;

?>