<?php
include '../config/config.php';
include_once '../model/Grille_model.php';
include_once '../model/Entreprise_model.php';

class Api_Controller {
    private $ObjEntrepriseModel;
    private $ObjGrilleModel;

    public function __construct($conn) {
        $this->ObjEntrepriseModel = new Entreprise_model($conn);
        $this->ObjGrilleModel = new Grille_model($conn);
    }

    public function listEndpoints() {
        // Définit les endpoints disponibles
        $endpoints = [
            'listEntreprises' => 'index.php?ctrl=api&action=listEntreprises',
            'getGrilleData' => 'index.php?ctrl=api&action=getGrilleData&grille_id=1&entreprise_id=1'
        ];

        $appversion['app_version'] = APP_VERSION;
        include '../view/api.php';
    }

    public function listEntreprises() {
        try {
            // Appeler la méthode du modèle pour obtenir toutes les entreprises
            $entreprises = $this->ObjEntrepriseModel->getAllEntreprise();
    
            // Vérifier s'il y a des résultats
            if (!empty($entreprises)) {
                // Envoyer les données en JSON
                header('Content-Type: application/json');
                echo json_encode($entreprises);
            } else {
                echo json_encode(['error' => 'Aucune entreprise trouvée']);
            }
        } catch (Exception $e) {
            // Envoyer l'erreur en JSON en cas d'exception
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function getGrilleData() {
        // Vérifier les paramètres grille_id et entreprise_id dans l'URL
        if (!isset($_GET['grille_id']) || !isset($_GET['entreprise_id'])) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Paramètres grille_id et entreprise_id requis']);
            return;
        }

        $grille_id = intval($_GET['grille_id']);
        $entreprise_id = intval($_GET['entreprise_id']);

        try {
            // Appeler la méthode du modèle pour obtenir les données de la grille
            $data = $this->ObjGrilleModel->getEvaluationData($grille_id, $entreprise_id);

            // Vérifier s'il y a des résultats
            if (count($data) > 0) {
                // Envoyer les données en JSON
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                // Aucune donnée trouvée pour cette grille
                http_response_code(404); // Not Found
                echo json_encode(['error' => 'Aucune donnée trouvée pour cette grille']);
            }
        } catch (Exception $e) {
            // Erreur de serveur interne
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
?>
