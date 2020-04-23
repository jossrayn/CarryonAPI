<?php 
  
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
	header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
    require("conexion.php"); 


    $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
	$params = json_decode($json);			 // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE

	//obtiene las variables del objteo
    $email=$params->email;

    $connection = conexion(); // CREA LA CONEXION
    $register = mysqli_query($connection, "SELECT * FROM usuario where email='$email'"); //

    class Result {}
	$response = new Result();
    if($register!=NULL) {
    	 // RECORRE EL RESULTADO Y LO GUARDA EN UN ARRAY

		while ($result = mysqli_fetch_array($register)){
		    $data[] = $result;
		}
        if (count($data) > 0) {
          //Se autentico un usuario con esa combinacion
           $response->result = 'true';
        }
        else{
        	 $response->result ='false';
        }
    }else {
      	$response->result ='false';
    }      

    // GENERA LOS DATOS DE RESPUESTA
  header('Content-Type: application/json');
  echo json_encode($response); // MUESTRA EL JSON GENERADO*/
	

?>