<?php 
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    require("conexion.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
    header('Content-Type: application/json');

    $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
    $params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE

    $nombre=$params->nombre;
    $apellidos=$params->apellidos;
    $email=$params->email;
    $contra=$params->contra;
    $contra2=$params->contra2;
    $fechaNacimiento=$params->fechaNacimiento;
    $telefono=$params->telefono;
    $tipoUsuario=$params->tipoUsuario;

    $conexion = conexion(); // CREA LA CONEXION

    //se crea el objeto resultado
    class Result {}
    $response = new Result();

    //$response->test= $nombre. " " . $apellidos . " ". $email. "  ". $contra . " " . $contra2." ".$fechaNacimiento . " " .$telefono . " " . $tipoUsuario;
    //se validan los datos
    if(validarDatosNoNulos($nombre,$apellidos,$email,$contra,$contra2,$fechaNacimiento,$telefono)){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            if(!usuarioenUso($email,$conexion)){
                if(validarContraseña($contra)){
                    if($contra==$contra2){
                        //hago todo el insert
                        $registros = mysqli_query($conexion, "CALL insertUsuario('$email','$contra','$nombre','$apellidos','$fechaNacimiento','$telefono',$tipoUsuario)");
                        if ($registros != NULL){
                            $response->resultado ='ok';
                            $response->mensaje ='Usuario registrado';
                        }
                        else{
                            $response->resultado ='Fail';
                            $response->mensaje ='Error con el servidor intentelo mas tarde';
                            $response->test=mysqli_error($conexion);
                        }
                    }
                    else{
                        $response->resultado ='Fail';
                        $response->mensaje ='Las contraseñas no coinciden';
                    }
                }
                else{
                    $response->resultado ='Fail';
                    $response->mensaje ='La contraseña debe contener: minimo 7 digitos, mayusculas, minusculas y numeros';
                }
            }
            else{
                $response->resultado ='Fail';
                $response->mensaje ='El correo ya se encuentra en uso';
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
    function validarDatosNoNulos($parm_nombre,$param_apellidos,$param_email,$param_contra,$param_contra2,$param_fechaNacimiento,$param_telefono){
        if(!empty($parm_nombre)&& !empty($param_apellidos) && !empty($param_email) && !empty($param_contra) && !empty($param_contra2) && !empty($param_fechaNacimiento) && !empty($param_telefono)){
            return True;
        }else{
            return False;
        }
    }

     //Funcion especifica para la validacion de la contraseña
     function validarContraseña($pass){
        //largo de la contraseña
        if(strlen($pass) > 7){
            //debe tener una letra minuscula
            if (preg_match('`[a-z]`',$pass)){
                //debe tener una masyuscula
                if (preg_match('`[A-Z]`',$pass)){
                    //debe tener un numero
                    if (preg_match('`[0-9]`',$pass)){
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

    //verifica que los usuario no sean nulos
    function usuarioenUso($Param_email,$conn){
        $registros = mysqli_query($conn, "SELECT * FROM usuario where email='$Param_email'");
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