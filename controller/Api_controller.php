<?php
include '../config/config.php';
include_once '../model/Grille_model.php';

class Api_Controller {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function handleRequest() {
        // Vérifier les paramètres
        $grille_id = isset($_GET['grille_id']) ? intval($_GET['grille_id']) : null;
        $entreprise_id = isset($_GET['entreprise_id']) ? intval($_GET['entreprise_id']) : null;

        if ($grille_id === null || $entreprise_id === null) {
            $this->sendError('Paramètres grille_id et entreprise_id requis.');
            return;
        }

        // Récupérer les données
        $data = $this->model->getEvaluationData($grille_id, $entreprise_id);
        if (!$data) {
            $this->sendError('Aucune donnée trouvée pour cette grille et entreprise.');
            return;
        }

        // Calcul des totaux et moyennes par axe
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
                $moyennes_par_axe[$axe] = ($total / $diviseors[$axe]) * 2.5;
            } else {
                $moyennes_par_axe[$axe] = null;
            }
        }

        // Formatage des données
        $result = [
            'grille_id' => $grille_id,
            'entreprise_id' => $entreprise_id,
            'totaux_par_axe' => $totaux_par_axe,
            'moyennes_par_axe' => $moyennes_par_axe,
        ];

        $this->sendResponse($result);
    }

    private function sendResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    private function sendError($message) {
        $this->sendResponse(['error' => $message]);
    }
}
?>
