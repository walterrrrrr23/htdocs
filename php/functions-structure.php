<?php
ini_set('display_errors', 'on');


function DisplayGames($bdd)
{
    $isConnected = isset($_SESSION['connected']) && $_SESSION['connected'];

    echo '<div class="row m-5 p-5 row-cols-lg-6 g-2">';

    foreach ($bdd as $jeu) {

      

        echo '<div class="col">';
        echo '<div class="card h-100 shadow-sm text-center">';

        echo '<div class="bg-light p-3">';
        
        echo '<a href="jeu.php?numero=' . $jeu['ID_jeu'] . '">';
        echo '<img src="' . $jeu['Image_tt'] . '" class="img-fluid">';
        echo '</a>';

        echo '</div>';

        echo '<div class="card-body">';

      

        echo '<h6 class="card-title text-capitalize">';

        echo $jeu['Nom'];
        echo $jeu['Notes'];

  
        echo '</h6>';

        echo '</div>';

        echo '</div>';
        echo '</div>';
    }

    echo '</div>';
}
?>