<?php 

function getAllDirectors():array {

    require '../Service/Database.php';
    
    $sql = "SELECT * FROM directors";
    
    $getDirectorsStmt = $db->prepare($sql);
    $getDirectorsStmt->execute();

    return  $getDirectorsStmt->fetchAll(PDO::FETCH_ASSOC);
}

function getDirectorById(int $id):array {

    require '../Service/Database.php';
    
    $sql = "SELECT * FROM directors WHERE id = :id";
    
    $getDirectorsStmt = $db->prepare($sql);
    $getDirectorsStmt->bindParam(':id', $id);
    $getDirectorsStmt->execute();

    return  $getDirectorsStmt->fetchAll(PDO::FETCH_ASSOC);
}

function createDirector ($firstname, $lastname, $dob, $bio): array{
    require '../Service/Database.php';

    $sql = "INSERT INTO directors (`first_name`, `last_name`, `dob`, `bio`) VALUES (:firstname, :lastname, :dob, :bio)";
    $createDirectorStmt = $db->prepare($sql);

    $createDirectorStmt->execute([
        'firstname' => $firstname,
        'lastname' => $lastname,
        'dob' => $dob,
        'bio' => $bio
    ]);

    $sql = "SELECT MAX(id) FROM directors";
    $getDirectorsCountStmt = $db->prepare($sql);
    $getDirectorsCountStmt->execute();

    $lastId = $getDirectorsCountStmt->fetch(PDO::FETCH_COLUMN);

    return getDirectorById($lastId);
}

function updateDirector($id, $firstname, $lastname, $dob, $bio): array{
    require '../Service/Database.php';

    $sql = "UPDATE directors SET first_name = :firstname, last_name = :lastname, dob = :dob, bio = :bio WHERE id = :id";
    $updateDirectorStmt = $db->prepare($sql);
    $updateDirectorStmt->execute([
        'id' => $id,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'dob' => $dob,
        'bio' => $bio
    ]);

    return getDirectorById($id);

}

function deleteDirector(int $id){
    require '../Service/Database.php';

    $sql = "DELETE FROM directors WHERE id = :id";
    $deleteDirectorStmt = $db->prepare($sql);
    $deleteDirectorStmt->execute([
        'id' => $id
    ]);
}