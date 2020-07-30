<?php  
require_once "Model.php"; 

class OpcionsModel extends Model 
{
	     
    public function __construct() 
    { 
        parent::__construct(); 
    } 

    public function get_opcions($modulo_id, $user_id){
        	
        $sql = "SELECT DISTINCT O.id, O.opcion, O.control 
        		FROM opcions O, opcions_users OU 
        		WHERE 
        			O.estado=1 AND
        			O.modulo_id='$modulo_id' AND 
        			O.id=OU.opcion_id AND 
        			OU.user_id='$user_id'";
         
        $result = $this->conexion->query($sql); 
         
        $rols = $result->fetch_all(MYSQLI_ASSOC); 
         
        parent::cerrar();
        
        return $rols; 
    }

} 


?> 