document.getElementById('exportBtn').addEventListener('click', function() {
    const grille_id = this.getAttribute('data-grille-id');
    const entreprise_id = this.getAttribute('data-entreprise-id');

    if (!grille_id || !entreprise_id) {
        alert('Identifiants de grille ou d\'entreprise non définis.');
        return;
    }

    const url = `../public/index.php?route=api&grille_id=${grille_id}&entreprise_id=${entreprise_id}`;

    window.open(url, '_blank');
});
