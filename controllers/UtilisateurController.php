<?php
// Fonction pour afficher le formulaire d'inscription
function utilisateur_controller_register() 
{
    render('utilisateur/register.php');
}


// Fonction pour traiter les données du formulaire d'inscription
function utilisateur_controller_store($request) 
{
    require_once(MODEL_DIR."/utilisateur.php");
    
    // Valide les données soumises par l'utilisateur
    $errors = utilisateur_validate($request);
    
    if (empty($errors)) {
        $utilisateur_id = utilisateur_insert($request);
        
        if ($utilisateur_id) {
            $_SESSION['success'] = "Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.";
            header('Location: ?controller=utilisateur&function=login');
            exit();
        } else {
            $_SESSION['error'] = "Une erreur est survenue lors de la création du compte.";
            render('utilisateur/register.php', array('request' => $request));
        }
    } else {
        render('utilisateur/register.php', array('request' => $request, 'errors' => $errors));
    }
}


// Fonction pour afficher le formulaire de connexion
function utilisateur_controller_login() 
{
    render('utilisateur/login.php');
}


// Fonction pour authentifier un utilisateur
function utilisateur_controller_authenticate($request) 
{
    require_once(MODEL_DIR."/utilisateur.php");
    
    $nom_utilisateur = $request['nom_utilisateur'];
    $mot_de_passe = $request['mot_de_passe'];
    
    // Vérifie les identifiants de l'utilisateur
    $user = utilisateur_login($nom_utilisateur, $mot_de_passe);
    
    if ($user) {
        $_SESSION['user_id'] = $user['id_utilisateur'];
        $_SESSION['user_nom'] = $user['nom'];
        $_SESSION['fingerPrint'] = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
        $_SESSION['success'] = "Connexion réussie. Bienvenue, <strong>{$user['nom']}! </strong>";
        
        header('location:?controller=forum&function=all_articles');
    } else {
        $_SESSION['error'] = "Email ou mot de passe incorrect.";
        render('utilisateur/login.php', ['nom_utilisateur' => $nom_utilisateur]);
    }
}

// Fonction pour déconnecter un utilisateur
function utilisateur_controller_logout() 
{
    // Supprime toutes les variables de session
    session_unset();

    // Détruit la session
    session_destroy();

    // Redirige vers la page d'accueil
    header('location:?controller=forum&function=all_articles');
}