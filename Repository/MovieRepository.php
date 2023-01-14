<?php

function getAllMovies():array {

    require '../Service/Database.php';
    
    $sql = "SELECT * FROM movies LIMIT 10";
    
    $getMoviesStmt = $db->prepare($sql);
    $getMoviesStmt->execute();

    return  $getMoviesStmt->fetchAll(PDO::FETCH_ASSOC);
}

?>