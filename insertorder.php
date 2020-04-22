<?php 
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
  
    require("conexion.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB

    header('Content-Type: application/json');
    $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
    $params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE


    //
    $id_transportista=$params->transportista;
    $id_usuario=$params->usuario;
    $estado=$params->estado;
    $descripcion=$params->descripcion;
    $longitud=$params->longitud;
    $latitud=$params->latitud;
    $fecha=$params->fecha;
    $infoExtra=$params->infoExtra;

    $conexion = conexion(); // CREA LA CONEXION
    
    //se crea el objeto resultado
    class Result {}
    $response = new Result();
        $registros = mysqli_query($conexion, "CALL insertOrden('$id_transportista','$id_usuario','$estado','$descripcion','$longitud','$latitud','$fecha','$observaciones','$infoExtra')");
        if ($registros != NULL){
            $response->resultado ='ok';
            $response->mensaje ='Orden guardada';
            while ($resultado = mysqli_fetch_array($registros)){
                $response->id = $resultado;
            }
    
        }
        else{
            $response->resultado ='Fail';
            $response->mensaje ='Error con el servidor intentelo mas tarde';
            $response->test=mysqli_error($conexion);
        }
    
   
    $json = json_encode($response); // GENERA EL JSON CON LOS DATOS OBTENIDOS
      
    echo $json; // MUESTRA EL JSON GENERADO
    

    //vetrifica que los datos no sean nulos
    function validarDatosNoNulos($parm_id_usuario,$param_estado,$param_descripcion,$param_longitud,$param_latitud,$param_fecha){
        if(!empty($parm_id_usuario) && !empty($param_descripcion) && !empty($param_longitud) && !empty($param_latitud) && !empty($param_fecha)){
            return True;
        }else{
            return False;
        }
    }
    
?>