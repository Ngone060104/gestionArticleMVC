<?php
// core/route.php

function dispatch(string $controllerName) {
    // 1. On construit le nom du fichier et de la classe (ex: TaskController)
    $className = ucfirst($controllerName) . "Controller"; 
    $controllerFile = ROOT . "Controller/" . $className . ".php";

    // 2. Vérification de l'existence du fichier
    if (file_exists($controllerFile)) {
        require_once($controllerFile);

        // 3. Vérification de l'existence de la classe
        if (class_exists($className)) {
            // Instanciation dynamique de l'objet (ex: $controller = new TaskController();)
            $controller = new $className();

            // 4. Détermination de la méthode (action) à exécuter
            // Si aucune action n'est demandée, la méthode par défaut est 'index'
            $action = $_REQUEST['action'] ?? 'index';

            // 5. Vérification et exécution de la méthode sur l'objet
            if (method_exists($controller, $action)) {
                $controller->$action(); // Appel dynamique de la méthode (ex: $controller->index();)
            } else {
                die("Erreur : La méthode '{$action}' n'existe pas dans la classe {$className}.");
            }
        } else {
            die("Erreur : La classe '{$className}' n'est pas définie dans le fichier.");
        }
    } else {
        die("Erreur : Le fichier contrôleur '{$controllerFile}' n'existe pas.");
    }
}
