<?php
class Database{

    public $conn;

    // get the database connection
    public function getConnection(){

        $this->conn = null;

        try{
            $conn = mysqli_init();
            mysqli_ssl_set($conn,NULL,NULL, "BaltimoreCyberTrustRoot.crt.pem", NULL, NULL) ; 
            mysqli_real_connect($conn,"localhost","carryoncr", 3306, MYSQLI_CLIENT_SSL,"root","2016131865");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>