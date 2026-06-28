<?php
require_once(ROOT . "config/database.php");

class ArticleModel
{

    // Récupérer les articles avec le nom de leur catégorie associée (Jointure)
    // public function getAllArticles(): array
    // {
    //     $sql = "SELECT a.*, c.nom AS categorie_nom 
    //             FROM articles a
    //             INNER JOIN categories c ON a.categorie_id = c.id
    //             ORDER BY a.id DESC";
    //     return Database::executeSelect($sql);
    // }

        // Récupérer les articles (optionnellement filtrés par catégorie)
    public function getAllArticles(?int $categorieId = null, int $limit = 4, int $offset = 0): array {
        $sql = "SELECT a.*, c.nom AS categorie_nom 
                FROM articles a
                INNER JOIN categories c ON a.categorie_id = c.id";
        
        $params = [];
        
         // 1. Gestion du filtre de catégorie (via paramètre sécurisé PDO)
        if ($categorieId !== null) {
            $sql .= " WHERE a.categorie_id = :categorie_id";
            $params['categorie_id'] = $categorieId;
        }

           // 2. Sécurisation stricte des entiers pour la pagination
        $cleanLimit = intval($limit);
        $cleanOffset = intval($offset);
        
         // 3. Injection directe des nombres dans la requête (Sécurisé car forcé en INT)
        $sql .= " ORDER BY a.id DESC LIMIT $cleanLimit OFFSET $cleanOffset";
        
        return Database::executeSelect($sql, $params);
    }

        // Compter le nombre d'articles (avec filtre optionnel de catégorie)
    public function countArticles(?int $categorieId = null): int {
        $sql = "SELECT COUNT(*) as total FROM articles";
        $params = [];

        if ($categorieId !== null) {
            $sql .= " WHERE categorie_id = ?";
            $params[] = $categorieId;
            $result = Database::executeSelect($sql, $params, true);
        } else {
            $result = Database::executeSelect($sql, [], true);
        }

        return (int)$result['total'];
    }



    // Enregistrer un nouvel article en base de données
    public function addArticle(array $article): void
    {
        // Remarquez l'absence de date_creation car gérée par le DEFAULT CURRENT_TIMESTAMP de PostgreSQL
        $sql = "INSERT INTO articles (titre, description, prix, photo, statut, categorie_id) 
                VALUES (?, ?, ?, ?, ?, ?)";

        Database::executeUpdate($sql, [
            $article['titre'],
            $article['description'],
            $article['prix'],
            $article['photo'] ?? 'default.jpg', 
            $article['statut'] ?? 'disponible',
            $article['categorie_id']
        ]);
    }

    // Supprimer un article
    public function deleteArticle(int $id): void
    {
        Database::executeDelete("DELETE FROM articles WHERE id = ?", [$id]);
    }

    // Récupérer un article unique par son ID
    public function getArticleById(int $id): array|null
    {
        $sql = "SELECT * FROM articles WHERE id = ?";
        $result = Database::executeSelect($sql, [$id], true);
        return $result ?: null;
    }

    // Sauvegarder les modifications d'un article existant
    public function updateArticle(int $id, array $article): void
    {
        $sql = "UPDATE articles SET 
                    titre = ?, 
                    description = ?, 
                    prix = ?, 
                    photo = ?, 
                    statut = ?, 
                    categorie_id = ? 
                WHERE id = ?";

        Database::executeUpdate($sql, [
            $article['titre'],
            $article['description'],
            $article['prix'],
            $article['photo'],
            $article['statut'],
            $article['categorie_id'],
            $id
        ]);
    }
}
