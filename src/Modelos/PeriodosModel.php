<?php  
require_once "Model.php"; 

class PeriodosModel extends Model 
{
	     
    public function __construct() 
    { 
        parent::__construct(); 
    } 

    public function get_periodos(){
        	 
        $result = $this->conexion->query("SELECT * FROM periodos WHERE activo=1 ORDER BY periodo DESC"); 
         
        $periodos = $result->fetch_all(MYSQLI_ASSOC); 
         
        parent::cerrar();
        
        return $periodos; 
    }

    public function periodos_por_id($user_id){
        	 
        $result = $this->conexion->query("SELECT * FROM periodos WHERE activo=1 AND periodos.id NOT IN ( SELECT P.id FROM matriculas M, grupos G, periodos P WHERE M.user_id=$user_id AND M.grupo_id=G.id AND G.periodo_id=P.id)"); 
         
        $periodos = $result->fetch_all(MYSQLI_ASSOC); 
         
        parent::cerrar();
        
        return $periodos; 
    }

} 


?> 
