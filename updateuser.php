<?php 
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
  
    require("conexion.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB

    header('Content-Type: application/json');
    $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
    $params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE


    //
    //$transportista='rayn04@gmail.com';//$params->correo;
    $email=$params->email;
    $nombre=$params->nombre;
    $apellidos=$params->apellidos;
    $fechaNacimiento=$params->fechaNacimiento;
    $telefono=$params->telefono;

    $conexion = conexion(); // CREA LA CONEXION
    $registros = mysqli_query($conexion, "CALL updateUser('$email','$nombre','$apellidos','$fechaNacimiento','$telefono')");
      
    if ($registros != NULL){
        $response->resultado ='ok';
        $response->mensaje ='Datos de usuario actualizados.';
    }
    else{
        $response->resultado ='Fail';
        $response->mensaje ='Error con el servidor intentelo mas tarde';
        $response->test=mysqli_error($conexion);
    }

    
    $json = json_encode($response); // GENERA EL JSON CON LOS DATOS OBTENIDOS
    echo $json; // MUESTRA EL JSON GENERADO
    




?>