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
    $costo = $params->costo;

    $conexion = conexion(); // CREA LA CONEXION

    //se crea el objeto resultado
    class Result {}
    $response = new Result();

    //verifica que la orden se encuentre en pendiente
    if(verificarOrden($idOrden,$conexion)){
        $registros = mysqli_query($conexion, "CALL updateOrden('$idOrden','$estado','$idTransportista','$costo')");
        if ($registros != NULL){
            $response->resultado ='ok';
            $response->mensaje ='Orden aceptada';
        }
        else{
            $response->resultado ='Fail';
            $response->mensaje ='Error con el servidor intentelo mas tarde';
            $response->test=mysqli_error($conexion);
        }
    }
    else{
        $response->resultado ='Fail';
        $response->mensaje ='Orden no disponible';
    }

    $json = json_encode($response); // GENERA EL JSON CON LOS DATOS OBTENIDOS
    echo $json; // MUESTRA EL JSON GENERADO

    //verifica que los usuario no sean nulos
    function verificarOrden($Param_idOrden,$conn){
        $estado = "0";
        $registros = mysqli_query($conn, "SELECT * FROM ordenes where idOrden='$Param_idOrden' and estado = '$estado'");
        if($registros!=NULL) {
            // RECORRE EL RESULTADO Y LO GUARDA EN UN ARRAY
            $cont=0;
            while ($resultado = mysqli_fetch_array($registros)){
                $datos[] = $resultado;
                $cont= $cont+1;

            }
            if($cont>0){
                return true;
            }
            else{
                return false;
            }
        }else {
            return false;
        }      
    }
    
?>