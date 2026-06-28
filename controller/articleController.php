<?php
// controller/articleController.php

require_once ROOT . "model/articleModel.php";
require_once ROOT . "model/categorieModel.php";

class ArticleController
{
    private $articleModel;
    private $categorieModel;

    public function __construct()
    {
        // Instanciation des deux modèles nécessaires
        $this->articleModel = new ArticleModel();
        $this->categorieModel = new CategorieModel();
    }

    //  Action : Afficher la liste complète des articles

    // public function index()
    // {
    //     // Récupération des articles avec la jointure SQL pour les catégories
    //     $articles = $this->articleModel->getAllArticles();
    //     $errors = [];

    //     // Démarre la mise en mémoire tampon
    //     ob_start();
    //     require_once ROOT . "view/article/articleView.php";
    //     // Fin de la mise en mémoire tampon et récupération du contenu tamponné
    //     $content = ob_get_clean();

    //     require_once ROOT . "view/layout/side.layout.php";
    // }

    public function index()
    {
        // 1. Nombre d'articles par page
        $perPage = 4;

        // 2. Récupérer l'ID de la catégorie depuis l'URL si elle existe
        $categorieId = filter_input(INPUT_GET, 'categorie_id', FILTER_VALIDATE_INT) ?: null;

      // 3. Récupérer la page actuelle
        $currentPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        if (!$currentPage || $currentPage < 1) {
            $currentPage = 1;
        }

         // 4. Calcul de l'offset pour PostgreSQL
        $offset = ($currentPage - 1) * $perPage;

         // 5. Compter le nombre de produits correspondants et calculer le total de pages
        $totalArticles = $this->articleModel->countArticles($categorieId);
        $totalPages = ceil($totalArticles / $perPage);


           // 6. Récupération des données nécessaires à la vue
        $articles = $this->articleModel->getAllArticles($categorieId, $perPage, $offset);
        $categories = $this->categorieModel->getAllCategories();
        $errors = [];

        ob_start();
        require_once ROOT . "view/article/articleView.php";
        $content = ob_get_clean();

        require_once ROOT . "view/layout/side.layout.php";
    }

    //  Action : Afficher le formulaire d'ajout d'un article

    public function create()
    {
        $categories = $this->categorieModel->getAllCategories();
        $errors = [];

        ob_start();
        require_once ROOT . "view/article/createView.php";
        $content = ob_get_clean();

        require_once ROOT . "view/layout/side.layout.php";
    }

    //  Action : Traiter la soumission du formulaire et gérer l'upload
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            // 1. Validation centralisée des champs obligatoires et formats
            isEmpty('titre', $_POST['titre'] ?? null, $errors, "Le titre de l'article est obligatoire.");
            isPrice('prix', $_POST['prix'] ?? null, $errors, "Le prix est obligatoire et doit être un nombre positif.");
            isEmpty('categorie_id', $_POST['categorie_id'] ?? null, $errors, "Veuillez sélectionner une catégorie.");

            // 2. Gestion et sécurisation de la photo si aucune erreur sur les champs
            $photoName = 'default.jpg';
            if (empty($errors) && isset($_FILES['photo'])) {
                // Appel de la fonction de helpers.php qui gère les restrictions et le renommage unique
                $uploadedFile = uploadImage($_FILES['photo'], $errors);
                if ($uploadedFile !== null) {
                    $photoName = $uploadedFile;
                }
            }

            // 3. Enregistrement en base de données PostgreSQL si tout est valide
            if (empty($errors)) {
                $this->articleModel->addArticle([
                    'titre'        => $_POST['titre'],
                    'description'  => $_POST['description'] ?? '',
                    'prix'         => floatval($_POST['prix']),
                    'photo'        => $photoName,
                    'statut'       => $_POST['statut'] ?? 'disponible',
                    'categorie_id' => intval($_POST['categorie_id'])
                ]);

                // Redirection vers le tableau de bord des articles
                header("Location: " . path('article', 'index'));
                exit();
            }
            
            $categories = $this->categorieModel->getAllCategories();

            ob_start();
            require_once ROOT . "view/article/createView.php";
            $content = ob_get_clean();

            require_once ROOT . "view/layout/side.layout.php";
        }
    }


    // Action : Supprimer un article

    public function delete()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $this->articleModel->deleteArticle($id);
        }
        header("Location: " . path('article', 'index'));
        exit();
    }

    //  Action : Afficher le formulaire d'édition pré-rempli

    public function edit()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            header("Location: " . path('article', 'index'));
            exit();
        }

        // Récupération de l'article actuel et des catégories pour la liste déroulante
        $article = $this->articleModel->getArticleById($id); // Nécessite d'être ajouté au modèle si absent
        $categories = $this->categorieModel->getAllCategories();
        $errors = [];

        ob_start();
        require_once ROOT . "view/article/editView.php";
        $content = ob_get_clean();

        require_once ROOT . "view/layout/side.layout.php";
    }

    //  Action : Enregistrer les modifications de l'article

    public function update()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . path('article', 'index'));
            exit();
        }

        $errors = [];
        isEmpty('titre', $_POST['titre'] ?? null, $errors, "Le titre de l'article est obligatoire.");
        isPrice('prix', $_POST['prix'] ?? null, $errors, "Le prix est obligatoire et doit être un nombre positif.");
        isEmpty('categorie_id', $_POST['categorie_id'] ?? null, $errors, "Veuillez sélectionner une catégorie.");

        // Récupération de l'ancien article pour conserver l'image si aucune nouvelle n'est uploadée
        $ancienArticle = $this->articleModel->getArticleById($id);
        $photoName = $ancienArticle['photo'] ?? 'default.jpg';

        // Si l'utilisateur envoie une nouvelle photo
        if (empty($errors) && isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadedFile = uploadImage($_FILES['photo'], $errors);
            if ($uploadedFile !== null) {
                $photoName = $uploadedFile;
            }
        }

        if (empty($errors)) {
            // Appel de la mise à jour (à déclarer dans le modèle)
            $this->articleModel->updateArticle($id, [
                'titre'        => $_POST['titre'],
                'description'  => $_POST['description'] ?? '',
                'prix'         => floatval($_POST['prix']),
                'photo'        => $photoName,
                'statut'       => $_POST['statut'],
                'categorie_id' => intval($_POST['categorie_id'])
            ]);

            header("Location: " . path('article', 'index'));
            exit();
        }

        // En cas d'erreur
        $categories = $this->categorieModel->getAllCategories();
        $article = $_POST;
        $article['id'] = $id;
        $article['photo'] = $photoName;

        ob_start();
        require_once ROOT . "view/article/editView.php";
        $content = ob_get_clean();

        require_once ROOT . "view/layout/side.layout.php";
    }
}
