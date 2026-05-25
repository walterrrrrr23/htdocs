<?php
ini_set('display_errors', 'on');
session_start();

// SÉCURITÉ : Seul un administrateur a le droit de supprimer un article
if (!isset($_SESSION['connected']) || $_SESSION['perm'] !== 'administrateur') {
    header('Location: ../index.php');
    exit();
}

// On vérifie qu'on a bien reçu un ID d'article à supprimer
if (!isset($_GET['id'])) {
    header('Location: ../index.php');
    exit();
}

require_once("./../includes/constantes.php");
require_once("./../includes/config-bdd.php");
require_once('./functions_query.php');
require_once('./functions-DB.php');

$mysqli = connectionDB();
$id_article = (int)$_GET['id'];

// On appelle la fonction pour supprimer
deleteArticle($id_article, $mysqli);

closeDB($mysqli);

// On redirige vers l'accueil avec un message de succès
header('Location: ../index.php?msg=article_supprime');
exit();
?>