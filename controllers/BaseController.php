<?php
function base_controller_index() {
    // Récupérer tous les articles avec leurs auteurs
    require_once(MODEL_DIR."/forum.php");
    $articles = forum_select_all_with_author();
    
    // Afficher la page d'accueil avec tous les articles
    render('forum/all_articles.php', ['articles' => $articles]);
}