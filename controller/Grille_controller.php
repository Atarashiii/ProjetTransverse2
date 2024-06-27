<?php
include '../config/config.php';
include_once '../model/Grille_model.php';

class Grille_controller {
    private $ObjGrilleModel;

    public function __construct($conn) {
        $this->ObjGrilleModel = new Grille_model($conn);
    }

    public function GrilleIndex() {
        $value = isset($_GET['id']) ? $_GET['id'] : die('ID de grille non spécifié.');
        list($grille_id, $entreprise_id) = explode('-', $value);

        $data = $this->ObjGrilleModel->getEvaluationData($grille_id, $entreprise_id);
        
        $totaux_par_axe = [];
        foreach ($data as $row) {
            if (!isset($totaux_par_axe[$row["axe_libelle"]])) {
                $totaux_par_axe[$row["axe_libelle"]] = 0;
            }
            $totaux_par_axe[$row["axe_libelle"]] += $row["reponse_valeur"];
        }

        $diviseurs = [
            "Axe Compétence" => 9,
            "Axe Réactivité" => 11,
            "Axe Numérique" => 20,
        ];

        $moyennes_par_axe = [];
        foreach ($totaux_par_axe as $axe => $total) {
            if (isset($diviseurs[$axe])) {
                $moyennes_par_axe[$axe] = ($total / $diviseurs[$axe]) * 2.5;
            } else {
                $moyennes_par_axe[$axe] = null;
            }
        }

        include '../view/recap.php';
    }

    public function __destruct() {
        $this->ObjGrilleModel->closeConnection();
    }
}
?>