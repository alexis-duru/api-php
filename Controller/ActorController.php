<?php 

require_once '../Repository/ActorRepository.php';

header('Content-Type: application/json');

$requestMethod = $_SERVER['REQUEST_METHOD'];

$id = $_GET['id'] ?? null;

switch ($requestMethod) {
    case 'GET':
    if($id) {
        if(preg_match("/actors\/\d+/", $_SERVER['REQUEST_URI'])) {
            $actor = getActorById($id);
            if($actor) {
                http_response_code(200);
                echo json_encode($actor);
            }else{
                $error = ['code' => 404, 'message' => "L'acteur avec l'identifiant $id n'existe pas" ,];
                http_response_code(404);
                echo json_encode($error);
            }
        }else{
            $actors = getActorsByMovieId($id);
            if(!empty($actors)) {
                http_response_code(200);
                echo json_encode($actors);
            }else{
                $error = ['code' => 404, 'message' => "Aucun acteur trouvé pour ce film"];
                http_response_code(404);
                echo json_encode($error);
            }
        }
    }else{
        $actors = getAllActors();
        http_response_code(200);
        echo json_encode($actors);
    }
    break;

    case "POST":
        $data = json_decode(file_get_contents('php://input'));
        if (!isset($data->firstname, $data->lastname, $data->dob, $data->bio)) {
            http_response_code(400);
            $error = ['error' => 400, 'message' => 'Veuillez renseigner tous les champs'];
            echo json_encode($error);
        } else {
            $actor = createActor($data->firstname, $data->lastname, $data->dob, $data->bio);
            http_response_code(201);
            echo json_encode($actor);
        }
        break;

    case "PUT":
        $data = json_decode(file_get_contents('php://input'));
        if (!isset($data->firstname, $data->lastname, $data->dob, $data->bio)) {
            http_response_code(400);
            $error = ['error' => 400, 'message' => 'Veuillez renseigner tous les champs'];
            echo json_encode($error);
        } else {
            if ($id) {
                $actor = getActorById($id);
                if(!$actor){
                    http_response_code(404);
                    echo json_encode(['code' => 404, 'message' => "L'acteur avec l'id $id n'existe pas"]);
                    return;
                }
                $actor = updateActor($id, $data->firstname, $data->lastname, $data->dob, $data->bio);
                http_response_code(200);
                echo json_encode($actor);
            } else {
                $error = ['error' => 400, 'message' => "Veuillez renseigner l'id de l'acteur à modifier"];
                echo json_encode($error);
            }
        }
        break;
    case "DELETE":
        if($id) {
            $actor = getActorById($id);
            if($actor) {
                deleteActor($id);
                $message = ['code' => 200, 'message' => "L'acteur avec l'identifiant $id a bien été supprimé" ,];
                http_response_code(200);
                echo json_encode($message);
            }else{
                $error = ['code' => 404, 'message' => "L'acteur avec l'identifiant $id n'existe pas" ,];
                http_response_code(404);
                echo json_encode($error);
            }
        }else{
            $error = ['code' => 400, 'message' => "Veuillez renseigner l'identifiant de l'acteur à supprimer" ,];
            http_response_code(400);
            echo json_encode($error);
        }
    break;
    // default:
    //     http_response_code(405);
    //     $error = ['error' => 405, 'message' => 'Méthode non autorisée'];
    //     echo json_encode($error);
    // break;
}