<?php
require_once(ROOT . "config/database.php");

class CategorieModel {

    // Récupérer toutes les catégories pour le formulaire de l'article
    public function getAllCategories(): array {
        return Database::executeSelect("SELECT * FROM categories ORDER BY nom ASC");
    }

    // Récupérer une catégorie par son ID
    public function getCategorieById(int $id): array|null {
        $result = Database::executeSelect("SELECT * FROM categories WHERE id = ?", [$id], true);
        return $result ?: null;
    }

     // Enregistrer un nouvel categories en base de données
    public function addCategorie(array $categorie): void {
        $sql = "INSERT INTO categories (nom, description) VALUES (?, ?)";
        
        Database::executeUpdate($sql, [
            $categorie['nom'],
            $categorie['description'] ?? null
        ]);
    }
}
