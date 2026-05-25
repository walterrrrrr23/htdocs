<?php
ini_set('display_errors', 'on');
session_start();

if (!isset($_SESSION['connected']) || !$_SESSION['connected']) {
    header('Location: ../connection.php');
    exit();
}

require_once("./../includes/constantes.php");
require_once("./../includes/config-bdd.php");
require_once('./functions_query.php');
require_once('./functions-DB.php');

$mysqli = connectionDB();
$id_user = $_SESSION['id'];

$new_login = $_POST['login'];
$new_mail = $_POST['mail'];


$exists = checkOtherUsernameExists($new_login, $id_user, $mysqli);
if (count($exists) > 0) {
    closeDB($mysqli);
    //le pseudo est pris
    header('Location: ../profil.php?erreur=login');
    exit();
}

$photo_path = "";

if (isset($_FILES['photo_profil']) && $_FILES['photo_profil']['error'] == 0) {
    
    $file_info = pathinfo($_FILES['photo_profil']['name']);
    $ext = strtolower($file_info['extension']);
    $allowed_exts = array('jpg', 'jpeg', 'png', 'gif');

    if (in_array($ext, $allowed_exts)) {
        $new_filename = "profil_" . $id_user . "_" . time() . "." . $ext;
        
        $destination = "../images/profils/" . $new_filename;

        if (move_uploaded_file($_FILES['photo_profil']['tmp_name'], $destination)) {
            $photo_path = "./images/profils/" . $new_filename;
        }
    }
}

updateUserProfile($id_user, $new_login, $new_mail, $photo_path, $mysqli);

$_SESSION['login'] = $new_login;

closeDB($mysqli);


header('Location: ../profil.php?succes=1');
exit();
?>