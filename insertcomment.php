<?php 
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
  
    require("conexion.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB

    header('Content-Type: application/json');

    $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
    $params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE


    //
    //$transportista='rayn04@gmail.com';//$params->correo;
    $orden=$params->orden;
    $remitente=$params->remitente;
    $receptor=$params->receptor;
    $descripcion=$params->comentario;
    $rating=$params->rating;


    $conexion = conexion(); // CREA LA CONEXION
    
    class Result {}
    $response = new Result();

    $registros = mysqli_query($conexion, "CALL insertComentario('$orden','$remitente','$receptor','$descripcion','$rating')");
    if ($registros != NULL){
        $response->resultado ='ok';
        $response->mensaje ='Comentario guardado';
        $response->id = $registros;

        $registro = mysqli_query($conexion, "Select * from comentarioXusuario where idOrden = '$orden'");
        if ($registro != NULL){
            $cont=0;
            while ($resultado = mysqli_fetch_array($registro)){
                $datos[] = $resultado;
                $cont= $cont+1;
            }
            $response->contador=$cont;
            if($cont == 2){
                $registro = mysqli_query($conexion, "update ordenes set estado = '3' where idOrden = '$orden'");
                $response->estado="actualizado";
                $response->test=mysqli_error($conexion);
            }
            else{
                $response->estado="no actualizado";
                $response->test=mysqli_error($conexion);
            }
        }
    }
    else{
        $response->resultado ='Fail';
        $response->mensaje ='Error con el servidor intentelo mas tarde';
        $response->test=mysqli_error($conexion);
    }
       
    $json = json_encode($response); // GENERA EL JSON CON LOS DATOS OBTENIDOS
      
    echo $json; // MUESTRA EL JSON GENERADO
    
    
?>