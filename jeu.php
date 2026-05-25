<?php
ini_set('display_errors', 'on');

require_once("./includes/constantes.php");
require_once("./includes/config-bdd.php");
require_once("./php/functions-DB.php");
require_once("./php/functions_query.php");
require_once("./php/functions-structure.php");

$sql_connection = connectionDB();

session_start();

if (!isset($_GET['numero'])) {
    header('Location: index.php');
    exit();
}

$numero = (int)$_GET['numero'];

$jeu = getgamebyID($numero, $sql_connection);
$article = getarticlebyID($numero, $sql_connection);
$image = getimagebyID($numero, $sql_connection);
$avis = getavisbyID($numero, $sql_connection);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Esir, Prepa">
    <meta name="author" content="Moi">
    <title>ESIR Critics</title>
    <link rel="icon" href="./images/logo.png">
    <link rel="stylesheet" type="text/css" href="./styles/stylesheet.css">
</head>
<body>
    <?php include("./static/header.php"); ?>

   <nav>
    <ul>
        <li ><a href="index.php">Accueil</a></li>
        <li><a href="recherche.php">Recherche</a></li>
        
        <?php if (isset($_SESSION['connected']) && $_SESSION['connected']): ?>

            <li><a href="profil.php">Mon Profil</a></li>
            <li><a href="./php/logout.php">Déconnexion</a></li>
            <?php if (isset($_SESSION['perm']) && $_SESSION['perm'] == 'administrateur'): ?>
                <li><a href="admin_utilisateur.php">Gestion Utilisateurs</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION['perm']) && $_SESSION['perm'] == 'administrateur'): ?>
                <li><a href="ajouter_article.php" class="link-highlight">Rédiger un article</a></li>
            <?php endif; ?>
        <?php else: ?>
            <li><a href="connection.php">Connexion</a></li>
            <li><a href="inscription.php">Inscription</a></li>
        <?php endif; ?>
            
    </ul>
    </nav>
  
    <div class="row">
        <div class="column side">
            <?php DisplayMainInfo($jeu); ?>
        </div>
        
        <div class="column middle">

            <h1 class="title"> ARTICLE</h1>
            <?php DisplayArticle($article); ?>
            <?php if (isset($_SESSION['perm']) && $_SESSION['perm'] == 'administrateur'): ?>
                <div class="action-links">
                    <a href="./php/delete_article.php?id=<?php echo $article['ID_article'] ?? $article['id_article']; ?>" class="msg-error" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.');">Supprimer l'article</a>
                </div>
            <?php endif; ?>

            <h1 class="title"> AVIS</h1>
            <?php DisplayAvis($avis); ?>

            <div class="form-avis-container">
                <h3>Rédiger une critique</h3>
                
                <div class="col2">
                <?php
                if (isset($_GET['succes']) && $_GET['succes'] == 'avis_ajoute') {
                    echo "<p class='msg-success'>Votre avis a été publié avec succès !</p>";
                }
                if (isset($_GET['erreur']) && $_GET['erreur'] == 'deja_poste') {
                    echo "<p class='msg-error'>Vous avez déjà donné votre avis sur ce jeu.</p>";
                }

                if (!isset($_SESSION['connected']) || !$_SESSION['connected']) {
                    echo "<p>Vous devez être <a href='connection.php' class='link-highlight'>connecté</a> pour laisser un avis.</p>";
                } 
                else {
                    $deja_poste = checkUserReviewExists($_SESSION['id'], $numero, $sql_connection);
                    
                    if (count($deja_poste) > 0) {
                        echo "<p><em>Vous avez déjà partagé votre critique pour ce jeu. Allez sur votre profil pour la modifier ou la supprimer.</em></p>";
                    } else {
                        ?>
                        <form action="./php/add_avis.php" method="POST" class="form-login">
                            <input type="hidden" name="id_jeu" value="<?php echo $numero; ?>">
                            
                            <label class = 'titre'>Titre de votre avis :</label><br>
                            <input type="text" name="titre" required class="input-full"><br><br>

                            <label  class = 'titre' >Votre critique :</label><br>
                            <textarea name="texte" rows="5" required class="input-full"></textarea><br><br>

                            <label  class = 'titre'>Note (sur 10) :</label><br>
                            <input type="number" name="note" min="0" max="10" required class="input-small"><br><br>

                            <button type="submit" class="btn-submit">Publier mon avis</button>
                        </form>
                        <?php
                    }
                }
                ?>
                  </div>
            </div>

            <br><hr><br>

            <h1 class="title"> IMAGES</h1>
            <?php DisplayImage($image); ?>
            
        </div>
    </div>

    <?php include("./static/footer.php"); ?>
    <?php closeDB($sql_connection); ?>

</body>
</html>