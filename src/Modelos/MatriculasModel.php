<?php  
require_once "Model.php"; 

class MatriculasModel extends Model 
{
	     
    public function __construct() 
    { 
        parent::__construct(); 
    } 

    public function get_matriculas(){
        	 
        $result = $this->conexion->query("SELECT r.id, r.rol FROM rols_users ru, rols r WHERE ru.user_id='$user_id' and ru.rol_id=r.id"); 
         
        $rols = $result->fetch_all(MYSQLI_ASSOC); 
         
        parent::cerrar();
        
        return $rols; 
    }

	public function insertar($user_id, $grupo_id, $paso, $username){

		$sql ="INSERT INTO matriculas (user_id, grupo_id, paso, username, created, modified ) VALUES ('$user_id', '$grupo_id', '$paso', '$username', NOW(), NOW() )";

		$insert = $this->conexion->query($sql); 

		if($insert){
			return true;
		} else {
			return false;
		}
		
		parent::cerrar();
	} 

	public function actualizar_paso_matricula($paso, $matricula_id){

		$sql ="UPDATE matriculas SET paso=$paso WHERE id=$matricula_id ";

		$update = $this->conexion->query($sql); 
		
		if($update){
			return true;
		} else {
			return false;
		}
		
		parent::cerrar();
	} 

} 
?> 
