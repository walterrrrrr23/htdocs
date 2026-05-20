<?php
ini_set('display_errors', 'on');


function DisplayGames($bdd)
{
    $isConnected = isset($_SESSION['connected']) && $_SESSION['connected'];

    echo '<div class="row">';

    foreach ($bdd as $jeu) {

      

        echo '<div class="col">';
        echo '<div class="card">';

        echo '<div class="cardbg">';

         

        echo '<h1 class="title">';

        echo $jeu['Nom'];
  

  
        echo '</h1>';

        
        echo '<a href="jeu.php?numero=' . $jeu['ID_jeu'] . '">';
        echo '<img src="' . $jeu['Image_tt'] . '" class="img_thumbnail">';
        echo '</a>';

        echo '</div>';

        echo '<div class="card-body">';

     
        echo '<h6 class="note">';

       
        echo $jeu['Notes'];

  
        echo '</h6>';


        echo '</div>';

        echo '</div>';
        echo '</div>';
    }

    echo '</div>';
}



function DisplayMainInfo($jeu)
{
     echo '<div class="col">';
        echo '<div class="card">';

        echo '<div class="cardbg">';

         

        echo '<h1 class="title">';

        echo $jeu['Nom'];
  

  
        echo '</h1>';

        
        echo '<a href="jeu.php?numero=' . $jeu['ID_jeu'] . '">';
        echo '<img src="' . $jeu['Image_tt'] . '" class="img_thumbnail">';
        echo '</a>';

        echo '</div>';

        echo '<div class="card-body">';

     
        echo '<h6 class="note">';

       
        echo $jeu['Prix'];

  
        echo '</h6>';


        echo '</div>';

        echo '</div>';
        echo '</div>';
    }

?>