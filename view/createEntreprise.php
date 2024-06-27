<?php include 'header.php'; ?>

    <main>
        <form action="index.php?ctrl=entreprise&action=createEntreprise" method="POST">
            <label for="nom_entreprise">Nom de l'entreprise :</label>
            <input type="text" id="nom_entreprise" name="nom_entreprise" required>
            <br>
            <label for="commentaire">Commentaire :</label>
            <textarea id="commentaire" name="commentaire" required></textarea>
            <br>
            <button type="submit">Créer</button>
        </form>
    </main>

<?php include 'footer.php'; ?>