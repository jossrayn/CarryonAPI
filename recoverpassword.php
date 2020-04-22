<?php 
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    require("conexion.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
    header('Content-Type: application/json');

    $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
    $params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE


    //
    //$transportista='rayn04@gmail.com';//$params->correo;
    $email=$params->correo;
    $contrasena=$params->contra;

    $error="";

    $conexion = conexion(); // CREA LA CONEXION


    class Result {}
    $response = new Result();

    if(validarContraseña($contrasena)){
        // REALIZA LA QUERY A LA DB
        $registros = mysqli_query($conexion, "CALL updatePassword('$email','$contrasena')");
        if ($registros != NULL){
            $response->resultado ='ok';
            $response->mensaje ='Contraseña actualizada';
        }
        else{
            $response->resultado ='Fail';
            $response->mensaje ='Error con el servidor intentelo mas tarde';
        }
    }
    else{
        $response->resultado ='Fail';
        $response->mensaje ='La contraseña debe contener: minimo 7 digitos, mayusculas, minusculas y numeros';
        //$response->test =$contrasena;
        //$response->test2 =$error;
    }



    $json = json_encode($response); // GENERA EL JSON CON LOS DATOS OBTENIDOS
    echo $json; // MUESTRA EL JSON GENERADO
    

    //Funcion especifica para la validacion de la contraseña
function validarContraseña($pass){
    //largo de la contraseña
    if(strlen($pass) > 7){
        //$error="1";
        //debe tener una letra minuscula
        if (preg_match('`[a-z]`',$pass)){
            //debe tener una masyuscula
            //$error="2";
            if (preg_match('`[A-Z]`',$pass)){
                //debe tener un numero
                //$error="3";
                if (preg_match('`[0-9]`',$pass)){
                    //$error="4";
                    return true;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }else{
            return false;
        }
    }
    else{
        return false;
    }
    }
?>