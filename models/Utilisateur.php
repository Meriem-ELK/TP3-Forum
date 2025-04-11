<?php
// Fonction pour insérer un nouvel utilisateur dans la base de données
function utilisateur_insert($request) 
{
    require(CONNEX_DIR);

    // Sécurise chaque champ du formulaire contre les injections SQL
    foreach ($request as $key => $value) {
        $$key = mysqli_real_escape_string($connex, $value);
    }

    $mot_de_passe = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    $sql = "INSERT INTO utilisateur (nom, nom_utilisateur, mot_de_passe, date_naissance) 
            VALUES ('$nom', '$nom_utilisateur', '$mot_de_passe', '$date_naissance')";
    
    if (mysqli_query($connex, $sql)) 
    {
        return mysqli_insert_id($connex);
    } else {
        return false;
    }
}

function utilisateur_validate($request) 
{
    $errors = array();
    
    // Validation du nom
    if (!preg_match('/^[A-Za-zÀ-ÿ\s]{2,25}$/', $request['nom'])) {
        $errors['nom'] = "Le nom doit contenir uniquement des lettres et des espaces (entre 2 et 25 caractères).";
    }
    
    // Validation de l'email
    if (!filter_var($request['nom_utilisateur'], FILTER_VALIDATE_EMAIL)) {
        $errors['nom_utilisateur'] = "L'adresse email n'est pas valide.";
    } else {
        require(CONNEX_DIR);
        $nom_utilisateur = mysqli_real_escape_string($connex, $request['nom_utilisateur']);
            
        $sql = "SELECT * FROM utilisateur 
                WHERE nom_utilisateur = '$nom_utilisateur'";

        $result = mysqli_query($connex, $sql);
        if (mysqli_num_rows($result) > 0) {
            $errors['nom_utilisateur'] = "Cette adresse email est déjà utilisée.";
        }
    }
    
    // Validation du mot de passe
    $mot_de_passe = $request['mot_de_passe'];
    if (strlen($mot_de_passe) < 6 || strlen($mot_de_passe) > 20) {
        $errors['mot_de_passe'] = "Le mot de passe doit comporter entre 6 et 20 caractères.";
    } elseif (!preg_match('/[A-Za-z]/', $mot_de_passe) || !preg_match('/[0-9]/', $mot_de_passe)) {
        $errors['mot_de_passe'] = "Le mot de passe doit contenir des chiffres et des lettres.";
    }
    
    // Validation de la date de naissance

    // Récupération de la date de naissance envoyée dans le formulaire
    $date = $request['date_naissance'];
    $format = 'Y-m-d';

    // Création d’un objet DateTime à partir de la date envoyée
    $d = DateTime::createFromFormat($format, $date);

    // Vérifie si la date a bien été créée et qu’elle correspond exactement au format souhaité
    if (!($d && $d->format($format) === $date)) {
        $errors['date_naissance'] = "La date de naissance doit être au format aaaa-mm-jj.";
    } else 
    {
        // Si la date est valide, on crée un objet représentant la date actuelle
        $today = new DateTime();
    
        // On calcule la différence entre aujourd’hui et la date de naissance
        $age = $today->diff($d)->y;
        
        // 
        if ($age < 16 || $age > 85) {
            $errors['date_naissance'] = "La date de naissance n'est pas valide.";
        }
    }
    
    return $errors;
}

function utilisateur_login($nom_utilisateur, $mot_de_passe) 
{
    require(CONNEX_DIR);
    $nom_utilisateur = mysqli_real_escape_string($connex, $nom_utilisateur);
    $sql = "SELECT * FROM utilisateur 
            WHERE nom_utilisateur = '$nom_utilisateur'";
    $result = mysqli_query($connex, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
            return $user;
        }
    }
    return false;
}