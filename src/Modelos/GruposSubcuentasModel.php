<?php  
require_once "Model.php"; 

class GruposSubcuentasModel extends Model 
{
	     
    public function __construct() 
    { 
        parent::__construct(); 
    } 

    public function subcuentas_por_grupo($grupo_id){
        	
        $sql = "SELECT GS.*, C.id AS cuenta_id, C.cuenta
				FROM grupos_subcuentas GS, subcuentas S, cuentas C
				WHERE GS.grupo_id=$grupo_id AND
					GS.subcuenta_id=S.id AND
    				S.cuenta_id=C.id
				ORDER BY GS.fecha_de_cobro";
         
        $result = $this->conexion->query($sql); 
         
        $rols = $result->fetch_all(MYSQLI_ASSOC); 
         
        parent::cerrar();
        
        return $rols; 
    }

} 


?> 