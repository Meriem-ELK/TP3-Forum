<?php
// Fonctions utilitaires principales

// Fonction pour sécuriser les entrées utilisateur
function safe($param)
{
    return addslashes($param);
}

// Fonctions de base pour tous les contrôleurs
function render($file, $data = null)
{
    $layout_file = VIEW_DIR."/layouts/layout.php";

     // Transforme un tableau associatif en variables individuelles
     if(is_array($data)){
        extract($data);
    }

    // Démarre la mise en mémoire tampon pour capturer la sortie
    ob_start();

    // Inclut le fichier de vue spécifié
    include_once(VIEW_DIR."/".$file);

    // Récupère le contenu généré par la vue
    $content = ob_get_clean();

    // Inclut le layout principal qui utilisera la variable $content
    include_once($layout_file);
}

// Fonction pour vérifier si un utilisateur est connecté, sinon rediriger vers la page de connexion
function require_login() 
{
    if(!isset($_SESSION)) 
    {
        session_start();
    }
    

    // Vérifier si l'utilisateur n'est pas connecté
    if(!is_logged_in()) 
    {
        // Définir le message d'erreur
        $_SESSION['error'] = 'Vous devez être connecté pour accéder à cette page.';
        
        redirect('index.php?controller=utilisateur&function=login');
        exit();
    }
}

// Redirection vers une URL
function redirect($url) 
{
    header("Location: $url");
    exit();
}

// Vérifier si l'utilisateur est connecté
function is_logged_in() 
{
    if (!isset($_SESSION['user_id'])) {
        return false;
    }
    // Vérification du fingerPrint
    $currentFingerPrint = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);

    if ($_SESSION['fingerPrint'] !== $currentFingerPrint) {
        session_destroy(); // Session invalide
        return false;
    }
    return true;
}

//
function is_active($controller, $function, $default = false) {
    $current_controller = $_GET['controller'] ?? '';
    $current_function = $_GET['function'] ?? '';

    // Si aucun paramètre et que c'est la page par défaut
    if ($default && $current_controller === '' && $current_function === '') {
        return 'active';
    }

    // Sinon, on compare normalement
    return ($current_controller === $controller && $current_function === $function) ? 'active' : '';
}
