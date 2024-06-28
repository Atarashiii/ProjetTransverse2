<?php include 'header.php'; ?>

    <main>
        <form action="index.php?ctrl=grille&action=saveGrille" method="POST">
            <input type="hidden" name="entreprise_id" value="<?php echo $entreprise_id; ?>">
            <?php 
            $current_categorie = null;
            $current_axe = null;
            foreach ($grille_data as $data):
                if ($data['axe_libelle'] != $current_axe) {
                    echo "<h2>" . $data['axe_libelle'] . "</h2>";
                    $current_axe = $data['axe_libelle'];
                }
                if ($data['categorie_libelle'] != $current_categorie) {
                    echo "<h3>" . $data['categorie_libelle'] . "</h3>";
                    $current_categorie = $data['categorie_libelle'];
                }
            ?>
                <div class="question">
                    <h4><?php echo $data['question_libelle']; ?></h4>
                    <?php 
                        $responses = $this->ObjQuestionModel->getAllResponsesByQuestionId($data['question_id']);
                        foreach ($responses as $response):
                    ?>
                        <input type="radio" id="reponse_<?php echo $response['reponse_id']; ?>" name="reponses[<?php echo $data['question_id']; ?>]" value="<?php echo $response['reponse_id']; ?>" <?php echo ($data['reponse_id'] == $response['reponse_id']) ? 'checked' : ''; ?>>
                        <label for="reponse_<?php echo $response['reponse_id']; ?>"><?php echo $response['reponse_libelle']; ?> (<?php echo $response['reponse_valeur']; ?> point)</label><br>
                    <?php endforeach; ?>
                    <label for="commentaire_<?php echo $data['question_id']; ?>">Commentaire :</label>
                    <textarea id="commentaire_<?php echo $data['question_id']; ?>" name="commentaires[<?php echo $data['question_id']; ?>]"><?php echo htmlspecialchars($data['grille_commentaire']); ?></textarea>
                </div>
            <?php endforeach; ?>
            <button type="submit">Enregistrer</button>
        </form>
    </main>

<?php include 'footer.php'; ?>