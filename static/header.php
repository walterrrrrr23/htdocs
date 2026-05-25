<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<head>
    <meta charset="UTF-8">
    <title>Esir Critics</title> //trop creatif
    <link rel="stylesheet" href="styles/stylesheet.css">
</head>


<header>
    <div class="entete-logo">
        <a href="index.php">
            <img src="images/logo.png" alt="Logo Kritik Kontrol" width="50">
        </a>
        <h1>ESIR Critics</h1> //trop trop creatif
    </div>
   
</header>
