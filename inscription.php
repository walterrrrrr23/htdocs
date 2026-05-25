<?php
session_start();

if (isset($_SESSION['connected']) && $_SESSION['connected']) {
    header('Location: index.php');
    exit(); //si connecté; peut pas s'inscrire
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - ESIR Critics</title>
    <link rel="stylesheet" type="text/css" href="./styles/stylesheet.css">
</head>
<body>
    <?php include("./static/header.php"); ?>

     <nav>
    <ul>
        <li  ><a href="index.php">Accueil</a></li>
        <li><a href="recherche.php">Recherche</a></li>
        
        <?php if (isset($_SESSION['connected']) && $_SESSION['connected']): ?>

            <li><a href="profil.php">Mon Profil</a></li>
            <li><a href="./php/logout.php">Déconnexion</a></li>
            <?php if (isset($_SESSION['perm']) && $_SESSION['perm'] == 'administrateur'): ?>
                <li><a href="admin_utilisateur.php">Gestion Utilisateurs</a></li>
            <?php endif; ?>
        <?php else: ?>
            <li><a href="connection.php">Connexion</a></li>
            <li class="active"><a href="inscription.php">Inscription</a></li>
        <?php endif; ?>
            
    </ul>
    </nav>

    <div class="row">
        <div class="column middle">
                <div class="col2">
            <h2 class= "title">Créer un compte</h2>
            
            <?php
            
            if (isset($_GET['erreur'])) {
                if ($_GET['erreur'] == 'age') {
                    echo "<p style='color:red;'>Inscription refusée : Vous devez avoir plus de 15 ans pour créer un compte.</p>";
                } elseif ($_GET['erreur'] == 'login') {
                    echo "<p style='color:red;'>Ce nom d'utilisateur est déjà utilisé. Veuillez en choisir un autre.</p>";
                }
            }
            ?>

            <form action="./php/register.php" method="POST" class="form-login">
                <label  class = 'titre'>Nom :</label><br>
                <input type="text" name="nom" required><br><br>

                <label  class = 'titre'>Prénom :</label><br>
                <input type="text" name="prenom" required><br><br>

                <label  class = 'titre'>Adresse mail :</label><br>
                <input type="email" name="mail" required><br><br>

                <label  class = 'titre'>Date de naissance :</label><br>
                <input type="date" name="date_naiss" required><br><br>

                <label  class = 'titre'>Username :</label><br>
                <input type="text" name="login" required><br><br>

                <label  class = 'titre'>Mot de passe :</label><br>
                <input type="password" name="password" required><br><br>

                <button type="submit">S'inscrire</button>
            </form>
            </div>
        </div>
    </div>

    <?php include("./static/footer.php"); ?>
</body>
</html>