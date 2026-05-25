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

    <div class="row">
        <div class="column middle">
            <h2>Mon Profil Privé</h2>

            <div class="cardbg" style="padding: 10px; margin-bottom: 20px;">
                <p><strong>Date de création du compte :</strong> <?php echo $user['date_creation']; ?></p>
                <p><strong>Dernière connexion :</strong> <?php echo $user['date_dern_conex']; ?></p>
            </div>

            <h3>Modifier mes informations</h3>
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
                <?php if (!empty($user['photo'])): ?>
                    <img src="<?php echo $user['photo']; ?>" alt="Photo de profil" class="img_thumbnail" style="max-width: 150px;"><br>
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

            <h3>Mes Avis (Bonus)</h3>
            <?php if (count($mes_avis) > 0): ?>
                <ul>
                <?php foreach ($mes_avis as $avis): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($avis['NomJeu']); ?></strong> - 
                        Note : <?php echo $avis['Note']; ?>/10 <br>
                        <em>Publié le <?php echo $avis['date_crea']; ?></em>
                        [ <a href="#">Modifier</a> | <a href="#">Supprimer</a> ]
                    </li>
                    <br>
                <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Vous n'avez posté aucun avis pour le moment.</p>
            <?php endif; ?>

            <?php if ($_SESSION['perm'] == 'redacteur' || $_SESSION['perm'] == 'administrateur'): ?>
                <br><hr><br>
                <h3>Mes Articles (Bonus)</h3>
                <?php if (count($mes_articles) > 0): ?>
                    <ul>
                    <?php foreach ($mes_articles as $article): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($article['Titre']); ?></strong><br>
                            <em>Publié le <?php echo $article['Date_publ']; ?></em>
                            [ <a href="#">Modifier</a> | <a href="#">Supprimer</a> ]
                        </li>
                        <br>
                    <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Vous n'avez rédigé aucun article.</p>
                <?php endif; ?>
            <?php endif; ?>

        </div>
    </div>

    <?php include("./static/footer.php"); ?>
    <?php closeDB($mysqli); ?>
</body>
</html>