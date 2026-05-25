<?php
ini_set('display_errors', 'on');

require_once("./includes/constantes.php");
require_once("./includes/config-bdd.php");
require_once("./php/functions-DB.php");
require_once("./php/functions_query.php");
require_once("./php/functions-structure.php");

$sql_connection = connectionDB();

session_start();

$limit = 5; 

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}

$offset = ($page - 1) * $limit;

$total_articles = countArticles($sql_connection);
$total_pages = ceil($total_articles / $limit);

$result = GetArticlesSortedAndPaginated($sql_connection, $limit, $offset);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - ESIR Critics</title>
    <link rel="stylesheet" type="text/css" href="./styles/stylesheet.css">
</head>
<body>
    <?php include("./static/header.php"); ?>

    <nav>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="recherche.php">Recherche</a></li>
        
        <?php if (isset($_SESSION['connected']) && $_SESSION['connected']): ?>

            <li><a href="profil.php">Mon Profil</a></li>
            <li><a href="./php/logout.php">Déconnexion</a></li>
            <?php if (isset($_SESSION['perm']) && $_SESSION['perm'] == 'administrateur'): ?>
                <li><a href="admin_utilisateur.php" class="link-highlight">Gestion Utilisateurs</a></li>
            <?php endif; ?>
        <?php else: ?>
            <li><a href="connection.php">Connexion</a></li>
            <li><a href="inscription.php">Inscription</a></li>
        <?php endif; ?>
            
    </ul>
    </nav>

    <div class="row">
        <div class="column middle">
            <h2>Dernières Critiques de Jeux Vidéo</h2>

            <?php
            if (count($result) > 0) {
                
                DisplayGames($result);
                
                echo '<div class="pagination-container">';
                
                if ($page > 1) {
                    echo '<a href="index.php?page=' . ($page - 1) . '" class="page-link">&laquo; Précédent</a>';
                }
                
                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == $page) {
                        echo '<strong class="page-active">' . $i . '</strong>';
                    } else {
                        echo '<a href="index.php?page=' . $i . '" class="page-link">' . $i . '</a>';
                    }
                }
                
                if ($page < $total_pages) {
                    echo '<a href="index.php?page=' . ($page + 1) . '" class="page-link">Suivant &raquo;</a>';
                }
                
                echo '</div>';
            } else {
                echo '<p>Aucun article n\'est disponible pour le moment.</p>';
            }
            ?>
        </div>
    </div>

    <?php include("./static/footer.php"); ?>
    <?php closeDB($sql_connection); ?>
</body>
</html>