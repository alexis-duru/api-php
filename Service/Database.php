<?php 
try {
    $db = new PDO('mysql:host=localhost;dbname=movies-api;charset=utf8', 'root', 'root');
    echo 'Connexion réussie';
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>