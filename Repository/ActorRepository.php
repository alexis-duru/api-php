<?php 

function getAllActors():array {

    require '../Service/Database.php';
    
    $sql = "SELECT * FROM actors";
    
    $getActorsStmt = $db->prepare($sql);
    $getActorsStmt->execute();

    return  $getActorsStmt->fetchAll(PDO::FETCH_ASSOC);
}

function getActorById(int $id):array {

    require '../Service/Database.php';
    
    $sql = "SELECT * FROM actors WHERE id = :id";
    
    $getActorStmt = $db->prepare($sql);
    $getActorStmt->bindParam(':id', $id);
    $getActorStmt->execute();

    return  $getActorStmt->fetchAll(PDO::FETCH_ASSOC);
}

function createActor ($firstname, $lastname, $dob, $bio): array{
    require '../Service/Database.php';

    $sql = "INSERT INTO actors (`first_name`, `last_name`, `dob`, `bio`) VALUES (:firstname, :lastname, :dob, :bio)";
    $createActorStmt = $db->prepare($sql);

    $createActorStmt->execute([
        'firstname' => $firstname,
        'lastname' => $lastname,
        'dob' => $dob,
        'bio' => $bio
    ]);

    $sql = "SELECT MAX(id) FROM actors";
    $getActorsCountStmt = $db->prepare($sql);
    $getActorsCountStmt->execute();

    $lastId = $getActorsCountStmt->fetch(PDO::FETCH_COLUMN);

    return getActorById($lastId);
}

function updateActor(int $id, $firstname, $lastname, $dob, $bio): array{
    require '../Service/Database.php';

    $sql = "UPDATE actors SET first_name = :firstname, last_name = :lastname, dob = :dob, bio = :bio WHERE id = :id";

    $updateActorStmt =  $db->prepare($sql);
    $updateActorStmt->execute([
        'id' => $id,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'dob' => $dob,
        'bio' => $bio
    ]);

    return getActorById($id);
}

function deleteActor(int $id){
    require '../Service/Database.php';

    $sql = "DELETE FROM actors WHERE id = :id";
    $deleteActorStmt = $db->prepare($sql);
    $deleteActorStmt->execute([
        'id' => $id
    ]);
}

function getActorsByMovieId(int $id):array {

    require '../Service/Database.php';
    
    $sql = "SELECT actors.id, first_name, last_name, dob, bio, movies.id as movie_id FROM actors
    JOIN movie_actors ON actors.id = movie_actors.actor_id
    JOIN movies ON movies.id = movie_actors.movie_id
    WHERE movies.id = :id";

    $getActorsByMovieIdStmt = $db->prepare($sql);
    $getActorsByMovieIdStmt->bindParam(':id', $id);
    $getActorsByMovieIdStmt->execute();

    return  $getActorsByMovieIdStmt->fetchAll(PDO::FETCH_ASSOC);
}


function getMoviesByActorId(int $id):array {

    require '../Service/Database.php';

    $sql = "SELECT movies.id, title, release_date, plot, runtime, actors.id as actor_id FROM movies
    JOIN movie_actors ON movies.id = movie_actors.movie_id
    JOIN actors ON actors.id = movie_actors.actor_id
    WHERE actors.id = :id";

    $getMoviesByActorIdStmt = $db->prepare($sql);
    $getMoviesByActorIdStmt->bindParam(':id', $id);
    $getMoviesByActorIdStmt->execute();

    return  $getMoviesByActorIdStmt->fetchAll(PDO::FETCH_ASSOC);
}

function  getActorByFirstNameAndLastname ($firstname, $lastname):array {

    require '../Service/Database.php';

    $sql = "SELECT * FROM actors WHERE first_name = :firstname AND last_name = :lastname";

    $getActorByFirstNameAndLastnameStmt = $db->prepare($sql);
    $getActorByFirstNameAndLastnameStmt->execute([
        'firstname' => $firstname,
        'lastname' => $lastname
    ]);

    return  $getActorByFirstNameAndLastnameStmt->fetchAll(PDO::FETCH_ASSOC);
}