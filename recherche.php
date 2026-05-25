<?php
ini_set('display_errors', 'on');
session_start();

require_once("./includes/constantes.php");
require_once("./includes/config-bdd.php");
require_once("./php/functions-DB.php");
require_once("./php/functions_query.php");
require_once("./php/functions-structure.php");

$mysqli = connectionDB();

$categories = getAllCategories($mysqli);

$recherche_nom = isset($_GET['nom_jeu']) ? $_GET['nom_jeu'] : '';
$recherche_cat = isset($_GET['categorie']) ? $_GET['categorie'] : '';

$jeux_trouves = searchGames($recherche_nom, $recherche_cat, $mysqli);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche - ESIR Critics</title>
    <link rel="stylesheet" type="text/css" href="./styles/stylesheet.css">
</head>
<body>
    <?php include("./static/header.php"); ?>

   <nav>
    <ul>
        <li ><a href="index.php">Accueil</a></li>
        <li class="active"><a href="recherche.php">Recherche</a></li>
        
        <?php if (isset($_SESSION['connected']) && $_SESSION['connected']): ?>

            <li><a href="profil.php">Mon Profil</a></li>
            <li><a href="./php/logout.php">Déconnexion</a></li>
            <?php if (isset($_SESSION['perm']) && $_SESSION['perm'] == 'administrateur'): ?>
                <li><a href="admin_utilisateur.php" >Gestion Utilisateurs</a></li>
            <?php endif; ?>
        <?php else: ?>
            <li><a href="connection.php">Connexion</a></li>
            <li><a href="inscription.php">Inscription</a></li>
        <?php endif; ?>
            
    </ul>
    </nav>
    <div class="row">
        <div class="column middle">
            <h2 class = "title" >Rechercher un jeu vidéo</h2>
            
            <form action="recherche.php" method="GET" class="form-login">
                <label>Nom du jeu :</label>
                <input type="text" name="nom_jeu" value="<?php echo htmlspecialchars($recherche_nom); ?>">
                
                <label>Catégorie :</label>
                <select name="categorie">
                    <option value="">Toutes les catégories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['ID_genre']; ?>" <?php if($recherche_cat == $cat['ID_genre']) echo 'selected'; ?>>
                            <?php echo $cat['nom']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <button type="submit">Rechercher</button>
            </form>

            <br><hr><br>

            <h3>Résultats de la recherche :</h3>
            <?php 
            if (count($jeux_trouves) > 0) {
                DisplayGames($jeux_trouves);
            } else {
                echo "<p>Aucun jeu ne correspond à votre recherche.</p>";
            }
            ?>

        </div>
    </div>

    <?php include("./static/footer.php"); ?>
    <?php closeDB($mysqli); ?>
</body>
</html>