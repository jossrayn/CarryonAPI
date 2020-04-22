<?php 
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
  
    require("conexion.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB

    header('Content-Type: application/json');
    $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
    $params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE


    //
    $filtro=$params->filtroEstablecimiento;

    

    $conexion = conexion(); // CREA LA CONEXION
    // REALIZA LA QUERY A LA D
    // REALIZA LA QUERY A LA DB
    if (!empty($filtro)){
        $registros = mysqli_query($conexion, "CALL getEstablecimientosfiltros('$filtro')");
    }
    else{
        $registros = mysqli_query($conexion, "CALL getEstablecimientos()");
    } 
    if ($registros != NULL){
        while ($resultado = mysqli_fetch_array($registros)){
            $datos[] = $resultado;
        }

        $json = json_encode($datos); // GENERA EL JSON CON LOS DATOS OBTENIDOS
      
        echo $json; // MUESTRA EL JSON GENERADO
    }
    else{

        $datos = "{}";

        $json = json_encode($datos); // GENERA EL JSON CON LOS DATOS OBTENIDOS
      
        echo $json; // MUESTRA EL JSON GENERADO
    }
    
?>