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
function getimagebyID($id, $mysqli)


{
    $sql = $sql = "
SELECT 
    p.*
FROM jeu j

JOIN photos p 
    ON j.ID_jeu = p.ID_jeu


WHERE j.ID_jeu = '$id'

";
    $res = readDB($mysqli, $sql);
    return $res;
}

function getavisbyID($id, $mysqli)


{
    $sql = $sql = "
SELECT 
    av.*,
    m.*
FROM jeu j

JOIN avis av 
    ON j.ID_jeu = av.ID_jeu

JOIN membre m
    ON av.ID_member = m.ID_member


WHERE j.ID_jeu = '$id'

";
    $res = readDB($mysqli, $sql);
    return $res;
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

function updateLastConnection($id_member, $mysqli)
{
    // On met a jour le champ Date_dern_conex avec l'heure actuelle du serveur
    $sql = "UPDATE MEMBRE SET Date_dern_conex = CURRENT_TIMESTAMP WHERE ID_member = $id_member";
    
    return writeDB($mysqli, $sql);
}

function getAllCategories($mysqli)
{
    $sql = "SELECT ID_genre, nom FROM GENRE ORDER BY nom ASC";
    return readDB($mysqli, $sql);
}

function searchGames($nom_recherche, $id_categorie, $mysqli)
{
    // On sécurise les entrées pour éviter les bugs si l'utilisateur tape des guillemets
    $nom_propre = mysqli_real_escape_string($mysqli, $nom_recherche);
    $id_propre = mysqli_real_escape_string($mysqli, $id_categorie);

    // On commence la requete de base
    $sql = "SELECT jeu.ID_jeu, jeu.Nom, jeu.Image_tt, AVG(avis.Note) as Notes 
            FROM JEU jeu 
            LEFT JOIN AVIS avis ON jeu.ID_jeu = avis.ID_jeu";

    // Si l'utilisateur a choisi une categorie, on fait la liaison avec la table CLASSER
    if (!empty($id_propre)) {
        $sql .= " INNER JOIN CLASSER c ON jeu.ID_jeu = c.ID_jeu AND c.ID_genre = '$id_propre' ";
    }

    // Le WHERE 1=1 est une petite astuce pour pouvoir ajouter des AND facilement apres
    $sql .= " WHERE 1=1 ";

    // Si l'utilisateur a tapé un nom, on utilise LIKE pour chercher ce mot dans le titre
    if (!empty($nom_propre)) {
        $sql .= " AND jeu.Nom LIKE '%$nom_propre%' ";
    }

    // On regroupe pour calculer la moyenne correctement
    $sql .= " GROUP BY jeu.ID_jeu, jeu.Nom, jeu.Image_tt";

    return readDB($mysqli, $sql);
}

function countArticles($mysqli)
{
    // On compte le nombre total d'articles dans la base
    $sql = "SELECT COUNT(*) as total FROM article";
    $res = readDB($mysqli, $sql);
    return $res[0]['total'] ?? 0;
}

function GetArticlesSortedAndPaginated($mysqli, $limit, $offset)
{
    // On selectionne les jeux associes aux articles en les triant par la date de l'article
    $sql = "
        SELECT 
            jeu.ID_jeu,
            jeu.Nom,
            jeu.Image_tt,
            AVG(avis.Note) as Notes
        FROM article
        JOIN jeu ON article.ID_jeu = jeu.ID_jeu
        LEFT JOIN avis ON jeu.ID_jeu = avis.ID_jeu
        GROUP BY jeu.ID_jeu, jeu.Nom, jeu.Image_tt, article.Date_publ
        ORDER BY article.Date_publ DESC
        LIMIT $limit OFFSET $offset;
    ";

    return readDB($mysqli, $sql);
}
?>








