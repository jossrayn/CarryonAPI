<?php 
  
    // required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
  
// instantiate database and user object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$user = new Users($db);

// get id of user to be edited
$data = json_decode(file_get_contents("php://input"));
  
// set ID property of user to be edited
$user->correo = $data->correo;
$user->contrasena = $data->contrasena;

/// update the user
if($user->validate()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "User was correct."));
}
  
// if unable to update the user, tell the user
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to find user."));
}
?>