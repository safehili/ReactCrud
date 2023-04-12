<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once './config/Database.php';
include_once './class/ItemManager.php';

// prend les données de POST de React app
$data = json_decode(file_get_contents("php://input"));


if (!empty($data->id) && !empty($data->name) && !empty($data->description)) {
    // Create a new ItemManager instance with your database connection and table name
   
    $database = new Database("shop");
    $dbConnection = $database->getConnection();
    $itemManager = new ItemManager($dbConnection,"items");

    // appeler la fonction avec les données ajoutées
    $result = $itemManager->modifyItemToDb($data->id, $data->name, $data->description);

    // verification
    if ($result) {
        http_response_code(200);
        echo json_encode(['message' => 'Item modifie avec succes']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Modification echoue']);
    }
} 
else {
    http_response_code(400);
    echo json_encode(['message' => 'input invalide']);
}
?>
