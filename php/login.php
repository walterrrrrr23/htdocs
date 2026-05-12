<?php
ini_set('display_errors', 'on');
session_start();
require_once("./../includes/constantes.php");
require_once("./../includes/config-bdd.php");
require_once ('./functions_query.php');
require_once ('./functions-DB.php');

if (!isset($_POST['login']) || !isset($_POST['password'])) {
    header('Location: ../connection.php');
    exit();
}

$login = $_POST['login'];
$password = $_POST['password'];


$mysqli = connectionDB(); 

$result = checkDresseur($login, $password, $mysqli);


if (count($result) == 0) {
    header('Location: ../connection.php');
    exit();
}


$user = $result[0];

$_SESSION['login'] = $user['nom_dresseur'];
$_SESSION['id'] = $user['mdp_dresseur'];
$_SESSION['connected'] = true;


closeDB($mysqli);


header('Location: ../index.php');
exit();
?>