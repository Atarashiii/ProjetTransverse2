<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1>Bienvenue sur notre questionnaire</h1>
    </header>
    <main>
        <p>Cliquez sur le bouton ci-dessous pour commencer le questionnaire.</p>
        <button onclick="nouvelleGrille()">Nouvelle Grille</button>
        <form action="../public/index.php" method="get">
            <select name="id">
                <?php foreach ($grilles as $grille): ?>
                    <option value="<?= $grille['grille_id'] . '-' . $grille['entreprise_id'] ?>">
                        Grille <?= $grille['entreprise_libelle'] . " " . $grille['grille_date'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="ctrl" value="grille">
            <input type="hidden" name="action" value="GrilleIndex">
            <button type="submit">Afficher la grille</button>
        </form>
    </main>
    <script>
        function nouvelleGrille() {
            window.location.href = 'nouvelleGrille.html';
        }
    </script>
</body>
</html>
