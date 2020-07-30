<?php  
require_once "Model.php";

class CierresModel extends Model {
	     
    public function __construct(){ 
        parent::__construct(); 
    } 

	public function ultimo_id(){
		$sql = "SELECT MAX(id) AS id FROM cierres";
        $result = $this->conexion->query($sql); 
        $id = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $id; 
    }

	public function guardar_cierre($cierre){
		$username_cajero = $cierre['username_cajero'];
		$stand_id = $cierre['stand_id'];
		$fecha = $cierre['fecha'];
		$hora = $cierre['hora'];
		$monto = $cierre['monto'];
		$comentario = $cierre['comentario'];
		$username = $cierre['username'];

		$sql ="INSERT INTO cierres (username_cajero, stand_id, fecha, hora, monto, username, created, modified, comentario) 
		VALUES ('$username_cajero', $stand_id, '$fecha', '$hora', $monto, '$username', NOW(), NOW(), '$comentario' ) ";

		$insert = $this->conexion->query($sql); 

		if($insert) return true;
		else return false;
		
		parent::cerrar();
	} 
} 
?> 
