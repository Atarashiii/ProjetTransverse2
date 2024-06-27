<?php
include '../config/config.php';

class Grille_model {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getEvaluationData($grille_id, $entreprise_id) {
        $sql = "SELECT entreprise_libelle, question_libelle, reponse_libelle, reponse_valeur, axe_libelle, categorie_libelle, grille_date, grille_commentaire
                FROM grille
                JOIN entreprise ON grille.entreprise_id = entreprise.entreprise_id
                JOIN question ON grille.question_id = question.question_id
                JOIN reponse ON grille.reponse_id = reponse.reponse_id
                JOIN categorie ON question.categorie_id = categorie.categorie_id
                JOIN axe ON categorie.axe_id = axe.axe_id
                WHERE grille_id = ? AND grille.entreprise_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $grille_id, $entreprise_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }

    public function getAvailableGrilles() {
        $sql = "SELECT DISTINCT(grille_id), grille_date, g.entreprise_id, entreprise_libelle  
                FROM grille g
                JOIN entreprise e ON g.entreprise_id = e.entreprise_id";
        $result = $this->conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function closeConnection() {
        $this->conn->close();
    }
}
?>