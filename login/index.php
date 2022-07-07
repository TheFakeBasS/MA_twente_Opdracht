<?php
session_start();
if(!isset($_SESSION["ingelogd"]) || $_SESSION["ingelogd"] !== true){
    header("location: login.php");
    exit; 
}

include "connect.php";
include "functie.php";

echo "vraag         antwoord        categorie";

toonAlleinfo()
?>