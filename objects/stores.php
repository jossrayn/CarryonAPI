<?php
class stores{
  
    // database connection and table name
    private $conn;
    private $table_name = "establecimiento";
  
    // object properties
    public $correo;
    public $nombreEstablecimiento;
    public $descripcion;
    public $imagen;
    public $latitud;
    public $longitud;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
    
        // select all query
        $query = "SELECT * FROM establecimiento";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }
}
?>