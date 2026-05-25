<?php
ini_set('display_errors', 'on');
session_start();

// Sécurité : on vérifie que l'utilisateur est bien connecté
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

// Récupération des champs texte
$new_login = $_POST['login'];
$new_mail = $_POST['mail'];

// 1. Vérification du pseudo unique (sauf si c'est déjà le sien)
$exists = checkOtherUsernameExists($new_login, $id_user, $mysqli);
if (count($exists) > 0) {
    closeDB($mysqli);
    // Le pseudo est pris par un autre membre, on le renvoie avec une erreur
    header('Location: ../profil.php?erreur=login');
    exit();
}

// 2. Traitement de la photo de profil
$photo_path = ""; // Par défaut, on ne change pas la photo

// On vérifie si un fichier a été envoyé et s'il n'y a pas d'erreur
if (isset($_FILES['photo_profil']) && $_FILES['photo_profil']['error'] == 0) {
    
    // On récupère l'extension du fichier (ex: jpg, png)
    $file_info = pathinfo($_FILES['photo_profil']['name']);
    $ext = strtolower($file_info['extension']);
    $allowed_exts = array('jpg', 'jpeg', 'png', 'gif');

    // Si l'extension est autorisée
    if (in_array($ext, $allowed_exts)) {
        // On crée un nom unique pour éviter d'écraser les photos des autres
        $new_filename = "profil_" . $id_user . "_" . time() . "." . $ext;
        
        // Le chemin où le fichier sera sauvegardé sur le serveur
        $destination = "../images/profils/" . $new_filename;

        // On déplace le fichier temporaire vers son dossier final
        if (move_uploaded_file($_FILES['photo_profil']['tmp_name'], $destination)) {
            // Le chemin qu'on va sauvegarder dans la base de données
            $photo_path = "./images/profils/" . $new_filename;
        }
    }
}

// 3. Mise à jour de la base de données
updateUserProfile($id_user, $new_login, $new_mail, $photo_path, $mysqli);

// On met à jour la variable de session au cas où le login aurait changé
$_SESSION['login'] = $new_login;

closeDB($mysqli);

// On redirige vers le profil avec un message de succès
header('Location: ../profil.php?succes=1');
exit();
?>