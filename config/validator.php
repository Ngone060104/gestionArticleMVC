<?php
//verifier champs vides
function isEmpty(string $key, ?string $value, array &$errors, string $msg = "Ce champ est obligatoire"): void {
    if ($value === null || empty(trim($value))) {
        $errors[$key] = $msg;
    }
}


// 2. Vérifie si une valeur est un prix valide (Numérique et positif)
 
function isPrice(string $key, ?string $value, array &$errors, string $msg = "Le prix doit être un nombre positif"): void {
    if ($value === null || !is_numeric($value) || floatval($value) < 0) {
        $errors[$key] = $msg;
    }
}

// 3. Vérifie si un fichier (photo) obligatoire a bien été sélectionné

function isFileEmpty(string $key, ?array $file, array &$errors, string $msg = "Veuillez sélectionner une image"): void {
    if ($file === null || !isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        $errors[$key] = $msg;
    }
}