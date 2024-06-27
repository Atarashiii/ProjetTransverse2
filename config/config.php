<?php
// config.php

include_once 'database.php'; // Inclusion de la classe Database

$servername = "10.10.10.50";
$username = "operator";
$password = "root";
$dbname = "app";

// Création d'une instance de Database pour gérer la connexion
$database = new Database($servername, $username, $password, $dbname);

// Récupération de l'objet de connexion pour être utilisé dans d'autres fichiers
$conn = $database->getConnection();

if (!defined('APP_VERSION')) {
    define('APP_VERSION', '1.1.6');
}

?>
