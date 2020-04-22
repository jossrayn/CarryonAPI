<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
require("conexion.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
header('Content-Type: application/json');

$json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
$params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE

$correo=$params->to; 
$from=$params->from;
$asunto=$params->asunto;
$mensaje=$params->message;   
$mail = new PHPMailer(true);

class Result {}
$response = new Result();


if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
    if(existeCorreo($correo)){
        try {
            //Server settings
            //$mail->SMTPDebug = 2;//SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'carryoncr@gmail.com';                     // SMTP username
            $mail->Password   = 'rkzcqcyefpwwukqp';                               // SMTP password
            $mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 465;                                    // TCP port to connect to
        
            $mail->CharSet = 'UTF-8';
            //Recipients
            $mail->setFrom("carryoncr@gmail.com",'CarryOn');
            $mail->addAddress("$correo");   
        
            // Content
                                      // Set email format to HTML
            $mail->Subject = "$asunto";
            $mail->AddEmbeddedImage("./img/logo_negro.png", "logoImg", "img/logo_negro.png");
            $mail->Body    = "$mensaje";
            $mail->isHTML(true);       
            $mail->MsgHTML($mensaje); 
        
            $mail->send();
            $response->respuesta = 'ok';
        
            $json = json_encode($response); // GENERA EL JSON CON LOS DATOS OBTENIDOS
              
            echo $json; // MUESTRA EL JSON GENERADO

        } catch (Exception $e) {
            $response->respuesta = "fail";
            $response->mensaje="¡Error con el servidor! Intentelo mas tarde";
            $response->test = "$e";
            $json = json_encode($response); // GENERA EL JSON CON LOS DATOS OBTENIDOS
            echo $json; // MUESTRA EL JSON GENERADO
        }
    }
    else{
        $response->respuesta = "fail";
        $response->mensaje="No existe un usuario registrado con ese correo";
        $json = json_encode($response); // GENERA EL JSON CON LOS DATOS OBTENIDOS
        echo $json; // MUESTRA EL JSON GENERADO
    }
}else{
    $response->respuesta = "fail";
    $response->mensaje="¡El formato del correo no es valido";
    $json = json_encode($response); // GENERA EL JSON CON LOS DATOS OBTENIDOS
    echo $json; // MUESTRA EL JSON GENERADO
}






function existeCorreo($correo){
    $conexion = conexion();
    // Ejecutar la consulta
    $registros = mysqli_query($conexion, "SELECT * FROM usuario where email='$correo'");
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