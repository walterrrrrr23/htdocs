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

       
        echo number_format($jeu['Notes'],1);

  
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
        echo '<img src="' . $jeu['Image_tt'] . '" class="img_thumbnail_big">';
        echo '</a>';

        echo '</div>';

        echo '<div class="card-infos">';

     
        echo '<h6 class="prix">';

       
        echo $jeu['Prix'] . "$";

  
        echo '</h6>';

            echo '<h6 class="prix">';

       
        echo $jeu['Date_sortie'] ;

  
        echo '</h6>';



            echo '<h6 class="prix">';

       
        echo $jeu['Synopsis'] ;

  
        echo '</h6>';


            echo '<h6 class="prix">';

       
        echo $jeu['Supp'] ;

  
        echo '</h6>';

        
            echo '<h6 class="note">';

       
        echo number_format($jeu['Notes'],1) ;

  
        echo '</h6>';




        echo '</div>';

        echo '</div>';
        echo '</div>';
    }


function DisplayArticle($article)
{



     echo '<div class="col">';
        echo '<div class="card">';

        echo '<div class="cardbg">';

        
        echo '<div class="infocard">';

        echo '<img src="' . $article['Photo'] . '" class="member_icon">';
        
        echo '<h1 class="username">';

        echo $article['Username'];
  
          echo '</h1>';
        echo '</div>';
  
      
        
      
      


        echo '<h1 class="title">';

        echo $article['Titre'];
  

  
        echo '</h1>';

      
        echo '</div>';

        echo '<div class="card-infos">';

     
        echo '<h6 class="texte_avis">';

       
        echo $article['Contenu'];

  
        echo '</h6>';

        
        echo '<h6 class="note">';

       
        echo number_format($article['Note'], 1);

  
        echo '</h6>';


          echo '<h6 class="infos">';

       
        echo $article['Date_publ'];

  
        echo '</h6>';


        if (isset($article['Date_modif']) ){
              echo '<h6 class="infos">';

       
        echo '( modifié ' . $article['Date_modif'] .')';

  
        echo '</h6>';

      
        }

         

      




        echo '</div>';

        echo '</div>';
        echo '</div>';
    }


    function DisplayImage($img)
{




     echo '<div class="col">';

        foreach ($img as $image) {
        echo '<div class="card">';

        echo '<div class="cardbg">';

        
        echo '<div class="infocard">';

        echo '<img src="' . $image['chemin'] . '" class="game_img">';





        echo '</div>';

        echo '</div>';
         echo '</div>';
        }
        echo '</div>';
    }


function DisplayAvis($avis)
{



     echo '<div class="col">';


        foreach ($avis as $article) {
        echo '<div class="card avis">';
        echo '<div class="cardbg avis">';

        
        echo '<div class="infocard avis">';
          
        echo '<h6 class="note avis">';

       
        echo $article['Note'];

  
        echo '</h6>';

        echo '<img src="' . $article['Photo'] . '" class="member_icon avis">';
        
        echo '<h1 class="username avis">';

       echo '<h1 class="username avis">';
        echo $article['Username'];
        echo '</h1>';
        echo '</div>';
        
      
      


        echo '<h1 class="title avis">';

        echo $article['Titre'];
  

  
        echo '</h1>';

      
       

        echo '<div class="card-infos avis">';

     
        echo '<h6 class="texte_avis">';

       
        echo $article['Texte'];

  
        echo '</h6>';

      


        echo '<h6 class="infos">';

       
        echo $article['Date_crea'];

  
        echo '</h6>';

      




        echo '</div>';

        echo '</div>';
         echo '</div>';


        }
        echo '</div>';
    }

?>