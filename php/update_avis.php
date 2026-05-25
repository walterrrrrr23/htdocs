<?php
ini_set('display_errors', 'on');
session_start();

if (!isset($_SESSION['connected']) || !$_SESSION['connected'] || !isset($_POST['id_avis'])) {
    header('Location: ../index.php');
    exit();
}

require_once("./../includes/constantes.php");
require_once("./../includes/config-bdd.php");
require_once('./functions_query.php');
require_once('./functions-DB.php');

$mysqli = connectionDB();

$id_avis = (int)$_POST['id_avis'];
$id_member = $_SESSION['id'];
$titre = $_POST['titre'];
$texte = $_POST['texte'];
$note = (int)$_POST['note'];

// On appelle la fonction de mise à jour que tu as déjà dans functions_query.php
updateReview($id_avis, $titre, $texte, $note, $id_member, $mysqli);

closeDB($mysqli);

// On renvoie l'utilisateur sur son profil avec un message de succès
header("Location: ../profil.php?succes=avis_modifie");
exit();
?>