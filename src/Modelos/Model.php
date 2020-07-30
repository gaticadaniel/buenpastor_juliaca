<?php  

require_once "../Modelos/Config.php"; 

class Model 
{ 
    protected $conexion; 

    public function __construct() 
    { 
        $this->conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); 

        if ( $this->conexion->connect_errno ) 
        { 
            echo "Fallo al conectar a MySQL: ". $this->conexion->connect_error; 
            return;     
        } 

        $this->conexion->set_charset(DB_CHARSET); 
    } 
	
	public function cerrar()
	{
		$this->conexion->close();
	}
} 
?> 