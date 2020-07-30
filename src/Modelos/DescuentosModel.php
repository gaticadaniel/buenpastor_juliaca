<?php  
require_once "Model.php"; 

class DescuentosModel extends Model 
{
	     
    public function __construct() 
    { 
        parent::__construct(); 
    } 

    public function descuentos_por_grupo($grupo_id){
        	
        $sql = "SELECT DISTINCT D.*, C.cuenta
				FROM grupos_subcuentas GS, subcuentas S, cuentas C, descuentos D
				WHERE GS.grupo_id=$grupo_id AND
					GS.subcuenta_id=S.id AND
				    S.cuenta_id=C.id AND
				    C.id=D.cuenta_id
				ORDER BY D.porcentaje";
         
        $result = $this->conexion->query($sql); 
         
        $rols = $result->fetch_all(MYSQLI_ASSOC); 
         
        parent::cerrar();
        
        return $rols; 
    }

} 


?> 