<?php
session_start();
// Si l'utilisateur est déjà connecté, on le renvoie vers l'accueil
if (isset($_SESSION['connected']) && $_SESSION['connected']) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - ESIR Critics</title>
    <link rel="stylesheet" type="text/css" href="./styles/stylesheet.css">
</head>
<body>
    <?php include("./static/header.php"); ?>

     <nav>

        

        <ul>
            <li  ><a href="./../index.php">Maison</a></li>
            <li ><a href="recherche.php">Recherche</a></li>
            <?php if (isset($_SESSION['connected']) && $_SESSION['connected']): ?>
                <li><a href="./../php/logout.php">Déconnexion</a></li>
            <?php else: ?>
                <li  class = 'active'><a href="./../connection.php">Connection</a></li>
            
        
                <li ><a href="inscription.php">Inscription</a></li>
            <?php endif; ?>

       
        </ul>
         <a href="index.html">
       
    </a>

 
    



    </nav>

    <div class="row">
        <div class="column middle">
            <h2>Connexion à votre compte</h2>
            
            <form action="./php/login.php" method="POST" class="form-login">
                <br>
                <label for="login">Nom d'utilisateur (Login) :</label><br>
                <input type="text" id="login" name="login" required><br><br>

                <label for="password">Mot de passe :</label><br>
                <input type="password" id="password" name="password" required><br><br>

                <button type="submit">Se connecter</button>
            </form>
        </div>
    </div>

    <?php include("./static/footer.php"); ?>
</body>
</html>