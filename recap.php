
<?php
// Récupération de l'ID de la grille
$grille_id = isset($_GET['id']) ? $_GET['id'] : die('ID de grille non spécifié.');

// Utiliser $grille_id dans votre requête SQL pour filtrer les données
$sql = "SELECT question_libelle, reponse FROM résultats WHERE grille_id = $grille_id";  // Adaptez cette requête selon votre base de données

// Définir l'encodage des en-têtes HTML en UTF-8
header('Content-Type: text/html; charset=utf-8');

$servername = "localhost"; 
$username = "root";  
$password = "root";     
$dbname = "projettranseverse2"; 

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}
// Configurer la connexion pour utiliser UTF-8
$conn->set_charset("utf8");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de l'Évaluation de la Maturité</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header>
        <h1>Résultats de l'Évaluation de la Maturité</h1>
    </header>
    <main>
        <section>
            <?php
            // Récupération de l'ID de la grille
            $value  = isset($_GET['id']) ? $_GET['id'] : die('ID de grille non spécifié.');

            // Séparation des valeurs
            list($grille_id, $entreprise_id) = explode('-', $value);

            $sql = "SELECT entreprise_libelle,question_libelle, reponse_libelle, reponse_valeur, axe_libelle, categorie_libelle, grille_date, grille_commentaire
                    FROM grille
                    JOIN entreprise ON grille.entreprise_id = entreprise.entreprise_id
                    JOIN question ON grille.question_id = question.question_id
                    JOIN reponse ON grille.reponse_id = reponse.reponse_id
                    JOIN categorie ON question.categorie_id = categorie.categorie_id
                    JOIN axe ON categorie.axe_id = axe.axe_id
                    WHERE grille_id = $grille_id AND grille.entreprise_id = $entreprise_id"; 

            $result = $conn->query($sql);

            // Variables pour garder en mémoire les valeurs précédentes
            $prev_axe = null;
            $prev_categorie = null;

            // Tableau pour stocker les valeurs des réponses par axe
            $totaux_par_axe  = array();

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Initialiser l'entrée pour cet axe si elle n'existe pas encore
                    if (!isset($totaux_par_axe[$row["axe_libelle"]])) {
                        $totaux_par_axe[$row["axe_libelle"]] = 0;
                    }

                    // Ajouter la valeur de cette réponse à l'axe correspondant
                    $totaux_par_axe[$row["axe_libelle"]] += $row["reponse_valeur"];

                    // Vérifier si l'axe a changé pour afficher son total
                    if ($row["axe_libelle"] != $prev_axe) {
                        // Mettre à jour l'axe précédent
                        echo "<h1 class='axe'>" . $row["axe_libelle"] . "</h1>";
                        $prev_axe = $row["axe_libelle"];
                    }
                    
                    // Vérifier si la catégorie a changé
                    if ($row["categorie_libelle"] != $prev_categorie) {
                        echo "<h2>" . $row["categorie_libelle"] . "</h4>";
                        $prev_categorie = $row["categorie_libelle"];
                    }
                    
                    // Afficher la question et sa réponse
                    echo "<div class='question'>";
                    echo "<h3>" . $row["question_libelle"] . "</h3>";
                    echo "<ul><li class='choix'>" . $row["reponse_valeur"] . " point - " . $row["reponse_libelle"] . "</li></ul>";
                    echo "<p>Suggestion : " . $row["grille_commentaire"] . "</p>";
                    echo "</div>";

                }
            } else {
                echo "0 résultats";
            }
            ?>
            <canvas id="chart" data-axes='
            <?php
            // Diviser les totaux par les nombres spécifiques
            $diviseurs = [
                "Axe Compétence" => 9,
                "Axe Réactivité" => 11,
                "Axe Numérique" => 20,
            ];

            $moyennes_par_axe = [];
            foreach ($totaux_par_axe as $axe => $total) {
                if (isset($diviseurs[$axe])) {
                    $moyennes_par_axe[$axe] = ($total / $diviseurs[$axe]) * 2.5;
                } else {
                    $moyennes_par_axe[$axe] = null; 
                }
            }
            // Récupération de l'ID de la grille
            $grille_id = isset($_GET['id']) ? $_GET['id'] : die('ID de grille non spécifié.');

            $sql = "SELECT question_libelle, reponse FROM résultats WHERE grille_id = $grille_id";  
            echo json_encode($moyennes_par_axe); ?>'></canvas>
            <script src="diagnostic_script.js"></script>
        </section>
    </main>
    <?php $conn->close(); ?>
</body>
</html>
