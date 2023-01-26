<?php 

require_once '../Repository/MovieRepository.php';
require_once '../Repository/DirectorRepository.php';
require_once '../Repository/ActorRepository.php';
require_once '../Repository/GenreRepository.php';

header('Content-Type: application/json');

$requestMethod = $_SERVER['REQUEST_METHOD'];

$id = $_GET['id'] ?? null;
$parent = $_GET['parent'] ?? null;

switch ($requestMethod) {
    case 'GET':
        if($id) {
            switch ($parent){
                case "actors":
                    $movies = getMoviesByActorId($id);
                    if($movies) {
                        http_response_code(200);
                        echo json_encode($movies);
                    } else {
                        http_response_code(404);
                        echo json_encode(['code' => 404, 'message' => "L'acteur avec l'id $id n'est dans aucun film de la liste"]);
                    }
                return;

                case "directors":
                    $movies = getMoviesByDirectorId($id);
                    if($movies) {
                        http_response_code(200);
                        echo json_encode($movies);
                    } else {
                        http_response_code(404);
                        echo json_encode(['code' => 404, 'message' => "Le directeur avec l'id $id n'appartient à aucun film de la liste"]);
                    }
                return;

                case "genres":
                    $movies = getMoviesByGenreId($id);
                    if($movies) {
                        http_response_code(200);
                        echo json_encode($movies);
                    } else {
                        http_response_code(404);
                        echo json_encode(['code' => 404, 'message' => "Le genre avec l'id $id ne correspond à aucun film de la liste"]);
                    }
                return;
            }
            $movies = getMovieById($id);
            if(!empty($movies)) {
                http_response_code(200);
                echo json_encode($movies);
            }else{
                $error = ['code' => 404, 'message' => "Aucun film trouvé pour ce film"];
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
            $title = filter_var($data->title, FILTER_SANITIZE_STRING);
            $releasedate = filter_var($data->releasedate, FILTER_SANITIZE_STRING);
            $releasedate = filter_var($data->releasedate, FILTER_VALIDATE_INT);
            $plot = filter_var($data->plot, FILTER_SANITIZE_STRING);
            $runtime = filter_var($data->runtime, FILTER_SANITIZE_STRING);
            $runtime = filter_var($data->runtime, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/")));
            $existingMovie = getMovieByTitle($title);
            if (!empty($existingMovie)) {
                http_response_code(409);
                $error = ['error' => 409, 'message' => 'Un film avec le même titre existe déjà'];
                echo json_encode($error);
            } else{
                if(strlen($releasedate)!==4){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'Veuillez renseigner une date de sortie valide'];
                    echo json_encode($error);
                }elseif($title === ""){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'Veuillez renseigner un titre'];
                    echo json_encode($error);
                }elseif(strlen($plot)>250){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'La description ne doit pas dépasser 250 caractères'];
                    echo json_encode($error);
                }
                elseif($plot === ""){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'Veuillez renseigner une description'];
                    echo json_encode($error);
                }
                elseif(!$runtime){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'Veuillez renseigner une durée de film valide'];
                    echo json_encode($error);
                }
                else{
                    $movie = createMovie($data->title, $data->releasedate, $data->plot, $data->runtime);
                    http_response_code(201);
                    echo json_encode($movie);
                }

            }
        }
        break;
            
    case "PUT":
        $data = json_decode(file_get_contents('php://input'));
        if (!isset($data->title, $data->releasedate, $data->plot, $data->runtime)) {
            http_response_code(400);
            $error = ['error' => 400, 'message' => 'Veuillez renseigner tous les champs ou inscrire des valeurs valides'];
            echo json_encode($error);
        } 
        if($id) {
            $movie = getMovieById($id);
            if($movie) {
                $title = filter_var($data->title, FILTER_SANITIZE_STRING);
                $releasedate = filter_var($data->releasedate, FILTER_SANITIZE_STRING);
                $releasedate = filter_var($data->releasedate, FILTER_VALIDATE_INT);
                $plot = filter_var($data->plot, FILTER_SANITIZE_STRING);
                $runtime = filter_var($data->runtime, FILTER_SANITIZE_STRING);
                $runtime = filter_var($data->runtime, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/")));
                $existingMovie = getMovieByTitle($title);
                if(strlen($releasedate)!==4){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'Veuillez renseigner une date de sortie valide'];
                    echo json_encode($error);
                }elseif(strlen($plot)>250){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'La description ne doit pas dépasser 250 caractères'];
                    echo json_encode($error);
                }elseif($title === ""){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'Veuillez renseigner un titre'];
                    echo json_encode($error);
                }
                elseif($plot === ""){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'Veuillez renseigner une description'];
                    echo json_encode($error);
                }
                elseif(!$runtime){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'Veuillez renseigner une durée de film valide'];
                    echo json_encode($error);
                }else{
                    $movie = updateMovie($id, $data->title, $data->releasedate, $data->plot, $data->runtime);
                    $message = ['code' => 200, 'message' => "Le film avec l'identifiant $id a bien été modifié"];
                    echo json_encode($message + $movie);
                }
            }else{
                $error = ['code' => 404, 'message' => "Le film avec l'identifiant $id n'existe pas ou a déja été supprimé" ,];
                http_response_code(404);
                echo json_encode($error);
            }
        }else{
            $error = ['code' => 400, 'message' => "Veuillez renseigner un identifiant"];
            http_response_code(400);
            echo json_encode($error);
        }
    break;

    case "DELETE":
        if($id) {
            $movie = getMovieById($id);
            if($movie) {
                deleteMovie($id);
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
    default:
        http_response_code(405);
        $error = ['error' => 405, 'message' => 'Méthode non autorisée'];
        echo json_encode($error);
    break;
}
?>