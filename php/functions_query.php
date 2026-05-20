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
    $sql = $sql = "
SELECT 
    j.*,
  
    s.nom AS Supp,
    AVG(av.Note) AS Notes
FROM jeu j

LEFT JOIN avis av 
    ON j.ID_jeu = av.ID_jeu

LEFT JOIN support s 
    ON j.ID_support = s.ID_support

WHERE j.ID_jeu = '$id'

GROUP BY 
    j.ID_jeu,
    s.nom

LIMIT 1
";
    $res = readDB($mysqli, $sql);
    return $res[0] ?? null;
}

function getarticlebyID($id, $mysqli)


{
    $sql = $sql = "
SELECT 
    art.*,
    m.*
FROM jeu j

JOIN article art 
    ON j.ID_jeu = art.ID_jeu

JOIN membre m
    ON art.ID_member = m.ID_member


WHERE j.ID_jeu = '$id'

LIMIT 1
";
    $res = readDB($mysqli, $sql);
    return $res[0] ?? null;
}

?>


