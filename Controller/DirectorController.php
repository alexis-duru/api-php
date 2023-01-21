<?php 

require_once '../Repository/DirectorRepository.php';

header('Content-Type: application/json');

$requestMethod = $_SERVER['REQUEST_METHOD'];

$id = $_GET['id'] ?? null;

switch ($requestMethod) {
    case 'GET':
        if($id) {
            if(preg_match("/directors\/\d+/", $_SERVER['REQUEST_URI'])) {
                $director = getDirectorById($id);
                if($director) {
                    http_response_code(200);
                    echo json_encode($director);
                }else{
                    $error = ['code' => 404, 'message' => "Le réalisateur avec l'identifiant $id n'existe pas" ,];
                    http_response_code(404);
                    echo json_encode($error);
                }
            }else{
                $directors = getDirectorsByMovieId($id);
                if(!empty($directors)) {
                    http_response_code(200);
                    echo json_encode($directors);
                }else{
                    $error = ['code' => 404, 'message' => "Aucun réalisateur trouvé pour ce film"];
                    http_response_code(404);
                    echo json_encode($error);
                }
            }
           
        }else{
            $directors = getAllDirectors();
            if(!empty($directors)) {
                http_response_code(200);
                echo json_encode($directors);
            }else{
                $error = ['code' => 404, 'message' => "Aucun réalisateur trouvé"];
                http_response_code(404);
                echo json_encode($error);
            }
        }
    break;
    case "POST":
        $data = json_decode(file_get_contents('php://input'));
        if (!isset($data->firstname, $data->lastname, $data->dob, $data->bio)) {
            http_response_code(400);
            $error = ['error' => 400, 'message' => 'Veuillez renseigner tous les champs'];
            echo json_encode($error);
        } else {
            $director = createDirector($data->firstname, $data->lastname, $data->dob, $data->bio);
            http_response_code(201);
            echo json_encode($director);
        }
        break;
    case "PUT":
        $data = json_decode(file_get_contents('php://input'));
        if (!isset($data->firstname, $data->lastname, $data->dob, $data->bio)) {
            http_response_code(400);
            $error = ['error' => 400, 'message' => 'Veuillez renseigner tous les champs'];
            echo json_encode($error);
        }
        if($id) {
            $director = getDirectorById($id);
            if($director) {
                updateDirector($id, $data->firstname, $data->lastname, $data->dob, $data->bio);
                $message = ['code' => 200, 'message' => "Le réalisateur avec l'identifiant $id a bien été modifié" ,];
                http_response_code(200);
                echo json_encode($message + $director);
            }else{
                $error = ['code' => 404, 'message' => "Le réalisateur avec l'identifiant $id n'existe pas" ,];
                http_response_code(404);
                echo json_encode($error);
            }
        }else{
            $error = ['code' => 400, 'message' => "Veuillez renseigner l'identifiant du réalisateur à modifier" ,];
            http_response_code(400);
            echo json_encode($error);
        }
    break;

    case "DELETE":
        if($id) {
            $director = getDirectorById($id);
            if($director) {
                deleteDirector($id);
                $message = ['code' => 200, 'message' => "Le réalisateur avec l'identifiant $id a bien été supprimé" ,];
                http_response_code(200);
                echo json_encode($message);
            }else{
                $error = ['code' => 404, 'message' => "Le réalisateur avec l'identifiant $id n'existe pas" ,];
                http_response_code(404);
                echo json_encode($error);
            }
        }else{
            $error = ['code' => 400, 'message' => "Veuillez renseigner l'identifiant du réalisateur à supprimer" ,];
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