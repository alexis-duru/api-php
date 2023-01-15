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

function createGenre($name): array{
    require '../Service/Database.php';

    $sql = "INSERT INTO genres (`name`) VALUES (:name)";

    $createGenreStmt = $db->prepare($sql);

    $createGenreStmt->execute([
        'name' => $name
    ]);

    $sql = "SELECT MAX(id) FROM genres";
    $getGenresCountStmt = $db->prepare($sql);
    $getGenresCountStmt->execute();

    $lastId = $getGenresCountStmt->fetch(PDO::FETCH_COLUMN);

    return getGenreById($lastId);
}

function updateGenre($id, $name): array{
    require '../Service/Database.php';

    $sql = "UPDATE genres SET name = :name WHERE id = :id";

    $updateGenreStmt = $db->prepare($sql);

    $updateGenreStmt->execute([
        'id' => $id,
        'name' => $name
    ]);

    return deleteGenre($id);
}

function deleteGenre(int $id){
    require '../Service/Database.php';

    $sql = "DELETE FROM genres WHERE id = :id";
    
    $deleteGenreStmt = $db->prepare($sql);

    $deleteGenreStmt->execute([
        'id' => $id
    ]);
}