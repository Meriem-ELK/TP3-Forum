<?php
// Fonction pour afficher la liste des articles du forum
function forum_controller_all_articles() 
{
    // Inclut le modèle forum qui contient les fonctions d'accès aux données
    require_once(MODEL_DIR."/forum.php");
    
    // Récupération de tous les articles du forum depuis la base de données
    $articles = forum_select_all_with_author();
    
    // Affiche la vue contenant tous les articles, en passant les articles récupérés
    render('forum/all_articles.php', ['articles' => $articles]);
}


// Fonction pour afficher les articles de l'utilisateur connecté
function forum_controller_articlesUser() 
{
    require_login();

    $user_id = $_SESSION['user_id'];
    
    require_once(MODEL_DIR."/forum.php");
    
    // Récupération des articles de l'utilisateur
    $articles = forum_select_by_user($user_id);
    
    render('forum/articlesUser.php', [
        'articles' => $articles,
        'user_name' => $_SESSION['user_nom']
    ]);
}


// Fonction pour afficher le formulaire de création d'un nouvel article
function forum_controller_create() 
{
    require_login();
    render('forum/create.php');
}

// Fonction de validation des données envoyées
function forum_validation($request) 
{
    $errors = array();
    
    // Validation du titre (entre 5 et 100 caractères)
    $titre = $request['titre'];
    if (strlen($titre) < 5 || strlen($titre) > 100) {
        $errors['titre'] = "Le titre doit comporter entre 5 et 100 caractères.";
    }
    
    // Validation de l'article (max 1000 caractères)
    $article = $request['article'];
    if (strlen($article) > 1000) {
        $errors['article'] = "L'article ne doit pas dépasser 1000 caractères.";
    }
    
    return $errors;
}


//  Fonction pour enregistrer un nouvel article
function forum_controller_store($request) 
{
    require_login();

    require_once(MODEL_DIR."/forum.php");
    
    // Ajoute l'ID de l'utilisateur à la requête pour lier l'article à l'auteur
    $request['utilisateur_id'] = $_SESSION['user_id'];
    
    // Validation des données
    $errors = forum_validation($request);
    
    // Si aucune erreur n'est détectée
    if (empty($errors)) {

        $forum_id = forum_insert($request);
        
        // Si l'insertion a réussi
        if ($forum_id) {
            $_SESSION['success'] = "Votre article a été publié avec succès.";
            header('location:?controller=forum&function=articlesUser');
        } else {
            $_SESSION['error'] = "Une erreur est survenue lors de la publication de l'article.";
            render('forum/create.php', $request);
        }
    } else {
        // En cas d’erreurs de validation, on renvoie le formulaire avec les erreurs
        render('forum/create.php', array_merge($request, ['errors' => $errors]));
    }
}


// Fonction pour afficher le formulaire de modification d'un article
function forum_controller_edit($request) 
{
    require_login();

    // Récupère l'identifiant de l'article à modifier
    $id = $request['id'];

    require_once(MODEL_DIR."/forum.php");

    // Récupère les détails de l'article par son ID
    $article = forum_select_id($id);
    
    // Vérifie que l'article existe et appartient à l'utilisateur connecté
    if ($article && $article['id_utilisateur'] == $_SESSION['user_id']) {
        render('forum/edit.php', ['article' => $article]);
    } else {
        $_SESSION['error'] = "Vous n'êtes pas autorisé à modifier cet article ou il n'existe pas.";
        header('location:?controller=forum&function=articlesUser');
    }
}


// Fonction pour traiter la soumission du formulaire de modification d'article
function forum_controller_update($request) {
    require_login();

    require_once(MODEL_DIR."/forum.php");
    
    $request['id_utilisateur'] = $_SESSION['user_id'];
    
    $article = [
        'id_article' => $request['id'],
        'titre' => $request['titre'],
        'article' => $request['article']
    ];

    $errors = forum_validation($request);

    if (empty($errors)) {
        $result = forum_update($request);
        
        // Si la mise à jour a réussi
        if ($result) {
            $_SESSION['success'] = "Votre article a été modifié avec succès.";
            header('location:?controller=forum&function=articlesUser');
        } else {
            // Échec
            $_SESSION['error'] = "Une erreur est survenue lors de la modification de l'article.";
            
        
            render('forum/edit.php', ['article' => $article]);
        }
    } else {
        render('forum/edit.php', ['article' => $article, 'errors' => $errors]);
    }
}

// Fonction pour supprimer un article
function forum_controller_delete($request) 
{
    require_login();

    // Récupère l'ID de l'article à supprimer
    $id = $request['id'];
    
    require_once(MODEL_DIR."/forum.php");

     // Supprime l'article (en vérifiant qu'il appartient bien à l'utilisateur connecté)
    $result = forum_delete($id, $_SESSION['user_id']);
    
    if ($result) {
        $_SESSION['success'] = "Votre article a été supprimé avec succès.";
    } else {
        $_SESSION['error'] = "Une erreur est survenue lors de la suppression de l'article.";
    }
    
    header('location:?controller=forum&function=articlesUser');
}
