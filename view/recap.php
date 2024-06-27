<?php include 'header.php'; ?>

    <main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <section>
            <?php 
            // Variables pour garder en mémoire les valeurs précédentes
            $prev_axe = null;
            $prev_categorie = null;
            foreach ($data as $row): ?>
                <?php if ($row['axe_libelle'] !== $prev_axe): ?>
                    <h1 class="axe"><?= $row['axe_libelle'] ?></h1>
                    <?php $prev_axe = $row['axe_libelle']; ?>
                <?php endif; ?>

                <?php if ($row['categorie_libelle'] !== $prev_categorie): ?>
                    <h2><?= $row['categorie_libelle'] ?></h2>
                    <?php $prev_categorie = $row['categorie_libelle']; ?>
                <?php endif; ?>

                <div class="question">
                    <h3><?= $row['question_libelle'] ?></h3>
                    <ul>
                        <li class="choix"><?= $row['reponse_valeur'] ?> point - <?= $row['reponse_libelle'] ?></li>
                    </ul>
                    <p>Suggestion : <?= $row['grille_commentaire'] ?></p>
                </div>
            <?php endforeach; ?>

            <canvas id="chart" data-axes='<?= json_encode($moyennes_par_axe) ?>'></canvas>
            <script src="../diagnostic_script.js"></script>
        </section>
    </main>

<?php include 'footer.php'; ?>