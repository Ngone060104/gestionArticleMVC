<?php
require_once ROOT . "model/categorieModel.php";

class CategorieController {
    private $categorieModel;

    public function __construct() {
        // Instanciation du modèle des catégories
        $this->categorieModel = new CategorieModel();
    }

     
    public function index() {
        $categories = $this->categorieModel->getAllCategories();
        $errors = [];

        // Temporisation de sortie pour injecter la vue dans le Layout
        ob_start();
        require_once ROOT . "view/categorie/categorieView.php";
        $content = ob_get_clean();

        require_once ROOT . "view/layout/side.layout.php";
    }

    // Action : Afficher le formulaire d'ajout d'une catégorie 
     
    public function create() {
        $errors = [];

        ob_start();
        require_once ROOT . "view/categorie/createView.php";
        $content = ob_get_clean();

        require_once ROOT . "view/layout/side.layout.php";
    }
    
    //  Action : Traiter la soumission du formulaire d'ajout
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            // Validation du champ nom (obligatoire)
            isEmpty('nom', $_POST['nom'] ?? null, $errors, "Le nom de la catégorie est obligatoire.");

            if (empty($errors)) {
                $this->categorieModel->addCategorie([
                    'nom'         => $_POST['nom'],
                    'description' => $_POST['description'] ?? ''
                ]);
                
                // Redirection vers la liste des catégories après l'ajout
                header("Location: " . path('categorie', 'index'));
                exit();
            }

            // En cas d'erreur, on réaffiche le formulaire d'ajout
            ob_start();
            require_once ROOT . "view/categorie/createView.php";
            $content = ob_get_clean();

            require_once ROOT . "view/layout/side.layout.php";
        }
    }

}
