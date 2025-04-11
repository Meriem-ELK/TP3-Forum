<?php
// Définit la constante MODEL_DIR qui contient le chemin vers le répertoire des modèles
define('MODEL_DIR', 'models');

// Définit la constante VIEW_DIR qui contient le chemin vers le répertoire des vues
define('VIEW_DIR', 'views');

// Définit la constante CONNEX_DIR qui contient le chemin vers le fichier de connexion à la base de données
define('CONNEX_DIR', 'lib/connex.php');


// Crée un tableau de configuration avec les paramètres par défaut
$config = array (
    // Définit le contrôleur par défaut qui sera appelé si aucun n'est spécifié
    'default_controller' => 'base',

    // Définit la fonction par défaut qui sera appelée si aucune n'est spécifiée
    'default_function' => 'index',
);