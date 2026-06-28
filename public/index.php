<?php
// 1. Définition des constantes de chemins
define("WEBROOT","http://localhost:8002/");
define("ROOT", (substr($_SERVER['DOCUMENT_ROOT'] ,0, -6)));

// 2. Chargement du fichier d'environnement et de routage
require_once(ROOT."env.dev.php");
require_once(ROOT."config/database.php");
require_once(ROOT."core/route.php");
require_once(ROOT."config/helpers.php");
require_once(ROOT."config/validator.php");

// 3. Récupération dynamique du contrôleur demandé 
// Si aucun contrôleur n'est spécifié, l'application charge par défaut les articles
$ctrl=$_REQUEST["controller"]??"article";

// 4. Lancement de la méthode via votre routeur POO dispatch()
dispatch($ctrl);