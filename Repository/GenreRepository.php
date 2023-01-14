<?php 

function getAllGenres():array {

    require '../Service/Database.php';
    
    $sql = "SELECT * FROM genres";
    
    $getGenresStmt = $db->prepare($sql);
    $getGenresStmt->execute();

    return  $getGenresStmt->fetchAll(PDO::FETCH_ASSOC);
}

function getGenreById(int $id):array {

    require '../Service/Database.php';
    
    $sql = "SELECT * FROM genres WHERE id = :id";
    
    $getGenreStmt = $db->prepare($sql);
    $getGenreStmt->bindParam(':id', $id);
    $getGenreStmt->execute();

    return  $getGenreStmt->fetchAll(PDO::FETCH_ASSOC);
}