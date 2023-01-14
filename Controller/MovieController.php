<?php 

require_once '../Repository/MovieRepository.php';

header('Content-Type: application/json');

$requestMethod = $_SERVER['REQUEST_METHOD'];

$id = $_GET['id'] ?? null;
    switch ($requestMethod) {
        case 'GET':
            if($id) {
                $movie = getMovieById($id);
                if($movie) {

                    http_response_code(200);
                    echo json_encode($movie);
                }else{
                    $error = ['code' => 404, 'message' => "Le film avec l'identifiant $id n'existe pas" ,];

                    http_response_code(404);
                    echo json_encode($error);
                }
            }else{
                $movies = getAllMovies();
                http_response_code(200);
                echo json_encode($movies);
            }
            break;
            case "POST":
                $data = json_decode(file_get_contents('php://input'));
                if (!isset($data->title, $data->releasedate, $data->plot, $data->runtime)) {
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'Veuillez renseigner tous les champs'];
                    echo json_encode($error);
                } else {
                    // Valider les données avant d'insérer
                    $movie = createMovie($data->title, $data->releasedate, $data->plot, $data->runtime);
                    http_response_code(201);
                    echo json_encode($movie);
                }
                break;
                
            case "PUT":
                $data = json_decode(file_get_contents('php://input'));
                if (!isset($data->title, $data->releasedate, $data->plot, $data->runtime)) {
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'Veuillez renseigner tous les champs'];
                    echo json_encode($error);
                } else {
                    // Valider les données avant d'insérer
                    $movie = updateMovie($id, $data->title, $data->releasedate, $data->plot, $data->runtime);
                    http_response_code(200);
                    echo json_encode($movie);
                }
                break;

            case "DELETE":
                if($id) {
                    $movie = getMovieById($id);
                    if($movie) {
                        deleteMovie($id);

                        // ecrire un message pour signifier que le message a bien été supprimé
                        $message = ['code' => 200, 'message' => "Le film avec l'identifiant $id a bien été supprimé" ,];
                        http_response_code(200);
                        echo json_encode($message);

                    }else{
                        $error = ['code' => 404, 'message' => "Le film avec l'identifiant $id n'existe pas" ,];
                        http_response_code(404);
                        echo json_encode($error);
                    }
                }else{
                    $error = ['code' => 400, 'message' => "Veuillez renseigner l'identifiant du film à supprimer" ,];
                    http_response_code(400);
                    echo json_encode($error);
                }
                break;
    }
?>