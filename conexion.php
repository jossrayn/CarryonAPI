<?php
// DATOS DE CONEXION A LA BASE DE DATOS
function conexion() {
    $conn = mysqli_init();
    mysqli_ssl_set($conn,NULL,NULL, "BaltimoreCyberTrustRoot.crt.pem", NULL, NULL) ; 
    mysqli_real_connect($conn,"carryoncr.mysql.database.azure.com", "myadmin@carryoncr", "Admin12345", "carryon", 3306, MYSQLI_CLIENT_SSL);
    return $conn;
}
?>