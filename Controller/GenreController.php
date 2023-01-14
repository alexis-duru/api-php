<?php 

require_once '../Repository/GenreRepository.php';

header('Content-Type: application/json');

$requestMethod = $_SERVER['REQUEST_METHOD'];

$id = $_GET['id'] ?? null;

switch ($requestMethod) {
    case 'GET':
        if($id) {
            $genre = getGenreById($id);
            if($genre) {

                http_response_code(200);
                echo json_encode($genre);
            }else{
                $error = ['code' => 404, 'message' => "Le genre avec l'identifiant $id n'existe pas" ,];

                http_response_code(404);
                echo json_encode($error);
            }
        }else{
            $genres = getAllGenres();
            http_response_code(200);
            echo json_encode($genres);
        }
        break;
   
}
