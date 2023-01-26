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
            $firstname = filter_var($data->firstname, FILTER_SANITIZE_STRING);
            $lastname = filter_var($data->lastname, FILTER_SANITIZE_STRING);
            $dob = filter_var($data->dob, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{4}-\d{2}-\d{2}$/")));
            $bio = filter_var($data->bio, FILTER_SANITIZE_STRING);
            $existingActor = getDirectorByFirstnameAndLastname($firstname, $lastname);
            if($existingActor) {
                http_response_code(400);
                $error = ['error' => 400, 'message' => 'Ce réalisateur existe déjà'];
                echo json_encode($error);
            }elseif($firstname === ""){
                http_response_code(400);
                $error = ['error' => 400, 'message' => 'Veuillez entrer un prénom'];
                echo json_encode($error);
            }elseif($lastname === ""){
                http_response_code(400);
                $error = ['error' => 400, 'message' => 'Veuillez entrer un nom de famille'];
                echo json_encode($error);
            }
            elseif(strlen($firstname)>25){
                http_response_code(400);
                $error = ['error' => 400, 'message' => 'Le prénom ne doit pas dépasser 25 caractères'];
                echo json_encode($error);
            }elseif(strlen($lastname)>25){
                http_response_code(400);
                $error = ['error' => 400, 'message' => 'Le nom de famille ne doit pas dépasser 25 caractères'];
                echo json_encode($error);
            }elseif(!$dob){
                http_response_code(400);
                $error = ['error' => 400, 'message' => 'Veuillez entrer une date de naissance valide (yyyy-mm-dd)'];
                echo json_encode($error);
            }elseif($bio === ""){
                http_response_code(400);
                $error = ['error' => 400, 'message' => 'Veuillez entrer une biographie'];
                echo json_encode($error);
            }elseif(strlen($bio)>250){
                http_response_code(400);
                $error = ['error' => 400, 'message' => 'La biographie ne doit pas dépasser 250 caractères'];
                echo json_encode($error);
            }
            elseif(!preg_match("/^[a-zA-ZÀ-ÿ\s-]+$/", $firstname)) {
                http_response_code(400);
                $error = ['error' => 400, 'message' => 'Le prénom ne doit contenir que des lettres'];
                echo json_encode($error);
            }
            elseif(!preg_match("/^[a-zA-ZÀ-ÿ\s-]+$/", $lastname)) {
                http_response_code(400);
                $error = ['error' => 400, 'message' => 'Le nom ne doit contenir que des lettres'];
                echo json_encode($error);
            }else{
                $message = ['code' => 201, 'message' => "Le directeur $firstname $lastname a été correctement ajouté"];
                $director = createDirector($firstname, $lastname, $dob, $bio);
                http_response_code(201);
                echo json_encode($actor + $message);
            }
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
                $firstname = filter_var($data->firstname, FILTER_SANITIZE_STRING);
                $lastname = filter_var($data->lastname, FILTER_SANITIZE_STRING);
                $dob = filter_var($data->dob, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{4}-\d{2}-\d{2}$/")));
                $bio = filter_var($data->bio, FILTER_SANITIZE_STRING);
                if($firstname === ""){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'Veuillez entrer un prénom'];
                    echo json_encode($error);
                }elseif($lastname === ""){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'Veuillez entrer un nom de famille'];
                    echo json_encode($error);
                }
                elseif(strlen($firstname)>25){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'Le prénom ne doit pas dépasser 25 caractères'];
                    echo json_encode($error);
                }elseif(strlen($lastname)>25){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'Le nom de famille ne doit pas dépasser 25 caractères'];
                    echo json_encode($error);
                }elseif(!$dob){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'Veuillez entrer une date de naissance valide (yyyy-mm-dd)'];
                    echo json_encode($error);
                }elseif($bio === ""){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'Veuillez entrer une biographie'];
                    echo json_encode($error);
                }elseif(strlen($bio)>250){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'La biographie ne doit pas dépasser 250 caractères'];
                    echo json_encode($error);
                }
                elseif(!preg_match("/^[a-zA-ZÀ-ÿ\s-]+$/", $firstname)) {
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'Le prénom ne doit contenir que des lettres'];
                    echo json_encode($error);
                }
                elseif(!preg_match("/^[a-zA-ZÀ-ÿ\s-]+$/", $lastname)) {
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'Le nom ne doit contenir que des lettres'];
                    echo json_encode($error);
                }else{
                    $message = ['code' => 200, 'message' => "Le réalisateur $firstname $lastname a été modifié"];
                    $director = updateDirector($id, $firstname, $lastname, $dob, $bio);
                    http_response_code(200);
                    echo json_encode($director + $message);
                }
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