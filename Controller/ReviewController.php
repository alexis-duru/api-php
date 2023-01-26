<?php 

require_once '../Repository/ReviewRepository.php';
require_once '../Repository/MovieRepository.php';

header('Content-Type: application/json');

$requestMethod = $_SERVER['REQUEST_METHOD'];

$id = $_GET['id'] ?? null;

switch ($requestMethod) {
    case 'GET':
        if($id) {
            if($id) {
                if(preg_match("/reviews\/\d+/", $_SERVER['REQUEST_URI'])) {
                    $review = getReviewById($id);
                    if($review) {
                        http_response_code(200);
                        echo json_encode($review);
                    }else{
                        $error = ['code' => 404, 'message' => "L'article avec l'identifiant $id n'existe pas" ,];
                        http_response_code(404);
                        echo json_encode($error);
                    }
                }else{
                    $reviews = getReviewsByMovieId($id);
                    if(!empty($reviews)) {
                        http_response_code(200);
                        echo json_encode($reviews);
                    }else{
                        $error = ['code' => 404, 'message' => "Aucun article trouvé pour ce film"];
                        http_response_code(404);
                        echo json_encode($error);
                    }
                }
            }else{
                $reviews = getAllReviews();
                http_response_code(200);
                echo json_encode($reviews);
            }
        }else{
            $reviews = getAllReviews();
            http_response_code(200);
            echo json_encode($reviews);
        }
    break;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'));
        if(!isset($data->movie_id) || !isset($data->username) || !isset($data->content) || !isset($data->date)) {
            http_response_code(400);
            $error = ['code' => 400, 'message' => "Les champs 'movie_id , username , content , date' sont obligatoires"];
            echo json_encode($error);
        }else{
            $username = filter_var($data->username, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9]{3,}$/")));
            $username = filter_var($data->username, FILTER_SANITIZE_STRING);
            $content = filter_var($data->content, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9]{3,}$/")));
            $content = filter_var($data->content, FILTER_SANITIZE_STRING);
            $date = filter_var($data->date, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{4}-\d{2}-\d{2}$/")));
            $movieExist = getMovieById($data->movie_id);
            if(!$movieExist){
                http_response_code(400);
                $error = ['error' => 400, 'message' => "Le film avec l'identifiant $data->movie_id n'existe pas"];
                echo json_encode($error);
            }
            elseif(!is_int($data->movie_id)){
                http_response_code(400);
                $error = ['error' => 400, 'message' => "L'identifiant du film doit être un entier"];
                echo json_encode($error);
            }
            elseif($username === ""){
                http_response_code(400);
                $error = ['error' => 400, 'message' => "Veuillez entrer un nom d'utilisateur"];
                echo json_encode($error);
            }
            elseif(strlen($username)>25){
                http_response_code(400);
                $error = ['error' => 400, 'message' => "Le nom d'utilisateur ne doit pas dépasser 25 caractères"];
                echo json_encode($error);
            }elseif(!$date){
                http_response_code(400);
                $error = ['error' => 400, 'message' => 'Veuillez entrer une date valide (yyyy-mm-dd)'];
                echo json_encode($error);
            }elseif($content === ""){
                http_response_code(400);
                $error = ['error' => 400, 'message' => 'Veuillez entrer un contenu'];
                echo json_encode($error);
            }elseif(strlen($content)>250){
                http_response_code(400);
                $error = ['error' => 400, 'message' => 'Le texte ne doit pas dépasser 250 caractères'];
                echo json_encode($error);
            }else{
                $review = createReview($data->movie_id, $data->username, $data->content, $data->date);
                http_response_code(201);
                echo json_encode($review);
            }
        }
    break;
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'));
        if(!isset($data->movie_id) || !isset($data->username) || !isset($data->content) || !isset($data->date)) {
            http_response_code(400);
            $error = ['code' => 400, 'message' => "Les champs 'movie_id , username , content , date' sont obligatoires"];
            echo json_encode($error);
        }
        if($id) {
            $review = getReviewById($id);
            if($review) {
                $date = filter_var($data->date, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{4}-\d{2}-\d{2}$/")));
                $username = filter_var($data->username, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9]{3,}$/")));
                $username = filter_var($data->username, FILTER_SANITIZE_STRING);
                $content = filter_var($data->content, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9]{3,}$/")));
                $content = filter_var($data->content, FILTER_SANITIZE_STRING);
                $movieExist = getMovieById($data->movie_id);
                if(!$movieExist){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => "Le film avec l'identifiant $data->movie_id n'existe pas"];
                    echo json_encode($error);
                }
                elseif(!is_int($data->movie_id)){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => "L'identifiant du film doit être un entier"];
                    echo json_encode($error);
                }
                elseif($username === ""){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => "Veuillez entrer un nom d'utilisateur"];
                    echo json_encode($error);
                }
                elseif(strlen($username)>25){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => "Le nom d'utilisateur ne doit pas dépasser 25 caractères"];
                    echo json_encode($error);
                }elseif($content === ""){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'Veuillez entrer un contenu'];
                    echo json_encode($error);
                }elseif(strlen($content)>250){
                    http_response_code(400);
                    $error = ['error' => 400, 'message' => 'Le texte ne doit pas dépasser 250 caractères'];
                    echo json_encode($error);
                }elseif(!$date) {
                    http_response_code(400);
                    $error = ['code' => 400, 'message' => "Le champ 'date' doit être au format YYYY-MM-DD"];
                    echo json_encode($error);
                    return;
                }else{
                    $review = updateReview($id, $data->movie_id, $data->username, $data->content, $data->date);
                    $message = ['code' => 200, 'message' => "L'article avec l'identifiant $id a été modifié"];
                    http_response_code(200);
                    echo json_encode($message + $review);
                }
            }else{
                $error = ['code' => 404, 'message' => "L'article avec l'identifiant $id n'existe pas" ,];
                http_response_code(404);
                echo json_encode($error);
            }
        }else{
            $error = ['code' => 400, 'message' => "L'identifiant de l'article est obligatoire"];
            http_response_code(400);
            echo json_encode($error);
        }
    break;
    case 'DELETE':
        if($id) {
            $review = getReviewById($id);
            if($review) {
                deleteReview($id);
                $message = ['code' => 200, 'message' => "L'article avec l'identifiant $id a été supprimé" ,];
                http_response_code(200);
                echo json_encode($message);
            }else{
                $error = ['code' => 404, 'message' => "L'article avec l'identifiant $id n'existe pas" ,];
                http_response_code(404);
                echo json_encode($error);
            }
        }else{
            $error = ['code' => 400, 'message' => "L'identifiant de l'article est obligatoire"];
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