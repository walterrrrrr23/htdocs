<?php
ini_set('display_errors', 'on');
session_start();

// SÉCURITÉ : Si l'utilisateur n'est pas administrateur, on le renvoie à l'accueil
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
$utilisateurs = getAllUsers($mysqli);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Utilisateurs - ESIR Critics</title>
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
            <h2>Panneau d'Administration : Utilisateurs</h2>

            <?php
            if (isset($_GET['msg']) && $_GET['msg'] == 'succes') {
                echo "<p class='msg-success'>Le rôle de l'utilisateur a été mis à jour avec succès.</p>";
            }
            if (isset($_GET['erreur']) && $_GET['erreur'] == 'meme_user') {
                echo "<p class='msg-error'>Vous ne pouvez pas modifier votre propre rôle.</p>";
            }
            ?>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Pseudo</th>
                        <th>Email</th>
                        <th>Rôle Actuel</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($utilisateurs as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['Username']); ?></td>
                            <td><?php echo htmlspecialchars($user['Mail']); ?></td>
                            <td>
                                <strong><?php echo ucfirst($user['Perm']); ?></strong>
                            </td>
                            <td>
                                <?php if ($user['ID_member'] !== $_SESSION['id']): ?>
                                    <form action="./php/update_role.php" method="POST" class="form-inline">
                                        <input type="hidden" name="id_membre" value="<?php echo $user['ID_member']; ?>">
                                        <select name="permission" class="select-role">
                                            <option value="membre" <?php if($user['Perm'] == 'membre') echo 'selected'; ?>>Membre</option>
                                            <option value="redacteur" <?php if($user['Perm'] == 'redacteur') echo 'selected'; ?>>Rédacteur</option>
                                            <option value="administrateur" <?php if($user['Perm'] == 'administrateur') echo 'selected'; ?>>Administrateur</option>
                                        </select>
                                        <button type="submit" class="btn-small">Mettre à jour</button>
                                    </form>
                                <?php else: ?>
                                    <em class="text-muted">C'est vous</em>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
        </div>
    </div>

    <?php include("./static/footer.php"); ?>
    <?php closeDB($mysqli); ?>
</body>
</html>