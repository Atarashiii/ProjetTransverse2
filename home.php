<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Bienvenue sur notre questionnaire</h1>
    </header>
    <main>
        <p>Cliquez sur le bouton ci-dessous pour commencer le questionnaire.</p>
        <button onclick="nouvelleGrille()">Nouvelle Grille</button>
        <?php
            // Connexion à la base de données
            $servername = "localhost"; 
            $username = "root";  
            $password = "root";     
            $dbname = "projettranseverse2";
            $conn = new mysqli($servername, $username, $password, $dbname);
            $conn->set_charset("utf8");

            if ($conn->connect_error) {
                die("Échec de la connexion: " . $conn->connect_error);
            }

            // Récupération des grilles disponibles
            $sql = "SELECT DISTINCT(grille_id),grille_date,g.entreprise_id,entreprise_libelle  FROM grille g
                    JOIN entreprise e ON g.entreprise_id = e.entreprise_id "; // Assurez-vous que cette requête correspond à votre structure de base de données
            $result = $conn->query($sql);

            echo '<form action="recap.php" method="get">';
            echo '<select name="id">';
            while($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['grille_id'] . '-' . $row['entreprise_id'] . '">Grille ' . $row['entreprise_libelle'] . " " . $row['grille_date'] . '</option>';
            }            
            echo '</select>';
            echo '<button type="submit">Afficher la grille</button>';
            echo '</form>';
            $conn->close();
        ?>
    </main>
    <script>
        function nouvelleGrille() {
            window.location.href = 'nouvelleGrille.html';
        }
    </script>
</body>
</html>
