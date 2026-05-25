<?php
ini_set('display_errors', 'on');
session_start();

// Si l'utilisateur n'est pas connecté, on le renvoie vers la connexion
if (!isset($_SESSION['connected']) || !$_SESSION['connected']) {
    header('Location: connection.php');
    exit();
}

require_once("./includes/constantes.php");
require_once("./includes/config-bdd.php");
require_once("./php/functions-DB.php");
require_once("./php/functions_query.php");
require_once("./php/functions-structure.php");

$mysqli = connectionDB();
$id_user = $_SESSION['id'];

// Récupération des données
$user = getUserById($id_user, $mysqli);
$mes_avis = getUserReviews($id_user, $mysqli);
$mes_articles = getUserArticles($id_user, $mysqli);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil - ESIR Critics</title>
    <link rel="stylesheet" type="text/css" href="./styles/stylesheet.css">
</head>
<body>
    <?php include("./static/header.php"); ?>

    <nav>
    <ul>
        <li  ><a href="index.php">Accueil</a></li>
        <li><a href="recherche.php">Recherche</a></li>
        
        <?php if (isset($_SESSION['connected']) && $_SESSION['connected']): ?>

            <li class="active"><a href="profil.php">Mon Profil</a></li>
            <li><a href="./php/logout.php">Déconnexion</a></li>
            <?php if (isset($_SESSION['perm']) && $_SESSION['perm'] == 'administrateur'): ?>
                <li><a href="admin_utilisateur.php">Gestion Utilisateurs</a></li>
            <?php endif; ?>
        <?php else: ?>
            <li><a href="connection.php">Connexion</a></li>
            <li><a href="inscription.php">Inscription</a></li>
        <?php endif; ?>
            
    </ul>
    </nav>

    <div class="row">
        <div class="column middle">
             <div class="col2">
            <h2 class = 'title'>Mon Profil Privé</h2>

            <div class="column middle" style="padding: 10px; margin-bottom: 20px;">
                <p><strong>Date de création du compte :</strong> <?php echo $user['Date_creation'] ?? $user['date_creation'] ?? 'Non renseignée'; ?></p>
                <p><strong>Dernière connexion :</strong> <?php echo $user['Date_dern_conex'] ?? $user['date_dern_conex'] ?? 'Non renseignée'; ?></p>
            </div>

            <h3 class = 'title'>Modifier mes informations</h3>
            <?php
            if (isset($_GET['erreur']) && $_GET['erreur'] == 'login') {
                echo "<p style='color:red;'>Ce nom d'utilisateur est déjà pris.</p>";
            }
            if (isset($_GET['succes'])) {
                echo "<p style='color:#45db79;'>Profil mis à jour avec succès !</p>";
            }
            ?>
            <form action="./php/update_profil.php" method="POST" enctype="multipart/form-data" class="form-login">
                
                <label>Photo de profil actuelle :</label><br>
                <?php if (!empty($user['Photo'] ?? $user['Photo'])): ?>
                    <img src="<?php echo $user['Photo'] ?? $user['Photo']; ?>" alt="Photo de profil" class="img_thumbnail" style="max-width: 150px;"><br>
                <?php else: ?>
                    <p>Aucune photo</p>
                <?php endif; ?>
                <input type="file" name="photo_profil" accept="image/*"><br><br>

                <label>Nom d'utilisateur (Login) :</label><br>
                <input type="text" name="login" value="<?php echo htmlspecialchars($user['Username']); ?>" required><br><br>

                <label>Adresse mail :</label><br>
                <input type="email" name="mail" value="<?php echo htmlspecialchars($user['Mail']); ?>" required><br><br>

                <button type="submit">Sauvegarder les modifications</button>
            </form>

            <br><hr><br>

            <h3 class = 'title' >Mes Avis</h3>

        <?php

        if (isset($_GET['succes']) && $_GET['succes'] == 'avis_modifie') {
            echo "<p class='msg-success'>Votre avis a été modifié avec succès !</p>";
        }
        if (isset($_GET['msg']) && $_GET['msg'] == 'supprime') {
            echo "<p class='msg-success'>Votre avis a bien été supprimé.</p>";
        }
        ?>

        <?php if (count($mes_avis) > 0): ?>
        <div class='col2'>
        <?php foreach ($mes_avis as $avis): ?>
          
           <div class="card">

            <div class="cardbg">

            
           
                 <h6 class="title"><?php echo htmlspecialchars($avis['NomJeu']); ?></h6> 
            
               
                <h6 class="note avis"><?php echo $avis['note'] ?? $avis['Note']; ?></h6>
              
               
            
                 <a class = 'link-highlight' href="modifier_avis.php?id=<?php echo $avis['id_avis'] ?? $avis['ID_avis']; ?>">Modifier</a> 
                <a class = 'link-highlight2' href="./php/delete_avis.php?id=<?php echo $avis['id_avis'] ?? $avis['ID_avis']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet avis ?');">Supprimer</a> 

                  <h6 class="infos">Publié le <?php echo $avis['date_crea'] ?? $avis['Date_crea']; ?></h6>
            </div>
            </div>
          
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            <p>Vous n'avez posté aucun avis pour le moment.</p>
        <?php endif; ?>

            <?php if ($_SESSION['perm'] == 'redacteur' || $_SESSION['perm'] == 'administrateur'): ?>
                <br><hr><br>
                <h3 class = 'title'>Mes Articles</h3>
                <?php if (count($mes_articles) > 0): ?>
                     <div class='col2'>
                    <?php foreach ($mes_articles as $article): ?>
                          <div class="card">

                            <div class="cardbg">


                            <h6 class="title"><?php echo htmlspecialchars($article['Titre']); ?><h6>
                          
                             <a  class = 'link-highlight' href="#">Modifier</a>  <a class = 'link-highlight2' href="#">Supprimer</a> 
                              <h6 class="infos">Publié le <?php echo $article['Date_publ']; ?></h6>
                    </div>
                    </div>
                        <br>
                    <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>Vous n'avez rédigé aucun article.</p>
                <?php endif; ?>
            <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include("./static/footer.php"); ?>
    <?php closeDB($mysqli); ?>
</body>
</html>