<?php
ini_set('display_errors', 'on');
session_start();

require_once("./../includes/constantes.php");
require_once("./../includes/config-bdd.php");
require_once('./functions_query.php');
require_once('./functions-DB.php');

// On verifie si le formulaire a bien envoye les donnees
if (!isset($_POST['login']) || !isset($_POST['password'])) {
    header('Location: ../connection.php');
    exit();
}

$login = $_POST['login'];
$password = $_POST['password'];

// On se connecte a la base de donnees
$mysqli = connectionDB(); 

// On verifie si l'utilisateur existe avec le bon mot de passe
$result = checkUser($login, $password, $mysqli);

// Si le resultat est vide, c'est que le login ou le mot de passe est faux
if (count($result) == 0) {
    header('Location: ../connection.php?erreur=1');
    exit();
}

// Si c'est bon, on recupere les informations de l'utilisateur
$user = $result[0];

// On cree les variables de session pour garder l'utilisateur connecte
$_SESSION['login'] = $user['Username'];
$_SESSION['id'] = $user['ID_member'];
$_SESSION['perm'] = $user['Perm']; // Tres utile pour verifier s'il est admin ou membre
$_SESSION['connected'] = true;

closeDB($mysqli);

// On le renvoie vers la page d'accueil
header('Location: ../index.php');
exit();
?>