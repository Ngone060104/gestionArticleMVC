<?php
function dd($test){
    echo "<pre>";
    var_dump($test);
    echo "</pre>";
    die("YALLA PITHIE");
};

function path(string $controller, string $action, array $params = []): string {
    // Construction de l'URL de base avec le contrôleur et l'action
    $url = WEBROOT . "?controller=" . urlencode($controller) . "&action=" . urlencode($action);
    if (!empty($params)) {
        foreach ($params as $key => $value) {
            $url .= "&" . urlencode($key) . "=" . urlencode($value);
        }
    }
    return $url;
}

/**
 * Gère l'upload sécurisé d'une image sur le serveur.
 * 
 * @param array $file Le tableau $_FILES['votre_champ_photo']
 * @param array &$errors Référence vers le tableau des erreurs du contrôleur
 * @return string|null Retourne le nouveau nom unique du fichier si succès, ou null si échec
 */
function uploadImage(array $file, array &$errors): ?string {
    // 1. Vérifier si un fichier a bien été soumis sans erreur système
    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        return 'default.jpg'; // Retourne l'image par défaut si l'utilisateur n'en met pas
    }
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors['photo'] = "Une erreur serveur est survenue lors du transfert de la photo.";
        return null;
    }

    // 2. Configuration des contraintes de sécurité
    $maxSize = 3 * 1024 * 1024; // Limite à 3 Mo (en octets)
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    $allowedMimeTypes  = ['image/jpeg', 'image/png', 'image/webp'];

    // 3. Vérification de la taille du fichier
    if ($file['size'] > $maxSize) {
        $errors['photo'] = "La photo est trop lourde. La taille maximale autorisée est de 3 Mo.";
        return null;
    }

    // 4. Vérification de l'extension du fichier
    $filename = $file['name'];
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    if (!in_array($extension, $allowedExtensions)) {
        $errors['photo'] = "Format d'image non valide. Autorisé : JPG, JPEG, PNG, WEBP.";
        return null;
    }

    // 5. SÉCURITÉ CRUCIALE : Vérification du type MIME réel du fichier (Finfo)
    // Cela empêche un faux fichier image (qui contient du code malveillant) de passer
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $realMimeType = $finfo->file($file['tmp_name']);
    if (!in_array($realMimeType, $allowedMimeTypes)) {
        $errors['photo'] = "Le contenu du fichier ne correspond pas à une image valide.";
        return null;
    }

    // 6. Génération d'un nom unique hautement sécurisé
    // On nettoie le titre d'origine et on ajoute un préfixe temporel unique
    $cleanName = preg_replace('/[^a-zA-Z0-9_]/', '', pathinfo($filename, PATHINFO_FILENAME));
    $newFilename = "art_" . uniqid() . "_" . time() . "." . $extension;

    // 7. Déplacement physique du fichier temporaire vers le dossier public/upload/
    $uploadDir = ROOT . "public/upload/";
    $destination = $uploadDir . $newFilename;

    // S'assurer que le dossier upload existe, sinon le créer
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return $newFilename; // Succès : on retourne le nom qui sera stocké en BDD
    } else {
        $errors['photo'] = "Impossible d'enregistrer l'image dans le dossier de destination.";
        return null;
    }
}
