<?php

function forum_select_all_with_author() 
{
    require(CONNEX_DIR);

    $sql = "SELECT forum.*, utilisateur.nom as nom 
            FROM forum 
            INNER JOIN utilisateur ON utilisateur.id_utilisateur = forum.id_utilisateur 
            ORDER BY forum.date_creation DESC";
    
    $result = mysqli_query($connex, $sql);
    $articles = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $articles;
}

function forum_select_by_user($id_utilisateur) 
{
    require(CONNEX_DIR);

    $id_utilisateur = mysqli_real_escape_string($connex, $id_utilisateur);

    $sql = "SELECT * FROM forum 
            WHERE id_utilisateur = '$id_utilisateur' 
            ORDER BY date_creation DESC";

    $result = mysqli_query($connex, $sql);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $result;
}

function forum_select_id($id) 
{
    require(CONNEX_DIR);
    $id = mysqli_real_escape_string($connex, $id);

    $sql = "SELECT forum.*, utilisateur.id_utilisateur 
            FROM forum 
            INNER JOIN utilisateur ON utilisateur.id_utilisateur = forum.id_utilisateur 
            WHERE forum.id_article = '$id'";

    $result = mysqli_query($connex, $sql);
    $count = mysqli_num_rows($result);
    if ($count == 1) {
        $result = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return $result;
    } else {
        return false;
    }
}

function forum_insert($request) 
{
    require(CONNEX_DIR);
    
    foreach ($request as $key => $value) {
        $$key = mysqli_real_escape_string($connex, $value);
    }
    
    // Date actuelle pour l'article
    $date = date('Y-m-d');
    
    $sql = "INSERT INTO forum (titre, article, date_creation, id_utilisateur) 
            VALUES ('$titre', '$article', '$date', '$utilisateur_id')";
    
    if (mysqli_query($connex, $sql)) {
        return mysqli_insert_id($connex);
    } else {
        return false;
    }
}

function forum_update($request) 
{
    require(CONNEX_DIR);
    
    foreach ($request as $key => $value) {
        $$key = mysqli_real_escape_string($connex, $value);
    }
    
    // Vérifier que l'article appartient à l'utilisateur
    $sql = "SELECT * FROM forum 
            WHERE id_article = '$id' AND id_utilisateur = '$id_utilisateur'";
    $result = mysqli_query($connex, $sql);
    
    if (mysqli_num_rows($result) == 0) {
        return false;
    }
    
    $sql = "UPDATE forum SET titre = '$titre', article = '$article' 
            WHERE id_article = '$id' AND id_utilisateur = '$id_utilisateur'";
    
    if (mysqli_query($connex, $sql)) {
        return true;
    } else {
        return false;
    }
}

function forum_delete($id, $id_utilisateur) 
{
    require(CONNEX_DIR);
    $id = mysqli_real_escape_string($connex, $id);
    $id_utilisateur = mysqli_real_escape_string($connex, $id_utilisateur);
    
    // Vérifier que l'article appartient à l'utilisateur
    $sql = "SELECT * FROM forum 
            WHERE id_article = '$id' AND id_utilisateur = '$id_utilisateur'";
    $result = mysqli_query($connex, $sql);
    
    if (mysqli_num_rows($result) == 0) {
        return false;
    }
    
    $sql = "DELETE FROM forum 
            WHERE id_article = '$id' AND id_utilisateur = '$id_utilisateur'";
    
    if (mysqli_query($connex, $sql)) {
        return true;
    } else {
        return false;
    }
}
?>