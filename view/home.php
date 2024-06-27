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
        <p>Séléctionner votre résultat :</p>
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
        <form>
            <br>
            <br>
            <input type="hidden" name="ctrl" value="api">
            <input type="hidden" name="action" value="listEndpoints">
            <button type="submit">Accès à l'api</button>
        </form>
    </main>
</body>
</html>
