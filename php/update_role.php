<?php
ini_set('display_errors', 'on');
session_start();

// SÉCURITÉ STRICTE : Seul un administrateur a le droit d'exécuter ce fichier
if (!isset($_SESSION['connected']) || $_SESSION['perm'] !== 'administrateur') {
    header('Location: ../index.php');
    exit();
}

require_once("./../includes/constantes.php");
require_once("./../includes/config-bdd.php");
require_once('./functions_query.php');
require_once('./functions-DB.php');

$mysqli = connectionDB();

$id_cible = (int)$_POST['id_membre'];
$nouvelle_perm = $_POST['permission'];

// Sécurité : On empêche l'administrateur de changer son propre rôle par erreur
if ($id_cible === $_SESSION['id']) {
    closeDB($mysqli);
    header('Location: ../admin_utilisateur.php?erreur=meme_user');
    exit();
}

// On vérifie que la permission envoyée est valide par sécurité
$roles_autorises = ['membre', 'redacteur', 'administrateur'];

if (in_array($nouvelle_perm, $roles_autorises)) {
    updateUserRole($id_cible, $nouvelle_perm, $mysqli);
    closeDB($mysqli);
    header("Location: ../admin_utilisateur.php?msg=succes");
    exit();
} else {
    closeDB($mysqli);
    header("Location: ../admin_utilisateur.php?erreur=invalide");
    exit();
}
?>