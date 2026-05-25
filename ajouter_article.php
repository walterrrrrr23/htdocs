<?php
ini_set('display_errors', 'on');
session_start();

if (!isset($_SESSION['connected']) || $_SESSION['perm'] !== 'administrateur') {
    header('Location: index.php');
    exit();
}

require_once("./includes/constantes.php");
require_once("./includes/config-bdd.php");
require_once("./php/functions-DB.php");
require_once("./php/functions_query.php");
require_once("./php/functions-structure.php");

$mysqli = connectionDB();

$jeux_dispos = getJeuxSansArticle($mysqli);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rédiger un article - ESIR Critics</title>
    <link rel="stylesheet" type="text/css" href="./styles/stylesheet.css">
</head>
<body>
    <?php include("./static/header.php"); ?>

    <nav>
        <ul>
            <li><a href="index.php">Maison</a></li>
            <li><a href="profil.php">Mon Profil</a></li>
            <li><a href="admin_utilisateurs.php">Gestion Utilisateurs</a></li>
            <li><a href="./php/logout.php">Déconnexion</a></li>
        </ul>
    </nav>
  
    <div class="row">
        <div class="column middle">
            <h2>Rédiger un nouvel article</h2>

            <?php if (count($jeux_dispos) == 0): ?>
                <p class="msg-error">Tous les jeux ont déjà un article ! Ajoutez d'abord un nouveau jeu dans la base de données.</p>
            <?php else: ?>
                <div class="form-avis-container">
                    <form action="./php/process_article.php" method="POST" class="form-login">
                        
                        <label>Choisir le jeu :</label><br>
                        <select name="id_jeu" class="input-full" required>
                            <option value="">-- Sélectionnez un jeu --</option>
                            <?php foreach ($jeux_dispos as $jeu): ?>
                                <option value="<?php echo $jeu['id_jeu']; ?>"><?php echo htmlspecialchars($jeu['nom']); ?></option>
                            <?php endforeach; ?>
                        </select><br><br>

                        <label>Titre de l'article :</label><br>
                        <input type="text" name="titre" required class="input-full"><br><br>

                        <label>Contenu de l'article :</label><br>
                        <textarea name="contenu" rows="10" required class="input-full"></textarea><br><br>

                        <label>Note de la rédaction (sur 20) :</label><br>
                        <input type="number" name="note" min="0" max="20" required class="input-small"><br><br>

                        <button type="submit" class="btn-submit">Publier l'article</button>
                    </form>
                </div>
            <?php endif; ?>
            
        </div>
    </div>

    <?php include("./static/footer.php"); ?>
    <?php closeDB($mysqli); ?>
</body>
</html>