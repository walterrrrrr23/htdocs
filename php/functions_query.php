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
    $nom_propre = mysqli_real_escape_string($mysqli, $nom_recherche);
    $id_propre = mysqli_real_escape_string($mysqli, $id_categorie);

    $sql = "SELECT jeu.ID_jeu, jeu.Nom, jeu.Image_tt, AVG(avis.Note) as Notes 
            FROM JEU jeu 
            LEFT JOIN AVIS avis ON jeu.ID_jeu = avis.ID_jeu";

    if (!empty($id_propre)) {
        $sql .= " INNER JOIN CLASSER c ON jeu.ID_jeu = c.ID_jeu AND c.ID_genre = '$id_propre' ";
    }

    $sql .= " WHERE 1=1 ";

    if (!empty($nom_propre)) {
        $sql .= " AND jeu.Nom LIKE '%$nom_propre%' ";
    }

    $sql .= " GROUP BY jeu.ID_jeu, jeu.Nom, jeu.Image_tt";

    return readDB($mysqli, $sql);
}

function countArticles($mysqli)
{

    $sql = "SELECT COUNT(*) as total FROM article";
    $res = readDB($mysqli, $sql);
    return $res[0]['total'] ?? 0;
}

function GetArticlesSortedAndPaginated($mysqli, $limit, $offset)
{
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

function getUserById($id, $mysqli)
{
    $sql = "SELECT * FROM MEMBRE WHERE ID_member = $id";
    $res = readDB($mysqli, $sql);
    return $res[0] ?? null;
}

function getUserReviews($id, $mysqli)
{
    $sql = "SELECT a.id_avis, a.titre, a.note, a.date_crea, j.nom as NomJeu 
            FROM AVIS a 
            JOIN JEU j ON a.ID_jeu = j.ID_jeu 
            WHERE a.ID_member = $id 
            ORDER BY a.date_crea DESC";
    return readDB($mysqli, $sql);
}

function getUserArticles($id, $mysqli)
{
    $sql = "SELECT ID_article, Titre, Date_publ 
            FROM ARTICLE 
            WHERE ID_member = $id 
            ORDER BY Date_publ DESC";
    return readDB($mysqli, $sql);
}

function checkOtherUsernameExists($login, $id_user, $mysqli)
{
    $sql = "SELECT Username FROM MEMBRE WHERE Username = '$login' AND ID_member != $id_user";
    return readDB($mysqli, $sql);
}

function updateUserProfile($id_user, $login, $mail, $photo_path, $mysqli)
{

    $sql = "UPDATE MEMBRE SET Username = '$login', Mail = '$mail'";

    if ($photo_path != "") {
        $sql .= ", photo = '$photo_path'";
    }

    $sql .= " WHERE ID_member = $id_user";

    return writeDB($mysqli, $sql);
}


function checkUserReviewExists($id_member, $id_jeu, $mysqli)
{
    $sql = "SELECT id_avis FROM AVIS WHERE ID_member = $id_member AND ID_jeu = $id_jeu";
    return readDB($mysqli, $sql);
}

//pour ajouter avis
function addReview($titre, $texte, $note, $id_member, $id_jeu, $mysqli)
{
    $titre_propre = mysqli_real_escape_string($mysqli, $titre);
    $texte_propre = mysqli_real_escape_string($mysqli, $texte);
    
    $sql = "INSERT INTO AVIS (titre, texte, note, date_crea, ID_member, ID_jeu) 
            VALUES ('$titre_propre', '$texte_propre', $note, CURRENT_TIMESTAMP, $id_member, $id_jeu)";
            
    return writeDB($mysqli, $sql);
}

//pour modifier un avis existant
function updateReview($id_avis, $titre, $texte, $note, $id_member, $mysqli)
{
    $titre_propre = mysqli_real_escape_string($mysqli, $titre);
    $texte_propre = mysqli_real_escape_string($mysqli, $texte);
    
    // Le "AND ID_member = $id_member" garantit qu'il ne modifie que SON avis
    $sql = "UPDATE AVIS SET titre = '$titre_propre', texte = '$texte_propre', note = $note 
            WHERE id_avis = $id_avis AND ID_member = $id_member";
            
    return writeDB($mysqli, $sql);
}

// 4. Supprimer un avis (avec le droit spécial pour l'admin)
function deleteReview($id_avis, $id_member, $perm, $mysqli)
{
    // Si c'est un admin, il a le droit de supprimer n'importe quel ID
    if ($perm === 'administrateur') {
        $sql = "DELETE FROM AVIS WHERE id_avis = $id_avis";
    } else {
        // Sinon, il ne peut supprimer que le sien
        $sql = "DELETE FROM AVIS WHERE id_avis = $id_avis AND ID_member = $id_member";
    }
    
    return writeDB($mysqli, $sql);
}

function getSingleReview($id_avis, $id_member, $mysqli)
{
    $sql = "SELECT id_avis, titre, texte, note, ID_jeu FROM AVIS WHERE id_avis = $id_avis AND ID_member = $id_member";
    $res = readDB($mysqli, $sql);
    return $res[0] ?? null;
}

function getAllUsers($mysqli)
{
    $sql = "SELECT ID_member, Username, Mail, Perm FROM MEMBRE ORDER BY Username ASC";
    return readDB($mysqli, $sql);
}

function updateUserRole($id_member, $new_perm, $mysqli)
{
    $perm_propre = mysqli_real_escape_string($mysqli, $new_perm);
    
    $sql = "UPDATE MEMBRE SET Perm = '$perm_propre' WHERE ID_member = $id_member";
    return writeDB($mysqli, $sql);
}
function getJeuxSansArticle($mysqli)
{
    $sql = "SELECT id_jeu, nom FROM JEU WHERE id_jeu NOT IN (SELECT ID_jeu FROM ARTICLE) ORDER BY nom ASC";
    return readDB($mysqli, $sql);
}


function addArticle($titre, $contenu, $note, $id_jeu, $id_member, $mysqli)
{
    $titre_propre = mysqli_real_escape_string($mysqli, $titre);
    $contenu_propre = mysqli_real_escape_string($mysqli, $contenu);
    
    $sql = "INSERT INTO ARTICLE (titre, contenu, note, date_publ, ID_jeu, ID_member) 
            VALUES ('$titre_propre', '$contenu_propre', $note, CURRENT_TIMESTAMP, $id_jeu, $id_member)";
            
    return writeDB($mysqli, $sql);
}

function deleteArticle($id_article, $mysqli)
{
    $sql = "DELETE FROM ARTICLE WHERE ID_article = $id_article";
    return writeDB($mysqli, $sql);
}
?>









