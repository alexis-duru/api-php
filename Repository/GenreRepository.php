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

    return getGenreById($id);
}

function deleteGenre(int $id){
    require '../Service/Database.php';

    $sql = "DELETE FROM genres WHERE id = :id";

    $deleteGenreStmt = $db->prepare($sql);

    $deleteGenreStmt->execute([
        'id' => $id
    ]);
}

function getGenresByMovieId(int $id) {
    require '../Service/Database.php';

    $sql = "SELECT genres.id, name, movies.id as movie_id FROM genres
    JOIN movie_genres ON genres.id = movie_genres.genre_id
    JOIN movies ON movies.id = movie_genres.movie_id
    WHERE movies.id = :id";

    $getGenreByMovieIdStmt = $db->prepare($sql);
    $getGenreByMovieIdStmt->bindParam(':id', $id);
    $getGenreByMovieIdStmt->execute();

    return $getGenreByMovieIdStmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMoviesByGenreId(int $id):array {

    require '../Service/Database.php';

    $sql = "SELECT movies.id, title, release_date, plot, runtime, genres.id as genre_id FROM movies
    JOIN movie_genres ON movies.id = movie_genres.movie_id
    JOIN genres ON genres.id = movie_genres.genre_id
    WHERE genres.id = :id";

    $getMoviesByGenreIdStmt = $db->prepare($sql);
    $getMoviesByGenreIdStmt->bindParam(':id', $id);
    $getMoviesByGenreIdStmt->execute();

    return  $getMoviesByGenreIdStmt->fetchAll(PDO::FETCH_ASSOC);
}

function  getGenreByName ( string $name ) : array  { 
    require '../Service/Database.php';

    $sql = "SELECT * FROM genres WHERE name = :name";

    $getGenreByTitleStmt = $db->prepare($sql);
    $getGenreByTitleStmt->bindParam(':name', $name);
    $getGenreByTitleStmt->execute();

    return  $getGenreByTitleStmt->fetchAll(PDO::FETCH_ASSOC);
}