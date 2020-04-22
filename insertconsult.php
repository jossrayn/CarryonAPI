<?php 
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
  
    require("conexion.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB

    header('Content-Type: application/json');
    $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
    $params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE


    //
    //$transportista='rayn04@gmail.com';//$params->correo;
    $orden=$params->idOrden;
    $consulta=$params->consulta;
    $respuesta=$params->respuesta;
    $titulo=$params->titulo;

    $conexion = conexion(); // CREA LA CONEXION
    

    class Result {}
    $response = new Result();
    $registros = mysqli_query($conexion, "CALL insertConsulta('$orden','$consulta','$respuesta','$titulo')");
    if ($registros != NULL){
        $response->resultado ='ok';
        $response->mensaje ='Favorito guardado';
        $response->id = $registros;
    }
    else{
        $response->resultado ='Fail';
        $response->mensaje ='Error con el servidor intentelo mas tarde';
        $response->test=mysqli_error($conexion);
    }
    
   
    $json = json_encode($response); // GENERA EL JSON CON LOS DATOS OBTENIDOS
      
    echo $json; // MUESTRA EL JSON GENERADO

    
    //vetrifica que los datos no sean nulos
    function validarDatosNoNulos($parm_orden,$param_usuario){
        if(!empty($parm_usuario) && !empty($param_orden)){
            return True;
        }else{
            return False;
        }
    }
?>