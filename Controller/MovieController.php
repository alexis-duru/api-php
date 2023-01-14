<?php 

require_once '../Repository/MovieRepository.php';

header('Content-Type: application/json');

$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'GET':
        $movies = getAllMovies();
        http_response_code(200);
        echo json_encode($movies);
        break;
    case 'POST':
        echo 'POST';
        break;
    case 'PUT':
        echo 'PUT';
        break;
    case 'DELETE':
        echo 'DELETE';
        break;
    default:
        echo 'Method not allowed';
        break;
}

?>