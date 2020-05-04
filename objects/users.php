<?

class Users{

    /**db conn */
    private $conn;
    private $table_name = "usuario";
    /** properties of the objects */
    public $correo;
    public $tipo;
    public $contrasena;
    public $nombre;
    public $apellidoP;
    public $apellidoS;
    public $telefono;
    public $fechaNacimiento;
    public $imagen;

    /**contructor */
    public funtion _construct($db){
        $this->conn = $db;
    }

    /**read users */
    function read(){
  
        // select all query
        $query = "SELECT correo,tipo,contrasena,nombre,apellidoP,apellidoS,telefono,fechaNacimiento,imagen from usuario"
      
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
                usuario
            SET
                correo=:pCorreo,tipo:=pTipo,contrasena:=pContrasena,nombre:=pNombre,apellidoP:=pApellidoP,apellidoS:=pApellidoS,
                telefono,pTelefono,fechaNacimiento:pFechaNacimiento,imagen:=pImagen";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->correo=htmlspecialchars(strip_tags($this->correo));
    $this->tipo=htmlspecialchars(strip_tags($this->tipo));
    $this->contrasena=htmlspecialchars(strip_tags($this->contrasena));
    $this->nombre=htmlspecialchars(strip_tags($this->nombre));
    $this->apellidoP=htmlspecialchars(strip_tags($this->apellidoP));
    $this->apellidoS=htmlspecialchars(strip_tags($this->apellidoS));
    $this->telefono=htmlspecialchars(strip_tags($this->telefono));
    $this->fechaNacimiento=htmlspecialchars(strip_tags($this->fechaNacimiento));
    $this->imagen=htmlspecialchars(strip_tags($this->imagen));
    
  
    // bind values
    $stmt->bindParam(":pCorreo", $this->correo);
    $stmt->bindParam(":pTipo", $this->tipo);
    $stmt->bindParam(":pContrasena", $this->contrasena);
    $stmt->bindParam(":pNombre", $this->nombre);
    $stmt->bindParam(":pApellidoP", $this->apellidoP);
    $stmt->bindParam(":pApellidoS", $this->apellidoS);
    $stmt->bindParam(":pTelefono", $this->telefono);
    $stmt->bindParam(":pFechaNacimiento", $this->fechaNacimiento);
    $stmt->bindParam(":pImagen", $this->imagen);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
      
}

// update the product
function update(){
  
    // update query
    $query = "UPDATE
                usuario
            SET
                telefono = :telefono,
                nombre = :nombre,
                apellidoP = :apellidoP,
                apellidoS = :apellidoS
            WHERE
                correo = :correo";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->nombre=htmlspecialchars(strip_tags($this->nombre));
    $this->apellidoP=htmlspecialchars(strip_tags($this->apellidoP));
    $this->apellidoS=htmlspecialchars(strip_tags($this->apellidoS));
    $this->telefono=htmlspecialchars(strip_tags($this->telefono));
    $this->correo=htmlspecialchars(strip_tags($this->correo));
  
    // bind new values
    $stmt->bindParam(':nombre', $this->nombre);
    $stmt->bindParam(':apellidoP', $this->apellidoP);
    $stmt->bindParam(':apellidoS', $this->apellidoS);
    $stmt->bindParam(':telefono', $this->telefono);
    $stmt->bindParam(':correo', $this->correo);
  
    // execute the query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}

function read(){
  
    // select all query
    $query = "SELECT 1 from usuario where correo = :correo and contrasena = :contrasena"
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->correo=htmlspecialchars(strip_tags($this->correo));
    $this->cpntrasena=htmlspecialchars(strip_tags($this->contrasena));

    // bind new values
    $stmt->bindParam(':correo', $this->correo);
    $stmt->bindParam(':contrasena', $this->contrasena);

    // execute the query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}

}

?>