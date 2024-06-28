<?php
include '../config/config.php';

class Grille_model {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getEvaluationData($grille_id, $entreprise_id) {
        $sql = "SELECT entreprise_libelle, axe_libelle, categorie_libelle, question_libelle, reponse_valeur, reponse_libelle, grille_date, grille_commentaire
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

    public function createGrilleForEntreprise($entreprise_id) {
        // Créer une grille avec des réponses par défaut (réponse_valeur = 0)
        $date = date('Y-m-d H:i:s');
        $values = array();

        // Insérer 40 lignes dans la table grille pour l'entreprise donnée
        for ($question_id = 1; $question_id <= 40; $question_id++) {
            // Trouver la réponse_id pour cette question où reponse_valeur = 0
            $sql = "SELECT reponse_id FROM reponse WHERE question_id = $question_id AND reponse_valeur = 0";
            $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $reponse_id = $row['reponse_id'];
                $values[] = "(1, $entreprise_id, $question_id, $reponse_id, '$date', ' ')";
            }
        }

        if (!empty($values)) {
            $sql = "INSERT INTO grille (grille_id, entreprise_id, question_id, reponse_id, grille_date, grille_commentaire) VALUES " . implode(", ", $values);
            if ($this->conn->query($sql) === TRUE) {
                return true;
            } else {
                return "Erreur lors de la création de la grille : " . $this->conn->error;
            }
        } else {
            return "Aucune réponse par défaut trouvée.";
        }
    }

    public function getGrilleByEntrepriseId($entreprise_id) {
        $sql = "SELECT g.grille_id, g.entreprise_id, g.question_id, g.reponse_id, q.question_libelle, r.reponse_libelle 
                FROM grille g
                JOIN question q ON g.question_id = q.question_id
                JOIN reponse r ON g.reponse_id = r.reponse_id
                WHERE g.entreprise_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $entreprise_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getGrilleIdByEntrepriseId($entreprise_id) {
        $sql = "SELECT grille_id FROM grille WHERE entreprise_id = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $entreprise_id);
        $stmt->execute();
        $stmt->bind_result($grille_id);
        $stmt->fetch();
        return $grille_id;
    }

    public function updateGrilleResponses($entreprise_id, $reponses) {
        foreach ($reponses as $question_id => $reponse_id) {
            $sql = "UPDATE grille SET reponse_id = ? WHERE entreprise_id = ? AND question_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iii", $reponse_id, $entreprise_id, $question_id);
            if (!$stmt->execute()) {
                return "Erreur lors de la mise à jour de la grille : " . $stmt->error;
            }
        }
        return true;
    }

    public function closeConnection() {
        $this->conn->close();
    }
}
?>