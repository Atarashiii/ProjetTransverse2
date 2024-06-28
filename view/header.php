<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Titre</title>
    <link rel="stylesheet" href="../style.css"> 
</head>
<body>
    <header>
    <?php
        // Tableau associatif des titres par défaut
        $pageTitles = [
            'HomeHomeIndex' => "Diagnostic digitalisation d'entreprise",
            'GrilleGrilleIndex' => "Résultats de l'Évaluation de la Maturité",
            'EntrepriseEntrepriseIndex' => "Saisie d'Entreprise",
            'GrilleEditGrille' => "Saisie du formulaire",
            'ApiListEndpoints' => "Page API"
        ];

        // Récupération du contrôleur et de l'action depuis les paramètres GET
        $strCtrl = $_GET['ctrl'] ?? 'Home';
        $strAction = $_GET['action'] ?? 'HomeIndex';

        // Construction de la clé pour rechercher le titre correspondant
        $currentPageKey = ucfirst($strCtrl) . ucfirst($strAction);

        // Vérification si la clé existe dans le tableau des titres
        $pageTitle = isset($pageTitles[$currentPageKey]) ? $pageTitles[$currentPageKey] : 'Diagnostic digitalisation d\'entreprise';
        ?>
        <h2><?php echo $pageTitle; ?></h2>
        <a href="index.php" class="btn-home">Accueil</a>
    </header>
