<?php include 'header.php'; ?>

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
            <button type="submit">Accès à l'API</button>
        </form>
    </main>

<?php include 'footer.php'; ?>
