<?php
ini_set('display_errors', 'on');
session_start();

// SÉCURITÉ : On vérifie que c'est bien un administrateur (ou rédacteur si tu as ce rôle)
if (!isset($_SESSION['connected']) || $_SESSION['perm'] !== 'administrateur') {
    header('Location: ../index.php');
    exit();
}

require_once("./../includes/constantes.php");
require_once("./../includes/config-bdd.php");
require_once('./functions_query.php');
require_once('./functions-DB.php');

$mysqli = connectionDB();

$id_jeu = (int)$_POST['id_jeu'];
$titre = $_POST['titre'];
$contenu = $_POST['contenu'];
$note = (int)$_POST['note'];
$id_member = $_SESSION['id'];

// On ajoute l'article
addArticle($titre, $contenu, $note, $id_jeu, $id_member, $mysqli);

closeDB($mysqli);

// On redirige vers la page du jeu pour voir le résultat directement !
header("Location: ../jeu.php?numero=$id_jeu");
exit();
?>