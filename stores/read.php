<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/stores.php';
  
// instantiate database and store object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$store = new Stores($db);
  
// read stores will be here
// query stores
$stmt = $store->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // stores array
    $stores_arr=array();
    $stores_arr["stores"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $store_item=array(
            "mail" => $correo,
            "password" => $contraseña,
            "name" => $nombreEstablecimiento,
            "description" => $descripcion,
            "url" => $imagen,
            "latitude" => $latitud,
            "longitude" => $longitud
        );
  
        array_push($stores_arr["stores"], $store_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show stores data in json format
    echo json_encode($stores_arr);
}
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no stores found
    echo json_encode(
        array("message" => "No stores found.")
    );
}