<?php
ini_set('display_errors', 'on');
session_start();

// Vérification de sécurité
if (!isset($_SESSION['connected']) || !isset($_GET['id'])) {
    header('Location: ../index.php');
    exit();
}

require_once("./../includes/constantes.php");
require_once("./../includes/config-bdd.php");
require_once('./functions_query.php');
require_once('./functions-DB.php');

$mysqli = connectionDB();
$id_avis_a_supprimer = (int)$_GET['id'];
$id_utilisateur = $_SESSION['id'];
$permission = $_SESSION['perm'];

// On appelle la fonction de suppression
deleteReview($id_avis_a_supprimer, $id_utilisateur, $permission, $mysqli);

closeDB($mysqli);

// On le renvoie sur son profil
header('Location: ../profil.php?msg=supprime');
exit();
?>