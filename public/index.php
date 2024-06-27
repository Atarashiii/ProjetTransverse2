<?php

// Inclusion du fichier de configuration
include '../config/config.php';

// Obtention du contrôleur et de l'action à partir des paramètres GET, avec des valeurs par défaut
$strCtrl = $_GET['ctrl'] ?? 'home';
$strAction = $_GET['action'] ?? 'handleRequest';

// Construction du chemin vers le fichier du contrôleur
$strFile = "../controller/" . ucfirst($strCtrl) . "_controller.php";

// Vérification de l'existence du fichier du contrôleur
if (file_exists($strFile)) {
    // Inclusion du fichier du contrôleur
    require($strFile);
    
    // Construction du nom de la classe du contrôleur
    $strClassName = ucfirst($strCtrl) . "_controller";
    
    // Instanciation du contrôleur
    $objCtrl = new $strClassName($conn);
    
    // Vérification de l'existence de la méthode dans le contrôleur
    if (method_exists($objCtrl, $strAction)) {
        // Appel de la méthode sur le contrôleur
        $objCtrl->$strAction();
    } else {
        // Gestion de l'erreur si la méthode n'existe pas
        die('Méthode non valide');
    }
} else {
    // Gestion de l'erreur si le fichier du contrôleur n'existe pas
    die('Contrôleur non valide');
}
