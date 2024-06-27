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
        <ul>
            <?php foreach ($endpoints as $name => $url): ?>
                <li><strong><?= $name ?>:</strong> <a href="<?= $url ?>" target="_blank"><?= $url ?></a></li>
            <?php endforeach; ?>
        </ul>
    </main>
</body>
</html>
