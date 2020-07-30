<?php  
require_once "Model.php"; 

class CuentasModel extends Model {
	     
    public function __construct(){ 
        parent::__construct(); 
    } 

    public function cuentas_por_grupo($grupo_id){
        $sql = "SELECT DISTINCT C.*
				FROM cuentas C,subcuentas S, grupos_subcuentas GS
				WHERE C.id=S.cuenta_id AND
					S.id=GS.subcuenta_id AND
				    GS.grupo_id=$grupo_id";
        $result = $this->conexion->query($sql); 
        $rols = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $rols; 
    }
    public function cuentas_libres(){
        $sql = "SELECT * FROM cuentas where id NOT IN(
							SELECT DISTINCT C.id
							FROM cuentas C, subcuentas SC, grupos_subcuentas GS 
							WHERE C.id=SC.cuenta_id AND
								 SC.id=GS.subcuenta_id)";
        $result = $this->conexion->query($sql); 
        $cuentas = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $cuentas; 
    }
}
?>