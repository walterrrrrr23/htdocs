<?php
ini_set('display_errors', 'on');
session_start();

if (!isset($_SESSION['connected']) || $_SESSION['perm'] !== 'administrateur') {
    header('Location: ../index.php');
    exit();
}

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

deleteArticle($id_article, $mysqli);

closeDB($mysqli);

header('Location: ../index.php?msg=article_supprime');
exit();
?>