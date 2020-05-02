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
    public $estado;
    public $contraseña;
    
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read stores
    function read(){
    
        // select all query
        $query = "SELECT * FROM establecimiento where estado=1";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }
    // create store
    function create(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    correo=:pCorreo, nombreEstablecimiento=:pNombre, descripcion=:pDescripcion, imagen=:pUrl,latitud=:pLatitud,longitud=:pLongitud,estado=:pEstado,contraseña=:pPass";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->correo=htmlspecialchars(strip_tags($this->correo));
        $this->nombreEstablecimiento=htmlspecialchars(strip_tags($this->nombreEstablecimiento));
        $this->descripcion=htmlspecialchars(strip_tags($this->descripcion));
        $this->imagen=htmlspecialchars(strip_tags($this->imagen));
        $this->latitud=htmlspecialchars(strip_tags($this->latitud));
        $this->longitud=htmlspecialchars(strip_tags($this->longitud));      
        $this->estado=htmlspecialchars(strip_tags($this->estado));
        $this->contraseña=htmlspecialchars(strip_tags($this->contraseña));
    
        // bind values
        $stmt->bindParam(":pCorreo", $this->correo);
        $stmt->bindParam(":pNombre", $this->nombreEstablecimiento);
        $stmt->bindParam(":pDescripcion", $this->descripcion);
        $stmt->bindParam(":pUrl", $this->imagen);
        $stmt->bindParam(":pLatitud", $this->latitud);
        $stmt->bindParam(":pLongitud", $this->longitud);
        $stmt->bindParam(":pEstado", $this->estado);
        $stmt->bindParam(":pPass", $this->contraseña);
        
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }
    // update the store
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET                    
                    nombreEstablecimiento=:pNombre, 
                    descripcion=:pDescripcion, 
                    imagen=:pUrl, 
                    latitud=:pLatitud,
                    longitud=:pLongitud
                WHERE
                    correo = :pCorreo";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->correo=htmlspecialchars(strip_tags($this->correo));
        $this->nombreEstablecimiento=htmlspecialchars(strip_tags($this->nombreEstablecimiento));
        $this->descripcion=htmlspecialchars(strip_tags($this->descripcion));
        $this->imagen=htmlspecialchars(strip_tags($this->imagen));
        $this->latitud=htmlspecialchars(strip_tags($this->latitud));
        $this->longitud=htmlspecialchars(strip_tags($this->longitud));
    
        // bind new values
        $stmt->bindParam(":pCorreo", $this->correo);
        $stmt->bindParam(":pNombre", $this->nombreEstablecimiento);
        $stmt->bindParam(":pDescripcion", $this->descripcion);
        $stmt->bindParam(":pUrl", $this->imagen);
        $stmt->bindParam(":pLatitud", $this->latitud);
        $stmt->bindParam(":pLongitud", $this->longitud);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }
    function updatePass(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET                    
                    contraseña=:pPass
                WHERE
                    correo = :pCorreo";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->correo=htmlspecialchars(strip_tags($this->correo));
        $this->contraseña=htmlspecialchars(strip_tags($this->contraseña));
    
        // bind new values
        $stmt->bindParam(":pCorreo", $this->correo);
        $stmt->bindParam(":pPass", $this->contraseña);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }
    function updateStatus(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET                    
                    estado=:pStatus
                WHERE
                    correo = :pCorreo";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->correo=htmlspecialchars(strip_tags($this->correo));
    
        // bind new values
        $inactive = 0;
        $stmt->bindParam(":pCorreo", $this->correo);
        $stmt->bindParam(":pStatus",$inactive);
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }
}
?>