<?php
ini_set('display_errors', 'on');
session_start();

require_once("./../includes/constantes.php");
require_once("./../includes/config-bdd.php");
require_once('./functions_query.php');
require_once('./functions-DB.php');

if (!isset($_POST['login']) || !isset($_POST['password']) || !isset($_POST['date_naiss'])) {
    header('Location: ../inscription.php');
    exit();
}

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$mail = $_POST['mail'];
$date_naiss = $_POST['date_naiss'];
$login = $_POST['login'];
$password = $_POST['password'];

$aujourdhui = new DateTime();
$naissance = new DateTime($date_naiss);
$age = $aujourdhui->diff($naissance)->y;

if ($age <= 15) {
    header('Location: ../inscription.php?erreur=age');
    exit();
}

$mysqli = connectionDB();

$exists = checkUsernameExists($login, $mysqli);

//pseudo existe deja
if (count($exists) > 0) {
    closeDB($mysqli);
    header('Location: ../inscription.php?erreur=login');
    exit();
}

insertMembre($nom, $prenom, $login, $password, $mail, $date_naiss, $mysqli);

closeDB($mysqli);

header('Location: ../connection.php');
exit();
?>