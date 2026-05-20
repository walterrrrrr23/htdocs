<?php


ini_set('display_errors', 'on');

function getIDbyName($mysqli,$name)
{
    $sql = "SELECT d.id_dresseur FROM dresseur d WHERE d.nom_dresseur = '$name'";
    return readDB($mysqli, $sql)[0]['id_dresseur'] ?? null;

}

function GetAllGames($mysqli)
{
    

    $sql = "
        SELECT 
            jeu.ID_jeu,
            jeu.Nom,
            jeu.Image_tt,
            AVG(Note) as Notes
        FROM jeu
        LEFT JOIN avis ON jeu.ID_jeu = avis.ID_jeu
        GROUP BY jeu.ID_jeu, jeu.Nom, jeu.Image_tt;
      
    ";

    return readDB($mysqli, $sql);
}

function getgamebyID($id, $mysqli)


{
     $sql = "SELECT j.*, art.*, av.* FROM jeu j
            JOIN article art ON j.ID_jeu = art.ID_jeu
            LEFT JOIN avis av
            ON j.ID_jeu = av.ID_jeu
            WHERE j.ID_jeu = $id LIMIT 1";
    $res = readDB($mysqli, $sql);
    return $res[0] ?? null;
}

function checkUser($login, $password, $mysqli)
{
    $sql = "SELECT * FROM MEMBRE WHERE Username = '$login' AND Mdp = '$password'";
    
    return readDB($mysqli, $sql);
}

function checkUsernameExists($login, $mysqli)
{
    $sql = "SELECT Username FROM MEMBRE WHERE Username = '$login'";
    return readDB($mysqli, $sql);
}

function insertMembre($nom, $prenom, $login, $mdp, $mail, $date_naiss, $mysqli)
{
    $sql = "INSERT INTO MEMBRE (Nom, Prenom, Username, Mdp, Mail, Date_naiss, Perm) 
            VALUES ('$nom', '$prenom', '$login', '$mdp', '$mail', '$date_naiss', 'membre')";
    
    return writeDB($mysqli, $sql);
}
?>


