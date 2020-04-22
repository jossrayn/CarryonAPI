<?php 
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    require("conexion.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
    header('Content-Type: application/json');

    $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
    $params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE

    $idOrden=$params->idOrden;
    $idTransportista=$params->transportista;
    $estado=$params->estado;

    $conexion = conexion(); // CREA LA CONEXION

    //se crea el objeto resultado
    class Result {}
    $response = new Result();

    //verifica que la orden se encuentre en pendiente
  
    $registros = mysqli_query($conexion, "update ordenes set estado = '$estado',id_transportista = '$idTransportista'  where idOrden = '$idOrden';");
    if ($registros != NULL){
        $response->resultado ='ok';
        $response->mensaje ='Orden aceptada';
    }
    else{
        $response->resultado ='Fail';
        $response->mensaje ='Error con el servidor intentelo mas tarde';
        $response->test=mysqli_error($conexion);
    }

   

    $json = json_encode($response); // GENERA EL JSON CON LOS DATOS OBTENIDOS
    echo $json; // MUESTRA EL JSON GENERADO

   
    
?>