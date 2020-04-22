<?php 
  
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    require("conexion.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
    header('Content-Type: application/json');

    $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
    $params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE


    @$email=$params->email;
    @$contra=$params->contra;
    @$tipoUser=$params->tipo;
  

    $conexion = conexion(); // CREA LA CONEXION

    class Result {}
    $response = new Result();
    //se validan los datos
    if(validarDatosNoNulos($email,$contra)){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $registros = mysqli_query($conexion, "SELECT * FROM usuario where email='$email' and contra='$contra' and tipoUsuario = '$tipoUser'");
            if ($registros != NULL){
               // RECORRE EL RESULTADO Y LO GUARDA EN UN ARRAY
                $cont=0;
                while ($resultado = mysqli_fetch_array($registros)){
                    $datos[] = $resultado;
                    $cont= $cont+1;
                }
                if($cont>0){
                    $response->resultado ='ok';
                    $response->mensaje ='Usuario autenticado';
                    $response->nombre = json_encode($datos[0][2]);
                    $response->apellido = json_encode($datos[0][3]);
                }
                else{
                    $response->resultado ='Fail';
                    $response->mensaje ='Usuario on contraseña incorrectos';
                }
            }
            else{
                $response->resultado ='Fail';
                $response->mensaje ='Usuario on contraseña incorrectos';
                //$response->test=mysqli_error($conexion);
            }
        }else{
            $response->resultado ='Fail';
            $response->mensaje ='El correo no es valido';
        }
    }else{
        $response->resultado ='Fail';
        $response->mensaje ='Complete todos los datos';
    }


    $json = json_encode($response); // GENERA EL JSON CON LOS DATOS OBTENIDOS
    echo $json; // MUESTRA EL JSON GENERADO
    

   
  //vetrifica que los datos no sean nulos
    function validarDatosNoNulos($parm_email,$param_pass){
        if(!empty($parm_email)&& !empty($param_pass)){
            return True;
        }else{
            return False;
        }
    }

?>