<?php
ini_set('display_errors', 'on');
session_start();

// On vérifie que l'utilisateur est connecté et que le formulaire a été envoyé
if (!isset($_SESSION['connected']) || !$_SESSION['connected'] || !isset($_POST['id_jeu'])) {
    header('Location: ../index.php');
    exit();
}

require_once("./../includes/constantes.php");
require_once("./../includes/config-bdd.php");
require_once('./functions_query.php');
require_once('./functions-DB.php');

$mysqli = connectionDB();

$id_member = $_SESSION['id'];
$id_jeu = (int)$_POST['id_jeu'];
$titre = $_POST['titre'];
$texte = $_POST['texte'];
$note = (int)$_POST['note'];

// Double sécurité : on vérifie que le membre n'a pas déjà posté un avis sur ce jeu
$deja_poste = checkUserReviewExists($id_member, $id_jeu, $mysqli);

if (count($deja_poste) > 0) {
    closeDB($mysqli);
    // Il a déjà posté, on le renvoie sur la page du jeu avec une erreur
    header("Location: ../jeu.php?numero=$id_jeu&erreur=deja_poste");
    exit();
}

// Tout est bon, on ajoute l'avis
addReview($titre, $texte, $note, $id_member, $id_jeu, $mysqli);

closeDB($mysqli);

// On le renvoie sur la page du jeu avec un message de succès
header("Location: ../jeu.php?numero=$id_jeu&succes=avis_ajoute");
exit();
?>