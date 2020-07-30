<?php  
require_once "Model.php"; 

class DescuentosMatriculasModel extends Model 
{
	     
    public function __construct() 
    { 
        parent::__construct(); 
    } 

	public function insertar_descuento_matricula($matricula_id, $descuento_id, $username){

		$sql ="INSERT INTO descuentos_matriculas (matricula_id, descuento_id, username, created, modified ) VALUES ($matricula_id, $descuento_id, '$username', NOW(), NOW() )";

		$insert = $this->conexion->query($sql); 

		if($insert){
			return true;
		} else {
			return false;
		}
		
		parent::cerrar();
	} 

} 
?> 
