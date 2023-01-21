<?php 

require_once '../Repository/GenreRepository.php';

header('Content-Type: application/json');

$requestMethod = $_SERVER['REQUEST_METHOD'];

$id = $_GET['id'] ?? null;

switch ($requestMethod) {
    case 'GET':
        if($id) {
            if(preg_match("/genres\/\d+/", $_SERVER['REQUEST_URI'])) {
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
                $genres = getGenresByMovieId($id);
                if(!empty($genres)) {
                    http_response_code(200);
                    echo json_encode($genres);
                }else{
                    $error = ['code' => 404, 'message' => "Aucun film trouvé pour ce genre"];
                    http_response_code(404);
                    echo json_encode($error);
                }
            }
        }else{
            $genres = getAllGenres();
            if(!empty($genres) && $genres) {
                http_response_code(200);
                echo json_encode($genres);
            }else{
                $error = ['code' => 404, 'message' => "Aucun genre trouvé"];
                http_response_code(404);
                echo json_encode($error);
            }
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'));
        if(!isset($data->name)) {
            http_response_code(400);
            $error = ['code' => 400, 'message' => "Le champ 'name' est obligatoire"];
            echo json_encode($error);
        }else{
            $name = filter_var($data->name, FILTER_SANITIZE_STRING);
            $genre = createGenre($data->name);
            if(!$genre) {
                $error = ['code' => 500, 'message' => "Une erreur est survenue lors de la création du genre"];
                http_response_code(500);
                echo json_encode($error);
            }
            http_response_code(201);
            echo json_encode($genre);
        }
        break;
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'));
        if(!isset($data->name)) {
            http_response_code(400);
            $error = ['code' => 400, 'message' => "Le champ 'name' est obligatoire"];
            echo json_encode($error);
        }
        if($id) {
            $genre = getGenreById($id);
            if($genre) {
                $name = filter_var($data->name, FILTER_SANITIZE_STRING);

                $genre = updateGenre($id, $data->name);
                $message = ['code' => 200, 'message' => "Le genre numéro $id a été modifié"];
                http_response_code(200);
                echo json_encode($genre + $message);
            }else{
                $error = ['code' => 404, 'message' => "Le genre numéro $id n'existe pas"];
                http_response_code(404);
                echo json_encode($error);
            }
        }else{
            $error = ['code' => 400, 'message' => "L'identifiant du genre est obligatoire"];
            http_response_code(400);
            echo json_encode($error);
        }
        break;
    case 'DELETE':
        if($id) {
            $genre = getGenreById($id);
            if($genre) {
                deleteGenre($id);
                $message = ['code' => 200, 'message' => "Le genre numéro $id a été supprimé"];
                http_response_code(200);
                echo json_encode($message);
            }else{
                $error = ['code' => 404, 'message' => "Le genre numéro $id n'existe pas"];
                http_response_code(404);
                echo json_encode($error);
            }
        }else{
            $error = ['code' => 400, 'message' => "L'identifiant du genre est obligatoire"];
            http_response_code(400);
            echo json_encode($error);
        }
        break;
    default:
        http_response_code(405);
        $error = ['code' => 405, 'message' => "La méthode $requestMethod n'est pas autorisée"];
        echo json_encode($error);
    break;
}
