<?php 
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    require("conexion.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
    header('Content-Type: application/json');
    
    $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
    $params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE


    //parametros
    $orden=$params->idOrden;
    $usuario = $params->transportista;

    $conexion = conexion(); // CREA LA CONEXION
    
           
    $registros = mysqli_query($conexion, "SELECT * FROM solicitantexpedido where idOrden='$orden' and transportista='$usuario'");
    if (mysqli_fetch_array($registros) != NULL){
        $response->resultado ='Ok';
        $response->mensaje ='Solicitud procesada';    
    }
    else{
        $response->resultado ='Fail';
        $response->mensaje ='Error con el servidor intentelo mas tarde';
        $response->test=mysqli_error($conexion);
    }

    
    $json = json_encode($response); // GENERA EL JSON CON LOS DATOS OBTENIDOS
      
    echo $json; // MUESTRA EL JSON GENERADO
    
?>