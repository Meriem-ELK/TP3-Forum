<?php
$host = "localhost";
$user = "root";
$password = "root";
$dbname = "forum_college";
$port = "3306";

// Connexion à la base de données
$connex = mysqli_connect($host, $user, $password, $dbname, $port);

// Vérification de la connexion
if (mysqli_connect_error()) {
    die("Échec de la connexion à la base de données : " . mysqli_connect_error());
}

// Définir l'encodage des caractères pour éviter les problèmes d'affichage
mysqli_set_charset($connex, "utf8");
?>