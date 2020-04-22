<?php 
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
  
    require("conexion.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB

    header('Content-Type: application/json');

    $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
    $params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE

    $idOrden=$params->orden;
    $conexion = conexion(); // CREA LA CONEXION
    // REALIZA LA QUERY A LA D
    $registros = mysqli_query($conexion, "CALL selectItemOrden('$idOrden')");
      
    if ($registros != NULL){
        while ($resultado = mysqli_fetch_array($registros)){
            $datos[] = $resultado;
        }

        $json = json_encode($datos); // GENERA EL JSON CON LOS DATOS OBTENIDOS
        echo $json; // MUESTRA EL JSON GENERADO
    }
    else{
        $mensaje=mysqli_error($conexion);
        $datos = "{}";

        $json = json_encode($datos); // GENERA EL JSON CON LOS DATOS OBTENIDOS
      
        echo $json; // MUESTRA EL JSON GENERADO
    }
?>