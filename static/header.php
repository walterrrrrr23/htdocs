<header>
    
    <h1>POKEDEX</h1>
   
    <?php
        ini_set('display_errors', 'on');

if (isset($_SESSION['connected']) && $_SESSION['connected']) {
    echo "Connecté en tant que " . $_SESSION['login'];
} else {
    echo "Non connecté";
}
?> 
  
</header>