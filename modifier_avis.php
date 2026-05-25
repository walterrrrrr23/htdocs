<?php
ini_set('display_errors', 'on');
session_start();

if (!isset($_SESSION['connected']) || !$_SESSION['connected'] || !isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

require_once("./includes/constantes.php");
require_once("./includes/config-bdd.php");
require_once("./php/functions-DB.php");
require_once("./php/functions_query.php");
require_once("./php/functions-structure.php");

$mysqli = connectionDB();
$id_avis = (int)$_GET['id'];
$id_member = $_SESSION['id'];

// On récupère l'avis actuel
$avis_actuel = getSingleReview($id_avis, $id_member, $mysqli);

// Si l'avis n'existe pas ou n'appartient pas à la personne, on la renvoie sur son profil
if (!$avis_actuel) {
    closeDB($mysqli);
    header('Location: profil.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier mon avis - ESIR Critics</title>
    <link rel="stylesheet" type="text/css" href="./styles/stylesheet.css">
</head>
<body>
    <?php include("./static/header.php"); ?>

    <nav>
        <ul>
            <li><a href="index.php">Maison</a></li>
            <li><a href="profil.php">Mon Profil</a></li>
            <li><a href="./php/logout.php">Déconnexion</a></li>
        </ul>
    </nav>
  
    <div class="row">
        <div class="column middle">
            <h2>Modifier mon avis</h2>

            <div class="form-avis-container">
                <form action="./php/update_avis.php" method="POST" class="form-login">
                    
                    <input type="hidden" name="id_avis" value="<?php echo $avis_actuel['id_avis']; ?>">
                    
                    <label>Titre de votre avis :</label><br>
                    <input type="text" name="titre" value="<?php echo htmlspecialchars($avis_actuel['titre']); ?>" required class="input-full"><br><br>

                    <label>Votre critique :</label><br>
                    <textarea name="texte" rows="5" required class="input-full"><?php echo htmlspecialchars($avis_actuel['texte']); ?></textarea><br><br>

                    <label>Note (sur 10) :</label><br>
                    <input type="number" name="note" min="0" max="10" value="<?php echo $avis_actuel['note']; ?>" required class="input-small"><br><br>

                    <button type="submit" class="btn-submit">Mettre à jour mon avis</button>
                    <a href="profil.php" class="btn-submit" style="background-color: gray; text-decoration: none; display: inline-block; margin-left: 10px;">Annuler</a>
                </form>
            </div>
            
        </div>
    </div>

    <?php include("./static/footer.php"); ?>
    <?php closeDB($mysqli); ?>
</body>
</html>