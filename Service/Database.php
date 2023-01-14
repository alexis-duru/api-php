<?php 
try {
    $db = new PDO('mysql:host=localhost;dbname=movies-api;charset=utf8', 'root', 'root');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>