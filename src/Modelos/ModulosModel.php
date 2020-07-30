<?php  
require_once "Model.php"; 

class ModulosModel extends Model 
{
	     
    public function __construct() 
    { 
        parent::__construct(); 
    } 

    public function get_modulos($rol_id, $user_id){
        	
        $sql = "SELECT DISTINCT M.id, M.modulo, M.carpeta 
        		FROM modulos M, opcions O, opcions_users OU 
        		WHERE 
        			M.estado=1 AND
        			M.rol_id='$rol_id' AND 
        			M.id=O.modulo_id AND 
        			O.id=OU.opcion_id AND 
        			OU.user_id='$user_id'";
         
        $result = $this->conexion->query($sql); 
         
        $rols = $result->fetch_all(MYSQLI_ASSOC); 
         
        parent::cerrar();
        
        return $rols; 
    }

} 


?> 

