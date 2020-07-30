<?php  
require_once "Model.php"; 

class SubCuentasModel extends Model {
	     
    public function __construct(){ 
        parent::__construct(); 
    } 

    public function subcuentas_por_cuenta($cuenta_id){
        $sql = "SELECT * FROM subcuentas WHERE cuenta_id=$cuenta_id AND activo=1";
        $result = $this->conexion->query($sql); 
        $subcuentas = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $subcuentas; 
    }
}
?>