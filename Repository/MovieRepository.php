<?php

function getAllMovies():array {

    require '../Service/Database.php';
    
    $sql = "SELECT * FROM movies LIMIT 10";
    
    $getMoviesStmt = $db->prepare($sql);
    $getMoviesStmt->execute();

    return  $getMoviesStmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMovieById(int $id):array {

    require '../Service/Database.php';
    
    $sql = "SELECT * FROM movies WHERE id = :id";
    
    $getMovieStmt = $db->prepare($sql);
    $getMovieStmt->bindParam(':id', $id);
    $getMovieStmt->execute();

    return  $getMovieStmt->fetchAll(PDO::FETCH_ASSOC);
}
    
function createMovie($title, $releasedate, $plot, $runtime): array{
    require '../Service/Database.php';

    $sql = "INSERT INTO movies (`title`, `release_date`, `plot`, `runtime`) VALUES (:title, :releasedate, :plot, :runtime)";
    $createMovieStmt = $db->prepare($sql);
    $createMovieStmt->execute([
        'title' => $title,
        'releasedate' => $releasedate,
        'plot' => $plot,
        'runtime' => $runtime
    ]);

    $sql = "SELECT MAX(id) FROM movies";
    $getMoviesCountStmt = $db->prepare($sql);
    $getMoviesCountStmt->execute();

    $lastId = $getMoviesCountStmt->fetch(PDO::FETCH_COLUMN);

    return getMovieById($lastId);

}

function updateMovie($id, $title, $releasedate, $plot, $runtime): array{
    require '../Service/Database.php';

    $sql = "UPDATE movies SET title = :title, release_date = :releasedate, plot = :plot, runtime = :runtime WHERE id = :id";
    $updateMovieStmt = $db->prepare($sql);
    $updateMovieStmt->execute([
        'id' => $id,
        'title' => $title,
        'releasedate' => $releasedate,
        'plot' => $plot,
        'runtime' => $runtime
    ]);

    return getMovieById($id);

}

function deleteMovie(int $id){
    require '../Service/Database.php';

    $sql = "DELETE FROM movies WHERE id = :id";

    $deleteMovieStmt = $db->prepare($sql);

    $deleteMovieStmt->execute([
        'id' => $id
    ]);
}

function getMovieByTitle(string $title):array {

    require '../Service/Database.php';
    
    $sql = "SELECT * FROM movies WHERE title LIKE :title";
    
    $getMovieStmt = $db->prepare($sql);
    $getMovieStmt->bindParam(':title', $title);
    $getMovieStmt->execute();

    return  $getMovieStmt->fetchAll(PDO::FETCH_ASSOC);
}
?>