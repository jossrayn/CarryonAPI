<?php
class Stores{
  
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
    // create product
    function create(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    correo=:pCorreo, nombreEstablecimiento=:pNombre, descripcion=:pDescripcion, imagen=:pUrl, latitud=:pLatitud,longitud=:pLongitud";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->correo=htmlspecialchars(strip_tags($this->correo));
        $this->nombreEstablecimiento=htmlspecialchars(strip_tags($this->nombreEstablecimiento));
        $this->descripcion=htmlspecialchars(strip_tags($this->descripcion));
        $this->imagen=htmlspecialchars(strip_tags($this->imagen));
        $this->latitud=htmlspecialchars(strip_tags($this->latitud));
        $this->longitud=htmlspecialchars(strip_tags($this->longitud));
    
        // bind values
        $stmt->bindParam(":pCorreo", $this->correo);
        $stmt->bindParam(":pNombre", $this->nombreEstablecimiento);
        $stmt->bindParam(":pDescripcion", $this->descripcion);
        $stmt->bindParam(":pUrl", $this->imagen);
        $stmt->bindParam(":pLatitud", $this->latitud);
        $stmt->bindParam(":pLongitud", $this->longitud);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }
}
?>