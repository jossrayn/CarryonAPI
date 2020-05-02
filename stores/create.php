<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate store object
include_once '../objects/stores.php';
  
$database = new Database();
$db = $database->getConnection();
  
$store = new Stores($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->correo) &&
    !empty($data->nombreEstablecimiento) &&
    !empty($data->descripcion) &&
    !empty($data->imagen) &&
    !empty($data->latitud)&&
    !empty($data->longitud)&&
    !empty($data->estado)&&
    !empty($data->contraseña)
){
  
    // set stores values
    $store->correo = $data->correo;
    $store->nombreEstablecimiento = $data->nombreEstablecimiento;
    $store->descripcion = $data->descripcion;
    $store->imagen = $data->imagen;
    $store->latitud = $data->latitud;
    $store->longitud = $data->longitud;
    $store->estado = $data->estado;
    $store->contraseña = $data->contraseña;
    // create the store
    if($store->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Store was created."));
    }
  
    // if unable to create the store, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create store."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create store. Data is incomplete."));
}
?>