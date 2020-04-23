<?php 
  
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    require("conexion.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
    header('Content-Type: application/json');

    $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
    $params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE


    @$email=$params->email;
    @$password=$params->password;
    @$userType=$params->type;
  

    $conection = conexion(); // CREA LA CONEXION

    class Result {}
    $response = new Result();
    //se validan los data
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $registers = mysqli_query($conection, "SELECT * FROM usuario where correo='$email' and contrasena='$password' and tipo = '$userType'");
        if ($register != NULL){
            // RECORRE EL result Y LO GUARDA EN UN ARRAY
            $cont=0;
            while ($result = mysqli_fetch_array($registers)){
                $data[] = $result;
                $cont= $cont+1;
            }
            if($cont>0){
                $response->result ='Ok';
                $response->mensaje ='Autenticado';
                $response->nombre = json_encode($data[0][2]);
                $response->apellido = json_encode($data[0][3]);
            }
            else{
                $response->result ='Fail';
                $response->mensaje ='Contraseña incorrectos';
            }
    }else{
        $response->result ='Fail';
        $response->mensaje ='Correo no es valido';
    }

    $json = json_encode($response); // GENERA EL JSON CON LOS data OBTENIDOS
    echo $json; // MUESTRA EL JSON GENERADO

?>