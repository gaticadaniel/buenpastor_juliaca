<?php  
require_once "Model.php"; 

class RolsModel extends Model 
{
	     
    public function __construct() 
    { 
        parent::__construct(); 
    } 

	//SELECCIONA TODOS LOS ROLES DEL USUARIO
    public function get_rols($user_id){
        $result = $this->conexion->query("SELECT R.id, R.rol, RU.predeterminado 
        								  FROM rols_users RU, rols R 
        								  WHERE 
        								  	RU.user_id='$user_id' and 
        								  	RU.rol_id=R.id and
        								  	R.estado=1"
										); 
        $rols = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $rols; 
    }

} 


?> 

