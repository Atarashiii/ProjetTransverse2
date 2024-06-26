<?php
// config.php

$servername = "172.16.47.190"; 
$username = "operator";  
$password = "root";     
$dbname = "app";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}

// Configurer la connexion pour utiliser UTF-8
$conn->set_charset("utf8");
?>
