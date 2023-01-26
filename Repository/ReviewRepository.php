<?php 

function getAllReviews():array {

    require '../Service/Database.php';
    
    $sql = "SELECT * FROM reviews";
    
    $getReviewsStmt = $db->prepare($sql);
    $getReviewsStmt->execute();

    return  $getReviewsStmt->fetchAll(PDO::FETCH_ASSOC);
}

function getReviewById(int $id):array {

    require '../Service/Database.php';
    
    $sql = "SELECT * FROM reviews WHERE id = :id";
    
    $getReviewsStmt = $db->prepare($sql);
    $getReviewsStmt->bindParam(':id', $id);
    $getReviewsStmt->execute();

    return  $getReviewsStmt->fetchAll(PDO::FETCH_ASSOC);
}

function createReview($movie_id, $username, $content, $date): array{
    require '../Service/Database.php';

    $sql = "INSERT INTO reviews (`movie_id`, `username`, `content`, `date`) VALUES (:movie_id, :username, :content, :date)";
    $createReviewStmt = $db->prepare($sql);
    $createReviewStmt->execute([
        'movie_id' => $movie_id,
        'username' => $username,
        'content' => $content,
        'date' => $date
    ]);

    $sql = "SELECT MAX(id) FROM reviews";
    $getReviewsCountStmt = $db->prepare($sql);
    $getReviewsCountStmt->execute();

    $lastId = $getReviewsCountStmt->fetch(PDO::FETCH_COLUMN);

    return getReviewById($lastId);
}

function updateReview($id, $movie_id, $username, $content, $date): array{
    require '../Service/Database.php';

    $sql = "UPDATE reviews SET movie_id = :movie_id, username = :username, content = :content, date = :date WHERE id = :id";
    $updateReviewStmt = $db->prepare($sql);
    $updateReviewStmt->execute([
        'id' => $id,
        'movie_id' => $movie_id,
        'username' => $username,
        'content' => $content,
        'date' => $date
    ]);

    return getReviewById($id);

}

function deleteReview(int $id){
    require '../Service/Database.php';

    $sql = "DELETE FROM reviews WHERE id = :id";
    
    $deleteReviewStmt = $db->prepare($sql);

    $deleteReviewStmt->execute([
        'id' => $id
    ]);
}

function getReviewsByMovieId(int $id):array {
    require '../Service/Database.php';

    $sql = "SELECT reviews.id, reviews.movie_id, reviews.username, reviews.content, reviews.date FROM reviews JOIN movies ON movies.id = reviews.movie_id WHERE movies.id = :id ORDER BY reviews.date DESC";

    $getReviewsStmt = $db->prepare($sql);
    $getReviewsStmt->bindParam(':id', $id);
    $getReviewsStmt->execute();

    return  $getReviewsStmt->fetchAll(PDO::FETCH_ASSOC);
}


?>