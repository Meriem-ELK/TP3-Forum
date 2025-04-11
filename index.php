<?php

session_start();


// Affiche les erreurs PHP pour faciliter le débogage lors du développement
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Inclusion des fichiers de configuration et de la bibliothèque principale
require_once('config/config.php');
require_once('lib/core.php');



// Récupération du contrôleur et de la fonction à appeler depuis la requête HTTP ou valeurs par défaut définies dans la configuration
$controller = isset($_REQUEST['controller'])?safe($_REQUEST['controller']):$config['default_controller'];
$function = isset($_REQUEST['function'])?safe($_REQUEST['function']):$config['default_function'];

// echo $controller;
// echo "<br/>";
// echo $function;


// Détermination du fichier du contrôleur à inclure, en le formatant correctement (première lettre en majuscule, ajout de "Controller.php")
$controller_file = "controllers/".ucfirst($controller)."Controller.php";

//controllers/ClientController.php
//echo $controller_file;


// Vérification si le fichier du contrôleur existe
if(!file_exists($controller_file)){
    trigger_error('Could not find this file');
    exit();
}

// Inclusion du fichier du contrôleur trouvé
require_once($controller_file);

// Construction du nom de la fonction à appeler à partir du nom du contrôleur et de la fonction demandée
$controller_function = strtolower($controller)."_controller_".$function;

// echo $controller_function;


// Vérification si la fonction existe dans le fichier du contrôleur
if(!function_exists($controller_function)){
    trigger_error('Could not find this function');
    exit();
}

// Appel de la fonction dynamique avec les paramètres de la requête
call_user_func($controller_function, $_REQUEST);