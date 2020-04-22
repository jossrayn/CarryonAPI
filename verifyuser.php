<?php 
  
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
	header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
    require("conexion.php"); 


    $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
	$params = json_decode($json);			 // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE

	//obtiene las variables del objteo
    $email=$params->correo;

    $conexion = conexion(); // CREA LA CONEXION
    $registros = mysqli_query($conexion, "SELECT * FROM usuario where email='$email'"); //

    class Result {}
	$response = new Result();
    if($registros!=NULL) {
    	 // RECORRE EL RESULTADO Y LO GUARDA EN UN ARRAY

		while ($resultado = mysqli_fetch_array($registros)){
		    $datos[] = $resultado;
		}
        if (count($datos) > 0) {
          //Se autentico un usuario con esa combinacion
           $response->resultado = 'true';
        }
        else{
        	 $response->resultado ='false';
        }
    }else {
      	$response->resultado ='false';
    }      

    // GENERA LOS DATOS DE RESPUESTA
  header('Content-Type: application/json');
  echo json_encode($response); // MUESTRA EL JSON GENERADO*/
	

?>