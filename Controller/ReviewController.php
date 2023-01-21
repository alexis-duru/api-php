<?php 

require_once '../Repository/ReviewRepository.php';

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
            $date = filter_var($data->date, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{4}-\d{2}-\d{2}$/")));

            if(!$date) {
                http_response_code(400);
                $error = ['code' => 400, 'message' => "Le champ 'date' doit être au format YYYY-MM-DD"];
                echo json_encode($error);
                return;
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
                if(!$date) {
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