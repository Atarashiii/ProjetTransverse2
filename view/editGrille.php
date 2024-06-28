<?php include 'header.php'; ?>

    <main>
        <form action="index.php?ctrl=grille&action=saveGrille" method="post">
            <input type="hidden" name="entreprise_id" value="<?php echo htmlspecialchars($entreprise_id); ?>">
            <?php
            if (!empty($grille_data)) {
                foreach ($grille_data as $question) {
                    echo "<div class='question'>";
                    echo "<h3>" . htmlspecialchars($question['question_libelle']) . "</h3>";
                    echo "<ul>";
                    $question_id = $question['question_id'];
                    foreach ($question['responses'] as $response) {
                        $checked = $response['reponse_id'] == $question['reponse_id'] ? 'checked' : '';
                        echo "<li><label>";
                        echo "<input type='radio' name='reponses[" . $question_id . "]' value='" . $response['reponse_id'] . "' $checked> ";
                        echo htmlspecialchars($response['reponse_libelle']) . " (" . $response['reponse_valeur'] . " point)";
                        echo "</label></li>";
                    }
                    echo "</ul>";
                    echo "</div>";
                }
            } else {
                echo "Aucune question trouvée.";
            }
            ?>
            <button type="submit">Enregistrer les modifications</button>
        </form>
    </main>

<?php include 'footer.php'; ?>