<?php

ini_set('display_errors', 'on');

require_once("./includes/constantes.php");
require_once("./includes/config-bdd.php");
require_once("./php/functions-DB.php");
require_once("./php/functions_query.php");
require_once("./php/functions-structure.php");

$sql_connection = connectionDB();

session_start();



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
            <li    ><a href="./../index.php">Maison</a></li>
            <?php if (isset($_SESSION['connected']) && $_SESSION['connected']): ?>
                <li><a href="./../php/logout.php">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="./../connection.php">Connection</a></li>
            <?php endif; ?>
         
       
        </ul>
         <a href="index.html">
       
    </a>

 
    



    </nav>
  
      <?php
        if (!isset($_GET['numero'])) {
        header('Location: index.php');
        exit();
        }

        

        $numero = $_GET['numero'];

        $jeu = getgamebyID($numero , $sql_connection);
        $article = getarticlebyID($numero , $sql_connection);
        $image = getimagebyID($numero , $sql_connection);
        $avis = getavisbyID($numero , $sql_connection);
        
        
    ?>


     <div class="row">

    <div class="column side">
          <?php    DisplayMainInfo($jeu)   ?>
    </div>
    
    <div class="column middle">

                <h1 class="title"> ARTICLE</h1>
                  <?php    DisplayArticle($article)   ?>
                
                     <h1 class="title"> AVIS</h1>
                  <?php    DisplayAvis($avis)   ?>

                     <h1 class="title"> IMAGES</h1>
                    <?php    DisplayImage($image)   ?>
    </div>

     </div>
  


    
   
   
    <?php include("./static/footer.php"); ?>
    <?php closeDB($sql_connection); ?>

</body>
</html>